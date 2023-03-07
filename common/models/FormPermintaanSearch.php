<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FormPermintaan;

/**
 * FormPermintaanSearch represents the model behind the search form of `common\models\FormPermintaan`.
 */
class FormPermintaanSearch extends FormPermintaan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['ref_agent', 'no_spaj', 'data_spaj', 'created_date', 'status', 'api_response', 'remark', 'otp_code'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = FormPermintaan::find();

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
            'id' => $this->id,
            'created_date' => $this->created_date,
        ]);

        $query->andFilterWhere(['like', 'ref_agent', $this->ref_agent])
            ->andFilterWhere(['like', 'no_spaj', $this->no_spaj])
            ->andFilterWhere(['like', 'data_spaj', $this->data_spaj])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'api_response', $this->api_response])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'otp_code', $this->otp_code]);
			
		$query->orderBy(['id'=>SORT_DESC]);

        return $dataProvider;
    }
}
