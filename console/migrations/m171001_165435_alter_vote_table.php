<?php

use yii\db\Migration;

class m171001_165435_alter_vote_table extends Migration
{
    /* */
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
      $this->addColumn('vote', 'point', $this->integer()->defaultValue(0));
      $this->dropColumn('vote', 'up');
      $this->dropColumn('vote', 'down');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('vote', 'point');
        $this->addColumn('vote', 'up', $this->integer()->defaultValue(0));
        $this->addColumn('vote', 'point', $this->integer()->defaultValue(0));
    }
    /**/
}
