<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Projeto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="projeto-form">

    <?php $form = ActiveForm::begin([
        'id' => 'projeto-form',
        'fieldConfig' => [
            'template' => "{input}",
            'options' => [
                //Desabilita as tags que pertencem ao formulário
                'tag' => false,
            ],
        ],  
    ]); ?>

    <?php //$form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?php //$form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <br/>
    <br/>
    <div class="form-group field-projetoform-nome">
    <div class="wrap-input100 validate-input">
    <?= $form->field($model, 'nome')->textInput(['maxlength' => 16, 'class' => ['input100'],
                                                                            'id' => 'projetoform-nome',
                                                                            'aria-required' => 'true',
                                                                            'aria-invalid' => 'true'
                                                                            ])->label(false) 
    ?> 
        <span class="focus-input100" data-placeholder="Digite o nome do projeto"></span>                                               
    </div>
        <div class="col-lg-20"><p class="help-block help-block-error text-danger"></p></div> 
    </div>  

    <div class="form-group field-projetoform-descricao">
    <div class="wrap-input100 validate-input">
    <?= $form->field($model, 'descricao')->textInput(['maxlength' => 16, 'class' => ['input100'],
                                                                            'id' => 'projetoform-descricao',
                                                                            'aria-required' => 'true',
                                                                            'aria-invalid' => 'true'
                                                                            ])->label(false) 
    ?> 
        <span class="focus-input100" data-placeholder="Digite uma descricao do projeto"></span>                                               
    </div>
        <div class="col-lg-20"><p class="help-block help-block-error text-danger"></p></div> 
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
