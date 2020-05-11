<?php

namespace Oddvalue\LinkBuilder;

use Oddvalue\LinkBuilder\Link;
use PHPUnit\Framework\TestCase;
use Oddvalue\LinkBuilder\HtmlAttributes;
use Oddvalue\LinkBuilder\Models\LinkableModel;

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
        $this->assertEquals(' disabled', (string) $attributes);
        $attributes->remove(null);
        $this->assertEquals(' disabled', (string) $attributes);
        $attributes->remove('disabled');
        $this->assertEquals('', (string) $attributes);

        $attributes->setClass('foo');
        $this->assertEquals(' class="foo"', (string) $attributes);
        $attributes->remove('class');
        $this->assertEquals('', (string) $attributes);

        $attributes->set('disabled');
        $this->assertEquals(' disabled', (string) $attributes);
        unset($attributes['disabled']);
        $this->assertEquals('', (string) $attributes);
    }

    public function testValuelessAttribute()
    {
        $attributes = new HtmlAttributes;
        $attributes->set('foo');
        $this->assertEquals($attributes->toHtml(), ' foo');
    }

    public function testHasClass()
    {
        $attributes = HtmlAttributes::make(['class' => 'foo bar baz boz']);

        $this->assertTrue($attributes->hasClass('foo'));
        $this->assertTrue($attributes->has('class'));
        $this->assertFalse($attributes->hasClass('bad-class'));
    }

    public function testHas()
    {
        $attributes = HtmlAttributes::make(['foo' => 'bar']);

        $this->assertTrue($attributes->has('foo'));
        $this->assertFalse($attributes->has('bar'));

        $this->assertTrue(isset($attributes['foo']));
        $this->assertFalse(empty($attributes['foo']));

        $this->assertFalse(isset($attributes['bar']));
        $this->assertTrue(empty($attributes['bar']));
    }

    public function testGet()
    {
        $attributes = HtmlAttributes::make([
            'id' => 'foobar',
            'class' => [
                'foo bar',
                'baz',
            ],
            'role' => 'button'
        ]);

        $expected = [
            'id' => 'foobar',
            'class' => 'foo bar baz',
            'role' => 'button'
        ];
        $actual = $attributes->get();
        $this->assertEquals($expected, $actual);

        $expected = 'foobar';
        $actual = $attributes->get('id');
        $this->assertEquals($expected, $actual);

        $expected = 'foo bar baz';
        $actual = $attributes->get('class');
        $this->assertEquals($expected, $actual);
    }

    public function testLinkAttributes()
    {
        $model = new LinkableModel;
        $link = new Link($model, [
            'attributes' => [
                'foo' => 'bar',
            ],
        ]);

        $expected = ' foo="bar"';
        $actual = (string) $link->getAttributes();
        $this->assertEquals($expected, $actual);
    }

    public function testLinkClass()
    {
        $model = new LinkableModel;
        $link = new Link($model, [
            'class' => 'foo',
        ]);

        $expected = ' class="foo"';
        $actual = (string) $link->getAttributes();
        $this->assertEquals($expected, $actual);
    }
}
