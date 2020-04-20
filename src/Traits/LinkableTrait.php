<?php

namespace Oddvalue\LinkBuilder\Traits;

use Oddvalue\LinkBuilder\Contracts\LinkGenerator;

trait LinkableTrait
{
    /**
     * Get the fully qualified class name of the model's link generator
     *
     * @return string
     */
    abstract protected function getLinkGeneratorClass();

    /**
     * Get the model's link generator
     *
     * @param array $options
     * @return LinkGenerator
     */
    public function getLinkGenerator(array $options = []) : LinkGenerator
    {
        $generatorClass = $this->getLinkGeneratorClass();
        return new $generatorClass($this, $options);
    }
}
