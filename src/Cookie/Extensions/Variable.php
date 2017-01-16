<?php

namespace Deimos\Cookie\Extensions;

trait Variable
{

    /**
     * @var array
     */
    private $object;

    /**
     * @var bool
     */
    private $init;

    /**
     * @return bool
     */
    private function init()
    {
        if (!$this->init)
        {
            global $_COOKIE;

            $this->init   = true;
            $this->object = $_COOKIE;
        }

        return !$this->init;
    }

    /**
     * @param string $variable
     *
     * @return mixed
     */
    protected function normalize($variable)
    {
        return preg_replace('~\.(\w+)~', '[$1]', $variable);
    }

    /**
     * @return array
     */
    protected function &object()
    {
        return $this->object;
    }

}