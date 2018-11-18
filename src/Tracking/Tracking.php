<?php
/**
 * Matomo Tracking Component Class file
 *
 * @author    Chris Yates
 * @copyright Copyright &copy; 2017 BeastBytes - All Rights Reserved
 * @license   BSD 3-Clause
 * @package   Matomo\Tracking
 */

namespace BeastBytes\Matomo\Tracking;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\UnknownMethodException;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\View;

/**
 * Matomo Tracking Component Class
 *
 * Adds {@link https://matomo.org/ Matomo Analytics Platform} tracking code to every page and adds additional code for
 * tracking function calls made in the application
 *
 * Add and configure the Tracking component in the application configuration file.
 */
class Tracking extends Component
{
    /**
     * Matomo Javascript tracking
     */
	const JS = 'var _paq=_paq||[];{trackers}(function(){var u="//{url}/";_paq.push(["setTrackerUrl",u+"{php}"]);_paq.push(["setSiteId","{siteId}"]);var d=document,g=d.createElement("script"),s=d.getElementsByTagName("script")[0];g.type="text/javascript";g.async=true;g.defer=true;g.src=u+"{js}";s.parentNode.insertBefore(g,s);})();';

    /**
     * Matomo image tracking HTML
     */
    const IMG = '<noscript><p><img src="//{url}/{php}?idsite={siteId}" style="border:0;" alt="" /></p></noscript>';

    const STRING_LITERAL = ':';

    /**
     * @var [string] Array of Matomo tracking calls which should **not** be followed by the TrackPageView call
     */
    public $disableTrackPageView = ['trackSiteSearch'];
    /**
     * @var integer Heartbeat timer in seconds. Zero disables the heartbeat timer. Default 15.
     */
    public $heartbeat = 15;
    /**
     * @var boolean Whether to use image tracking as a fallback if the client has Javascript disabled
     */
    public $imageTracking = true;
    /**
     * @var string Matomo PHP filename
     */
    public $matomoPhp = 'matomo.php';
    /**
     * @var string Matomo JavaScript filename
     */
    public $matomoJs = 'matomo.js';
    /**
     * @var integer ID of the website to track
     */
    public $siteId = 1;
    /**
     * @var string Base URL for analytics with no scheme or trailing /; e.g. analytics.mysite.com or mysite.com/analytics
     */
    public $url;

    /**
     * @var [string] Tracker function calls
     */
    private $_trackers = [];
    /**
     * @var boolean Whether to add the trackPageView call to the trackers. Will be set to FALSE if any of the
     * functions listed in @link{$disableTrackPageView} are called
     */
    private $_trackPageView = true;

    /**
     * Checks to see if any attached behavior has the named method; if so it is executed.
     * If not a Matomo Javascript API call to the named function is generated
     *
     * @param string $name Function name
     * @param array $params Function params
     * @return mixed The return value
     */
    public function __call($name, $params)
    {
        try {
            return parent::__call($name, $params);
        } catch (UnknownMethodException $e) {
            $this->_trackers[] = Json::encode($this->tracker($name, $params[0], (isset($params[1]) ? $params[1] : [])));
            return null;
        }
    }

    /**
     * @inheritdoc
     * Attaches event handlers to insert Matomo tracking code into pages
     */
    public function init()
    {
        foreach (['siteId', 'url'] as $property) {
            if (empty($this->$property)) {
                throw new InvalidConfigException(strtr('{property} must be set', ['{property}' => $property]));
            }
        }

        parent::init();

        Yii::$app->view->on(View::EVENT_BEGIN_PAGE, [$this, 'registerTracking']);

        if ($this->imageTracking) {
            Yii::$app->view->on(View::EVENT_BEGIN_BODY, [$this, 'renderImageTracking']);
        }
    }

    /**
     * Registers tracking Javascript
     *
     * **DO NOT** call this method; it is called from the View::EVENT_BEGIN_PAGE event
     */
    public function registerTracking()
	{
	    if ($this->_trackPageView) {
            array_push($this->_trackers, '["trackPageView"]', '["enableLinkTracking"]');
        }

        Yii::$app->view->registerJs(strtr(self::JS, [
            '{trackers}' => '_paq.push(' . join(');_paq.push(', $this->_trackers) . ');',
            '{siteId}'   => $this->siteId,
            '{js}'       => $this->matomoJs,
            '{php}'      => $this->matomoPhp,
            '{url}'      => $this->url
        ]), View::POS_HEAD);
	}

    /**
     * Renders image tracking HTML
     *
     * **DO NOT** call this method; it is called from the View::EVENT_BEGIN_BODY event
     */
    public function renderImageTracking()
    {
        echo strtr(self::IMG, [
            '{siteId}' => $this->siteId,
            '{php}'    => $this->matomoPhp,
            '{url}'    => $this->url
        ]);
    }

    /**
     * Tracks an order and the order items.
     * Wrapper for addECommerceItem and trackEcommerceOrder function calls
     *
     * @param array|\yii\base\Model $order Model containing order details
     * @param [array|\yii\base\Model] $items Items in the order
     * @param array $parameters Array of arrays describing how to obtain JavaScript API function parameter values from
     * the model; $parameters[0] applies to trackEcommerceItems, $parameters[1] applies to trackEcommerceOrder
     * See @link{tracker()} for details
     */
    public function trackOrder($order, $items, $parameters)
    {
        $this->addItems($items, $parameters[0]);
        $this->trackEcommerceOrder($order, $parameters[1]);
    }

    /**
     * Updates a cart.
     * A wrapper for addECommerceItem and trackEcommerceCartUpdate function calls
     *
     * @param array|\yii\base\Model $cart Model containing cart details (price)
     * @param [array|\yii\base\Model] $items Items in the order
     * @param array $parameters Array of arrays describing how to obtain JavaScript API function parameter values from
     * the model; $parameters[0] applies to trackEcommerceItems, $parameters[1] applies to trackEcommerceCartUpdate
     * See @link{tracker()} for details
     */
    public function trackCartUpdate($cart, $items, $parameters)
    {
        $this->addItems($items, $parameters[0]);
        $this->trackEcommerceCartUpdate($cart, $parameters[1]);
    }

    /**
     * Adds cart or order items
     *
     * @param [array|\yii\base\Model] $items in the order
     * @param array $parameters Array describing how to obtain JavaScript API function parameter values from the model.
     * See @link{tracker()} for details
     * @see  trackOrder()
     */
    public function addItems($items, $parameters)
    {
        foreach ($items as $item) {
            $this->addEcommerceItem($item, $parameters);
        }
    }

    /**
     * Returns the parameters for the named Matomo tracker function from the given model
     *
     * @param string $function Function name
     * @param array|yii\base\Model $model Model providing the parameters
     * @param array $parameters Array describing how to obtain JavaScript API function parameter values from the model.
     * Parameters must be listed in the order required by the function; they are either:
     * a string: if the string begins with ':' it is a string literal, else it is the attribute/key name in the
     * model/array,
     * an anonymous function returning the value. The anonymous function signature should be: function($model,
     * $defaultValue)
     * any other type - integer, float, or boolean is used "as is". Use boolean false for unused parameters
     *
     * Make sure that the parameters are the type required by the JavaScript Tracking API - in particular, make sure
     * booleans, floats, and integers are not strings
     *
     * Example for the 'addEcommerceItem' JavaScript Tracking function:
     * ['sku', 'name', ':The Category', function($model, null) {return (float)$model->totalPrice;}, function($model, null) {return (int)$model->quantity;}]
     * @return array Function parameters
     */
    protected function tracker($function, $model, $parameters)
    {
        if (in_array($function, $this->disableTrackPageView)) {
            $this->_trackPageView = false;
        }

        $params = [$function];
        foreach ($parameters as $parameter) {
            switch(gettype($parameter)) {
                case 'boolean': // fall through
                case 'double': // fall through
                case 'integer':
                    $params[] = $parameter;
                    break;
                case 'string':
                    if (strpos($parameter, self::STRING_LITERAL) !== false) {
                        $params[] = substr($parameter, strlen(self::STRING_LITERAL));
                        break;
                    }
                    // fall through
                default: // string or Closure
                    $params[] = ArrayHelper::getValue($model, $parameter);
            }
        }

        return $params;
    }
}
