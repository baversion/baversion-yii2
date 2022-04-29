<?php

namespace backend\controllers;

use backend\models\AuthItem;
use Yii;
use common\models\Users;
use common\models\UsersSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
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
                        'actions' => ['index', 'view', 'update', 'ban'],
                        'allow' => true,
                        'roles' => ['manageUsers'],
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
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
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
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException if assign a not exist role
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $auth = Yii::$app->authManager;

        $roles = AuthItem::findAll(['type' => 1]);
        $listRoles = ArrayHelper::map($roles, 'name', 'name');

        $userRoles = $auth->getRolesByUser($id);
        foreach ($userRoles as $role)
        {
            $userRole = $role->name;
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (Yii::$app->request->post('Users')['image'])
            {
                $model->image = null;
            }

            $role = Yii::$app->request->post('role');
            if (in_array($role, $listRoles))
            {
                $auth->revokeAll($model->id);
                $auth->assign($auth->getRole($role), $model->id);
            }
            else
            {
                throw new ForbiddenHttpException('درخواست شما غیر مجاز است.', '403');
            }

            if ($model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'roles' => $roles,
            'listRoles' => $listRoles,
            'userRole' => $userRole,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionBan($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('کاربر مورد نظر شما وجود ندارد.');
    }
}
