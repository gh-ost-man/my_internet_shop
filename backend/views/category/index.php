<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Категорія';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="row">
    <div class="col-md-12">
        <?= Html::a(
            'Додати категорію',
            Url::toRoute('category/create'),
            [
                'class' => 'btn btn-success pull-right',
                'id' => 'category_create'
            ]
        );?>
    </div>
</div>