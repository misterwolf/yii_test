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

    <?php if (Yii::$app->user->id == $model->author->id){ ?>
      <?= $this->render('_editing', array('model'=>$model)); ?>
    <?php }?>

    <?php // render the first info about thread with a summeray version ?>
    <?= $this->render('_single_thread', array('thread'=>$model, 'summaryVersion' => true)); ?>

    <?php // TODO: change this=> $model->posts when you'll need Dynmical Query ?>
    <?php if ( !empty( $model->getPost()->all() ) ) { ?>

      <?php foreach ($model->post as $post) { ?>
        <?= $this->render('_single_post', array('post'=> $post )) ?>
      <?php } ?>

    <?php } else { ?>
              <?= $this->render('_empty',array('message'=>'No posts have been created for this thread yet!')); ?>
    <?php } ?>

      <section class="container">
        <section class="row clearfix">
          <?php
           if (!Yii::$app->user->isGuest) { ?>
             <?= Html::button('Write a post', ['value' => Url::to(['threads/'.$model->id.'/posts/create']), 'title' => 'Write a post', 'class' => 'showModalButton btn btn-success ' ]); ?>
          <?php } ?>
          <?php // with a tag, showmodalbutton doesn't work properly: FURTHER INVESTIGATION ?>
          <?//= Html::a('Write a post', ['threads/'.$model->id.'/posts/create'], ['class' => 'showModalButton btn btn-success '.$disabled]) ?>
        </section>
      </section>

</div>
