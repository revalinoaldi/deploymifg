<?php
namespace common\components;

use Yii;
use yii\base\Component;
use common\models\Settings;


class InitRoutines extends Component
{
    public function init()
    {
    	if(Yii::$app->session->get('language') == null){
    		Yii::$app->session->set('language', 'id');
    	}
        parent::init();
    }

    public function getSetting($keys){
    	return Settings::find()->where(['keys'=>$keys])->one()->value;
    }
}