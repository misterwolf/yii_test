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

  <section class="container">
    <section class="row clearfix">
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
                      <dd> Joined at: <?= Yii::$app->formatter->asDate($post->author->created_at, 'yyyy-MM-dd'); ?> </dd>
                      <dd> Posts:     <?= $post->author->getPosts()->count() ?> </dd>
                      <dd> Likes:     <?= $post->author->getVotes()->count() ?></dd>
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
                   if ($currentUserVote) {
                     if ($currentUserVote->up) $statusUp = 'not-active';
                     if ($currentUserVote->down) $statusDown   = 'not-active';
                   } ?>
                   <dl>
                     <dd id="post-votes-<?= $post->id ?>"> Votes: <?= $voteForThisPost; // TODO: increment this after voting ?></dd>
                     <dd> Replies: TODO</dd>
                   </dl>
                  <a href="<?= Url::to(['threads/'.$thread_id.'/posts/'.$post->id.'/votes/up']); ?>" class="btn btn-primary btn-xs vote <?= $statusUp ?>"> Like this post! </a>
                  <a href="<?= Url::to(['threads/'.$thread_id.'/posts/'.$post->id.'/votes/down']); ?>" class="btn btn-danger btn-xs vote <?= $statusDown ?>"> Dislike this post!</a>
                </section>
                <section class="col-md-5 ">
                </section>
                <section class="col-md-4 text-right">
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </section>

<!-- !second proposal -->
