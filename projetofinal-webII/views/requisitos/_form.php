<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Requisitos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="requisitos-form">

    <?php $form = ActiveForm::begin([
        'id' => 'requisitos-form',
        'fieldConfig' => [
            'template' => "{input}",
            'options' => [
                //Desabilita as tags que pertencem ao formulário
                'tag' => false,
            ],
        ],  
    ]); ?>

    <?php //$form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?php //$form->field($model, 'descricao')->textarea(['rows' => 6]) ?>

    <?php //$form->field($model, 'nivelPrioridade')->textInput() ?>

    <?php //$form->field($model, 'estado')->dropDownList([ 'Finalizado' => 'Finalizado', 'Em execução' => 'Em execução', 'Preparado' => 'Preparado', ]) ?>

    <?php //$form->field($model, 'Projeto_idProjeto')->textInput() ?>
    <br/>
    <br/>
    <div class="form-group field-requisitosform-nome">
        <div class="wrap-input100 validate-input" data-validate = "Enter nome">
            <?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'class' => ['input100'],
                                                                                    'id' => 'requisitosform-nome',
                                                                                    'aria-required' => 'true',
                                                                                    'aria-invalid' => 'true'
                                                                                    ])->label(false) ?> 
            <span class="focus-input100" data-placeholder="Digite o nome do requisito"></span>                                               
        </div>
        <div class="col-lg-20">
            <p class="help-block help-block-error text-danger"></p>
        </div> 
    </div>    

    <div class="form-group field-requisitosform-descricao">
        <div class="wrap-input100 validate-input" data-validate = "Enter descricao">
        <?= $form->field($model, 'descricao')->textInput(['maxlength' => true, 'class' => ['input100'],
                                                                                'id' => 'requisitosform-descricao',
                                                                                'aria-required' => 'true',
                                                                                'aria-invalid' => 'true'
                                                                                ])->label(false) ?> 
            <span class="focus-input100" data-placeholder="Descrição do requisito"></span>                                               
        </div>
        <div class="col-lg-20">
            <p class="help-block help-block-error text-danger"></p>
        </div> 
    </div>    

    <div class="form-group field-requisitosform-nivelPrioridade">
        <p>Nível de Prioridade</p>
        <div class="wrap-input100 validate-input" data-validate = "Enter nivelPrioridade">
        <?= $form->field($model, 'nivelPrioridade')->dropDownList([1 => 'Alto',
        0 => 'Baixo'])?> 
        </div>
        <div class="col-lg-20">
            <p class="help-block help-block-error text-danger"></p>
        </div> 
    </div>    
    
    <div class="form-group field-requisitosform-estado">
        <p>Estado</p>
        <div class="wrap-input100 validate-input" data-validate = "Enter estado">
        <?= $form->field($model, 'estado')->dropDownList(['Finalizado' => 'Finalizado', 
                                                        'Em execução' => 'Em execução', 
                                                        'Preparado' => 'Preparado'])?> 
                                                          
        </div>
        <div class="col-lg-20">
            <p class="help-block help-block-error text-danger"></p>
        </div> 
    </div> 

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
