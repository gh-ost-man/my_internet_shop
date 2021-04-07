<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

use kartik\select2\Select2;

$this->title = 'Користувачі';
$this->params['breadcrumbs'][] = $this->title;

$js = <<< JS
    $('.role').change(function(){
        var id = $(this).attr('name');
        var role = $(this).val();
        $.ajax({
            type: 'post',
            url: 'change-role',
            data: {
                'id' : id, 
                'role' : role
                },
            success: (function() {
                alert('Role is changed');
            })

        });
    });
JS;

$i = 1;
$this->registerJS($js);
?>


<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div>
            <p>Id: <?= $user['id']?></p>
            <p>Username: <?= $user['username']?></p>
            <p>Email: <?= $user['email']?></p>
            <div>
                <label for="">Role</label> 
                    <?= Select2::widget([
                        'name' => $user['id'],
                        'data' => $role_array,
                        'value' =>$role,
                        'options' => [
                            'class' => 'role',
                            'placeholder' => 'Select provinces ...',
                        'multiple' => false
                        ],
                    ]); ?>
            </div>
           
        </div>
    </div>
    <div class="col-md-3"></div>
</div>
