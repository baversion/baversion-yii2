<?php
namespace frontend\controllers;

use common\models\Articles;
use common\models\Docs;
use common\models\Tags;
use common\models\Terminology;
use common\models\Users;
use frontend\models\ChangeProfileForm;
use frontend\models\VerifyEmail;
use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup', 'settings'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'settings'],
                        'allow' => true,
                        'roles' => ['@'],
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->layout = 'blank';
        return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $docs = Docs::find()->where(['doc_status' => 6])->orderBy(['published_at' => SORT_DESC])->limit(4)->all();

        $articles = Articles::find()->where(['article_status' => 6])->orderBy(['published_at' => SORT_DESC])->limit(3)->all();

        $terms = Terminology::find()->where(['term_status' => 6])->orderBy(['published_at' => SORT_DESC])->limit(12)->all();

        $this->layout = 'home';

        $this->view->params['meta']['keywords'] = 'باورژن,آموزش برنامه‌نویسی,مستندات,داکیومنت,لاراول,اصطلاحات فنی,ترجمه فارسی داکیومنت,کدایگنایتر,PHP';
        $this->view->params['meta']['description'] = 'باورژن ارائه دهنده آموزش‌های حرفه‌ای برنامه‌نویسی، اصطلاحات فنی و ترجمه داکیومنت‌های زبان‌ها، فریمورک‌ها و ابزارهای برنامه‌نویسی';

        return $this->render('index', [
            'docs' => $docs,
            'articles' => $articles,
            'terms' => $terms,
        ]);
    }

//    public function actionMaintenance($hour)
//    {
//        $this->layout = 'blank';
//
//        return $this->render('maintenance', [
//            'hour' => $hour,
//        ]);
//    }

    /**
     * Display sitemap.
     *
     * @param $sitemap
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSitemap($sitemap)
    {
        $items = [];
        if ($sitemap === null)
        {
            $items = [
                [
                    'loc' => htmlspecialchars(Url::to('/sitemap-pages.xml', true)),
                    'lastmod' => '2018-07-08',
                ],
                [
                    'loc' => htmlspecialchars(Url::to('/sitemap-blog.xml', true)),
                    'lastmod' => '2018-07-08',
                ],
                [
                    'loc' => htmlspecialchars(Url::to('/sitemap-tags.xml', true)),
                    'lastmod' => '2018-07-08',
                ],
                [
                    'loc' => htmlspecialchars(Url::to('/sitemap-docs.xml', true)),
                    'lastmod' => '2018-07-08',
                ],
            ];
        }
        elseif($sitemap === '-pages')
        {
            $items = [
                [
                    'loc' => Url::to('/about', true),
                    'lastmod' => '2018-06-07',
                ],
                [
                    'loc' => Url::to('/contact', true),
                    'lastmod' => '2018-06-07',
                ],
            ];
        }
        elseif($sitemap === '-blog')
        {
            $posts = Articles::find()->
            select(['slug', 'updated_at', 'article_title', 'cover_image'])->
            where(['article_status' => 6])->
            asArray()->
            all();

            $items[] = [
                'loc' => Url::to('blog/'),
            ];

            foreach ($posts as $post)
            {
                $item = [
                    'loc' => Url::to('blog/post/' . $post['slug'], true),
                    'lastmod' => date('Y-m-d', $post['updated_at']),
                    'changefreq' => 'daily',
                    'priority' => 0.8,
                ];
                if ($post['cover_image'] !== null)
                {
                    $item['image'] = [
                        'loc' => Url::to($post['cover_image'], true),
                        'title' => $post['article_title'],
                    ];
                }

                $items[] = $item;
            }
        }
        elseif($sitemap === '-tags')
        {
            $tags = Tags::find()->
            select(['slug', 'updated_at'])->
            where(['tag_status' => 6])->
            asArray()->
            all();

            foreach ($tags as $tag)
            {
                $items[] = [
                    'loc' => Url::to('tag/' . $tag['slug'], true),
                    'lastmod' => date('Y-m-d', $tag['updated_at']),
                    'changefreq' => 'daily',
                    'priority' => 0.8,
                ];
            }
        }
        elseif($sitemap === '-docs')
        {
            $docs = Docs::find()
                ->select(['`docs`.`id`', '`docs`.`slug`', '`docs`.`doc_version`', '`docs`.`updated_at`', '`docs`.`doc_title`', '`docs`.`cover_image`'])
                ->where(['doc_status' => 6])
                ->andWhere(['not', ['`doc_posts`.`slug`' => null]])
                ->joinWith(['docPosts' => function ($q) {
                    $q->select(['`doc_posts`.`doc_id`', '`doc_posts`.`slug`', '`doc_posts`.`updated_at`'])
                    ->where(['post_status' => 6])
                    ->andWhere(['not', ['`doc_posts`.`slug`' => null]]);
                }])
                ->asArray()
                ->all();

            $items[] = [
                'loc' => Url::to('docs/', true),
            ];

            foreach ($docs as $doc)
            {
                $item = [
                    'loc' => Url::to('docs/' . $doc['slug'] . '/' . $doc['doc_version'], true),
                    'lastmod' => date('Y-m-d', $doc['updated_at']),
                    'changefreq' => 'daily',
                    'priority' => 0.8,
                ];

                if ($doc['cover_image'] !== null)
                {
                    $item['image'] = [
                        'loc' => Url::to($doc['cover_image'], true),
                        'title' => $doc['doc_title'],
                    ];
                }

                $items[] = $item;

                foreach ($doc['docPosts'] as $post) {
                    $items[] = [
                        'loc' => Url::to('docs/' . $doc['slug'] . '/' . $doc['doc_version'] . '/' . $post['slug'], true),
                        'lastmod' => date('Y-m-d', $post['updated_at']),
                        'changefreq' => 'daily',
                        'priority' => 0.8,
                    ];
                }
            }
        }
        else
        {
            throw new NotFoundHttpException('سایت‌مپ مورد نظر شما وجود ندارد.' );
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'application/xml');


        return $this->renderPartial('sitemap',[
            'sitemap' => $sitemap,
            'items' => $items,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $user = Users::findOne(Yii::$app->user->id);
            $user->setLastLogin();
            $user->save();

            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Shows and changes the user account settings.
     *
     * @return mixed
     */
    public function actionSettings()
    {
        $model = new ChangeProfileForm(Yii::$app->user->identity->id);

        if ($model->load(Yii::$app->request->post()))
        {
            $user = $model->changeProfile();
            $msg = [
                $model->display_name . ' گرامی، ایمیل شما در <strong>باورژن</strong> کرده است.',
                'برای استفاده از امکانات سایت باید آدرس ایمیل خود را تایید کنید. جهت تکمیل ثبت نام خود در <strong>باورژن</strong> روی لینک زیر کلیک کنید.',
                '<a href="' . Url::to(['/verify', 'email' => $model->email, 'token' => $user->email_verification_code], true) . '" class="btn-primary">تایید آدرس ایمیل</a>',
                '&mdash; تیم باورژن',
            ];

            $messages = '';
            foreach($msg as $message) {
                $messages .= '<tr>' . PHP_EOL
                    . '<td class="content-block">' . PHP_EOL
                    . $message . PHP_EOL
                    . '</td>' . PHP_EOL
                    . '</tr>' . PHP_EOL;
            }

            if (Yii::$app->request->post('email') != $user->email) {
                $this->sendEmail($model->email, 'تایید آدرس ایمیل شما در باورژن', $messages);
            }
        }

        return $this->render('settings', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionVerify()
    {
        if (Yii::$app->request->get('email') !== null && Yii::$app->request->get('token') !== null)
        {
            if (($user = Users::findOne(['email' => Yii::$app->request->get('email'),'email_verificatin_code' => Yii::$app->request->get('token')])) !== null) {
                $user->email_verification_code = null;
                $user->updated_at = time();
                $user->save();
                return $this->goHome();
            }

            Yii::$app->session->setFlash('danger', "پارامترهای وارد شده صحیح نیستند، از فرم زیر استفاده کنید.");
        }
        elseif (Yii::$app->request->get())
        {
            Yii::$app->session->setFlash('danger', "پارامترهای وارد شده صحیح نیستند، از فرم زیر استفاده کنید.");
        }

        $model = new VerifyEmail();

        return $this->render('verify', [
            'model' => $model,
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'از اینکه با ما تماس گرفتید، متشکریم. در اسرع وقت پاسخ پیام شما را خواهیم داد.');
            } else {
                Yii::$app->session->setFlash('error', 'خطایی در ارسال پیام شما رخ داد. لطغا از ایمیل baversion.com@gmail.com استفاده کنید.');
            }

            Yii::$app->session->setFlash('form', '');

            return $this->actionContact();//$this->refresh(); TODO::This is a trick, you must fix it as soon as it's possible.
        } else {
            $this->view->params['meta']['keywords'] = 'تماس با ما';
            $this->view->params['meta']['description'] = 'برای مشاوره، انتقادات، پیشنهادات و هر موضوع مرتبطی که تمایل دارید پذیرای ایمیل‌های شما هستیم.';

            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        $this->view->params['meta']['keywords'] = 'درباره ما';
        $this->view->params['meta']['description'] = 'باورژن در حال حاضر از دو بخش وبلاگ و داکیومنت تشکیل شده است.';

        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        throw new ForbiddenHttpException('فعلا امکان ثبت نام وجود ندارد.');
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                $msg = [
                    $model->display_name . ' گرامی، ورود شما به جمع کاربران <strong>باورژن</strong> را تبریک می‌گوییم.',
                    'برای استفاده از امکانات سایت باید آدرس ایمیل خود را تایید کنید. جهت تکمیل ثبت نام خود در <strong>باورژن</strong> روی لینک زیر کلیک کنید.',
                    '<a href="' . Url::to(['/verify', 'email' => $model->email, 'token' => $user->email_verification_code], true) . '" class="btn-primary">تایید آدرس ایمیل</a>',
                    '&mdash; تیم باورژن',
                ];

                $messages = '';
                foreach($msg as $message) {
                    $messages .= '<tr>' . PHP_EOL
                                . '<td class="content-block">' . PHP_EOL
								. $message . PHP_EOL
                                . '</td>' . PHP_EOL
                                . '</tr>' . PHP_EOL;
                }

                $this->sendEmail($model->email, 'تایید آدرس ایمیل شما در باورژن', $messages);

                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function sendEmail($to, $subject, $messages)
    {
        Yii::$app->mailer->compose()
            ->setFrom('admin@baversion.com')
            ->setTo($to)
            ->setSubject($subject)
//            ->setTextBody('Plain text content')
            ->setHtmlBody('
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Actionable emails e.g. reset password</title>
<style type="text/css">
	/* -------------------------------------
    GLOBAL
------------------------------------- */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-size: 14px;
}

img {
  max-width: 100%;
}

body {
  -webkit-font-smoothing: antialiased;
  -webkit-text-size-adjust: none;
  width: 100% !important;
  height: 100%;
  line-height: 1.6;
}

/* Let\'s make sure all tables have defaults */
table td {
  vertical-align: top;
}

/* -------------------------------------
    BODY & CONTAINER
------------------------------------- */
body {
  background-color: #f6f6f6;
}

.body-wrap {
  background-color: #f6f6f6;
  width: 100%;
}

.container {
  display: block !important;
  max-width: 600px !important;
  margin: 0 auto !important;
  /* makes it centered */
  clear: both !important;
}

.content {
  max-width: 600px;
  margin: 0 auto;
  display: block;
  padding: 20px;
}

/* -------------------------------------
    HEADER, FOOTER, MAIN
------------------------------------- */
.main {
  background: #fff;
  border: 1px solid #e9e9e9;
  border-radius: 3px;
}

.content-wrap {
  padding: 20px;
}

.content-block {
  padding: 0 0 20px;
  direction: rtl;
  text-align: right;
  line-height: 1.5;
  font-family: Tahoma, Helvetica, Arial, Sans-serif;
}

.header {
  width: 100%;
  margin-bottom: 20px;
}

.footer {
  width: 100%;
  clear: both;
  color: #999;
  padding: 20px;
}
.footer a {
  color: #999;
}
.footer p, .footer a, .footer unsubscribe, .footer td {
  font-size: 12px;
}

/* -------------------------------------
    GRID AND COLUMNS
------------------------------------- */
.column-left {
  float: left;
  width: 50%;
}

.column-right {
  float: left;
  width: 50%;
}

/* -------------------------------------
    TYPOGRAPHY
------------------------------------- */
h1, h2, h3 {
  font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
  color: #000;
  margin: 40px 0 0;
  line-height: 1.2;
  font-weight: 400;
}

h1 {
  font-size: 32px;
  font-weight: 500;
}

h2 {
  font-size: 24px;
}

h3 {
  font-size: 18px;
}

h4 {
  font-size: 14px;
  font-weight: 600;
}

p, ul, ol {
  margin-bottom: 10px;
  font-weight: normal;
}
p li, ul li, ol li {
  margin-right: 5px;
  list-style-position: inside;
}

/* -------------------------------------
    LINKS & BUTTONS
------------------------------------- */
a {
  color: #348eda;
  text-decoration: underline;
}

.btn-primary {
  text-decoration: none;
  color: #FFF;
  background-color: #348eda;
  border: solid #348eda;
  border-width: 10px 20px;
  line-height: 2;
  font-weight: bold;
  text-align: center;
  cursor: pointer;
  display: inline-block;
  border-radius: 5px;
  text-transform: capitalize;
}

/* -------------------------------------
    OTHER STYLES THAT MIGHT BE USEFUL
------------------------------------- */
.last {
  margin-bottom: 0;
}

.first {
  margin-top: 0;
}

.padding {
  padding: 10px 0;
}

.aligncenter {
  text-align: center;
}

.alignright {
  text-align: right;
}

.alignleft {
  text-align: left;
}

.clear {
  clear: both;
}

/* -------------------------------------
    Alerts
------------------------------------- */
.alert {
  font-size: 16px;
  color: #fff;
  font-weight: 500;
  padding: 20px;
  text-align: center;
  border-radius: 3px 3px 0 0;
}
.alert a {
  color: #fff;
  text-decoration: none;
  font-weight: 500;
  font-size: 16px;
}
.alert.alert-warning {
  background: #ff9f00;
}
.alert.alert-bad {
  background: #d0021b;
}
.alert.alert-good {
  background: #68b90f;
}

/* -------------------------------------
    INVOICE
------------------------------------- */
.invoice {
  margin: 40px auto;
  text-align: left;
  width: 80%;
}
.invoice td {
  padding: 5px 0;
}
.invoice .invoice-items {
  width: 100%;
}
.invoice .invoice-items td {
  border-top: #eee 1px solid;
}
.invoice .invoice-items .total td {
  border-top: 2px solid #333;
  border-bottom: 2px solid #333;
  font-weight: 700;
}

/* -------------------------------------
    RESPONSIVE AND MOBILE FRIENDLY STYLES
------------------------------------- */
@media only screen and (max-width: 640px) {
  h1, h2, h3, h4 {
    font-weight: 600 !important;
    margin: 20px 0 5px !important;
  }

  h1 {
    font-size: 22px !important;
  }

  h2 {
    font-size: 18px !important;
  }

  h3 {
    font-size: 16px !important;
  }

  .container {
    width: 100% !important;
  }

  .content, .content-wrapper {
    padding: 10px !important;
  }

  .invoice {
    width: 100% !important;
  }
}
</style>
</head>

<body>

<table class="body-wrap">
	<tr>
		<td></td>
		<td class="container" width="600">
			<div class="content">
				<table class="main" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="content-wrap">
							<table width="100%" cellpadding="0" cellspacing="0">
							    ' . $messages . '
							</table>
						</td>
					</tr>
				</table>
				<div class="footer">
					<table width="100%">
						<tr>
							<td class="aligncenter content-block">Follow <a href="http://twitter.com/ba_version">@ba_version</a> on Twitter.</td>
						</tr>
					</table>
				</div></div>
		</td>
		<td></td>
	</tr>
</table>

</body>
</html>')
            ->send();
    }
}
