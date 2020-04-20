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

Start by creating a generator class for your model. Generator classes must
implement [`\Oddvalue\LinkBuilder\Contracts\LinkGenerator`](src/Contracts/LinkGenerator.php).
This generator class will be responsible for deciding what attributes from the
model form the link.

See [`\Oddvalue\LinkBuilder\Link`](src/Link.php) for an example implementation.

Next, in your model, implement [`\Oddvalue\LinkBuilder\Contracts\Linkable`](src/Contracts/Linkable.php).
There is also a trait for ease of use but it is not essential to use it:
[`\Oddvalue\LinkBuilder\Traits\LinkableTrait`](src/Traits/LinkableTrait.php)

See [`\Oddvalue\LinkBuilder\Models\LinkableModel`](tests/Models/LinkableModel.php)
for an example implementation.

Once you have set all your linkable models up with their respective link
generators you will have a consistent interface for handling URLs and links.

e.g.

``` php
$model = new LinkableModel;

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
