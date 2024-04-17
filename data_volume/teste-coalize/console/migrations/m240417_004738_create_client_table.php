<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client}}`.
 */
class m240417_004738_create_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'cpf' => $this->string()->notNull()->unique(),
            'cep' => $this->string()->notNull(),
            'logradouro' => $this->string()->notNull(),
            'numero' => $this->string()->notNull(),
            'cidade' => $this->string()->notNull(),
            'estado' => $this->string()->notNull(),
            'complemento' => $this->string(),
            'foto' => $this->string(),
            'sexo' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%client}}');
    }
}
