# Tracking Client

The Tracking component provides simple integration of the [JavaScript Tracking Client](https://developer.matomo.org/guides/tracking-javascript-guide) into web pages.

## Configuration

Add the tracking component configuration to the components section of your config file:
 
```php
[
    'components' => [
        'tracking' => [
            'class' => '\BeastBytes\Matomo\Tracking\Tracking',
            // Array of Matomo tracking calls which should **not** be followed by the TrackPageView call
            'disableTrackPageView' => ['trackSiteSearch'],
            // Heartbeat timer in seconds. Zero disables the heartbeat timer. Default 15.
            'heartbeat' => 15,
            // Whether to use image tracking as a fallback if the client has Javascript disabled
            'imageTracking' => true,
            // Matomo PHP filename
            'matomoPhp' => 'matomo.php',
            // Matomo JavaScript filename
            'matomoJs' => 'matomo.js',
            // ID of the website to track
            'siteId' => 1,
            // Base URL for analytics with no scheme or trailing /
            'url' => 'matomo.mysite.com'
        ]
    ]    
]
```

Typically the only configuration parameters that need to be set are 'siteId' and 'url'.

## Useage

The Tracking component automatically adds the Matomo JavaScript tracking code to each page.

To add additional tracking calls, e.g. to track orders, make calls to the Tracking component; these are automatically added to the Matomo JavaScript tracking code for the page.

A call to the Tracking component is of the form:
```php
Yii::$app->tracking-><apiMethod>($model, $parameters);
```

$model can be an array or object.

$parameters is an array that tells the Tracking component how to assign values to the JavaScript Tracking API calls from the model. Parameters must be listed in the order required by the function; they are either:
* a string: if the string begins with ':' it is a string literal, else it is the attribute/key name in the model/array,
* an anonymous function: The function returns the parameter value; its signature is:
```php
function($model, $defaultValue)
```
* any other type - integer, float, or boolean: these are used "as is". Use boolean **false** for unused parameters

Make sure that the parameters are the type required by the JavaScript Tracking API - in particular, make sure booleans, floats, and integers are not strings.

#### Example

```php
Yii::$app->tracking->setEcommerceView($ecommerceItemModel, ['sku', 'name', ':The Category', function($model, null) {return (float)$model->price / 100;}]);
```

This calls the "setEcommerceView" Matomo JavaScript Tracking API function that tracks a view of a product; the parameter values are derived as follows:

* sku = $model->sku
* name = $model->name
* category = "The Category" as a string literal
* price = anonymous function converts the price from the currency minor unit (e.g. pence) as stored in the model, to the currency major unit (e.g. pounds) as required by Matomo and casts it to a float

## Convenience Methods

There are some convenience methods that simplfy e-commerce tracking even further, they are:
 * trackOrder()
 * trackCartUpdate()
 * addItems()
