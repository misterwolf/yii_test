<?php

  use yii\helpers\Url;


  // better separate the rendering of thread and post in two different partials:
  // it's sure that in future the things'll change :)

  $summaryVersion     = $summaryVersion ?? false;
  $currentUserId      = Yii::$app->user->isGuest ? null : Yii::$app->user->identity->id;
  $voteForThisThread  = $thread->getVote()->count();
  $postsForThisThread = $thread->getPost()->count();
  $currentUserVotes   = $thread->getVote()->andOnCondition(['thread_id' => $thread->id, 'user_id' => $currentUserId])->one();

?>

<section class="row clearfix">
    <div class="col-md-12 column">
      <section class="panel panel-default <?= $summaryVersion ? "summary" : ""?> ">
        <section class="panel-heading clearfix">
          <section class="panel-title">
            <section class="col-md-9 column">
              <h2><?= $thread->title ?></h2>
            </section>
            <section class="col-md-3 column text-right">
              <dl>
                <dd> Posted at: <h5><?= Yii::$app->formatter->asDate($thread->created_at, 'yyyy-MM-dd hh:mm:ss'); ?></h5></dd>
              </dl>
            </section>
          </section>
        </section>

        <section class="panel-body">
          <section class="col-md-9 ">
            <h3>
              <?= $thread->content ?>
            </h3>
          </section>

          <section id="user-description" class="col-md-3 ">
              <section class="well">
                <dl>
                  <dd> Created by </dd>
                  <dd><h5> <?= $thread->author->first_name." ".$thread->author->last_name ?> </h5></dd>
                </dl>
                <figure>
                  <!-- PICTURE PROFILE-->
                </figure>

                <dl>
                  <dd> Joined at: <?= Yii::$app->formatter->asDate($thread->author->created_at, 'yyyy-MM-dd'); ?> </dd>
                  <dd> Posts:     <?= $thread->author->getPosts()->count() ?> </dd>
                  <dd> Likes:     <?= $thread->author->getVotes()->count() ?> </dd>
                </dl>

              </section>
          </section>

        </section>
        <section class="panel-footer">
          <div class="row">
            <section class="col-md-5 ">
              <?php

              $statusUp   = '';
              $statusDown = '';
               if ($currentUserVotes) {
                 if ($currentUserVotes->up) $statusUp = 'not-active';
                 if ($currentUserVotes->down) $statusDown   = 'not-active';
               }
               ?>
              <a href="<?= Url::to(['threads/'.$thread->id.'/votes/up']); ?>" class="btn btn-primary btn-md vote-thread <?= $statusUp ?>"> Like this thread! </a>
              <a href="<?= Url::to(['threads/'.$thread->id.'/votes/down']); ?>" class="btn btn-danger btn-md vote-thread <?= $statusDown ?>"> Dislike this thread!</a>
            </section>
            <section class="col-md-2 ">
              <h5>Posts: <?= $postsForThisThread; // TODO: increment this after voting ?></h5>
            </section>
            <section class="col-md-2 ">
              <h5>Votes: <?= $voteForThisThread; // TODO: increment this after voting ?></h5>
            </section>
            <section class="col-md-3 text-right">
              <?php if (!$summaryVersion) { ?>
                <a href="<?= Url::to(['threads/view', 'id' => $thread->id]); ?>" class="btn btn-primary btn-md">View</a>
              <?php }?>
            </section>
          </div>
        </section>
      </section>
    </div>
</section>
