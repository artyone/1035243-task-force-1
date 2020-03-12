<?php


namespace frontend\models;

use yii\base\Model;

/**
 * Users filter form
 */
class UsersFilterForm extends Model
{
    /**
     * {@inheritdoc}
     */
    public $categories;
    public $free;
    public $online;
    public $hasFeedback;
    public $inFavorites;
    public $search;
    public $sort;

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'categories' => 'Категории',
            'free' => 'Сейчас свободен',
            'online' => 'Сейчас онлайн',
            'hasFeedback' => 'Есть отзывы',
            'inFavorites' => 'В избранном',
            'search' => 'Поиск по имени',
            'sort' => 'Сортировать по'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categories', 'free', 'online', 'hasFeedback', 'inFavorites', 'search', 'sort'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function formName()
    {
        return '';
    }

    /**
     * Вычисление крайней даты для нахождения статуса "онлайн" у пользователей
     *
     * @return string текущая дата минус 30 минут
     */
    private function getOnlineTime(): string
    {
        $date = new \DateTime();
        $date->sub(\DateInterval::createFromDateString('30 minutes'));
        $result = $date->format('Y-m-d H:i:s');
        return $result;
    }

    /**
     * Применение дополнительных фильтров к запросу
     *
     * @param ???
     * @return ???
     */
    //Прошу подсказать какой тут тип данных
    public function applyFilters($query)
    {

        if ($this->categories) {
            $query->andWhere(['categories.id' => $this->categories]);
        }
        if ($this->free) {
            $query->joinWith('tasksExecutor');
            $query->andWhere(['or', ['tasks.id' => null], ['tasks.status' => Tasks::STATUS_DONE]]);
            $query->groupBy('users.id');
        }
        if ($this->online) {
            $query->joinWith('userData');
            $query->andWhere(['>', 'users_data.last_online_time', $this->getOnlineTime()]);
        }
        if ($this->hasFeedback) {
            $query->joinWith('tasksFeedbackExecutor');
            $query->andWhere(['is not', 'tasks_feedback.executor_id', null]);
            $query->groupBy('users.id');
        }
        if ($this->inFavorites) {
            //@todo разработать по созданию аккаунта
        }
        if ($this->sort) {
            $query->joinWith('userData');
            $query->orderBy(["users_data.$this->sort" => SORT_DESC]);
        }

        return $query;
    }
}