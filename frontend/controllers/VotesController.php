<?php

namespace frontend\controllers;

use Yii;
use app\models\Vote;
use app\models\Post;
use app\models\Thread;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Response;

/*
  TODO: REFACTOR CODE FOR UP AND DOWN ACTIONS.
 */
/**
 * VotesController implements the CRUD actions for Vote model.
 */
class VotesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            [
            'class' => 'yii\filters\ContentNegotiator',
            'only' => ['actionUp', 'actionDown'],  // in a controller
            // if in a module, use the following IDs for user actions
            // 'only' => ['user/view', 'user/index']
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ],
        ];
    }

    /**
     * Creates a new Vote model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUp($thread_id = null, $post_id = null)
    {
        $result = $this->vote('up', $thread_id, $post_id);
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }
    /**
     * Updates an existing Vote model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDown($thread_id = null, $post_id = null )
    {
      $result = $this->vote('down', $thread_id, $post_id);
      \Yii::$app->response->format = Response::FORMAT_JSON;
      return $result;
    }

    private function vote($kindOfVote = 'up', $thread_id = null, $post_id = null){
      // ---- no way to vote!
      if (!$thread_id && !$post_id){
        $result = ["error" => true, "message" => "Ops! Something went wrong. Try again later!"];
      }

      if (Yii::$app->user->isGuest){
        $result = ["error" => true, "message" => "You must be logged to vote!"];
      }  else {
        // ------
        $changedMindText = "It's always a good thing to change mind!";
        $model = Vote::find()
                 ->where(['thread_id' => $thread_id, 'post_id'=>$post_id, 'user_id' => Yii::$app->user->identity->id])
                 ->one();

        if(!$model){ // new istance.
          $changedMindText  = '';
          $model            = new Vote();
          $model->user_id   = Yii::$app->user->identity->id;
          $model->thread_id = $thread_id;
          $model->post_id   = $post_id;
        }
        if($kindOfVote == 'up'){
          $model->point = 1;
        } else {
          $model->point = -1;
        }
        if ($model->save(false)) {
          if($post_id){
            $points = Vote::find()->where(['thread_id' => $thread_id, 'post_id'=>$post_id])->sum('point');
          } else {
            $points = Vote::find()->where(['thread_id' => $thread_id, 'post_id'=>null])->sum('point');
          }
          // For a big application, obviously, this is not the correct implementatino way.
          // I'd separate votes for thread/post. For multiple reasons: 1 view layout 2 DB queries simpler  

          $result = ["error" => false, "message" => "Thanks for voting! ".$changedMindText,
            'thread_id' => $thread_id,
            'post_id'   => $post_id,
            'points'    => $points
          ];
        } else {
          $result = ["error" => true, "message" => "Ops! Something went wrong. Try again later!"];
        }
      }
      return $result;
    }
}
