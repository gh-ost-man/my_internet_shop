<?php 
    namespace backend\controllers;
    
    use Yii;
    use yii\web\Controller;
    use yii\web\UploadedFile;
    use yii\data\ActiveDataProvider;

    use backend\models\TovarForm;
    use backend\models\Category;
    use backend\models\Tovar;
   
    class SelectDataController extends Controller
    {
        public function actionFileDeleteTovar($id)
        {
            Yii::$arr->response->format = \yii\web\Response::FORMAT_JSON;
            
            if (isset($_POST['key'])){
                $image = $_POST['key'];
                
                unlink($_POST['key']);
                
                $tovar = Tovar::findOne(['id' => $id]);
                $images = json_decode($tovar->url_image, true);
                
                $result = [];

                foreach ($images as $value){
                    if ($image != $value){
                        $result[] = $value;
                    }
                }
                $tovar->url_image = json_encode($result);
                $tovar->save();
            }
            return true;
        }
    }