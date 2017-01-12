<?php

namespace DeimosTest;

use Deimos\Builder\Builder;
use Deimos\Cookie\Cookie;

class TestSetUp extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Cookie
     */
    protected $cookie;

    public function setUp()
    {
        $builder      = new Builder();
        $this->cookie = new Cookie($builder);
    }

}