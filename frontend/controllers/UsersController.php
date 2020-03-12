<?php


namespace frontend\controllers;

use frontend\models\users\Users;
use yii\data\Pagination;
use yii\web\Controller;
use frontend\models\users\UsersFilterForm;
use yii;
use yii\web\HttpException;

/**
 * Users controller
 */
class UsersController extends Controller
{
    /**
     * Отображение общего списка исполнителей с учетом фильтров, если они заданы.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Users::find()
            ->orderBy(['creation_time' => SORT_DESC])
            ->joinWith('userCategories')
            ->where(['is not', 'categories.id', null]);

        $usersFilterForm = new UsersFilterForm();
        if (Yii::$app->request->isGet) {
            $usersFilterForm->load(Yii::$app->request->get());
        }

        if ($search = $usersFilterForm->search) {
            $query->andWhere(['like', 'users.name', $search]);
            $usersFilterForm = new UsersFilterForm();
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

    /**
     * Отображение общего списка исполнителей с учетом сортировки.
     *
     * @return mixed
     */
    public function actionSort()
    {
        $query = Users::find()
            ->orderBy(['creation_time' => SORT_DESC])
            ->joinWith('userCategories')
            ->where(['is not', 'categories.id', null]);

        $usersFilterForm = new UsersFilterForm();
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

    /**
     * Отображение одного исполнителя.
     *
     * @return mixed
     */
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