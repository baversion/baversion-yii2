<?php

namespace backend\controllers;

use Yii;
use backend\models\AuthItem;
use backend\models\AuthItemSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RolesController implements the CRUD actions for authItem model.
 */
class RolesController extends Controller
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
                        'actions' => ['index', 'create', 'delete', 'view', 'update'],
                        'allow' => true,
                        'roles' => ['manageRoles'],
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
     * Lists all authItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['type' => 1]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single authItem model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $permissions = \Yii::$app->authManager->getPermissionsByRole($id);

        return $this->render('view', [
            'model' => $model,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Creates a new authItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new AuthItem();
        $model->type = 1;

        $auth = Yii::$app->authManager;
        $allPermissions = $auth->getPermissions();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $rolePermissions = Yii::$app->request->post('Permissions');

            if ($rolePermissions !== null)
            {
                $role = $auth->getRole($model->name);

                foreach ($rolePermissions as $name => $permission)
                {
                    if (isset($allPermissions[$name])) {
                        $auth->addChild($role, $allPermissions[$name]);
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->name]);
        }

        foreach ($allPermissions as $permission)
        {
            $permissions[] = [
                'name' => $permission->name,
                'description' => $permission->description,
                'checked' => false,
            ];
        }

        return $this->render('create', [
            'model' => $model,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Updates an existing authItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $auth = Yii::$app->authManager;
        $allPermissions = $auth->getPermissions();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $rolePermissions = Yii::$app->request->post('Permissions');

            if ($rolePermissions !== null)
            {
                $role = $auth->getRole($model->name);
                $auth->removeChildren($role);

                foreach ($rolePermissions as $name => $permission)
                {
                    if (isset($allPermissions[$name])) {
                        $auth->addChild($role, $allPermissions[$name]);
                    }
                }
            }

            return $this->redirect(['view', 'id' => $model->name]);
        }

        $allPermissions = \Yii::$app->authManager->getPermissions();
        $rolePermissions = \Yii::$app->authManager->getPermissionsByRole($id);

        foreach ($allPermissions as $permission)
        {
            $permissions[] = [
                'name' => $permission->name,
                'description' => $permission->description,
                'checked' => (isset($rolePermissions[$permission->name]) ? true : false),
            ];
        }

        return $this->render('update', [
            'model' => $model,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Deletes an existing authItem model.
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
     * Finds the authItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return authItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = authItem::findOne(['type' => 1, 'name' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('نقش کاربری مورد نظر شما وجود ندارد.');
    }
}
