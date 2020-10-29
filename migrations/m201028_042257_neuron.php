<?php

use yii\db\Migration;

/**
 * Class m201028_042257_neuron
 */
class m201028_042257_neuron extends Migration
{

    public function up()
    {
        $this->createTable('{{%neuron}}', [
            'id' => $this->primaryKey(),
            'amount' => $this->integer()->notNull(),
            'name_on_card' => $this->string(200)->notNull(),
            'cart_number' => $this->integer(50)->notNull(),
            'expries' => $this->string(10)->notNull(),
            'security code' => $this->integer(10)->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%neuron}}');
    }

}
