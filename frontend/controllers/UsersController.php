<?php


namespace frontend\controllers;

use frontend\models\users\Users;
use frontend\service\UserService;
use yii\data\Pagination;
use frontend\models\users\UsersFilterForm;
use yii;
use yii\web\HttpException;

/**
 * Users controller
 */
class UsersController extends SecuredController
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
        $usersFilterForm->load(Yii::$app->request->get());

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
            ->groupBy('users.id')
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
        $usersFilterForm->load(Yii::$app->request->get());

        $query = $usersFilterForm->applyFilters($query);

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);
        $query->offset($pagination->offset);
        $query->limit($pagination->limit);

        $users = $query
            ->groupBy('users.id')
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
            throw new HttpException(404, 'Пользователь не найден');
        }
        if (!$user->isExecutor()) {
            throw new HttpException(404, 'Пользователь не исполнитель');
        }

        if (Yii::$app->user->getId() != $id) {
            $user->userData->addPopularity();
        }

        return $this->render('view', [
            'user' => $user
        ]);
    }

    public function actionFavorite($id)
    {
        $user = Yii::$app->user->identity;
        $favoriteUser = Users::findOne($id);

        if (!$favoriteUser) {
            throw new HttpException(404, 'Пользователь не найден');
        }

        if ($favorite = $user->getUserFavorite($favoriteUser)) {
            if (!(new UserService)->removeFavorite($favorite)) {
                return $this->redirect('/users');
            }
        } else {
            if (!(new UserService)->addFavorite($user, $favoriteUser)) {
                return $this->redirect('/users');
            }
        }

        return $this->redirect($favoriteUser->link);
    }




}