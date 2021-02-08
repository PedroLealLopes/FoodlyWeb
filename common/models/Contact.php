<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property int $contactId
 * @property string $category
 * @property string $email
 * @property string $body
 * @property int $isRead
 * @property string $date
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category', 'email', 'body', 'date'], 'required'],
            [['category', 'body'], 'string'],
            [['isRead'], 'integer'],
            [['date'], 'safe'],
            [['email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'contactId' => 'Contact ID',
            'category' => 'Category',
            'email' => 'Email',
            'body' => 'Body',
            'isRead' => 'Is Read',
            'date' => 'Date',
        ];
    }
}
