<?php

namespace backend\models;

use Yii;
use yii\helpers\Html;
/**
 * This is the model class for table "courseregistration".
 *
 * @property integer $courseregistration_id
 * @property integer $course_id
 * @property integer $customer_id
 * @property string $registration_date
 * @property string $amount
 * @property string $status_registration
 * @property integer $status
 * @property integer $flagdelete
 * @property integer $deleted_by
 * @property string $created_at
 */
class Courseregistration extends \yii\db\ActiveRecord
{
     public $from_date;
     public $to_date;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'courseregistration';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'customer_id', 'status', 'flagdelete', 'deleted_by'], 'integer'],
            [['registration_date', 'created_at'], 'safe'],
            [['status_registration'], 'string'],
            [['amount'], 'string', 'max' => 255],
            
            //[['from_date','to_date'],'required','on'=>'outsidefilter'],
            [['from_date','to_date'],'string','on'=>'outsidefilter'],
            //['to_date','compare','compareAttribute' => 'from_date','operator'=>'>=', 'message' => '{attribute} should be greater than "{compareValue}".','on'=>'outsidefilter'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'courseregistration_id' => Yii::t('yii', 'Courseregistration ID'),
            'course_id' => Yii::t('yii', 'Course'),
            'customer_id' => Yii::t('yii', 'Customer'),
            'registration_date' => Yii::t('yii', 'Date & Time'),
            'amount' => Yii::t('yii', 'Amount'),
            'status_registration' => Yii::t('yii', 'Status'),
            'status' => Yii::t('yii', 'Status'),
            'flagdelete' => Yii::t('yii', 'Flagdelete'),
            'deleted_by' => Yii::t('yii', 'Deleted By'),
            'created_at' => Yii::t('yii', 'Created At'),
        ];
    }
    
     public function getCourse()
    {
        return $this->hasOne(Courses::className(), ['course_id' => 'course_id']);
    }
    public function getCustomer()
    {
        return $this->hasOne(Customers::className(), ['customer_id' => 'customer_id']);
    }
    public function getCustomerName($id)
    {
        $custData = Customers::find()->where("customer_id = $id")->one();
        return $custData->last_name.' '.$custData->first_name;
    }
    public function changestatusOfcourseRegistration($status,$id) {
                return Html::a('Mark As Paid', '', ['class' => 'change-status-course-registration', 'id' => $id]);
        }
}
