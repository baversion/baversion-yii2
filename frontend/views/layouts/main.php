<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <?= Html::csrfMetaTags() ?>
    <title>باورژن - <?= Html::encode($this->title) ?></title>
    <meta name="og:title" content="<?= Html::encode($this->title) ?>">
    <meta name="og:type" content="article">
    <meta name="og:site_name" content="باورژن"/>
    <?php if (isset($this->params['meta']['keywords'])): ?>
        <meta name="keywords" content="<?= $this->params['meta']['keywords'] ?>">
    <?php endif; ?>
    <?php if (isset($this->params['meta']['description'])): ?>
        <meta name="description" content="<?= $this->params['meta']['description'] ?>">
        <meta name="og:description" content="<?= $this->params['meta']['description'] ?>">
    <?php endif; ?>
    <meta name="og:url" content="<?= Url::current([], true) ?>">
    <?php if (isset($this->params['meta']['image'])): ?>
        <meta name="og:image" content="<?= $this->params['meta']['image'] ?>">
    <?php endif; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->head() ?>
</head>

<body class="home">
<?php $this->beginBody() ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <?= $this->render('//layouts/header') ?>
</nav>
<main role="main" class="container-fluid section">
    <div class="row">
        <div class="col-md-8 blog-main">
            <?php if (Yii::$app->session->hasFlash('info')): ?>
                <div class="alert alert-info alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><span class="fas fa-info"></span> توجه!</h4>
                    <?= Yii::$app->session->getFlash('info') ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('danger')): ?>
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><span class="fas fa-times-circle"></span> اخطار!</h4>
                    <?= Yii::$app->session->getFlash('danger') ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><span class="fas fa-times-circle"></span> اخطار!</h4>
                    <?= Yii::$app->session->getFlash('error') ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('warning')): ?>
                <div class="alert alert-warning alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><span class="fas fa-exclamation-triangle"></span> هشدار!</h4>
                    <?= Yii::$app->session->getFlash('warning') ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><span class="fas fa-check"></span> توجه!</h4>
                    <?= Yii::$app->session->getFlash('success') ?>
                </div>
            <?php endif; ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div><!-- /.main -->

        <aside class="col-md-4 sidebar">
            <?= $this->render('sidebar') ?>
        </aside><!-- /.sidebar -->

    </div><!-- /.row -->
</main>
<?php /* if (Yii::$app->controller->id == 'docs' && Yii::$app->controller->action->id == 'post'): ?>
<div class="section-invert py-4">
    <h3 class="section-title text-center m-5">توضیحات ارائه شده توسط کاربران</h3>
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="pr-4 pl-4 pt-4">
                                    <div class="card-title bg-transparent d-flex">
                                        <div>
                                            <a href="#"><span class="fas fa-caret-up"></span></a>
                                            <span>23 +</span>
                                            <a href="#"><span class="fas fa-caret-down"></span></a>
                                            <strong class="mt-3">مجتبی پاکزاد</strong>
                                            <small class="text-muted">22 مرداد 1397</small>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">با نوشتن حس خوبی پیدا می‌کنم، هنگام نوشتن همیشه سعی می‌کنم نسبت به موضوع اطلاعات کافی به دست آوردم و بعد دست به کیبورد شوم. مهندس الکترونیک‌ام. حل مساله و چالش رو خیلی دوست دارم و رابطه خیلی خوبی با ریاضیات، برنامه‌نویسی و اقتصاد دارم. علاقه زیادی به هوش‌مصنوعی، یادگیری ماشین و موضوعات مرتبط دارم.</p>
                                        <pre><code class="php">$counter = 5;</code></pre>
                                    </div>
                                    <div class="card-footer">
                                        <a href="#"><span class="fas fa-flag"></span></a>
                                        <a href="#"><span class="fas fa-pencil-alt"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="pr-4 pl-4 pt-4">
                                    <div class="card-title bg-transparent d-flex">
                                        <div>
                                            <a href="#"><span class="fas fa-caret-up"></span></a>
                                            <span>23 +</span>
                                            <a href="#"><span class="fas fa-caret-down"></span></a>
                                            <strong class="mt-3">مجتبی پاکزاد</strong>
                                            <small class="text-muted">22 مرداد 1397</small>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">با نوشتن حس خوبی پیدا می‌کنم، هنگام نوشتن همیشه سعی می‌کنم نسبت به موضوع اطلاعات کافی به دست آوردم و بعد دست به کیبورد شوم. مهندس الکترونیک‌ام. حل مساله و چالش رو خیلی دوست دارم و رابطه خیلی خوبی با ریاضیات، برنامه‌نویسی و اقتصاد دارم. علاقه زیادی به هوش‌مصنوعی، یادگیری ماشین و موضوعات مرتبط دارم.</p>
                                        <pre><code class="php">$counter = 5;</code></pre>
                                    </div>
                                    <div class="card-footer">
                                        <a href="#"><span class="fas fa-flag"></span></a>
                                        <a href="#"><span class="fas fa-pencil-alt"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 col-sm-12">
                <h4>ارسال یادداشت</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <p>لطفا فقط برای توضیح یا ارائه مثال در رابطه با مطلب بالا، کامنت ارسال کنید.<br>
                    اگر سوالی دارید، لطفا سوال خود را به جای اینجا، در استک مطرح کنید.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
            <?php
                // usage without model
                echo kartik\markdown\MarkdownEditor::widget([
                'name' => 'markdown',
                'value' => 'Hi'//$value,
                ]);
                ?>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 col-sm-12">
                <input type="submit" class="btn btn-primary" value="ارسال یادداشت">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 col-sm-12">
                <div class="alert alert-warning">
                    <span class="fas fa-exclamation-triangle"></span>
                    به منظور ارائه یادداشت، ابتدا باید ثبت‌نام کنید یا وارد اکانت خود شوید.</div>
            </div>
        </div>
        <?php /*if (!Yii::$app->user->isGuest): ?>
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($commentForm, 'text')->label(false)->textarea(['class' => 'markdown-editor']) ?>

            <div class="form-group">
                <?= Html::submitButton('Comment', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        <?php else: ?>
            <p><?= Html::a('Signup', ['auth/signup'])?> or <?= Html::a('Login', ['auth/login']) ?> in order to comment.</p>
        <?php endif */ ?>
        <?php
        /*
        $markdown = '**dfgfd';
        // traditional markdown and parse full text
        $parser = new \cebe\markdown\Markdown();
        echo $parser->parse($markdown);

        // use github markdown
        $parser = new \cebe\markdown\GithubMarkdown();
        echo $parser->parse($markdown);

        // use markdown extra
        $parser = new \cebe\markdown\MarkdownExtra();
        echo $parser->parse($markdown);

        // parse only inline elements (useful for one-line descriptions)
        $parser = new \cebe\markdown\GithubMarkdown();
        echo $parser->parseParagraph($markdown);*/
        /*
        ?>
    </div>
</div>
<?php endif;*/ ?>
<?= $this->render('//layouts/footer') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>