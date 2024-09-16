<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property integer $page_id
 * @property string $name
 * @property string $slug
 * @property string $content
 * @property string $seo_title
 * @property string $seo_description
 * @property integer $status
 * @property integer $flagdelete
 * @property string $deleted_at
 * @property integer $deleted_by
 * @property string $created_on
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['content'], 'string'],
            [['status', 'flagdelete', 'deleted_by'], 'integer'],
            [['deleted_at', 'created_on'], 'safe'],
            [['name', 'seo_title', 'seo_description'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 1024],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'page_id' => Yii::t('yii', 'Page ID'),
            'name' => Yii::t('yii', 'Name'),
            'slug' => Yii::t('yii', 'Slug'),
            'content' => Yii::t('yii', 'Content'),
            'seo_title' => Yii::t('yii', 'Seo Title'),
            'seo_description' => Yii::t('yii', 'Seo Description'),
            'status' => Yii::t('yii', 'Status'),
            'flagdelete' => Yii::t('yii', 'Flagdelete'),
            'deleted_at' => Yii::t('yii', 'Deleted At'),
            'deleted_by' => Yii::t('yii', 'Deleted By'),
            'created_on' => Yii::t('yii', 'Created On'),
        ];
    }
}
