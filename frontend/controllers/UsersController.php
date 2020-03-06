<?php


namespace frontend\controllers;

use frontend\models\Users;
use frontend\models\Tasks;
use yii\data\Pagination;
use yii\db\Query;
use yii\web\Controller;
use frontend\models\UsersFilter;
use yii;
use yii\web\HttpException;


class UsersController extends Controller
{

    public function actionIndex()
    {

        $query = Users::find()
            ->orderBy(['creation_time' => SORT_DESC])
            ->joinWith('userCategories')
            ->where(['is not', 'categories.id', null]);

        $model = new UsersFilter();
        $model->load(Yii::$app->request->get());

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);
        $query->offset($pagination->offset);
        $query->limit($pagination->limit);

        foreach ($model as $key => $data) {
            if ($data) {
                switch ($key) {
                    case 'categories':
                        $query->andWhere(['categories.id' => $data]);
                        break;
                    case 'free':
                        $query->joinWith('taskExecutor');
                        $query->andWhere(['or', ['tasks.id' => null], ['tasks.status' => Tasks::STATUS_DONE]]);
                        break;
                    case 'online':
                        $query->joinWith('userData');
                        $query->andWhere(['>', 'users_data.last_online_time', $model->getOnlineTime()]);
                        break;
                    case 'hasFeedback':
                        $query->joinWith('tasksFeedbackExecutor');
                        $query->andWhere(['is not', 'tasks_feedback.task_id', null]);
                        break;
                    case 'inFavorites':
                        //@todo разработать по созданию аккаунта
                        break;
                    case 'search':
                        $query->andWhere(['like', 'users.name', $data]);
                        break;
                }
            }
        }
        $users = $query
            ->all();

        return $this->render('index', [
            'users' => $users,
            'model' => $model,
            'pagination' => $pagination
        ]);
    }

    public function actionSort($sort)
    {
        $query = Users::find()
            ->orderBy(['creation_time' => SORT_DESC])
            ->joinWith('userCategories')
            ->where(['is not', 'categories.id', null]);

        $model = new UsersFilter();
        $model->load(Yii::$app->request->get());

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);
        $query->offset($pagination->offset);
        $query->limit($pagination->limit);

        if ($sort) {
            $query->joinWith('userData');
            $query->orderBy(["users_data.$sort" => SORT_DESC]);

        }
        $users = $query
            ->all();

        return $this->render('index', [
            'users' => $users,
            'model' => $model,
            'pagination' => $pagination
        ]);
    }

    public function actionView($id)
    {
        $user = Users::findOne($id);
        if (!$user) {
            throw new HttpException(404 ,'User not found');
        }
        return $this->render('view', [
            'user' => $user
        ]);
    }


}