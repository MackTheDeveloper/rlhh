<?php

namespace backend\models;

use Yii;
use yii\helpers\Html;
/**
 * This is the model class for table "customers".
 *
 * @property integer $customer_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property integer $phone_number
 * @property string $flag_newsletter
 * @property string $profession
 * @property integer $status
 * @property integer $flagdelete
 * @property integer $deleted_by
 * @property string $created_at
 *
 * @property CustomerAddress[] $customerAddresses
 */
class Customers extends \yii\db\ActiveRecord
{
    public $from_date;
    public $to_date;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone_number', 'status', 'flagdelete', 'deleted_by'], 'integer'],
            [['created_at'], 'safe'],
            [['first_name', 'last_name', 'email', 'password', 'profession'], 'string', 'max' => 255],
            [['flag_newsletter'], 'string', 'max' => 1],
            
            //[['from_date','to_date'],'required','on'=>'outsidefilter'],
            [['from_date','to_date'],'string','on'=>'outsidefilter'],
            //['to_date','compare','compareAttribute' => 'from_date','operator'=>'>=', 'message' => '{attribute} should be greater than "{compareValue}".','on'=>'outsidefilter'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => Yii::t('yii', 'Customer ID'),
            'first_name' => Yii::t('yii', 'First Name'),
            'last_name' => Yii::t('yii', 'Last Name'),
            'email' => Yii::t('yii', 'Email'),
            'password' => Yii::t('yii', 'Password'),
            'phone_number' => Yii::t('yii', 'Contact Number'),
            'flag_newsletter' => Yii::t('yii', 'Newsletter'),
            'profession' => Yii::t('yii', 'Profession'),
            'status' => Yii::t('yii', 'Status'),
            'flagdelete' => Yii::t('yii', 'Flagdelete'),
            'deleted_by' => Yii::t('yii', 'Deleted By'),
            'created_at' => Yii::t('yii', 'Date & Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerAddresses()
    {
        return $this->hasMany(CustomerAddress::className(), ['customer_id' => 'customer_id']);
    }
    
    public function changestatus($status,$id) {
        if ($status == 1) {
                return Html::a('Mark As Inactive', '', ['class' => 'change-status', 'id' => $id]);
            } else {
                return Html::a('Mark As Active', '', ['class' => 'change-status', 'id' => $id]);
            }
    }
    public function getBillingAdress($id,$flagAddressType,$add1Or2) {
        
        $dataAddress = CustomerAddress::find()->where("customer_id = $id AND flag_address_type = '$flagAddressType'")->one();
        if(!empty($dataAddress))
        {
            if($add1Or2 == 1)
            return $dataAddress->address_one;
            else
            return $dataAddress->address_two;
        }
    }
    public function getCountryStateCityPincode($id,$flagAddressType,$couOrStaorCit) {
        
        $dataAddress = CustomerAddress::find()->where("customer_id = $id AND flag_address_type = '$flagAddressType'")->one();
        if(!empty($dataAddress))
        {
            if($couOrStaorCit == 'Cou')
            return $dataAddress->country;
            elseif($couOrStaorCit == 'Sta')
            return $dataAddress->state;
            else
            return $dataAddress->city;
        }
    }
    
    
    
}
