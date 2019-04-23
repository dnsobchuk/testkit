<?php

use app\models\User;
use yii\db\Migration;

/**
 * Class m190420_104902_create_tables
 */
class m190420_104902_create_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('USERS', [
            'ID_USER'               => $this->primaryKey(),
            'LOGIN'                 => $this->string()->notNull()->unique()->comment('Логин'),
            'PASSWORD'              => $this->string()->notNull()->comment('Пароль'),
            'EMAIL'                 => $this->string()->notNull()->unique()->comment('email'),
            'PHONE'                 => $this->string()->notNull()->unique()->comment('Номер телефона'),
            'ACCESS_LEVEL'          => $this->integer()->notNull()->defaultValue(User::ACCESS_LEVEL_RESULT)
            ->comment('Уровень доступа, по умолчанию доступ к просмотру результов тестирования'),
            'EXPIRES_DATE_TIME'     => $this->string()->notNull()->defaultValue(strtotime("+1 day"))
                ->comment('Дата и время действия аккаунта')
        ]);

        $this->createTable('TESTS',[
            'ID_TEST'               => $this->primaryKey(),
            'TITLE_TEST'            => $this->string()->notNull()->unique(),
        ]);

        $this->createTable('QUESTIONS', [
            'ID_QUESTION'           => $this->primaryKey(),
            'FID_TEST'              => $this->integer()->notNull()->comment('ВК на тесты'),
            'CONTENT_QUESTION'      => $this->string(4000)->notNull()->comment('Текст вопроса'),

        ]);

        $this->createTable('ANSWERS', [
            'ID_ANSWER'             => $this->primaryKey(),
            'FID_QUESTION'          => $this->integer()->notNull()->comment('ВК на вопросы'),
            'CONTENT_ANSWER'        => $this->string(1000)->notNull()->comment('Текст ответа'),
            'IS_RIGHT'              => $this->integer(1)->notNull()->defaultValue(0)
                ->comment('Правильный ответ')
        ]);

        $this->createTable('RESULTS', [
            'ID_RESULT'             => $this->primaryKey(),
            'FID_USER'              => $this->integer()->notNull()->comment('ВК пользователя'),
            'FID_TEST'              => $this->integer()->notNull()->comment('ВК на тесты'),
            'RIGHT_ANSWERS'         => $this->integer()->comment('Количество правильных ответов'),
        ]);

        $this->createTable('USER_ANSWERS', [
            'FID_RESULTS'           => $this->integer()->notNull()->comment('ВК на полученные результаты'),
            'FID_RESULT_QUESTIONS'  => $this->integer()->notNull()->comment('ВК на пройденный вопрос'),
            'FID_RESULT_ANSWERS'    => $this->integer()->notNull()->comment('ВК на данный ответ')
        ]);

        $this->createTable('USER_TESTS', [
            'FID_USER'   => $this->integer()->notNull()->comment('ВК на пользователя'),
            'FID_TEST' => $this->integer()->notNull()->comment('ВК на тест'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('USER_TESTS');

        $this->dropTable('USER_ANSWERS');

        $this->dropTable('RESULTS');

        $this->dropTable('ANSWERS');

        $this->dropTable('QUESTIONS');

        $this->dropTable('TESTS');

        $this->dropTable('USERS');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190420_104902_create_tables cannot be reverted.\n";

        return false;
    }
    */
}
