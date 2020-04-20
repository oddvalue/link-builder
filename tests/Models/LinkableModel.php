<?php

namespace Oddvalue\LinkBuilder\Models;

use Oddvalue\LinkBuilder\Contracts\Linkable;
use Oddvalue\LinkBuilder\Traits\LinkableTrait;

class LinkableModel implements Linkable
{
    use LinkableTrait;

    public $name;
    public $slug;

    /**
     * Get the fully qualified class name of the model's link generator
     *
     * @return string
     */
    protected function getLinkGeneratorClass()
    {
        return \Oddvalue\LinkBuilder\Link::class;
    }
}
