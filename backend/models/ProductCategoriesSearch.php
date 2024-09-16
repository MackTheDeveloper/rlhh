<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductCategories;

/**
 * ProductCategoriesSearch represents the model behind the search form about `backend\models\ProductCategories`.
 */
class ProductCategoriesSearch extends ProductCategories
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'parent_id', 'sort_order', 'status', 'flagdelete', 'deleted_by'], 'integer'],
            [['type', 'name', 'category_path', 'created_at'], 'safe'],
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
        if(isset($params['id']))
        {
        Yii::$app->session->set('currentProdCatId', $params['id']);    
        $query = ProductCategories::find()->where(['flagdelete'=>'0','parent_id'=>$params['id']]);    
        }
        else
        {
        Yii::$app->session->set('currentProdCatId', 0);    
        $query = ProductCategories::find()->where(['flagdelete'=>'0','parent_id'=>0]);
        }
        

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['category_id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'category_id' => $this->category_id,
            'parent_id' => $this->parent_id,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
            'flagdelete' => $this->flagdelete,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'category_path', $this->category_path]);

        return $dataProvider;
    }
}
