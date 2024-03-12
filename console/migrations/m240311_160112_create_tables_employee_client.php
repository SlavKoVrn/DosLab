<?php
use common\models\User;
use common\models\Employee;
use common\models\Client;
use common\models\Position;
use common\helpers\FakerProvider;
use yii\db\Migration;
use Faker\Factory;

/**
 * Class m240311_160112_create_tables_employee_client
 */
class m240311_160112_create_tables_employee_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $adminRole = $auth->createRole(User::USER_ROLE_ADMINISTRATOR);
        $employeeRole = $auth->createRole(User::USER_ROLE_EMPLOYEE);
        $clientRole = $auth->createRole(User::USER_ROLE_CLIENT);

        $auth->add($adminRole);
        $auth->add($employeeRole);
        $auth->add($clientRole);

        $auth->assign($adminRole, User::ADMINISTRATOR_USER_ID);
        $auth->assign($employeeRole, User::ADMINISTRATOR_USER_ID);
        $auth->assign($clientRole, User::ADMINISTRATOR_USER_ID);

        $this->createTable('{{%position}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);

        $this->createTable('{{%employee}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'position_id' => $this->integer(),
            'fio' => $this->string(),
            'username' => $this->string(),
        ]);

        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'fio' => $this->string(),
            'passport' => $this->string(),
            'username' => $this->string(),
        ]);

        $faker = Factory::create('ru_RU');
        for ($i = 1; $i <= 10; $i++) {

            $position = new Position;
            $position->setAttributes([
                'name' => $faker->jobTitle,
            ]);
            $position->save();
            echo "$position->id. $position->name\n";
        }

        $faker->addProvider(new FakerProvider($faker));
        for ($i = 1; $i <= 100; $i++) {

            $client = new Client;
            $client->setAttributes([
                'fio' => $faker->firstName.' '.$faker->lastName,
                'passport' => $faker->passportNumber,
            ]);
            $client->save();

            $user = new User;
            $user->setAttributes([
                'username' => $client->username,
                'auth_key' => md5(time()),
                'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
                'password_reset_token' => Yii::$app->security->generateRandomString(),
                'email' => $faker->email,
                'verification_token' => '',
                'created_at' => time(),
                'updated_at' => time(),
            ],false);
            $user->save();

            $client->user_id = $user->id;
            $client->save();

            $auth->assign($clientRole, $user->id);

            echo "$client->id. $client->fio - $client->passport\n";
        }

        for ($i = 1; $i <= 100; $i++) {

            $emploee = new Employee;
            $emploee->setAttributes([
                'fio' => $faker->firstName.' '.$faker->lastName,
                'position_id' => rand(1,10),
            ]);
            $emploee->save();

            $user = new User;
            $user->setAttributes([
                'username' => $emploee->username,
                'auth_key' => md5(time()),
                'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
                'password_reset_token' => Yii::$app->security->generateRandomString(),
                'email' => $faker->email,
                'verification_token' => '',
                'created_at' => time(),
                'updated_at' => time(),
            ],false);
            $user->save();

            $emploee->user_id = $user->id;
            $emploee->save();

            $auth->assign($employeeRole, $user->id);

            echo "$emploee->id. $emploee->fio - {$emploee->position->name}\n";
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $this->dropTable('{{%position}}');
        $this->dropTable('{{%employee}}');
        $this->dropTable('{{%client}}');

    }

}
