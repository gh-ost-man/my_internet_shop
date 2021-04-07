<?php

    namespace backend\controllers;

    use Yii;
    use yii\web\Controller;
    use yii\data\ActiveDataProvider;
    use yii\filters\AccessControl;

    use common\models\User;

    class AdminController extends Controller
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
                            'roles' => ['admin', 'owner'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['index'],
                            'roles' => ['user', 'manager'],
                        ],
                    ],
                ],
            ];
        }

        public function actionIndex()
        {
            $role = Yii::$app->AuthManager->Roles;
            $role_array = [];
            foreach($role as $key => $value){
                $role_array[$key] = $key; 
            }
           
            $users = User::find()->asArray()->all();
            
            $user_array = [];
            foreach($users as $user){
                if(array_keys(Yii::$app->AuthManager->getRolesByUser($user['id'])) != null){
                    $role = array_keys(Yii::$app->AuthManager->getRolesByUser($user['id']))[0];
                } else {
                    $role = '';
                }
                $user_array[] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'role' => $role 
                ];
            }            

        
            return  $this->render('index', [
                'user_array' => $user_array,
                'role_array' => $role_array
            ]);
        }

        public function actionView($id)
        {
            $role = Yii::$app->AuthManager->Roles;
            $role_array = [];
            foreach($role as $key => $value){
                $role_array[$key] = $key; 
            }
           
            $user = User::findOne(['id' => $id]);
            
            if(array_keys(Yii::$app->AuthManager->getRolesByUser($id)) != null){
                $role = array_keys(Yii::$app->AuthManager->getRolesByUser($id))[0];
            } else {
                $role = '';
            }

        
            return  $this->render('view', [
                'user' => $user,
                'role' => $role,
                'role_array' => $role_array
            ]);
        }

        public function actionChangeRole()
        {
            if ($_POST['id'] != '' && $_POST['role'] != ''){
                $auth = Yii::$app->authManager;
                
                if(array_keys(Yii::$app->AuthManager->getRolesByUser($_POST['id'])) != null){
                    $role_old = array_keys(Yii::$app->AuthManager->getRolesByUser($_POST['id']))[0];
    
                    $role_old = $auth->getRole($role_old);
                    Yii::$app->AuthManager->revoke($role_old, $_POST['id']);
                } 
                $role_new = $auth->getRole($_POST['role']);
                $auth->assign($role_new, $_POST['id']);
            }
            return false;
        }

        public function actionDelete($id)
        {
            $user = User::findOne(['id' => $id]);
          
            if($user->delete(['id' => $id])) {
                Yii::$app->session->setFlash('success', "Користувача: < {$user->username} > видалено з БД");
                Yii::$app->AuthManager->revokeAll($id);
            } else {
                Yii::$app->session->setFlash('error', 'Помилка видалення користувача з БД');
            }
            return $this->redirect(['admin/index']);
        }
    }