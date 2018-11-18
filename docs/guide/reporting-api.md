# Reporting API

The Reporting component provides simple integration of the [Reporting API](https://developer.matomo.org/guides/querying-the-reporting-api).

There are two versions of the reporting component: one for use when Matomo is on the same server as the application - this uses PHP to access the API; the other for use when Matomo is on a remote server - this uses HTTP to access the API.

## Configuration

Add the reporting component configuration to the components section of your config file:

### Configuration for Matomo on the local server
```php
[
    'components' => [
        'analytics' => [
            'class' => '\BeastBytes\Matomo\Reporting\Local',
            // Matomo API authorisation token,
            'authToken' = '<token_auth>',
            // Date(s) of the report
            'date' => 'last1',
            // Response format. If not given reports are returned as a PHP array. See the Reporting API Reference (https://developer.matomo.org/api-reference/reporting-api) for valid formats
            'format' => '<format>',
            // Default period of the report
            'period' => 'month',
            // Path to behavior providing high-level reporting methods
            'reports' => '\BeastBytes\Matomo\Reporting\Reports',
            // ID of the website to track
            'siteId' => 1,
            
            // Specific to Local            
            // Matomo include path
            'includePath' => '@webroot/../analytics',
            // Matomo entry file relative to includePath
            'Matomo' => 'index.php',
            // Matomo reporting API entry point relative to includePath
            'request' => 'core/API/Request.php',
        ]
    ]    
]
```

### Configuration for Matomo on a remote server
```php
[
    'components' => [
        'analytics' => [
            'class' => '\BeastBytes\Matomo\Reporting\Remote',
            // Matomo API authorisation token,
            'authToken' = '<token_auth>',
            // Date(s) of the report
            'date' => 'today',
            // Response format. If not given reports are returned as a PHP array. See the Reporting API Reference (https://developer.Matomo.org/api-reference/reporting-api) for valid formats
            'format' => '<format>',
            // Default period of the report
            'period' => 'month',
            // Path to behavior providing high-level reporting methods
            'reports' => '\BeastBytes\Matomo\Reporting\Reports',
            // ID of the website to track
            'siteId' => 1,
            
            // Specific to Remote  
            // URL Matomo remote server
            'url' => 'https://Matomo.mysite.com'
        ]
    ]    
]
```

## Useage

To call a reporting API method:

```php
$report = Yii::$app->analytics->call($method, $params);
```

$method is the name of the report method, e.g. "VisitsSummary.get"

$parameters is an array of parameters for the method as key=>value pairs
