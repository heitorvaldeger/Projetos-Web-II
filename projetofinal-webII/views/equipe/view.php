<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Equipe */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Equipes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs(
    "$('#refresh').click(function() {
        let rota = '" . Url::toRoute(['equipe/view']) . '?idEquipe=' . $model->id . "';
        $.ajax({
            url: rota,
            type: 'GET',
            success:
                //console.log('success'),
                $('#tableMembros').load(rota + '#tableMembros'),
            
        });
    });"
);
?>

<div class="equipe-view">

    <h1><?= Html::encode($model->nomeOrganizacao) ?></h1>

    <p>        
        <?php
            $auth = Yii::$app->authManager;
            $role = $auth->getRolesByUser('user'.Yii::$app->user->identity->id.'equipe'.$model->id);
            
            if(array_key_exists('membroadmin', $role))
            {
                echo (Html::a(Yii::t('app', 'Update'), ['update', 'idEquipe' => $model->id], ['class' => 'btn btn-primary']));
                echo (Html::a(Yii::t('app', 'Delete'), ['delete', 'idEquipe' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]));
                echo (Html::a(Yii::t('app', 'Adicionar Membros'), 
                ['update', 'id' => $model->id], ['class' => 'btn btn-dark', 
                'data-toggle' => 'modal',
                'data-target' => '#myModal']));
                echo (Html::a(Yii::t('app', 'Cadastrar Projeto'), 
                ['projeto/create', 'idEquipe' => $model->id], ['class' => 'btn btn-warning']));
            }
        ?>
         <?= 
            Html::a(Yii::t('app', 'Visualizar Projetos'), 
            ['projeto/index', 'idEquipe' => $model->id], ['class' => 'btn btn-info']) 
        ?>        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'nomeOrganizacao',
        ],
    ]) ?>
   
    <h2 class="d-inline">Lista de Membros</h2>

    <?= Html::submitButton('', ['class' => 'fas fa-sync-alt d-inline', 
                                'id' => 'refresh',
                                'value' => 'asdad']); ?>
    <table class="table" id="tableMembros">
        <th scope="col">Nome</th>
        <th scope="col">Email</th>
        <th scope="col"></th>
        <?php
            foreach ($listaDeMembros as $membro) 
            {
                /**
                 * Se membro_administrador == 1, então a tupla ficará verde
                 */
                if(ArrayHelper::getValue($membro, 'Membro_administrador') == 1)
                {
                ?>
                    <tr scope="row" class="table-success">                    
                <?php
                }
                /**
                 * Se não, a tupla ficará cinza
                 */
                else
                {
                    ?>
                    <tr scope="row">                    
                <?php
                }
                ?>
                    <td style="padding: 5px;">
                        <?= Html::encode(ArrayHelper::getValue($membro, 'nome'))?>
                    </td>
                    <td>
                        <?= Html::encode(ArrayHelper::getValue($membro, 'email'))?>    
                    </td>
                    <td>
                    <?php
                         $auth = Yii::$app->authManager;
                         $role = $auth->getRolesByUser('user'.Yii::$app->user->identity->id.'equipe'.$model->id);
                         if(array_key_exists('membroadmin', $role))
                         {
                            echo (Html::a('<span class="fa fa-trash-alt"></span>', Url::to(['membro/teste', 'idMembro' => 
                                Html::encode(ArrayHelper::getValue($membro, 'id')), 
                                'idEquipe' => $model->id]), [
                                'title'        => 'delete',
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method'  => 'post',
                            ]));
                            /**
                             * Se membro_administrador == 1, mostrará o ícone da seta para baixo
                             */
                            if(ArrayHelper::getValue($membro, 'Membro_administrador') == 1)
                            {
                                echo (Html::a('<span class="fa fa-arrow-down"></span>', Url::to(['membro/promote-demote', 'idMembro' => 
                                                                                        Html::encode(ArrayHelper::getValue($membro, 'id')), 
                                                                                        'idEquipe' => $model->id,
                                                                                        'var' => 1]), [ 
                                    'title' => 'Rebaixar Membro',  
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to demote member?'),                             
                                    'data-method'  => 'post',
                                ]));
                            }
                            /**
                             * Se não, mostrará o ícone da seta para cima
                             */
                            else
                            {
                                echo (Html::a('<span class="fa fa-arrow-up"></span>', Url::to(['membro/promote-demote', 'idMembro' => 
                                                                                    Html::encode(ArrayHelper::getValue($membro, 'id')), 
                                                                                    'idEquipe' => $model->id,
                                                                                    'var' => 0]), [
                                    'title' => 'Promover Membro',
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to promote member?'),
                                    'data-method'  => 'post',
                                ]));
                            }
                        }
                    ?>
                    </td>
                    
                </tr>
                <?php
            }
        ?>
    </table>

     <!-- Modal de Adicionar Membro-->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Adicionar membro</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'enableAjaxValidation' => true,
                        'layout' => 'horizontal',
                            'fieldConfig' => [
                                'template' => "{input}",
                                'options' => [
                                    //Desabilita as tags que pertencem ao formulário
                                    'tag' => false,
                                ],
                            ],
                    ]); ?>
                <div class="modal-body">                
                    <!-- Campo email -->
                    <?php //$form->field($modelMembro, 'email')->textInput(['maxlength' => 50])?>
                    <br/>
                    <br/>
                    <div class="form-group field-loginform-email">
                    <div class="wrap-input100 validate-input" data-validate = "Enter email">
                    <?= $form->field($modelMembro, 'email')->textInput(['maxlength' => 50, 'class' => ['input100'],
                                                                                            'id' => 'loginform-email',
                                                                                            'aria-required' => 'true',
                                                                                            'aria-invalid' => 'true'
                                                                                            ])->label(false) ?> 
                        <span class="focus-input100" data-placeholder="Digite o email"></span>                                               
                    </div>
                        <div class="col-lg-20"><p class="help-block help-block-error text-danger"></p></div> 
                    </div>    
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Confirmar Inscrição', ['class' => 'btn btn-success']); ?>
                </div>
                <?php ActiveForm::end(); ?> 
            </div>
        </div>
    </div>
<script>
// jQuery(function ($) {
// jQuery('#login-form').yiiActiveForm([
//     {"id":"loginform-email","name":"email","container":".field-loginform-email","input":"#loginform-email","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, {"message":"\"Email\" não pode ficar em branco."});}},
//     {"id":"loginform-password","name":"password","container":".field-loginform-password","input":"#loginform-password","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, {"message":"\"Senha\" não pode ficar em branco."});}},{"id":"loginform-rememberme","name":"rememberMe","container":".field-loginform-rememberme","input":"#loginform-rememberme","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.boolean(value, messages, {"trueValue":"1","falseValue":"0","message":"\"Remember Me\" deve ser \"1\" ou \"0\".","skipOnEmpty":1});}}], []);
// });
</script>