<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "course_payment_installments".
 *
 * @property integer $course_payment_installment_id
 * @property integer $course_id
 * @property string $period
 * @property string $amount
 */
class CoursePaymentInstallments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_payment_installments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id'], 'integer'],
            [['period', 'amount','reminder'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'course_payment_installment_id' => Yii::t('yii', 'Course Payment Installment ID'),
            'course_id' => Yii::t('yii', 'Course ID'),
            'period' => Yii::t('yii', ''),
            'amount' => Yii::t('yii', ''),
            'reminder' => Yii::t('yii', ''),
            
        ];
    }
}
