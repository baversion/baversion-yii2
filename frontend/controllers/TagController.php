<?php

namespace frontend\controllers;

use common\models\Taggables;
use Yii;
use common\models\Tags;
use common\models\TagsSearch;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TagController implements the CRUD actions for Tags model.
 */
class TagController extends Controller
{
    /**
     * @inheritdoc
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

    public function beforeAction($action)
    {
        if (trim(Yii::$app->request->getUrl(), '/') == 'tag/مستندسازی')
        {
            Yii::$app->getResponse()->redirect(Url::to(['/tag/documentation']), 301)->send();
            return;
        }

        $this->view->params['randomTags'] = Tags::find()->where(['tag_status' => 6])->orderBy(new Expression('rand()'))->limit(20)->all();
        return parent::beforeAction($action);
    }

    /**
     * Displays a single Tags model.
     * @param string $slug
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionTag($slug)
    {
        $tag = $this->findModelBySlug($slug);

        $this->view->params['meta']['keywords'] = $tag->meta_keywords;
        $this->view->params['meta']['description'] = $tag->meta_description;

        if (!Yii::$app->user->can('manageContent'))
        {
            $tag->updateCounters(['view_count' => 1]);
        }

        $articles = Taggables::find()->where(['taggable_type' => 'article', 'tag_id' => $tag->id])->joinWith('article')->all();

        return $this->render('tag', [
            'model' => $tag,
            'articles' => $articles,
        ]);
    }

    /**
     * Finds the Tags model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $slug
     * @return Tags the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelBySlug($slug)
    {
        if (($model = Tags::findOne(['slug' => $slug, 'tag_status' => 6])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('تگ مورد نظر وجود ندارد.');
    }
}
