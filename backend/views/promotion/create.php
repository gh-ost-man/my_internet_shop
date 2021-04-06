<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;
use kartik\widgets\FileInput;
use yii\helpers\Url;

$this->title = 'Створення реклами';
$this->params['breadcrumbs'][] = ['label' => 'Реклами', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4><?= $this->title;?></h4>
    </div>
    <?php
        $form = ActiveForm::begin(['id' => 'tovar-create']);
    ?>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'name')->textInput(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'description')->textarea(['row' => '3'])->label('Опис'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'imageFile')->widget(FileInput::classname(), [
                    'options'=>[
                        'multiple'=>true,
                        'max' => 10,
                    ],
                    'pluginOptions' => [
                        'initialPreview'=> $initialPreview,
                        'initialPreviewConfig' => $initialConfig,
                        'initialPreviewAsData'=> true,
                        'showCaption' => false,
                        'showUpload' => false,
                        'overwriteInitial'=> false,
                        'removeClass' => 'btn btn-default pull-right',
                        'browseClass' => 'btn btn-primary pull-right',
                        'maxFileSize'=> 2800,
                        // 'deleteUrl' => Url::to(["/promotion/" . $promotion_id . "/file-delete-promotion"])
                        'deleteUrl' => Url::to(['/promotion/file-delete-promotion?id=' . $promotion_id]),
                    ]
                ]);?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success btn-block m-2']); ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>