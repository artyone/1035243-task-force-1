<?php


namespace frontend\models;

use yii\base\Model;

class UsersFilter extends Model
{

    public $categories;
    public $free;
    public $online;
    public $hasFeedback;
    public $inFavorites;
    public $search;
    public $sort;

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

    public function rules()
    {
        return [
            [['categories', 'free','online', 'hasFeedback', 'inFavorites', 'search', 'sort'], 'safe'],
        ];
    }

    public function formName()
    {
        return '';
    }

    private function getOnlineTime()
    {
        $date = new \DateTime();
        $date->sub(\DateInterval::createFromDateString('30 minutes'));
        $result = $date->format('Y-m-d H:i:s');
        return $result;
    }

    public function applyFilters($query)
    {

        if ($this->categories) {
            $query->andWhere(['categories.id' => $this->categories]);
        }
        if ($this->free) {
            $query->joinWith('tasksExecutor');
            $query->andWhere(['or', ['tasks.id' => null], ['tasks.status' => Tasks::STATUS_DONE]]);
        }
        if ($this->online) {
            $query->joinWith('userData');
            $query->andWhere(['>', 'users_data.last_online_time', $this->getOnlineTime()]);
        }
        if ($this->hasFeedback) {
            $query->joinWith('tasksFeedbackExecutor');
            $query->andWhere(['is not', 'tasks_feedback.task_id', null]);
        }
        if ($this->inFavorites) {
            //@todo разработать по созданию аккаунта
        }

        return $query;
    }
}