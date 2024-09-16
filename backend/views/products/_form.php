<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use backend\models\ProductCategories;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>
<?php 
if(!$model->isNewRecord)
{
    $countDownloadableMaterials = backend\models\ProductMaterials::find()->where("product_id = $model->product_id AND flag_material = 'D' AND material_type = 'O'")->count();
    $countDownloadableVideos = backend\models\ProductMaterials::find()->where("product_id = $model->product_id AND flag_material = 'D' AND material_type = 'V'")->count();
    
}
else
{
    $countDownloadableMaterials = 0;
    $countDownloadableVideos = 0;
    
}
?>
<div class="products-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?php
    $allNeededCategories = $model->getNeededCategories();
    $categoruData = ArrayHelper::map($allNeededCategories, 'category_id', 'name');
    //echo $form->field($model, 'category_id')->dropDownList($categoruData, ['prompt' => '-- Select --']);
    echo $form->field($model, 'category_id')
                    ->widget(Select2::classname(), [
                        'data' => $categoruData,
                        'options' => ['placeholder' => '-- Select --'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            //'multiple' => true
                        ],
            ]);
    ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="col-md-4" style="padding: 0px">
        <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>
        <span style="float: left;margin-top: -95px;margin-left: 52px;font-size: 11px;">Preferred Image Dimension : <?php echo Yii::$app->params['catImageDimentionWidth']; ?> Width, <?php echo Yii::$app->params['catImageDimentionHeight']; ?> Height</span>
        <?php if (!$model->isNewRecord && $model->image != "" && file_exists(Yii::$app->basePath.'/web/images/products/'.$model->image)) { ?>
            <span style="float: right;margin-top: -73px;margin-right: 70px;"><?php $img = Html::img(Yii::getAlias('@web') . '/images/products/' . $model->image, ['width' => 100, 'height' => 100]);
            echo Html::a($img, Yii::getAlias('@web') . '/images/products/' . $model->image, ['target' => '_blank']); ?></span>
    <?php } ?>
    </div>

    <?= $form->field($model, 'cost_type')->radioList(['Free' => 'Free', 'Paid' => 'Paid']) ?>
    <div class="priceSection">
<?= $form->field($model, 'price',['enableAjaxValidation'=>true])->textInput(['maxlength' => true,'placeholder'=>'0.00']) ?>
      </div>



    <?= $form->field($model, 'status')->radioList(['1' => 'Active', '0' => 'In Active',]) ?>

        


<?php
echo $form->field($model, 'description')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'basic'
]);
?>
<div class="col-md-12">
        <div class="divdonwloadbalematerial maindivcontainer">
            <h4 style="float: left;width: 98%;background-color: #ececec;padding: 7px;margin-bottom: 25px;">Downloadable Materials</h4>
            <div class="adddownloadablematerialmaincontainer" style="width: 100%;float:left">
            <div class="col-md-12" id="adddownloadablematerialcontainer-0">
            <?= $form->field($modelProductMaterials, 'attachmentsname[]')->textInput() ?>
            <?= $form->field($modelProductMaterials, 'attachments[]')->fileInput(['accept' => '.pdf']) ?>
            <?php echo Html::a('+', 'javascript:void(0)', ['class'=>'btn btn-success btn-xs adddownloadablematerial adddownloadablematerialfirst','style'=>'']);  ?>
            </div>
            </div>
            
            <div class="attachmentviewsec">
                    <?php
                    if ($model->product_id) {
                        $modelUploadedAttachment = new backend\models\ProductMaterials();
                        $dataImages = $modelUploadedAttachment->getUploadedAttachments($model->product_id,'DO');
                        ?>

                        <?php if (count($dataImages) > 0) { ?>
                            <h4 style="float: left;width: 100%;border-top: 1px solid #ededed;padding: 20px 0;display:none"><?php echo '<b>' . $model->name . '</b>'; ?> : Uploaded Materials</h4>
                        <?php } else { ?>
                            <h4 style="float: left;width: 100%;border-top: 1px solid #ededed;padding: 20px 0;"><?php echo '<b>Not Available.</b>'; ?></h4>    
                            <?php } ?>
                        <div class="alert-success alert-success-modified" style="display: none;">Downloadable Material Deleted Successfully</div>    
                        <div class="upload-images" data-code='DO'>
                            <?php
                foreach ($dataImages as $images) {
                    $imagePath = Yii::getAlias('@web') . '/images/product-materials/' . $images->url_material;
                    ?>
                                                    <div class="wholeimgpart">
                                                    <div class="up-images" data-id="<?php echo $images->material_id; ?>" data-confirm = "Are You Sure ?" title="Click To Delete Image">
                                                    </div>

                                                    <?php
                            $pdIco = Html::img(Yii::getAlias('@web') . '/images/Pdf.png',[
                                        'class' => 'albumpicclass',
                                        'height' => '70px',
                                        'width' => '70px',
                                            //'style'=>'box-shadow:8px 8px 13px #ccc;border:1px solid #ccc;margin:10px;border-radius:10px'
                                            ]
                            );

                            echo Html::a($pdIco,$imagePath,['target'=>'_blank','title'=>'Click to view','class'=>'dispimage']);
                            echo Html::a(substr($images->name,0,10).'...',$imagePath,['target'=>'_blank','title'=>$images->name]);
                            ?>

                                                </div>
                                    <?php } ?>
                                </div>
                    <?php } ?>
                </div>
        </div>        
    
    <div class="divdownloadablevideos maindivcontainer">
        <h4 style="float: left;width: 98%;background-color: #ececec;padding: 7px;margin-bottom: 25px;">Downloadable Videos</h4>
        <div class="adddownloadablevideomaincontainer" style="width: 100%;float:left">
        <div class="col-md-12" id="adddownloadablevideocontainer-0">
        <?= $form->field($modelProductMaterials, 'videosdownloadablename[]')->textInput() ?>
        <?= $form->field($modelProductMaterials, 'videosdownloadable[]')->fileInput(['accept' => '.mp4']) ?>
        <?php echo Html::a('+', 'javascript:void(0)', ['class'=>'btn btn-success btn-xs adddownloadablevideo adddownloadablevideofirst','style'=>'']);  ?>
        </div>
        </div>
        
        <div class="attachmentviewsec">
                    <?php
                    if ($model->product_id) {
                        $modelUploadedAttachment = new backend\models\ProductMaterials();
                        $dataImages = $modelUploadedAttachment->getUploadedAttachments($model->product_id,'DV');
                        ?>

                        <?php if (count($dataImages) > 0) { ?>
                            <h4 style="float: left;width: 100%;border-top: 1px solid #ededed;padding: 20px 0;display:none"><?php echo '<b>' . $model->name . '</b>'; ?> : Uploaded Materials</h4>
                        <?php } else { ?>
                            <h4 style="float: left;width: 100%;border-top: 1px solid #ededed;padding: 20px 0;"><?php echo '<b>Not Available.</b>'; ?></h4>    
                            <?php } ?>
                        <div class="alert-success alert-success-modified" style="display: none;">Downloadable Video Deleted Successfully</div>    
                        <div class="upload-images" data-code='DV'>
                            <?php
                foreach ($dataImages as $images) {
                    $imagePath = Yii::getAlias('@web') . '/images/product-materials/' . $images->url_material;
                    ?>
                                                    <div class="wholeimgpart">
                                                    <div class="up-images" data-id="<?php echo $images->material_id; ?>" data-confirm = "Are You Sure ?" title="Click To Delete Image">
                                                    </div>

                                                    <?php
                            $pdIco = Html::img(Yii::getAlias('@web') . '/images/video.png',[
                                        'class' => 'albumpicclass',
                                        'height' => '70px',
                                        'width' => '70px',
                                            //'style'=>'box-shadow:8px 8px 13px #ccc;border:1px solid #ccc;margin:10px;border-radius:10px'
                                            ]
                            );

                            echo Html::a($pdIco,$imagePath,['target'=>'_blank','title'=>'Click to view','class'=>'dispimage']);
                            echo Html::a(substr($images->name,0,10).'...',$imagePath,['target'=>'_blank','title'=>$images->name]);
                            ?>

                                                </div>
                                    <?php } ?>
                                </div>
                    <?php } ?>
                </div>
        
        </div>

         
</div>       
    


    

<div class="row rowbtn">
    <div class="form-group typesubmit">
<?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Submit') : Yii::t('yii', 'Submit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
<?php echo Html::a(Yii::t('yii', 'Cancel'), ['index'], ['class' => 'btn-success btn']); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

</div>
<script>
$('document').ready(function(){
    //$('.up-images').click(function(e){
    $(document).delegate(".up-images", "click", function(e){
       
       var thizPathFormessage = $(this).parent().parent().prev('.alert-success-modified');
       var thizPathForResponse = $(this).parent().parent();
       code = $(this).parent().parent().data('code');
       
        
        imageId = $(this).data('id');
        productId = '<?php echo $model->product_id; ?>'; 
        
        Lobibox.confirm({
            msg: "Are you sure you want to delete?",
                    callback: function (lobibox, type) {
                        
                         if(type == 'yes')
                           {
                              $('#loading').show();
                              $.ajax({
                        		type: 'post',
                        		url: '<?php echo Yii::$app->urlManager->createUrl(['products/deletematerial']); ?>',
                        		data : {imageid:imageId,productId:productId,code:code},
                        		success: function (response) {
                        		  $('#loading').hide();
                        		  //$('.upload-images').html(response);
				  //$('.alert-success-modified').show();
                                        thizPathForResponse.html(response);
                                        thizPathFormessage.show();
                                       setTimeout(function() { thizPathFormessage.fadeOut(1500); }, 2000);
                        		  return false;
                        		  }
                            	});
                            	e.preventDefault();
                            	e.stopImmediatePropagation();  
                            	return false;
                           }
                          else
                            {
                                
                            }    
                }
      
        })
    })
    
     var countDownloadableMaterials = 0;
     var countDownloadableVideos = 0;
    if('<?php echo $countDownloadableMaterials; ?>' != 0)
    {
        countDownloadableMaterials  =  <?php echo $countDownloadableMaterials-1;?>;
    }
    if('<?php echo $countDownloadableVideos; ?>' != 0)
    {
        countDownloadableVideos  =  <?php echo $countDownloadableVideos-1;?>;
    }
    
    // Add multiple downloadable material
    $(document).on("click",".adddownloadablematerial",function (e) {
        countDownloadableMaterials = countDownloadableMaterials+1;
        if(countDownloadableMaterials == 0) { countDownloadableMaterials = 1; }
        e.preventDefault();
        var str  =  
         "<div class='col-md-12' id='adddownloadablematerialcontainer-"+countDownloadableMaterials+"' style='margin-bottom:10px;height:60px'>\n\
\n\
<div class = 'form-group'>"+adddownloadablematerialname('')+"</div>\n\
\n\<div class = 'form-group'>"+adddownloadablematerialattachment('')+"</div>\n\
\n\<div class = 'form-group' style='margin-left:20px;width:65px'><a style='margin-top:0px !important;margin-right:10px !important' href='#' class='btn btn-success btn-xs adddownloadablematerial' id="+countDownloadableMaterials+">+</a><a style='' href='#' class='btn btn-danger btn-xs removedownloadablematerial' id="+countDownloadableMaterials+">-</a></div>";
$('.adddownloadablematerialmaincontainer').append(str);
    });
    $(document).on("click",".removedownloadablematerial",function (e) {
        
            e.preventDefault();
            var id = $(this).attr('id');
            $("#adddownloadablematerialcontainer-"+id).remove();
            //counterInqAttachement = counterInqAttachement - 1;
    });
    
     function adddownloadablematerialname(txt)
	{
                                  
		var text  =  '<input type="text" name="ProductMaterials[attachmentsname][]" id="productmaterials-attachmentsname" class="form-control value="">';
                                return text;
	}
    function adddownloadablematerialattachment(txt)
        {
                var text  = '<input type="file" id="productmaterials-attachments" name="ProductMaterials[attachments][]" accept=".pdf">';
                                return text;
        }
        
        
    
        
        
    // Add multiple downloadable videos
    $(document).on("click",".adddownloadablevideo",function (e) {
        countDownloadableVideos = countDownloadableVideos+1;
        if(countDownloadableVideos == 0) { countDownloadableVideos = 1; }
        e.preventDefault();
        var str  =  
         "<div class='col-md-12' id='adddownloadablevideocontainer-"+countDownloadableVideos+"' style='margin-bottom:10px;height:60px'>\n\
\n\
<div class = 'form-group'>"+adddownloadablevideoname('')+"</div>\n\
\n\<div class = 'form-group'>"+adddownloadablevideoattachment('')+"</div>\n\
\n\<div class = 'form-group' style='margin-left:20px;width:65px'><a style='margin-top:0px !important;margin-right:10px !important' href='#' class='btn btn-success btn-xs adddownloadablevideo' id="+countDownloadableVideos+">+</a><a style='' href='#' class='btn btn-danger btn-xs removedownloadablevideo' id="+countDownloadableVideos+">-</a></div>";
$('.adddownloadablevideomaincontainer').append(str);
    });
    $(document).on("click",".removedownloadablevideo",function (e) {
        
            e.preventDefault();
            var id = $(this).attr('id');
            $("#adddownloadablevideocontainer-"+id).remove();
            //counterInqAttachement = counterInqAttachement - 1;
    });
    
     function adddownloadablevideoname(txt)
	{
                                  
		var text  =  '<input type="text" name="ProductMaterials[videosdownloadablename][]" id="productmaterials-videosdownloadablename" class="form-control value="">';
                                return text;
	}
    function adddownloadablevideoattachment(txt)
        {
                var text  = '<input type="file" id="productmaterials-videosdownloadable" name="ProductMaterials[videosdownloadable][]" accept=".mp4">';
                                return text;
        }
        
        
        // Show hide price
        <?php if(!$model->isNewRecord){ ?>
            var chekedVal = $('#products-cost_type label input:checked').val();
            if(chekedVal == 'Free')
                $('.priceSection').hide();
        <?php } ?>
        $('#products-cost_type label input').click(function(){
            if($(this).val() == 'Paid')
            {
                $('.priceSection').show();
            }else{
                $('.priceSection').hide();
            }
            
        });
        
        
     
        
})
</script>