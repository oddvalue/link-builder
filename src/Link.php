<?php

namespace Oddvalue\LinkBuilder;

use Oddvalue\LinkBuilder\Contracts\Linkable;
use Oddvalue\LinkBuilder\Contracts\LinkGenerator;

class Link implements LinkGenerator
{
    protected $model;

    /**
     * Instantiate the generator with the linkable model
     *
     * @param Linkable $model
     * @param array $options
     */
    public function __construct(Linkable $model, array $options = [])
    {
        $this->model = $model;
    }

    /**
     * Get the link href for a given model
     *
     * @param $model
     * @return string
     */
    public function href() : string
    {
        return (string) url($this->model->slug ?? '/');
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

    /**
     * Generate an HTML link for the model
     *
     * @return string
     */
    public function toHtml()
    {
        return <<<HTML
<a href="{$this->href()}">{$this->label()}</a>
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
