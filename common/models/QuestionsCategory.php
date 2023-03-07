<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "questions_category".
 *
 * @property int $id
 * @property string $category_name
 * @property string $text_1
 * @property string $text_2
 * @property string $text_3
 * @property int $sort_order
 */
class QuestionsCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questions_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_name', 'sort_order'], 'required'],
            [['text_1', 'text_2', 'text_3'], 'string'],
            [['sort_order'], 'integer'],
            [['category_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_name' => 'Category Name',
            'text_1' => 'Text 1',
            'text_2' => 'Text 2',
            'text_3' => 'Text 3',
            'sort_order' => 'Sort Order',
        ];
    }
}
