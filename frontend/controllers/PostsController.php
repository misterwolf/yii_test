<?php

namespace frontend\controllers;

use Yii;
use app\models\Post;
use app\models\Thread;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\VerbFilter;
use yii\helpers\Url;
/**
 * PostController implements the CRUD actions for Post model.
 */
class PostsController extends Controller
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
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
      return Yii::$app->getResponse()->redirect(Url::to(['/threads/' ]));
    }

    public function actionView($post_id)
    {
      // Uhm, we can't do this by urlManager? let's study it
      // TODO: a good idea is redirect to related thread with pagination!
      $model = $this->findModel($post_id);
      return Yii::$app->getResponse()->redirect(Url::to(['/threads/'.$model->thread_id ]));

    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($thread_id)
    {
      $model = new Post();
      $model->thread_id = $thread_id;

      if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
        Yii::$app->response->format =  yii\web\Response::FORMAT_JSON;
        return ActiveForm::validate($model);
      } else {
          // in the post ( 'ensembleStaff_ids' => [0 => '2']); where the id actually is staff_id
          if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/threads/'.$thread_id]);
          } else {
            if (Yii::$app->request->isAjax){
              return $this->renderAjax('_form', [
                  'model' => $model,
              ]);
            } else{
              return $this->redirect(['/threads/'.$thread_id]); // prevent direct opening of url
            }
          }
      }
      return $this->redirect(['/threads/'.$thread_id]); // prevent direct opening of url
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
