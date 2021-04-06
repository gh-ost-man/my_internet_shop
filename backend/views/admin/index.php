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

// $this->registerCss(
//     "   
//         body 
//         {
//             color: red;
//         }

//     "
// );

?>






<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Users</div>
  <!-- Table -->
  <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Id</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th scope="col">Role</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($user_array as $user) : ?>
        <tr>
            <th scope="row"><?= $i++; ?></th>
            <th scope="row"><?= $user['id']; ?></th>
            <td><?= $user['username'] ?></td>
            <td><?= $user['email'] ?></td>
            <td>
                <?= Select2::widget([
                    'name' => $user['id'],
                    'data' => $role_array,
                    'value' => $user['role'],
                    'options' => [
                        'class' => 'role',
                        'placeholder' => 'Select provinces ...',
                    'multiple' => false
                    ],
                ]); ?>
            </td>
            <td> 
                <?=  Html::a('Delete', ['delete','id' => $user['id']], ['class' => 'btn btn-danger']);  ?>
            </td>
        </tr>
    <?php endforeach ?>
  </tbody>
  </table>
</div>