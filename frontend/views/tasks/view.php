<?php

use frontend\helpers\WordHelper;
use frontend\models\tasks\actions\StartAction;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use frontend\models\tasks\Tasks;
use frontend\models\tasks\TasksResponse;

/**
 * @var Tasks $task
 * @array TasksResponse $responses
 * @var $availableActions
 * @var \frontend\models\users\Users $user
 * @var \frontend\models\tasks\TasksResponseForm $taskResponseForm
 * @var \frontend\models\tasks\TasksCompleteForm $taskCompleteForm
 */

?>
<section class="content-view">
    <div class="content-view__card">
        <div class="content-view__card-wrapper">
            <div class="content-view__header">
                <div class="content-view__headline">
                    <h1><?= $task->name ?></h1>
                    <span>
                        Размещено в категории
                        <?= Html::a($task->category->name, ['#'], ['class' => 'link-regular']) ?>
                        <?= WordHelper::getStringTimeAgo($task->creation_time) ?> назад
                    </span>
                </div>
                <b class="new-task__price new-task__price--<?= $task->category->icon ?> content-view-price"><?= $task->price ? $task->price . '<b> ₽</b>' : '' ?></b>
                <div class="new-task__icon new-task__icon--<?= $task->category->icon ?> content-view-icon"></div>
            </div>
            <div class="content-view__description">
                <h3 class="content-view__h3">Общее описание</h3>
                <p><?= $task->description ?></p>
            </div>
            <div class="content-view__attach">
                <h3 class="content-view__h3">Вложения</h3>
                <?php foreach ($task->tasksFile as $file): ?>
                    <?= Html::a(pathinfo($file->link, PATHINFO_FILENAME), [$file->link], ['download' => '']) ?>
                <?php endforeach; ?>
            </div>
            <div class="content-view__location">
                <h3 class="content-view__h3">Расположение</h3>
                <div class="content-view__location-wrapper">
                    <div class="content-view__map">
                        <a href="#"><img src="/img/map.jpg" width="361" height="292"
                                         alt="Москва, Новый арбат, 23 к. 1"></a>
                    </div>
                    <div class="content-view__address">
                        <span class="address__town"><?= $task->city_id ? $task->city->name : '' ?></span><br>
                        <span><?= $task->longitude ?>-<?= $task->latitude ?></span>
                        <p><?= $task->address_comments ?></p>
                    </div>
                </div>
            </div>
        </div>
        <? if ($availableActions): ?>
            <div class="content-view__action-buttons">
                <?php foreach ($availableActions as $action => $description): ?>
                    <?= Html::button($description, [
                        'class' => "button button__big-color $action-button open-modal",
                        'type' => 'button',
                        'data-for' => "$action-form"
                    ]); ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php if (!empty($responses)): ?>
        <div class="content-view__feedback">
            <h2>Отклики <span>(<?= count($responses) ?>)</span></h2>
            <div class="content-view__feedback-wrapper">
                <?php foreach ($responses as $response): ?>
                    <div class="content-view__feedback-card">
                        <div class="feedback-card__top">
                            <a href="<?= Url::to(['users/view', 'id' => $response->executor_id]) ?>">
                                <img src="<?= $response->executor->fileAvatar ? $response->executor->fileAvatar->link : '/img/user-photo.png' ?>"
                                     width="55" height="55" alt="Аватар исполнителя"></a>
                            <div class="feedback-card__top--name">
                                <p>
                                    <?= Html::a($response->executor->name,
                                        ['users/view', 'id' => $response->executor_id], ['class' => 'link-regular']) ?>
                                </p>
                                <?php foreach (range(1, 5) as $value): ?>
                                    <span <?= $value <= $response->executor->userData->rating ? '' : 'class="star-disabled"' ?>></span>
                                <?php endforeach; ?>
                                <b><?= $response->executor->userData->rating ?></b>
                            </div>
                            <span class="new-task__time"><?= WordHelper::getStringTimeAgo($response->creation_time) ?> назад</span>
                        </div>
                        <div class="feedback-card__content">
                            <p><?= $response->description ?></p>
                            <?= $response->price ? "<span>$response->price ₽</span>" : '' ?>
                        </div>
                        <?php if (StartAction::verifyAction($task, $user)): ?>
                            <div class="feedback-card__actions">
                                <?= Html::a('Подтвердить',
                                    ['tasks/response', 'id' => $response->id, 'status' => 'accept'],
                                    ['class' => 'button__small-color request-button button', 'type' => 'button']) ?>
                                <?= Html::a('Отказать',
                                    ['tasks/response', 'id' => $response->id, 'status' => 'decline'],
                                    ['class' => 'button__small-color refusal-button button', 'type' => 'button']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>
<section class="connect-desk">
    <?php if ($user->isExecutor()): ?>
        <div class="connect-desk__profile-mini">
            <div class="profile-mini__wrapper">
                <h3>Заказчик</h3>
                <div class="profile-mini__top" >
                    <img src="<?= $task->customer->fileAvatar ? $task->customer->fileAvatar->link : '/img/user-photo.png' ?>"
                         width="62" height="62" alt="Аватар заказчика">
                    <div class="profile-mini__name five-stars__rate">
                        <p><?= $task->customer->name ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($user->isAuthor($task) && $task->executor_id): ?>
        <div class="connect-desk__profile-mini">
            <div class="profile-mini__wrapper">
                <h3>Исполнитель</h3>
                <div class="profile-mini__top">
                    <img src="<?= $task->executor->fileAvatar ? $task->executor->fileAvatar->link : '/img/user-photo.png' ?>"
                         width="62" height="62" alt="Аватар заказчика">
                    <div class="profile-mini__name five-stars__rate">
                        <p><?= $task->executor->name ?></p>
                    </div>
                </div>
                <p class="info-customer">
                    <span><?= WordHelper::getStringTasks(count($task->customer->tasksCustomer)) ?></span>
                    <span class="last-"><?= WordHelper::getStringTimeAgo($task->customer->creation_time) ?> на сайте</span>
                </p>
                <?= Html::a('Смотреть профиль', ['users/view', 'id' => $task->customer->id],
                    ['class' => 'link-regular']) ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (($user->isAuthor($task) || $user->isContractor($task)) && $task->executor_id): ?>
        <div class="connect-desk__chat">
            <h3>Переписка</h3>
            <div class="chat__overflow">
                <div class="chat__message chat__message--out">
                    <p class="chat__message-time">10.05.2019, 14:56</p>
                    <p class="chat__message-text">Привет. Во сколько сможешь
                        приступить к работе?</p>
                </div>
                <div class="chat__message chat__message--in">
                    <p class="chat__message-time">10.05.2019, 14:57</p>
                    <p class="chat__message-text">На задание
                        выделены всего сутки, так что через час</p>
                </div>
                <div class="chat__message chat__message--out">
                    <p class="chat__message-time">10.05.2019, 14:57</p>
                    <p class="chat__message-text">Хорошо. Думаю, мы справимся</p>
                </div>
            </div>
            <p class="chat__your-message">Ваше сообщение</p>
            <form class="chat__form">
            <textarea class="input textarea textarea-chat" rows="2" name="message-text"
                      placeholder="Текст сообщения"></textarea>
                <button class="button chat__button" type="submit">Отправить</button>
            </form>
        </div>
    <?php endif; ?>
</section>
<section class="modal response-form form-modal" id="response-form">
    <h2>Отклик на задание</h2>

    <?php $form = ActiveForm::begin([
        'id' => 'add-response-form',
        'options' => ['class' => ''],
        'action' => [$task->getLink()],
        'method' => 'post'
    ]) ?>

    <?= $form->field($taskResponseForm, 'price', [
        'options' => ['class' => ''],
        'labelOptions' => ['class' => 'form-modal-description', 'style' => ['display' => 'inline-block']],
        'template' => '{label}<br>{input}<br>{error}'
    ])
        ->textinput([
            'class' => 'response-form-payment input input-middle input-money',
        ])
        ->error(['tag' => 'span']) ?>

    <?= $form->field($taskResponseForm, 'descriptionResponse', [
        'options' => ['class' => ''],
        'labelOptions' => ['class' => 'form-modal-description', 'style' => ['display' => 'inline-block']],
        'template' => '{label}<br>{input}<br>{error}'
    ])
        ->textarea([
            'class' => 'input textarea',
            'style' => 'width: 90%',
            'rows' => '4'
        ])
        ->error(['tag' => 'span']) ?>


    <?= Html::submitButton('Отправить',
        ['class' => 'button modal-button', 'name' => 'send-button']) ?>

    <?php ActiveForm::end(); ?>

    <?= Html::button('', ['class' => 'form-modal-close', 'type' => 'button']) ?>

</section>


<section class="modal form-modal refusal-form" id="cancel-form">
    <h2>Отмена задания</h2>
    <p>
        Вы собираетесь отменить задание.
        Вы уверены?
    </p>
    <?= Html::button('Отмена', ['class' => 'button__form-modal button', 'id' => 'close-modal', 'type' => 'button']) ?>
    <form action="/task/cancel/<?= $task->id ?>">
        <?= Html::button('Отменить задание',
            ['class' => 'button__form-modal cancel-button button', 'type' => 'submit']) ?>
    </form>
    <?= Html::button('Закрыть', ['class' => 'form-modal-close', 'type' => 'button']) ?>
</section>


<section class="modal form-modal refusal-form" id="refuse-form">
    <h2>Отказ от задания</h2>
    <p>
        Вы собираетесь отказаться от выполнения задания.
        Это действие приведёт к снижению вашего рейтинга.
        Вы уверены?
    </p>
    <?= Html::button('Отмена',
        ['class' => 'button__form-modal button', 'id' => 'close-modal', 'type' => 'button']) ?>
    <form action="/task/refuse/<?= $task->id ?>">
        <?= Html::button('Отказаться', ['class' => 'button__form-modal refusal-button button', 'type' => 'submit']) ?>
    </form>
    <?= Html::button('Закрыть', ['class' => 'form-modal-close', 'type' => 'button']) ?>
</section>

<section class="modal completion-form form-modal" id="complete-form">
    <h2>Завершение задания</h2>
    <p class="form-modal-description">Задание выполнено?</p>
    <?php $form = ActiveForm::begin([
        'options' => ['class' => ''],
        'action' => [$task->link],
        'method' => 'post'
    ]) ?>

    <?= $form->field($taskCompleteForm, 'isComplete')
        ->radioList([
            'yes' => 'Да',
            'difficult' => 'Возникли проблемы'
        ], [
            'item' => function ($index, $label, $name, $checked, $value) {
                return "<input class=\"visually-hidden completion-input completion-input--$value\" 
                        type=\"radio\" id=\"completion-radio--$value\" name=\"$name\" value=\"$value\">
                        <label class=\"completion-label completion-label--$value\" style=\"display:inline-block\"
                        for=\"completion-radio--$value\">$label</label>";
            }
        ])
        ->label(false) ?>

    <?= $form->field($taskCompleteForm, 'descriptionComplete', [
        'options' => ['class' => ''],
        'labelOptions' => ['class' => 'form-modal-description', 'style' => ['display' => 'inline-block']]
    ])
        ->textarea([
            'class' => 'input textarea',
            'style' => 'width: 90%',
            'rows' => '4',
            'placeholder' => 'Place your text'
        ])
        ->error(['tag' => 'span']) ?>

    <p class="form-modal-description">
        Оценка
    </p>
    <div class="feedback-card__top--name completion-form-star">
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
        <span class="star-disabled"></span>
    </div>

    <?= $form->field($taskCompleteForm, 'rating', [
        'options' => ['class' => ''],
        'template' => '{input}'
    ])
        ->textinput([
            'type' => 'hidden',
            'name' => 'rating',
            'id' => 'rating'
        ]) ?>
    <?= Html::submitButton('Отправить',
        ['class' => 'button modal-button', 'type' => 'submit']) ?>

    <?php ActiveForm::end(); ?>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>


<div class="overlay"></div>