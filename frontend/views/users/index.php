<?php

use yii\helpers\Html;
use frontend\helpers\WordHelper;
use yii\widgets\ActiveForm;
use frontend\models\Categories;

?>

<section class="user__search">
    <div class="user__search-link">
        <p>Сортировать по:</p>
        <ul class="user__search-list">
            <li class="user__search-item user__search-item--current">
                <a href="#" class="link-regular">Рейтингу</a>
            </li>
            <li class="user__search-item">
                <a href="#" class="link-regular">Числу заказов</a>
            </li>
            <li class="user__search-item">
                <a href="#" class="link-regular">Популярности</a>
            </li>
        </ul>
    </div>
    <?php foreach ($users as $user): ?>
        <?php if ($user->userCategories): ?>
            <div class="content-view__feedback-card user__search-wrapper">
                <div class="feedback-card__top">
                    <div class="user__search-icon">
                        <a href="#"><img src=".<?= $user->fileAvatar->link ?>" width="65" height="65"></a>
                        <span><?= WordHelper::getStringTasks(count($user->completedTasksExecutor)) ?></span>
                        <span><?= WordHelper::getStringFeedbacks(count($user->tasksFeedbackExecutor)) ?></span>
                    </div>
                    <div class="feedback-card__top--name user__search-card">
                        <p class="link-name"><a href="#" class="link-regular"><?= $user->name ?></a></p>
                        <?php foreach(range(1,5) as $value): ?>
                            <span <?= $value <= $user->rating ? '' : 'class="star-disabled"' ?>></span>
                        <?php endforeach; ?>
                        <b><?= $user->rating ?></b>
                        <p class="user__search-content"><?= $user->userData->about ?></p>
                    </div>
                    <span class="new-task__time">Был на сайте <?= WordHelper::getStringTimeAgo($user->userData->last_online_time) ?> назад</span>
                </div>
                <div class="link-specialization user__search-link--bottom">
                    <?php foreach ($user->userCategories as $userCategory): ?>
                        <a href="#" class="link-regular"><?= $userCategory->name ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
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
                ->checkboxList(Categories::find()->select(['name'])->indexBy('id')->column(), [
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

            echo $form->field($model, 'free', [
                'template' => '{input}{label}',
                'options' => ['class' => ''],
            ])
                ->checkbox(['class' => 'visually-hidden checkbox__input'], false);

            echo $form->field($model, 'online', [
                'template' => '{input}{label}',
                'options' => ['class' => '']
            ])
                ->checkbox(['class' => 'visually-hidden checkbox__input'], false);

            echo $form->field($model, 'hasFeedback', [
                'template' => '{input}{label}',
                'options' => ['class' => '']
            ])
                ->checkbox(['class' => 'visually-hidden checkbox__input'], false);

            echo $form->field($model, 'inFavorites', [
                'template' => '{input}{label}',
                'options' => ['class' => '']
            ])
                ->checkbox(['class' => 'visually-hidden checkbox__input'], false);

            ?>
        </fieldset>
        <?php

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

<!--<form class="search-task__form" name="users" method="post" action="#">
    <fieldset class="search-task__categories">
        <legend>Категории</legend>
        <input class="visually-hidden checkbox__input" id="101" type="checkbox" name="" value="" checked
               disabled>
        <label for="101">Курьерские услуги </label>
        <input class="visually-hidden checkbox__input" id="102" type="checkbox" name="" value="" checked>
        <label for="102">Грузоперевозки </label>
        <input class="visually-hidden checkbox__input" id="103" type="checkbox" name="" value="">
        <label for="103">Переводы </label>
        <input class="visually-hidden checkbox__input" id="104" type="checkbox" name="" value="">
        <label for="104">Строительство и ремонт </label>
        <input class="visually-hidden checkbox__input" id="105" type="checkbox" name="" value="">
        <label for="105">Выгул животных </label>
    </fieldset>
    <fieldset class="search-task__categories">
        <legend>Дополнительно</legend>
        <input class="visually-hidden checkbox__input" id="106" type="checkbox" name="" value="" disabled>
        <label for="106">Сейчас свободен</label>
        <input class="visually-hidden checkbox__input" id="107" type="checkbox" name="" value="" checked>
        <label for="107">Сейчас онлайн</label>
        <input class="visually-hidden checkbox__input" id="108" type="checkbox" name="" value="" checked>
        <label for="108">Есть отзывы</label>
        <input class="visually-hidden checkbox__input" id="109" type="checkbox" name="" value="" checked>
        <label for="109">В избранном</label>
    </fieldset>
    <label class="search-task__name" for="110">Поиск по имени</label>
    <input class="input-middle input" id="110" type="search" name="q" placeholder="">
    <button class="button" type="submit">Искать</button>
</form>-->
