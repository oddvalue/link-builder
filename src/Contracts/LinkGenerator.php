<?php

namespace Oddvalue\LinkBuilder\Contracts;

use Illuminate\Contracts\Support\Htmlable;

interface LinkGenerator extends Htmlable
{
    /**
     * Instantiate the generator with the linkable model
     *
     * @param Linkable $model
     * @param array $options
     */
    public function __construct(Linkable $model, array $options = []);

    /**
     * Get the link href for a given model
     *
     * @return string
     */
    public function href() : string;

    /**
     * Get the link text for a given model
     *
     * @return string
     */
    public function label() : string;

    /**
     * Generate an HTML link for the model
     *
     * @return string
     */
    public function toHtml();

    /**
     * Cast the generator to a string
     *
     * @return string
     */
    public function __toString() : string;
}
