<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $product_id
 * @property integer $category_id
 * @property string $name
 * @property string $image
 * @property string $price
 * @property string $description
 * @property integer $status
 * @property integer $flagdelete
 * @property integer $deleted_by
 * @property integer $created_at
 *
 * @property ProductMaterials[] $productMaterials
 * @property ProductCategories $category
 */
class Products extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'status', 'flagdelete', 'deleted_by'], 'integer'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['created_at','cost_type'],'safe'],
            [['name', 'image'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategories::className(), 'targetAttribute' => ['category_id' => 'category_id']],
            [['name','description','category_id'],'required'],
            ['price', 'required', 'when' => function ($model) { return $model->cost_type == 'Paid'; }, 
            'whenClient' => "function (attribute, value) { }"
            ],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('yii', 'Product ID'),
            'category_id' => Yii::t('yii', 'Category'),
            'name' => Yii::t('yii', 'Name'),
            'image' => Yii::t('yii', 'Image'),
            'price' => Yii::t('yii', 'Price'),
            'description' => Yii::t('yii', 'Description'),
            'status' => Yii::t('yii', 'Status'),
            'flagdelete' => Yii::t('yii', 'Flagdelete'),
            'deleted_by' => Yii::t('yii', 'Deleted By'),
            'created_at' => Yii::t('yii', 'Created At'),
            'cost_type' => Yii::t('yii', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductMaterials()
    {
        return $this->hasMany(ProductMaterials::className(), ['product_id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ProductCategories::className(), ['category_id' => 'category_id']);
    }
    
    public function getNeededCategories()
    {
        $categoryAll = ProductCategories::find()->where(['flag_category'=>'N','flag_product'=>'N'])->orWhere(['flag_category'=>'N','flag_product'=>'Y'])->andWhere(['flagdelete'=>0])->all();
            foreach($categoryAll as $k => $v)
            {
                $catName = array();
                $path = explode(',',$v->category_path);
                array_pop($path);
                $catOfPath = ProductCategories::find()->where(['IN','category_id',$path])->all();
                if(!empty($catOfPath))
                {
                    foreach($catOfPath as $vll)
                    {
                        $catName[] = $vll->name;
                    }
                }
                if(count($catName) > 0)
                $categoryAll[$k]['name'] = $categoryAll[$k]['name'] . ' - ' .implode(' > ',$catName);
                else
                $categoryAll[$k]['name'] = $categoryAll[$k]['name'];    
            }
         return $categoryAll;  
    }
}
