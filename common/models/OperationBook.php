<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "operation_book".
 *
 * @property int $id
 * @property int|null $operation_id
 * @property int|null $book_id
 * @property int|null $book_status_id
 *
 * @property Book $book
 * @property BookStatus $bookStatus
 * @property Operation $operation
 */
class OperationBook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operation_book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['operation_id', 'book_id', 'book_status_id'], 'integer'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['book_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookStatus::class, 'targetAttribute' => ['book_status_id' => 'id']],
            [['operation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operation::class, 'targetAttribute' => ['operation_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'operation_id' => 'Operation ID',
            'book_id' => 'Book ID',
            'book_status_id' => 'Book Status ID',
        ];
    }

    /**
     * Gets query for [[Book]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }

    /**
     * Gets query for [[BookStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookStatus()
    {
        return $this->hasOne(BookStatus::class, ['id' => 'book_status_id']);
    }

    /**
     * Gets query for [[Operation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOperation()
    {
        return $this->hasOne(Operation::class, ['id' => 'operation_id']);
    }
}
