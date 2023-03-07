<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "questions_option".
 *
 * @property int $id
 * @property string $option_text
 * @property int $point_value
 */
class QuestionsOption extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questions_option';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['option_text', 'question_id'], 'required'],
            [['point_value'], 'integer'],
            [['option_text'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'option_text' => 'Option Text',
            'point_value' => 'Point Value',
        ];
    }
}
