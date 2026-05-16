<?php

use app\migrations\Migration;

/**
 * Handles the creation of table `{{%page}}`.
 */
class m260516_063341_create_page_table extends Migration
{
    private $tableName = '{{%page}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('ID'),
            'lft' => $this->integer()->notNull()->comment('Left'),
            'rgt' => $this->integer()->notNull()->comment('Right'),
            'depth' => $this->integer()->notNull()->comment('Depth'),
            'slug' => $this->string(128)->notNull()->comment('Slug'),
            'title_ru' => $this->string()->comment('Название(Русский)'),
            'title_en' => $this->string()->comment('Название(Английский)'),
            'title_ky' => $this->string()->comment('Название(Кыргызский)'),
            'menu_title_ru' => $this->string()->comment('Название в меню(Русский)'),
            'menu_title_en' => $this->string()->comment('Название в меню(Английский)'),
            'menu_title_ky' => $this->string()->comment('Название в меню(Кыргызский)'),
            'is_active' => $this->boolean()->notNull()->defaultValue(false)->comment('Активная'),
            'is_main' => $this->boolean()->notNull()->defaultValue(false)->comment('Главная'),
            'show_in_menu' => $this->boolean()->notNull()->defaultValue(false)->comment('Показывать в меню'),
            'show_subpages' => $this->boolean()->notNull()->defaultValue(false)->comment('Показывать подстраницы'),
            'created_at' => $this->integer()->comment('Создана'),
            'updated_at' => $this->integer()->comment('Обновлена'),
        ], $this->tableOptions);

        $this->createIndex('page_slug_unique', $this->tableName, ['slug'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('page_slug_unique', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
