<?php

namespace ValueAuth;

use PHPUnit\Framework\TestCase;
use ValueAuth\ApiInput\Get2FACodeInput;
use ValueAuth\ApiInput\GetAccessTokenInput;
use ValueAuth\ApiInput\GetSiteSettingInput;
use ValueAuth\ApiInput\PostLoginCheckInput;
use ValueAuth\ApiInput\PostLoginLogInput;
use ValueAuth\ApiResult\AccessTokenResult;
use ValueAuth\ApiResult\DueDateResult;
use ValueAuth\ApiResult\LoginCheckResult;
use ValueAuth\ApiResult\LoginLogResult;
use ValueAuth\ApiResult\SiteSettingResult;
use ValueAuth\ApiResult\TwoFactorAuthSendResult;
use ValueAuth\Enum\AccessTokenRole;

class ApiClientTest extends TestCase
{
    const CustomerKey = 'test';
    const Ip = '0.0.0.0';
    const UserAgent = 'value-auth-php-test';
    const ApiKey = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjQ0NzNiYWYzZDU2ZWI5ZjBjNjA0MDcyYmY0MjZkMzUyODBiYWY4YTUzMjM2ZGRlOWJlOTIzNzlmMmUzZGZkNzBjZjliYzdhZTJhOTM3ZTliIn0.eyJhdWQiOiIxIiwianRpIjoiNDQ3M2JhZjNkNTZlYjlmMGM2MDQwNzJiZjQyNmQzNTI4MGJhZjhhNTMyMzZkZGU5YmU5MjM3OWYyZTNkZmQ3MGNmOWJjN2FlMmE5MzdlOWIiLCJpYXQiOjE2MDAwNjE4NjIsIm5iZiI6MTYwMDA2MTg2MiwiZXhwIjozMzEyNTM0ODI2Miwic3ViIjoiOCIsInNjb3BlcyI6W119.vmSQo3tHGxspB11TxXyqH-p527KiocihBXVsaJ4gZt1CRQbfptp3eWEr4eYrWTP0sXmnQSQ1VWUF4wy9Rsbza3cD4vaqffczfQ5UkXguIppgWbYHq6DQoRkKXfMnov8RbydGH5XoZ-eFEdLN-oplN4JCPPGdqZPNBmfdy3VFYb5fZu7NgO9hR1P0zW-lCAh5RIRqAHn3DEEBF83ebI_bmNOJXwsKMYqD8y6OoVToYUCUsnrmAkzaJ10-pcj139cvGzcwcosva93ngVWXSFwRtOAdjoQoa5dzrlnmWdWAWlFJ95JHa7ERPzg1MDh8PLBrC7muqtIbwF1oVgQ4Ea7KGss13ZLIQZyVMIg1_DxHNBrYDHRamrTJpnANPngxCtYbzy9uxClJQCa5-ySSQWhkC6UZNBuCbmryfjRknItgrEH3d19uWopEhR8XTufgudHJqx-mdO3VIZmtzrP9LhLg8AaizklSZJoPOlQMUXzWatF0Pcjwe8HMzyhyV7hMSq4GP4lqA9uuDReSQDiP1IE_ee0RFZ_VlRPtAvQSvpKVF7aQVhE7E2YMqpGhEhxiivBax9ORgcCJmAb6oZ5VHbahsKRbItDWIX0XiFirJZqMmPdVcmwcUOscPLbgZybZO6l91Urrgtasm_kv20Ep28LvQ-rydALzc67U9eomsnx-pzY";
    const BaseUrl = 'https://api-test.homestead.test';
    const SiteCode = "f684f2c89fdea6ad4fa4b23d59bcaafe";

    function buildApiKeyClient()
    {
        $client = new ApiClient(self::ApiKey, self::SiteCode, null, true, "v2", self::BaseUrl);
        return $client;
    }

    function buildAccessTokenClient(string $accessToken)
    {
        $client = new ApiClient(null, null, $accessToken, true, null, self::BaseUrl);
        return $client;
    }

    function testConstructor()
    {
        $client = $this->buildApiKeyClient();
        self::assertInstanceOf(ApiClient::class, $client);
    }

    function testFetchAccessToken()
    {
        $result = $this->fetchAccessToken(AccessTokenRole::Api());
        self::assertNotNull($result);
        self::assertInstanceOf(AccessTokenResult::class, $result);
        self::assertNotNull($result->results->access_token);
    }

    function fetchAccessToken(AccessTokenRole $role): AccessTokenResult
    {
        $client = $this->buildApiKeyClient();
        $input = new GetAccessTokenInput();
        $input->role = $role->getValue();
        $input->customer_key = 'test';
        $promise = $client->process($input);
        $result = $promise->wait();
        return $result;
    }


    function _checkLogin(): LoginCheckResult
    {
        $client = $this->buildApiKeyClient();
        $input = new PostLoginCheckInput();
        $input->ip = self::Ip;
        $input->user_agent = self::UserAgent;
        $input->auth_code = self::SiteCode;
        $input->customer_key = self::CustomerKey;
        /**
         * @var $result LoginCheckResult
         */
        $result = $client->process($input)->wait();
        return $result;
    }

    function testCheckLogin()
    {
        $result = $this->_checkLogin();
        self::assertNotNull($result);
        self::assertInstanceOf(LoginCheckResult::class, $result);
        self::assertNotNull($result->results->login_key);
//        self::assertNotNull($result->results->point);
    }

    function _buildSuccessfulLogin(): array
    {
        $result = $this->_checkLogin();
        $login_key = $result->results->login_key;
        $client = $this->buildApiKeyClient();
        $input = new PostLoginLogInput();
        $input->customer_key = self::CustomerKey;
        $input->login_key = $login_key;
        $input->is_logged_in = true;
        /**
         * @var $result LoginLogResult
         */
        $result = $client->process($input)->wait();
        return [$result, $login_key];
    }


    function _buildFailedLogin(): LoginLogResult
    {
        $result = $this->_checkLogin();
        $client = $this->buildApiKeyClient();
        $input = new PostLoginLogInput();
        $input->customer_key = self::CustomerKey;
        $input->login_key = $result->results->login_key;
        $input->is_logged_in = false;
        /**
         * @var $result LoginLogResult
         */
        $result = $client->process($input)->wait();

        return $result;
    }

    function testCreateSucceededLoginLog()
    {
        [$result, $login_key] = $this->_buildSuccessfulLogin();
        self::assertNotNull($result);
        self::assertInstanceOf(LoginLogResult::class, $result);
        self::assertNotNull($result->results->customer);
        self::assertNotNull($result->results->customer_login_log);
    }

    function testCreateFailedLoginLog()
    {
        $result = $this->_buildFailedLogin();
        self::assertNotNull($result);
        self::assertInstanceOf(LoginLogResult::class, $result);
        self::assertNotNull($result->results->customer);
        self::assertNotNull($result->results->customer_login_log);
    }

    function fetch2FAAccessToken(string $login_key): AccessTokenResult
    {
        $client = $this->buildApiKeyClient();
        $input = new GetAccessTokenInput();
        $input->login_key = $login_key;
        $input->role = AccessTokenRole::Auth;
        $input->customer_key = self::CustomerKey;
        $promise = $client->process($input);
        /**
         * @var $result AccessTokenResult
         */
        $result = $promise->wait();
        return $result;
    }

    function testGetAccessToken()
    {
        [$result, $login_key] = $this->_buildSuccessfulLogin();
        $accessToken = $this->fetch2FAAccessToken($login_key)->results->access_token;
        $client = $this->buildAccessTokenClient($accessToken);
        $input = new Get2FACodeInput();
        /**
         * @var $result DueDateResult
         **/
        $result = $client->process($input)->wait();
        self::assertNotNull($result);
        self::assertInstanceOf(TwoFactorAuthSendResult::class, $result);
        self::assertNotNull($result->results->due_date);
    }

    function testGetSiteSetting()
    {
        $client = $this->buildApiKeyClient();
        $result = $client->process(new GetSiteSettingInput())->wait();
        self::assertNotNull($result);
        self::assertInstanceOf(SiteSettingResult::class, $result);
    }


}
