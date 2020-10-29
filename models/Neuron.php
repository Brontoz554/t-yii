<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "neuron".
 *
 * @property int $id
 * @property int $amount
 * @property string $name_on_card
 * @property int $cart_number
 * @property string $expries
 * @property int $security_code
 */
class Neuron extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'neuron';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_on_card', 'cart_number', 'expries', 'security_code'], 'required', 'message' => 'Обязательное поле'],
            [['amount', 'cart_number', 'security_code'], 'integer'],
            [['name_on_card'], 'string', 'max' => 200],
            [['expries'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Amount',
            'name_on_card' => 'Имя на карте',
            'cart_number' => 'Номер карты',
            'expries' => 'Истекает',
            'security_code' => 'Код',
        ];
    }

    /**
     * @param $params
     * @param $algo
     * @param $secret
     * @return string
     */
    public static function getHmac($params, $algo, $secret)
    {
        $prepared_params = str_ireplace('%20', '+', json_encode($params, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        return hash_hmac($algo, $prepared_params, $secret);
    }

}
