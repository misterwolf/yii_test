<?php

namespace frontend\controllers;

use Yii;
use app\models\Post;
use app\models\Thread;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ThreadsController implements the CRUD actions for Threads model.
 */
class ThreadsController extends Controller
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
     * Lists all Threads models.
     * @return mixed
     */
    public function actionIndex()
    {
        $threads = Thread::find()->with('author')->orderBy('created_at DESC')->all();
        return $this->render('index', [
            'threads' => $threads,
        ]);
    }

    /**
     * Displays a single Threads model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
      $thread = $this->findModel($id);

      // -------------
      // set 1day expiration cookie for keeping info concerning thread view.
      //
      // Need to change because something is not correct:
      //  - if user clear cookie
      //  - if user uses private navigation
      //  - it can work good only for guest users.
      //
      // we can't use session:
      //  - server link to session change is lost whenver browser is closed
      //  - save a session in db? the same.
      //
      // use IP and save it in DB
      //  - can be good, but if more users use the same net? no.
      //
      // A best implementation is keep in DB who user has viewed a thread/:id
      // if user is not logged or unregistered then use cookie
      //
      $setCookie = false;
      if (!$this->getCookieForThreadView($id)){
        $setCookie = true;
      }
      // -------------

      return $this->render('view', [
          'model' => $thread, 'setCookieForViews' => $setCookie
      ]);
    }

    /**
     * Creates a new Threads model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Thread();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Threads model.
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
     * Deletes an existing Threads model.
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
     * Finds the Threads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Threads the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Thread::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Get the cookie for view thread incrementation
     * @param integer $thread_id
     * @param integer $value
     * @return Threads the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function getCookieForThreadView($thread_id){
      return \Yii::$app->getRequest()->getCookies()->getValue('_tWinc'.$thread_id);
    }
}
