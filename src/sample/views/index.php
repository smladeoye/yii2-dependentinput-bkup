<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use smladeoye\dependentinput\DependentInputWidget;

?>
    <div>
        <?= Html::beginForm();  ?>

        <div>
            <?= Html::dropDownList('input1','',['1'=>'ONE','2'=>'TWO'],['id'=>'input1']) ?>
        </div>

        <div>
            <?= Html::dropDownList('input2','',[],['empty'=>'select ...','id'=>'input2']) ?>
        </div>

        <div>
            <?= Html::textInput('input3','', ['empty'=>'select ...','id'=>'input3']) ?>
        </div>

        <?= Html::endForm();  ?>
    </div>
<?php
$action = Yii::$app->controller->action;
echo DependentInputWidget::widget(
    [
        'displayLoader' => true,
        'options' => [
            [
                //'type' => 'text',
                'parent' => ['input1' => 'input1'],
                'child' => 'input2',
                'url' => Url::to(),
            ],
            [
                'type' => 'text',
                'parent' => ['input2'=>'input2'],
                'child' => 'input3',
                'url' => Url::to(),
                'resultAttr' => ['max'],
                'elementAttr' => ['max' => 0, 'value' => 'sweet', 'min' => 0]
            ],
        ],
    ]
);
?>