<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Wine */

$this->title = Yii::t('app', 'Create Wine');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wine-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
