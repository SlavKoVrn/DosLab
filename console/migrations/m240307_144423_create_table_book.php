<?php
use common\models\Book;
use yii\db\Migration;
use Faker\Factory;

/**
 * Class m240307_144423_create_tables_book_author
 */
class m240307_144423_create_table_book extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'article_number' => $this->string(),
            'date_receipt' => $this->date(),
            'author' => $this->string(),
        ]);

        $faker = Factory::create('ru_RU');
        for ($i = 1; $i <= 100; $i++) {

            $randomTimestamp = mt_rand(strtotime('1900-01-01'), strtotime('2024-12-31'));
            $randomDate = date('Y-m-d', $randomTimestamp);

            $book = new Book;
            $book->setAttributes([
                'name' => $faker->realText(22),
                'article_number' => $faker->isbn13(),
                'date_receipt' => $randomDate,
                'author' => $faker->firstName.' '.$faker->lastName,
            ]);
            $book->save();
            echo "$book->id. $book->name - $book->article_number - $book->date_receipt - $book->author\n";
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%book}}');
    }

}
