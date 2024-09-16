<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "collaboration".
 *
 * @property integer $collaboration_id
 * @property string $title
 * @property string $description
 * @property string $image
 * @property integer $status
 * @property integer $flagdelete
 * @property integer $deleted_by
 * @property string $created_at
 */
class Collaboration extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'collaboration';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['status', 'flagdelete', 'deleted_by'], 'integer'],
            [['created_at'], 'safe'],
            [['title', 'image','logo'], 'string', 'max' => 255],
            
            [['title','description'], 'required'], 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'collaboration_id' => Yii::t('yii', 'Collaboration ID'),
            'title' => Yii::t('yii', 'Title'),
            'description' => Yii::t('yii', 'Description'),
            'image' => Yii::t('yii', 'Image'),
            'status' => Yii::t('yii', 'Status'),
            'flagdelete' => Yii::t('yii', 'Flagdelete'),
            'deleted_by' => Yii::t('yii', 'Deleted By'),
            'created_at' => Yii::t('yii', 'Created At'),
            'logo' => Yii::t('yii', 'Logo'),
        ];
    }
}
