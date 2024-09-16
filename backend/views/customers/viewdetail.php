<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Trainer */
?>
<div class="detail-container">
    <h4 style="float: left;width: 98%;background-color: #ececec;padding: 7px;margin-bottom: 25px;">Basic Detail</h4>
    <div class="labeldata">First Name</div><div class="resultdata"><?php echo $model->first_name; ?></div>
    <div class="labeldata">Last Name</div><div class="resultdata"><?php echo $model->last_name; ?></div>
    <div class="labeldata">Email</div><div class="resultdata"><?php echo $model->email; ?></div>
    <div class="labeldata">Contact Number</div><div class="resultdata"><?php echo $model->phone_number; ?></div>
    <div class="labeldata">Profession</div><div class="resultdata"><?php echo $model->profession; ?></div>
    <div class="labeldata">Newsletter</div><div class="resultdata"><?php echo $model->flag_newsletter == 'Y' ? 'Yes' : 'No'; ?></div>
    <div class="labeldata">Status</div><div class="resultdata"><?php echo $model->status == 1 ? 'Active' : 'In Active'; ?></div>
    
    <h4 style="float: left;width: 98%;background-color: #ececec;padding: 7px;margin-bottom: 25px;">Address  Detail</h4>
    <div class="col-md-12">
        <div class="col-md-6">
            <h4 style="float: left;width: 98%;background-color: #ececec;padding: 7px;margin-bottom: 25px;">Billing Address</h4>
            <?php 
            $billingAddress = \backend\models\CustomerAddress::find()->where("customer_id = $model->customer_id AND flag_address_type = 'B'")->one();
            if(!empty($billingAddress))
            { ?>
                    <div class="labeldata">Address 1</div><div class="resultdata"><?php echo $billingAddress->address_one; ?></div>
                    <div class="labeldata">Address 2</div><div class="resultdata"><?php echo $billingAddress->address_two; ?></div>
                    <div class="labeldata">Country</div><div class="resultdata"><?php echo $billingAddress->country; ?></div>
                    <div class="labeldata">State</div><div class="resultdata"><?php echo $billingAddress->state; ?></div>
                    <div class="labeldata">City</div><div class="resultdata"><?php echo $billingAddress->city; ?></div>
                    <div class="labeldata">Zip code</div><div class="resultdata"><?php echo $billingAddress->zipcode; ?></div>
                    <?php } ?>
        </div>
        <div class="col-md-6">
            <h4 style="float: left;width: 98%;background-color: #ececec;padding: 7px;margin-bottom: 25px;">Shipping Address</h4>
            <?php 
            $billingAddress = \backend\models\CustomerAddress::find()->where("customer_id = $model->customer_id AND flag_address_type = 'S'")->one();
            if(!empty($billingAddress))
            { ?>
                    <div class="labeldata">Address 1</div><div class="resultdata"><?php echo $billingAddress->address_one; ?></div>
                    <div class="labeldata">Address 2</div><div class="resultdata"><?php echo $billingAddress->address_two; ?></div>
                    <div class="labeldata">Country</div><div class="resultdata"><?php echo $billingAddress->country; ?></div>
                    <div class="labeldata">State</div><div class="resultdata"><?php echo $billingAddress->state; ?></div>
                    <div class="labeldata">City</div><div class="resultdata"><?php echo $billingAddress->city; ?></div>
                    <div class="labeldata">Zip code</div><div class="resultdata"><?php echo $billingAddress->zipcode; ?></div>
                    <?php } ?>
        </div>
            
        
    </div>
        
    
</div>


