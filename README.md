yii2-tabs-x
=================

An extended tabs widget for Yii Framework 2 based on the [bootstrap-tabs-x jQuery plugin](http://plugins.krajee.com/tabs-x) by Krajee. This plugin includes various CSS3 styling enhancements
and various tweaks to the core [Bootstrap 3 Tabs plugin](http://getbootstrap.com/javascript/#tabs). It helps you align tabs in multiple ways, add borders, achieve rotated/sideways titles, and more. 

## Features  

The plugin offers these enhanced features:

- Supports various tab opening directions: `above` (default), `below`, `right`, and `left`.
- Allows you to box the tab content in a new `bordered` style. This can work with any of the tab directions above.
- Allows you to align the entire tab content to the `left` (default), `center`, or `right` of the parent container/page.
- Automatically align & format heights and widths for bordered tabs for `right` and `left` positions.
- Allows a rotated `sideways` tab header orientation for the `right` and `left` tab directions.
- Auto detect overflowing header labels for `sideways` orientation (with ellipsis styling) and display full label as a title on hover.

> NOTE: This extension depends on the [kartik-v/yii2-widgets](https://github.com/kartik-v/yii2-widgets) extension which in turn depends on the 
[yiisoft/yii2-bootstrap](https://github.com/yiisoft/yii2/tree/master/extensions/bootstrap) extension. Check the 
[composer.json](https://github.com/kartik-v/yii2-tabs-x/blob/master/composer.json) for this extension's requirements and dependencies. 
Note: Yii 2 framework is still in active development, and until a fully stable Yii2 release, your core yii2-bootstrap packages (and its dependencies) 
may be updated when you install or update this extension. You may need to lock your composer package versions for your specific app, and test 
for extension break if you do not wish to auto update dependencies.

## Demo
You can see detailed [documentation and examples](http://demos.krajee.com/tabs-x) on usage of the extension.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

> Note: You must set the `minimum-stability` to `dev` in the **composer.json** file in your application root folder before installation of this extension.

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
            'headerOptions' => [...],
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