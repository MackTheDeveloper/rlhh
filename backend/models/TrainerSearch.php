<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Trainer;

/**
 * TrainerSearch represents the model behind the search form about `backend\models\Trainer`.
 */
class TrainerSearch extends Trainer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trainer_id', 'phone_number', 'status','practice_phone_number','flagdelete', 'deleted_by'], 'integer'],
            [['first_name', 'last_name', 'email', 'password', 'created_at'], 'safe'],
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
            $query = Trainer::find()->where("DATE(created_at) between '$session_from_date' AND '$session_to_date' AND flagdelete = 0");
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort'=> ['defaultOrder' => ['trainer_id'=>SORT_DESC]]
            ]);

            $this->load($params);

            if (!$this->validate()) {
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            // grid filtering conditions
            $query->andFilterWhere([
                'trainer_id' => $this->trainer_id,
                'status' => $this->status,
                'flagdelete' => $this->flagdelete,
                'deleted_by' => $this->deleted_by,
                //'created_at' => $this->created_at,
            ]);

            $query->andFilterWhere(['like', 'first_name', $this->first_name])
                ->andFilterWhere(['like', 'last_name', $this->last_name])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'password', $this->password])
                ->andFilterWhere(['like', 'phone_number', $this->phone_number])
                ->andFilterWhere(['like', 'practice_phone_number', $this->practice_phone_number])
                ->andFilterWhere(['like', 'date(created_at)',$this->created_at]);

            return $dataProvider;
            
        }else{
            
            $query = Trainer::find()->where("flagdelete = 0");
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort'=> ['defaultOrder' => ['trainer_id'=>SORT_DESC]]
            ]);

            $this->load($params);

            if (!$this->validate()) {
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            // grid filtering conditions
            $query->andFilterWhere([
                'trainer_id' => $this->trainer_id,
                'status' => $this->status,
                'flagdelete' => $this->flagdelete,
                'deleted_by' => $this->deleted_by,
                //'created_at' => $this->created_at,
            ]);

            $query->andFilterWhere(['like', 'first_name', $this->first_name])
                ->andFilterWhere(['like', 'last_name', $this->last_name])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'password', $this->password])
                ->andFilterWhere(['like', 'phone_number', $this->phone_number])
                ->andFilterWhere(['like', 'practice_phone_number', $this->practice_phone_number])
                ->andFilterWhere(['like', 'date(created_at)',$this->created_at]);

            return $dataProvider;
        }
    }
    
    public function searchfilteroutside($params,$post)
    {
        if(isset($post['Trainer']) && count($post) > 0)
        {
        $session = Yii::$app->session;    
        
        
        $from_date = date('Y-m-d', strtotime($post['Trainer']['from_date']));
        $to_date = date('Y-m-d', strtotime($post['Trainer']['to_date']));
        
        $session->remove('session_from_date');
        $session->remove('session_to_date');
        $session->remove('acedemic_roles');
        
        $session->set('session_from_date',$from_date);
        $session->set('session_to_date',$to_date);   
        $session->set('acedemic_roles',$post['Trainer']['acedemic_roles']);   
        
        $query = Trainer::find();
        $query->andWhere("flagdelete = 0");
        $academicRoles = $post['Trainer']['acedemic_roles'];
            if(!empty($academicRoles))
            {
                $i = 0;
                foreach($academicRoles as $vl)
                {
                    if($i == 0) { $query->where("FIND_IN_SET('$vl',acedemic_roles)"); }
                    else {
                    $query->orWhere("FIND_IN_SET('$vl',acedemic_roles)"); }
                    $i++;
                }
            }
            if(!empty($post['Trainer']['from_date']) && !empty($post['Trainer']['to_date']))
            $query->andWhere("DATE(created_at) between '$from_date' AND '$to_date'");
            

        }
        else
        {
        $session = Yii::$app->session;  
        $session_from_date = $session->get('session_from_date');
        $session_to_date = $session->get('session_to_date');
        $academicRoles = $session->get('acedemic_roles');
        
        $query = Trainer::find();
        $query->andWhere("flagdelete = 0");
        if(!empty($academicRoles))
        {
            $i = 0;
            foreach($academicRoles as $vl)
            {
                if($i == 0) { $query->where("FIND_IN_SET('$vl',acedemic_roles)"); }
                else {
                $query->orWhere("FIND_IN_SET('$vl',acedemic_roles)"); }
                $i++;
            }
        }
        if(!empty($session_from_date) && !empty($session_to_date))
        $query->andWhere("DATE(created_at) between '$session_from_date' AND '$session_to_date'");
        
        //$query = Trainer::find()->where("DATE(created_at) between '$session_from_date' AND '$session_to_date' AND flagdelete = 0");    
        }
        $dataProvider = new ActiveDataProvider([
                'query' => $query,
            'sort'=> ['defaultOrder' => ['trainer_id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'trainer_id' => $this->trainer_id,
            'status' => $this->status,
            'flagdelete' => $this->flagdelete,
            'deleted_by' => $this->deleted_by,
            //'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'practice_phone_number', $this->practice_phone_number])
            ->andFilterWhere(['like', 'date(created_at)',$this->created_at]);

        return $dataProvider;
    }
}
