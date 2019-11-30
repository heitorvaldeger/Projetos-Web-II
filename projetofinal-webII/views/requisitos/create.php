<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Requisitos */

$this->title = Yii::t('app', 'Create Requisitos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Requisitos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requisitos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
