<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Profiles;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $fullname;
    public $age;
    public $alergias;
    public $telefone;
    public $morada;
    public $genero;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            
            [['fullname', 'age'], 'required'],
            [['age'], 'integer'],
            [['alergias', 'telefone', 'morada'], 'string'],
            ['genero', 'in', 'range' => ['M', 'F']],
            [['fullname'], 'string', 'max' => 45],

            ['age', 'integer', 'min' => '16'], 
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'User ID',
            'fullname' => 'Fullname',
            'image' => 'Image',
            'age' => 'Age',
            'alergias' => 'Alergies',
            'genero' => 'Gender',
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $profile = new Profiles();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        // $user->generateEmailVerificationToken();
        //Comentei para não termos que nos preocupar com email verifications
        //O status fica a 10 que significa que já confirmou o mail.

        $user->status = 10;
        $user->save(false);

        $profile->userId = $user->getId();
        $profile->alergias = $this->alergias;
        $profile->telefone = $this->telefone;
        $profile->morada = $this->morada;
        $profile->genero = $this->genero;
        $profile->fullname = $this->fullname;
        $profile->age = $this->age;

        $profile->save(false);

        $auth = \Yii::$app->authManager;
        $authorRole = $auth->getRole('user');
        $auth->assign($authorRole, $user->getId());

        return $user->save();
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
