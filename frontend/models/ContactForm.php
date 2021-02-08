<?php

namespace frontend\models;

use common\models\Contact;
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
            ['category', 'in', 'range' => ['Help', 'General', 'Orders', 'Questions', 'Problems']],
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
     * @return bool whether the email was sent
     */
    public function sendEmail()
    {
        $contact = new Contact();
        $contact->category = $this->category;
        $contact->email = $this->email;
        $contact->body = $this->body;
        $contact->date = date('Y-m-d H:i:s');
        $contact->isRead = 0;
        if ($contact->validate()) {
            $contact->save();
            $contact->refresh();
            return true;
        } else {
            return false;
        }
    }
}
