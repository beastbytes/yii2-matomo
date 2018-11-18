<?php
/**
 * Matomo Remote Reporting Class file
 *
 * @author    Chris Yates
 * @copyright Copyright &copy; 2017 BeastBytes - All Rights Reserved
 * @license   BSD 3-Clause
 * @package   Matomo\Reporting
 */

namespace BeastBytes\Matomo\Reporting;

use yii\httpclient\Client;
use yii\httpclient\Response;

/**
 * Matomo Remote Reporting Class
 *
 * Access the Matomo reporting API using HTML requests.
 * Use when Matomo is on a remote server
 */
class Remote extends Reporting
{
    /**
     * @var string Matomo URL
     */
    public $url;

    /**
     * @var Response HTTP Client Response object
     */
    private $_response;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->params['module'] = 'API';
    }

    /**
     * Returns the HTTP Client Response object
     *
     * Useful if the Response is not OK
     *
     * @return Response HTTP Client Response object
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * @inheritdoc
     */
    public function call($method, $params = [])
    {
        $this->_response = (new Client())->createRequest()
            ->setMethod('get')
            ->setUrl($this->url)
            ->setData(array_merge(['method' => $method], $this->params, $params))
            ->send();

        if ($this->_response->isOk) {
            return ($this->format ? $this->_response->content : $this->_response->data);
        }

        return false;
    }
}
