<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{input}",
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
                        <i class="zmdi zmdi-font">
                            <img src="<?= Url::to(['login/images/icons/favicon.ico'])?>"/>
                        </i>
                    </span>

                    <!-- Esse campo precisa ser alterado para email -->
                    <div class="form-group field-loginform-email">
                    <div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'class' => ['input100'],
                                                                                          'id' => 'loginform-email',
                                                                                          'aria-required' => 'true',
                                                                                          'aria-invalid' => 'true'
                                                                                          ])->label(false) ?>  
                        <span class="focus-input100" data-placeholder="Digite o seu email"></span>                                               
                    </div>
                    <div class="col-lg-20"><p class="help-block help-block-error text-danger"></p></div> 
                    </div>

                    <div class="form-group field-loginform-password">
                    <div class="wrap-input100 validate-input" data-validate = "Enter password">
                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 16, 'class' => ['input100'],
                                                                                            'id' => 'loginform-password',
                                                                                            'aria-required' => 'true',
                                                                                            'aria-invalid' => 'true'
                                                                                            ])->label(false) ?> 
                        <span class="focus-input100" data-placeholder="Digite sua senha"></span>                                               
                    </div>
                        <div class="col-lg-20"><p class="help-block help-block-error text-danger"></p></div> 
                    </div>                    

                    <div class="container-login100-form-btn">
                        <?= $form->field($model, 'rememberMe')->checkbox([
                                    'class' => "<div class=\"fa fa-check-square-o\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                                ]) ?>    
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>                                            
                            <?= Html::submitButton('Login', ['class' => 'login100-form-btn', 'name' => 'login-button']) 
                            ?>
                        </div>
                    </div>

                    <div class="text-center p-t-115">
                        <span class="txt1">
                            Don’t have an account?
                        </span>

                        <!-- <a class="txt2" href="<?= Url::to(['site/signup']); ?>">
                            Sign Up
                        </a> -->
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-1 col-lg-11">
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>   
            </div>
        </div>
    </div>
</div>

<script>
jQuery(function ($) {
jQuery('#login-form').yiiActiveForm([
    {"id":"loginform-email","name":"email","container":".field-loginform-email","input":"#loginform-email","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, {"message":"\"Email\" não pode ficar em branco."});}},
    {"id":"loginform-password","name":"password","container":".field-loginform-password","input":"#loginform-password","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, {"message":"\"Senha\" não pode ficar em branco."});}},{"id":"loginform-rememberme","name":"rememberMe","container":".field-loginform-rememberme","input":"#loginform-rememberme","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.boolean(value, messages, {"trueValue":"1","falseValue":"0","message":"\"Remember Me\" deve ser \"1\" ou \"0\".","skipOnEmpty":1});}}], []);
});
</script>