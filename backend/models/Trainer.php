<?php

namespace backend\models;

use Yii;
use yii\helpers\Html;
/**
 * This is the model class for table "trainer".
 *
 * @property integer $trainer_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property integer $phone_number
 * @property integer $status
 * @property integer $flagdelete
 * @property integer $deleted_by
 * @property string $created_at
 */
class Trainer extends \yii\db\ActiveRecord
{
    public $from_date;
    public $to_date;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trainer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone_number','practice_phone_number','status', 'flagdelete', 'deleted_by'], 'integer'],
            [['created_at','acedemic_roles','skype_id'], 'safe'],
            [['first_name', 'last_name', 'email', 'password'], 'string', 'max' => 255],
            ['email','email'],
            ['email','unique'],
            [['first_name', 'last_name', 'email', 'password'],'required'],
            
            //[['from_date','to_date'],'required','on'=>'outsidefilter'],
            [['from_date','to_date','acedemic_roles'],'string','on'=>'outsidefilter'],
            //['to_date','compare','compareAttribute' => 'from_date','operator'=>'>=', 'message' => '{attribute} should be greater than "{compareValue}".','on'=>'outsidefilter'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'trainer_id' => Yii::t('yii', 'Trainer ID'),
            'first_name' => Yii::t('yii', 'First Name'),
            'last_name' => Yii::t('yii', 'Last Name'),
            'email' => Yii::t('yii', 'Email'),
            'password' => Yii::t('yii', 'Password'),
            'phone_number' => Yii::t('yii', 'Contact Number'),
            'practice_phone_number' => Yii::t('yii', 'Practice Contact Number'),
            'status' => Yii::t('yii', 'Status'),
            'flagdelete' => Yii::t('yii', 'Flagdelete'),
            'deleted_by' => Yii::t('yii', 'Deleted By'),
            'created_at' => Yii::t('yii', 'Date & Time'),
            'acedemic_roles' => Yii::t('yii', 'Academic Roles'),
        ];
    }
    
    public function changestatus($status,$id) {
        if ($status == 1) {
                return Html::a('Mark As Inactive', '', ['class' => 'change-status', 'id' => $id]);
            } else {
                return Html::a('Mark As Active', '', ['class' => 'change-status', 'id' => $id]);
            }
    }
}
