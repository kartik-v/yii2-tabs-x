<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2018
 * @package yii2-tabs-x
 * @version 1.2.5
 */
 
namespace kartik\tabs;

use yii\bootstrap4\Widget;

/**
 * Tabs plugin for Bootstrap 3
 */
class TabsPluginBS4 extends Widget
{
    public function register()
    {
        $this->registerPlugin('tabs');
    }
}
