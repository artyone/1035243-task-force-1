<?php

use frontend\helpers\WordHelper;

?>
<section class="content-view">
    <div class="user__card-wrapper">
        <div class="user__card">
            <img src="<?= $user->fileAvatar ? $user->fileAvatar->link : '/img/user-photo.png' ?>" width="120"
                 height="120" alt="Аватар пользователя">
            <div class="content-view__headline">
                <h1><?= $user->name ?></h1>
                <p><?= $user->userData->city->name ?>
                    , <?= WordHelper::getStringTimeAgo($user->userData->birthday) ?></p>
                <div class="profile-mini__name five-stars__rate">
                    <?php foreach (range(1, 5) as $value): ?>
                        <span <?= $value <= $user->userData->rating ? '' : 'class="star-disabled"' ?>></span>
                    <?php endforeach; ?>
                    <b><?= $user->userData->rating ?></b>
                </div>

                <b class="done-task">Выполнил <?= WordHelper::getStringTasks($user->userData->tasks_count) ?></b>
                <b class="done-review">Получил <?= WordHelper::getStringFeedbacks(count($user->tasksFeedbackExecutor)) ?></b>
            </div>
            <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                <span><?= WordHelper::getStringTimeAgo($user->userData->last_online_time) ?> назад</span>
                <a href="#"><b></b></a>
            </div>
        </div>
        <div class="content-view__description">
            <p><?= $user->userData->about ?></p>
        </div>
        <div class="user__card-general-information">
            <div class="user__card-info">
                <h3 class="content-view__h3">Специализации</h3>
                <div class="link-specialization">
                    <?php foreach ($user->userCategories as $userCategory): ?>
                        <a href="#" class="link-regular"><?= $userCategory->name ?></a>
                    <?php endforeach; ?>
                </div>
                <h3 class="content-view__h3">Контакты</h3>
                <div class="user__card-link">
                    <a class="user__card-link--tel link-regular" href="#"><?= $user->userData->phone ?></a>
                    <a class="user__card-link--email link-regular" href="#"><?= $user->email ?></a>
                    <a class="user__card-link--skype link-regular" href="#"><?= $user->userData->skype ?></a>
                </div>
            </div>
            <div class="user__card-photo">
                <h3 class="content-view__h3">Фото работ</h3>
                <?php foreach ($user->usersPhoto as $photo): ?>
                    <a href="<?= $photo->link ?>"><img src="<?= $photo->link ?>" width="85" height="86"
                                                       alt="Фото работы"></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="content-view__feedback">
        <h2>Отзывы<span>(<?= count($user->tasksFeedbackExecutor) ?>)</span></h2>
        <div class="content-view__feedback-wrapper reviews-wrapper">
            <?php foreach ($user->tasksFeedbackExecutor as $feedback): ?>
                <div class="feedback-card__reviews">
                    <p class="link-task link">Задание
                        <a href="/task/view/<?= $feedback->task->id ?>"
                           class="link-regular"><?= $feedback->task->name ?></a>
                    </p>
                    <div class="card__review">
                        <a href="#">
                            <img src="<?= $feedback->task->customer->fileAvatar ? $feedback->task->customer->fileAvatar->link : '' ?>"
                                 width="55" height="54">
                        </a>
                        <div class="feedback-card__reviews-content">
                            <p class="link-name link"><a href="/user/view/<?= $feedback->task->customer->id ?>"
                                                         class="link-regular">
                                    <?= $feedback->task->customer->name ?></a></p>
                            <p class="review-text">
                                <?= $feedback->description ?>
                            </p>
                        </div>
                        <div class="card__review-rate">
                            <p class="five-rate big-rate"><?= $feedback->rating ?><span></span></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>