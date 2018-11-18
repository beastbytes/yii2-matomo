<?php
/**
 * Piwik 3.0.* API methods
 * 
 * List of API methods and whether they require a date range
 *
 * @author    Chris Yates
 * @copyright Copyright &copy; 2017 BeastBytes - All Rights Reserved
 * @license   BSD 3-Clause
 * @package   Piwik
 */

$api = [
    'API' => [
        'getPiwikVersion'              => false,
        'getIpFromHeader'              => false,
        'getSettings'                  => false,
        'getMetadata'                  => false,
        'getReportMetadata'            => true,
        'getProcessedReport'           => true,
        'getReportPagesMetadata'       => false,
        'getWidgetMetadata'            => false,
        'get'                          => true,
        'getRowEvolution'              => true,
        'getBulkRequest'               => false,
        'isPluginActivated'            => false,
        'getSuggestedValuesForSegment' => false,
        'getGlossaryReports'           => false,
        'getGlossaryMetrics'           => false
    ],
    'Actions' => [
        'get'                              => true,
        'getPageUrls'                      => true,
        'getPageUrlsFollowingSiteSearch'   => true,
        'getPageTitlesFollowingSiteSearch' => true,
        'getEntryPageUrls'                 => true,
        'getExitPageUrls'                  => true,
        'getPageUrl'                       => true,
        'getPageTitles'                    => true,
        'getEntryPageTitles'               => true,
        'getExitPageTitles'                => true,
        'getPageTitle'                     => true,
        'getDownloads'                     => true,
        'getDownload'                      => true,
        'getOutlinks'                      => true,
        'getOutlink'                       => true,
        'getSiteSearchKeywords'            => true,
        'getSiteSearchNoResultKeywords'    => true,
        'getSiteSearchCategories'          => true
    ],
    'Annotations' => [
        'add'                        => true,
        'save'                       => true,
        'delete'                     => false,
        'deleteAll'                  => false,
        'get'                        => false,
        'getAll'                     => true,
        'getAnnotationCountForDates' => true
    ],
    'Contents' => [
        'getContentNames'  => true,
        'getContentPieces' => true
    ],
    'CoreAdminHome' => [
        'runScheduledTasks'         => false,
        'invalidateArchivedReports' => true,
        'runCronArchiving'          => false
    ],
    'CustomPiwikJs' => [
        'doesIncludePluginTrackersAutomatically' => false
    ],
    'CustomVariables' => [
        'getCustomVariables'                 => false,
        'getCustomVariablesValuesFromNameId' => true,
        'getUsagesOfSlots'                   => false
    ],
    'DBStats' => [
        'getGeneralInformation'       => false,
        'getDBStatus'                 => false,
        'getDatabaseUsageSummary'     => false,
        'getTrackerDataSummary'       => false,
        'getMetricDataSummary'        => false,
        'getMetricDataSummaryByYear'  => false,
        'getReportDataSummary'        => false,
        'getReportDataSummaryByYear'  => false,
        'getAdminDataSummary'         => false,
        'getIndividualReportsSummary' => false,
        'getIndividualMetricsSummary' => false
    ],
    'Dashboard' => [
        'getDashboards' => false
    ],
    'DevicePlugins' => [
        'getPlugin' => true
    ],
    'DevicesDetection' => [
        'getType'            => true,
        'getBrand'           => true,
        'getModel'           => true,
        'getOsFamilies'      => true,
        'getOsVersions'      => true,
        'getBrowsers'        => true,
        'getBrowserVersions' => true,
        'getBrowserEngines'  => true
    ],
    'Events' => [
        'getCategory'             => true,
        'getAction'               => true,
        'getName'                 => true,
        'getActionFromCategoryId' => true,
        'getNameFromCategoryId'   => true,
        'getCategoryFromActionId' => true,
        'getNameFromActionId'     => true,
        'getActionFromNameId'     => true,
        'getCategoryFromNameId'   => true
    ],
    'ExampleAPI' => [
        'getPiwikVersion'                => false,
        'getAnswerToLife'                => false,
        'getObject'                      => false,
        'getSum'                         => false,
        'getNull'                        => false,
        'getDescriptionArray'            => false,
        'getCompetitionDatatable'        => false,
        'getMoreInformationAnswerToLife' => false,
        'getMultiArray'                  => false
    ],
    'ExamplePlugin' => [
        'getAnswerToLife'  => false,
        'getExampleReport' => true
    ],
    'ExampleReport' => [
        'getExampleReport' => true
    ],
    'ExampleUI' => [
        'getTemperaturesEvolution' => true,
        'getTemperatures'          => false,
        'getPlanetRatios'          => false,
        'getPlanetRatiosWithLogos' => false
    ],
    'Feedback' => [
        'sendFeedbackForFeature' => false
    ],
    'Goals' => [
        'getGoal'                  => false,
        'getGoals'                 => false,
        'addGoal'                  => false,
        'updateGoal'               => false,
        'deleteGoal'               => false,
        'getItemsSku'              => true,
        'getItemsName'             => true,
        'getItemsCategory'         => true,
        'get'                      => true,
        'getDaysToConversion'      => true,
        'getVisitsUntilConversion' => true
    ],
    'ImageGraph' => [
        'get'
    ],
    'Insights' => [
        'canGenerateInsights'         => true,
        'getInsightsOverview'         => true,
        'getMoversAndShakersOverview' => true,
        'getMoversAndShakers'         => true,
        'getInsights'                 => true
    ],
    'LanguagesManager' => [
        'isLanguageAvailable'        => false,
        'getAvailableLanguages'      => false,
        'getAvailableLanguagesInfo'  => false,
        'getAvailableLanguageNames'  => false,
        'getTranslationsForLanguage' => false,
        'getLanguageForUser'         => false,
        'setLanguageForUser'         => false,
        'uses12HourClockForUser'     => false,
        'set12HourClockForUser'      => false
    ],
    'Live' => [
        'getCounters'            => false,
        'getLastVisitsDetails'   => true,
        'getVisitorProfile'      => false,
        'getMostRecentVisitorId' => false
    ],
    'Marketplace' => [
        'deleteLicenseKey' => false,
        'saveLicenseKey'   => false
    ],
    'MobileMessaging' => [
        'areSMSAPICredentialProvided' => false,
        'getSMSProvider'              => false,
        'setSMSAPICredential'         => false,
        'addPhoneNumber'              => false,
        'getCreditLeft'               => false,
        'removePhoneNumber'           => false,
        'validatePhoneNumber'         => false,
        'deleteSMSAPICredential'      => false,
        'setDelegatedManagement'      => false,
        'getDelegatedManagement'      => false
    ],
    'MultiSites' => [
        'getAll' => true,
        'getOne' => true
    ],
    'Overlay' => [
        'getTranslations'            => false,
        'getExcludedQueryParameters' => false,
        'getFollowingPages'          => true
    ],
    'Provider' => [
        'getProvider' => true
    ],
    'Referrers' => [
        'getReferrerType'                  => true,
        'getAll'                           => true,
        'getKeywords'                      => true,
        'getKeywordsForPageUrl'            => true,
        'getKeywordsForPageTitle'          => true,
        'getSearchEnginesFromKeywordId'    => true,
        'getSearchEngines'                 => true,
        'getKeywordsFromSearchEngineId'    => true,
        'getCampaigns'                     => true,
        'getKeywordsFromCampaignId'        => true,
        'getWebsites'                      => true,
        'getUrlsFromWebsiteId'             => true,
        'getSocials'                       => true,
        'getUrlsForSocial'                 => true,
        'getNumberOfDistinctSearchEngines' => true,
        'getNumberOfDistinctKeywords'      => true,
        'getNumberOfDistinctCampaigns'     => true,
        'getNumberOfDistinctWebsites'      => true,
        'getNumberOfDistinctWebsitesUrls'  => true
    ],
    'Resolution' => [
        'getResolution'    => true,
        'getConfiguration' => true
    ],
    'SEO' => [
        'getRank' => false
    ],
    'ScheduledReports' => [
        'addReport'      => false,
        'updateReport'   => false,
        'deleteReport'   => false,
        'getReports'     => true,
        'generateReport' => true,
        'sendReport'     => true
    ],
    'SegmentEditor' => [
        'isUserCanAddNewSegment' => false,
        'delete'                 => false,
        'update'                 => false,
        'add'                    => false,
        'get'                    => false,
        'getAll'                 => false
    ],
    'SitesManager' => [
        'getJavascriptTag'                       => false,
        'getImageTrackingCode'                   => false,
        'getSitesFromGroup'                      => false,
        'getSitesGroups'                         => false,
        'getSiteFromId'                          => false,
        'getSiteUrlsFromId'                      => false,
        'getAllSites'                            => false,
        'getAllSitesId'                          => false,
        'getSitesWithAdminAccess'                => false,
        'getSitesWithViewAccess'                 => false,
        'getSitesWithAtLeastViewAccess'          => false,
        'getSitesIdWithAdminAccess'              => false,
        'getSitesIdWithViewAccess'               => false,
        'getSitesIdWithAtLeastViewAccess'        => false,
        'getSitesIdFromSiteUrl'                  => false,
        'addSite'                                => false,
        'getSiteSettings'                        => false,
        'deleteSite'                             => false,
        'addSiteAliasUrls'                       => false,
        'setSiteAliasUrls'                       => false,
        'getIpsForRange'                         => false,
        'setGlobalExcludedIps'                   => false,
        'setGlobalSearchParameters'              => false,
        'getSearchKeywordParametersGlobal'       => false,
        'getSearchCategoryParametersGlobal'      => false,
        'getExcludedQueryParametersGlobal'       => false,
        'getExcludedUserAgentsGlobal'            => false,
        'setGlobalExcludedUserAgents'            => false,
        'isSiteSpecificUserAgentExcludeEnabled'  => false,
        'setSiteSpecificUserAgentExcludeEnabled' => false,
        'getKeepURLFragmentsGlobal'              => false,
        'setKeepURLFragmentsGlobal'              => false,
        'setGlobalExcludedQueryParameters'       => false,
        'getExcludedIpsGlobal'                   => false,
        'getDefaultCurrency'                     => false,
        'setDefaultCurrency'                     => false,
        'getDefaultTimezone'                     => false,
        'setDefaultTimezone'                     => false,
        'updateSite'                             => false,
        'getCurrencyList'                        => false,
        'getCurrencySymbols'                     => false,
        'isTimezoneSupportEnabled'               => false,
        'getTimezonesList'                       => false,
        'getUniqueSiteTimezones'                 => false,
        'renameGroup'                            => false,
        'getPatternMatchSites'                   => false,
        'getNumWebsitesToDisplayPerPage'         => false
    ],
    'Transitions' => [
        'getTransitionsForPageTitle' => true,
        'getTransitionsForPageUrl'   => true,
        'getTransitionsForAction'    => true,
        'getTranslations'            => false
    ],
    'UserCountry' => [
        'getCountry'                   => true,
        'getContinent'                 => true,
        'getRegion'                    => true,
        'getCity'                      => true,
        'getCountryCodeMapping'        => false,
        'getLocationFromIP'            => false,
        'setLocationProvider'          => false,
        'getNumberOfDistinctCountries' => true
    ],
    'UserId' => [
        'getUsers' => true
    ],
    'UserLanguage' => [
        'getLanguage'     => true,
        'getLanguageCode' => true
    ],
    'UsersManager' => [
        'setUserPreference'             => false,
        'getUserPreference'             => false,
        'getUsers'                      => false,
        'getUsersLogin'                 => false,
        'getUsersSitesFromAccess'       => false,
        'getUsersAccessFromSite'        => false,
        'getUsersWithSiteAccess'        => false,
        'getSitesAccessFromUser'        => false,
        'getUser'                       => false,
        'getUserByEmail'                => false,
        'addUser'                       => false,
        'setSuperUserAccess'            => false,
        'hasSuperUserAccess'            => false,
        'getUsersHavingSuperUserAccess' => false,
        'regenerateTokenAuth'           => false,
        'updateUser'                    => false,
        'deleteUser'                    => false,
        'userExists'                    => false,
        'userEmailExists'               => false,
        'getUserLoginFromUserEmail'     => false,
        'setUserAccess'                 => false,
        'createTokenAuth'               => false,
        'getTokenAuth'                  => false
    ],
    'VisitFrequency' => [
        'get' => true
    ],
    'VisitTime' => [
        'getByDayOfWeek'                   => true,
        'getVisitInformationPerLocalTime'  => true,
        'getVisitInformationPerServerTime' => true
    ],
    'VisitorInterest' => [
        'getNumberOfVisitsPerVisitDuration' => true,
        'getNumberOfVisitsPerPage'          => true,
        'getNumberOfVisitsByDaysSinceLast'  => true,
        'getNumberOfVisitsByVisitCount'     => true
    ],
    'VisitsSummary' => [
        'get'                      => true,
        'getVisits'                => true,
        'getUniqueVisitors'        => true,
        'getUsers'                 => true,
        'getActions'               => true,
        'getMaxActions'            => true,
        'getBounceCount'           => true,
        'getVisitsConverted'       => true,
        'getSumVisitsLength'       => true,
        'getSumVisitsLengthPretty' => true
    ]
];
