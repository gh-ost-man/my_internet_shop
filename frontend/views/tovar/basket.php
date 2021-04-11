<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php  
  
  use yii\helpers\Html;
  use yii\helpers\Url;

  $i = 1;

  if(isset($error_message)){
    alert($error_message);
  }

  $this->title = "Basket";
  $this->params['breadcrumbs'][] = ['label' => 'Basket', 'url' => ['/tovar/basket']];
  $this->params['breadcrumbs'][] = $this->title;

?>

<style>
  body
  {
    background: #111;
  }
</style>

<h1 class="text-white">Basket</h1>

<table class="table table-striped table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col"></th>
      <th scope="col">Name</th>
      <th scope="col">Count</th>
      <th scope="col">Price</th>
      <th scope="col">Discount</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($tovars as $tovar) : ?>
        <tr>
            <th scope="row"><?= $i++ ?></th>
            <td>
                <div>
                    <img src="/<?= $tovar['url_image'][0] ?>" style="width:70px" alt="">
                </div>
            </td>
            <td><?= $tovar['name'] ?></td>
            <td>
                <input type="number" name="<?= $order->id ?>" id="<?= $tovar['id'] ?>" class="tovar-count" value="<?= $tovar['count'] ?>" min="1">
            <td class="price-<?= $tovar['id']?>"><?= $tovar['price'] ?> $</td>
            <td class="discount-<?= $tovar['id'] ?>"><?= $tovar['discount'] ?> %</td>
        </tr>
    <?php endforeach?>
  </tbody>
</table>
<div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4"></div>
  <div class="col-md-4">
    <h1 class="text-white" style="font-size:30px">Total sum: <span id="total"></span> $</h1>
    <a id="pay" href="<?= Url::to(['/tovar/pay-order']) ?>" class='btn btn-success'>To pay an order</a>
    <a href="<?= Url::to(['/tovar/cancel-order']) ?>" class='btn btn-danger'>Cancel order</a>
  </div>
</div>

<script>

  let host = window.location.protocol + "//" + window.location.host;
  
  Total();

  $('.tovar-count').change(function(){
    let id = $(this).attr('id');
    let count = $(this).val();
    let order_id = $(this).attr('name');
    let tag = $(this);
    $.ajax({
      url: 'update-item',
      type: 'post',
      data: {
        'tovar_id' : id,
        'order_id' : order_id,
        'count' : count
      },
      success: function(data){
        if(data.status == 'error') {
          alert(data.message);
          tag.val('1');
        }
      }
    });

    Total();
  });

  function Total(){
    let total = 0;
    $('.tovar-count').each(function(){
        let id = $(this).attr('id');
        let count = $(this).val();
        let price = parseInt($('.price-' + id).html());
        let discount = parseInt($('.discount-' + id).html());

        let m = count * price;

        if(discount > 0){
          m = (m / 100) * discount;
        } 

        console.log(`id =  ${id}\nCount = ${count}\nPrice = ${price}\nDiscount: ${discount}\nTotal = ${m}`);

        total += m;
    });
    
    $('#total').html(total);
  }

</script>