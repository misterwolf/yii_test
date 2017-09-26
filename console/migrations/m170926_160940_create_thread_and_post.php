<?php

use yii\db\Migration;

// ------------
// FIRST ASSETS FOR THREAD AND POST, ADDING FEATURE WILL BE ADDED BY (AN)OTHER MIGRATION(S)
// ------------

class m170926_160940_create_thread_and_post extends Migration
{

    public function safeUp()
    {
      // THREAD TABLE
      $this->createTable('{{%thread}}',
  			[
  				'id'          => $this->primaryKey(),
  				'title'       => $this->string(32)->notNull()->unique(), # can be
  				'content'     => $this->string(100)->notNull(),
          'views'       => $this->integer()->defaultValue(0),
          'author_id'   => $this->integer()->notNull(),
          'created_at'  => $this->integer()->notNull(),
          'updated_at'  => $this->integer()->notNull()
  			]);
      $this->createIndex('thread_title', 'thread', 'title', true);
      $this->createIndex('thread_created_at', 'thread', 'created_at', true);
      $this->addForeignKey('FK_thread_author_id', 'thread', 'author_id', 'user', 'id', 'CASCADE', 'CASCADE');

      // POST TABLE
      $this->createTable('{{%post}}', [
        'id'          => $this->primaryKey(),
				'content'     => $this->string(100)->notNull(),
        'thread_id'   => $this->integer()->notNull(),
        'author_id'   => $this->integer()->notNull(),
        'created_at'  => $this->integer()->notNull(),
        'updated_at'  => $this->integer()->notNull()
      ]);
      $this->createIndex('post_created_at', 'post', 'created_at', true);
      $this->addForeignKey('FK_post_thread_id',  'post', 'thread_id', 'thread', 'id', 'CASCADE', 'CASCADE');
      $this->addForeignKey('FK_post_author_id',  'post', 'author_id', 'user',   'id', 'CASCADE', 'CASCADE');

    }

    public function safeDown()
    {
      $this->dropTable('{{%post}}');
      $this->dropTable('{{%thread}}');
    }

}
