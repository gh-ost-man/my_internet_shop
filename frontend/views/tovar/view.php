<?php
    use yii\helpers\Html;
    use yii\helpers\Url;

    $this->title = $category->name;
    $this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => [$category->id . 'view']];
    $this->params['breadcrumbs'][] = $this->title;

?>
<style>
    hr
    {
        background: white;
    }

</style>
<h1 class="text-white"><?= $category->name?></h1>
<hr>

<div class="row">
    <?php foreach($tovars as $tovar) : $imgs = json_decode($tovar['url_image'], true);  ?>
        <div class="col-md-3">
            <div class="card mt-2" style="width: 15rem;">
                <img src="/<?= $imgs[0] ?>" class="card-img-top" alt="..." style="height: 200px">
                <hr>
                <div class="card-body">
                    <a href="<?= Url::to(["/tovar/" . $tovar->id . "item"]) ?>" class="card-title" style="color:black;"><?= $tovar['name']?></a>
                    <h4 class="card-text p-1 text-center bg-dark text-white"><?= $tovar['price'] ?>$</h4>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>