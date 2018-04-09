<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "business".
 *
 * @property integer $id
 * @property string $name
 * @property string $short_name
 * @property integer $business_type
 * @property integer $brand_id
 * @property string $service_type
 * @property string $province
 * @property string $city
 * @property string $county
 * @property string $detail
 * @property string $phone
 * @property integer $join_time
 * @property integer $end_time
 * @property string $money
 * @property integer $pay_type
 * @property integer $user_id
 * @property integer $ctime
 * @property string $business_code
 * @property string $recommend_code
 */
class Business extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'business';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['business_type', 'brand_id', 'join_time', 'end_time', 'pay_type', 'user_id', 'ctime'], 'integer'],
            [['money'], 'number'],
            [['name', 'short_name', 'business_code', 'recommend_code'], 'string', 'max' => 100],
            [['service_type', 'detail'], 'string', 'max' => 255],
            [['province', 'city', 'county'], 'string', 'max' => 30],
            [['phone'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'short_name' => 'Short Name',
            'business_type' => 'Business Type',
            'brand_id' => 'Brand ID',
            'service_type' => 'Service Type',
            'province' => 'Province',
            'city' => 'City',
            'county' => 'County',
            'detail' => 'Detail',
            'phone' => 'Phone',
            'join_time' => 'Join Time',
            'end_time' => 'End Time',
            'money' => 'Money',
            'pay_type' => 'Pay Type',
            'user_id' => 'User ID',
            'ctime' => 'Ctime',
            'business_code' => 'Business Code',
            'recommend_code' => 'Recommend Code',
        ];
    }
    /*
     * type  1：商家提交   2：业务员提交
     * **/
    public function add($data,$type=1){
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->name = $data['name'];
            $this->short_name = $data['short_name'];
            $this->business_type = $data['business_type'];
            $this->brand_id = $data['brand_id'];
            $this->service_type = implode(',',$data['name']);
            $this->province = $data['province'];
            $this->county = $data['county'];
            $this->detail = $data['detail'];
            $this->phone = $data['phone'];
            $this->ctime = time();
            $this->business_code = $data['business_code'];
            $this->recommend_code = $data['recommend_code'];
            if($type!=1){
                //业务员提交内容
                $this->money = $data['money'];
                $this->pay_type = $data['pay_type'];
                $this->join_time = strtotime($data['join_time']);
                $this->end_time = strtotime($data['end_time']);
                $this->user_id = $data['uid'];
                //判断有没有注册用户  这个需要再确认一下
            }else{
                $this->saler_id = $data['uid'];
            }
            $status = $this->save();
            if($status===false){
                $transaction->rollBack();
                return false;
            }
            $transaction->commit();
            return true;
        }catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }

    }
    //修改
    public function edit($data){
        $obj = $this->find()->where(['id'=>$data['id']])->one();
        $obj->name = $data['name'];
        $obj->short_name = $data['short_name'];
        $obj->business_type = $data['business_type'];
        $obj->brand_id = $data['brand_id'];
        $obj->service_type = implode(',',$data['name']);
        $obj->province = $data['province'];
        $obj->county = $data['county'];
        $obj->detail = $data['detail'];
        $obj->phone = $data['phone'];
        return $obj->save();
    }
}
