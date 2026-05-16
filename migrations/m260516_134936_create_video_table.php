<?php

use app\migrations\Migration;

/**
 * Handles the creation of table `{{%video}}`.
 */
class m260516_134936_create_video_table extends Migration
{
    private $tableName = '{{%video}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('ID'),
            'title_ru' => $this->string()->comment('Название(Русский)'),
            'title_en' => $this->string()->comment('Название(Английский)'),
            'title_ky' => $this->string()->comment('Название(Кыргызский)'),
            'description_ru' => $this->text()->comment('Описание(Русский)'),
            'description_en' => $this->text()->comment('Описание(Английский)'),
            'description_ky' => $this->text()->comment('Описание(Кыргызский)'),
            'url' => $this->string()->notNull()->comment('Ссылка'),
            'description_position' => $this->tinyInteger()->notNull()->defaultValue(0)->comment('Расположение описания'),
            'created_at' => $this->integer()->comment('Создано'),
            'updated_at' => $this->integer()->comment('Обновлено'),
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
