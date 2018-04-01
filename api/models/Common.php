<?php

namespace api\models;

use Yii;

class Common extends \yii\db\ActiveRecord
{
    public $enableCsrfValidation = false;


	//转换结果为空数据防止报错
	public static function ReturnJson($code,$message="",$data=[]){
	    if(empty($message)){
	        $arr = ['err'=>$code,'data'=>$data];
        }else{
	        $arr = ['err'=>$code,'message'=>$message];
        }
	    exit(\str_replace(':null', ':""', json_encode($arr)));
	}


	public static function testPost($flag=false){
        if($flag){
            $data = Yii::$app->request->get();
            return $data;
        }else{
            if(Yii::$app->request->isPost){
                $data = Yii::$app->request->post();
				return $data;
            }else{
                self::ReturnJson(801,'非法操作');
            }
        }
	}
	public static function getError($model){
        if( !$model->validate()) {
            $tmp_earr     = $model->getFirstErrors();
            foreach( $model->activeAttributes() as $ati ) {
                if( isset( $tmp_earr[$ati] ) && !empty( $tmp_earr[$ati] ) )
                    exit($tmp_earr[$ati]);
            }
        }
    }

}
