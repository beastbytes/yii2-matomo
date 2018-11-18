<?php
/**
 * Matomo Reports Behavior Class file
 *
 * @author    Chris Yates
 * @copyright Copyright &copy; 2017 BeastBytes - All Rights Reserved
 * @license   BSD 3-Clause
 * @package   Matomo\Reporting
 */

namespace BeastBytes\Matomo\Reporting;

use yii\base\Behavior;

/**
 * Matomo Reports Behavior Class
 *
 * High level methods to the {@link https://developer.matomo.org/api-reference/reporting-api Matomo Reporting API}
 *
 * Extend this class to add reports
 */
class Reports extends Behavior
{
    /**
     * @return mixed The Matomo version
     */
    public function version()
    {
        return $this->owner->call('API.getMatomoVersion');
    }
}
