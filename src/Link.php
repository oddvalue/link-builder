<?php

namespace Oddvalue\LinkBuilder;

use Oddvalue\LinkBuilder\Contracts\Linkable;
use Oddvalue\LinkBuilder\Contracts\LinkGenerator;

abstract class Link implements LinkGenerator
{
    /**
     * The model we're generating a link for
     *
     * @var object
     */
    protected $model;

    /**
     * Options array
     * There's no concrete implementation or use case for this
     * do with it as you wish
     *
     * @var array
     */
    protected $options;

    /**
     * Holds the HTML attribute object
     *
     * @var \Oddvalue\LinkBuilder\HtmlAttributes
     */
    protected $attributes;

    /**
     * The attribute on the model from which the link href is derived
     *
     * @var string
     */
    protected $hrefAttribute = 'slug';

    /**
     * The attribute on the model to use as the link text
     *
     * @var string
     */
    protected $labelAttribute = 'name';

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
        return '/' . $this->model->{$this->hrefAttribute};
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
        return (string) $this->model->{$this->labelAttribute};
    }

    /**
     * Get the HtmlAttributes object
     *
     * @return \Oddvalue\LinkBuilder\HtmlAttributes
     */
    public function getAttributes() : HtmlAttributes
    {
        return $this->attributes;
    }

    /**
     * Set the link attributes
     *
     * @param array $attributes
     * @return self
     */
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
<a href="{$this->href()}"{$this->getAttributes()}>{$this->label()}</a>
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
