<?php

namespace Oddvalue\LinkBuilder;

use PHPUnit\Framework\TestCase;
use Oddvalue\LinkBuilder\HtmlAttributes;

class LinkBuilderHtmlAttributeTest extends TestCase
{
    public function testMakeAttributes()
    {
        $this->assertEquals((string) HtmlAttributes::make([
            'id' => 'foobar',
            'class' => [
                'foo bar',
                'baz'
            ],
            'role' => 'button'
        ]), ' id="foobar" role="button" class="foo bar baz"');
    }

    public function testAddClass()
    {
        $attributes = new HtmlAttributes;
        $attributes->addClass('foo');
        $attributes->addClass('foo');
        $attributes->addClass('foo bar');
        $attributes->addClass(['baz', 'boz']);
        $this->assertEquals((string) $attributes, ' class="foo bar baz boz"');
    }

    public function testRemoveClass()
    {
        $attributes = new HtmlAttributes;
        $attributes->addClass('foo');
        $attributes->removeClass('foo');
        $this->assertEquals((string) $attributes, '');
    }

    public function testArrayAccess()
    {
        $attributes = new HtmlAttributes;
        $attributes['foo'] = 'bar';
        $this->assertEquals($attributes['foo'], 'bar');
    }

    public function testRemove()
    {
        $attributes = new HtmlAttributes;
        $attributes->set('disabled');
        $attributes->remove('disabled');
        $this->assertEquals((string) $attributes, '');
    }

    public function testValuelessAttribute()
    {
        $attributes = new HtmlAttributes;
        $attributes->set('foo');
        $this->assertEquals($attributes->toHtml(), ' foo');
    }

    public function testHasClass()
    {
        $this->assertTrue(HtmlAttributes::make(['class' => 'foo bar baz boz'])->hasClass('foo'));
    }

    public function testHas()
    {
        $this->assertTrue(HtmlAttributes::make(['foo' => 'bar'])->has('foo'));
    }
}
