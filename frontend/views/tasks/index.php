<?php

use yii\helpers\Html;
use frontend\helpers\WordHelper;
use yii\widgets\ActiveForm;
use frontend\models\Categories;
use yii\widgets\LinkPager;
use yii\helpers\Url;

/**
 * @var $tasks
 * @var $pagination
 * @var $tasksFilterForm
 */

?>
<section class="new-task">
    <div class="new-task__wrapper">
        <h1>Новые задания</h1>
        <?php foreach ($tasks as $task): ?>
            <div class="new-task__card">
                <div class="new-task__title">
                    <a href="<?= Url::to(['tasks/view', 'id' => $task->id]) ?>" class="link-regular">
                        <h2><?= $task->name ?></h2></a>
                    <a class="new-task__type link-regular" href="#"><p><?= $task->category->name ?></p></a>
                </div>
                <div class="new-task__icon new-task__icon--<?= $task->category->icon ?>"></div>
                <p class="new-task_description">
                    <?= $task->description ?>
                </p>
                <b class="new-task__price new-task__price--<?= $task->category->icon ?>">
                    <?= $task->price ? $task->price . ' <b> ₽</b>' : '' ?></b>
                <p class="new-task__place"><?= Html::encode("{$task->city->name}, {$task->address_comments}, {$task->latitude}-{$task->longitude}") ?></p>
                <span class="new-task__time"><?= WordHelper::getStringTimeAgo($task->creation_time) ?> назад</span>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="new-task__pagination">
        <?= LinkPager::widget([
            'pagination' => $pagination,
            'options' => [
                'class' => 'new-task__pagination-list',
            ],
            'activePageCssClass' => 'pagination__item--current',
            'pageCssClass' => 'pagination__item',
            'prevPageCssClass' => 'pagination__item',
            'nextPageCssClass' => 'pagination__item',
            'nextPageLabel' => '⠀',
            'prevPageLabel' => '⠀',
            'hideOnSinglePage' => true
        ]) ?>
    </div>
</section>
<section class="search-task">
    <div class="search-task__wrapper">
        <?php $form = ActiveForm::begin([
            'id' => 'tasks-filter-form',
            'options' => ['class' => 'search-task__form'],
            'action' => ['/tasks'],
            'method' => 'get'
        ]) ?>
        <fieldset class="search-task__categories">
            <legend>Категории</legend>

            <?= $form->field($tasksFilterForm, 'categories', ['options' => ['class' => '']])
                ->checkboxList(Categories::find()->select(['name', 'id'])->indexBy('id')->column(), [
                    'item' => function ($index, $label, $name, $checked, $value) use ($tasksFilterForm) {
                        if (!empty($tasksFilterForm['categories']) && in_array($value,
                                $tasksFilterForm['categories'])) {
                            $checked = 'checked';
                        }
                        return '<input class="visually-hidden checkbox__input" id="categories_' . $value . '"
                         type="checkbox" name="' . $name . '" value="' . $value . '" ' . $checked . '>
                                        <label for="categories_' . $value . '">' . $label . '</label>';
                    },
                    'unselect' => null
                ])->label(false) ?>

        </fieldset>
        <fieldset class="search-task__categories">
            <legend>Дополнительно</legend>
            <?= $form->field($tasksFilterForm, 'noResponse', [
                'template' => '{input}{label}',
                'options' => ['class' => ''],
            ])
                ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => false], false)
            ?>
            <?= $form->field($tasksFilterForm, 'remoteWork', [
                'template' => '{input}{label}',
                'options' => ['class' => '']
            ])
                ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => false], false) ?>
        </fieldset>
        <?= $form->field($tasksFilterForm, 'period', [
            'template' => '{label}{input}',
            'options' => ['class' => ''],
            'labelOptions' => ['class' => 'search-task__name']
        ])
            ->dropDownList([
                '1' => 'За день',
                '2' => 'За неделю',
                '3' => 'За месяц',
                '4' => 'За все время'
            ], [
                'class' => 'multiple-select input',
                'style' => 'width: 100%',
                'prompt' => 'Выберите период'
            ]) ?>
        <?= $form->field($tasksFilterForm, 'search', [
            'template' => '{label}{input}',
            'options' => ['class' => ''],
            'labelOptions' => ['class' => 'search-task__name']
        ])
            ->input('search', [
                'class' => 'input-middle input',
                'style' => 'width: 100%'
            ]) ?>

        <?= Html::submitButton('Искать', ['class' => 'button']); ?>
        <?php ActiveForm::end() ?>
    </div>
</section>