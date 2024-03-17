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

    public $book = '';
    public $books = [];

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
            [['client_id'], 'required'],
            [['employee_id', 'book'], 'integer'],
            [['datetime', 'books', 'client_id'], 'safe'],
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
            'book' => 'Книга',
            'books' => 'Выбранные книги',
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
            $this->employee_id = Yii::$app->user->identity->employee->id ?? 1;
        }

        return parent::beforeSave($insert);
    }

    public function saveBooks($books)
    {
        $bookStatus = [];
        $newBooks = [];
        foreach ($books as $book){
            $newBooks[] = intval($book['book_id']);
            $bookStatus[$book['book_id']] = intval($book['book_status_id']);
        }
        $currentBooks = ArrayHelper::map($this->operationBooks,'book_id','book_id');

        $toInsert = [];
        foreach (array_filter(array_diff($newBooks,$currentBooks)) as $book_id){
            $toInsert[] = $book_id;
        }
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if ($toInsert){
                foreach ($toInsert as $book_id){
                    $operationBook = new OperationBook;
                    $operationBook->setAttributes([
                        'operation_id' => $this->id,
                        'book_id' => $book_id,
                        'book_status_id' => $bookStatus[$book_id],
                    ]);
                    $operationBook->save();
                }
            }
            if ($toRemove = array_filter(array_diff($currentBooks,$newBooks))){
                OperationBook::deleteAll([
                    'operation_id'=>$this->id,
                    'book_id'=>$toRemove
                ]);
                foreach ($toRemove as $delBook){
                    $book = Book::findOne($delBook);
                    $book->client_id = 0;
                    $book->operation_id = 0;
                    $book->save();
                }
            }
            foreach ($newBooks as $newBook){
                $opBook = OperationBook::find()->where(['and',
                    ['operation_id' => $this->id],
                    ['book_id' => $newBook],
                ])->one();
                if ($opBook and $opBook->book_status_id != $bookStatus[$newBook]){
                    $opBook->book_status_id = $bookStatus[$newBook];
                    $opBook->save();
                }
                $book = Book::findOne($newBook);
                $book->book_status_id = $bookStatus[$newBook];
                $book->client_id = $this->client_id;
                $book->operation_id = $this->id;
                $book->save();
            }
            $transaction->commit();
        } catch (\Exception $e) {
            \Yii::$app->session->addFlash('danger', $e->getMessage());
            $transaction->rollBack();
        }
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

    public function getCurrentBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->viaTable(OperationBook::tableName(), ['operation_id' => 'id']);
    }

}
