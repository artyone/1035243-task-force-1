<?php


namespace frontend\controllers;

use frontend\models\Users;
use yii\db\Query;
use yii\web\Controller;
use frontend\models\UsersFilter;


class UsersController extends Controller
{

    public function actionIndex()
    {

        $query = Users::find()
            ->orderBy(['creation_time' => SORT_DESC])
            ->joinWith('userCategories')
            ->where(['is not','categories.id', NULL]);

        $model = new UsersFilter();
        $model->load($_GET);

        foreach ($model as $key => $data) {
            if ($data) {
                switch ($key) {
                    case 'categories':
                        $query->andWhere(['categories.id' => $data]);
                        break;
                    case 'free':
                        $query->joinWith('taskExecutor');
                        $query->andWhere(['tasks.id' => NULL]);
                        break;
                    case 'online':
                        $query->joinWith('userData');
                        $query->andWhere(['>', 'users_data.last_online_time', $model->getOnlineTime()]);
                        break;

                    case 'hasFeedback':
                        $query->joinWith('taskCompletedFeedbackExecutor');
                        $query->andWhere(['is not','tasks_completed_feedback.task_id', NULL]);
                        break;

                    case 'inFavorites':
                        //@todo разработать по созданию аккаунта
                        break;
                }
            }
        }

        $users = $query
            ->all();

        return $this->render('index', [
            'users' => $users,
            'model' => $model
        ]);
    }

}