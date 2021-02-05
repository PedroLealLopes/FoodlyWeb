<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $category;
    public $email;
    public $body;
    public $date;
    public $verifyCode;
    public $read;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // category, email, body are required
            [['category', 'email', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            ['date', 'date'],
            ['read', 'boolean'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
    }
}
