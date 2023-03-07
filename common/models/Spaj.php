<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "spaj".
 *
 * @property string $id
 * @property string $fullname
 * @property string $identity_type
 * @property string $identity_number
 * @property string $birth_place
 * @property string $birth_date
 * @property string $gender
 * @property string $marital_status
 * @property string $identity_address
 * @property string $residential_address
 * @property string $jobs_desc
 * @property string $business_fields
 * @property string $business_position
 * @property string $business_institution_name
 * @property string $business_institution_address
 * @property string $business_contact
 * @property string $correspondence_address
 * @property string $relationship_insured
 * @property string $insured_fullname
 * @property string $insured_identity_type
 * @property string $insured_identity_number
 * @property string $insured_birth_place
 * @property string $insured_birth_date
 * @property string $insured_gender
 * @property string $insured_marital_status
 * @property string $insured_identity_address
 * @property string $insured_residential_address
 * @property string $insured_jobs_desc
 * @property string $insured_business_fields
 * @property string $insured_business_position
 * @property string $insured_business_institution_name
 * @property string $insured_business_institution_address
 * @property string $insured_business_contact
 * @property string $is_premi_polis
 * @property string $insurance_protection
 * @property string $source_income
 * @property string $gross_income
 * @property string $payment_method
 * @property string $pay_interval
 * @property string $insurance_class
 * @property string $additional_benefit
 * @property string $provider
 * @property string $insurance_period
 * @property string $currency
 * @property string $history_insurance
 * @property string $history_insurance_desc
 */
class Spaj extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'spaj';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fullname', 'identity_type', 'identity_number', 'birth_date', 'gender', 'marital_status', 'jobs_desc', 'business_fields', 'business_position', 'business_institution_name', 'insured_fullname', 'insured_identity_type', 'insured_identity_number', 'insured_birth_date', 'insured_gender', 'insured_marital_status', 'insured_jobs_desc', 'insured_business_fields', 'insured_business_position', 'insured_business_institution_name'], 'string', 'max' => 100],
            [['birth_place', 'insured_birth_place'], 'string', 'max' => 30],
            [['identity_address', 'residential_address', 'business_institution_address', 'insured_identity_address', 'insured_residential_address', 'insured_business_institution_address', 'history_insurance_desc'], 'string', 'max' => 250],
            [['business_contact', 'correspondence_address', 'relationship_insured', 'insured_business_contact', 'is_premi_polis', 'insurance_protection', 'source_income', 'gross_income', 'payment_method', 'pay_interval', 'insurance_class', 'additional_benefit', 'provider', 'insurance_period', 'currency', 'history_insurance'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fullname' => 'Fullname',
            'identity_type' => 'Identity Type',
            'identity_number' => 'Identity Number',
            'birth_place' => 'Birth Place',
            'birth_date' => 'Birth Date',
            'gender' => 'Gender',
            'marital_status' => 'Marital Status',
            'identity_address' => 'Identity Address',
            'residential_address' => 'Residential Address',
            'jobs_desc' => 'Jobs Desc',
            'business_fields' => 'Business Fields',
            'business_position' => 'Business Position',
            'business_institution_name' => 'Business Institution Name',
            'business_institution_address' => 'Business Institution Address',
            'business_contact' => 'Business Contact',
            'correspondence_address' => 'Correspondence Address',
            'relationship_insured' => 'Relationship Insured',
            'insured_fullname' => 'Insured Fullname',
            'insured_identity_type' => 'Insured Identity Type',
            'insured_identity_number' => 'Insured Identity Number',
            'insured_birth_place' => 'Insured Birth Place',
            'insured_birth_date' => 'Insured Birth Date',
            'insured_gender' => 'Insured Gender',
            'insured_marital_status' => 'Insured Marital Status',
            'insured_identity_address' => 'Insured Identity Address',
            'insured_residential_address' => 'Insured Residential Address',
            'insured_jobs_desc' => 'Insured Jobs Desc',
            'insured_business_fields' => 'Insured Business Fields',
            'insured_business_position' => 'Insured Business Position',
            'insured_business_institution_name' => 'Insured Business Institution Name',
            'insured_business_institution_address' => 'Insured Business Institution Address',
            'insured_business_contact' => 'Insured Business Contact',
            'is_premi_polis' => 'Is Premi Polis',
            'insurance_protection' => 'Insurance Protection',
            'source_income' => 'Source Income',
            'gross_income' => 'Gross Income',
            'payment_method' => 'Payment Method',
            'pay_interval' => 'Pay Interval',
            'insurance_class' => 'Insurance Class',
            'additional_benefit' => 'Additional Benefit',
            'provider' => 'Provider',
            'insurance_period' => 'Insurance Period',
            'currency' => 'Currency',
            'history_insurance' => 'History Insurance',
            'history_insurance_desc' => 'History Insurance Desc',
        ];
    }
}
