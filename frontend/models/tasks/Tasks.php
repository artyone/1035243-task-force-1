<?php

namespace frontend\models\tasks;

use yii\db\ActiveRecord;
use frontend\models\Categories;
use frontend\models\Cities;
use frontend\models\users\Users;
use frontend\models\Files;
use frontend\models\tasks\actions\CancelAction;
use frontend\models\tasks\actions\RefuseAction;
use frontend\models\tasks\actions\CompleteAction;
use frontend\models\tasks\actions\AddResponseAction;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string|null $creation_time
 * @property string $name
 * @property int $category_id
 * @property int|null $city_id
 * @property int|null $latitude
 * @property int|null $longitude
 * @property string|null $address_comments
 * @property string|null $description
 * @property int|null $price
 * @property int $customer_id
 * @property int|null $executor_id
 * @property string|null $deadline_time
 * @property int $status
 *
 * @property Categories $category
 * @property Cities $city
 * @property Users $customer
 * @property Users $executor
 * @property TasksChat[] $taskChat
 * @property TasksFeedback[] $tasksFeedback
 * @property TasksFile[] $tasksFile
 * @property TasksResponse[] $tasksResponse
 */
class Tasks extends ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_EXECUTION = 2;
    const STATUS_CANCELED = 3;
    const STATUS_FAILED = 4;
    const STATUS_DONE = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creation_time', 'deadline_time'], 'safe'],
            [['name', 'category_id', 'customer_id'], 'required'],
            [
                [
                    'category_id',
                    'city_id',
                    'price',
                    'customer_id',
                    'executor_id',
                    'status'
                ],
                'integer'
            ],
            [
              [
                  'latitude',
                  'longitude'
              ],
                'double'
            ],
            [['name', 'address_comments', 'description'], 'string', 'max' => 500],
            [
                ['category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Categories::className(),
                'targetAttribute' => ['category_id' => 'id']
            ],
            [
                ['city_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Cities::className(),
                'targetAttribute' => ['city_id' => 'id']
            ],
            [
                ['customer_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Users::className(),
                'targetAttribute' => ['customer_id' => 'id']
            ],
            [
                ['executor_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Users::className(),
                'targetAttribute' => ['executor_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'creation_time' => 'Creation Time',
            'name' => 'Name',
            'category_id' => 'Category ID',
            'city_id' => 'City ID',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'address_comments' => 'Address Comments',
            'description' => 'Description',
            'price' => 'Price',
            'customer_id' => 'Customer ID',
            'executor_id' => 'Executor ID',
            'deadline_time' => 'Deadline Time',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Users::className(), ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(Users::className(), ['id' => 'executor_id']);
    }

    /**
     * Gets query for [[TasksChat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksChat()
    {
        return $this->hasMany(TasksChat::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TasksFeedback]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksFeedback()
    {
        return $this->hasOne(TasksFeedback::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TasksFile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksFile()
    {
        return $this->hasMany(Files::className(), ['id' => 'file_id'])
            ->viaTable('tasks_file', ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TasksResponse]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksResponse()
    {
        return $this->hasMany(TasksResponse::className(), ['task_id' => 'id']);
    }

    public function getLink(): string
    {
        return "/task/view/$this->id";
    }

    public function getTasksResponseByUser($user): array
    {
        return $this->getTasksResponse()->where(['executor_id' => $user->id])->all();
    }

    public function getAvailableActions($user): array
    {
        $result = [];
        if (AddResponseAction::verifyAction($this, $user)) {
            $result[AddResponseAction::getActionName()] = AddResponseAction::getActionDescription() ;
        }
        if (CancelAction::verifyAction($this, $user)) {
            $result[CancelAction::getActionName()] = CancelAction::getActionDescription();
        }
        if (RefuseAction::verifyAction($this, $user)) {
            $result[RefuseAction::getActionName()] = RefuseAction::getActionDescription();
        }
        if (CompleteAction::verifyAction($this, $user)) {
            $result[CompleteAction::getActionName()] = CompleteAction::getActionDescription();
        }
        return $result;
    }

    public function start(): int
    {

        return $this->status = self::STATUS_EXECUTION;
    }

    public function cancel(): int
    {
        return $this->status = self::STATUS_CANCELED;
    }

    public function refuse(): int
    {
        return $this->status = self::STATUS_FAILED;
    }

    public function complete(): int
    {
        return $this->status = self::STATUS_DONE;
    }
}
