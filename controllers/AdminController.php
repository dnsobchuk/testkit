<?php

namespace app\controllers;

use app\models\Test;
use app\models\User;
use app\models\UserSearch;
use app\models\UserTest;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * AdminController extends BaseController.
 *
 */
class AdminController extends BaseController
{
    public $layout = 'admin';
    protected $accessLevel = User::ACCESS_LEVEL_CRUD_USERS;

    /**
     * Displays adminPage and all User model.
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'dataProvider'       => $dataProvider,
            'searchModel'        => $searchModel
        ]);
    }

    /**
     * Displays a single Test model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new User();
        $model->scenario = User::SCENARIO_CREATE;
        $userTest = new UserTest();
        $tests = Test::find()->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $userTest->FID_USER = $model->ID_USER;
            $userTest->saveUserTest(Yii::$app->request->post('TestData'));
            return $this->redirect(['view', 'id' => $model->ID_USER]);
        }
        return $this->render('create', [
            'model' => $model,
            'tests' => $tests,
            'userTest' => $userTest
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $userTest = UserTest::findOne(['FID_USER' => $id]);
        $tests = Test::find()->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $userTest->saveUserTest(Yii::$app->request->post('TestData'));
            return $this->redirect(['view', 'id' => $model->ID_USER]);
        }
        return $this->render('update', [
            'model' => $model,
            'tests' => $tests,
            'userTest' => $userTest
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Test model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Ой! Страницы не существует.');
    }
}
