<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2018
 * @package yii2-tabs-x
 * @version 1.2.7
 */

namespace kartik\tabs;

use kartik\base\AssetBundle;

/**
 * Asset bundle for StickyTabs plugin. Includes assets from timabell/jquery-stickytabs plugin.
 *
 * @see https://github.com/timabell/jquery-stickytabs
 * @see http://github.com/kartik-v/bootstrap-tabs-x
 * @see http://plugins.krajee.com/tabs-x
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class StickyTabsAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('js', ['js/jquery.stickytabs']);
        parent::init();
    }
}
