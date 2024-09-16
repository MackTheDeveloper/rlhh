<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TrainerSubjects;

/**
 * TrainerSubjectsSearch represents the model behind the search form about `backend\models\TrainerSubjects`.
 */
class TrainerSubjectsSearch extends TrainerSubjects
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trainer_subject_id', 'trainer_id'], 'integer'],
            [['subject_name', 'subject_value'], 'safe'],
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
        $query = TrainerSubjects::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['trainer_subject_id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'trainer_subject_id' => $this->trainer_subject_id,
            'trainer_id' => $this->trainer_id,
        ]);

        $query->andFilterWhere(['like', 'subject_name', $this->subject_name])
            ->andFilterWhere(['like', 'subject_value', $this->subject_value]);

        return $dataProvider;
    }
}
