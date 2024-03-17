<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "book_status".
 *
 * @property int $id
 * @property string|null $name
 */
class BookStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'name' => 'Состояние книги',
        ];
    }

    public static function getStatuses()
    {
        return ArrayHelper::map(self::find()->orderBy('name')->all(),'id','name');
    }

    public static function getStatusById($id)
    {
        $statuses = self::getStatuses();
        return $statuses[$id];
    }
}
