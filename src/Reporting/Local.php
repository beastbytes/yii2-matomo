<?php
/**
 * Matomo Local Reporting Class file
 *
 * @author    Chris Yates
 * @copyright Copyright &copy; 2017 BeastBytes - All Rights Reserved
 * @license   BSD 3-Clause
 * @package   Matomo\Reporting
 */

namespace BeastBytes\Matomo\Reporting;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use Matomo\API\Request;
use Matomo\Application\Environment;
use Matomo\FrontController;

define('MATOMO_ENABLE_DISPATCH',      false);
define('MATOMO_ENABLE_ERROR_HANDLER', false);
define('MATOMO_ENABLE_SESSION_START', false);

/**
 * Matomo HTML Reporting Class
 *
 * Access the Matomo reporting API using PHP.
 * Use when Matomo is on the same server as the application
 */
class Local extends Reporting
{
    /**
     * @var string Path to Matomo
     */
    public $includePath;
    /**
     * @var string Matomo entry file relative to @link{includePath}
     */
    public $matomo = 'index.php';
    /**
     * @var string Matomo reporting API entry point relative to @link{includePath}
     */
    public $request = 'core/API/Request.php';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->includePath)) {
            throw new InvalidConfigException('includePath must be set');
        }

        parent::init();

        $includePath = $this->getIncludePath($this->includePath);
        require_once $includePath . '/' . $this->matomo;
        require_once $includePath . '/' . $this->request;
    }

    /**
     * @inheritdoc
     */
    public function call($method, $params = [])
    {
        (new Environment(null))->init();
        FrontController::getInstance()->init();

        $response = (new Request($this->parseParams(array_merge(['method' => $method], $this->params, $params))))->process();

        return ($this->format ? $response : Json::decode($response));
    }

    /**
     * Gets the Matomo include path
     *
     * @param  string $path The path can be a path alias (starts with '@'), relative to the current directory (starts
     * with '/') or an absolute path
     * @return string The Matomo include path
     */
    private function getIncludePath($path)
    {
        if (strncmp($path, '@', 1) === 0) {
            return Yii::getAlias($path);
        } elseif (strncmp($path, '/', 1) === 0) {
            return realpath(__DIR__ . $path);
        }

        return $path;
    }

    /**
     * Parses parameters into a query string
     *
     * @param array $params Parameters as key => value pairs
     * @return string Parameter query string
     */
    private function parseParams($params)
    {
        foreach ($params as $k => &$v) {
            $v = "$k=$v";
        }

        return join('&', $params);
    }
}
