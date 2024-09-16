<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CourseSchedule;

/**
 * CourseScheduleSearch represents the model behind the search form about `backend\models\CourseSchedule`.
 */
class CourseScheduleSearch extends CourseSchedule
{
    public $course_category;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_schedule_id',  'status', 'flagdelete', 'deleted_by'], 'integer'],
            [['course_category','trainer_ids', 'from_time','course_id', 'to_time', 'from_date', 'to_date', 'days', 'created_at','location','fees','class_size'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
         if(isset($_POST['indexofoutsidefiltering']) && $_POST['indexofoutsidefiltering'] != "")
        {
           
            $session = Yii::$app->session;  
            $session_from_date = $session->get('session_from_date');
            $session_to_date = $session->get('session_to_date');
            $query = CourseSchedule::find()->where("(DATE(from_date) between '$session_from_date' AND '$session_to_date' || DATE(to_date) between '$session_from_date' AND '$session_to_date') AND flagdelete = 0");
            $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'sort'=> ['defaultOrder' => ['course_schedule_id'=>SORT_DESC]]
                ]);
            
            $dataProvider->sort->attributes['course_category'] = [
                        'asc' => ['categories.category_id' => SORT_ASC],
                        'desc' => ['categories.category_id' => SORT_DESC],
                    ];

                $this->load($params);
                $query->joinWith('course');
                $query->join('LEFT JOIN','trainer','FIND_IN_SET(trainer_id,trainer_ids)');
                $query->join('LEFT JOIN','categories','categories.category_id = courses.course_category_id');
                if (!$this->validate()) {
                    return $dataProvider;
                }

                // grid filtering conditions
                $query->andFilterWhere([
                    'course_schedule_id' => $this->course_schedule_id,
                    'from_date' => $this->from_date,
                    'to_date' => $this->to_date,
                    'course_schedule.status' => $this->status,
                    'flagdelete' => $this->flagdelete,
                    'deleted_by' => $this->deleted_by,
                    'created_at' => $this->created_at,
                ]);

               $query->andFilterWhere(['like', 'days', $this->days])
                    ->andFilterWhere(['like', 'courses.course_name', $this->course_id])
                    ->andFilterWhere(['like', 'courses.fees', $this->fees])
                    ->andFilterWhere(['like', 'courses.class_size', $this->class_size])
                    ->andFilterWhere(['like', 'location', $this->location])
                    ->andFilterWhere(['OR',['like', 'trainer.first_name', $this->trainer_ids],['like', 'trainer.last_name', $this->trainer_ids]])
                   ->andFilterWhere(['OR',['like', 'from_time', $this->from_time],['like', 'from_time', $this->to_time]])
                ->andFilterWhere(['like', 'categories.name', $this->course_category]);

                return $dataProvider;  
        }
        else{
         
                $query = CourseSchedule::find()->where("course_schedule.flagdelete = 0");
                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'sort'=> ['defaultOrder' => ['course_schedule_id'=>SORT_DESC]]
                ]);
                
                $dataProvider->sort->attributes['course_category'] = [
                        'asc' => ['categories.category_id' => SORT_ASC],
                        'desc' => ['categories.category_id' => SORT_DESC],
                    ];
        
                  
                $this->load($params);
                $query->joinWith('course');
                $query->join('LEFT JOIN','trainer','FIND_IN_SET(trainer_id,trainer_ids)');
                $query->join('LEFT JOIN','categories','categories.category_id = courses.course_category_id');
                if (!$this->validate()) {
                    return $dataProvider;
                }
//pre($query);
                // grid filtering conditions
                $query->andFilterWhere([
                    'course_schedule_id' => $this->course_schedule_id,
                    'from_date' => $this->from_date,
                    'to_date' => $this->to_date,
                    'course_schedule.status' => $this->status,
                    'flagdelete' => $this->flagdelete,
                    'deleted_by' => $this->deleted_by,
                    'created_at' => $this->created_at,
                ]);

                $query->andFilterWhere(['like', 'days', $this->days])
                    ->andFilterWhere(['like', 'courses.course_name', $this->course_id])
                    ->andFilterWhere(['like', 'courses.fees', $this->fees])
                    ->andFilterWhere(['like', 'courses.class_size', $this->class_size])
                    ->andFilterWhere(['like', 'location', $this->location])
                    ->andFilterWhere(['OR',['like', 'trainer.first_name', $this->trainer_ids],['like', 'trainer.last_name', $this->trainer_ids]])
                   ->andFilterWhere(['OR',['like', 'from_time', $this->from_time],['like', 'from_time', $this->to_time]])
                    ->andFilterWhere(['like', 'categories.name', $this->course_category]);

                return $dataProvider;  
        }
    }
    
    public function searchfilteroutside($params,$post)
    {
        if(isset($post['CourseSchedule']) && count($post) > 0)
        {
           $session = Yii::$app->session;    
           
           if($post['CourseSchedule']['from_date'] != "" && $post['CourseSchedule']['to_date'] !="")
            {
            $from_date = date('Y-m-d', strtotime($post['CourseSchedule']['from_date']));
            $to_date = date('Y-m-d', strtotime($post['CourseSchedule']['to_date']));
            }else{
            $from_date = '';
            $to_date = '';
            }
           

            $session->remove('session_from_date');
            $session->remove('session_to_date');
            $session->remove('trainer_ids');
            $session->remove('course_id');

            $session->set('session_from_date',$from_date);
            $session->set('session_to_date',$to_date);   
            $session->set('trainer_ids',$post['CourseSchedule']['trainer_ids']);   
            $session->set('course_id',$post['CourseSchedule']['course_id']);   
            
            $query = CourseSchedule::find();
            $query->where("course_schedule.flagdelete = 0");
            $tainers = $post['CourseSchedule']['trainer_ids'];
            $course = $post['CourseSchedule']['course_id'];
                if(!empty($tainers))
                {
                    $i = 0;
                    foreach($tainers as $vl)
                    {
                        if($i == 0) { $query->andWhere("FIND_IN_SET('$vl',trainer_ids)"); }
                        else {
                        $query->orWhere("FIND_IN_SET('$vl',trainer_ids)"); }
                        $i++;
                    }
                }
                
                if(!empty($course))
                {
                    $i = 0;
                    foreach($course as $vl)
                    {
                        if($i == 0) { $query->andWhere("course_schedule.course_id = $vl"); }
                        else {
                        $query->orWhere("course_schedule.course_id = $vl"); }
                        $i++;
                    }
                }
                 if(!empty($from_date) && !empty($to_date))
                 $query->andWhere("(DATE(from_date) between '$from_date' AND '$to_date' || DATE(to_date) between '$from_date' AND '$to_date')");
                   
        }else{
                  
            $session = Yii::$app->session;  
            $session_from_date = $session->get('session_from_date');
            $session_to_date = $session->get('session_to_date');
            $tainers = $session->get('trainer_ids');
            $course = $session->get('course_id');
            
            $query = CourseSchedule::find();
            $query->where("course_schedule.flagdelete = 0");
            if(!empty($tainers))
                {
                    $i = 0;
                    foreach($tainers as $vl)
                    {
                        if($i == 0) { $query->andWhere("FIND_IN_SET('$vl',trainer_ids)"); }
                        else {
                        $query->orWhere("FIND_IN_SET('$vl',trainer_ids)"); }
                        $i++;
                    }
                }
                
                if(!empty($course))
                {
                    $i = 0;
                    foreach($course as $vl)
                    {
                        if($i == 0) { $query->andWhere("course_schedule.course_id = $vl"); }
                        else {
                        $query->orWhere("course_schedule.course_id = $vl"); }
                        $i++;
                    }
                }
                 if(!empty($session_from_date) && !empty($session_to_date))
                 $query->andWhere("(DATE(from_date) between '$session_from_date' AND '$session_to_date' || DATE(to_date) between '$session_from_date' AND '$session_to_date')");
        
        //$query = CourseSchedule::find()->where("(DATE(from_date) between '$session_from_date' AND '$session_to_date' || DATE(to_date) between '$session_from_date' AND '$session_to_date') AND course_schedule.flagdelete = 0");  
            
        }
         $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'sort'=> ['defaultOrder' => ['course_schedule_id'=>SORT_DESC]]
                ]);
       
         $dataProvider->sort->attributes['course_category'] = [
                        'asc' => ['categories.category_id' => SORT_ASC],
                        'desc' => ['categories.category_id' => SORT_DESC],
                    ];

        $this->load($params);
        $query->joinWith('course');
        $query->join('LEFT JOIN','trainer','FIND_IN_SET(trainer_id,trainer_ids)');
        $query->join('LEFT JOIN','categories','categories.category_id = courses.course_category_id');
        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'course_schedule_id' => $this->course_schedule_id,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'course_schedule.status' => $this->status,
            'flagdelete' => $this->flagdelete,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
        ]);

         $query->andFilterWhere(['like', 'days', $this->days])
                    ->andFilterWhere(['like', 'courses.course_name', $this->course_id])
                    ->andFilterWhere(['like', 'courses.fees', $this->fees])
                    ->andFilterWhere(['like', 'courses.class_size', $this->class_size])
                    ->andFilterWhere(['like', 'location', $this->location])
                    ->andFilterWhere(['OR',['like', 'trainer.first_name', $this->trainer_ids],['like', 'trainer.last_name', $this->trainer_ids]])
                   ->andFilterWhere(['OR',['like', 'from_time', $this->from_time],['like', 'from_time', $this->to_time]])
                  ->andFilterWhere(['like', 'categories.name', $this->course_category]);

        return $dataProvider;
    }
}
