<?php

namespace app\controllers;

use app\models\Question;
use app\models\Answer;
use app\models\User;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

class QuestionController extends BaseController

{
    protected $accessLevel = User::ACCESS_LEVEL_EDIT_TEST;

    /**
     * Lists all Question models.
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $testId = $model->FID_TEST;
        $dataProvider = new ActiveDataProvider([
            'query' => Answer::find()->where(['FID_QUESTION' => $id])->orderBy('ID_ANSWER'),
        ]);
        return $this->render('view', [
            'model' => $model,
            'testId' => $testId,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Updates an existing Question/Answer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $questionModel = $this->findModel($id);
        $answerModel = new Answer();
        $dataProvider = new ActiveDataProvider([
            'query' => Answer::find()->where(['FID_QUESTION' => $questionModel->ID_QUESTION])->orderBy('ID_ANSWER'),
            'pagination' => ['pageSize' => 10]
        ]);
        if ($questionModel->load(Yii::$app->request->post())) $questionModel->save();
        if ($answerModel->load(Yii::$app->request->post())) $answerModel->save();
        return $this->render('update', [
            'questionModel' => $questionModel,
            'answerModel'  => $answerModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing Question model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['edit/update', 'id' => $model->FID_TEST]);
    }

    /**
     * Finds the Question model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Question the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Question::findOne($id)) !== null) {
            $model->CONTENT_QUESTION = Html::decode($model->CONTENT_QUESTION);
            return $model;
        }
        throw new NotFoundHttpException('Ой! Страницы не существует.');
    }

}