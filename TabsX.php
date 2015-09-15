<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2015
 * @package yii2-tabs-x
 * @version 1.2.1
 */

namespace kartik\tabs;

use Yii;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Dropdown;
use yii\base\InvalidConfigException;

/**
 * An extended Bootstrap Tabs widget for Yii Framework 2 based on the bootstrap-tabs-x
 * plugin by Krajee. This widget enhances the default bootstrap tabs plugin with various
 * new styling enhancements.
 *
 * ```php
 * echo TabsX::widget([
 *     'position' => TabsX::POS_ABOVE,
 *     'align' => TabsX::ALIGN_LEFT,
 *     'items' => [
 *         [
 *             'label' => 'One',
 *             'content' => 'Anim pariatur cliche...',
 *             'active' => true
 *         ],
 *         [
 *             'label' => 'Two',
 *             'content' => 'Anim pariatur cliche...',
 *             'headerOptions' => [],
 *             'options' => ['id' => 'myveryownID'],
 *         ],
 *         [
 *             'label' => 'Dropdown',
 *             'items' => [
 *                  [
 *                      'label' => 'DropdownA',
 *                      'content' => 'DropdownA, Anim pariatur cliche...',
 *                  ],
 *                  [
 *                      'label' => 'DropdownB',
 *                      'content' => 'DropdownB, Anim pariatur cliche...',
 *                  ],
 *             ],
 *         ],
 *     ],
 * ]);
 * ```
 *
 * @see http://plugins.krajee.com/tabs-x
 * @see http://github.com/kartik-v/bootstrap-tabs-x
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class TabsX extends \yii\bootstrap\Tabs
{
    use \kartik\base\WidgetTrait;

    /**
     * Tabs direction / position
     */
    const POS_ABOVE = 'above';
    const POS_BELOW = 'below';
    const POS_LEFT = 'left';
    const POS_RIGHT = 'right';

    /**
     * Tab align
     */
    const ALIGN_LEFT = 'left';
    const ALIGN_CENTER = 'center';
    const ALIGN_RIGHT = 'right';

    /**
     * Tab content fixed heights
     */
    const SIZE_TINY = 'xs';
    const SIZE_SMALL = 'sm';
    const SIZE_MEDIUM = 'md';
    const SIZE_LARGE = 'lg';

    /**
     * @var string the position of the tabs with respect to the tab content Should be
     * one of the [[TabsX::POS]] constants. Defaults to [[TabsX::POS_ABOVE]].
     */
    public $position = self::POS_ABOVE;

    /**
     * @var string the alignment of the tab headers with respect to the tab content. Should be
     * one of the [[TabsX::ALIGN]] constants. Defaults to [[TabsX::ALIGN_LEFT]].
     */
    public $align = self::ALIGN_LEFT;

    /**
     * @var boolean whether the tab content should be boxed within a bordered container.
     * Defaults to `false`.
     */
    public $bordered = false;

    /**
     * @var boolean whether the tab header text orientation should be rotated sideways.
     * Applicable only when position is one of [[TabsX::POS_LEFT]] or [[TabsX::POS_RIGHT]].
     * Defaults to `false`.
     */
    public $sideways = false;

    /**
     * @var boolean whether to fade in each tab pane using the fade animation effect. Defaults
     * to `true`.
     */
    public $fade = true;

    /**
     * @var string whether the tab body content height should be of a fixed size. You should
     * pass one of the [[TabsX::SIZE]] constants. Applicable only when position is one of
     * [[TabsX::POS_ABOVE]] or [[TabsX::POS_BELOW]]. Defaults to empty string (meaning dynamic
     * height).
     */
    public $height = '';

    /**
     * @var array the HTML attributes for the TabsX container
     */
    public $containerOptions = [];

    /**
     * @var array widget plugin options
     */
    public $pluginOptions = [];
    
    /**
     *
     * @var array|boolean|null if set then stickytabs are used. If set to array then the array 
     * is used as the stickytabs settings.
     */
    public $stickyTabs;

    /**
     * @var array widget JQuery events. You must define events in
     * event-name => event-function format
     * for example:
     * ~~~
     * pluginEvents = [
     *     "change" => "function() { log("change"); }",
     *     "open" => "function() { log("open"); }",
     * ];
     * ~~~
     */
    public $pluginEvents = [];

    /**
     * @var string the name of the jQuery plugin
     */
    protected $_pluginName;

    /**
     * @var string the hashed global variable name storing the pluginOptions
     */
    protected $_hashVar;

    /**
     * @var string the element's HTML5 data variable name storing the pluginOptions
     */
    protected $_dataVar;

    /**
     * @var string the Json encoded options
     */
    protected $_encOptions = '';

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        $this->_pluginName = 'tabsX';
        if (empty($this->containerOptions['id'])) {
            $this->containerOptions['id'] = $this->options['id'] . '-container';
        }
        if (ArrayHelper::getValue($this->containerOptions, 'data-enable-cache', true) === false) {
            $this->containerOptions['data-enable-cache'] = "false";
        }
        $this->registerAssets();
        Html::addCssClass($this->options, 'nav ' . $this->navType);
        $this->options['role'] = 'tablist';
        $css = self::getCss("tabs-{$this->position}", $this->position != null) .
            self::getCss("tab-align-{$this->align}", $this->align != null) .
            self::getCss("tab-bordered", $this->bordered) .
            self::getCss("tab-sideways",
                $this->sideways && ($this->position == self::POS_LEFT || $this->position == self::POS_RIGHT)) .
            self::getCss("tab-height-{$this->height}",
                $this->height != null && ($this->position == self::POS_ABOVE || $this->position == self::POS_BELOW)) . 
                ' ' . ArrayHelper::getValue($this->pluginOptions, 'addCss', 'tabs-krajee');
        Html::addCssClass($this->containerOptions, $css);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo $this->renderItems();
    }

    /**
     * Parse the CSS content to append based on condition
     *
     * @param string  $prop the css property
     * @param boolean $condition the validation to append the CSS class
     *
     * @return string the parsed CSS
     */
    protected static function getCss($prop = '', $condition = true)
    {
        return $condition ? ' ' . $prop : '';
    }

    /**
     * Renders tab items as specified on [[items]].
     *
     * @return string the rendering result.
     * @throws InvalidConfigException.
     */
    protected function renderItems()
    {
        $headers = [];
        $panes = [];

        if (!$this->hasActiveTab() && !empty($this->items)) {
            $this->items[0]['active'] = true;
        }

        foreach ($this->items as $n => $item) {
            if (!ArrayHelper::remove($item, 'visible', true)) {
                continue;
            }
            if (!isset($item['label'])) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $headerOptions = array_merge($this->headerOptions, ArrayHelper::getValue($item, 'headerOptions', []));
            $linkOptions = array_merge($this->linkOptions, ArrayHelper::getValue($item, 'linkOptions', []));
            $content = ArrayHelper::getValue($item, 'content', '');

            if (isset($item['items'])) {
                $label .= ' <b class="caret"></b>';
                Html::addCssClass($headerOptions, 'dropdown');

                if ($this->renderDropdown($n, $item['items'], $panes)) {
                    Html::addCssClass($headerOptions, 'active');
                }

                Html::addCssClass($linkOptions, 'dropdown-toggle');
                $linkOptions['data-toggle'] = 'dropdown';
                $header = Html::a($label, "#", $linkOptions) . "\n"
                    . Dropdown::widget([
                        'items' => $item['items'],
                        'clientOptions' => false,
                        'view' => $this->getView()
                    ]);
            } else {
                $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
                $options['id'] = ArrayHelper::getValue($options, 'id', $this->options['id'] . '-tab' . $n);
                $css = 'tab-pane';
                $isActive = ArrayHelper::remove($item, 'active');
                if ($this->fade) {
                    $css = $isActive ? "{$css} fade in" : "{$css} fade";
                }
                Html::addCssClass($options, $css);
                if ($isActive) {
                    Html::addCssClass($options, 'active');
                    Html::addCssClass($headerOptions, 'active');
                }
                if (isset($item['url'])) {
                    $header = Html::a($label, $item['url'], $linkOptions);
                } else {
                    $linkOptions['data-toggle'] = 'tab';
                    $linkOptions['role'] = 'tab';
                    $header = Html::a($label, '#' . $options['id'], $linkOptions);
                }
                if ($this->renderTabContent) {
                    $panes[] = Html::tag('div', $content, $options);
                }
            }

            $headers[] = Html::tag('li', $header, $headerOptions);
        }
        $outHeader = Html::tag('ul', implode("\n", $headers), $this->options);
        if ($this->renderTabContent) {
            $outPane =  Html::tag('div', implode("\n", $panes), ['class' => 'tab-content']);
            $tabs = $this->position == self::POS_BELOW ? $outPane . "\n" . $outHeader : $outHeader . "\n" . $outPane;
        } else {
            $tabs = $outHeader;
        } 
        return Html::tag('div', $tabs, $this->containerOptions);
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        TabsXAsset::register($view);
        $this->registerPlugin($this->_pluginName, 'jQuery("#' . $this->containerOptions['id'] . '")');
        if($this->stickyTabs) {
            StickyTabsAsset::register($view);
            $options = is_array($this->stickyTabs)? Json::htmlEncode($this->stickyTabs) : null;
            $view->registerJs('jQuery("#' . $this->containerOptions['id'] . '")'.'.stickyTabs('.$options.')');
        }
    }
}