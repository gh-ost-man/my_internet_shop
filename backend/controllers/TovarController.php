<?php 
    namespace backend\controllers;
    
    use Yii;
    use yii\web\Controller;
    use yii\web\UploadedFile;
    use yii\data\ActiveDataProvider;
    use yii\helpers\ArrayHelper;

    use backend\models\TovarForm;
    use backend\models\Category;
    use backend\models\Tovar;
   
    class TovarController extends Controller
    {
        public function actionIndex()
        {
            // $tovar =Tovar::find()->all();

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
            return $this->render('create', [
                'model' => $model,
                'categories' => $category_array,
                'initialPreview' => [],
                'initialConfig' => [],
                'tovar_id' => ''
            ]);
        }

        public function actionUpdate($id)
        {
            $model = new TovarForm;
            $tovar = Tovar::findOne(['id' => $id]);

            $model->name = $tovar->name;
            $model->description = $tovar->description;
            $model->count = $tovar->count;
            $model->price = $tovar->price;
            $model->category_id = $tovar->category_id;
            
            $categories = Category::find()->all();
            foreach($categories as $category) {
                $category_array[$category->id] = $category->name;
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
            foreach($images as $image){
                unlink($image);
            }
            if($tovar->delete(['id' => $id])) {
                Yii::$app->session->setFlash('success', "Товар: < {$tovar->name} > видалено з БД");
            } else {
                Yii::$app->session->setFlash('error', 'Помилка видалення товару з БД');
            }

            return $this->redirect(['tovar/index']);
        }
    }