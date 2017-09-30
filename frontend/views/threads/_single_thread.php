<!-- second proposal -->
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

  <section class="container">
    <section class="row clearfix">
      <div class="row clearfix">
        <div class="col-md-12 column">
          <div class="panel panel-default <?= $summaryVersion ? "summary" : ""?> ">

            <?php if (!$summaryVersion) { ?>
              <div class="panel-heading">
                <section class="panel-title"> Thread Numer #
                </section>
              </div>
            <?php }?>

            <section class="row panel-body">
              <section class="col-md-9 ">

                <?php if (!$summaryVersion) { ?>
                  <h2><?= $thread->title ?></h2>
                  <hr>
                <?php }?>

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
                      <dd> Posts:     <?= $thread->author->getPosts()->count() ?> </dd>
                      <dd> Likes:     <?= $thread->author->getVotes()->count() ?></dd>
                    </dl>

                  </section>
              </section>

            </section>
            <div class="panel-footer">
              <div class="row">
                <section class="col-md-3 ">
                  <?php
                  $statusUp   = '';
                  $statusDown = '';

                   if ($currentUserVotes) {
                     if ($currentUserVotes->up) $statusUp = 'not-active';
                     if ($currentUserVotes->down) $statusDown   = 'not-active';
                   } ?>
                   <dl>
                     <dd> Votes: <?= $voteForThisThread; // TODO: increment this after voting ?></dd>
                     <dd> Posts: <?= $postsForThisThread; // TODO: increment this after voting ?></dd>
                   </dl>
                  <a href="<?= Url::to(['threads/'.$thread->id.'/votes/up']); ?>" class="btn btn-primary btn-xs vote <?= $statusUp ?>"> Like this thread! </a>
                  <a href="<?= Url::to(['threads/'.$thread->id.'/votes/down']); ?>" class="btn btn-danger btn-xs vote <?= $statusDown ?>"> Dislike this thread!</a>
                </section>
                <section class="col-md-5 ">
                </section>
                <section class="col-md-4 text-right">
                  <?php if (!$summaryVersion) { ?>
                    <a href="<?= Url::to(['threads/view', 'id' => $thread->id]); ?>" class="btn btn-primary btn-xs">View</a>
                  <?php }?>
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </section>

<!-- !second proposal -->
