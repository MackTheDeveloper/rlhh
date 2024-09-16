<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_categories".
 *
 * @property integer $category_id
 * @property string $type
 * @property integer $parent_id
 * @property string $name
 * @property string $image
 * @property string $description
 * @property integer $sort_order
 * @property string $category_path
 * @property integer $status
 * @property integer $flagdelete
 * @property integer $deleted_by
 * @property string $created_at
 */
class ProductCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'sort_order', 'status', 'flagdelete', 'deleted_by'], 'integer'],
            [['created_at','flag_category','flag_product'], 'safe'],
            [['type', 'name', 'image', 'description', 'category_path'], 'string', 'max' => 255],
            [['name'],'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => Yii::t('yii', 'Category ID'),
            'type' => Yii::t('yii', 'Type'),
            //'parent_id' => Yii::t('yii', 'Parent ID'),
            'parent_id' => Yii::t('yii', 'Category'),
            'name' => Yii::t('yii', 'Name'),
            'image' => Yii::t('yii', 'Image'),
            'description' => Yii::t('yii', 'Description'),
            'sort_order' => Yii::t('yii', 'Sort Order'),
            'category_path' => Yii::t('yii', 'Category Path'),
            'status' => Yii::t('yii', 'Status'),
            'flagdelete' => Yii::t('yii', 'Flagdelete'),
            'deleted_by' => Yii::t('yii', 'Deleted By'),
            'created_at' => Yii::t('yii', 'Created At'),
        ];
    }
    
    public function getAllCategories()
    {
        $catAll = array();
        $catAll = ProductCategories::find()->where("flagdelete = 0")->all();
        return $catAll;
    }
    
    public function checkHasSubCatOrNot($id)
    {
        $checkCat = ProductCategories::find()->where("parent_id = $id AND flagdelete = 0")->count();
        if($checkCat > 0)
        {
            return 1;
        }else{
            return 0;
        }
    }
}
