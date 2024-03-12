<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $fio
 * @property string|null $passport
 * @property string|null $username
 */
class Client extends \yii\db\ActiveRecord
{
    public $email;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['fio', 'passport', 'username', 'email'], 'string', 'max' => 255],
            [['fio', 'passport', 'email'], 'required'],
            [['email'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'user_id' => 'Логин',
            'fio' => 'ФИО',
            'email' => 'Почта',
            'passport' => 'Паспорт',
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

    public function afterFind()
    {
        parent::afterFind();
        $this->email = $this->user->email ?? '';
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
