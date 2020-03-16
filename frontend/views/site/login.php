<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $userLoginForm */

?>

<section class="registration__user">
    <h1 style="text-align: center">Вход на сайт</h1>
    <div class="registration-wrapper">

        <?php $form = ActiveForm::begin([
            'id' => 'user-login-form',
            'options' => ['class' => 'registration__user-form form-create'],
            'action' => ['/login'],
            'method' => 'post',
            'enableAjaxValidation' => true
        ]) ?>

        <?= $form->field($userLoginForm, 'email', [
            'options' => ['class' => '']
        ])
            ->textinput([
                'class' => 'input textarea',
                'style' => 'width: 100%',
            ])
            ->error(['tag' => 'span']) ?>

        <?= $form->field($userLoginForm, 'password', [
            'options' => ['class' => ''],
            'labelOptions' => ['style' => 'color: #333438']

        ])
            ->passwordInput([
                'class' => 'input textarea',
                'style' => 'width: 100%; border-color: #e4e9f2',
                'type' => 'password',
            ])
            ->error(['tag' => 'span']) ?>



        <div class="form-group">
            <?= Html::submitButton('Войти',
                ['class' => 'button button__login', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</section>