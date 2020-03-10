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

        $formModel = new UsersFilter();
        if (Yii::$app->request->get()) {
            $formModel->load(Yii::$app->request->get());
        }

        if ($search = $formModel->search) {
            $query->andWhere(['like', 'users.name', $search]);
            $formModel = new UsersFilter();
            $formModel->search = $search;
        } else {
            $query = $formModel->applyFilters($query);
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
            'formModel' => $formModel,
            'pagination' => $pagination
        ]);
    }

    public function actionSort()
    {
        $query = Users::find()
            ->orderBy(['creation_time' => SORT_DESC])
            ->joinWith('userCategories')
            ->where(['is not', 'categories.id', null]);

        $formModel = new UsersFilter();
        if (Yii::$app->request->get()) {
            $formModel->load(Yii::$app->request->get());
        }

        $query = $formModel->applyFilters($query);

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
            'formModel' => $formModel,
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