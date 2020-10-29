<?php

use yii\db\Migration;

/**
 * Class m201026_044821_product
 */
class m201026_044821_product extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'tittle' => $this->string()->notNull(),
            'subject' => $this->string()->notNull(),
            'price' => $this->integer()->notNull(),
            'img' => $this->string()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('product');
    }

}
