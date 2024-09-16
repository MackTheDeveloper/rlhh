<aside class="main-sidebar">
    <?php
    use yii\widgets\Menu;
    echo Menu::widget([
            'options'=>['class'=>'sidemenu nav navbar-nav side-nav'],
            'items' => isset($this->params['menu']) ? $this->params['menu'] : [],
        ]);
    ?>
    

</aside>
