<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-tabs-x
 * @version 1.2.0
 */

namespace kartik\tabs;

use yii\web\AssetBundle;

/**
 * Asset bundle for TabsX widget. Includes assets from
 * bootstrap-tabs-x plugin by Krajee.
 *
 * @see http://plugins.krajee.com/tabs-x
 * @see http://github.com/kartik-v/bootstrap-tabs-x
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class TabsXAsset extends AssetBundle
{
    public $sourcePath = '@vendor/kartik-v/bootstrap-tabs-x';

    public $js = [
        'js/bootstrap-tabs-x.js'
    ];
    
    public $css = [
        'css/bootstrap-tabs-x.css'
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
