<?php

namespace Oddvalue\LinkBuilder\Contracts;

interface Linkable
{
    /**
     * Get the model's link generator
     *
     * @param array $options
     * @return LinkGenerator
     */
    public function getLinkGenerator(array $options = []) : LinkGenerator;
}
