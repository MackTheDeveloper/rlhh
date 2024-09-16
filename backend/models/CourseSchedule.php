<?php

namespace backend\models;

use Yii;
use yii\helpers\Html;
/**
 * This is the model class for table "course_schedule".
 *
 * @property integer $course_schedule_id
 * @property integer $course_id
 * @property string $trainer_ids
 * @property string $from_time
 * @property string $to_time
 * @property string $from_date
 * @property string $to_date
 * @property string $days
 * @property integer $status
 * @property integer $flagdelete
 * @property integer $deleted_by
 * @property string $created_at
 */
class CourseSchedule extends \yii\db\ActiveRecord
{
    public $fees;
    public $class_size;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'status', 'flagdelete', 'deleted_by'], 'integer'],
            [['from_time','trainer_ids','to_time', 'from_date', 'to_date', 'created_at','location','important_notes_for_student','important_notes_for_trainer','downloadable_materials_student','downloadable_videos_student','downloadable_materials_trainer','downloadable_videos_trainer','trainers_allow_download'], 'safe'],
            [['days'], 'string', 'max' => 255],
            
             ['from_date', 'compare', 'compareValue' => date('Y-m-d'), 'operator' => '>=', 
              'message' => '{attribute} should be greater or more than "{compareValue}".','on'=>['add','update']],    
            
            
            ['to_date','compare','compareAttribute' => 'from_date','operator'=>'>=', 
             'message' => '{attribute} should be grater or equal than "{compareValue}".','on'=>['add','update']],
            
            
            ['to_time','compare','compareAttribute' => 'from_time','operator'=>'>', 
             'message' => '{attribute} should be greater than "{compareValue}".'],
            
            [['from_date', 'to_date','course_id','trainer_ids'],'required','on'=>['add','update']],
            [['from_time','to_time','days'],'required'],
            
             //[['from_date','to_date'],'required','on'=>'outsidefilter'],
            [['from_date','trainer_ids','to_date'],'string','on'=>'outsidefilter'],
            //['to_date','compare','compareAttribute' => 'from_date','operator'=>'>=', 'message' => '{attribute} should be greater than "{compareValue}".','on'=>'outsidefilter'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'course_schedule_id' => Yii::t('yii', 'Course Schedule ID'),
            'course_id' => Yii::t('yii', 'Course'),
            'trainer_ids' => Yii::t('yii', 'Trainer(s)'),
            'from_time' => Yii::t('yii', 'From Time'),
            'to_time' => Yii::t('yii', 'To Time'),
            'from_date' => Yii::t('yii', 'From Date'),
            'to_date' => Yii::t('yii', 'To Date'),
            'days' => Yii::t('yii', 'Days'),
            'status' => Yii::t('yii', 'Status'),
            'flagdelete' => Yii::t('yii', 'Flagdelete'),
            'deleted_by' => Yii::t('yii', 'Deleted By'),
            'created_at' => Yii::t('yii', 'Created At'),
            'important_notes_for_student' => Yii::t('yii', 'Important note for student'),
            'important_notes_for_trainer' => Yii::t('yii', 'Important note for trainer'),
            'downloadable_materials_student' => Yii::t('yii', 'Materials'),
            'downloadable_videos_student' => Yii::t('yii', 'Videos'),
            'downloadable_materials_trainer' => Yii::t('yii', 'Materials'),
            'downloadable_videos_trainer' => Yii::t('yii', 'Videos'),
            'trainers_allow_download' => Yii::t('yii', 'Allow Download To'),
        ];
    }
    
     public function getCourse()
    {
        return $this->hasOne(Courses::className(), ['course_id' => 'course_id']);
    }
    public function getCourseCatName($id)
    {
        $query = new yii\db\Query;
        $query->select(['cat.name'])
                ->from('categories cat')
                ->join('LEFT JOIN','courses c','c.course_category_id=cat.category_id')
                ->where("c.course_id = $id");
        $conn = $query->createCommand();
        $data = $conn->queryOne();
        return $data['name']; 
    }
    
    
    public function getCourseTrainers($courseId)
    {
        $courseData = Courses::find()->where("course_id = $courseId")->one();
        if(!empty($courseData))
        {
            $trainers = explode(',',$courseData->trainer);
            $dataTrainers = Trainer::find()->where("flagdelete = 0")->all();
            if(!empty($dataTrainers))
            {
                
                $optStr = '<option value="">-- Select --</option>';
                foreach($dataTrainers as $k => $v)
                {
                    
                    if(in_array($v->trainer_id,$trainers))
                    $temp = 'selected'; 
                    else
                    $temp = '';     
                    
                    $optStr .= "<option $temp value=$v->trainer_id>" . $v->last_name.' '.$v->first_name . "</option>";
                }
                return $optStr;
            }
        }
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
    
    public function getCourseDetail($courseId)
    {
         $courseData = Courses::find()->where("course_id = $courseId")->one();
         return $courseData;
    }
    
     public function changestatus($status,$id) {
        if ($status == 1) {
                return Html::a('Mark As Inactive', '', ['class' => 'change-status', 'id' => $id]);
            } else {
                return Html::a('Mark As Active', '', ['class' => 'change-status', 'id' => $id]);
            }
    }
    
    public function getMaterialsOfCourse($id)
    {
        $query = new \yii\db\Query;
        $dataDownloadablematerials = array();
        $dataDownloadableVidoes = array();
        // Downloadable Materials
        $query->select(['pm.*','p.name as product_name'])
                ->from('courses c')
                ->join('LEFT JOIN','product_materials pm','FIND_IN_SET(pm.material_id,c.downloadable_materials)')
                ->join('LEFT JOIN','products p','p.product_id = pm.product_id')
                ->andWhere("c.course_id = $id");
        
         $conn = $query->createCommand();
         $dataDownloadablematerials['materials'] = $conn->queryAll(); 
         
         
         $query1 = new \yii\db\Query;
         // Downloadable videos
       $query1->select(['pm.*','p.name as product_name'])
                ->from('courses c')
                ->join('LEFT JOIN','product_materials pm','FIND_IN_SET(pm.material_id,c.downloadable_videos)')
                ->join('LEFT JOIN','products p','p.product_id = pm.product_id')
                ->andWhere("c.course_id = $id");
        $conn = $query1->createCommand();
        $dataDownloadableVidoes['videos'] = $conn->queryAll(); 
        
        $allData = array_merge($dataDownloadablematerials,$dataDownloadableVidoes);
        
        return $allData;
    }
    
    public function getTrainersForAllowDownload($trainers)
    {
        $dataTrainers = Trainer::find()->where(['IN','trainer_id',$trainers])->all();
        return $dataTrainers;
    }
        
}
