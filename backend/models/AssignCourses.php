<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "assign_courses".
 *
 * @property integer $assign_course_id
 * @property integer $course_id
 * @property integer $course_category_id
 *
 * @property Categories $courseCategory
 * @property Courses $course
 */
class AssignCourses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'assign_courses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'course_category_id'], 'integer'],
            [['course_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['course_category_id' => 'category_id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Courses::className(), 'targetAttribute' => ['course_id' => 'course_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'assign_course_id' => Yii::t('yii', 'Assign Course ID'),
            'course_id' => Yii::t('yii', 'Course ID'),
            'course_category_id' => Yii::t('yii', 'Course Category'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseCategory()
    {
        return $this->hasOne(Categories::className(), ['category_id' => 'course_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Courses::className(), ['course_id' => 'course_id']);
    }
    
     public function getNeededCategories($catId)
    {
        $categoryAll = Categories::find()->where(['flag_category'=>'N','flag_course'=>'N'])->orWhere(['flag_category'=>'N','flag_course'=>'Y'])
                ->andWhere(['flagdelete'=>0])->andWhere(['<>','category_id', $catId])->all();
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
    
    public function getAssingedCategory($courseId)
    {
        $catIds = array();
        $dataAssignCourse = AssignCourses::find()->where("course_id = $courseId")->all();
        if(!empty($dataAssignCourse))
        {
            foreach($dataAssignCourse as $v)
            {
                $catIds[] = $v->course_category_id;
            }
        }
        return $catIds;
    }
}
