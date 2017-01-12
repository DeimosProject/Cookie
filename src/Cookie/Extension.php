<?php

namespace Deimos\Cookie;

use Deimos\Builder\Builder;
use Deimos\Cookie\Extensions\Option;
use Deimos\Cookie\Extensions\Variable;
use Deimos\Helper\Traits\Helper;
use Deimos\Secure\Secure;

abstract class Extension
{

    const OPTION_LIFETIME  = 'lifetime';
    const OPTION_EXPIRE    = 'expire';
    const OPTION_PATH      = 'path';
    const OPTION_DOMAIN    = 'domain';
    const OPTION_SECURE    = 'secure';
    const OPTION_HTTP_ONLY = 'httpOnly';

    const SECURE_ALGORITHM = 'algorithm';
    const SECURE_SECRET    = 'secret';
    const SECURE_IV        = 'iv';

    use Option;
    use Helper;
    use Variable;

    /**
     * @var Secure[]
     */
    private $secure = [];

    /**
     * @var SecureDefault
     */
    private $secureDefault;

    /**
     * Session constructor.
     *
     * @param Builder $builder
     * @param array   $options
     */
    public function __construct(Builder $builder, array $options = [])
    {
        $this->builder = $builder;
        $this->options = $this->merge($this->options, $options);

        $this->init();
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function options(array $options = null)
    {
        $dataOptions = $this->options;

        if ($options)
        {
            $dataOptions = $this->merge($dataOptions, $options);
        }

        return $dataOptions;
    }

    /**
     * @param $options
     *
     * @return Secure
     */
    protected function secure(array $options)
    {
        $option = $options[self::OPTION_SECURE];

        if (is_array($option))
        {
            $key = $this->helper()->json()->encode($option);

            if (!isset($this->secure[$key]))
            {
                $secure = new Secure();

                if (isset($option[self::SECURE_ALGORITHM]))
                {
                    $secure->algorithm($option[self::SECURE_ALGORITHM]);
                }

                if (isset($option[self::SECURE_SECRET]))
                {
                    $secure->secret($option[self::SECURE_SECRET]);
                }

                if (isset($option[self::SECURE_IV]))
                {
                    $secure->iv($option[self::SECURE_IV]);
                }

                $this->secure[$key] = $secure;
            }

            return $this->secure[$key];
        }

        if (!$this->secureDefault)
        {
            $this->secureDefault = new SecureDefault();
        }

        return $this->secureDefault;
    }

    /**
     * @param string $name
     * @param string $value
     * @param array  $options
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function set($name, $value, array $options = [])
    {
        /**
         * @param Secure $secure
         */
        if ($value !== null)
        {
            $secure = $this->secure($options);
            $value  = $secure->encrypt($value);

            $this->helper()->arr()->set($this->object, $name, $value);
        }

        return $value;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function remove($name)
    {
        if (isset($this->{$name}))
        {
            unset($this->object[$name]);

            return true;
        }

        return false;
    }

    /**
     * remove all keys
     */
    public final function removeAll()
    {
        foreach ($this->object() as $name => &$value)
        {
            $this->remove($name);
        }
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    abstract public function __get($name);

    /**
     * @param string $name
     *
     * @return bool
     */
    abstract public function __isset($name);

    /**
     * @param string $name
     * @param mixed  $value
     */
    abstract public function __set($name, $value);

}