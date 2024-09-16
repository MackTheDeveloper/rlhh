<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "trainer_subjects".
 *
 * @property integer $trainer_subject_id
 * @property integer $trainer_id
 * @property string $subject_name
 * @property string $subject_value
 *
 * @property Trainer $trainer
 */
class TrainerSubjects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trainer_subjects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trainer_id'], 'integer'],
            [['subject_value'], 'string'],
            [['subject_name'], 'string', 'max' => 255],
            [['trainer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trainer::className(), 'targetAttribute' => ['trainer_id' => 'trainer_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'trainer_subject_id' => Yii::t('yii', 'Trainer Subject ID'),
            'trainer_id' => Yii::t('yii', 'Trainer ID'),
            'subject_name' => Yii::t('yii', 'Subject Name'),
            'subject_value' => Yii::t('yii', 'Subject Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainer()
    {
        return $this->hasOne(Trainer::className(), ['trainer_id' => 'trainer_id']);
    }
}
