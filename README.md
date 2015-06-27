yii2-tabs-x
=================

[![Latest Stable Version](https://poser.pugx.org/kartik-v/yii2-tabs-x/v/stable)](https://packagist.org/packages/kartik-v/yii2-tabs-x)
[![License](https://poser.pugx.org/kartik-v/yii2-tabs-x/license)](https://packagist.org/packages/kartik-v/yii2-tabs-x)
[![Total Downloads](https://poser.pugx.org/kartik-v/yii2-tabs-x/downloads)](https://packagist.org/packages/kartik-v/yii2-tabs-x)
[![Monthly Downloads](https://poser.pugx.org/kartik-v/yii2-tabs-x/d/monthly)](https://packagist.org/packages/kartik-v/yii2-tabs-x)
[![Daily Downloads](https://poser.pugx.org/kartik-v/yii2-tabs-x/d/daily)](https://packagist.org/packages/kartik-v/yii2-tabs-x)

An extended tabs widget for Yii Framework 2 based on the [bootstrap-tabs-x jQuery plugin](http://plugins.krajee.com/tabs-x) by Krajee. This plugin includes various CSS3 styling enhancements and various tweaks to the core [Bootstrap 3 Tabs plugin](http://getbootstrap.com/javascript/#tabs). It helps you align tabs in multiple ways, add borders, achieve rotated/sideways titles, load tab content via ajax, and more. 

## Features  

The plugin offers these enhanced features:

- Supports various tab opening directions: `above` (default), `below`, `right`, and `left`.
- Allows you to box the tab content in a new `bordered` style. This can work with any of the tab directions above.
- Allows you to align the entire tab content to the `left` (default), `center`, or `right` of the parent container/page.
- Automatically align & format heights and widths for bordered tabs for `right` and `left` positions.
- Allows a rotated `sideways` tab header orientation for the `right` and `left` tab directions.
- Auto detect overflowing header labels for `sideways` orientation (with ellipsis styling) and display full label as a title on hover.

## Demo
You can see detailed [documentation and examples](http://demos.krajee.com/tabs-x) on usage of the extension.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

> NOTE: Check the [composer.json](https://github.com/kartik-v/yii2-tabs-x/blob/master/composer.json) for this extension's requirements and dependencies. Read this [web tip /wiki](http://webtips.krajee.com/setting-composer-minimum-stability-application/) on setting the `minimum-stability` settings for your application's composer.json.

Either run

```
$ php composer.phar require kartik-v/yii2-tabs-x "dev-master"
```

or add

```
"kartik-v/yii2-tabs-x": "dev-master"
```

to the ```require``` section of your `composer.json` file.

## Usage

### TabsX

```php
use kartik\tabs\TabsX;

echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
    'align' => TabsX::ALIGN_LEFT,
    'items' => [
        [
            'label' => 'One',
            'content' => 'Anim pariatur cliche...',
            'active' => true
        ],
        [
            'label' => 'Two',
            'content' => 'Anim pariatur cliche...',
            'headerOptions' => ['style'=>'font-weight:bold'],
            'options' => ['id' => 'myveryownID'],
        ],
        [
            'label' => 'Dropdown',
            'items' => [
                 [
                     'label' => 'DropdownA',
                     'content' => 'DropdownA, Anim pariatur cliche...',
                 ],
                 [
                     'label' => 'DropdownB',
                     'content' => 'DropdownB, Anim pariatur cliche...',
                 ],
            ],
        ],
    ],
]);
```

## License

**yii2-tabs-x** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.