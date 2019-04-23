<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "USERS".
 *
 * @property int $ID_USER _autoIncremented
 * @property string $LOGIN Логин
 * @property string $PASSWORD Пароль
 * @property string $EMAIL email
 * @property string $PHONE Номер телефона
 * @property integer $ACCESS_LEVEL Уровень доступа
 * @property string $EXPIRES_DATE_TIME время действия учетной записи
 * @property array $available_level массив уровней доступа
 */

class User extends ActiveRecord implements IdentityInterface
{
    const ACCESS_LEVEL_RESULT = 1;
    const ACCESS_LEVEL_EDIT_TEST = 2;
    const ACCESS_LEVEL_FULL_RESULT = 4;
    const ACCESS_LEVEL_CRUD_USERS = 8;

    const SCENARIO_CREATE = 'create';

    public $available_level = [
        self::ACCESS_LEVEL_RESULT          => 'Просмотр результатов',
        self::ACCESS_LEVEL_EDIT_TEST       => 'Редактирование тестов',
        self::ACCESS_LEVEL_FULL_RESULT     => 'Детальный просмотр результатов',
        self::ACCESS_LEVEL_CRUD_USERS      => 'Управление пользователями'
    ];

    public $passwordRepeat;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LOGIN', 'EMAIL', 'PHONE', 'accessRights'], 'required'],
            ['dateTime', 'safe'],
            [['PASSWORD', 'passwordRepeat'], 'required', 'on'=> self::SCENARIO_CREATE],
            [['passwordRepeat'], 'compare', 'compareAttribute'=>'PASSWORD',
                'message'=>"Пароли отличаются", 'on'=> self::SCENARIO_CREATE],
            [['ID_USER'], 'integer'],
            [['LOGIN', 'PASSWORD', 'passwordRepeat'], 'string', 'max' => 60],
            [['EMAIL'], 'email', 'message'=>"email имеет неверный формат"],
            [['PHONE'], 'match', 'pattern' => '/^[0-9]{10}$/', 'message'=>"Телефон должен состоять из 10 цифр"]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID_USER' => 'Id  User',
            'LOGIN' => 'Логин',
            'PASSWORD' => 'Пароль',
            'EMAIL' => 'Email',
            'PHONE' => 'Телефон',
            'ACCESS_LEVEL' => 'Права',
            'accessRights' => 'Права доступа',
            'passwordRepeat' => 'Подтверждение пароля',
            'dateTime' => 'Время действия',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'USERS';
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getTests()
    {
        return $this->hasMany(Test::class, ['ID_TEST' => 'FID_TEST'])->viaTable('USER_TESTS',
            ['FID_USER' => 'ID_USER']);
    }

    /**
     * @return ActiveQuery
     */
    public function getResults()
    {
        return $this->hasMany(Result::class, ['FID_USER' => 'ID_USER']);
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws Exception
     */
    public function beforeSave($insert)
    {
        if($this->isNewRecord){
            $this->passwordRepeat = $this->PASSWORD = Yii::$app->getSecurity()->generatePasswordHash($this->PASSWORD);
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return bool
     */
    public function getTimeOver()
    {
        return $this->EXPIRES_DATE_TIME < strtotime("now");
    }

    /**
     * @param $access
     * @return int
     */
    public function can($access)
    {
        return $this->ACCESS_LEVEL & $access;
    }

    /**
     * @return false|string
     */
    public function getDateTime()
    {
        if($this->isNewRecord) return  date('Y-m-d H:i', strtotime("+1 day"));
        return date('Y-m-d H:i', $this->EXPIRES_DATE_TIME);
    }

    /**
     * @param $value
     * @return false|int
     */
    public function setDateTime($value){
        return $this->EXPIRES_DATE_TIME = strtotime($value);
    }

    /**
     * @return array
     */
    public function getAccessRights()
    {
        return $this->getDataForAccess($this->available_level, $this->ACCESS_LEVEL);
    }

    /**
     * @param $value
     */
    public function setAccessRights($value)
    {
        $result = $this->setDataForAccess($value);
        $this->ACCESS_LEVEL = $result;
    }

    /**
     * @param $modelLevel
     * @param $modelAccess
     * @return array
     */
    public function getDataForAccess($modelLevel, $modelAccess)
    {
        $result = [];
        $accessLevel = array_keys($modelLevel);
        foreach ($accessLevel as $level){
            if($level & $modelAccess){
                $result[] = $level;
            }
        }
        return $result;
    }

    /**
     * @param $value
     * @return int
     */
    public function setDataForAccess($value)
    {
        $result = 0;
        foreach ($value as $item){
            $result += (int)$item;
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->ID_USER;
    }

    /**
     * @param $username
     * @return array|ActiveRecord|null
     */
    public static function findByUsername($username){
        return static::find()->where(['LOGIN' => $username])->orWhere(['EMAIL' => $username])->one();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->PASSWORD);
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * @return int|string
     */
    public function getAuthKey()
    {
        return $this->ID_USER;
    }

    /**
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return true;
    }

    /**
     * @param int|string $id
     * @return User|IdentityInterface|null
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

}
