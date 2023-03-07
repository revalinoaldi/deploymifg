<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Spaj;

/**
 * SpajSearch represents the model behind the search form of `common\models\Spaj`.
 */
class SpajSearch extends Spaj
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['fullname', 'identity_type', 'identity_number', 'birth_place', 'birth_date', 'gender', 'marital_status', 'identity_address', 'residential_address', 'jobs_desc', 'business_fields', 'business_position', 'business_institution_name', 'business_institution_address', 'business_contact', 'correspondence_address', 'relationship_insured', 'insured_fullname', 'insured_identity_type', 'insured_identity_number', 'insured_birth_place', 'insured_birth_date', 'insured_gender', 'insured_marital_status', 'insured_identity_address', 'insured_residential_address', 'insured_jobs_desc', 'insured_business_fields', 'insured_business_position', 'insured_business_institution_name', 'insured_business_institution_address', 'insured_business_contact', 'is_premi_polis', 'insurance_protection', 'source_income', 'gross_income', 'payment_method', 'pay_interval', 'insurance_class', 'additional_benefit', 'provider', 'insurance_period', 'currency', 'history_insurance', 'history_insurance_desc'], 'safe'],
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
        $query = Spaj::find();

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
        ]);

        $query->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'identity_type', $this->identity_type])
            ->andFilterWhere(['like', 'identity_number', $this->identity_number])
            ->andFilterWhere(['like', 'birth_place', $this->birth_place])
            ->andFilterWhere(['like', 'birth_date', $this->birth_date])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'marital_status', $this->marital_status])
            ->andFilterWhere(['like', 'identity_address', $this->identity_address])
            ->andFilterWhere(['like', 'residential_address', $this->residential_address])
            ->andFilterWhere(['like', 'jobs_desc', $this->jobs_desc])
            ->andFilterWhere(['like', 'business_fields', $this->business_fields])
            ->andFilterWhere(['like', 'business_position', $this->business_position])
            ->andFilterWhere(['like', 'business_institution_name', $this->business_institution_name])
            ->andFilterWhere(['like', 'business_institution_address', $this->business_institution_address])
            ->andFilterWhere(['like', 'business_contact', $this->business_contact])
            ->andFilterWhere(['like', 'correspondence_address', $this->correspondence_address])
            ->andFilterWhere(['like', 'relationship_insured', $this->relationship_insured])
            ->andFilterWhere(['like', 'insured_fullname', $this->insured_fullname])
            ->andFilterWhere(['like', 'insured_identity_type', $this->insured_identity_type])
            ->andFilterWhere(['like', 'insured_identity_number', $this->insured_identity_number])
            ->andFilterWhere(['like', 'insured_birth_place', $this->insured_birth_place])
            ->andFilterWhere(['like', 'insured_birth_date', $this->insured_birth_date])
            ->andFilterWhere(['like', 'insured_gender', $this->insured_gender])
            ->andFilterWhere(['like', 'insured_marital_status', $this->insured_marital_status])
            ->andFilterWhere(['like', 'insured_identity_address', $this->insured_identity_address])
            ->andFilterWhere(['like', 'insured_residential_address', $this->insured_residential_address])
            ->andFilterWhere(['like', 'insured_jobs_desc', $this->insured_jobs_desc])
            ->andFilterWhere(['like', 'insured_business_fields', $this->insured_business_fields])
            ->andFilterWhere(['like', 'insured_business_position', $this->insured_business_position])
            ->andFilterWhere(['like', 'insured_business_institution_name', $this->insured_business_institution_name])
            ->andFilterWhere(['like', 'insured_business_institution_address', $this->insured_business_institution_address])
            ->andFilterWhere(['like', 'insured_business_contact', $this->insured_business_contact])
            ->andFilterWhere(['like', 'is_premi_polis', $this->is_premi_polis])
            ->andFilterWhere(['like', 'insurance_protection', $this->insurance_protection])
            ->andFilterWhere(['like', 'source_income', $this->source_income])
            ->andFilterWhere(['like', 'gross_income', $this->gross_income])
            ->andFilterWhere(['like', 'payment_method', $this->payment_method])
            ->andFilterWhere(['like', 'pay_interval', $this->pay_interval])
            ->andFilterWhere(['like', 'insurance_class', $this->insurance_class])
            ->andFilterWhere(['like', 'additional_benefit', $this->additional_benefit])
            ->andFilterWhere(['like', 'provider', $this->provider])
            ->andFilterWhere(['like', 'insurance_period', $this->insurance_period])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'history_insurance', $this->history_insurance])
            ->andFilterWhere(['like', 'history_insurance_desc', $this->history_insurance_desc]);

        return $dataProvider;
    }
}
