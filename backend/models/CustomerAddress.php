<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "customer_address".
 *
 * @property integer $customer_address_id
 * @property integer $customer_id
 * @property string $address_one
 * @property string $address_two
 * @property string $country
 * @property string $state
 * @property string $city
 * @property string $zipcode
 * @property string $flag_address_type
 *
 * @property Customers $customer
 */
class CustomerAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id'], 'integer'],
            [['address_one', 'address_two'], 'string'],
            [['country', 'state', 'city', 'zipcode'], 'string', 'max' => 255],
            [['flag_address_type'], 'string', 'max' => 1],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customers::className(), 'targetAttribute' => ['customer_id' => 'customer_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customer_address_id' => Yii::t('yii', 'Customer Address ID'),
            'customer_id' => Yii::t('yii', 'Customer ID'),
            'address_one' => Yii::t('yii', 'Address One'),
            'address_two' => Yii::t('yii', 'Address Two'),
            'country' => Yii::t('yii', 'Country'),
            'state' => Yii::t('yii', 'State'),
            'city' => Yii::t('yii', 'City'),
            'zipcode' => Yii::t('yii', 'Zipcode'),
            'flag_address_type' => Yii::t('yii', 'Flag Address Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customers::className(), ['customer_id' => 'customer_id']);
    }
}
