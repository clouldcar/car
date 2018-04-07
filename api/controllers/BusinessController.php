<?php
namespace api\controllers;

use Yii;
use yii\web\Response;
use api\models\Business;

/**
 * Business controller
 */
class BusinessController extends BaseController
{
    //提交信息
    /*
     * 商家提交
     * **/
    public function actionBusinessSubmit(){
        $post = Common::testPost();
        $uid = Yii::$app->user->id;
        $post['uid'] = $uid;
        $post['add_type'] = 1;
        $Business = new Business();
        $status = $Business->add($post);
        if($status){
            Common::ReturnJson(0,'提交成功');
        }else{
            Common::ReturnJson(801,'提交失败');
        }
    }
    /*
     * 商家修改
     * **/
    public function actionBusinessEdit(){
        $post = Common::testPost();
        $uid = Yii::$app->user->id;
        $Business = new Business();
        $status = $Business->edit($post);
        if($status!==false){
            Common::ReturnJson(0,'提交成功');
        }else{
            Common::ReturnJson(801,'提交失败');
        }
    }
    /*
     * 工作人员提交
     * **/
    public function actionStaffSubmit(){
        $post = Common::testPost();
        $uid = Yii::$app->user->id;
        $post['add_type'] = 2;
        $Business = new Business();
        $status = $Business->add($post,2);
        if($status){
            Common::ReturnJson(0,'提交成功');
        }else{
            Common::ReturnJson(801,'提交失败');
        }
    }


}