<?php

namespace frontend\controllers\panel;

use frontend\models\Tag;
use Yii;
use common\models\Tags;
use common\models\TagsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TagsController implements the CRUD actions for Tags model.
 */
class TagsController extends Controller
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
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['createContent'], // createContent
                    ],
                    [
                        'actions' => ['index', 'view', 'catch', 'update'],
                        'allow' => true,
                        'roles' => ['manageContent'], // createContent
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
        $this->layout = 'panel';
        return parent::beforeAction($action);
    }

    /**
     * Lists all Tags models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TagsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tags model.
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
     * Creates a new Tags model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tags();

        if ($model->load(Yii::$app->request->post())) {

            if (Yii::$app->request->post('saveTag') == 'draft' or Yii::$app->request->post('saveTag') == 'publish')
            {
                if (Yii::$app->request->post('saveTag') == 'draft')
                {
                    $model->tag_status = 1;
                }
                else
                {
                    if (Yii::$app->user->can('manageContent'))
                    {
                        $model->published_at = time();
                        $model->tag_status = 6;
                    }
                    else
                    {
                        $model->tag_status = 2;
                    }
                }

                $model->created_at = time();
                $model->updated_at = time();

                if ($model->save())
                {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else
                {
                    Yii::$app->session->setFlash('danger', "خطایی در ساخت تگ رخ داده است.");
                }
            }
            else
            {
                Yii::$app->session->setFlash('danger', "عملیات غیرمجاز است.");
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tags model.
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
     * Deletes an existing Tags model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the Tags model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Tags the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tags::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
