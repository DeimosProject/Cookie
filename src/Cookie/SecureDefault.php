<?php

namespace Deimos\Cookie;

use Deimos\Secure\Secure;

class SecureDefault extends Secure
{

    /**
     * @param string $data
     *
     * @return string
     */
    public function encrypt($data)
    {
        return $data;
    }

    /**
     * @param string $data
     *
     * @return string
     */
    public function decrypt($data)
    {
        return $data;
    }

}