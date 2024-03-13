<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "operation".
 *
 * @property int $id
 * @property int|null $employee_id
 * @property int|null $client_id
 * @property string|null $datetime
 * @property string|null $type
 *
 * @property OperationBook[] $operationBooks
 */
class Operation extends \yii\db\ActiveRecord
{
    const OPERATION_TYPE_ISSUANCE = 'issuance';
    const OPERATION_TYPE_RETURN = 'return';

    public static $types = [
        self::OPERATION_TYPE_ISSUANCE => 'выдача',
        self::OPERATION_TYPE_RETURN => 'возврат',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'client_id'], 'integer'],
            [['datetime'], 'safe'],
            [['type'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'type' => 'Операция',
            'employee_id' => 'Сотрудник',
            'client_id' => 'Клиент',
            'datetime' => 'Дата время',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['datetime'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert){
            $this->employee_id = Yii::$app->user->identity->employee->id;
        }

        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[OperationBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOperationBooks()
    {
        return $this->hasMany(OperationBook::class, ['operation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    public function getClientData()
    {
        return ($this->client)?[$this->client->id => $this->client->fio]:[];
    }

}
