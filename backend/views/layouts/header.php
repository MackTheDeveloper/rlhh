<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
Yii::$app->name = 'RLHH';
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div>
            <ul class="nav navbar-nav">
                <li>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Users Management<span class="caret"></span></a>
                    <ul role="menu" class="dropdown-menu">
                        <li>
                            <?= Html::a('Internal Users',['/users']) ?>
                        </li>
                        <li>
                            <?= Html::a('Trainers',['/trainer']) ?>
                        </li>
                        <li>
                            <?= Html::a('Website Users',['/customers']) ?>
                        </li>
                    </ul>
                    
                </li>
                
                <li style="display: none;">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Customers Management<span class="caret"></span></a>
                    <ul role="menu" class="dropdown-menu">
                        <li>
                            <?= Html::a('Customers',['/customers']) ?>
                        </li>
                    </ul>
                    
                </li>
                
                <li>
                    
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Course Management<span class="caret"></span></a>
                    <ul role="menu" class="dropdown-menu">
                        <li>
                            <?= Html::a('Course Categories',['/categories']) ?>
                        </li>
                        <li>
                            <?= Html::a('Courses',['/courses']) ?>
                        </li>
                        <li>
                            <?= Html::a('Scheduling',['/course-schedule']) ?>
                        </li>
                        <li>
                            <?= Html::a('Registrations',['/courseregistration']) ?>
                        </li>
                    </ul>
                        
                </li>
                <li>
                    
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Product Management<span class="caret"></span></a>
                    <ul role="menu" class="dropdown-menu">
                        <li>
                            <?= Html::a('Product Categories',['/product-categories']) ?>
                        </li>
                        <li>
                            <?= Html::a('Products',['/products']) ?>
                        </li>
                    </ul>
                        
                </li>
                
                 <li>
                    
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Frontend Management<span class="caret"></span></a>
                    <ul role="menu" class="dropdown-menu">
                        <li>
                            <?= Html::a('Our Collaboration',['/collaboration']) ?>
                        </li>
                        <li>
                            <?= Html::a('Our Team',['/teachingteam']) ?>
                        </li>
                    </ul>
                        
                </li>
            </ul>
        </div>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        
                        <span class="hidden-xs">Welcome : <?php echo Yii::$app->user->identity->first_name.' '.Yii::$app->user->identity->last_name; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        
                        
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                
            </ul>
        </div>
    </nav>
</header>
