<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_materials".
 *
 * @property integer $material_id
 * @property integer $category_id
 * @property integer $product_id
 * @property string $name
 *
 * @property ProductCategories $category
 * @property Products $product
 */
class ProductMaterials extends \yii\db\ActiveRecord
{
    public $attachments;
    public $attachmentsname;
    public $attachmentspaid;
    public $attachmentspaidname;
    public $videosdownloadable;
    public $videosdownloadablename;
    public $videospaid;
    public $videospaidname;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_materials';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'product_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategories::className(), 'targetAttribute' => ['category_id' => 'category_id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'product_id']],
            [['attachments','attachmentsname','attachmentspaid','attachmentspaidname','videosdownloadable','videosdownloadablename','videospaid','videospaidname',],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'material_id' => Yii::t('yii', 'Material ID'),
            'category_id' => Yii::t('yii', 'Category ID'),
            'product_id' => Yii::t('yii', 'Product ID'),
            'name' => Yii::t('yii', 'Name'),
            /*'attachments' => 'Downloadable Materials',
                    'attachmentsname' => 'Name',
                    'attachmentspaid' => 'Paid Materials',
                    'attachmentspaidname' => 'Name',
                    'videosdownloadable' => 'Downloadable Videos',
                    'videosdownloadablename' => 'Name',
                    'videospaid' => 'Paid Videos',
                    'videospaidname' => 'Name', */
            'attachments' => '',
            'attachmentsname' => '',
            'attachmentspaid' => '',
            'attachmentspaidname' => '',
            'videosdownloadable' => '',
            'videosdownloadablename' => '',
            'videospaid' => '',
            'videospaidname' => '',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ProductCategories::className(), ['category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['product_id' => 'product_id']);
    }
    
    public function getUploadedAttachments($id,$shortCode="")
    {
        $dataMaterials = array();
        if($shortCode == 'DO')
        $dataMaterials =  ProductMaterials::find()->where("product_id = $id AND flag_material = 'D' AND material_type = 'O'")->all();
        if($shortCode == 'PO')
        $dataMaterials =  ProductMaterials::find()->where("product_id = $id AND flag_material = 'P' AND material_type = 'O'")->all();
        if($shortCode == 'DV')
        $dataMaterials =  ProductMaterials::find()->where("product_id = $id AND flag_material = 'D' AND material_type = 'V'")->all();
        if($shortCode == 'PV')
        $dataMaterials =  ProductMaterials::find()->where("product_id = $id AND flag_material = 'P' AND material_type = 'V'")->all();
        if(!empty($dataMaterials))
        {
            return $dataMaterials;
        }else{
            return $dataMaterials;
        }
    }
    
}
