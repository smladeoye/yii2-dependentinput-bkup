# yii2-dependentinput
YII 2 Dependent Form-Input Control Widget

- [Installation] (https://github.com/smladeoye/yii2-dependentinput#installation)
- [Usage] (https://github.com/smladeoye/yii2-dependentinput#usage)


## Installation

The preferred way to install this extension is through composer.

Either run

```bash
composer require smladeoye/yii2-dependentinput
```

**or**

add '"smladeoye/yii2-dependentinput": "1.0.0"' to the require section of your composer.json file, then run:

```bash
composer install
```

## Usage Example

To use the widget, simply call it from your view and pass it the required parameters;
Example:

```php


    echo DependentInputWidget::widget(
    [
        // set to true to display the default loader when ajax request is being made
        'displayLoader' => true,

        // settings for the widget dependent element
        // this can be an array containg an array of settings or just one array with the setting
        'options' => [
            [
                // the dependent element type
                'type' => 'select',

                // the dependent element parent/parents id without the #
                'parent' => ['input1' => 'input1'],

                // the dependent element id without the #
                'child' => 'input2',

                // the url used for the ajax request
                'url' => Url::to(),
            ],
            // another dependent element settings
            [
                'type' => 'text',
                'parent' => ['input2'=>'input2'],
                'child' => 'input3',
                'url' => Url::to(),
                // you can set this value in cases where the dependent is an input and you
                // want to modify some attributes with the gotten result
                'resultAttr' => ['max'],
                // you can also set the element attributes
                'elementAttr' => ['max' => 0, 'value' => 'sweet', 'min' => 0]
            ],
        ],
    ]
    );
?>

```

There are seven operations available that can be performed which have been grouped based on Paystack's own grouping.
Each of the operations also have their individual methods that can be called for performing different actions
(create, list -- fetchAll, fetch, update,...) which can accept all the necessary parameters as an array.

The following are the available operations and methods (all sample codes are based on the demo configuration above):


1. **customer**:   To initiatiate any customer operation: