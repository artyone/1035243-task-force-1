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

        $filterModel = new UsersFilter();
        if (Yii::$app->request->get()) {
            $filterModel->load(Yii::$app->request->get());
        }

        if ($search = $filterModel->search) {
            $query->andWhere(['like', 'users.name', $search]);
            $filterModel = new UsersFilter();
            $filterModel->search = $search;
        } else {
            $query = $filterModel->applyFilters($query);
        }

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);
        $query->offset($pagination->offset)
            ->limit($pagination->limit);

        $users = $query
            ->all();

        return $this->render('index', [
            'users' => $users,
            'filterModel' => $filterModel,
            'pagination' => $pagination
        ]);
    }

    public function actionSort($sort)
    {
        $query = Users::find()
            ->orderBy(['creation_time' => SORT_DESC])
            ->joinWith('userCategories')
            ->where(['is not', 'categories.id', null]);

        $filterModel = new UsersFilter();
        if (Yii::$app->request->get()) {
            $filterModel->load(Yii::$app->request->get());
        }

        if ($sort) {
            $query->joinWith('userData');
            $query->orderBy(["users_data.$sort" => SORT_DESC]);
        }

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);
        $query->offset($pagination->offset);
        $query->limit($pagination->limit);

        $users = $query
            ->all();

        return $this->render('index', [
            'users' => $users,
            'filterModel' => $filterModel,
            'pagination' => $pagination
        ]);
    }

    public function actionView($id)
    {
        $user = Users::findOne($id);
        if (!$user) {
            throw new HttpException(404, 'User not found');
        }
        return $this->render('view', [
            'user' => $user
        ]);
    }


}