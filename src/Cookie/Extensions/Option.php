<?php

namespace Deimos\Cookie\Extensions;

use Deimos\Cookie\Extension;

trait Option
{

    /**
     * @var array
     */
    private $options = [
        Extension::OPTION_EXPIRE    => 0,
        Extension::OPTION_PATH      => '/',
        Extension::OPTION_DOMAIN    => null,
        Extension::OPTION_SECURE    => [],
        Extension::OPTION_HTTP_ONLY => false,
    ];

    /**
     * @param array $first
     * @param array $second
     *
     * @return array
     */
    protected function merge(array $first, array $second)
    {
        if (isset($second[Extension::OPTION_LIFETIME]))
        {
            $second[Extension::OPTION_EXPIRE] = $second[Extension::OPTION_LIFETIME] + time();
            unset($second[Extension::OPTION_LIFETIME]);
        }

        return array_merge($first, $second);
    }

}