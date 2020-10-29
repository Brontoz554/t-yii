<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $tittle
 * @property string $subject
 * @property int $price
 * @property string $img
 *
 * @property Cart[] $carts
 */
class Product extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tittle', 'subject', 'price'], 'required'],
            [['price'], 'integer', 'max' => 1000000],
            [['tittle', 'subject'], 'string', 'max' => 255],
            [['img'], 'file', 'extensions' => 'png, jpg, jpeg']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tittle' => 'Наименование',
            'subject' => 'Описание',
            'price' => 'Цена',
            'img' => 'Изображение',
        ];
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::className(), ['product_id' => 'id']);
    }

    public function upload()
    {
        $file = 'uploads/' . $this->img->baseName . date('H-m-s') . '.' . $this->img->extension;
        if ($this->validate()) {
            $this->img->saveAs($file);
            return $file;
        } else {
            return false;
        }
    }
}
