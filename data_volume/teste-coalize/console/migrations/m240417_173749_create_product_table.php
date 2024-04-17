<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m240417_173749_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'preco' => $this->decimal(10, 2)->notNull(),
            'cliente_id' => $this->integer()->notNull(),
            'foto' => $this->string(),
        ]);

        $this->addForeignKey(
            'fk-product-client',
            '{{%product}}',
            'cliente_id',
            '{{%client}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-product-client', '{{%product}}');
        $this->dropTable('{{%product}}');
    }
}
