<?php

namespace Oddvalue\LinkBuilder;

use ArrayAccess;
use Illuminate\Contracts\Support\Htmlable;

class HtmlAttributes implements ArrayAccess, Htmlable
{
    protected $attributes = [];
    protected $classes = [];

    /**
     * Construct with attribute array
     *
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        $this->set($attributes);
    }

    /**
     * Static singleton generator
     *
     * @param array $attributes
     * @return self
     */
    public static function make($attributes = [])
    {
        return new static($attributes);
    }

    /**
     * Get one or all of the attributes as an array
     *
     * @param string $attribute
     * @return array|string
     */
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

    /**
     * Set one or more attributes
     *
     * @param mixed $attributes
     * @param string $value
     * @return self
     */
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

    /**
     * Remove one or more attributes
     *
     * @param string|array $attributes
     * @return self
     */
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

    /**
     * Test if the attribute exists
     *
     * @param string $attribute
     * @return boolean
     */
    public function has(string $attribute) : bool
    {
        if ($attribute === 'class') {
            return $this->hasClass();
        }

        return array_key_exists($attribute, $this->attributes);
    }

    /**
     * Append an html class to the class attribute
     *
     * @param array|string $class
     * @return self
     */
    public function addClass($class)
    {
        $this->classes = array_unique(array_merge($this->classes, $this->splitClass($class)));
        return $this;
    }

    /**
     * Override the class attribute
     *
     * @param array|string $class
     * @return void
     */
    public function setClass($class)
    {
        $this->classes = $this->splitClass($class);
        return $this;
    }

    /**
     * Get the class attribute value
     *
     * @return string
     */
    public function getClass() : string
    {
        return implode(' ', $this->classes);
    }

    /**
     * Test that a certain class exists or that the class attribute exists
     *
     * @param string $class
     * @return boolean
     */
    public function hasClass(string $class = null)
    {
        if (! $class) {
            return count($this->classes) > 0;
        }
        return in_array($class, $this->classes);
    }

    /**
     * Take a string of class names and split them to an array
     *
     * @param array|string $classString
     * @return array
     */
    private function splitClass($classString) : array
    {
        return call_user_func_array('array_merge', array_map(function ($class) {
            return explode(' ', $class);
        }, $this->wrapArray($classString)));
    }

    /**
     * Remove all classes
     *
     * @return self
     */
    public function clearClass()
    {
        $this->classes = [];
        return $this;
    }

    /**
     * Remove a class
     *
     * @param string $class
     * @return self
     */
    public function removeClass(string $class)
    {
        if (($key = array_search($class, $this->classes)) !== false) {
            unset($this->classes[$key]);
        }
        return $this;
    }

    /**
     * Assure that the value is wrapped in an array if not already
     *
     * @param mixed $value
     * @return array
     */
    private function wrapArray($value) : array
    {
        if (is_null($value)) {
            return [];
        }

        return is_array($value) ? $value : [$value];
    }

    /**
     * Test if no attributes are set
     *
     * @return boolean
     */
    public function isEmpty() : bool
    {
        return empty($this->attributes) && empty($this->classes);
    }

    /**
     * ArrayAccess method to check an attribute exists
     *
     * @param mixed $offset
     * @return boolean
     */
    public function offsetExists($offset) : bool
    {
        return $this->has($offset);
    }

    /**
     * ArrayAccess method to fetch an attribute
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * ArrayAccess method to set an attribute
     *
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value) : void
    {
        $this->set($offset, $value);
    }

    /**
     * ArrayAccess method for unsetting an attribute
     *
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset($offset) : void
    {
        $this->remove($offset);
    }

    /**
     * Cast the object to an array
     *
     * @return array
     */
    public function toArray() : array
    {
        return array_merge($this->attributes, $this->hasClass() ? ['class' => $this->getClass()] : []);
    }

    /**
     * Format the object as a string of HTML tag attributes
     *
     * @return string
     */
    public function toHtml() : string
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

    /**
     * Cast the object to a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }
}
