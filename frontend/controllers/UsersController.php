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

        $usersFilterForm = new UsersFilter();
        if (Yii::$app->request->get()) {
            $usersFilterForm->load(Yii::$app->request->get());
        }

        if ($search = $usersFilterForm->search) {
            $query->andWhere(['like', 'users.name', $search]);
            $usersFilterForm = new UsersFilter();
            $usersFilterForm->search = $search;
        } else {
            $query = $usersFilterForm->applyFilters($query);
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
            'usersFilterForm' => $usersFilterForm,
            'pagination' => $pagination
        ]);
    }

    public function actionSort()
    {
        $query = Users::find()
            ->orderBy(['creation_time' => SORT_DESC])
            ->joinWith('userCategories')
            ->where(['is not', 'categories.id', null]);

        $usersFilterForm = new UsersFilter();
        if (Yii::$app->request->get()) {
            $usersFilterForm->load(Yii::$app->request->get());
        }

        $query = $usersFilterForm->applyFilters($query);

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
            'usersFilterForm' => $usersFilterForm,
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