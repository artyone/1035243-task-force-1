<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Categories;

/**
 * @var $taskCreateForm
 * @var $errors
 */
?>


<section class="create__task">
    <h1>Публикация нового задания</h1>
    <div class="create__task-main">

        <?php $form = ActiveForm::begin([
            'id' => 'task-create-form',
            'options' => ['class' => 'create__task-form form-create'],
            'action' => ['/task/create'],
            'method' => 'post',
            'enableAjaxValidation' => false,
            'enableClientValidation' => false
        ]) ?>

        <?= $form->field($taskCreateForm, 'name')
            ->textarea([
                'class' => 'input textarea',
                'rows' => '1',
                'style' => ['width' => '95%'],
                'placeholder' => 'Повесить полку'
            ])
            ->hint('Кратко опишите суть работы', ['tag' => 'span'])
            ->error(['tag' => 'span']) ?>

        <?= $form->field($taskCreateForm, 'description')
            ->textarea([
                'class' => 'input textarea',
                'rows' => '4',
                'style' => ['width' => '95%'],
                'placeholder' => 'Требуется повесить полку надо окном в гостинной комнате'
            ])
            ->hint('Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться', ['tag' => 'span'])
            ->error(['tag' => 'span']) ?>

        <?= $form->field($taskCreateForm, 'categoryId')
            ->dropDownList(
                Categories::find()->select(['name', 'id'])->indexBy('id')->column(), [
                'class' => 'multiple-select input multiple-select-big',
                'style' => 'width: 95%',
                'prompt' => ['text' => 'Выберите категорию', 'options' => []],
                'options' => [$taskCreateForm['categoryId'] => ['selected' => true]]
            ])
            ->hint('Выберите категорию', ['tag' => 'span'])
            ->error(['tag' => 'span']) ?>

        <?= $form->field($taskCreateForm, 'files[]')
            ->fileInput([
                'multiple' => true,
                'class' => '',
                'style' => ['width' => '95%', 'margin-bottom' => '10px']
            ])
            ->hint('Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу', ['tag' => 'span'])
            ->error(['tag' => 'span']) ?>

        <?= $form->field($taskCreateForm, 'location')
            ->textInput([
                'class' => 'input-navigation input-middle input',
                'style' => ['width' => '95%'],
                'placeholder' => 'Санкт-Петербург, Калининский район'
            ])
            ->hint('Укажите адрес исполнения, если задание требует присутствия', ['tag' => 'span'])
            ->error(['tag' => 'span']) ?>

        <div class="create__price-time">
            <div class="create__price-time--wrapper">
                <?= $form->field($taskCreateForm, 'price')
                    ->textInput([
                        'class' => 'input textarea input-money',
                        'style' => ['width' => '90%'],
                        'placeholder' => '1000'
                    ])
                    ->hint('Не заполняйте для оценки исполнителем', ['tag' => 'span'])
                    ->error(['tag' => 'span']) ?>
            </div>
            <div class="create__price-time--wrapper">
                <?= $form->field($taskCreateForm, 'deadlineTime')
                    ->textInput([
                        'type' => 'date',
                        'class' => 'input-middle input input-date',
                        'style' => ['width' => '90%'],
                        'placeholder' => '10.11, 15:00'
                    ])
                    ->hint('Укажите крайний срок исполнения', ['tag' => 'span'])
                    ->error(['tag' => 'span']) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Опубликовать',
                ['class' => 'button', 'name' => 'create-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <div class="create__warnings">
            <div class="warning-item warning-item--advice">
                <h2>Правила хорошего описания</h2>
                <h3>Подробности</h3>
                <p>Друзья, не используйте случайный<br>
                    контент – ни наш, ни чей-либо еще. Заполняйте свои
                    макеты, вайрфреймы, мокапы и прототипы реальным
                    содержимым.</p>
                <h3>Файлы</h3>
                <p>Если загружаете фотографии объекта, то убедитесь,
                    что всё в фокусе, а фото показывает объект со всех
                    ракурсов.</p>
            </div>
            <?php if ($errors): ?>
            <div class="warning-item warning-item--error">
                <h2>Ошибки заполнения формы</h2>
                <?php foreach ($errors as $name => $error): ?>
                    <h3><?= $taskCreateForm->attributeLabels()[$name] ?></h3>
                    <p>
                        <?php foreach ($error as $description): ?>
                            <?= $description ?> <br>
                        <?php endforeach; ?>
                    </p>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
