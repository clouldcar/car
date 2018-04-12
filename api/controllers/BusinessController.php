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
     * name  商家名称
     * short_name  商家简称
     * business_type   商家类型   1：4S店  2：修配厂  3：汽车美容  4：轮胎服务  5：汽车配件  6：洗车店  7：汽车俱乐部  8：汽车救援  9：二手车  10：其他
     * brand_id  品牌id
     * service_type  服务类型  字符串逗号分隔
     * province  省
     * city   市
     * county  县
     * detail  详细地址
     * phone   手机号
     * business_code  业务编码
     * recommend_code   推荐编码
     * **/
    public function actionBusinessSubmit(){
        $post = Common::testPost();
        Common::checkMustParams($post,['name','short_name','business_type','brand_id','service_type','province','city','county','detail','phone']);
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
    /*
     * name  商家名称
     * short_name  商家简称
     * business_type   商家类型   1：4S店  2：修配厂  3：汽车美容  4：轮胎服务  5：汽车配件  6：洗车店  7：汽车俱乐部  8：汽车救援  9：二手车  10：其他
     * brand_id  品牌id
     * service_type  服务类型  字符串逗号分隔
     * province  省
     * city   市
     * county  县
     * detail  详细地址
     * phone   手机号
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
    //工作人员提交
    /*
     * name  商家名称
     * short_name  商家简称
     * business_type   商家类型   1：4S店  2：修配厂  3：汽车美容  4：轮胎服务  5：汽车配件  6：洗车店  7：汽车俱乐部  8：汽车救援  9：二手车  10：其他
     * brand_id  品牌id
     * service_type  服务类型  字符串逗号分隔
     * province  省
     * city   市
     * county  县
     * detail  详细地址
     * phone   手机号
     * business_code  业务编码
     * recommend_code   推荐编码
     * money  缴纳金额
     * pay_type  支付方式  1：现金  2：手机支付
     * join_time  入驻时间
     * end_time   到期时间
     * **/
    public function actionStaffSubmit(){
        $post = Common::testPost();
        Common::checkMustParams($post,['name','short_name','business_type','brand_id','service_type','province','city','county','detail','phone','money','pay_type','join_time','end_time']);
        $post['uid'] = $uid = Yii::$app->user->id;
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