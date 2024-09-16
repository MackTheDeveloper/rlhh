<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

dmstr\web\AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="login-page">

<?php $this->beginBody() ?>

    <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script>
    $(document).ready(function(){
        $('#btn_forgot_password').on('click',function(){
            $.ajax({
                type: "POST",
                url: "<?php echo Url::to('validateemail'); ?>",
                data: "email=" + $('#email_forgot_password').val(),
                success: function (result) {
                    $('#errMsg').html('');
                    if(result == "1") {
                        $('#errMsg').html('Check your mail. The Reset password link is sent');
                    }else{
                        $('#errMsg').html(result);
                    }
                },
            });
        });
    });
</script>