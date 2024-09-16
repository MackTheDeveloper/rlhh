<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "teachingteam".
 *
 * @property integer $teaching_team_id
 * @property string $title
 * @property string $description
 * @property string $image
 * @property integer $status
 * @property integer $flagdelete
 * @property integer $deleted_by
 * @property string $created_at
 */
class Teachingteam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teachingteam';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['status', 'flagdelete', 'deleted_by'], 'integer'],
            [['created_at','type'], 'safe'],
            [['title', 'image'], 'string', 'max' => 255],
            
             [['title','type'], 'required'], 
            
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'teaching_team_id' => Yii::t('yii', 'Teaching Team ID'),
            'title' => Yii::t('yii', 'Name'),
            'description' => Yii::t('yii', 'Description'),
            'image' => Yii::t('yii', 'Image'),
            'status' => Yii::t('yii', 'Status'),
            'flagdelete' => Yii::t('yii', 'Flagdelete'),
            'deleted_by' => Yii::t('yii', 'Deleted By'),
            'created_at' => Yii::t('yii', 'Created At'),
            'type' => Yii::t('yii', 'Type'),
        ];
    }
}
