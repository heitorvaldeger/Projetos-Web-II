<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Winery */

$this->title = Yii::t('app', 'Create Winery');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wineries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="winery-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
