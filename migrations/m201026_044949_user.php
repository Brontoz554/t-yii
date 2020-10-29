<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m201026_044949_user
 */
class m201026_044949_user extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(100)->notNull(),
            'password' => $this->string(100)->notNull(),
            'email' => $this->string(100)->notNull(),
            'firstName' => $this->string(100)->notNull(),
            'lastName' => $this->string(100)->notNull(),
            'region' => $this->string(100)->notNull(),
            'phone' => $this->string(20)->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('user');
    }

}
