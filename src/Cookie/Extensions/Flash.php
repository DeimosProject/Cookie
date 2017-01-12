<?php

namespace Deimos\Cookie\Extensions;

trait Flash
{

    protected $flashProperty = 'DeimosFlash';

    /**
     * @param string $name
     * @param mixed  $value
     * @param array  $options
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function flash($name, $value = null, array $options = [])
    {
        $name .= $this->flashProperty;

        if ($value === null)
        {
            $value = $this->get($name, null, $options);
            $this->remove($name);
        }
        else
        {
            $this->set($name, $value, $options);
        }

        return $value;
    }

}