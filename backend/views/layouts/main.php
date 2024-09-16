<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
}else{

    if(class_exists('backend\assets\AppAsset')){
        backend\assets\AppAsset::register($this);
    }else{
        app\assets\AppAsset::register($this);
    }

    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <script src="<?php echo Yii::getAlias('@web');?>/js/jquery-1.11.0.min.js"></script>
        <?php $this->head() ?>
    </head>
    <body class="<?= \dmstr\helpers\AdminLteHelper::skinClass() ?>">
        <div id="loading">
            <img id="loading-image" src="<?php  echo Yii::$app->request->baseUrl.'/images/loading.gif';  ?>" alt="Loading..."/>
</div>
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>
 <?php if (Yii::$app->controller->action->controller->id != 'site') { ?>
        <?= $this->render(
                'left.php',
                ['directoryAsset' => $directoryAsset]
            )
        ?>
 <?php } ?>
        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
<script>
$(document).ready(function(){
    $(window).load(function() {
     $('#loading').show();
     //$("#loading").fadeOut("slow");
     $("#loading").fadeOut(1000);
     
  });
  
  // SET TOOLTIP ON HOVER
  $('*').tooltip();  
  /*$( ".tooltip_all" ).tooltip({
        tooltipClass: "tooltip_all1"
  }); */
      

})
</script>