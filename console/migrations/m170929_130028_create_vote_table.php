<?php

use yii\db\Migration;

/**
 * Handles the creation of table `likes`.
 */
class m170929_130028_create_vote_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        // by this table the management of "just one vote" is easy.
        // If a day, this forum will be used like Facebook, something MUST change :)

        $this->createTable('vote', [
          'id'          => $this->primaryKey(),
				  'up'          => $this->boolean()->defaultValue(0),
				  'down'        => $this->boolean()->defaultValue(0),
          'thread_id'   => $this->integer(),
          'post_id'     => $this->integer(),
          'user_id'     => $this->integer()->notNull(), // keep trace of user: we MUST know if he can do it again
          'created_at'  => $this->integer()->notNull(),
          'updated_at'  => $this->integer()->notNull(),
  			]);

        $this->addForeignKey('FK_vote_thread_id', 'vote', 'thread_id', 'thread', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_vote_post_id',   'vote', 'post_id', 'post', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_vote_user_id',   'vote', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('vote');
    }
}
