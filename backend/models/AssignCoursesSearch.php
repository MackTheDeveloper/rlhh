<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AssignCourses;

/**
 * AssignCoursesSearch represents the model behind the search form about `backend\models\AssignCourses`.
 */
class AssignCoursesSearch extends AssignCourses
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assign_course_id', 'course_id', 'course_category_id'], 'integer'],
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
        $query = AssignCourses::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'assign_course_id' => $this->assign_course_id,
            'course_id' => $this->course_id,
            'course_category_id' => $this->course_category_id,
        ]);

        return $dataProvider;
    }
}
