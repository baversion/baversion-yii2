<?php

namespace frontend\controllers\panel;

use common\models\ArticleMeta;
use common\models\ArticleTagRelations;
use common\models\Tags;
use Yii;
use common\models\Articles;
use common\models\ArticlesSearch;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
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
     * Updates an existing Articles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPost($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if (!Yii::$app->request->post('createPost') == 'draft' && !Yii::$app->request->post('createPost') == 'publish')
            {
                Yii::$app->session->setFlash('danger', "عملیات غیرمجاز است.");
            }
            else
            {
                $model->updated_at = time();
                if (Yii::$app->request->post('createPost') == 'draft')
                {
                    $model->article_status = 1;
                }
                elseif(Yii::$app->request->post('createPost') == 'publish')
                {
                    $model->article_status = 6;
                    if ($model->published_at == NULL)
                    {
                        $model->published_at = time();
                    }
                }

                preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $model->content, $image);

                if (isset($image['src']))
                {
                    $model->cover_image = $image['src'];
                }

                if ($model->save())
                {
                    return $this->redirect(['panel/blog/post/' . $model->id]);
                }
                else
                {
                    Yii::$app->session->setFlash('danger', "عملیات شکست خورد.");
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


}
