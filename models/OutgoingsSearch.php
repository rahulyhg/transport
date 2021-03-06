<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Outgoings;

/**
 * OutgoingsSearch represents the model behind the search form about `app\models\Outgoings`.
 */
class OutgoingsSearch extends Outgoings {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'price'], 'integer'],
            [['order_id', 'assign_id', 'detail', 'create_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Outgoings::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'create_date' => $this->create_date,
        ]);

        $query->andFilterWhere(['like', 'assign_id', $this->assign_id])
                ->andFilterWhere(['like', 'detail', $this->detail]);

        return $dataProvider;
    }

}
