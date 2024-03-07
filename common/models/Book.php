<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $article_number
 * @property string|null $date_receipt
 * @property string|null $author
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_receipt'], 'safe'],
            [['name', 'article_number', 'author'], 'string', 'max' => 255],
            ['date_receipt', 'filter', 'filter' => function ($value) {
                // Convert 'DD.MM.YYYY' format to 'YYYY-MM-DD'
                return Yii::$app->formatter->asDate($value, 'yyyy-MM-dd');
            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'name' => 'Наименование',
            'article_number' => 'артикул',
            'date_receipt' => 'Дата поступления',
            'author' => 'Автор',
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->date_receipt = date('d.m.Y',strtotime($this->date_receipt));
    }
}
