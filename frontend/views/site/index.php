<?php

    use yii\helpers\Html;
    use yii\helpers\Url;

    $i = 0;
    $k = 0; //для виводу 10 нових товарів
    $this->title = 'App';
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <?php foreach($categories as $category) : ?>
                <a href="<?= Url::to(["/tovar/" . $category->id . "view"]) ?>" class="list-group-item list-group-item-action"><?= $category['name']?></a>
            <?php endforeach ?>
        </div>
    </div>
    <div class="col-md-9">
        <div id="carouselExampleControls" class="carousel slide " data-ride="carousel" >
            <div class="carousel-inner" >
                <?php foreach($promotions as $promotion) { 
                    $promotion_images = json_decode($promotion['url_image'], true);
                    foreach($promotion_images as $img) : ?>
                        <?php if($i == 0) :?>
                            <div class="carousel-item active">
                                <img src="../../<?= $img ?>" class="d-block w-100" style=" height:350px" alt="...">
                            </div>
                        <?php $i++; endif ?>
                        <div class="carousel-item">
                            <img src="../../<?= $img ?>" class="d-block w-100" style=" height: 350px"  alt="...">
                        </div>
                    <?php endforeach ?>
                <?php } ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" style="color:red" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>