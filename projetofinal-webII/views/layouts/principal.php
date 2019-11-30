<?php
use app\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\PrincipalAsset;
use yii\helpers\Url;

PrincipalAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

  <head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
  </head>

  <body id="page-top">
  <?php $this->beginBody() ?>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top"><?= Html::encode($this->title) ?></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#sobre">Sobre</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contato">Contato</a>
            </li>
            <li class="nav-item">
              <?php 
                if(Yii::$app->user->isGuest)
                {
                    ?>
                    <a class="nav-link js-scroll-trigger" href="<?= Url::to(['site/login']);?>">Sign in</a>
                    <?php
                }
                else
                {
                    echo (
                      '<li>'
                      . Html::beginForm(['/site/logout'], 'post')
                      . Html::submitButton(
                          'Logout (' . Yii::$app->user->identity->nome . ')',
                          ['class' => 'btn btn-link logout']
                      )
                      . Html::endForm()
                      . '</li>');
                }
              ?>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="<?=Url::to(['site/signup'])?>">Sign up</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>  
    <!-- <div class="container"> -->
        <?= Alert::widget() ?>
        <?= $content ?>
    <!-- </div>  -->
    <?php $this->endBody() ?>
  </body>
</html>
<?php $this->endPage() ?>
