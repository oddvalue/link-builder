<?php

namespace Oddvalue\LinkBuilder;

use ArrayAccess;
use Illuminate\Contracts\Support\Htmlable;

class HtmlAttributes implements ArrayAccess, Htmlable
{
    protected $attributes = [];
    protected $classes = [];

    public function __construct($attributes = [])
    {
        $this->set($attributes);
    }

    public static function make($attributes = [])
    {
        return new static($attributes);
    }

    public function get(string $attribute = null)
    {
        if (is_null($attribute)) {
            return $this->toArray();
        }
        if ($attribute === 'class') {
            return $this->getClass();
        }
        return $this->attributes[$attribute];
    }

    public function set($attributes, string $value = null)
    {
        if (! is_array($attributes) || $attributes instanceof ArrayAccess) {
            $attributes = [$attributes => $value];
        }

        foreach ($attributes as $name => $value) {
            if ($name === 'class') {
                $this->setClass($value);
                continue;
            }

            if (is_int($name)) {
                $name = $value;
                $value = null;
            }

            $this->attributes[$name] = $value;
        }

        return $this;
    }

    public function remove($attributes)
    {
        foreach ($this->wrapArray($attributes) as $name) {
            if ($name === 'class') {
                $this->clearClass();
                continue;
            }
            unset($this->attributes[$name]);
        }
        return $this;
    }

    public function has($attribute) : bool
    {
        if ($attribute === 'class') {
            return $this->hasClass();
        }

        return array_key_exists($attribute, $this->attributes);
    }

    public function addClass($classes)
    {
        $this->classes = array_unique(array_merge($this->classes, $this->splitClass($classes)));
        return $this;
    }

    public function setClass($class)
    {
        $this->classes = $this->splitClass($class);
        return $this;
    }

    public function getClass()
    {
        return implode(' ', $this->classes);
    }

    public function hasClass(string $class = null)
    {
        if (! $class) {
            return count($this->classes) > 0;
        }
        return in_array($class, $this->classes);
    }

    private function splitClass($classString) : array
    {
        return call_user_func_array('array_merge', array_map(function ($class) {
            return explode(' ', $class);
        }, $this->wrapArray($classString)));
    }

    public function clearClass()
    {
        $this->classes = [];
        return $this;
    }

    public function removeClass($class)
    {
        if (($key = array_search($class, $this->classes)) !== false) {
            unset($this->classes[$key]);
        }
        return $this;
    }

    private function wrapArray($value)
    {
        if (is_null($value)) {
            return [];
        }

        return is_array($value) ? $value : [$value];
    }

    public function isEmpty() : bool
    {
        return empty($this->attributes) && empty($this->classes);
    }

    public function offsetExists($offset) : bool
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value) : void
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset) : void
    {
        $this->remove($offset);
    }

    public function toArray()
    {
        return array_merge($this->attributes, $this->hasClass() ? ['class' => $this->getClass()] : []);
    }

    public function toHtml()
    {
        if ($this->isEmpty()) {
            return '';
        }

        return ' ' . implode(' ', array_map(function ($attribute, $value) {
            if (is_null($value) || $value === '') {
                return $attribute;
            }

            return "{$attribute}=\"{$value}\"";
        }, array_keys($this->toArray()), $this->toArray()));
    }

    public function __toString()
    {
        return $this->toHtml();
    }
}
