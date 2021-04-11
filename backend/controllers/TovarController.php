<?php 
    namespace backend\controllers;
    
    use Yii;
    use yii\web\Controller;
    use yii\web\UploadedFile;
    use yii\data\ActiveDataProvider;
    use yii\helpers\ArrayHelper;
    use yii\filters\AccessControl;

    use backend\models\TovarForm;
    use common\models\Category;
    use common\models\Tovar;
    use common\models\Discount;
   
    class TovarController extends Controller
    {
        public function behaviors()
        {
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'only' => ['index', 'create', 'update', 'delete'],
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'create', 'update', 'delete'],
                            'roles' => ['admin', 'owner', 'manager'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['index'],
                            'roles' => ['user'],
                        ],
                    ],
                ],
            ];
        }

        public function actionIndex()
        {
            $dataProvider = new ActiveDataProvider([
                'query' => Tovar::find()
            ]);

            return $this->render('index',[
                'dataProvider' => $dataProvider
            ]);
        }

        public function actionCreate()
        {
            $model = new TovarForm;

            if($model->load(Yii::$app->request->post())){
                $tovar = new Tovar;
                $model->imageFile = UploadedFile::getInstances($model, 'imageFile');
               
                if ($imagePath = $model->upload()){
                    $tovar->name = $model->name;
                    $tovar->description = $model->description;
                    $tovar->count = $model->count;
                    $tovar->category_id = $model->category_id;
                    $tovar->price = $model->price;
                    var_dump($imagePath);
                    die();
                    $tovar->url_image = json_encode($imagePath);

                    if($tovar->save()){
                        Yii::$app->session->setFlash('success', 'Товар збережено в БД');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Помилка збереження товару в БД');
                }
                return $this->redirect(['tovar/index']);
            }

            $categories = Category::find()->all();
            foreach($categories as $category){
                $category_array[$category->id] = $category->name;
            }

            $discounts = Discount::find()->all();
            $discount_array = [];
            foreach($discounts as $discount){
                $discount_array[$discount->id] = $discount->name;
            }

            return $this->render('create', [
                'model' => $model,
                'categories' => $category_array,
                'discounts' => $discount_array,
                'initialPreview' => [],
                'initialConfig' => [],
                'tovar_id' => ''
            ]);
        }

        public function actionUpdate($id)
        {
            $model = new TovarForm;
            $tovar = Tovar::findOne(['id' => $id]);

            if($model->load(Yii::$app->request->post())){
                $model->imageFile = UploadedFile::getInstances($model, 'imageFile');
                $imagePath = $model->upload();
                if ($imagePath !== false){
                    $tovar->name = $model->name;
                    $tovar->description = $model->description;
                    $tovar->count = $model->count;
                    $tovar->category_id = $model->category_id;
                    $tovar->discount_id = $model->discount_id;
                    $tovar->price = $model->price;
                    
                    if($imagePath){
                        $image = json_decode($tovar->url_image, true);
                        $imagePath = array_merge($image, $imagePath);
                        $tovar->url_image = json_encode($imagePath);
                    } 
                    if($tovar->save()){
                        Yii::$app->session->setFlash('success', 'Товар оновлено в БД');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Помилка оновлення товару в БД');
                }
                return $this->redirect(['tovar/index']);
            }

            $model->name = $tovar->name;
            $model->description = $tovar->description;
            $model->count = $tovar->count;
            $model->price = $tovar->price;
            $model->category_id = $tovar->category_id;
            $model->discount_id = $tovar->discount_id;
 
            $categories = Category::find()->all();
            foreach($categories as $category) {
                $category_array[$category->id] = $category->name;
            }

            $discounts = Discount::find()->all();
            $discount_array = [];
            foreach($discounts as $discount){
                $discount_array[$discount->id] = $discount->name;
            }

            $images = json_decode($tovar->url_image, true);
           
            $initialPreview = [];
            $initialConfig = [];

            foreach($images as $image){
                $initialPreview[] = '../../' . $image;
                $initialConfig[] = [
                    'key' => $image
                ];
            }
        
            return $this->render('create', [
                'model' => $model,
                'categories' => $category_array,
                'discounts' => $discount_array,
                'initialPreview' => $initialPreview,
                'tovar_id' => $tovar->id,
                'initialConfig' => $initialConfig,
            ]);
        }

        public function actionFileDeleteTovar($id)
        {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;// формат відповіді
            
            if (isset($_POST['key'])){
                $image = $_POST['key'];
                
                unlink($image);
                
                $tovar = Tovar::findOne(['id' => $id]);
                $images = json_decode($tovar->url_image, true);
                $result = [];

                foreach($images as $value){
                    if($image != $value){
                        $result[] = $value;
                    }
                }
                
                $tovar->url_image = json_encode($result);
                $tovar->save();
            }
            return true;
        }

        public function actionDelete($id)
        {
            $tovar = Tovar::findOne(['id' => $id]);
            $images = json_decode($tovar->url_image, true);
          
            if($tovar->delete(['id' => $id])) {
                foreach($images as $image){
                    unlink($image);
                }

                Yii::$app->session->setFlash('success', "Товар: < {$tovar->name} > видалено з БД");
            } else {
                Yii::$app->session->setFlash('error', 'Помилка видалення товару з БД');
            }

            return $this->redirect(['tovar/index']);
        }


        public function actionView($id)
        {
            $tovar = Tovar::findOne(['id' => $id]);
            $images = json_decode($tovar->url_image);

            return $this->render('view', [
                'tovar' => $tovar,
                'images' => $images
            ]);
        }
    }