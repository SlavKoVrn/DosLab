<?php

use yii\db\Migration;

/**
 * Class m240313_142449_create_tables_operation_operation_book
 */
class m240313_142449_create_tables_operation_operation_book extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%operation}}', [
            'id' => $this->primaryKey(),
            'employee_id' => $this->integer(),
            'client_id' => $this->integer(),
            'datetime' => $this->dateTime(),
            'type' => $this->string(10),
        ]);

        $this->createTable('{{%operation_book}}', [
            'id' => $this->primaryKey(),
            'operation_id' => $this->integer(),
            'book_id' => $this->integer(),
            'book_status_id' => $this->integer(),
        ]);

        $this->createIndex('idx-operation_book-operation_id', '{{%operation_book}}', 'operation_id');
        $this->createIndex('idx-operation_book-book_id', '{{%operation_book}}', 'book_id');
        $this->createIndex('idx-operation_book-book_status_id', '{{%operation_book}}', 'book_status_id');

        $this->addForeignKey(
            'fk-operation_book-operation_id',
            '{{%operation_book}}',
            'operation_id',
            '{{%operation}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-operation_book-book_id',
            '{{%operation_book}}',
            'book_id',
            '{{%book}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-operation_book-book_status_id',
            '{{%operation_book}}',
            'book_status_id',
            '{{%book_status}}',
            'id',
            'CASCADE'
        );

        $this->addColumn('{{%book}}', 'client_id', $this->integer()->defaultValue(0));
        $this->addColumn('{{%book}}', 'operation_id', $this->integer()->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropColumn('{{%book}}', 'client_id');
        $this->dropColumn('{{%book}}', 'operation_id');

        $this->dropForeignKey('fk-operation_book-operation_id', '{{%operation_book}}');
        $this->dropForeignKey('fk-operation_book-book_id', '{{%operation_book}}');
        $this->dropForeignKey('fk-operation_book-book_status_id', '{{%operation_book}}');

        $this->dropIndex('idx-operation_book-operation_id', '{{%operation_book}}');
        $this->dropIndex('idx-operation_book-book_id', '{{%operation_book}}');
        $this->dropIndex('idx-operation_book-book_status_id', '{{%operation_book}}');

        $this->dropTable('{{%operation_book}}');
        $this->dropTable('{{%operation}}');
    }

}
