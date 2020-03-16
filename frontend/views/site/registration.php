<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Cities;

/** @var $userRegisterForm */

?>

<section class="registration__user">
    <h1>Регистрация аккаунта</h1>
    <div class="registration-wrapper">

        <?php $form = ActiveForm::begin([
            'id' => 'user-register-form',
            'options' => ['class' => 'registration__user-form form-create'],
            'action' => ['/registration'],
            'method' => 'post'
        ]) ?>

        <?= $form->field($userRegisterForm, 'email', [
            'options' => ['class' => ''],
            'enableAjaxValidation' => true
        ])
            ->textinput([
                'class' => 'input textarea',
                'style' => 'width: 91%',
                'placeholder' => 'ivanov@mail.ru'
            ])
            ->hint('Введите ваш адрес электронной почты', ['tag' => 'span'])
            ->error(['tag' => 'span']) ?>

        <?= $form->field($userRegisterForm, 'name', [
            'options' => ['class' => '']
        ])
            ->textinput([
                'class' => 'input textarea',
                'style' => 'width: 91%',
                'placeholder' => 'Иван Иванов'
            ])
            ->hint('Введите ваше имя и фамилию', ['tag' => 'span'])
            ->error(['tag' => 'span']) ?>


        <?= $form->field($userRegisterForm, 'city', [
            'options' => ['class' => ''],
            'enableAjaxValidation' => true
        ])
            ->dropDownList(
                Cities::find()->select(['name', 'id'])->indexBy('id')->column(), [
                'class' => 'multiple-select input town-select registration-town',
                'style' => 'width: 100%',
                'prompt' => ['text' => 'Выберите город', 'options' => ['class' => '']],
                'options' => [$userRegisterForm['city'] => ['selected' => true]]
            ])
            ->hint('Укажите город, чтобы находить подходящие задачи', ['tag' => 'span'])
            ->error(['tag' => 'span']) ?>

        <?= $form->field($userRegisterForm, 'password', [
            'options' => ['class' => '']
        ])
            ->passwordInput([
                'class' => 'input textarea',
                'style' => 'width: 91%',
                'type' => 'password'
            ])
            ->hint('Введите пароль. Минимально 8 знаков.', ['tag' => 'span'])
            ->error(['tag' => 'span']) ?>


        <div class="form-group">
            <?= Html::submitButton('Создать аккаунт',
                ['class' => 'button button__registration', 'name' => 'register-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</section>
<div class="clipart-woman">
    <img src="/img/clipart-woman.png" width="238" height="450" alt="Промо фото">
</div>
<div class="clipart-message">
    <div class="clipart-message-text">
        <h2>Знаете ли вы, что?</h2>
        <p>После регистрации вам будет доступно более
            двух тысяч заданий из двадцати разных категорий.</p>
        <p>В среднем, наши исполнители зарабатывают
            от 500 рублей в час.</p>
    </div>
</div>