<!-- second proposal -->
<?php
  //
  use yii\helpers\Url;
  use yii\helpers\Html;

  $currentUserId = Yii::$app->user->isGuest ? null : Yii::$app->user->identity->id;
  $thread_id = $post->thread_id;
  $voteForThisPost  = $post->getVote()->count();
  $postsForThisPost = $post->getThread()->one()->getPost()->count();
  $currentUserVote  = $post->getVote()->andOnCondition(['thread_id' => $thread_id, 'post_id' => $post->id, 'user_id' => $currentUserId])->one();

?>

<section class="row">
  <div class="col-md-2 column"></div>
  <div class="col-md-8 ">
    <div class="panel panel-default">
      <section class="panel-heading clearfix">
        <div class="row">
          <section class="col-md-4 ">
            <p id="post-votes-<?= $post->id ?>"> Votes: <?= $voteForThisPost; // TODO: increment this after voting ?></p>
          </section>
          <section class="col-md-8 text-right">
              <p>Posted at: <strong><?= Yii::$app->formatter->asDate($post->created_at, 'yyyy-MM-dd hh:mm:ss'); ?></strong></p>
          </section>
        </div>
      </section>
      <section class="row panel-body">
        <section class="col-md-7">
          <h3>
            <?= $post->content ?>
          </h3>
        </section>

        <section id="user-description" class="col-md-5 ">
            <section class="well">
              <dl>
                <dd> Posted by </dd>
                <dd> <h5><?= $post->author->first_name." ".$post->author->last_name ?></h5> </dd>
              </dl>
              <figure>
                <!-- PICTURE PROFILE-->
              </figure>

              <dl>
                <dd> Joined at: <?= Yii::$app->formatter->asDate($post->author->created_at, 'yyyy-MM-dd'); ?> </dd>
                <dd> Posts:     <?= $post->author->getPosts()->count() ?> </dd>
                <dd> Likes:     <?= $post->author->getVotes()->count() ?></dd>
              </dl>

            </section>
        </section>

      </section>
      <div class="panel-footer">
        <div class="row">
          <section class="col-md-8 ">
            <?php
            $statusUp   = '';
            $statusDown = '';
             if ($currentUserVote) {
               if ($currentUserVote->up) $statusUp = 'not-active';
               if ($currentUserVote->down) $statusDown   = 'not-active';
             } ?>

            <a href="<?= Url::to(['threads/'.$thread_id.'/posts/'.$post->id.'/votes/up']); ?>" class="btn btn-primary btn-xs vote-post <?= $statusUp ?>"> Like this post! </a>
            <a href="<?= Url::to(['threads/'.$thread_id.'/posts/'.$post->id.'/votes/down']); ?>" class="btn btn-danger btn-xs vote-post <?= $statusDown ?>"> Dislike this post!</a>
          </section>
          <section class="col-md-4 text-right ">
            <a href="<?= Url::to(['#']); ?>" class="btn btn-primary btn-xs vote not-active <?= $statusUp ?>"> Reply (TODO) </a>
          </section>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-2"></div>
</section>

<!-- !second proposal -->
