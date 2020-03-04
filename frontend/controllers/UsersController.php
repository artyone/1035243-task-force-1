<?php


namespace frontend\controllers;

use frontend\models\Users;
use frontend\models\Tasks;
use yii\db\Query;
use yii\web\Controller;
use frontend\models\UsersFilter;
use yii;


class UsersController extends Controller
{

    public function actionIndex()
    {

        $query = Users::find()
            ->orderBy(['creation_time' => SORT_DESC])
            ->joinWith('userCategories')
            ->where(['is not','categories.id', NULL]);

        $model = new UsersFilter();
        $model->load(Yii::$app->request->get());

        foreach ($model as $key => $data) {
            if ($data) {
                switch ($key) {
                    case 'categories':
                        $query->andWhere(['categories.id' => $data]);
                        break;
                    case 'free':
                        $query->joinWith('taskExecutor');
                        $query->andWhere(['or',['tasks.id' => NULL],['tasks.status' => Tasks::STATUS_DONE]]);
                        break;
                    case 'online':
                        $query->joinWith('userData');
                        $query->andWhere(['>', 'users_data.last_online_time', $model->getOnlineTime()]);
                        break;
                    case 'hasFeedback':
                        $query->joinWith('tasksFeedbackExecutor');
                        $query->andWhere(['is not','tasks_feedback.task_id', NULL]);
                        break;
                    case 'inFavorites':
                        //@todo разработать по созданию аккаунта
                        break;
                    case 'search':
                        $query->andWhere(['like','users.name',$data]);
                        break;
                    case 'sort':
                        $query->joinWith('userData');
                        $query->orderBy(["users_data.$data" => SORT_DESC]);
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