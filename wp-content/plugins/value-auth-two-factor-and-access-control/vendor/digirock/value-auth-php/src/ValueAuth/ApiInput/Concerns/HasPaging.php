<?php

namespace ValueAuth\ApiInput\Concerns;

trait HasPaging
{
    /**
     * @var int
     */
    public $page;

    /**
     * @var int
     */
    public $limit;

}