<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170922_144428_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'email' => $this->string()->defaultValue(null),
            'password' => $this->string(),
            'status' => $this->integer(),
            'isAdmin' => $this->integer()->defaultValue(0)
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
