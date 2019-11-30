<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Equipe */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="equipe-form">

    <?php $form = ActiveForm::begin([
        'id' => 'equipe-form',
        'fieldConfig' => [
            'template' => "{input}",
            'options' => [
                //Desabilita as tags que pertencem ao formulário
                'tag' => false,
            ],
        ],  
    ]); ?>

    <?php //$form->field($model, 'nomeOrganizacao')->textInput(['maxlength' => true]) ?>
    <br/>
    <br/>
    <div class="form-group field-equipeform-nomeOrganizacao">
    <div class="wrap-input100 validate-input" data-validate = "Enter password">
    <?= $form->field($model, 'nomeOrganizacao')->textInput(['maxlength' => 16, 'class' => ['input100'],
                                                                            'id' => 'equipeform-nomeOrganizacao',
                                                                            'aria-required' => 'true',
                                                                            'aria-invalid' => 'true'
                                                                            ])->label(false) ?> 
        <span class="focus-input100" data-placeholder="Digite o nome da equipe"></span>                                               
    </div>
        <div class="col-lg-20"><p class="help-block help-block-error text-danger"></p></div> 
    </div>  

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
