<?php 
    namespace frontend\controllers;
    
    use Yii;
    use yii\web\Controller;
    use yii\web\UploadedFile;
    use yii\data\ActiveDataProvider;
    use yii\helpers\ArrayHelper;
    use yii\filters\AccessControl;

    use common\models\Category;
    use common\models\Tovar;
    use common\models\Discount;
    use common\models\Order;
    use common\models\Item_Order;
    use common\models\Promotion;
   
    class TovarController extends Controller
    {
        public function actionView($id)
        {
            $tovars = Tovar::find()->where(['category_id' => $id])->andWhere(['>' ,'count', 0])->all();
            $category = Category::find()->where(['id' => $id ])->one();
            
            return $this->render('view', [
                'tovars' => $tovars,
                'category' => $category
            ]);
        }

        public function actionItem($id)
        {
            $tovar = Tovar::find()->where(['id' => $id])->asArray()->one();

            if($tovar['discount_id'] != null){
                $discount = Discount::find()->where(['id'=> $tovar['discount_id']])->one();
                $percent = $discount->percent;
            } else {
                $percent = 0;
            }
            
            $category = Category::find()->where(['id' => $tovar['category_id'] ])->one();
            
            return $this->render('item', [
                'tovar' => $tovar,
                'discount' => $percent,
                'category' => $category
            ]);
        }



        public function actionAddItem($id)
        {
            $idUser = Yii::$app->user->id;
            
            $order = Order::find()->where(['user_id' => $idUser])->andWhere(['=','status','new'])->one();

            if($order == null ) 
            {
                $model = new Order;
                $model->number = 0;
                $model->user_id = $idUser;
                $model->status = 'new';
                
                if ($model->save()){
                    $order = Order::find()->where(['user_id' => $idUser])->andWhere(['=','status','new'])->one();
                }
            }

            $item_Order =  Item_Order::find()->where(['tovar_id' => $id])->andWhere(['=','order_id', $order->id])->one();
                
            //якщо замовлення існує просто повертаєм всі товари цього замовлення
            if($item_Order == null){
                $new_item_order = new Item_Order;
                $new_item_order->order_id = $order->id;
                $new_item_order->tovar_id = $id;


                $tovar = Tovar::find()->where(['id' => $id])->one();
                
                if($tovar['discount_id'] != null){
                    $discount = Discount::find()->where(['id'=> $tovar['discount_id']])->one();
                    $percent = $discount->percent;
                } else {
                    $percent = 0;
                }

                $price = ($tovar['price'] / 100) * $percent;
                $new_item_order->price = $price;

                $new_item_order->save();
            }
            $items_order = Item_Order::find()->where(['order_id' => $order->id])->all();

            return $this->redirect('basket');

        }

        public function actionBasket()
        {
            $idUser = Yii::$app->user->id;
            
            $order = Order::find()->where(['user_id' => $idUser])->andWhere(['=','status','new'])->one();
            
            if($order != null){
                $items_order = Item_Order::find(['order_id' => $order->id])->all();
                $tovars = [];
    
                foreach($items_order as $item) {
                    $product = Tovar::find()->where(['id' => $item->tovar_id])->one();
    
                    if($product->discount_id != null ){
                        $discnt = Discount::find()->where(['id' => $product->discount_id])->one(); 
                        $per = $discnt->percent;
                    } else {
                        $per = 0;
                    }
                    $tovars[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product-> price,
                        'discount' => $per,
                        'url_image' => json_decode($product->url_image, true),
                        'count' => $item->count
                    ];
                } 
    
                return $this->render('basket', [
                    'order' => $order,
                    'items_order' => $items_order,
                    'tovars' => $tovars
                ]);
            }
            return $this->render('basket', [
                'order' => [],
                'items_order' => [],
                'tovars' => []
            ]);


        }

        public function actionUpdateItem()
        {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;// формат відповіді

            if($_POST != null){
                $item_order = Item_Order::find()->where(['tovar_id' => $_POST['tovar_id']])->andWhere(['=','order_id', $_POST['order_id']])->one();
                $tovar = Tovar::find()->where(['id' => $item_order->tovar_id])->one();
                
                //Обчислюєм суму товара якщо є знижка
                if($tovar->discount_id != null){
                    $discount = Discount::find()->where(['id'=> $tovar->discount_id])->one();
                    $percent = $discount->percent;
                    $price = ($tovar->price / 100) * $percent;
                } else {
                    $price = $tovar->price;
                }
                
                $item_order->count = $_POST['count'];
                $item_order->price = $price * $item_order->count;

                $tovar = Tovar::find()->where(['id' => $_POST['tovar_id']])->one();
                
                if(($tovar->count - $_POST['count']) >= 0){
                    $item_order->save();
                    return true;
                } else {
                    return  ['status' => 'error', 'message' => 'Error!! Quantity of goods equal: ' . $tovar->count];
                }
            }
            return false;
        }

        public function actionPayOrder()
        {
            $idUser = Yii::$app->user->id;

            $order = Order::find()->where(['user_id' => $idUser])->andWhere(['=','status','new'])->one();

            if($order != null) {
                $items_order = Item_Order::find(['order_id' => $order->id])->all();
    
                if(count($items_order) == 0){
                    return $this->redirect('basket');
                }

                $total = 0;

                foreach($items_order as $item){
                    $total += $item->price;
                }
    
                $order->status = 'booked';
                $order->number = count($items_order);
                $order->total_sum = $total;
                $order->save();
    
               return $this->redirect('/site/index');
            }

            return $this->redirect('basket');
        }
        public function actionCancelOrder()
        {
            $idUser = Yii::$app->user->id;

            $order = Order::find()->where(['user_id' => $idUser])->andWhere(['=','status','new'])->one();

            if($order != null){
                Item_Order::deleteAll(['order_id' => $order->id]);
            }

            return $this->redirect('basket');
        }
    }