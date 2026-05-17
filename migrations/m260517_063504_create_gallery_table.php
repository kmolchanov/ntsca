<?php

use app\migrations\Migration;

/**
 * Handles the creation of table `{{%gallery}}`.
 */
class m260517_063504_create_gallery_table extends Migration
{
    private $tableName = '{{%gallery}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('ID'),
            'title_ru' => $this->string()->comment('Название(Русский)'),
            'created_at' => $this->integer()->comment('Создана'),
            'updated_at' => $this->integer()->comment('Обновлена'),
        ], $this->tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
