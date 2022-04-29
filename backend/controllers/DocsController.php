<?php

namespace backend\controllers;

use common\models\DocPosts;
use Yii;
use common\models\Docs;
use common\models\DocsSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DocsController implements the CRUD actions for Docs model.
 */
class DocsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Docs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Docs model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Docs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Docs();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Add post to a specific doc.
     * @param $id Docs id The id of document
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionAdd($id)
    {
        $doc = Docs::findOne($id);

        if(!$doc)
        {
            throw new NotFoundHttpException('داکیومنت مورد نظر شما وجود ندارد.');
        }

        $post = new DocPosts();

//        $post->scenario = 'create';
//        $keywords->scenario = 'create';
//        $description->scenario = 'create';

        $parentPosts = DocPosts::find()->where(['doc_id' => $id, 'parent_id' => null])->all();
        $postList = ArrayHelper::map($parentPosts,'id','post_title');

        if ($post->load(Yii::$app->request->post())) {
            $post->doc_id = $doc->id;
            $post->created_at = time();
            $post->updated_at = time();
            if (Yii::$app->request->post('slug') === '')
            {
                $post->slug = null;
            }
            if (Yii::$app->request->post('content') === '')
            {
                $post->content = null;
            }
            if (Yii::$app->request->post('src') === '')
            {
                $post->src = null;
            }
            if (Yii::$app->request->post('meta_keywords') === '')
            {
                $post->meta_keywords = null;
            }
            if (Yii::$app->request->post('meta_description') === '')
            {
                $post->meta_description = null;
            }

            if ($post->validate()) {
                if (Yii::$app->request->post('savePost') == 'publish')
                {
                    $post->author_id = Yii::$app->user->identity->id;
                    $post->post_status = 6;
                    $post->published_at = time();
                }
                else
                {
                    $post->post_status = 1;
                }
                $post->save(false);

                return $this->redirect(['post', 'id' => $post->id]);
            }
        }

        return $this->render('post_create', [
            'doc' => $doc,
            'post' => $post,
            'postList' => $postList,
        ]);
    }

    /**
     * Updates an existing Docs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException if this post reserved by another user
     */
    public function actionPost($id)
    {
        $post = DocPosts::findOne($id);

        if(!$post)
        {
            throw new NotFoundHttpException('پست مورد نظر شما وجود ندارد.');
        }

        $view = 'post_view';

        if($post->lock_to !== null)
        {
            if ($post->lock_to != Yii::$app->user->identity->id)
            {
                throw new ForbiddenHttpException('این پست انتخاب شده و دسترسی به آن موقتا مسدود شده است.', '403');
            }
            $view = 'post_update';
        }

        $post->scenario = DocPosts::SCENARIO_UPDATE;

        $doc = Docs::findOne($post->doc_id);
        $parentPosts = DocPosts::find()->where(['doc_id' => $post->doc_id, 'parent_id' => null])->andWhere('id <>' . $id)->all();
        $postList = ArrayHelper::map($parentPosts,'id','post_title');

        if ($post->load(Yii::$app->request->post())) {
            $isValid = $post->validate();
            if ($isValid) {
                if (Yii::$app->request->post('savePost') == 'publish')
                {
                    if ($post->post_status == 'draft')
                    {
                        $post->author_id = Yii::$app->user->identity->id;
                    }
                    if (Yii::$app->user->can('manageContent'))
                    {
                        if ($post->post_status != 6)
                        {
                            $post->post_status = 6;
                            $post->published_at = time();
                        }
                    }
                    elseif ($post->post_status == 1)
                    {
                        $post->post_status = 2;
                    }

                }
                else
                {
                    $post->post_status = 1;
                }
                $post->updated_at = time();
                $post->save(false);
                return $this->redirect(['post', 'id' => $id]);
            }
        }

        return $this->render($view, [
            'doc' => $doc,
            'post' => $post,
            'postList' => $postList,
        ]);
    }

    /**
     * Catch an existing DocPosts model.
     *
     * Catching a docPost allow user to edit it without conflict.
     *
     * If catching is successful, the browser will be redirected to the 'post' edit page.
     * @param string $id DocPosts
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException if the model status is published(6) and the current user is not an admin.
     */
    public function actionCatch($id)
    {
        $post = $this->findPostModel($id);

        $doc = $this->findDocModel($post->doc_id);

        $post->scenario = DocPosts::SCENARIO_CATCH;
        //$model->load(Yii::$app->request->post()

        if ($post->lock_to === null)
        {
            if (!Yii::$app->user->can('managePost') && $post->post_status == 6)
            {
                throw new ForbiddenHttpException('این مطلب قبلا منتشر شده است و شما سطح دسترسی لازم برای ویرایش آن را ندارید. لطفا تغییرات مورد نظرتان را به مدیر اطلاع دهید.', 403);
            }


            $post->lock_to = Yii::$app->user->identity->id;
            $post->updated_at = time();
            if ($post->post_status == 1)
            {
                $post->author_id = Yii::$app->user->identity->id;
            }

            if ($post->save())
            {
                return $this->redirect(['panel/docs/post/' . $id]);
            }

            Yii::$app->session->setFlash('error', 'متاسفانه خطایی در رزرو پست پیش آمده است.');
        }
        else
        {
            if ($post->lock_to == Yii::$app->user->identity->id)
            {
                $post->lock_to = null;
                $post->updated_at = time();

                if ($post->post_status == 1)
                {
                    $post->author_id = null;
                }

                if ($post->save())
                {
                    return $this->redirect(['panel/docs/doc/' . $post->doc_id]);
                }

                Yii::$app->session->setFlash('error', 'متاسفانه خطایی در رزرو پست پیش آمده است.');
            }
            else
            {
                throw new ForbiddenHttpException('این پست انتخاب شده و امکان انتخاب آن توسط سایر کاربران وجود ندارد.', 403);
            }
        }

        return $this->redirect(['panel/docs/doc/' . $doc->id]);
    }

    /**
     * Updates an existing Docs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Docs model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Docs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Docs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Docs::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
