<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Threads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="threads-index">


    <div class="container" style="margin-top: 35px">
      <section class="row clearfix">
          <h1><?= Html::encode($this->title) ?></h1>
        <p class="lead">Please follow the forum rules. To prevent duplicate posts, please, always do a research first (when it will be implemented!) :) </p>

        <?php
        $disabled = '';
         if (Yii::$app->user->isGuest) {
          $disabled = 'disabled';
        } ?>
        <?= Html::a('Create Threads', ['create'], ['class' => 'btn btn-success '.$disabled]) ?>
      </section>
    </div>
    <hr>

    <!-- COMMON -->
    <?php if ( !empty($threads)) { ?>

      <?= $this->render('_single_thread', array('threads'=>$threads)); ?>

    <?php } else { ?>

      <?= $this->render('_empty',array('message'=>'No threads have been created yet!')); ?>

    <?php } ?>
    <!-- !COMMON -->

</div>
