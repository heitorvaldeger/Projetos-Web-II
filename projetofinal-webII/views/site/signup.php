<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Cadastrar-se';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <?php $form = ActiveForm::begin([
                    'id' => 'signup-form',    
                    'fieldConfig' => [
                    'template' => '{input}',
                    'options' => [
                        //Desabilita as tags que pertencem ao formulário
                        'tag' => false,
                    ],
                    ],
                ]); ?>
                    <span class="login100-form-title p-b-26">
                        <?= Html::encode($this->title) ?>
                    </span>
                    <span class="login100-form-title p-b-48">
                        <i class="zmdi zmdi-font"></i>
                    </span>

                    <!-- Campo ID -->
                    <div class="form-group field-loginform-id">
                    <div class="wrap-input100 validate-input">
                        <?= $form->field($model, 'id')->textInput(['maxlength' => true, 'class' => ['input100'],
                                                                                            'id' => 'loginform-id',
                                                                                            'aria-required' => 'true',
                                                                                            'aria-invalid' => 'true'
                                                                                            ])->label(false) ?> 
                        <span class="focus-input100" data-placeholder="ID"></span>                                               
                    </div>
                        <div class="col-lg-20"><p class="help-block help-block-error text-danger"></p></div> 
                    </div>

                    <!-- Campo Nome -->
                    <div class="form-group field-loginform-nome">
                    <div class="wrap-input100 validate-input">
                        <?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'class' => ['input100'],
                                                                                          'id' => 'loginform-nome',
                                                                                          'aria-required' => 'true',
                                                                                          'aria-invalid' => 'true'
                                                                                          ])->label(false) ?>                                                                        
                        <span class="focus-input100" data-placeholder="Nome"></span>                                               
                    </div>
                        <div class="col-lg-20"><p class="help-block help-block-error text-danger"></p></div> 
                    </div>

                    <!-- Campo Email -->
                    <div class="form-group field-loginform-email">
                    <div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
                        <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'class' => ['input100'],
                                                                                            'id' => 'loginform-email',
                                                                                            'aria-required' => 'true',
                                                                                            'aria-invalid' => 'true'
                                                                                            ])->label(false) ?> 
                        <span class="focus-input100" data-placeholder="Email"></span>                                               
                    </div>
                        <div class="col-lg-20"><p class="help-block help-block-error text-danger"></p></div> 
                    </div>

                    <!-- Campo Senha -->
                    <div class="form-group field-loginform-senha">
                    <div class="wrap-input100 validate-input" data-validate = "Enter password">
                        <?= $form->field($model, 'senha')->passwordInput(['maxlength' => 16, 'class' => ['input100'],
                                                                                            'id' => 'loginform-senha',
                                                                                            'aria-required' => 'true',
                                                                                            'aria-invalid' => 'true'
                                                                                            ])->label(false) ?> 
                        <span class="focus-input100" data-placeholder="Senha"></span>                                               
                    </div>
                        <div class="col-lg-20"><p class="help-block help-block-error text-danger"></p></div> 
                    </div>                    

                    <div class="container-login100-form-btn">   
                                      
                        <div class="wrap-login100-form-btn">                        
                            <div class="login100-form-bgbtn"></div>                                            
                            <?= Html::submitButton('Cadastrar', ['class' => 'login100-form-btn', 'name' => 'login-button']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-1 col-lg-11">
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>   
            </div>
        </div>
    </div>
    <div id="dropDownSelect1"></div>    
</div>

<script>
jQuery(function ($) {
jQuery('#signup-form').yiiActiveForm([
    {"id":"loginform-nome","name":"nome","container":".field-loginform-nome","input":"#loginform-nome","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, {"message":"\"Nome\" não pode ficar em branco."});}},
    {"id":"loginform-senha","name":"senha","container":".field-loginform-senha","input":"#loginform-senha","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, {"message":"\"Senha\" não pode ficar em branco."});}},
    {"id":"loginform-email","name":"email","container":".field-loginform-email","input":"#loginform-email","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, {"message":"\"Email\" não pode ficar em branco."});}},
    {"id":"loginform-id","name":"id","container":".field-loginform-id","input":"#loginform-id","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, {"message":"\"ID\" não pode ficar em branco."});}},
    ], []);
});

</script>