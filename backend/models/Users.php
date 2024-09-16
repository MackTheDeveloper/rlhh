<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $mobile
 * @property string $type
 * @property string $created
 * @property string $updated
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'password'], 'required'],
            [['type'], 'string'],
            [['created', 'updated','password_reset_token'], 'safe'],
            [['first_name', 'last_name', 'email', 'password'], 'string', 'max' => 255],
            ['email','unique'],
            ['email','email'],
            [['mobile'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yii', 'ID'),
            'first_name' => Yii::t('yii', 'First Name'),
            'last_name' => Yii::t('yii', 'Last Name'),
            'email' => Yii::t('yii', 'Email'),
            'password' => Yii::t('yii', 'Password'),
            'mobile' => Yii::t('yii', 'Mobile'),
            'type' => Yii::t('yii', 'Type'),
            'created' => Yii::t('yii', 'Created'),
            'updated' => Yii::t('yii', 'Updated'),
        ];
    }
}
