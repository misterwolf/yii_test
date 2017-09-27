<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

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




</div>
