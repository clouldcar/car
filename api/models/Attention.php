<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "attention".
 *
 * @property integer $id
 * @property integer $business_id
 * @property integer $user_id
 * @property integer $ctime
 */
class Attention extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attention';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['business_id', 'uid', 'ctime'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'business_id' => 'Business ID',
            'uid' => 'Uid',
            'ctime' => 'Ctime',
        ];
    }
    //关注或取消关注
    public function attention($data){
        $obj = $this->find()->where(['uid'=>$data['uid'],'business_id'=>$data['business_id']])->one();
        if(empty($obj)){
            $this->uid = $data['uid'];
            $this->business_id = $data['business_id'];
            $this->ctime = time();
            $status = $this->save();
            $info = '关注';
        }else{
            $status = $obj->delete();
            $info = '取消关注';
        }
        return ['status'=>$status,'info'=>$info];
    }
    //获取列表
    public function getList($uid){
        $list = $this->find()->from(self::tableName().' as a')
                        ->leftjoin(Business::tableName().' as b','b.uid=a.business_id')
                        ->leftjoin(Brand::tableName().' as br','br.id=b.brand_id')
                        ->where(['a.uid'=>$uid])
                        ->select('b.name,b.short_name')
                        ->asarray()
                        ->all();
        return $list;
    }
}
