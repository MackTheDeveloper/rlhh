<?php

namespace backend\models;

use Yii;
use Yii\db\Query;

/**
 * This is the model class for table "courses".
 *
 * @property integer $course_id
 * @property integer $course_category_id
 * @property string $course_name
 * @property string $image
 * @property string $type
 * @property string $course_date
 * @property string $time_duration
 * @property string $overview
 * @property string $highlight
 * @property string $class_size
 * @property integer $trainer
 * @property string $fees
 * @property integer $status
 * @property integer $flagdelete
 * @property integer $deleted_by
 * @property string $created_at
 */
class Courses extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'courses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_category_id','status','flagdelete', 'deleted_by'], 'integer'],
            ['fees','number'],
            [['course_date', 'created_at','downloadable_materials','paid_materials','downloadable_videos','paid_videos','productsdownloadablematerials','productspaidmaterials','productsdownloadablevideos','productspaidvideos','accredited_hours','time_duration','trainer','course_date','course_to_date','payment_process'],'safe'],
            [['overview', 'highlight'], 'string'],
            [['course_name', 'image', 'class_size'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 1],
            [['time_duration'], 'string', 'max' => 100],
            
            [['course_category_id','course_name','type'],'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'course_id' => Yii::t('yii', 'Course ID'),
            'course_category_id' => Yii::t('yii', 'Course Category'),
            'course_name' => Yii::t('yii', 'Course Name'),
            'image' => Yii::t('yii', 'Image'),
            'type' => Yii::t('yii', 'Type'),
            'course_date' => Yii::t('yii', 'Course From Date'),
            'course_to_date' => Yii::t('yii', 'Course To Date'),
            'time_duration' => Yii::t('yii', 'Time Duration (Hrs.)'),
            'overview' => Yii::t('yii', 'Overview'),
            'highlight' => Yii::t('yii', 'Highlight / Syllabus'),
            'class_size' => Yii::t('yii', 'Class Size / Seat Availability'),
            'trainer' => Yii::t('yii', 'Trainer'),
            'fees' => Yii::t('yii', 'Fees '.Yii::$app->params['currencySymbol']),
            'status' => Yii::t('yii', 'Status'),
            'flagdelete' => Yii::t('yii', 'Flagdelete'),
            'deleted_by' => Yii::t('yii', 'Deleted By'),
            'created_at' => Yii::t('yii', 'Created At'),
            'productsdownloadablematerials' => Yii::t('yii', 'Product'),
            'productspaidmaterials' => Yii::t('yii', 'Product'),
            'productsdownloadablevideos' => Yii::t('yii', 'Product'),
            'productspaidvideos' => Yii::t('yii', 'Product'),
            'accredited_hours' => Yii::t('yii', 'Credited Hrs.'),
            'payment_process' => Yii::t('yii', 'Payment Process'),
            
        ];
    }
     public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['category_id' => 'course_category_id']);
    }
     public function getTrainer()
    {
        return $this->hasOne(Trainer::className(), ['trainer_id' => 'trainer']);
    }
    public function getTrainerName($id)
    {
        $expldedTrainer = explode(',',$id);
        
        //$dataTrainer = Trainer::find()->where("trainer_id = $id")->one();
        $dataTrainer = Trainer::find()->where(['IN','trainer_id',$expldedTrainer])->all();
        if(!empty($dataTrainer))
        {
            foreach($dataTrainer as $t)
            {
                $nameOFtrainers[] = $t->last_name.' '.$t->first_name;
            }
            return implode(',',$nameOFtrainers);
        }else{
            return '-';
        }
    }
     public function getNeededCategories()
    {
        $categoryAll = Categories::find()->where(['flag_category'=>'N','flag_course'=>'N'])->orWhere(['flag_category'=>'N','flag_course'=>'Y'])->andWhere(['flagdelete'=>0])->all();
            foreach($categoryAll as $k => $v)
            {
                $catName = array();
                $path = explode(',',$v->category_path);
                array_pop($path);
                $catOfPath = Categories::find()->where(['IN','category_id',$path])->all();
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
    
    public function fetchdownlodableandpaidmaterialforcourse($id)
    {
        $query = new \yii\db\Query;
        $dataDownloadablematerials = array();
        $dataDownloadableVidoes = array();
        // Downloadable and paid materials
        $query->select(['pm.*','p.name as product_name'])
                ->from('product_materials pm')
                ->join('LEFT JOIN','products p','p.product_id = pm.product_id')
                ->where(['IN','pm.product_id',$id])
                ->andWhere("pm.flag_material = 'D' AND pm.material_type = 'O'");
        
         $conn = $query->createCommand();
         $dataDownloadablematerials['materials'] = $conn->queryAll(); 
         
         
         $query1 = new \yii\db\Query;
         // Downloadable and paid videos
        $query1->select(['pm.*','p.name as product_name'])
                ->from('product_materials pm')
                ->join('LEFT JOIN','products p','p.product_id = pm.product_id')
                ->where(['IN','pm.product_id',$id])
                ->andWhere("pm.flag_material = 'D' AND pm.material_type = 'V'");
        $conn = $query1->createCommand();
        $dataDownloadableVidoes['videos'] = $conn->queryAll(); 
        
        $allData = array_merge($dataDownloadablematerials,$dataDownloadableVidoes);
        
        return $allData;
    }
    
    
    
}
