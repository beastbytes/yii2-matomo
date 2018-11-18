<?php
/**
 * Matomo report Widget Class file
 *
 * @author    Chris Yates
 * @copyright Copyright &copy; 2017 BeastBytes - All Rights Reserved
 * @license   BSD 3-Clause
 * @package   Matomo\Reporting
 */
namespace BeastBytes\Matomo\Reporting;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Matomo report Widget Class
 *
 * Integrates Matomo Reporting Widgets
 */
class Widget extends \yii\base\Widget
{
    const ACTION_IFRAME    = '{url}/index.php?module=Widgetize&action=iframe&moduleToWidgetize={module}&actionToWidgetize={action}&idSite={siteId}&period=day&date=yesterday&disableLink=1&widget=1&token_auth={authToken}';
    const CONTAINER_IFRAME = '{url}/index.php?module=Widgetize&action=iframe&containerId={container}&moduleToWidgetize=CoreHome&actionToWidgetize=renderWidgetContainer&idSite={siteId}&period=day&date=yesterday&disableLink=1&widget=1&token_auth={authToken}';
    /**
     * @var string Matomo module action
     * If this is set, $module must also be set
     * @see $container
     * @see $module
     */
    public $action;
    /**
     * @var string Matomo Auth token
     * The token is on the API page of the Matomo interface
     */
    public $authToken;
    /**
     * @var string Matomo container id
     * Some widgets use a container id instead of module and action
     */
    public $container;
    /**
     * @var array HTML attributes for the iframe
     */
    public $iframeOptions = [];
    /**
     * @var string Matomo module
     * If this is set, $action must also be set
     * @see $action
     * @see $container
     */
    public $module;
    /**
     * @var array HTML attributes for the container tag of the widget
     * The "tag" element specifies the tag name of the container element and defaults to "div".
     * Set FALSE if no container tag is required
     */
    public $options = [];
    /**
     * @var integer Site ID
     */
    public $siteId;
    /**
     * @var string Matomo URL
     */
    public $url;

    /**
     * @var array Default HTML attributes for the iframe
     */
    private $_iframeOptions = [
        'frameborder'  => 0,
        'height'       => 350,
        'marginheight' => 0,
        'marginwidth'  => 0,
        'scrolling'    => 'yes',
        'width'        => '100%'
    ];
    /**
     * @var string iframe src attribute
     */
    private $_src;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->action) && !empty($this->module)) {
            throw new InvalidConfigException('Widget::action must be set if Widget::module given');
        } elseif (!empty($this->action) && empty($this->module)) {
            throw new InvalidConfigException('Widget::module must be set if Widget::action given');
        }

        $this->_iframeOptions = array_merge($this->_iframeOptions, $this->iframeOptions);

        $this->_iframeOptions['src'] = strtr((isset($this->container)
            ? self::CONTAINER_IFRAME
            : self::ACTION_IFRAME
        ), [
            '{action}'    => $this->action,
            '{authToken}' => $this->authToken,
            '{container}' => $this->container,
            '{module}'    => $this->module,
            '{siteId}'    => $this->siteId,
            '{url}'       => $this->url
        ]);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $iframe = Html::tag('iframe', '', $this->_iframeOptions);

        if ($this->options !== false) {
            $options = $this->options;
            echo Html::tag(ArrayHelper::remove($options, 'tag', 'div'), $iframe, $options);
        } else {
            echo $iframe;
        }
    }
}
