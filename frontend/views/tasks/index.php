<?php

use yii\helpers\Html;
use frontend\helpers\WordHelper;
use yii\widgets\ActiveForm;
use frontend\models\Categories;

?>
<section class="new-task">
    <div class="new-task__wrapper">
        <h1>Новые задания</h1>
        <?php foreach ($tasks as $task): ?>
            <div class="new-task__card">
                <div class="new-task__title">
                    <a href="#" class="link-regular"><h2><?= $task->name ?></h2></a>
                    <a class="new-task__type link-regular" href="#"><p><?= $task->category->name ?></p></a>
                </div>
                <div class="new-task__icon new-task__icon--<?= $task->category->icon ?>"></div>
                <p class="new-task_description">
                    <?= $task->description ?>
                </p>
                <b class="new-task__price new-task__price--<?= $task->category->icon ?>"><?= $task->price ?> <b> ₽</b></b>
                <p class="new-task__place"><?= Html::encode("{$task->city->name}, {$task->address_comments}, {$task->latitude}-{$task->longitude}") ?></p>
                <span class="new-task__time"><?= WordHelper::getStringTimeAgo($task->creation_time) ?> назад</span>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="new-task__pagination">
        <ul class="new-task__pagination-list">
            <li class="pagination__item"><a href="#"></a></li>
            <li class="pagination__item pagination__item--current">
                <a>1</a></li>
            <li class="pagination__item"><a href="#">2</a></li>
            <li class="pagination__item"><a href="#">3</a></li>
            <li class="pagination__item"><a href="#"></a></li>
        </ul>
    </div>
</section>
<section class="search-task">
    <div class="search-task__wrapper">
        <?php

        $form = ActiveForm::begin([
            'id' => 'filter-form',
            'options' => ['class' => 'search-task__form'],
            'action' => [''],
            'method' => 'get'
        ]);

        ?>
        <fieldset class="search-task__categories">
            <legend>Категории</legend>

            <?php

            echo $form->field($model, 'categories', ['options' => ['class' => '']])
                ->checkboxList(Categories::find()->select(['name', 'id'])->indexBy('id')->column(), [
                    'item' => function ($index, $label, $name, $checked, $value) use ($model) {
                        if (!empty($model['categories']) && in_array($value, $model['categories'])) {
                            $checked = 'checked';
                        }
                        return '<input class="visually-hidden checkbox__input" id="categories_' . $value . '"
                         type="checkbox" name="' . $name . '" value="' . $value . '" ' . $checked . '>
                                        <label for="categories_' . $value . '">' . $label . '</label>';
                    },
                    'unselect' => null
                ])->label(false);

            ?>
        </fieldset>

        <fieldset class="search-task__categories">
            <legend>Дополнительно</legend>
            <?php

            echo $form->field($model, 'noResponse', [
                'template' => '{input}{label}',
                'options' => ['class' => ''],
            ])
                ->checkbox(['class' => 'visually-hidden checkbox__input'], false);

            echo $form->field($model, 'remoteWork', [
                'template' => '{input}{label}',
                'options' => ['class' => '']
            ])
                ->checkbox(['class' => 'visually-hidden checkbox__input'], false);

            ?>
        </fieldset>
        <?php

        echo $form->field($model, 'period', [
            'template' => '{label}{input}',
            'options' => ['class' => ''],
            'labelOptions' => ['class' => 'search-task__name']
        ])
            ->dropDownList([
                '1' => 'За день',
                '2' => 'За неделю',
                '3' => 'За месяц'
            ], [
                'class' => 'multiple-select input',
                'style' => 'width: 100%',
                'prompt' => 'Выберите период'
            ]);

        echo $form->field($model, 'search', [
            'template' => '{label}{input}',
            'options' => ['class' => ''],
            'labelOptions' => ['class' => 'search-task__name']
        ])
            ->input('search', [
                'class' => 'input-middle input',
                'style' => 'width: 100%'
            ]);

        echo Html::submitButton('Искать', ['class' => 'button']);
        ActiveForm::end()
        ?>
    </div>
</section>

<!--
<form class="search-task__form" name="test" method="post" action="#">
            <fieldset class="search-task__categories">
                <legend>Категории</legend>
                <input class="visually-hidden checkbox__input" id="1" type="checkbox" name="" value="" checked>
                <label for="1">Курьерские услуги </label>
                <input class="visually-hidden checkbox__input" id="2" type="checkbox" name="" value="" checked>
                <label for="2">Грузоперевозки </label>
                <input class="visually-hidden checkbox__input" id="3" type="checkbox" name="" value="">
                <label for="3">Переводы </label>
                <input class="visually-hidden checkbox__input" id="4" type="checkbox" name="" value="">
                <label for="4">Строительство и ремонт </label>
                <input class="visually-hidden checkbox__input" id="5" type="checkbox" name="" value="">
                <label for="5">Выгул животных </label>
            </fieldset>
            <fieldset class="search-task__categories">
                <legend>Дополнительно</legend>
                <input class="visually-hidden checkbox__input" id="6" type="checkbox" name="" value="">
                <label for="6">Без откликов</label>
                <input class="visually-hidden checkbox__input" id="7" type="checkbox" name="" value="" checked>
                <label for="7">Удаленная работа </label>
            </fieldset>
            <label class="search-task__name" for="8">Период</label>
            <select class="multiple-select input" id="8" size="1" name="time[]">
                <option value="day">За день</option>
                <option selected value="week">За неделю</option>
                <option value="month">За месяц</option>
            </select>
            <label class="search-task__name" for="9">Поиск по названию</label>
            <input class="input-middle input" id="9" type="search" name="q" placeholder="">
            <button class="button" type="submit">Искать</button>
        </form>
        -->
