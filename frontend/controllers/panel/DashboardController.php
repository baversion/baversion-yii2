<?php

namespace frontend\controllers\panel;

use common\models\Users;
use frontend\models\ChangeProfileForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class DashboardController extends \yii\web\Controller
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
                        'actions' => ['index', 'profile', 'bookmarks'],
                        'allow' => true,
                        'roles' => ['accessPanel'],
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

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionProfile()
    {
        $model = new ChangeProfileForm(Yii::$app->user->identity->id);

        if ($model->load(Yii::$app->request->post()))
        {
            $model->changeProfile();
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }
}
