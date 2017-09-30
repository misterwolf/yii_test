<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<section class="row clearfix">
  <div class="col-md-12 column">
    <section class="panel panel-default ">
      <section class="panel-heading clearfix">
        <section class="panel-title">
          <section class="col-md-12 column text-center">
            <h4> This is your thread! Do you want edit or delete? </h2>
          </section>
          <section class="col-md-12 column text-center">
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
          </section>
        </section>
      </section>
    </section>
  </div>
</section>
