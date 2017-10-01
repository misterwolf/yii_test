<?php

use yii\db\Migration;

class m171001_002727_add_views_to_thread extends Migration
{
  public function up()
  {
    $this->addColumn('thread', 'views', $this->integer()->defaultValue(0));

  }

  /**
   * @inheritdoc
   */
  public function down()
  {
    $this->dropColumn('thread', 'views');
  }
}
