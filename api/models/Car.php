<?php

namespace api\models;

use Yii;
/**
 * This is the model class for table "car".
 *
 * @property string $id
 * @property integer $uid
 * @property string $plate_number
 * @property string $brand
 * @property string $color
 * @property string $type
 * @property string $licheng
 * @property string $chejian_date
 * @property string $chejian_cycle
 * @property string $chexian_date
 * @property string $chexian_cycle
 * @property string $reg_year
 * @property string $ctime
 */
class Car extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'plate_number', 'brand', 'color', 'type', 'licheng', 'chejian_date', 'chejian_cycle', 'chexian_date', 'chexian_cycle', 'reg_year', 'ctime'], 'required'],
            [['uid'], 'integer'],
            [['chejian_date', 'chexian_date', 'ctime'], 'safe'],
            [['plate_number', 'brand', 'color', 'type', 'licheng', 'chejian_cycle', 'chexian_cycle', 'reg_year'], 'string', 'max' => 255],
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
            'plate_number' => 'Plate Number',
            'brand' => 'Brand',
            'color' => 'Color',
            'type' => 'Type',
            'licheng' => 'Licheng',
            'chejian_date' => 'Chejian Date',
            'chejian_cycle' => 'Chejian Cycle',
            'chexian_date' => 'Chexian Date',
            'chexian_cycle' => 'Chexian Cycle',
            'reg_year' => 'Reg Year',
            'ctime' => 'Ctime',
        ];
    }
}
