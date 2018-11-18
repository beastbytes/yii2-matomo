<?php
/**
 * Matomo Base Reporting Component Class file
 *
 * @author    Chris Yates
 * @copyright Copyright &copy; 2017 BeastBytes - All Rights Reserved
 * @license   BSD 3-Clause
 * @package   Matomo\Reporting
 */

namespace BeastBytes\Matomo\Reporting;

use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;

/**
 * Matomo Reporting Component Class
 *
 * Integrates the {@link https://developer.matomo.org/api-reference/reporting-api Matomo Reporting API}
 */
abstract class Reporting extends Component
{
    /**
     * @link{http://userguide.icu-project.org/formatparse/datetime ICU format} for Matomo dates
     */
    const DATE_FORMAT = 'yyyy-MM-dd';

    /**
     * @var string Matomo Auth token
     * The token is on the API page of the Matomo interface
     */
    public $authToken;
    /**
     * @var string response format
     * If set the return value is in the given format.
     * If empty the return value is a PHP array
     */
    public $format;
    /**
     * @var string Default period of reports [day|week|month|year|range]
     * @see setDate()
     */
    public $period = 'month';
    /**
     * @var boolean|string Path to Reports class.
     * Reports is attached as a behavior to provide high level calls to reports methods.
     * By default the local Reports behavior is attached.
     * Set FALSE to disable attachment of a behavior
     */
    public $reports = '\BeastBytes\Matomo\Reporting\Reports';
    /**
     * @var integer Matomo site id
     */
    public $siteId;

    /**
     * @var array Common request parameters
     */
    protected $params;

    /**
     * @var string Parsed date (range)
     */
    private $_date = 'today';

    /**
     * @inheritdoc
     */
    public function init()
    {
        foreach (['authToken', 'siteId'] as $property) {
            if (empty($this->$property)) {
                throw new InvalidConfigException(strtr('{property} must be set', ['{property}' => $property]));
            }
        }

        if (!empty($this->period) && !in_array($this->period, array('day', 'week', 'month', 'year', 'range'))) {
            throw new InvalidConfigException('period must be one of "day", "week", "month", "year", or "range"');
        }

        if (!empty($this->reports)) {
            $this->attachBehavior('reports', $this->reports);
        }

        $this->params = [
            'format'     => ($this->format ?: 'json'),
            'date'       => $this->_date,
            'idSite'     => $this->siteId,
            'period'     => $this->period,
            'token_auth' => $this->authToken,
        ];

        parent::init();
    }

    /**
     * Sets the date (range)  for the report
     *
     * @param mixed Date (range)
     * Can be either a date or an array of two dates.
     * A date can - with some limitations - be anything supported by \yii\i18n\Formatter or "today", "yesterday",
     * "lastX", or "previousX" where X is the number of periods
     * Limitations: The first element of an array must be a value supported by \yii\i18n\Formatter, the second can
     * not be "lastX" or "previousX"
     * Note: "lastX" includes today, "previousX" does not
     * See @link{https://developer.matomo.org/api-reference/reporting-api#standard-api-parameters Matomo documentation}
     * for details
     * @throws InvalidParamException
     * @see $period
     */
    public function setDate($date)
    {
        if (is_array($date)) {
            if (count($date) === 2) {
                foreach ($date as $n => &$d) {
                    if ($n === 0 || !is_string($date) || preg_match('/^(to|yester)day/', $d) === 0) {
                        $d = Yii::$app->formatter->asDate($d, self::DATE_FORMAT);
                    }
                }

                $this->_date = join(',', $date);
            } else {
                throw new InvalidParamException('$date array must have two elements');
            }
        } else {
            $this->_date = (is_string($date) && preg_match('/^((to|yester)day)|((last|previous)[1-9]\d*)/', $date)
                ? $date
                : Yii::$app->formatter->asDate($date, self::DATE_FORMAT)
            );
        }
    }

    /**
     * Make a call to the API
     *
     * @param string $method Reporting API method
     * @param array $params Parameters for the method as key => value pairs
     * @return boolean|string Report results or FALSE on failure
     */
    abstract protected function call($method, $params = []);
}
