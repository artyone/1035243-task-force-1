<?php

namespace frontend\models;

use yii\base\Model;

/**
 * Tasks filter form
 */
class TasksFilterForm extends Model
{
    /**
     * {@inheritdoc}
     */
    public $categories;
    public $noResponse;
    public $remoteWork;
    public $period;
    public $search;
    private $availablePeriod = [
        1 => '1 day',
        2 => '1 week',
        3 => '1 month',
        4 => '100 years'
    ];

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'categories' => 'Категории',
            'noResponse' => 'Без откликов',
            'remoteWork' => 'Удаленная работа',
            'period' => 'Период',
            'search' => 'Поиск',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categories', 'noResponse', 'remoteWork', 'period', 'search'], 'safe'],
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
     * Вычисление даты для отбора заданий
     *
     * @return string текущая дата минус заданный на форме период
     */
    private function getPeriodTime($period)
    {
        $date = new \DateTime();
        $date->sub(\DateInterval::createFromDateString($this->availablePeriod[$period]));
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
            $query->andWhere(['tasks.category_id' => $this->categories]);
        }
        if ($this->noResponse) {
            $query->joinWith('tasksResponse');
            $query->andWhere(['tasks_response.executor_id' => NULL]);
        }
        if ($this->remoteWork) {
            $query->andWhere(['tasks.city_id' => NULL]);
        }
        if ($this->period) {
            $query->andWhere(['>', 'tasks.creation_time', $this->getPeriodTime($this->period)]);
        }
        if ($this->search) {
            $query->andWhere(['like','tasks.name',$this->search]);
        }

        return $query;
    }
}