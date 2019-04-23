<?php

/* @var $this yii\web\View */
/* @var $userResult app\models\UserAnswer */
/* @var $result app\models\Result */
/* @var $answer app\models\Answer */
/* @var $user app\models\User */
/* @var $dataTest array */
/* @var $count integer */
/* @var $answerDataId array */
/* @var $answerData array */


use app\models\Question;


$this->title = 'testing-system';
$this->params['breadcrumbs'][] = ['label' => 'Результаты', 'url' => ['index']];
?>
<div class="admin-userResults">

    <div class="body-content">
        <div class="admin-index">
            <div class="page-header">
                <h2 class="text-center">Результаты пользователя <?= $user->LOGIN . ' - ' . $result->RIGHT_ANSWERS .
                    '/' . $count?></h2>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <?php foreach ($dataTest as $questionId => $answers) {
                            $currentUserAnswers = $answerData[$questionId];
                            $quest = Question::findOne($questionId);
                            $rightQuestion = $result->getRightQuestion($quest, $currentUserAnswers);
                            ?>
                            <ul class="list-group">
                                <li class="list-group-item contentQuestion
                                <?= $rightQuestion ? "list-group-item-success" :
                                    "list-group-item-danger";
                                ?>">
                                    <?= $quest->CONTENT_QUESTION ?>
                                </li>
                                <?php foreach ($answers as $answer) {
                                    $selected = in_array($answer->ID_ANSWER, $currentUserAnswers) ?
                                        'checked' : '';
                                    $right = $answer->IS_RIGHT == 1;
                                    ?>
                                    <a href="#" class="list-group-item">
                                        <div class="form-check">
                                            <input type="checkbox" disabled class="form-check-input"
                                                   id="<?= $answer->ID_ANSWER ?>"<?= $selected ?>>
                                            <label class="form-check-label" for="<?= $answer->ID_ANSWER ?>">
                                                <?= $answer->CONTENT_ANSWER ?>
                                            </label>
                                            <?php if ($right && $selected) { ?>
                                                <span class ='glyphicon glyphicon-ok'></span>
                                            <?php } elseif (!$right && $selected) { ?>
                                                <span class ='glyphicon glyphicon-remove'></span>
                                            <?php } ?>
                                        </div>
                                    </a>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


