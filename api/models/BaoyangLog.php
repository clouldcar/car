<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "baoyang_log".
 *
 * @property integer $id
 * @property integer $car_id
 * @property integer $car_type
 * @property integer $licheng
 * @property string $baoyang_date
 * @property integer $ctime
 * @property string $labor_cost
 * @property string $material_cost
 */
class BaoyangLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'baoyang_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['car_id', 'type', 'licheng'], 'integer'],
            [['baoyang_date','ctime'], 'safe'],
            [['labor_cost', 'material_cost'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'car_id' => 'Car ID',
            'type' => 'Type',
            'licheng' => 'Licheng',
            'baoyang_date' => 'Baoyang Date',
            'ctime' => 'Ctime',
            'labor_cost' => 'Labor Cost',
            'material_cost' => 'Material Cost',
        ];
    }
    public function add($data){
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->uid = $data['uid'];
            $this->car_id = $data['car_id'];
            $this->type = $data['type'];
            $this->licheng = $data['licheng'];
            $this->baoyang_date = $data['baoyang_date'];
            $this->ctime = date('Y-m-d H:i:s');
            $this->labor_cost = $data['labor_cost'];
            $this->material_cost = $data['material_cost'];
            $this->content = $data['content'];
            $status = $this->save();
            if($status===false){
                echo 22;
                $transaction->rollBack();
                return false;
            }
            $Baoyang_obj = Baoyang::find()->where(['uid'=>$data['uid'],'car_id'=>$data['car_id'],'type'=>$data['type']])->one();
            $Baoyang_obj->last_licheng = $data['licheng'];
            $Baoyang_obj->last_date = $data['baoyang_date'];

            $status = $Baoyang_obj->save();
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
    //保养记录
    public function getList($data,$page=1,$pagesize=10){
        $obj = $this->find()->from(self::tableName().' as log')
            ->leftjoin(BaoyangType::tableName().' as type','type.id=log.type')
            ->where(['log.car_id'=>$data['car_id'],'log.uid'=>$data['uid']]);
        if(!empty($data['type'])){
            $obj->andWhere(['log.type'=>$data['type']]);
        }
        $list = $obj->select('type.name,log.licheng,log.baoyang_date,log.labor_cost,log.material_cost,log.content')
            ->offset(($page-1)*$pagesize)
            ->limit($pagesize)
            ->asarray()
            ->all();
        return $list;
    }
}
