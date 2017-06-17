<?php
/**
 * Created by PhpStorm.
 * User: smladeoye
 * Date: 5/22/2017
 * Time: 3:39 PM
 */

namespace smladeoye\dependentinput;

use yii\web\AssetBundle;

class DependentInputAsset extends AssetBundle
{
    public $sourcePath = __DIR__.DIRECTORY_SEPARATOR.'assets';

    public $css = [];

    public $js = [
        YII_DEBUG?'js/jquery-loading-overlay/src/loadingoverlay.js':'js/jquery-loading-overlay/src/loadingoverlay.min.js'
    ];

    public $jsOptions = [
        //'position' => View::POS_
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    /**
     * @inheritdoc
     */

    public function init()
    {
        parent::init();
    }
}