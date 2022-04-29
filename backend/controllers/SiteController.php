<?php
namespace backend\controllers;

use common\models\DocPosts;
use common\models\Docs;
use common\models\Users;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
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
                        'actions' => ['login'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'error'],
                        'allow' => true,
                        'roles' => ['accessAdmin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $latestRegisteredUsers = Users::find()->select(['id', 'display_name', 'created_at'])->orderBy(['created_at' => SORT_DESC])->limit(10)->asArray()->all();
        $usersCount = Users::find()->count();

        $latestDocPosts = DocPosts::find()->select(['id', 'post_title', 'published_at'])->where(['post_status' => 6])->orderBy(['published_at' => SORT_DESC])->limit(10)->asArray()->all();
        $docsCount = Docs::find()->count();

        return $this->render('index', [
            'latestRegisteredUsers' => $latestRegisteredUsers,
            'usersCount' => $usersCount,
            'latestDocPosts' => $latestDocPosts,
            'docsCount' => $docsCount,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }

        $this->layout = 'blank';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $user = Users::findOne(Yii::$app->user->id);
            $user->setLastLogin();
            $user->save();

            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
