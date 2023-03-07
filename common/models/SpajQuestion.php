<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "spaj_question".
 *
 * @property string $id
 * @property int $spaj_id
 * @property int $question_id
 * @property string $desc
 * @property int $desc_value
 */
class SpajQuestion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'spaj_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['spaj_id', 'question_id'], 'required'],
            [['spaj_id', 'question_id', 'desc_value'], 'integer'],
            [['desc'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'spaj_id' => 'Spaj ID',
            'question_id' => 'Question ID',
            'desc' => 'Desc',
            'desc_value' => 'Desc Value',
        ];
    }
}
