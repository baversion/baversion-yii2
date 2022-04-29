<?php

namespace backend\controllers;

use common\models\HelpPosts;
use Yii;
use common\models\HelpTopics;
use common\models\HelpTopicsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HelpController implements the CRUD actions for HelpTopics model.
 */
class HelpController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['create', 'index', 'topic', 'update', 'add', 'post'],
                        'allow' => true,
                        'roles' => ['accessAdmin'],
                    ],
                    [
                        'actions' => ['delete', 'remove'],
                        'allow' => true,
                        'roles' => ['deleteHelp'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all HelpTopics models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HelpTopicsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HelpTopics model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionTopic($id)
    {
        $topic = HelpTopics::find()->where(['`help_topics`.`id`' => $id])->joinWith('helpPosts')->one();

        if ($topic == null)
        {
            throw new NotFoundHttpException('تاپیک مورد نظر شما وجود ندارد.');
        }

        return $this->render('topic', [
            'topic' => $topic,
        ]);
    }

    /**
     * Displays a single HelpPosts model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPost($id)
    {
        $post = HelpPosts::find()->where(['`help_posts`.`id`' => $id])->joinWith('topic')->one();

        if ($post == null)
        {
            throw new NotFoundHttpException('پست مورد نظر شما وجود ندارد.');
        }

        return $this->render('post', [
            'post' => $post,
        ]);
    }

    /**
     * Creates a new HelpTopics model.
     * If creation is successful, the browser will be redirected to the 'topic' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HelpTopics();

        if ($model->load(Yii::$app->request->post())) {
            $model->author_id = Yii::$app->user->identity->id;
            $model->created_at = time();
            $model->updated_at = time();

            if ($model->validate() && $model->save()) {
                return $this->redirect(['topic', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new HelpPosts model.
     * @param string $id
     * If creation is successful, the browser will be redirected to the 'post' page.
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionAdd($id)
    {
        $topic = $this->findModel($id);

        $post = new HelpPosts();

        if ($post->load(Yii::$app->request->post())) {
            $post->author_id = Yii::$app->user->identity->id;
            $post->topic_id = $topic->id;
            $post->created_at = time();
            $post->updated_at = time();

            if (Yii::$app->request->post('save') == 'draft')
            {
                $post->help_status = 1;
            }
            elseif (Yii::$app->request->post('save') == 'published')
            {
                $post->help_status = 6;
                $post->published_at = time();
            }
            else
            {
                throw new ForbiddenHttpException('عملیات درخواستی شما مجاز نیست.', '403');
            }

            if ($post->validate() && $post->save()) {
                return $this->redirect(['post', 'id' => $post->id]);
            }
        }

        return $this->render('add', [
            'topic' => $topic,
            'post' => $post,
        ]);
    }

    /**
     * Updates an existing HelpTopics model.
     * If update is successful, the browser will be redirected to the 'post' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = time();

            if ($model->validate() && $model->save()) {
                return $this->redirect(['post', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HelpTopics model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['help/']);
    }

    /**
     * Deletes an existing HelpPosts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionRemove($id)
    {
        $this->findPostModel($id)->delete();

        return $this->redirect(['help/']);
    }

    /**
     * Finds the HelpTopics model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return HelpTopics the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HelpTopics::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('تاپیک مورد نظر شما وجود ندارد.');
    }

    /**
     * Finds the HelpPosts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return HelpPosts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findPostModel($id)
    {
        if (($model = HelpPosts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('پست مورد نظر شما وجود ندارد.');
    }
}
