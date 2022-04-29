<?php

namespace frontend\controllers;

use common\models\ArticleMeta;
use common\models\ArticleTagRelations;
use common\models\Docs;
use common\models\Taggables;
use common\models\Tags;
use Yii;
use common\models\Articles;
use common\models\BlogSearch;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BlogController implements the CRUD actions for Articles model.
 */
class BlogController extends Controller
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
                        'actions' => ['index', 'post', 'rss'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['draft', 'catch', 'create'],
                        'allow' => true,
                        'roles' => ['createContent'],
                    ],
                    [
                        'actions' => ['pending', 'delete'],
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

    public function beforeAction($action)
    {
        $this->view->params['featuredPosts'] = Articles::find()->select(['slug', 'article_title'])->where(['featured' => 1, 'article_status' => 6])->limit('10')->all();
        $this->view->params['docs'] = Docs::find()->select(['doc_title', 'slug', 'doc_version'])->orderBy(['published_at' => SORT_DESC])->all();
        return parent::beforeAction($action);
    }

    public function actionDraft()
    {
        $this->layout = 'blank';
        $dataProvider = new ActiveDataProvider([
            'query' => Articles::find(),
        ]);

        return $this->render('draft', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Articles models.
     * @return mixed
     */
    public function actionIndex()
    {
        // build a DB query to get all articles with status = published
        $query = Articles::find()
            ->select(['slug', 'article_title', 'excerpt', 'cover_image', 'published_at'])
            ->where(['article_status' => 6])
            ->orderBy(['published_at' => SORT_DESC]);

        // get the total number of articles (but do not fetch the article data yet)
        $count = $query->count();

        // create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 10]);

        // limit the query using the pagination and retrieve the articles
        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $this->view->params['meta']['keywords'] = 'وبلاگ, آموزش برنامه‌نویسی';
        $this->view->params['meta']['description'] = 'اخبار دنیای برنامه‌نویسی، آموزش‌های برنامه‌نویسی و نحوه استفاده از ابزار را در وبلاگ باورژن می‌توانید دنبال کنید.';

        return $this->render('index', [
            'posts' => $posts,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Creates a new Articles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Articles();

        if ($model->load(Yii::$app->request->post())) {
            if (!Yii::$app->request->post('createPost') == 'save' or !Yii::$app->request->post('createPost') == 'publish') {
                Yii::$app->session->setFlash('danger', "عملیات غیرمجاز است.");
            } else {
                if (Yii::$app->request->post('createPost') == 'draft') {
                    $model->article_status = 1;
                    $model->author_id = Yii::$app->user->identity->id;
                    $model->lock_to = Yii::$app->user->identity->id;
                } elseif (Yii::$app->request->post('createPost') == 'publish') {
                    $model->article_status = 6;
                    $model->published_at = time();
                }

                preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $model->content, $image);

                if (isset($image['src'])) {
                    $model->cover_image = $image['src'];
                }

                $model->created_at = time();
                $model->updated_at = time();

                if ($model->save()) {
//                    $tags = explode(',', $this->tags);
//
//                    foreach ($tags as $tag)
//                    {
//                        if($tagsModel = Tags::find()->where(['tag_name' => $tag])->orWhere(['slug' => $tag])->one() != null)
//                        {
//                            $tagModel = new ArticleTagRelations();
//                            $tagModel->article_id = $articleModel->id;
//                            $tagModel->tag_id = $tagsModel->id;
//                            $tagModel->save();
//                        }
//                    }
                    return $this->redirect(['post', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('danger', "عملیات شکست خورد.");
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Articles model.
     * @param string $slug
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPost($slug)
    {
        $post = $this->findModelBySlug($slug);

        if ($post === null) {
            throw new NotFoundHttpException('پست مورد نظر وجود ندارد.');
        }

        $this->view->params['meta']['keywords'] = $post->meta_keywords;
        $this->view->params['meta']['description'] = $post->meta_description;

        if (!Yii::$app->user->can('manageContent'))
        {
            $post->updateCounters(['view_count' => 1]);
        }

        if ($post->cover_image !== null)
        {
            $this->view->params['meta']['image'] = Url::to($post->cover_image, true);
        }

        $tags = Taggables::find()
                                ->where(['taggable_id' => $post->id, 'taggable_type' => 'article'])
                                ->joinWith('tag')
                                ->all();

        $sources = ArticleMeta::findAll(['article_id' => $post->id, 'meta_key' => 'src']);

        return $this->render('post', [
            'model' => $post,
            'tags' => $tags,
            'sources' => $sources,
        ]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionRss()
    {
        ob_start();

        $dataProvider = new ActiveDataProvider([
            'query' => Articles::find()->where(['article_status' => 6])->orderBy(['published_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10
            ],
        ]);

        $response = Yii::$app->getResponse();
        $headers = $response->getHeaders();

        $headers->set('Content-Type', 'application/rss+xml; charset=utf-8');

        echo \Zelenin\yii\extensions\Rss\RssView::widget([
            'dataProvider' => $dataProvider,
            'channel' => [
                'title' => function ($widget, \Zelenin\Feed $feed) {
                    $feed->addChannelTitle(Yii::$app->name);
                },
                'link' => Url::toRoute('/blog', true),
                'description' => 'وبلاگ باورژن ',
                'language' => function ($widget, \Zelenin\Feed $feed) {
                    return Yii::$app->language;
                },
//                'image'=> function ($widget, \Zelenin\Feed $feed) {
//                    $feed->addChannelImage('http://example.com/channel.jpg', 'http://baversion.com', 88, 31, 'Image description');
//                },
            ],
            'items' => [
                'title' => function ($model, $widget, \Zelenin\Feed $feed) {
                    return $model->article_title;
                },
                'description' => function ($model, $widget, \Zelenin\Feed $feed) {
                    return $model->excerpt;
                },
                'link' => function ($model, $widget, \Zelenin\Feed $feed) {
                    return Url::toRoute(['blog/post/' . $model->slug], true);
                },
                'image' => function ($model, $widget, \Zelenin\Feed $feed) {
                    return $model->cover_image;
                },
                'guid' => function ($model, $widget, \Zelenin\Feed $feed) {
                    $date = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', $model->published_at));
                    $date->setTimezone(new \DateTimeZone('Asia/Tehran'));
                    return Url::toRoute(['blog/post/' . $model->slug], true) . ' ' . $date->format(DATE_RSS);
                },
                'pubDate' => function ($model, $widget, \Zelenin\Feed $feed) {
                    $date = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', $model->published_at));
                    $date->setTimezone(new \DateTimeZone('Asia/Tehran'));
                    return $date->format(DATE_RSS);
                }
            ]
        ]);

        return ob_get_clean();
    }

    /**
     * Deletes an existing Articles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $article = $this->findModel($id);
        $article->slug = 'trash-' . time() . $article->slug;
        $article->article_status = 0;
        if ($article->save()) {
            Yii::$app->session->setFlash('success', "پست مورد نظر با موفقیت حذف گردید.");
        } else {
            Yii::$app->session->setFlash('danger', "عملیات شکست خورد.");
        }

        return $this->redirect(['blog/draft']);
    }

    /**
     * Catch an existing Articles model.
     *
     * Catching a Article allow user to edit it without conflict.
     *
     * If catching is successful, the browser will be redirected to the 'post' edit page.
     * @param string $id Articles
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException if the user does'nt have permission
     */
    public function actionCatch($id)
    {
        $article = $this->findModel($id);
        $article->scenario = Articles::SCENARIO_CATCH;

        if ($article->lock_to === null)
        {
            if (!Yii::$app->user->can('manageContent') && $article->article_status == 6)
            {
                throw new ForbiddenHttpException('این مطلب قبلا منتشر شده است و شما سطح دسترسی لازم برای ویرایش آن را ندارید. لطفا تغییرات مورد نظرتان را به مدیر اطلاع دهید.', 403);
            }

            $article->lock_to = Yii::$app->user->identity->id;
            $article->updated_at = time();
            if ($article->article_status == 1)
            {
                $article->author_id = Yii::$app->user->identity->id;
            }

            if ($article->save())
            {
                return $this->redirect(['panel/blog/post/' . $id]);
            }

            Yii::$app->session->setFlash('error', 'متاسفانه خطایی در رزرو پست پیش آمده است.');
        }
        else
        {
            if ($article->lock_to == Yii::$app->user->identity->id)
            {
                $article->lock_to = null;
                $article->updated_at = time();

                if ($article->article_status == 1)
                {
                    $article->author_id = null;
                }

                if ($article->save())
                {
                    return $this->redirect(['panel/blog']);
                }

                Yii::$app->session->setFlash('error', 'متاسفانه خطایی در رزرو پست پیش آمده است.');
            }
            else
            {
                throw new ForbiddenHttpException('این پست انتخاب شده و امکان انتخاب آن توسط سایر کاربران وجود ندارد.', 403);
            }
        }

        return $this->redirect(['blog/draft']);
    }

    /**
     * Finds the Articles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Articles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Articles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('پست مورد نظر شما وجود ندارد.');
    }

    /**
     * Finds the Articles model based on its slug value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $slug
     * @return Articles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelBySlug($slug)
    {
        if (($model = Articles::findOne(['slug' => $slug, 'article_status' => 6])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('پست مورد نظر وجود ندارد.');
    }
}
