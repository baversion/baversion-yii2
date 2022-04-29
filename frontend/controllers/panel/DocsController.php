<?php

namespace frontend\controllers\panel;

use common\models\DocMeta;
use common\models\DocPostMeta;
use common\models\DocPosts;
use Yii;
use common\models\Docs;
use common\models\DocsSearch;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DocsController implements the CRUD actions for Docs model.
 */
class DocsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'draft', 'catch', 'doc', 'post', 'my', 'preview'],
                        'allow' => true,
                        'roles' => ['createContent'],
                    ],
                    [
                        'actions' => ['pending', 'deletedoc', 'deletepost', 'create', 'add', 'catchdoc'],
                        'allow' => true,
                        'roles' => ['manageContent'],
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
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->layout = 'panel';
        return parent::beforeAction($action);
    }

    /**
     * Lists all DocPosts models.
     *
     * @param $id integer of documents.
     * @return string
     * @throws NotFoundHttpException If cannot find model of documents.
     */
    public function actionDoc($id)
    {
        $doc = $this->findDocModel($id);

        if (Yii::$app->user->can('manageContent'))
        {
            $query = DocPosts::find()->where(['doc_id' => $id]);
        }
        else
        {
            $query = DocPosts::find()->where(['doc_id' => $id, 'post_status' => 1]);
        }

        // get the total number of articles (but do not fetch the article data yet)
        $count = $query->count();

        // create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 50]);

        // limit the query using the pagination and retrieve the articles
        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('doc_posts', [
            'doc' => $doc,
            'posts' => $posts,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Lists all Docs models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('manageContent'))
        {
            $query = Docs::find();
        }
        else
        {
            $query = Docs::find()->where(['doc_status' => 6, 'completed' => 0]);
        }

        // get the total number of articles (but do not fetch the article data yet)
        $count = $query->count();

        // create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 50]);

        // limit the query using the pagination and retrieve the articles
        $docs = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('doc_index', [
            'docs' => $docs,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Lists all DocPosts models with pending status.
     * @return mixed
     */
    public function actionPending()
    {
        $query = DocPosts::find()->
        where(['post_status' => 2])->
        orderBy(['created_at' => SORT_DESC])->
        joinWith('doc', true);

        // get the total number of articles (but do not fetch the article data yet)
        $count = $query->count();

        // create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 50]);

        // limit the query using the pagination and retrieve the articles
        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('pending', [
            'posts' => $posts,
            'pagination' => $pagination,
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

        if ($model->load(Yii::$app->request->post())) {

            $model->created_at = time();
            $model->updated_at = time();

            if (Yii::$app->request->post('saveDoc') == 'publish')
            {
                $model->doc_status = 'published';
                $model->published_at = time();
            }
            elseif (Yii::$app->request->post('saveDoc') == 'draft')
            {
                $model->doc_status = 'draft';
            }

            $model->author_id = Yii::$app->user->identity->id;

            if ($model->save())
            {
                return $this->redirect(['panel/docs/doc/' . $model->id]);
            }
        }

        return $this->render('doc_create', [
            'model' => $model,
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
                    if ($post->post_status == 1)
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

                    $post->lock_to = null;
                }
                else
                {
                    $post->post_status = 1;
                }

                $post->meta_keywords = (Yii::$app->request->post('meta_keywords') && Yii::$app->user->can('manageContent') ? Yii::$app->request->post('meta_keywords') : null);
                $post->meta_description = (Yii::$app->request->post('meta_description') && Yii::$app->user->can('manageContent') ? Yii::$app->request->post('meta_description') : null);

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
     * Updates an existing Docs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException if this post reserved by another user
     */
    public function actionPreview($id)
    {
        $post = $this->findPostModel($id);

        if($post->lock_to !== null && $post->lock_to != Yii::$app->user->identity->id)
        {
            throw new ForbiddenHttpException('این پست انتخاب شده و دسترسی به آن موقتا مسدود شده است.', '403');
        }

        $doc = Docs::findOne($post->doc_id);

        return $this->render('post_view', [
            'doc' => $doc,
            'post' => $post,
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
            if (!Yii::$app->user->can('manageContent') && $post->post_status == 6)
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
     * Finds the Docs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Docs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findDocModel($id)
    {
        if (($model = Docs::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('داکیومنت مورد نظر شما وجود ندارد.');
    }

    /**
     * Finds the DocPosts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DocPosts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findPostModel($id)
    {
        if (($model = DocPosts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('پست مورد نظر شما وجود ندارد.');
    }
}
