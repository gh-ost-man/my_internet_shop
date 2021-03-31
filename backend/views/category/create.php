<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Створення категорії';
$this->params['breadcrumbs'][] = ['label' => 'Категорії', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4><?= $this->title; ?></h4>
    </div>
    <?php
        $form = ActiveForm::begin(['id' => 'category-create']);
    ?>
    <div class="panel-body">
        <div class="row">
            <div class="com-md-12">
                <?= $form->field($model, 'name')->textInput(); ?>
            </div>
        </div> 
        <div class="row">
            <div class="com-md-12">
                <?= $form->field($model, 'description')->textarea(['row' => '3'])->label('Опис категорії'); ?>
            </div>
        </div>    
        <div class="row">
            <div class="col-md-12">
                <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success btn-block']) ?>
            </div>
        </div>
    </div>
    <?php 
        ActiveForm::end();
    ?>
</div>