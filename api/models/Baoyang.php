<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "baoyang".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $car_id
 * @property integer $type
 * @property integer $last_licheng
 * @property integer $zhouqi
 * @property string $last_date
 * @property string $content
 */
class Baoyang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'baoyang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'uid', 'car_id', 'type', 'last_licheng', 'zhouqi', 'last_date', 'content'], 'required'],
            [[ 'uid', 'car_id', 'type', 'last_licheng', 'zhouqi'], 'integer'],
            [['last_date'], 'safe'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'car_id' => 'Car ID',
            'type' => 'Type',
            'last_licheng' => 'Last Licheng',
            'zhouqi' => 'Zhouqi',
            'last_date' => 'Last Date',
            'content' => 'Content',
        ];
    }
    public function add($data){
        $this->uid = $data['uid'];
        $this->car_id = $data['car_id'];
        $this->type = $data['type'];
        $this->last_licheng = $data['last_licheng'];
        $this->zhouqi = $data['zhouqi'];
        $this->last_date = $data['last_date'];
        $this->content = $data['content'];
        $this->month_space = $data['month_space'];
        $this->ctime = date('Y-m-d H:i:s');
        return $this->save();
    }
}
