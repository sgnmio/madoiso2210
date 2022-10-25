<?php


namespace ValueAuth;


use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use Lcobucci\JWT\Parser;
use Psr\Http\Message\ResponseInterface;
use Tebru\Gson\Gson;
use ValueAuth\ApiEndpoint\ApiEndpoint;
use ValueAuth\ApiInput\ApiInput;
use ValueAuth\ApiResult\ApiError;
use ValueAuth\Enum\AccessTokenRole;
use ValueAuth\Enum\ApiAuthentication;

class ApiClient
{

    const DefaultBaseUrl = "https://api.valueauth.jp";
    const DefaultApiVersion = "v2";
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string|null
     */
    public $apiKey;

    /**
     * @var string|null
     */
    public $accessToken;

    /**
     * @var AccessTokenRole|null
     */
    public $currentRole;

    /**
     * @var bool
     */
    public $debug;

    /**
     * @var string
     */
    public $version;

    /**
     * @var Gson
     */
    protected $gson;

    /**
     * @var
     */
    public $currentCustomerKey;

    /**
     * @var Parser
     */
    protected $jwtParser;

    /**
     * @var string
     */
    public $authCode;

    /**
     * ApiClient constructor.
     * @param string $baseUri
     * @param string|null $apiKey
     * @param string|null $accessToken
     * @param AccessTokenRole|null $role
     * @param bool $debug
     * @param string $version
     */
    function __construct(?string $apiKey, ?string $authCode = null, ?string $accessToken = null, ?bool $debug = false, ?string $version = self::DefaultApiVersion, ?string $baseUri = self::DefaultBaseUrl)
    {
        $options = [
            'base_uri' => $baseUri,
            'redirect.disable' => true
        ];
        $this->client = new Client($options);
        $this->apiKey = $apiKey;
        $this->accessToken = $accessToken;
        $this->debug = $debug;
        $this->version = $version;
        $this->gson = Gson::builder()->build();
        $this->jwtParser = new Parser();
        $this->authCode = $authCode;
        $this->parseAccessToken();

    }

    /**
     * @param ApiInput $input
     * @param array $apiEndpoint
     * @return PromiseInterface
     */
    function process(ApiInput $input): PromiseInterface
    {
        $endpointClass = $input::$endpointType;
        $endpoint = new $endpointClass();
        $path = $this->apiPathFor($endpoint, $input);
        $options = $this->requestOptionsFor($endpoint, $input);
        $headers = $this->headersFor($endpoint);

        $request = new Request($endpoint->method(), $path, $headers);
        return $this->client->sendAsync($request, $options)->then(function (ResponseInterface $response) use ($endpoint) {
            return $this->gson->fromJson($response->getBody()->getContents(), $endpoint->resultType());
        }, function (Exception $exception) {
            if ($exception instanceof RequestException) {
                return $this->gson->fromJson($exception->getResponse()->getBody()->getContents(), ApiError::class);
            } else {
                return ApiError::fromException($exception);
            }
        });
    }

    /**
     * @param ApiEndpoint $endpoint
     * @param ApiInput $apiInput
     * @return string
     */
    protected function apiPathFor(ApiEndpoint $endpoint, ApiInput $apiInput): string
    {
        $path = $endpoint->path();
        if ($apiInput && !empty($endpoint->pathParams())) {
            foreach ($endpoint->pathParams() as $key) {
                if ($key == 'auth_code') {
                    if (empty($this->authCode)) {
                        throw new Exception("Endpoint that needs API Key requires Auth Code to be set");
                    }
                    $path = str_replace('{' . $key . '}', $this->authCode, $path);
                } else if ($apiInput->$key != null) {
                    $path = str_replace('{' . $key . '}', $apiInput->$key, $path);
                }
            }
        }
        return '/' . $this->version . $path;
    }

    /**
     * @param ApiEndpoint $endpoint
     * @param ApiInput $input
     * @return array
     */
    protected function bodyFor(ApiEndpoint $endpoint, ApiInput $input): ?array
    {
        $body = null;
        if (!empty($endpoint->bodyParams())) {
            $body = [];
            foreach ($endpoint->bodyParams() as $key) {
                if ($input->$key != null) {
                    $body[$key] = $input->$key;
                }
            }
        }
        return $body;
    }

    /**
     * @param ApiEndpoint $endpoint
     * @param ApiInput $input
     * @return array
     */
    protected function queryFor(ApiEndpoint $endpoint, ApiInput $input): ?array
    {
        $query = null;
        if (!empty($endpoint->queryParams())) {
            $query = [];
            foreach ($endpoint->queryParams() as $key) {
                if ($input->$key != null) {
                    $query[$key] = $input->$key;
                }
            }
        }

        if ($this->debug) {
            $query['XDEBUG_SESSION_START'] = 'PHPSTORM';
        }
        return $query;
    }

    /**
     * @param ApiEndpoint $apiEndpoint
     * @return string[]
     */
    protected function headersFor(ApiEndpoint $apiEndpoint): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->bearerTokenFor($apiEndpoint),
            'User-Agent' => 'value-auth-php',
        ];
    }

    /**
     * @param ApiEndpoint $apiEndpoint
     * @return string
     */
    protected function bearerTokenFor(ApiEndpoint $apiEndpoint): string
    {
        switch ($apiEndpoint->authentication()) {
            case ApiAuthentication::ApiKey():
                return $this->apiKey;
            case  ApiAuthentication::AccessToken():
                return $this->accessToken;
        }
    }

    /**
     *
     */
    protected function parseAccessToken(): void
    {
        if (!empty($this->accessToken)) {
            $token = $this->jwtParser->parse($this->accessToken);
            $aud = $token->getClaim('aud');
            $role = $token->getClaim('role');
            $this->currentCustomerKey = $aud;
            if ($role) {
                $this->currentRole = new AccessTokenRole($role);
            }
        }
    }

    protected function requestOptionsFor(ApiEndpoint $endpoint, ApiInput $input): array
    {
        $body = $this->bodyFor($endpoint, $input);
        $query = $this->queryFor($endpoint, $input);
        $options = [
            'json' => $body,
            'query' => $query,
        ];

        if ($this->debug) {
            $options['verify'] = false;
        }
        return $options;
    }
}