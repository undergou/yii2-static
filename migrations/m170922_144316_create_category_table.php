<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m170922_144316_create_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'id_parent' => $this->integer(),
            'slug' => $this->string(),
            'status' => $this->integer()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('category');
    }
}
