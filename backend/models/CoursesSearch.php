<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Courses;

/**
 * CoursesSearch represents the model behind the search form about `backend\models\Courses`.
 */
class CoursesSearch extends Courses
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id',   'status', 'flagdelete', 'deleted_by'], 'integer'],
            [['course_name','course_category_id', 'image', 'type','trainer','course_to_date','course_date', 'time_duration', 'overview', 'highlight', 'class_size', 'fees', 'created_at'], 'safe'],
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
        $query = Courses::find()->where("courses.flagdelete = 0");;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['course_id'=>SORT_DESC]]
        ]);

        $this->load($params);
        $query->joinWith('category');
        $query->join('LEFT JOIN','trainer','FIND_IN_SET(trainer_id,trainer)');
        //$query->joinWith('trainer');
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'course_id' => $this->course_id,
           // 'course_category_id' => $this->course_category_id,
            //'course_date' => $this->course_date,
            //'trainer' => $this->trainer,
            'courses.status' => $this->status,
            'flagdelete' => $this->flagdelete,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'course_name', $this->course_name])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'courses.type', $this->type])
            ->andFilterWhere(['like', 'time_duration', $this->time_duration])
            ->andFilterWhere(['like', 'overview', $this->overview])
            ->andFilterWhere(['like', 'highlight', $this->highlight])
            ->andFilterWhere(['like', 'class_size', $this->class_size])
            ->andFilterWhere(['like', 'fees', $this->fees])
            ->andFilterWhere(['like', 'categories.name', $this->course_category_id])
            ->andFilterWhere(['like', 'date(course_date)',$this->course_date])
            ->andFilterWhere(['like', 'date(course_to_date)',$this->course_to_date])
            ->andFilterWhere(['OR',['like', 'trainer.first_name', $this->trainer],['like', 'trainer.last_name', $this->trainer]]);
                

        return $dataProvider;
    }
}
