<?php

namespace app\controllers;

use Throwable;
use Yii;
use app\models\User;
use yii\helpers\Html;
use yii\web\Response;
use app\models\Answer;
use app\models\Question;
use yii\db\StaleObjectException;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class AnswerController extends BaseController
{
    protected $accessLevel = User::ACCESS_LEVEL_EDIT_TEST;

    /**
     * Lists all Answer models.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex($id)
    {
        $model = $this->findQuestionModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => Answer::find()->where(['FID_QUESTION' => $id]),
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'questId' => $id,
            'testId' => $model->FID_TEST
        ]);
    }

    /**
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findAnswerModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => Answer::find()->where(['ID_ANSWER' => $id]),
        ]);
        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @param $questId
     * @return string|Response
     */
    public function actionCreate($questId)
    {
        $model = new Answer();
        $model->FID_QUESTION = $questId;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['question/update', 'id' => $model->FID_QUESTION]);
        }
        return $this->render('create', [
            'model' => $model,
            'questId' => $questId
        ]);
    }

    /**
     * Updates an existing Answer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    { /** @var Answer $model */
        $model = $this->findAnswerModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => Answer::find()->where(['ID_ANSWER' => $model->ID_ANSWER]),
            'pagination' => ['pageSize' => 10],
        ]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['question/update', 'id' => $model->FID_QUESTION]);
        }
        return $this->render('update', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing Answer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionDelete($id)
    {
        $model = $this->findAnswerModel($id);
        $model->delete();
        return $this->redirect(['question/update', 'id' => $model->FID_QUESTION]);
    }

    /**
     * Finds the Question model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Question the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findQuestionModel($id)
    {
        if (($model = Question::findOne($id)) !== null) {
            $model->CONTENT_QUESTION = Html::decode($model->CONTENT_QUESTION);
            return $model;
        }
        throw new NotFoundHttpException('Ой! Страницы не существует.');
    }

    /**
     * Finds the Answer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Answer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findAnswerModel($id)
    {
        if (($model = Answer::findOne($id)) !== null) {
            $model->CONTENT_ANSWER = Html::decode($model->CONTENT_ANSWER);
            return $model;
        }

        throw new NotFoundHttpException('Ой! Страницы не существует.');
    }
}