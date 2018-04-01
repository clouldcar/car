<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "baoyang_type".
 *
 * @property integer $id
 * @property string $name
 */
class BaoyangType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'baoyang_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
        ];
    }
    public function getIndexList($car_id,$licheng){
        $list = $this->find()->asarray()->all();
        $empty_arr = [];
        $unempty_arr = [];
        foreach($list as $key=>&$val){
            $baoyang_info = Baoyang::find()->where(['car_id'=>$car_id,'type'=>$val['id']])->asarray()->one();
            if(empty($baoyang_info)){
                $val['is_set'] = 0;
                $empty_arr[] = $val;
            }else{
                //显示是否是红的
                if(time()-strtotime($baoyang_info['last_date'])<30*86400||$licheng-$baoyang_info['last_licheng']-$baoyang_info['zhouqi']<20){
                    $val['red'] = 1;
                }else{
                    $val['red'] = 0;
                }
                //显示天数
                $val['day'] = floor((time()-strtotime($baoyang_info['last_date']))/86400);
                //显示百分数
                if($licheng - $baoyang_info['last_licheng']<=0){
                    $val['percent'] = 0;
                }else{
                    $val['percent'] = round(($licheng-$baoyang_info['last_licheng'])/$baoyang_info['zhouqi'],2);
                }
                $val['is_set'] = 1;
                $unempty_arr[] = $val;
            }

        }
        return array_merge($unempty_arr,$empty_arr);
    }
}
