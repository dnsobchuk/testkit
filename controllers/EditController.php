<?php

namespace app\controllers;

use app\models\Question;
use app\models\TestSearch;
use app\models\User;
use Throwable;
use Yii;
use app\models\Test;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

class EditController extends BaseController
{
    protected $accessLevel = User::ACCESS_LEVEL_EDIT_TEST;

    /**
     * Lists all Test models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestSearch();
        $model = new Test;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->ID_TEST]);
        }
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
            'model'        => $model
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
        $dataProvider = new ActiveDataProvider([
            'query' => Question::find()->where(['FID_TEST' => $id])->orderBy('ID_QUESTION'),
        ]);
        return $this->render('view', [
            'model' => $model, 'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new Test model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Test();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID_TEST]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Test model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $testModel = $this->findModel($id);
        $questModel = new Question();
        $dataProvider = new ActiveDataProvider([
            'query' => Question::find()->where(['FID_TEST' => $id])->orderBy('ID_QUESTION'),
            'pagination' => ['pageSize' => 10],
        ]);
        if ($testModel->load(Yii::$app->request->post())) $testModel->save();
        if ($questModel->load(Yii::$app->request->post())) $questModel->save();
        return $this->render('update', [
            'testModel'    => $testModel,
            'questModel'   => $questModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing Test model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
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
     * @return Test the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Test::findOne($id)) !== null) {
            $model->TITLE_TEST = Html::decode($model->TITLE_TEST);
            return $model;
        }
        throw new NotFoundHttpException('Ой! Страницы не существует.');
    }
}