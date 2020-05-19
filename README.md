# Link Builder

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A consistent interface for generating URLs and links for php models.

## Installation

Via Composer

``` bash
$ composer require oddvalue/link-builder
```

## Usage

### Creating a Generator

First off you will need a generator class for your model. This generator class
will be responsible for deciding what the href and label of the link for your
model should be.

This is the minimum generator setup:

```php
<?php

namespace App;

use Oddvalue\LinkBuilder\Link;

class ArticleLink extends Link
{
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
    protected $labelAttribute = 'title';
}
```

You don't have to extend [`\Oddvalue\LinkBuilder\Link`](src/Link.php), the only requirement is that the generator implements [`\Oddvalue\LinkBuilder\Contracts\LinkGenerator`](src/Contracts/LinkGenerator.php).

### Preparing Your Model

Next, in your model, implement [`\Oddvalue\LinkBuilder\Contracts\Linkable`](src/Contracts/Linkable.php).
There is also a trait for ease of use but it is not essential to use it:
[`\Oddvalue\LinkBuilder\Traits\LinkableTrait`](src/Traits/LinkableTrait.php)

For example:

```php
<?php

namespace App;

use App\ArticleLink;
use Oddvalue\LinkBuilder\Contracts\Linkable;
use Oddvalue\LinkBuilder\Traits\LinkableTrait;

class LinkableModel implements Linkable
{
    use LinkableTrait;

    public $title;
    public $slug;

    /**
     * Get the fully qualified class name of the model's link generator
     *
     * @return string
     */
    protected function getLinkGeneratorClass()
    {
        return ArticleLink::class;
    }
}
```

### Generating Links

Once you have set all your linkable models up with their respective link
generators you will have a consistent interface for handling their URLs and links in your app.

e.g.

``` php
$model = new Article;

echo $model->getLinkGenerator()->toHtml();
# output: <a href="/bar">foo</a>

echo (string) $model->getLinkGenerator();
# output: <a href="/bar">foo</a>

echo $model->getLinkGenerator()->label();
# output: foo

echo $model->getLinkGenerator()->href();
# output: /bar
```

There is also a helper method for fetching the link generator of a model:

``` php
echo get_link($model)->toHtml();
# output: <a href="/bar">foo</a>

echo (string) get_link($model);
# output: <a href="/bar">foo</a>

echo get_link($model)->label();
# output: foo

echo get_link($model)->href();
# output: /bar
```

### Link Attributes

In order to set classes and other attributes on the generated links you may either pass them in via the options array on the `getLinkGenerator(array)` method or you can call the `setAttributes(array)` method on the generator itself.

```php
$options = [
    'attributes' => [
        'class' => ['button', 'is-disabled'],
        'role' => 'button',
        'disabled',
    ]
];

echo (string) $model->getLinkGenerator($options);
echo (string) get_link($model, $options);

# output:
# <a href="/bar" class="button is-disabled" role="button" disabled>foo</a>
# <a href="/bar" class="button is-disabled" role="button" disabled>foo</a>
```

[ico-version]: https://img.shields.io/packagist/v/oddvalue/link-builder.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/oddvalue/link-builder/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/oddvalue/link-builder.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/oddvalue/link-builder.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/oddvalue/link-builder.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/oddvalue/link-builder
[link-travis]: https://travis-ci.org/oddvalue/link-builder
[link-scrutinizer]: https://scrutinizer-ci.com/g/oddvalue/link-builder/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/oddvalue/link-builder
[link-downloads]: https://packagist.org/packages/oddvalue/link-builder
[link-author]: https://github.com/oddvalue
[link-contributors]: ../../contributors
