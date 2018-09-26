<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2018
 * @package yii2-tabs-x
 * @version 1.2.7
 */

namespace kartik\tabs;

use kartik\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

/**
 * TabsX An extended Bootstrap Tabs navigation widget for Yii Framework 2 based on the
 * [bootstrap-tabs-x plugin](http://plugins.krajee.com/tabs-x) by Krajee. This widget enhances the default bootstrap
 * tabs plugin with various new styling enhancements.
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
class TabsX extends Widget
{
    /**
     * Tabs position above
     */
    const POS_ABOVE = 'above';
    /**
     * Tabs position below
     */
    const POS_BELOW = 'below';
    /**
     * Tabs position on left
     */
    const POS_LEFT = 'left';
    /**
     * Tabs position on right
     */
    const POS_RIGHT = 'right';
    /**
     * Tab aligned to the left
     */
    const ALIGN_LEFT = 'left';
    /**
     * Tab aligned to the center
     */
    const ALIGN_CENTER = 'center';
    /**
     * Tab aligned to the right
     */
    const ALIGN_RIGHT = 'right';

    /**
     * @var array list of tabs in the tabs widget. Each array element represents a single
     * tab with the following structure:
     *
     * - label: string, required, the tab header label.
     * - encode: bool, optional, whether this label should be HTML-encoded. This param will override
     *   global `$this->encodeLabels` param.
     * - headerOptions: array, optional, the HTML attributes of the tab header.
     * - linkOptions: array, optional, the HTML attributes of the tab header link tags.
     * - content: string, optional, the content (HTML) of the tab pane.
     * - url: string, optional, an external URL. When this is specified, clicking on this tab will bring
     *   the browser to this URL. This option is available since version 2.0.4.
     * - options: array, optional, the HTML attributes of the tab pane container.
     * - active: bool, optional, whether this item tab header and pane should be active. If no item is marked as
     *   'active' explicitly - the first one will be activated.
     * - visible: bool, optional, whether the item tab header and pane should be visible or not. Defaults to true.
     * - items: array, optional, can be used instead of `content` to specify a dropdown items
     *   configuration array. Each item can hold three extra keys, besides the above ones:
     *     * active: bool, optional, whether the item tab header and pane should be visible or not.
     *     * content: string, required if `items` is not set. The content (HTML) of the tab pane.
     *     * contentOptions: optional, array, the HTML attributes of the tab content container.
     */
    public $items = [];

    /**
     * @var array list of HTML attributes for the item container tags. This will be overwritten
     * by the "options" set in individual [[items]]. The following special options are recognized:
     *
     * - tag: string, defaults to "div", the tag name of the item container tags.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $itemOptions = [];

    /**
     * @var array list of HTML attributes for the header container tags. This will be overwritten
     * by the "headerOptions" set in individual [[items]].
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $headerOptions = [];

    /**
     * @var array list of HTML attributes for the tab header link tags. This will be overwritten
     * by the "linkOptions" set in individual [[items]].
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $linkOptions = [];

    /**
     * @var bool whether the labels for header items should be HTML-encoded.
     */
    public $encodeLabels = true;

    /**
     * @var string specifies the Bootstrap tab styling.
     */
    public $navType = 'nav-tabs';

    /**
     * @var bool whether to render the `tab-content` container and its content. You may set this property
     * to be false so that you can manually render `tab-content` yourself in case your tab contents are complex.
     */
    public $renderTabContent = true;

    /**
     * @var array list of HTML attributes for the `tab-content` container. This will always contain the CSS class `tab-content`.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $tabContentOptions = [];

    /**
     * @var string name of a class to use for rendering dropdowns withing this widget. Defaults to [[Dropdown]].
     */
    public $dropdownClass;

    /**
     * @var string the position of the tabs with respect to the tab content Should be one of the [[TabsX::POS]]
     * constants.
     */
    public $position = self::POS_ABOVE;

    /**
     * @var string the alignment of the tab headers with respect to the tab content. Should be one of the
     * [[TabsX::ALIGN]] constants.
     */
    public $align = self::ALIGN_LEFT;

    /**
     * @var boolean whether the tab content should be boxed within a bordered container.
     */
    public $bordered = false;

    /**
     * @var boolean whether the tab header text orientation should be rotated sideways. Applicable only when position
     *     is one of [[TabsX::POS_LEFT]] or [[TabsX::POS_RIGHT]].
     */
    public $sideways = false;

    /**
     * @var boolean whether to fade in each tab pane using the fade animation effect.
     */
    public $fade = true;

    /**
     * @var string whether the tab body content height should be of a fixed size. You should pass one of the
     * `TabsX::SIZE` constants. Applicable only when position is one of [[TabsX::POS_ABOVE]] or [[TabsX::POS_BELOW]].
     * Defaults to empty string (meaning dynamic height).
     */
    public $height = '';

    /**
     * @var array the HTML attributes for the TabsX container.
     */
    public $containerOptions = [];

    /**
     * @var boolean whether to enable sticky tabs plugin to maintain tabs push state on browser back and forward.
     */
    public $enableStickyTabs = false;

    /**
     * @var array sticky tabs plugin options.
     */
    public $stickyTabsOptions = [];

    /**
     * @var boolean whether this tab widget should be printable.
     */
    public $printable = true;

    /**
     * @var array the HTML attributes for the tab content header in print view.
     */
    public $printHeaderOptions = ['class' => 'h4'];

    /**
     * @var boolean whether the headers in print view will prepend the main label to the item label in case of dropdowns.
     */
    public $printHeaderCrumbs = true;

    /**
     * @var string the crumb separator for the dropdown headers in the print view when `printHeaderCrumbs` is `true`
     */
    public $printCrumbSeparator = ' &raquo; ';

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function run()
    {
        $this->initWidget();
        echo $this->renderItems();
    }

    /**
     * Initializes the widget settings.
     * @throws InvalidConfigException
     */
    public function initWidget()
    {
        $this->pluginName = 'tabsX';
        $isBs4 = $this->isBs4();
        if (!isset($this->dropdownClass)) {
            $this->dropdownClass = $isBs4 ? 'kartik\bs4dropdown\Dropdown' : 'yii\bootstrap\Dropdown';
        }
        Html::addCssClass($this->containerOptions, 'tabs-x');
        if (empty($this->containerOptions['id'])) {
            $this->containerOptions['id'] = $this->options['id'] . '-container';
        }
        if (ArrayHelper::getValue($this->containerOptions, 'data-enable-cache', true) === false) {
            $this->containerOptions['data-enable-cache'] = "false";
        }
        $this->registerAssets();
        Html::addCssClass($this->options, ['nav', $this->navType]);
        Html::addCssClass($this->tabContentOptions, 'tab-content');
        if ($this->printable) {
            $this->addCssClass($this->options, self::BS_HIDDEN_PRINT);
        }
        $this->options['role'] = 'tablist';
        $css = static::getCss("tabs-{$this->position}", $this->position != null) .
            static::getCss("tab-align-{$this->align}", $this->align != null) .
            static::getCss("tab-bordered", $this->bordered) .
            static::getCss(
                "tab-sideways",
                $this->sideways && ($this->position == self::POS_LEFT || $this->position == self::POS_RIGHT)
            ) .
            static::getCss(
                "tab-height-{$this->height}",
                $this->height != null && ($this->position == self::POS_ABOVE || $this->position == self::POS_BELOW)
            ) .
            ' ' . ArrayHelper::getValue($this->pluginOptions, 'addCss', 'tabs-krajee');
        Html::addCssClass($this->containerOptions, $css);
        $this->addCssClass($this->printHeaderOptions, self::BS_VISIBLE_PRINT);
    }

    /**
     * Parse the CSS content to append based on condition.
     *
     * @param string $prop the css property
     * @param boolean $condition the validation to append the CSS class
     *
     * @return string the parsed CSS
     */
    protected static function getCss($prop = '', $condition = true)
    {
        return $condition ? ' ' . $prop : '';
    }

    /**
     * Gets the label for an item configuration.
     *
     * @param array $item tabs item configuration
     *
     * @return string
     * @throws InvalidConfigException
     */
    protected function getLabel($item = [])
    {
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $encodeLabel = ArrayHelper::getValue($item, 'encode', $this->encodeLabels);
        return $encodeLabel ? Html::encode($item['label']) : $item['label'];
    }

    /**
     * @return bool if there's active tab defined
     */
    protected function hasActiveTab()
    {
        foreach ($this->items as $item) {
            if (isset($item['active']) && $item['active'] === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * Sets the first visible tab as active.
     *
     * This method activates the first tab that is visible and
     * not explicitly set to inactive (`'active' => false`).
     */
    protected function activateFirstVisibleTab()
    {
        foreach ($this->items as $i => $item) {
            $active = ArrayHelper::getValue($item, 'active', null);
            $visible = ArrayHelper::getValue($item, 'visible', true);
            if ($visible && $active !== false) {
                $this->items[$i]['active'] = true;
                return;
            }
        }
    }

    /**
     * Renders tab items as specified in [[items]].
     *
     * @return string the rendering result.
     * @throws InvalidConfigException
     * @throws \Exception
     */
    protected function renderItems()
    {
        $headers = $panes = $labels = [];
        $isBs4 = $this->isBs4();
        if (!$this->hasActiveTab()) {
            $this->activateFirstVisibleTab();
        }

        foreach ($this->items as $n => $item) {
            if (!ArrayHelper::remove($item, 'visible', true)) {
                continue;
            }
            $label = $this->getLabel($item);
            $headerOptions = array_merge($this->headerOptions, ArrayHelper::getValue($item, 'headerOptions', []));
            $linkOptions = array_merge($this->linkOptions, ArrayHelper::getValue($item, 'linkOptions', []));
            $this->addCssClass($linkOptions, self::BS_NAV_LINK);

            if (isset($item['items'])) {
                foreach ($item['items'] as $subItem) {
                    $subLabel = $this->getLabel($subItem);
                    $labels[] = $this->printHeaderCrumbs ? $label . $this->printCrumbSeparator . $subLabel : $subLabel;
                }
                if (!$isBs4) {
                    $label .= ' <b class="caret"></b>';
                }
                Html::addCssClass($headerOptions, 'dropdown');
                if ($this->renderDropdown($n, $item['items'], $panes)) {
                    if ($isBs4) {
                        Html::addCssClass($linkOptions, 'active');
                    } else {
                        Html::addCssClass($headerOptions, 'active');
                    }
                }
                Html::addCssClass($linkOptions, 'dropdown-toggle');

                $linkOptions['data-toggle'] = 'dropdown';

                /**
                 * @var \yii\bootstrap\Dropdown $dropdownClass
                 */
                $dropdownClass = $this->dropdownClass;
                $header = Html::a($label, "#", $linkOptions) . "\n"
                    . $dropdownClass::widget([
                        'items' => $item['items'],
                        'clientOptions' => false,
                        'view' => $this->getView(),
                    ]);
            } else {
                $labels[] = $label;
                $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
                $options['id'] = ArrayHelper::getValue($options, 'id', $this->options['id'] . '-tab' . $n);
                $css = 'tab-pane';
                $isActive = ArrayHelper::remove($item, 'active');
                if ($this->fade) {
                    $css = $isActive ? [$css, 'fade', $this->getCssClass(self::BS_SHOW)] : [$css, 'fade'];
                }
                Html::addCssClass($options, $css);
                if ($isActive) {
                    if ($isBs4) {
                        Html::addCssClass($linkOptions, 'active');
                        $css = ['active', 'show'];
                    } else {
                        Html::addCssClass($headerOptions, 'active');
                        $css = 'active';
                    }
                    Html::addCssClass($options, $css);
                }
                if (isset($item['url'])) {
                    $header = Html::a($label, $item['url'], $linkOptions);
                } else {
                    $linkOptions['data-toggle'] = 'tab';
                    $linkOptions['role'] = 'tab';
                    if (!isset($linkOptions['aria-selected'])) {
                        $linkOptions['aria-selected'] = 'false';
                    }
                    $linkOptions['aria-controls'] = $options['id'];
                    $header = Html::a($label, '#' . $options['id'], $linkOptions);
                }
                if ($this->renderTabContent) {
                    $tag = ArrayHelper::remove($options, 'tag', 'div');
                    $panes[] = Html::tag($tag, isset($item['content']) ? $item['content'] : '', $options);
                }
            }
            $this->addCssClass($headerOptions, self::BS_NAV_ITEM);
            $headers[] = Html::tag('li', $header, $headerOptions);
        }

        $outHeader = Html::tag('ul', implode("\n", $headers), $this->options);

        if ($this->renderTabContent) {
            Html::addCssClass($this->tabContentOptions, static::getCss('printable', $this->printable));
            $outPane = Html::beginTag('div', $this->tabContentOptions);
            foreach ($panes as $i => $pane) {
                if ($this->printable) {
                    $outPane .= Html::tag('div', ArrayHelper::getValue($labels, $i), $this->printHeaderOptions) . "\n";
                }
                $outPane .= "$pane\n";
            }
            $outPane .= Html::endTag('div');
            $tabs = $this->position == self::POS_BELOW ? $outPane . "\n" . $outHeader : $outHeader . "\n" . $outPane;
        } else {
            $tabs = $outHeader;
        }
        return Html::tag('div', $tabs, $this->containerOptions);
    }

    /**
     * Normalizes dropdown item options by removing tab specific keys `content` and `contentOptions`, and also
     * configure `panes` accordingly.
     * @param string $itemNumber number of the item
     * @param array $items the dropdown items configuration.
     * @param array $panes the panes reference array.
     * @return bool whether any of the dropdown items is `active` or not.
     * @throws InvalidConfigException
     */
    protected function renderDropdown($itemNumber, &$items, &$panes)
    {
        $itemActive = false;

        foreach ($items as $n => &$item) {
            if (is_string($item)) {
                continue;
            }
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            if (!(array_key_exists('content', $item) xor array_key_exists('url', $item))) {
                throw new InvalidConfigException("Either the 'content' or the 'url' option is required, but only one can be set.");
            }
            if (array_key_exists('url', $item)) {
                continue;
            }

            $content = ArrayHelper::remove($item, 'content');
            $options = ArrayHelper::remove($item, 'contentOptions', []);
            Html::addCssClass($options, ['widget' => 'tab-pane']);
            if (ArrayHelper::remove($item, 'active')) {
                Html::addCssClass($options, 'active');
                Html::addCssClass($item['options'], 'active');
                $itemActive = true;
            }

            $options['id'] = ArrayHelper::getValue($options, 'id',
                $this->options['id'] . '-dd' . $itemNumber . '-tab' . $n);
            $item['url'] = '#' . $options['id'];
            if (!isset($item['linkOptions']['data-toggle'])) {
                $item['linkOptions']['data-toggle'] = 'tab';
            }
            $panes[] = Html::tag('div', $content, $options);

            unset($item);
        }

        return $itemActive;
    }

    /**
     * Registers the assets for [[TabsX]] widget.
     */
    public function registerAssets()
    {
        $view = $this->getView();
        TabsXAsset::registerBundle($view, $this->bsVersion);
        if ($this->printable) {
            $view->registerCss('@media print{.tab-content.printable > .tab-pane{display:block;opacity:1;}}');
        }
        $id = 'jQuery("#' . $this->containerOptions['id'] . '")';
        $this->registerPlugin($this->pluginName, $id);
        if ($this->enableStickyTabs) {
            StickyTabsAsset::register($view);
            $opts = Json::encode($this->stickyTabsOptions);
            $id = 'jQuery("#' . $this->containerOptions['id'] . '>.nav")';
            $view->registerJs("{$id}.stickyTabs({$opts});");
        }
    }

}
