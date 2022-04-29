<?php

namespace frontend\controllers;

use common\models\DocPosts;
use Yii;
use common\models\Docs;
use common\models\DocsSearch;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
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
                        'actions' => ['index', 'doc', 'post', 'rss'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['edit'],
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
     * Lists all Docs models.
     * @return mixed
     */
    public function actionIndex()
    {
        // build a DB query to get all articles with status = published
        $query = Docs::find()
            ->joinWith('docPosts')
//            ->joinWith(['docPosts' => function ($q) {
//                $q->select(['doc_posts.slug AS post_slug', 'doc_posts.post_title', 'doc_posts.post_status'])
//                    ->where(['not', ['`doc_posts`.`slug`' => null]])
//                    ->limit(3)
//                    ->orderBy(['doc_posts.id' => SORT_ASC]);
//            }], true)
            ->where(['doc_status' => 6])
            ->orderBy(['docs.published_at' => SORT_DESC])
            ->groupBy('docs.id');

        // get the total number of articles (but do not fetch the article data yet)
        $count = $query->count();

        // create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 10]);

        // limit the query using the pagination and retrieve the articles
        $docs = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $this->view->params['latestPosts'] = DocPosts::find()
            ->where(['post_status' => 6])
            ->andWhere(['not', ['`doc_posts`.`slug`' => null]])
            ->orderBy(['published_at' => SORT_DESC])
            ->limit(30)
            ->joinWith('doc')
            ->all();

        $this->view->params['meta']['keywords'] = 'داکیومنت, docs, document';
        $this->view->params['meta']['description'] = 'داکیومنت‌های پروژه‌های اپن‌سورس منتخب را در این صفحه می‌توانید دنبال کنید.';


        return $this->render('index', [
            'docs' => $docs,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Displays a single Doc post model.
     * @param string $doc document slug
     * @param string $version document version
     * @return mixed
     * @throws HttpException if the model cannot be found
     */
    public function actionDoc($doc, $version)
    {
        $doc = Docs::findOne(['slug' => $doc, 'doc_version' => $version]);

        if ($doc == null)
        {
            throw new HttpException('404', 'لینک مربوط به داکیومنت یا ورژن اشتباه است.');
        }

        $posts = DocPosts::find()
            ->select(['id', 'slug', 'post_title', 'post_status', 'post_order', 'parent_id', 'meta_keywords', 'meta_description'])
            ->where(['doc_id' => $doc->id])
            ->asArray()
            ->all();

        $this->view->params['posts'] = $posts;
        $this->view->params['doc'] = $doc;
        $this->view->params['meta']['keywords'] = $doc->meta_keywords;
        $this->view->params['meta']['description'] = $doc->meta_description;

        if (!Yii::$app->user->can('manageContent'))
        {
            $doc->updateCounters(['view_count' => 1]);
        }

        return $this->render('doc', [
            'doc' => $doc,
            'posts' => $posts,
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
    public function actionEdit($id)
    {
        $this->layout = 'blank';

        $post = DocPosts::findOne($id);

        if(!$post)
        {
            throw new NotFoundHttpException('پست مورد نظر شما وجود ندارد.');
        }

        /*$view = 'post_view';

        if($post->lock_to !== null)
        {
            if ($post->lock_to != Yii::$app->user->identity->id)
            {
                throw new ForbiddenHttpException('این پست انتخاب شده و دسترسی به آن موقتا مسدود شده است.', '403');
            }
            $view = 'post_update';
        }*/
        $view = 'post_update';

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

                $post->meta_keywords = Yii::$app->request->post('meta_keywords');
                $post->meta_description = Yii::$app->request->post('meta_description');

                $post->updated_at = time();
                $post->save(false);
                return $this->redirect(['docs/edit', 'id' => $id]);
            }
        }

        return $this->render($view, [
            'doc' => $doc,
            'post' => $post,
            'postList' => $postList,
        ]);
    }

    /**
     * Displays a single Doc model.
     * @param string $doc
     * @param string $version
     * @param string $post
     * @return mixed
     * @throws HttpException if the model cannot be found
     */
    public function actionPost($doc, $version, $post)
    {
        $doc = Docs::findOne(['slug' => $doc, 'doc_version' => $version]);

        if ($doc == null)
        {
            throw new HttpException('404', 'لینک مربوط به داکیومنت یا ورژن اشتباه است.');
        }

        $post = DocPosts::findOne(['doc_id' => $doc->id, 'slug' => $post, 'post_status' => 6]);

        if ($post == null)
        {
            throw new HttpException('404', 'لینک مربوط به پست اشتباه است.');
        }

        $posts = DocPosts::find()
            ->select(['doc_posts.id', 'author_id', 'slug', 'post_title', 'post_status', 'post_order', 'parent_id', 'users.display_name'])
            ->where(['doc_id' => $doc->id])
            ->joinWith('author')
            ->asArray()
            ->all();

        $this->view->params['posts'] = DocPosts::find()
            ->select(['id', 'slug', 'post_title', 'post_status', 'post_order', 'parent_id', 'meta_keywords', 'meta_description'])
            ->where(['doc_id' => $doc->id])
            ->asArray()
            ->all();
        $this->view->params['doc'] = $doc;
        $this->view->params['meta']['keywords'] = $post->meta_keywords;
        $this->view->params['meta']['description'] = $post->meta_description;

        if (!Yii::$app->user->can('manageContent'))
        {
            $post->updateCounters(['view_count' => 1]);
        }
        
        return $this->render('post', [
            'doc' => $doc,
            'post' => $post,
            'posts' => $posts,
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
            'query' => docPosts::find()
                ->where(['post_status' => 6])
                ->andWhere(['not', ['`doc_posts`.`slug`' => null]])
                ->orderBy(['published_at' => SORT_DESC])
                ->joinWith('doc'),
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
                'link' => Url::toRoute('/docs', true),
                'description' => 'داکیومنت‌های باورژن ',
                'language' => function ($widget, \Zelenin\Feed $feed) {
                    return Yii::$app->language;
                },
//                'image'=> function ($widget, \Zelenin\Feed $feed) {
//                    $feed->addChannelImage('http://example.com/channel.jpg', 'http://baversion.com', 88, 31, 'Image description');
//                },
            ],
            'items' => [
                'title' => function ($model, $widget, \Zelenin\Feed $feed) {
                    return $model->post_title;
                },
                'description' => function ($model, $widget, \Zelenin\Feed $feed) {
                    preg_match('/<p>(.*?)<\/p>/i', $model->content, $paragraphs);
                    return html_entity_decode(strip_tags($paragraphs[0]));
                },
                'link' => function ($model, $widget, \Zelenin\Feed $feed) {
                    return Url::toRoute(['docs/' . $model->doc->slug . '/' . $model->doc->doc_version . '/' . $model->slug], true);
                },
                'guid' => function ($model, $widget, \Zelenin\Feed $feed) {
                    $date = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', $model->published_at));
                    $date->setTimezone(new \DateTimeZone('Asia/Tehran'));
                    return Url::toRoute(['docs/' . $model->doc->slug . '/' . $model->doc->doc_version . '/' . $model->slug], true) . ' ' . $date->format(DATE_RSS);
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
     * Finds the Docs model based on its doc.
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
