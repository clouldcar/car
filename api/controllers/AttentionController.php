<?php

namespace api\controllers;

use Yii;
use api\models\Common;
use api\models\Attention;

class AttentionController extends BaseController
{
    public $enableCsrfValidation = false;
    //关注或取消关注
    /*
     * business_id  商家id
     * **/
    public function actionAttention(){
        $data = Common::testPost();
        $data['uid'] = $uid  = yii::$app->user->id;
        if(empty($uid)){
            Common::ReturnJson(201,'尚未登陆');
        }
        $Attention = new Attention();
        $arr = $Attention->attention($data);
        if($arr['status']){
            Common::ReturnJson(0,$arr['info'].'成功');
        }else{
            Common::ReturnJson(801,'无效操作');
        }
    }
    //我的关注列表
    public function actionList(){
        $uid = yii::$app->user->id;
        if(empty($uid)){
            Common::ReturnJson(201,'尚未登陆');
        }
        $Attention = new Attention();
        $list = $Attention->getList($uid);
        Common::ReturnJson(0,'',$list);
    }


}
