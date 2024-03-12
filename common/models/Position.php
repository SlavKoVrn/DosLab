<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "position".
 *
 * @property int $id
 * @property string|null $name
 */
class Position extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'position';
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
            'name' => 'Должность',
        ];
    }

    public static function getPositions()
    {
        return ArrayHelper::map(self::find()->orderBy('name')->all(),'id','name');
    }
}
