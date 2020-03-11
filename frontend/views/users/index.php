<?php

use yii\helpers\Html;
use frontend\helpers\WordHelper;
use yii\widgets\ActiveForm;
use frontend\models\Categories;
use yii\widgets\LinkPager;
use yii\helpers\Url;

?>

<section class="user__search">
    <div class="user__search-link">
        <p>Сортировать по:</p>
        <ul class="user__search-list">
            <li class="user__search-item <?= $formModel->sort == 'rating' ? 'user__search-item--current' : '' ?>">
                <a href="<?= Url::to(['users/sort', 'sort' => 'rating']) ?>" class="link-regular">Рейтингу</a>
            </li>
            <li class="user__search-item <?= $formModel->sort == 'tasks_count' ? 'user__search-item--current' : '' ?>">
                <a href="<?= Url::to(['users/sort', 'sort' => 'tasks_count']) ?>" class="link-regular">Числу заказов</a>
            </li>
            <li class="user__search-item <?= $formModel->sort == 'popularity' ? 'user__search-item--current' : '' ?>">
                <a href="<?= Url::to(['users/sort', 'sort' => 'popularity']) ?>" class="link-regular">Популярности</a>
            </li>
        </ul>
    </div>
    <?php foreach ($users as $user): ?>
        <?php if ($user->userCategories): ?>
            <div class="content-view__feedback-card user__search-wrapper">
                <div class="feedback-card__top">
                    <div class="user__search-icon">
                        <a href="<?= Url::to(['users/view', 'id' => $user->id]) ?>">
                            <img src="<?= $user->fileAvatar->link ?>" width="65" height="65"></a>
                        <a href="/user/view/<?= $user->id ?>">
                            <img src="<?= $user->fileAvatar ? $user->fileAvatar->link : '/img/user-photo.png' ?>"
                                 width="65" height="65">
                        </a>
                        <span><?= WordHelper::getStringTasks($user->userData->tasks_count) ?></span>
                        <span><?= WordHelper::getStringFeedbacks(count($user->tasksFeedbackExecutor)) ?></span>
                    </div>
                    <div class="feedback-card__top--name user__search-card">
                        <p class="link-name"><a href="<?= Url::to(['users/view', 'id' => $user->id]) ?>"
                                                class="link-regular"><?= $user->name ?></a></p>
                        <?php foreach (range(1, 5) as $value): ?>
                            <span <?= $value <= $user->userData->rating ? '' : 'class="star-disabled"' ?>></span>
                        <?php endforeach; ?>
                        <b><?= $user->userData->rating ?></b>
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
    <div class="pagination">
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
            'id' => 'filter-form',
            'options' => ['class' => 'search-task__form'],
            'action' => ['/users'],
            'method' => 'get'
        ]) ?>

        <fieldset class="search-task__categories">
            <legend>Категории</legend>

            <?= $form->field($formModel, 'categories', ['options' => ['class' => '']])
                ->checkboxList(Categories::find()->select(['name'])->indexBy('id')->column(), [
                    'item' => function ($index, $label, $name, $checked, $value) use ($formModel) {
                        if (!empty($formModel['categories']) && in_array($value, $formModel['categories'])) {
                            $checked = 'checked';
                        }
                        return '<input class="visually-hidden checkbox__input" id="id_' . $value . '"
                         type="checkbox" name="' . $name . '" value="' . $value . '" ' . $checked . '>
                                        <label for="id_' . $value . '">' . $label . '</label>';
                    },
                    'unselect' => null
                ])->label(false) ?>
        </fieldset>
        <fieldset class="search-task__categories">
            <legend>Дополнительно</legend>
            <?= $form->field($formModel, 'free', [
                'template' => '{input}{label}',
                'options' => ['class' => ''],
            ])
                ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => false], false) ?>
            <?= $form->field($formModel, 'online', [
                'template' => '{input}{label}',
                'options' => ['class' => '']
            ])
                ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => false], false) ?>

            <?= $form->field($formModel, 'hasFeedback', [
                'template' => '{input}{label}',
                'options' => ['class' => '']
            ])
                ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => false], false) ?>
            <?= $form->field($formModel, 'inFavorites', [
                'template' => '{input}{label}',
                'options' => ['class' => '']
            ])
                ->checkbox(['class' => 'visually-hidden checkbox__input', 'uncheck' => false], false) ?>
        </fieldset>
        <?= $form->field($formModel, 'search', [
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