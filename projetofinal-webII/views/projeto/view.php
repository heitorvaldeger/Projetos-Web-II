<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Projeto */

$this->title = 'Projeto '.$model->nome;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projetos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(
    "$('#refresh').click(function() {
        let rota = '" . Url::toRoute(['projeto/view']) . '?idEquipe=' . $model->Equipe_idEquipe . '&idProjeto=' . $model->id . "';
        $.ajax({
            url: rota,
            type: 'GET',
            success:
                //console.log('success'),
                $('#tableRequisitos').load(rota + ' #tableRequisitos'),
            
        });
    });"
);

?>
<div class="projeto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'idEquipe' => $model->Equipe_idEquipe, 'idProjeto' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'idEquipe' => $model->Equipe_idEquipe, 'idProjeto' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= 
            Html::a(Yii::t('app', 'Adicionar Requisitos'), 
            ['requisitos/create', 'idEquipe' => $model->Equipe_idEquipe, 'idProjeto' => $model->id], ['class' => 'btn btn-warning']) 
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'nome',
            'descricao',
            //'Cliente_idCliente',
            //'Equipe_idEquipe',
        ],
    ]) ?>

    <h4 class="d-inline">Lista de Requisitos</h4>
    <?= Html::submitButton('', ['class' => 'fas fa-sync-alt d-inline', 
                                'id' => 'refresh']); ?>
    <div class="table-responsive center">
    <table class="table table-hover" id="tableRequisitos">
        <thead class="text-center">
            <th scope="col" class="align-left">Nome</th>
            <th scope="col">Descrição</th>
            <th scope="col">Nível de Prioridade</th>
            <th scope="col">Estado</th>
            <th scope="col"></th>
        </thead>

        <?php
            foreach($listaRequisitos as $requisitos)
            {
                ?>
                    <tr class="text-center">
                    <td style="padding: 5px;">
                        <?= Html::encode($requisitos->nome)?>
                    </td>
                    <td style="padding: 5px;">
                        <?= Html::encode($requisitos->descricao)?>
                    </td>
                    <td style="padding: 5px;">
                        <?php
                            $np = Html::encode($requisitos->nivelPrioridade);
                            if($np == '1')
                            {
                                echo 'Alto';
                            }
                            else
                            {
                                echo 'Baixo';
                            }
                        ?>
                    </td>

                    <?php
                        if($requisitos->estado == 'Preparado')
                        {
                    ?>
                        <td style="padding: 5px;" class="bg-info align-middle">                            
                    <?php
                        }
                        elseif($requisitos->estado == 'Em execução')
                        {
                    ?>
                        <td style="padding: 5px;" class="bg-warning"> 
                    <?php
                        }
                        elseif($requisitos->estado == 'Finalizado')
                        {
                    ?>
                        <td style="padding: 5px;" class="bg-success">
                    <?php
                        }
                    ?>                    
                    <?= mb_strtoupper(Html::encode($requisitos->estado), 'UTF-8')?>
                    </td>
                    <td>
                        <?php
                            $url = Url::to(['requisitos/update', 
                            'idEquipe' => $model->Equipe_idEquipe,
                            'idProjeto' => $model->id,
                            'idRequisito' => $requisitos->id]);
                            echo Html::a('<span class="fa fa-pencil-alt"></span>', $url, ['title' => 'update']);
                        ?>
                        <?php
                             echo (Html::a('<span class="fa fa-trash-alt"></span>', Url::to(['requisitos/delete-requisito', 
                             'idEquipe' => $model->Equipe_idEquipe,
                             'idProjeto' => Html::encode(ArrayHelper::getValue($model, 'id')),
                             'idRequisito' => Html::encode(ArrayHelper::getValue($requisitos, 'id')),                              
                             ]), [
                            'title' => 'Delete Project',
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete requirement?'),
                            'data-method'  => 'post',
                            ]));
                        ?>

                        <?php
                            $url = Url::to(['requisitos/view', 
                            'idEquipe' => $model->Equipe_idEquipe,
                            'idProjeto' => Html::encode(ArrayHelper::getValue($requisitos, 'Projeto_idProjeto')),
                            'idRequisito' => Html::encode(ArrayHelper::getValue($requisitos, 'id')),                            
                            ]);
                            echo (Html::a('<span class="fa fa-eye"></span>', $url, ['title' => 'view']));
                        ?>
                    </td>
                    </tr>
                <?php
            }
        ?>
    </table>
    </div>
</div>