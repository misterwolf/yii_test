<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Test for 180Vita - Dario Gasparro',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home',     'url' => ['/site/index']],
        ['label' => 'Threads',  'url' => ['/threads']]
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->first_name . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <? //= Alert::widget() // this doesn't print success alert flash,
           //TODO: try a further investigate
        ?>
        <?php
          $flashMessages = Yii::$app->session->getAllFlashes();
          if ($flashMessages) {
            foreach( $flashMessages as $key => $message) {
              echo \yii\bootstrap\Alert::widget([ 'options' => [ 'class' => ($key == 'success' ? 'alert-info fade' : 'alert-danger fade'), ], 'body' => $message, ]);
            }
          }
        ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Test for 180Vita - Dario Gasparro <?= date('Y') ?></p>
    </div>
</footer>
<?php
  yii\bootstrap\Modal::begin([
      'headerOptions' => ['id' => 'modalHeader'],
      'id' => 'modal',
      'size' => 'modal-lg',
      //keeps from closing modal with esc key or by clicking out of the modal.
      // user must click cancel or X to close
      'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
  ]);
  echo "<div id='modalContent'></div>";
  yii\bootstrap\Modal::end();
?>
<?php
$script = <<< JS

  $('.vote-thread').on('click', function(event){
    var buttons = $(this).parent().children();
    event.preventDefault();
    $.ajax({
        url : $(this).attr('href'),
        type: 'POST',
        cache : false,
        context:this,
        success : function( data ){
          console.log(data);
          if (!data.error){
            buttons.removeClass('not-active');
            $(this).addClass('not-active');
          }
          alert(data.message); // TODO: activate a modal
        }
    });

  });

JS;
$this->registerJs($script);
?>

<?php
$script = <<< JS

  $('.vote-post').on('click', function(event){
    var buttons = $(this).parent().children();
    event.preventDefault();
    $.ajax({
        url : $(this).attr('href'),
        type: 'POST',
        cache : false,
        context:this,
        success : function( data ){
          console.log(data);
          if (!data.error){
            buttons.removeClass('not-active');
            $(this).addClass('not-active');
          }
          alert(data.message); // TODO: activate a modal
        }
    });

  });

JS;
$this->registerJs($script);
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
