<?php

use app\migrations\Migration;

/**
 * Handles adding columns to table `{{%page}}`.
 */
class m260517_093420_add_additional_columns_to_page_table extends Migration
{
    private $tableName = '{{%page}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'content_ru', $this->text()->comment('Содержимое(Русский)')->after('menu_title_ky'));
        $this->addColumn($this->tableName, 'content_en', $this->text()->comment('Содержимое(Английский)')->after('content_ru'));
        $this->addColumn($this->tableName, 'content_ky', $this->text()->comment('Содержимое(Кыргызский)')->after('content_en'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'content_ky');
        $this->dropColumn($this->tableName, 'content_en');
        $this->dropColumn($this->tableName, 'content_ru');
    }
}
