<?php

use yii\helpers\Html;
use frontend\helpers\WordHelper;
use yii\widgets\ActiveForm;
use frontend\models\Cities;

?>

<section class="registration__user">
    <h1>Регистрация аккаунта</h1>
    <div class="registration-wrapper">

        <?php $form = ActiveForm::begin([
            'id' => 'form-signup',
            'options' => ['class' => 'registration__user-form form-create'],
            'action' => ['registration/'],
            'method' => 'post',
        ]) ?>

        <?= $form->field($model, 'email', [
            'options' => ['class' => 'form'],
        ])
            ->textinput([
                'class' => 'input textarea',
                'style' => 'width: 100%'
            ])
            ->error(['tag'=>'span']) ?>

        <?= $form->field($model, 'name', [
            'options' => ['class' => ''],
        ])
            ->textinput([
                'class' => 'input textarea',
                'style' => 'width: 100%'
            ])
            ->error(['tag'=>'span']) ?>


        <?php echo $form->field($model, 'city', [
            'options' => ['class' => '']
        ])
            ->dropDownList(
                Cities::find()->select(['name', 'id'])->indexBy('id')->column(),
                [
                    'class' => "multiple-select input town-select registration-town",
                    'style' => 'width: 100%',
                    'prompt' => ['text' => 'Выберите город', 'options' => [ 'class' => '']],
                    'options' => [$model['city'] => ['selected' => true]]]
            )
            ->error(['tag'=>'span']) ?>

        <?= $form->field($model, 'password', [
            'options' => ['class' => ''],
        ])
            ->passwordInput([
                'class' => 'input textarea',
                'style' => 'width: 100%',
                'type' => 'password'
            ])
            ->error(['tag'=>'span']) ?>


        <div class="form-group">
            <?= Html::submitButton('Создать аккаунт', ['class' => 'button button__registration', 'name' => 'signup-button']) ?>
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