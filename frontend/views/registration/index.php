<?php

use yii\helpers\Html;
use frontend\helpers\WordHelper;
use yii\widgets\ActiveForm;
use frontend\models\Categories;

?>
<!--<pre><?/*= print_r($error) */?></pre>-->
<section class="registration__user">
    <h1>Регистрация аккаунта</h1>
    <div class="registration-wrapper">

        <?php $form = ActiveForm::begin([
            'id' => 'form-signup',
            'options' => ['class' => 'registration__user-form form-create'],
            'action' => ['registration/'],
            'method' => 'post'
        ]) ?>

        <?= $form->field($model, 'email', [
            'template' => '{label}{input}',
            'options' => ['class' => 'form'],
            'labelOptions' => ['class' => '']
        ])
            ->textarea([
                'class' => 'input textarea',
                'style' => 'width: 100%',
                'rows' => 1
            ]) ?>

        <?= $form->field($model, 'name', [
            'template' => '{label}{input}',
            'options' => ['class' => ''],
            'labelOptions' => ['class' => '']
        ])
            ->textarea([
                'class' => 'input textarea',
                'style' => 'width: 100%',
                'rows' => 1
            ]) ?>
        <?= $form->field($model, 'city', [
            'template' => '{label}{input}',
            'options' => ['class' => ''],
            'labelOptions' => ['class' => '']
        ])
            ->textarea([
                'class' => 'input textarea',
                'style' => 'width: 100%',
                'rows' => 1
            ]) ?>

        <?= $form->field($model, 'password', [
            'template' => '{label}{input}',
            'options' => ['class' => '23'],
            'labelOptions' => ['class' => 'input-danger']
        ])
            ->passwordInput([
                'class' => 'input textarea',
                'style' => 'width: 100%',
                'type' => 'password'
            ]) ?>



        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'city') ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Signup', ['class' => 'button button__registration', 'name' => 'signup-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>


        <!--<form class="registration__user-form form-create">
            <label for="16">Электронная почта</label>
            <textarea class="input textarea" rows="1" id="16" name="" placeholder="kumarm@mail.ru"></textarea>
            <span>Введите валидный адрес электронной почты</span>
            <label for="17">Ваше имя</label>
            <textarea class="input textarea" rows="1" id="17" name="" placeholder="Мамедов Кумар"></textarea>
            <span>Введите ваше имя и фамилию</span>
            <label for="18">Город проживания</label>
            <select id="18" class="multiple-select input town-select registration-town" size="1" name="town[]">
                <option value="Moscow">Москва</option>
                <option selected value="SPB">Санкт-Петербург</option>
                <option value="Krasnodar">Краснодар</option>
                <option value="Irkutsk">Иркутск</option>
                <option value="Bladivostok">Владивосток</option>
            </select>
            <span>Укажите город, чтобы находить подходящие задачи</span>
            <label class="input-danger" for="19">Пароль</label>
            <input class="input textarea " type="password" id="19" name="">
            <span>Длина пароля от 8 символов</span>
            <button class="button button__registration" type="submit">Cоздать аккаунт</button>
        </form>-->
    </div>
</section>