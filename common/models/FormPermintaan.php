<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "form_permintaan".
 *
 * @property string $id
 * @property string $ref_agent
 * @property string $no_spaj
 * @property string $data_spaj
 * @property string $created_date
 * @property string $status
 * @property string $api_response
 * @property string $remark
 * @property string $otp_code
 */
class FormPermintaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'form_permintaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data_spaj'], 'required'],
            [['data_spaj', 'api_response', 'remark'], 'string'],
            [['created_date'], 'safe'],
            [['ref_agent', 'no_spaj'], 'string', 'max' => 60],
            [['status'], 'string', 'max' => 30],
            [['otp_code'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ref_agent' => 'Ref Agent',
            'no_spaj' => 'No Spaj',
            'data_spaj' => 'Data Spaj',
            'created_date' => 'Created Date',
            'status' => 'Status',
            'api_response' => 'Api Response',
            'remark' => 'Remark',
            'otp_code' => 'Otp Code',
        ];
    }
}
