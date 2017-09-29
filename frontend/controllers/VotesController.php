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
        ];
    }

    /**
     * Creates a new Vote model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUp($thread_id = null, $post_id = null)
    {

        if (!$thread_id && !$post_id || !Yii::$app->user->identity->id){
          return false; // no way to vote!
        }

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

        $model->up = 1;
        $model->down = 0;

        if ($model->save()) {
          $test = "Thanks for voting! ".$changedMindText;
        } else {
          $test = "Ops! Something went wrong. Try again later!";
        }

        // return Json
        return \yii\helpers\Json::encode($test);
    }

    /**
     * Updates an existing Vote model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDown($thread_id = null, $post_id = null )
    {
      if (!$thread_id && !$post_id || !Yii::$app->user->identity->id){
        return false; // no way to vote!
      }

      $changedMindText = "It's always a good thing to change mind!";

      // I think, this way we can prevent a lot of checks for to prevent multiple votes by a single user.
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

      $model->up = 0;
      $model->down = 1;

      // further information concerning the success and fail of request will be added in more complete project!
      if ($model->save()) {
        $test = "Thanks for voting! ".$changedMindText;
      } else {
        $test = "Ops! Something went wrong. Try again later!";
      }

      // return Json
      return \yii\helpers\Json::encode($test);
    }

}
