<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Courseregistration;

/**
 * CourseregistrationSearch represents the model behind the search form about `backend\models\Courseregistration`.
 */
class CourseregistrationSearch extends Courseregistration
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['courseregistration_id', 'status', 'flagdelete', 'deleted_by'], 'integer'],
            [['registration_date', 'amount', 'status_registration', 'created_at', 'course_id', 'customer_id'], 'safe'],
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
            $customer = $session->get('customer');
            $course = $session->get('course');
            $status = $session->get('status');
            $strQry = "";
            $query = Courseregistration::find();
            $query->andWhere("flagdelete = 0");
            if(!empty($customer))
            {
               $strQry .= "AND customer_id = $customer";
            }
            if(!empty($course))
            {
                $strQry .= "AND course_id = $course";
            }
            if(!empty($status))
            {
                $strQry .= "AND status_registration = '$status'";
            }
            if(!empty($session_from_date) && !empty($session_to_date))
                $strQry .= "AND DATE(registration_date) between '$session_from_date' AND '$session_to_date'";
            
            $query = Customers::find()->where("flagdelete = 0 $strQry");
            
            $dataProvider = new ActiveDataProvider([
            'query' => $query,
                ]);

                $this->load($params);
                $query->joinWith('course');
                $query->joinWith('customer');
                if (!$this->validate()) {
                    // uncomment the following line if you do not want to return any records when validation fails
                    // $query->where('0=1');
                    return $dataProvider;
                }

                // grid filtering conditions
                $query->andFilterWhere([
                    'courseregistration_id' => $this->courseregistration_id,
                    'registration_date' => $this->registration_date,
                    'status' => $this->status,
                    'flagdelete' => $this->flagdelete,
                    'deleted_by' => $this->deleted_by,
                    'created_at' => $this->created_at,
                ]);

                $query->andFilterWhere(['like', 'amount', $this->amount])
                    ->andFilterWhere(['like', 'status_registration', $this->status_registration])
                    ->andFilterWhere(['like', 'courses.course_name', $this->course_id])
                    ->andFilterWhere(['OR',['like', 'customers.last_name', $this->customer_id],['like', 'customers.first_name', $this->customer_id]]);

                return $dataProvider;
            
        }else
        {
            $query = Courseregistration::find()->where("courseregistration.flagdelete = 0");;

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);

            $this->load($params);
            $query->joinWith('course');
            $query->joinWith('customer');
            if (!$this->validate()) {
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            // grid filtering conditions
            $query->andFilterWhere([
                'courseregistration_id' => $this->courseregistration_id,
                'registration_date' => $this->registration_date,
                'status' => $this->status,
                'flagdelete' => $this->flagdelete,
                'deleted_by' => $this->deleted_by,
                'created_at' => $this->created_at,
            ]);

            $query->andFilterWhere(['like', 'amount', $this->amount])
                ->andFilterWhere(['like', 'status_registration', $this->status_registration])
                ->andFilterWhere(['like', 'courses.course_name', $this->course_id])
                ->andFilterWhere(['OR',['like', 'customers.last_name', $this->customer_id],['like', 'customers.first_name', $this->customer_id]]);

            return $dataProvider;
       }
    }
    
    public function searchfilteroutside($params,$post)
    {
        if(isset($post['Courseregistration']) && count($post) > 0)
        {
            $session = Yii::$app->session;    
            $from_date = date('Y-m-d', strtotime($post['Courseregistration']['from_date']));
            $to_date = date('Y-m-d', strtotime($post['Courseregistration']['to_date']));

            $session->remove('session_from_date');
            $session->remove('session_to_date');
            $session->remove('customer');
            $session->remove('course');
            $session->remove('status');

            $session->set('session_from_date',$from_date);
            $session->set('session_to_date',$to_date);   
            $session->set('customer',$post['Courseregistration']['customer_id']); 
            $session->set('course',$post['Courseregistration']['course_id']); 
            $session->set('status',$post['Courseregistration']['status_registration']); 
            
            $query = Courseregistration::find();
            $query->where("courseregistration.flagdelete = 0");
            $customer = $post['Courseregistration']['customer_id'];
            $course = $post['Courseregistration']['course_id'];
            $status = $post['Courseregistration']['status_registration'];
            if(!empty($customer))
            {
                $query->andWhere("courseregistration.customer_id = $customer");
            }
            if(!empty($course))
            {
                $query->andWhere("courseregistration.course_id = $course");
            }
            if(!empty($status))
            {
                $query->andWhere("courseregistration.status_registration = '$status'");
            }
            if(!empty($post['Courseregistration']['from_date']) && !empty($post['Courseregistration']['to_date']))
            $query->andWhere("DATE(registration_date) between '$from_date' AND '$to_date'");
            
        }else{
            $session = Yii::$app->session;  
            $session_from_date = $session->get('session_from_date');
            $session_to_date = $session->get('session_to_date');
            $customer = $session->get('customer');
            $course = $session->get('course');
            $status = $session->get('status');
            
            $query = Courseregistration::find();
            $query->andWhere("courseregistration.flagdelete = 0");
            if(!empty($customer))
            {
                $query->andWhere("courseregistration.customer_id = $customer");
            }
            if(!empty($course))
            {
                $query->andWhere("courseregistration.course_id = $course");
            }
            if(!empty($status))
            {
                $query->andWhere("courseregistration.status_registration = '$status'");
            }
            if(!empty($session_from_date) && !empty($session_to_date))
            $query->andWhere("DATE(registration_date) between '$session_from_date' AND '$session_to_date'");
            
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->joinWith('course');
        $query->joinWith('customer');
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'courseregistration_id' => $this->courseregistration_id,
            'registration_date' => $this->registration_date,
            'status' => $this->status,
            'flagdelete' => $this->flagdelete,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'amount', $this->amount])
            ->andFilterWhere(['like', 'status_registration', $this->status_registration])
            ->andFilterWhere(['like', 'courses.course_name', $this->course_id])
            ->andFilterWhere(['OR',['like', 'customers.last_name', $this->customer_id],['like', 'customers.first_name', $this->customer_id]]);

        return $dataProvider;
    }
}
