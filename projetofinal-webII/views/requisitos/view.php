<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Requisitos */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Requisitos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs(
    "$('#recarregarModalRequisitos').click(function() {
        let rota = '" . Url::toRoute(['requisitos/view']) . '&id=' . $model->id . '&idProjeto=' . $model->Projeto_idProjeto . "';
        $.ajax({
            url: rota,
            type: 'GET',
            success:
                //console.log('success'),
                $('#modalbody').load(rota + ' #modalbody'),
            
        });
    });"
);
?>
<div class="requisitos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'idEquipe' => $idEquipe, 'idProjeto' => $model->Projeto_idProjeto, 'idRequisito' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete-requisito', 'idEquipe' => $idEquipe, 'idProjeto' => $model->Projeto_idProjeto, 'idRequisito' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app', 'Adicionar Dependente'), ['dependente', 'id' => $model->id], [
            'class' => 'btn btn-success',
            'data-toggle' => 'modal',
            'data-target' => '#modalRequirementsList',
        ]) ?>
    </p>

    <?php
        echo (DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                'nome',
                'descricao:ntext',
                'nivelPrioridade',
                'estado',
                //'Projeto_idProjeto',
            ],
        ]));
    ?>

    <h4>Lista de Dependência</h4>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nome',
            'descricao:ntext',
            'nivelPrioridade',
            'estado',
            //'Projeto_idProjeto',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete} {update}',
                'buttons'  => [                   
                    'update' => function ($url, $model){
                        $url = Url::to(['requisitos/update', 'id' => $model->id]);
                        return Html::a('<span class="fa fa-pencil-alt"></span>', $url, ['title' => 'update']);
                    },
                    'delete' => function ($url, $model) use ($requisito, $idEquipe){
                        $url = Url::to(['requisitos/delete-dependente', 
                        'idEquipe' => $idEquipe,
                        'idRequisito' => $requisito,
                        'idDependente' => $model->id,                        
                        'idProjeto' => $model->Projeto_idProjeto]);
                        return Html::a('<span class="fa fa-trash-alt"></span>', $url, [
                            'title'        => 'delete',
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method'  => 'post',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
    
    <!-- Modal que exibe a lista de requisitos para poder adicionar dependentes -->
    <div class="modal fade" id="modalRequirementsList" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="modalbody">                
                    <table class="table table-hover">
                        <thead class="text-center">
                            <th scope="col">Código do Requisito</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Descricao</th>     
                            <th scope="col"></th>                                   
                        </thead>

                        <?php
                            foreach($requirements as $requirement)
                            {
                                ?>
                                <tr class="text-center">
                                    <td><?= Html::encode($requirement->id)?></td>
                                    <td><?= Html::encode($requirement->nome)?></td>
                                    <td><?= Html::encode($requirement->descricao)?></td>
                                    <td>
                                        <?php 
                                            $url = Url::to(['requisitos/add-dependente', 'idEquipe' => $idEquipe, 'idRequisito' => $model->id,'idDependente' => $requirement->id, 'idProjeto' => $model->Projeto_idProjeto]);
                                            echo Html::a('<span class="fa fa-plus"></span>', $url, ['title' => 'Adicionar']);
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        ?>
                    </table>
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Recarregar', ['class' => 'btn btn-success', 
                                                        'id' => 'recarregarModalRequisitos']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
