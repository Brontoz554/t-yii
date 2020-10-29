<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $firstName
 * @property string $lastName
 * @property string $region
 * @property string $phone
 * @property string $email
 *
 * @property Cart[] $carts
 */
class SignUp extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'firstName', 'lastName', 'region', 'phone', 'email'], 'required', 'message' => 'Заполните поле'],
            ['username', 'unique', 'targetClass' => User::className(), 'message' => 'Этот логин уже занят'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password' => 'Пароль',
            'firstName' => 'Имя',
            'lastName' => 'Фамилия',
            'region' => 'Регион',
            'phone' => 'Номер телефона',
            'email' => 'Электронная почта',
        ];
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::className(), ['user_id' => 'id']);
    }
}
