<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Teachingteam;

/**
 * TeachingteamSearch represents the model behind the search form about `backend\models\Teachingteam`.
 */
class TeachingteamSearch extends Teachingteam
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['teaching_team_id', 'status', 'flagdelete', 'deleted_by'], 'integer'],
            [['title', 'description', 'created_at','type'], 'safe'],
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
        $query = Teachingteam::find()->where("flagdelete = 0");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['teaching_team_id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'teaching_team_id' => $this->teaching_team_id,
            'status' => $this->status,
            'flagdelete' => $this->flagdelete,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
