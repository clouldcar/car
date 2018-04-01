<?php

namespace api\controllers;

use Yii;
use yii\web\Controller;
//use common\models\Baoyang;
use api\models\Baoyang;
use api\models\BaoyangType;
use api\models\BaoyangLog;
use api\models\Common;
use api\models\Car;


class BaoyangController extends Controller
{
    public $enableCsrfValidation = false;
//    public function actionIndex()
//    {
//        return $this->render('index');
//    }

    public function actionList()
    {
        $uid = yii::$app->user->id;

        $res = Baoyang::getBaoyangList($uid);

        return ["data" => 'aaaaa', "uid" => $uid];
    }
    //设定保养类型初始值
    /*
     * car_id  汽车id
     * type   保养类型
     * last_licheng  上次保养里程
     * zhouqi  保养周期
     * last_date  上次保养日期
     * month_space   保养间隔   /月
     * content   备注
     * http://car.cn/baoyang/set-start-value?car_id=2&type=4&last_licheng=50&zhouqi=50&last_date=2018-3-1&month_space=3&content=测试
     * **/
    public function actionSetStartValue(){
        $data = Common::testPost();
        $uid = yii::$app->user->id;
        $car_info = Car::find()->where(['id'=>$data['car_id'],'uid'=>$uid])->asarray()->one();
        if(empty($car_info)){
            Common::ReturnJson(100,'请求car_id参数无效');
        }
        $baoyang_info = Baoyang::find()->where(['uid'=>$uid,'car_id'=>$data['car_id'],'type'=>$data['type']])->asarray()->one();
        if(!empty($baoyang_info)){
            Common::ReturnJson(100,'请求保养类型参数无效');
        }
        $baoyang_type_info = BaoyangType::find()->where(['id'=>$data['type']])->asarray()->one();
        if(empty($baoyang_type_info)){
            Common::ReturnJson(100,'请求保养类型参数无效');
        }
        $data['uid'] = $uid;
        $Baoyang = new Baoyang();
        $status = $Baoyang->add($data);
        if($status){
            Common::ReturnJson(0,'设定成功');
        }else{
            Common::ReturnJson(801,'无效操作');
        }
    }
    //设定保养
    /*
     * car_id  汽车id
     * type   保养类型
     * licheng  上次保养里程
     * baoyang_date  保养日期
     * labor_cost  人工费
     * material_cost   材料费
     * content   备注
     * http://car.cn/baoyang/set-baoyang-value?car_id=2&type=4&licheng=50&baoyang_date=2018-3-2&labor_cost=30.2&material_cost=30.2&content=测试
     * **/
    public function actionSetBaoyangValue(){
        $data = Common::testPost();
        $uid = yii::$app->user->id;
//            $data = Yii::$app->request->post();
        $car_info = Car::find()->where(['id'=>$data['car_id'],'uid'=>$uid])->asarray()->one();
        if(empty($car_info)){
            Common::ReturnJson(100,'请求car_id参数无效');
        }
        $baoyang_info = Baoyang::find()->where(['uid'=>$uid,'car_id'=>$data['car_id'],'type'=>$data['type']])->asarray()->one();
        if(empty($baoyang_info)){
            Common::ReturnJson(100,'请求保养类型参数无效');
        }
        $baoyang_type_info = BaoyangType::find()->where(['id'=>$data['type']])->asarray()->one();
        if(empty($baoyang_type_info)){
            Common::ReturnJson(100,'请求保养类型参数无效');
        }
        $data['uid'] = $uid;
        $BaoyangLog = new BaoyangLog();
        $status = $BaoyangLog->add($data);
        if($status){
            Common::ReturnJson(0,'设定成功');
        }else{
            Common::ReturnJson(801,'无效操作');
        }
    }
    //保养记录
    /*
     * car_id  汽车id
     * type    类型  所有项目的时候传0
     * page   分页
     * http://car.cn/baoyang/get-record?car_id=2&type=0&page=1
     * **/
    public function actionGetRecord(){
        $data = Common::testPost(1);
        $uid = yii::$app->user->id;
        $car_info = Car::find()->where(['id'=>$data['car_id'],'uid'=>$uid])->asarray()->one();
        if(empty($car_info)){
            Common::ReturnJson(100,'请求car_id参数无效');
        }
        if(!empty($data['type'])){
            $baoyang_type_info = BaoyangType::find()->where(['id'=>$data['type']])->asarray()->one();
            if(empty($baoyang_type_info)){
                Common::ReturnJson(100,'请求保养类型参数无效');
            }
        }

        $data['uid'] = $uid;
        $BaoyangLog = new BaoyangLog();
        $page = empty($data['page'])?1:$data['page'];
        $list = $BaoyangLog->getList($data,$page,10);
        Common::ReturnJson(0,'',$list);
    }
    //获取类型记录
    /*
     * car_id  汽车id
     * licheng  当前里程
     * http://car.cn/baoyang/index?car_id=2&licheng=70
     * **/
    public function actionIndex(){
        $data = Common::testPost(1);
        $uid = yii::$app->user->id;
        $car_info = Car::find()->where(['id'=>$data['car_id'],'uid'=>$uid])->asarray()->one();
        if(empty($car_info)){
            Common::ReturnJson(100,'请求car_id参数无效');
        }
        $BaoyangType = new BaoyangType();
        $list = $BaoyangType->getIndexList($data['car_id'],$data['licheng']);
        Common::ReturnJson(0,'',$list);
    }
}


