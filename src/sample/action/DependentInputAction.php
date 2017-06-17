<?php
/**
 * Created by PhpStorm.
 * User: smladeoye
 * Date: 6/17/2017
 * Time: 3:12 PM
 */

namespace smladeoye\dependentinput\sample\action;

use Yii;
use yii\base\Action;

class DependentInputAction extends Action
{
    public function run()
    {
        Yii::setAlias('@smladeoye-dependentinput-sample', realpath(__DIR__ . '/../'));

        $request = Yii::$app->getRequest();
        if ($request->isGet && $request->get('params') !== null) {
            //debug($request->get());
            $params = $request->get('params');
            $input1 = $params['input1'];
            $input2 = $params['input2'];
            if (!empty($input1))
            {
                if ($input1 == 1)
                    echo json_encode(['1'=>'option from input1 with value of 1']);
                else
                    echo json_encode(['2'=>'option from input1 with value of 2']);
            }
            elseif (!empty($input2))
            {
                echo "alue is $input2";
            }
            return;
        }
        return $this->controller->render('@smladeoye-dependentinput-sample/views/index.php');
    }

}