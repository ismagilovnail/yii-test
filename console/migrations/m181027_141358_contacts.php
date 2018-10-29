<?php

use yii\db\Migration;

/**
 * Class m181027_141358_contacts
 */
class m181027_141358_contacts extends Migration
{
    
    public function up()
    {
        $this->createTable('{{%contacts}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'body' => $this->text()->notNull(),
            'file' => $this->string(),
            'user_id' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-contacts-id', '{{%contacts}}', 'id');
        $this->createIndex('idx-contacts-user_id', '{{%contacts}}', 'user_id');
        $this->createIndex('idx-contacts-status', '{{%contacts}}', 'status');
        $this->createIndex('idx-contacts-title', '{{%contacts}}', 'title');

         // add foreign key for table `user`
        $this->addForeignKey(
            'fk-contacts-user_id',
            '{{%contacts}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-contacts-user_id',
            '{{%contacts}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            'idx-contacts-title',
            'idx-contacts-status',
            'idx-contacts-id',
            'idx-contacts-user_id',
            '{{%contacts}}'
        );

        $this->dropTable('{{%contacts}}');
    }
}
