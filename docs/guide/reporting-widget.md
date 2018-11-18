# Reporting Widget

The Reporting widget simplifies the integration of [Matomo Reporting Widgets](https://developer.matomo.org/guides/widgets) into web pages.

## Useage
Matomo widgets are used in view files.

Add the following to autoload the widget.
```php
use BeastBytes\Matomo\Reporting\Widget as Matomo;
```

To display the widget add the following code
```php
echo Matomo::widget([
    'authToken' => '<token_auth>', // From Matomo admin
    'container' => 'VisitOverviewWithGraph',
    'options'   => ['class' => 'matomo-widget'],
    'siteId'    => 1,
    'url'       => '<Matomo URL>'
]);
```

or

```php
echo Matomo::widget([
    'action'    => 'getItemsName',
    'authToken' => '<token_auth>', // From Matomo admin
    'module'    => 'Goals',
    'options'   => ['class' => 'matomo-widget'],
    'siteId'    => 1,
    'url'       => '<Matomo URL>'
]);
```

Which one to use depends on the underlying Matomo widget. To determine which is the correct form take a look at the code for the widget from the Widgets page in the Matomo admin; if the code contains "containerId" use the first version and use the value of "containerID" for "container", else use the values from "actionToWidgetize" and "moduleToWidgetize" for "action" and "module" respectively in the second version.
