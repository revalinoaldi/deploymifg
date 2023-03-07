<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "questions".
 *
 * @property int $id
 * @property int $category_id
 * @property string $question_text
 * @property string $question_type
 * @property int $point_value
 * @property string $is_required
 * @property int $sort_order
 */
class Questions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'question_text', 'question_type', 'sort_order', 'input_name'], 'required'],
            [['category_id', 'point_value', 'sort_order'], 'integer'],
            [['question_text'], 'string'],
            [['children_of'], 'safe'],
            [['input_name'], 'unique'],
            [['question_type'], 'string', 'max' => 60],
            [['is_required'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'question_text' => 'Question Text',
            'question_type' => 'Question Type',
            'point_value' => 'Point Value',
            'is_required' => 'Is Required',
            'sort_order' => 'Sort Order',
            'children_of' => 'Grouping',
        ];
    }
}
