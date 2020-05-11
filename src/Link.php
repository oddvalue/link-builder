<?php

namespace Oddvalue\LinkBuilder;

use Oddvalue\LinkBuilder\Contracts\Linkable;
use Oddvalue\LinkBuilder\Contracts\LinkGenerator;

class Link implements LinkGenerator
{
    protected $model;

    protected $options;

    protected $attributes;

    /**
     * Instantiate the generator with the linkable model
     *
     * @param Linkable $model
     * @param array $options
     */
    public function __construct(Linkable $model, array $options = [])
    {
        $this->model = $model;

        if (key_exists('class', $options)) {
            $options['attributes'] = @$options['attributes'] ?: [];
            $options['attributes']['class'] = $options['class'];
            unset($options['class']);
        }

        $attributes = [];
        if (key_exists('attributes', $options)) {
            $attributes = $options['attributes'];
            unset($options['attributes']);
        }
        $this->setAttributes($attributes);

        $this->options = $options;
    }

    /**
     * Get the link href for a given model
     *
     * @param $model
     * @return string
     */
    public function href() : string
    {
        return '/' . $this->model->slug;
    }

    /**
     * Get the link text for a given model
     *
     * @param $model
     * @param array $options
     * @return string
     */
    public function label() : string
    {
        return (string) $this->model->name;
    }

    public function getAttributes() : HtmlAttributes
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = HtmlAttributes::make($attributes);
        return $this;
    }

    /**
     * Generate an HTML link for the model
     *
     * @return string
     */
    public function toHtml()
    {
        return <<<HTML
<a href="{$this->href()}"{$this->attributes}>{$this->label()}</a>
HTML;
    }

    /**
     * Cast the generator to a string
     *
     * @return string
     */
    public function __toString() : string
    {
        return $this->toHtml();
    }
}
