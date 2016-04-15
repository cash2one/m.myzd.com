<?php

class UserController extends MobileController {

    public $current_page;

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('register', 'ajaxRegister', 'login', 'commonProblem', 'index', 'captcha', 'captchaCode', 'ajaxForgetPassword'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('logout', 'view', 'changePassword'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'maxLength' => 6,
                'offset' => 0,
                'testLimit' => 0,
                'height' => 34
            ),
        );
    }

    //进入患者注册页面
    public function actionRegister() {
        $userRole = StatCode::USER_ROLE_PATIENT;
        $form = new UserRegisterForm();
        $form->role = $userRole;
        $form->terms = 1;

        $this->performAjaxValidation($form);
        $this->render('register', array(
            'model' => $form,
        ));
    }

    //无刷新注册
    public function actionAjaxRegister() {
        $output = array('status' => 'no');
        $userRole = StatCode::USER_ROLE_PATIENT;
        $form = new UserRegisterForm();
        $form->role = $userRole;
        $form->terms = 1;
        $this->performAjaxValidation($form);
        if (isset($_POST['UserRegisterForm'])) {
            $values = $_POST['UserRegisterForm'];
            $form->setAttributes($values, true);
            $userMgr = new UserManager();
            $userMgr->registerNewUser($form);
            if ($form->hasErrors() === false) {
                // success                
                $loginForm = $userMgr->autoLoginUser($form->username, $form->password, $userRole, 1);
                $output['status'] = 'ok';
            }
            $output['error'] = $form->getErrors();
        }
        $this->renderJsonOutput($output);
    }

    public function actionView() {
        $user = $this->getCurrentUser();
        //print_r($user);exit;
        $booking = new Booking();
        $bookingModels = $booking->getCountBkStatusByUserId($user['id']);
        $output = array();
        foreach ($bookingModels as $model) {
            $data = new stdClass();
            //$data->id =$model->id;
            $data->num = $model->num;
            $data->bkStatus = $model->bk_status;
            $data->bkStatusText = $model->getBkStatus();
            $output[] = $data;
        }
        $this->render('view', array('user' => $user, 'data' => $output));
    }

    public function actionCommonProblem() {
        $this->render('commonProblem');
    }

    public function actionIndex($page) {
        $this->current_page = $page;
        $this->render('index');
    }

    public function actionCaptchaCode() {
        $model = new UserDoctorMobileLoginForm;
        $values = $_POST['UserDoctorMobileLoginForm'];
        $model->setAttributes($values, true);
        echo (CActiveForm::validate($model));
        Yii::app()->end();
    }

    //登陆
    public function actionLogin() {
        $returnUrl = $this->getReturnUrl($this->createUrl('user/view'));
        $user = $this->getCurrentUser();
        print_r($_POST['UserDoctorMobileLoginForm']);
        exit;
        //用户已登陆 直接进入个人中心
        if (isset($user)) {
            $this->redirect(array('view'));
        }
        $form = new UserDoctorMobileLoginForm();
        $form->role = StatCode::USER_ROLE_PATIENT;
        if (isset($_POST['UserDoctorMobileLoginForm'])) {
            $values = $_POST['UserDoctorMobileLoginForm'];
            $form->setAttributes($values, true);
            $form->autoRegister = true;
            $userMgr = new UserManager();
            $isSuccess = $userMgr->mobileLogin($form);
            //var_dump($returnUrl);exit;
            if ($isSuccess) {
                $url = $_POST['returnUrl'];
                // $user = $this->getCurrentUser();
                $this->redirect($url);
            }
        }
        if (isset($_GET['ajax']) && $_GET['ajax'] === 'login-form') {
            echo CJSON::decode(CJSON::encode(CActiveForm::validate($model)));
            exit;
        }
        //失败 则返回登录页面
        $this->render("login", array(
            'model' => $form,
            'returnUrl' => $returnUrl
        ));
    }

    //修改密码
    public function actionChangePassword() {
        $user = $this->getCurrentUser();
        $form = new UserPasswordForm('new');
        $form->initModel($user);
        $this->performAjaxValidation($form);
        if (isset($_POST['UserPasswordForm'])) {
            $form->attributes = $_POST['UserPasswordForm'];
            $userMgr = new UserManager();
            $success = $userMgr->doChangePassword($form);
            if ($this->isAjaxRequest()) {
                if ($success) {
                    Yii::app()->user->logout();
                    //do anything here
                    echo CJSON::encode(array(
                        'status' => 'true'
                    ));
                    Yii::app()->end();
                } else {
                    $error = CActiveForm::validate($form);
                    if ($error != '[]') {
                        echo $error;
                    }
                    Yii::app()->end();
                }
            } else {
                if ($success) {
                    Yii::app()->user->logout();
                    $this->setFlashMessage('user.password', '密码修改成功！');
                }
            }
        }
        $this->render('changePassword', array(
            'model' => $form
        ));
    }

    //进入忘记密码页面
    public function actionForgetPassword() {
        $form = new ForgetPasswordForm();
        $this->render('forgetPassword', array(
            'model' => $form,
        ));
    }

    //忘记密码功能
    public function actionAjaxForgetPassword() {
        $output = array('status' => 'no');
        $form = new ForgetPasswordForm();
        if (isset($_POST['ForgetPasswordForm'])) {
            $form->attributes = $_POST['ForgetPasswordForm'];
            if ($form->validate()) {
                $userMgr = new UserManager();
                $user = $userMgr->loadUserByUsername($form->username);
                if (isset($user)) {
                    $success = $userMgr->doResetPassword($user, null, $form->password_new);
                    if ($success) {
                        $output['status'] = 'ok';
                    } else {
                        $output['errors']['errorInfo'] = '密码修改失败!';
                    }
                } else {
                    $output['errors']['username'] = '用户不存在';
                }
            } else {
                $output['errors'] = $form->getErrors();
            }
        }

        $this->renderJsonOutput($output);
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect('login');
    }

}
