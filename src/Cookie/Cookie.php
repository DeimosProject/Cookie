<?php

namespace Deimos\Cookie;

use Deimos\Cookie\Extensions\Flash;

class Cookie extends Extension
{

    use Flash;

    /**
     * @param $value
     * @param $options
     *
     * @return string
     */
    protected function decrypt($value, $options)
    {
        $secure = $this->secure($options);

        return $secure->decrypt($value);
    }

    /**
     * @param string $name
     * @param null   $default
     * @param array  $options
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function get($name, $default = null, array $options = [])
    {
        $options = $this->options($options);
        $value   = $this->helper()->arr()->get($this->storage(), $name, $default);

        return $value === null || $value === $default ? $default : $this->decrypt($value, $options);
    }

    /**
     * @param string $name
     * @param array  $options
     *
     * @return string
     *
     * @throws \Deimos\Helper\Exceptions\ExceptionEmpty
     * @throws \InvalidArgumentException
     */
    public function getRequired($name, array $options = [])
    {
        $options = $this->options($options);
        $value   = $this->helper()->arr()->getRequired($this->storage(), $name);

        return $this->decrypt($value, $options);
    }

    /**
     * Alias getRequired($name)
     *
     * @param string $name
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * @inheritdoc
     *
     * @return bool
     *
     * @throws \InvalidArgumentException
     */
    public function set($name, $value, array $options = [])
    {
        $options = $this->options($options);
        $value   = parent::set($name, $value, $options);

        return setcookie(
            $this->normalize($name),
            $value,
            $options[self::OPTION_EXPIRE],
            $options[self::OPTION_PATH],
            $options[self::OPTION_DOMAIN],
            false,
            $options[self::OPTION_HTTP_ONLY]
        );
    }

    /**
     * @param string $name
     *
     * @return bool
     *
     * @throws \InvalidArgumentException
     */
    public function remove($name)
    {
        parent::remove($name);

        return $this->set($name, null, [
            self::OPTION_EXPIRE => 0
        ]);
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws \InvalidArgumentException
     */
    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    /**
     * @param string $name
     *
     * @return bool
     *
     * @throws \InvalidArgumentException
     */
    public function __isset($name)
    {
        return $this->helper()->arr()->keyExists($this->storage(), $name);
    }

    /**
     * @return array
     */
    protected function storage()
    {
        return $this->object() ?: [];
    }

}