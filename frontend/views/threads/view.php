<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Threads */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Threads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="threads-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->id == $model->author->id){ ?>
      <?= $this->render('_editing', array('model'=>$model)); ?>
    <?php }?>

    <?php // render the first info about thread with a summeray version ?>
    <?= $this->render('_single_thread', array('thread'=>$model, 'summaryVersion' => true)); ?>

    <?php // TODO: change this=> $model->posts when you'll need Dynmical Query ?>
    <?php if ( !empty( $model->getPost() ) ) { ?>

      <?= $this->render('_single_post', array('posts'=> $model->post )) ?>

    <?php } else { ?>

      <?= $this->render('_empty',array('message'=>'No posts have been created for this thread yet!')); ?>

    <?php } ?>

      <section class="container">
        <section class="row clearfix">
          <?php
          $disabled = '';
           if (Yii::$app->user->isGuest) {
            $disabled = 'disabled';
          } ?>
          <?php if (!Yii::$app->user->isGuest) { ?>
            <?= Html::button('Write a post', ['value' => Url::to(['threads/'.$model->id.'/posts/create']), 'title' => 'Write a post', 'class' => 'showModalButton btn btn-success ' ]); ?>
            <?//= Html::a('Reply with a post', ['threads/'.$model->id.'/posts/create'], ['class' => 'btn btn-success '.$disabled]) ?>
          <?php } ?>
        </section>
      </section>
</div>
