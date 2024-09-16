<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\ProductMaterials;
use yii\helpers\Url;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
/* @var $searchModel common\models\TourAlbumSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<?php  
    $modelUploadedImages = new ProductMaterials();
    $dataImages = $modelUploadedImages->getUploadedAttachments($productId,$code);
    ?>
	
	 <?php
                if($code == 'DO' || $code == 'PO') 
                { 
                    $identifyFileType = 'Pdf.png'; 
                } else { 
                    $identifyFileType = 'video.png'; 
                }
                
                foreach ($dataImages as $images) {
                    $imagePath = Yii::getAlias('@web') . '/images/product-materials/' . $images->url_material;
                    ?>
                    <div class="wholeimgpart">
                        <div class="up-images" data-id="<?php echo $images->material_id; ?>" data-confirm = "Are You Sure ?" title="Click To Delete Image">
                        </div>

                        <?php
                        
                        $pdIco = Html::img(Yii::getAlias('@web') . '/images/'.$identifyFileType,[
                                    'class' => 'albumpicclass',
                                    'height' => '70px',
                                    'width' => '70px',
                                        //'style'=>'box-shadow:8px 8px 13px #ccc;border:1px solid #ccc;margin:10px;border-radius:10px'
                                        ]
                        );
                        
                        echo Html::a($pdIco,$imagePath,['target'=>'_blank','title'=>'Click to view','class'=>'dispimage']);
                        echo Html::a(substr($images->name,0,10).'...',$imagePath,['target'=>'_blank','title'=>$images->name]);
                        ?>
                                         
                        
                    <?php //echo Html::button($img, ['value' => Url::to(['hotels/viewimage', 'imagePath' => $imagePath]), 'title' => 'Click to View', 'class' => 'showModalButton', 'id' => 'modalbutton_show_image']); ?>
                    </div>
    <?php }
    ?>
	
