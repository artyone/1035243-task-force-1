<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Cities;

?>

<section class="registration__user">
    <h1>Регистрация аккаунта</h1>
    <div class="registration-wrapper">

        <?php $form = ActiveForm::begin([
            'id' => 'form-signup',
            'options' => ['class' => 'registration__user-form form-create'],
            'action' => ['/registration'],
            'method' => 'post',
            'enableAjaxValidation' => true
        ]) ?>

        <?= $form->field($userRegisterForm, 'email', [
            'options' => ['class' => 'form']
        ])
            ->textinput([
                'class' => 'input textarea',
                'style' => 'width: 100%',
                'placeholder' => 'ivanov@mail.ru'
            ])
            ->error(['tag' => 'span', 'style' => 'display:inline-block, margin-bottom:12px']) ?>

        <?= $form->field($userRegisterForm, 'name', [
            'options' => ['class' => '']
        ])
            ->textinput([
                'class' => 'input textarea',
                'style' => 'width: 100%',
                'placeholder' => 'Иван Иванов'
            ])
            ->error(['tag' => 'span', 'style' => 'display:inline-block, margin-bottom:12px']) ?>


        <?= $form->field($userRegisterForm, 'city', [
            'options' => ['class' => '']
        ])
            ->dropDownList(
                Cities::find()->select(['name', 'id'])->indexBy('id')->column(), [
                'class' => 'multiple-select input town-select registration-town',
                'style' => 'width: 100%',
                'prompt' => ['text' => 'Выберите город', 'options' => ['class' => '']],
                'options' => [$model['city'] => ['selected' => true]]
            ])
            ->error(['tag' => 'span', 'style' => 'display:inline-block, margin-bottom:12px']) ?>

        <?= $form->field($userRegisterForm, 'password', [
            'options' => ['class' => '']
        ])
            ->passwordInput([
                'class' => 'input textarea',
                'style' => 'width: 100%',
                'type' => 'password'
            ])
            ->error(['tag' => 'span', 'style' => 'display:inline-block, margin-bottom:12px']) ?>


        <div class="form-group">
            <?= Html::submitButton('Создать аккаунт',
                ['class' => 'button button__registration', 'name' => 'signup-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</section>