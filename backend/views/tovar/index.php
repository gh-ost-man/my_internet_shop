<?php 
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Товар';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-md-12">
        <?= Html::a(
            'Додати товар',
            Url::toRoute('tovar/create'),
            [
                'class' => 'btn btn-success pull-right',
                'id' => 'tovar-create'
            ]
            ); ?>
    </div>
    <?php 
        var_dump($tovar);
    ?>
</div>