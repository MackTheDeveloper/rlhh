<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Collaboration;

/**
 * CollaborationSearch represents the model behind the search form about `backend\models\Collaboration`.
 */
class CollaborationSearch extends Collaboration
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['collaboration_id', 'status', 'flagdelete', 'deleted_by'], 'integer'],
            [['title', 'description','created_at'], 'safe'],
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
        $query = Collaboration::find()->where("flagdelete = 0");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['collaboration_id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'collaboration_id' => $this->collaboration_id,
            'status' => $this->status,
            'flagdelete' => $this->flagdelete,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
