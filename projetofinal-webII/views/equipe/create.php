<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Equipe */

$this->title = Yii::t('app', 'Create Equipe');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Equipes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipe-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
