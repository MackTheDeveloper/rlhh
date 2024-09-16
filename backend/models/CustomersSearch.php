<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Customers;

/**
 * CustomersSearch represents the model behind the search form about `backend\models\Customers`.
 */
class CustomersSearch extends Customers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'phone_number', 'status', 'flagdelete', 'deleted_by'], 'integer'],
            [['first_name', 'last_name', 'email', 'password', 'flag_newsletter', 'profession', 'created_at'], 'safe'],
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
            $profession = $session->get('profession');
            $flagNewsletter = $session->get('flag_newsletter');
            $strQry = "";
            if(!empty($profession))
            {
                $strQry .= "AND profession = '$profession'";
            }
            if(!empty($flagNewsletter))
            {
                $strQry .=  "AND flag_newsletter = '$flagNewsletter'";
            }
            if(!empty($session_from_date) && !empty($session_to_date))
            {
                 $strQry .=  "AND DATE(created_at) between '$session_from_date' AND '$session_to_date'";
            }
            $query = Customers::find()->where("flagdelete = 0 $strQry");
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort'=> ['defaultOrder' => ['customer_id'=>SORT_DESC]]
            ]);
            $this->load($params);
            if (!$this->validate()) {
                return $dataProvider;
            }

            $query->andFilterWhere([
                'customer_id' => $this->customer_id,
                'phone_number' => $this->phone_number,
                'status' => $this->status,
                'flagdelete' => $this->flagdelete,
                'deleted_by' => $this->deleted_by,
                'created_at' => $this->created_at,
            ]);

            $query->andFilterWhere(['like', 'first_name', $this->first_name])
                ->andFilterWhere(['like', 'last_name', $this->last_name])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'password', $this->password])
                ->andFilterWhere(['like', 'flag_newsletter', $this->flag_newsletter])
                ->andFilterWhere(['like', 'profession', $this->profession]);

            return $dataProvider;
        }else
        {
            $query = Customers::find()->where("flagdelete = 0");;
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort'=> ['defaultOrder' => ['customer_id'=>SORT_DESC]]
            ]);
            $this->load($params);
            if (!$this->validate()) {
                return $dataProvider;
            }

            $query->andFilterWhere([
                'customer_id' => $this->customer_id,
                'phone_number' => $this->phone_number,
                'status' => $this->status,
                'flagdelete' => $this->flagdelete,
                'deleted_by' => $this->deleted_by,
                'created_at' => $this->created_at,
            ]);

            $query->andFilterWhere(['like', 'first_name', $this->first_name])
                ->andFilterWhere(['like', 'last_name', $this->last_name])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'password', $this->password])
                ->andFilterWhere(['like', 'flag_newsletter', $this->flag_newsletter])
                ->andFilterWhere(['like', 'profession', $this->profession]);

            return $dataProvider;
        }
    }
    
    public function searchfilteroutside($params,$post)
    {
        if(isset($post['Customers']) && count($post) > 0)
        {
            $session = Yii::$app->session;    
            
            if($post['Customers']['from_date'] != "" && $post['Customers']['to_date'] !="")
            {
            $from_date = date('Y-m-d', strtotime($post['Customers']['from_date']));
            $to_date = date('Y-m-d', strtotime($post['Customers']['to_date']));
            }else{
            $from_date = '';
            $to_date = '';
            }
            
            $session->remove('session_from_date');
            $session->remove('session_to_date');
            $session->remove('profession');
            $session->remove('flag_newsletter');

            $session->set('session_from_date',$from_date);
            $session->set('session_to_date',$to_date);   
            $session->set('profession',$post['Customers']['profession']);   
            $session->set('flag_newsletter',$post['Customers']['flag_newsletter']);   
            
            $query = Customers::find();
            $query->andWhere("flagdelete = 0");
            $profession = $post['Customers']['profession'];
            if(!empty($profession))
            {
                $query->andWhere("profession = '$profession'");
            }
            $flagNewsletter = $post['Customers']['flag_newsletter'];
            if(!empty($flagNewsletter))
            {
                $query->andWhere("flag_newsletter = '$flagNewsletter'");
            }
            if(!empty($from_date) && !empty($to_date))
            $query->andWhere("DATE(created_at) between '$from_date' AND '$to_date'");
            
            
            
        }
        else
        {
            $session = Yii::$app->session;  
            $session_from_date = $session->get('session_from_date');
            $session_to_date = $session->get('session_to_date');
            $profession = $session->get('profession');
            $flagNewsletter = $session->get('flag_newsletter');

            //$query = Customers::find()->where("DATE(created_at) between '$session_from_date' AND '$session_to_date' AND flagdelete = 0");    
            $query = Customers::find();
            $query->andWhere("flagdelete = 0");
            if(!empty($profession))
            {
                $query->andWhere("profession = '$profession'");
            }
            if(!empty($flagNewsletter))
            {
                $query->andWhere("flag_newsletter = '$flagNewsletter'");
            }
            if(!empty($session_from_date) && !empty($session_to_date))
            $query->andWhere("DATE(created_at) between '$session_from_date' AND '$session_to_date'");
        }
        $dataProvider = new ActiveDataProvider([
                'query' => $query,
            'sort'=> ['defaultOrder' => ['customer_id'=>SORT_DESC]]
            ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'customer_id' => $this->customer_id,
            'phone_number' => $this->phone_number,
            'status' => $this->status,
            'flagdelete' => $this->flagdelete,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'flag_newsletter', $this->flag_newsletter])
            ->andFilterWhere(['like', 'profession', $this->profession]);

        return $dataProvider;
    }
}
