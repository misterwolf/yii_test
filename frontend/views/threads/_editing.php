<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<p>
    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]) ?>
</p>

<?=
 DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'title',
        'content',
        'views',
        'created_by',
        'created_at:datetime',
        'updated_at:datetime',
    ],
])
?>
