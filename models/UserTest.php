<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\db\Exception;
use yii\db\Expression;
use yii\db\Query;

/**
 * This is the model class for table "USER_TESTS".
 *
 * @property int $FID_USER ВК на пользователя
 * @property int $FID_TEST ВК на тест
 */
class UserTest extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'USER_TESTS';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['FID_USER', 'FID_TEST'], 'required'],
            [['FID_USER', 'FID_TEST'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'FID_USER' => 'Fid  User',
            'FID_TEST' => 'Fid  Test',
            'TestData' => 'Доступные тесты'
        ];
    }

    /**
     * @param $data
     * @return bool
     * @throws Exception
     */
    public function saveUserTest($data)
    {
        if($data){
            $connection = new Connection(Yii::$app->db);
            $connection->createCommand()->delete('USER_TESTS', ['FID_USER' => $this->FID_USER])->execute();
            foreach ($data as $test){
                $userTest = new UserTest();
                $userTest->FID_USER = $this->FID_USER;
                $userTest->FID_TEST = $test;
                $userTest->save();
            }
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getTestData()
    {
        if($this->isNewRecord) return [];
        $dataId =[];
        $data =  (new Query())
            ->select(['ID_TEST', 'TITLE_TEST'])
            ->from('TESTS')
            ->leftJoin('USER_TESTS', ['FID_TEST' => new Expression('ID_TEST')])
            ->leftJoin('USERS', ['FID_USER' => new Expression('ID_USER')])
            ->where(['ID_USER' => $this->FID_USER])
            ->all();
        foreach ($data as $value) {
            $dataId[] = $value['ID_TEST'];
        }
        return $dataId;
    }
}
