<?php

namespace Oddvalue\LinkBuilder;

use PHPUnit\Framework\TestCase;
use Oddvalue\LinkBuilder\Models\LinkableModel;

class LinkBuilderHelperTest extends TestCase
{
    public function testToHtml()
    {
        $str = '<a href="/bar">foo</a>';
        $model = new LinkableModel;
        $model->name = 'foo';
        $model->slug = 'bar';
        $this->assertEquals($str, (string) get_link($model));
    }

    public function testUrlHelper()
    {
        $expected = '/foo';
        $actual = url('foo');
        $this->assertEquals($expected, $actual);
    }
}
