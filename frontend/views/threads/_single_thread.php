<!-- second proposal -->
<?php

  use yii\helpers\Url;

?>
<?php foreach ($threads as $thread) { ?>
  <section class="container">
    <section class="row clearfix">
      <div class="row clearfix">
        <div class="col-md-12 column">
          <div class="panel panel-default">
            <div class="panel-heading">
              <section class="panel-title"> Thread Numer #
              </section>
            </div>
            <section class="row panel-body">
              <section class="col-md-9">
                <h2><?= $thread->title ?></h2>
                <hr>
                <p>
                  <?= $thread->content ?>
                </p>
              </section>

              <section id="user-description" class="col-md-3 ">
                  <section class="well">
                    <dl>
                      <dd> Created by </dd>
                      <dd> <?= $thread->author->first_name." ".$thread->author->last_name ?> </dd>
                    </dl>
                    <figure>
                      <!-- PICTURE PROFILE-->
                    </figure>

                    <dl>
                      <dd> Joined at: <?= Yii::$app->formatter->asDate($thread->author->created_at, 'yyyy-MM-dd'); ?> </dd>
                      <dd> Posts: </dd>
                      <dd> Likes: </dd>
                    </dl>

                  </section>
              </section>

            </section>
            <div class="panel-footer">
              <div class="row">
                  <section class="col-md-2 ">
                    <button type="button" class="btn btn-primary btn-xs" > Like this thread! </button>
                  </section>
                  <section class="col-md-6 ">
                  </section>
                  <section class="col-md-4 text-right">
                    <a href="<?= Url::to(['threads/view', 'id' => $thread->id]); ?>" class="btn btn-primary btn-xs <?php echo Yii::$app->user->isGuest ? 'disabled' : '' ?>">View</a>
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
