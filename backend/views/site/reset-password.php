<?php
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Page Title</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php $form = ActiveForm::begin(['action'=>['site/forgotresetpassword'],'method' => 'post' ,'enableClientValidation' => false]); ?>
        <div class="form-group">
            <label>New Password</label>
            <input type="password" class="form-control col-md-6" name="password" title="Password" placeholder="Password" >
        </div>
        <div class="form-group">
            <label>New Password</label>
            <input type="password" class="form-control col-md-6" name="confirm_password" title="Confirm Password" placeholder="Confirm Password">
            <input type="hidden" name="reset_password_token" value="<?php echo $reset_password_token; ?>">
            
        </div>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-flat', 'name' => 'forgot-password','id'=>'btn_forgot_password']) ?>
            <div id="errMsg"></div>
        </div>

        <?php ActiveForm::end(); ?>
    </body>
</html>
