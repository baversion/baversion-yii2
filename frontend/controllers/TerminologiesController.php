<?php

namespace frontend\controllers;

use Yii;
use common\models\Terminology;
use common\models\TerminologySearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Zelenin\yii\extensions\Rss\RssView;

/**
 * TerminologiesController implements the CRUD actions for Terminology model.
 */
class TerminologiesController extends Controller
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
                        'actions' => ['index', 'term', 'rss'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create', 'delete', 'update'],
                        'allow' => true,
                        'roles' => ['createContent'],
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
        $this->view->params['latestTerms'] = Terminology::find()->select(['slug', 'term_title'])->where(['term_status' => 6])->limit('20')->all();
        return parent::beforeAction($action);
    }

    /**
     * Lists all Terminology models.
     * @return mixed
     */
    public function actionIndex()
    {
        $terminologies = Terminology::find()
            ->where(['term_status' => 6])
            ->asArray()
            ->all();
        foreach ($terminologies as $term) {
            $terms[$term['initial']][] = $term;
        }
        
        $this->view->params['meta']['keywords'] = 'اصطلاحات فنی,واژگان تخصصی برنامه‌نویسی';
        $this->view->params['meta']['description'] = 'از نظر ما یادگیری مفهوم اصطلاحات تخصصی بهتر از معادل‌سازی فارسی است که در اثر موارد باعث گیج شدن نویسنده می‌شود.';

        return $this->render('index', compact('terms'));
    }

    /**
     * Displays a single Terminology model.
     * @param string $slug
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionTerm($slug)
    {
        $term = $this->findModelBySlug($slug);

        if ($term === null) {
            throw new NotFoundHttpException('اصطلاح مورد نظر وجود ندارد.');
        }

        $this->view->params['meta']['keywords'] = $term->meta_keywords;
        $this->view->params['meta']['description'] = $term->meta_description;

        if (!Yii::$app->user->can('manageContent'))
        {
            $term->updateCounters(['view_count' => 1]);
        }

        return $this->render('term', [
            'model' => $term,
        ]);
    }

    /**
     * Creates a new Terminology model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Terminology();

        if ($model->load(Yii::$app->request->post())) {
            $model->author_id = Yii::$app->user->identity->id;
            $model->created_at = time();
            $model->updated_at = time();

            if (Yii::$app->request->post('term_status') == 6) {
                $model->published_at = time();
            }

            if ($model->save()) {
                return $this->redirect(['term', 'slug' => $model->slug]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Terminology model.
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
     * Deletes an existing Terminology model.
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
     * @return string
     * @throws \Exception
     */
    public function actionRss()
    {
        ob_start();

        $dataProvider = new ActiveDataProvider([
            'query' => Terminology::find()
                ->where(['term_status' => 6])
                ->orderBy(['published_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10
            ],
        ]);

        $response = Yii::$app->getResponse();
        $headers = $response->getHeaders();

        $headers->set('Content-Type', 'application/rss+xml; charset=utf-8');

        echo RssView::widget([
            'dataProvider' => $dataProvider,
            'channel' => [
                'title' => function ($widget, \Zelenin\Feed $feed) {
                    $feed->addChannelTitle(Yii::$app->name);
                },
                'link' => Url::toRoute('/terminologies', true),
                'description' => 'اصطلاحات فنی باورژن ',
                'language' => function ($widget, \Zelenin\Feed $feed) {
                    return Yii::$app->language;
                },
//                'image'=> function ($widget, \Zelenin\Feed $feed) {
//                    $feed->addChannelImage('http://example.com/channel.jpg', 'http://baversion.com', 88, 31, 'Image description');
//                },
            ],
            'items' => [
                'title' => function ($model, $widget, \Zelenin\Feed $feed) {
                    return $model->term_title;
                },
                'description' => function ($model, $widget, \Zelenin\Feed $feed) {
                    preg_match('/<p>(.*?)<\/p>/i', $model->content, $paragraphs);
                    return html_entity_decode(strip_tags($paragraphs[0]));
                },
                'link' => function ($model, $widget, \Zelenin\Feed $feed) {
                    return Url::toRoute(['terminologies/term/' . $model->slug], true);
                },
                'guid' => function ($model, $widget, \Zelenin\Feed $feed) {
                    $date = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', $model->published_at));
                    $date->setTimezone(new \DateTimeZone('Asia/Tehran'));
                    return Url::toRoute(['terminologies/term/' . $model->slug], true) . ' ' . $date->format(DATE_RSS);
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
     * Finds the Terminology model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Terminology the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Terminology::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the Articles model based on its slug value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $slug
     * @return Terminology the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelBySlug($slug)
    {
        if (($model = Terminology::findOne(['slug' => $slug, 'term_status' => 6])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('اصطلاح مورد نظر وجود ندارد.');
    }
}
