<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MembroSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Membros');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="membro-index">

    <h4>Bem - vindo <?= Html::encode(Yii::$app->user->identity->nome) ?></h4>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //Html::a(Yii::t('app', 'Create Membro'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    // GridView::widget([
    //     'dataProvider' => $dataProvider,
    //     'filterModel' => $searchModel,
    //     'columns' => [
    //         ['class' => 'yii\grid\SerialColumn'],

    //         //'id',
    //         'nome',
    //         'email:email',
    //         'senha',
    //         //'access_token',
    //         //'auth_key',

    //         ['class' => 'yii\grid\ActionColumn'],
    //     ],
    // ]); ?>
</div>
