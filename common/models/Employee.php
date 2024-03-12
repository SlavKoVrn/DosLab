<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $position_id
 * @property string|null $fio
 * @property string|null $username
 */
class Employee extends \yii\db\ActiveRecord
{
    public $email;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'position_id'], 'integer'],
            [['fio', 'username', 'email'], 'string', 'max' => 255],
            [['fio', 'email'], 'required'],
            [['email'], 'email'],
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->email = $this->user->email ?? '';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'user_id' => 'Логин',
            'position_id' => 'Должность',
            'fio' => 'ФИО',
            'username' => 'Логин',
            'email' => 'Почта',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'slug' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'fio',
                'slugAttribute' => 'username',
                'ensureUnique' => true,
            ],
        ];
    }

    public function getPosition()
    {
        return $this->hasOne(Position::class, ['id' => 'position_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
