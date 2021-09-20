<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2021
 * @package yii2-tabs-x
 * @version 1.2.8
 */

namespace kartik\tabs;

use kartik\base\PluginAssetBundle;

/**
 * Asset bundle for TabsX widget. Includes assets from bootstrap-tabs-x plugin by Krajee.
 *
 * @see http://plugins.krajee.com/tabs-x
 * @see http://github.com/kartik-v/bootstrap-tabs-x
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class TabsXAsset extends PluginAssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath('@vendor/kartik-v/bootstrap-tabs-x');
        $this->setupAssets('css', ['css/bootstrap-tabs-x' . (!$this->isBs(3) ? '-bs4' : '')]);
        $this->setupAssets('js', ['js/bootstrap-tabs-x']);
        parent::init();
    }
}
