<!-- second proposal -->
<?php
  //
  use yii\helpers\Url;
  use yii\helpers\Html;
?>
<?php foreach ($posts as $post) { ?>
  <section class="container">
    <section class="row clearfix">
      <div class="row clearfix">
        <div class="col-md-12 column">
          <div class="panel panel-default">
            <div class="panel-heading">
              <section class="panel-title"></section>
            </div>
            <section class="row panel-body">
              <section class="col-md-9">
                <p>
                  <?= $post->content ?>
                </p>
              </section>

              <section id="user-description" class="col-md-3 ">
                  <section class="well">
                    <dl>
                      <dd> Posted by </dd>
                      <dd> <?= $post->author->first_name." ".$post->author->last_name ?> </dd>
                    </dl>
                    <figure>
                      <!-- PICTURE PROFILE-->
                    </figure>

                    <dl>
                      <dd> Joined at: <?= Yii::$app->formatter->asDate($post->author->created_at, 'yyyy-MM-dd:hh:mm:ss'); ?> </dd>
                      <dd> Posts: <?= $post->author->getPosts()->count() ?> </dd>
                      <dd> Likes: </dd>
                    </dl>

                  </section>
              </section>

            </section>
            <div class="panel-footer">
              <div class="row">
                  <section class="col-md-2 ">
                    <?php if (!Yii::$app->user->isGuest) { ?>
                    <button type="button" class="btn btn-primary btn-xs" >
                        Like this post!
                    </button>
                  <?php } ?>
                  </section>
                  <section class="col-md-6 ">
                  </section>
                  <section class="col-md-4 text-right">

                    <?= Html::a('(TODO) Reply with a post', [ Url::to(['threads/'.$post->thread->id.'/posts/create'])], ['class' => 'btn btn-success disabled ']) ?>
                  </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </section>
<?php } ?>
<!-- !second proposal -->
