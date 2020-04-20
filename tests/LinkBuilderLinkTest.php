<?php

namespace Oddvalue\LinkBuilder;

use PHPUnit\Framework\TestCase;
use Oddvalue\LinkBuilder\Models\LinkableModel;

class LinkBuilderLinkTest extends TestCase
{
    public function testToHtml()
    {
        $str = '<a href="/bar">foo</a>';
        $model = new LinkableModel;
        $model->name = 'foo';
        $model->slug = 'bar';
        $this->assertEquals($str, $model->getLinkGenerator()->toHtml());
    }

    public function testToString()
    {
        $str = '<a href="/bar">foo</a>';
        $model = new LinkableModel;
        $model->name = 'foo';
        $model->slug = 'bar';
        $this->assertEquals($str, (string) $model->getLinkGenerator());
    }

    public function testLabel()
    {
        $model = new LinkableModel;
        $model->name = 'foo';
        $this->assertEquals('foo', $model->getLinkGenerator()->label());
    }

    public function testHref()
    {
        $model = new LinkableModel;
        $model->slug = 'foo';
        $this->assertEquals('/foo', $model->getLinkGenerator()->href());
    }
}
