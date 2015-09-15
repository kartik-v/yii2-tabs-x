<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2015
 * @package yii2-tabs-x
 * @version 1.2.1
 */

namespace kartik\tabs;

/**
 * Asset bundle for TabsX widget. Includes assets from
 * StickyTabs by aidanlister.
 *
 * @see http://plugins.krajee.com/tabs-x
 * @see https://github.com/aidanlister/jquery-stickytabs
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class StickyTabsAsset extends \kartik\base\AssetBundle
{
    public $depends = [
        'kartik\tabs\TabsXAsset',
    ];
    
    public $js = [
        'jquery.stickytabs.js'
    ];
    
    public function init()
    {
        $this->setSourcePath('@bower/jquery-stickytabs');
        parent::init();
    }
}