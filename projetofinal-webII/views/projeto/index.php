<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjetoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Projetos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projeto-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //Html::a(Yii::t('app', 'Create Projeto'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nome',
            'descricao',
            //'Cliente_idCliente',
            //'nomeEquipe',
            // [
            //     'label' => 'Nome Equipe',
            //     'value' => 'equipe.nomeOrganizacao'
            // ],
            [
            'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete} {update}',
                'buttons'  => [
                    'view' => function ($url, $model) {
                        $url = Url::toRoute(['projeto/view', 'idEquipe' => $model->Equipe_idEquipe, 'idProjeto' => $model->id]);
                        return Html::a('<span class="fa fa-eye"></span>', $url, ['title' => 'view']);
                    },
                    'update' => function ($url, $model) {
                        $url = Url::to(['projeto/update', 'idEquipe' => $model->Equipe_idEquipe, 'idProjeto' => $model->id]);
                        return Html::a('<span class="fa fa-pencil-alt"></span>', $url, ['title' => 'update']);
                    },
                    'delete' => function ($url, $model) {
                        $url = Url::to(['projeto/delete', 'idEquipe' => $model->Equipe_idEquipe, 'idProjeto' => $model->id]);
                        return Html::a('<span class="fa fa-trash-alt"></span>', $url, [
                            'title'        => 'delete',
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method'  => 'post',
                        ]);
                    },
                ],
            ],
        ],
    ]); 
    ?>

    
</div>
