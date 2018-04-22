<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $nickname
 * @property string $phone
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $level
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'auth_key', 'password_hash', 'created_at', 'updated_at'], 'required'],
            [['phone', 'role', 'status', 'created_at', 'updated_at', 'level'], 'integer'],
            [['nickname', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => 'Nickname',
            'phone' => 'Phone',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'role' => 'Role',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'level' => 'Level',
        ];
    }
    public function getInfo($uid){
        $info = $this->find()->where(['id'=>$uid])->asarray()->one();
        $field = Yii::$app->params['field_level'][$info['level']];
        if($field=='*'){
            return $info;
        }else{
            $result = [];
            foreach($info as $key=>$val){
                if(in_array($key,$field)){
                    $result[$key] = $val;
                }
            }
            return $result;
        }

    }
    public function getOne($uid,$field="*",$type=1){
        $userinfo = $this->find()->where(['id'=>$uid])->select($field)->asarray()->one();
        if($type==1)
            return $userinfo;
        else
            return $userinfo[$field];
    }
}
