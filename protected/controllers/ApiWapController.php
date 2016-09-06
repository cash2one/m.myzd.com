<?php

class ApiWapController extends Controller {

    // Members
    /**
     * Key which has to be in HTTP USERNAME and PASSWORD headers 
     */
    Const APPLICATION_ID = 'ASCCPE';

    /**
     * Default response format
     * either 'json' or 'xml'
     */
    private $format = 'json';

    /**
     * @return array action filters
     */
    public function filters() {
        return array();
    }

    public function init() {
        header("Access-Control-Allow-Origin: *");
        //header('Access-Control-Allow-Origin:http://m.mingyizhudao.com');
        header('Access-Control-Allow-Headers: X-Requested-With');
        header('Access-Control-Allow-Origin:http://mingyizhudao.com');    // Cross-domain access.
        header('Access-Control-Allow-Credentials:true');      // 允许携带 用户认证凭据（也就是允许客户端发送的请求携带Cookie）
        return parent::init();
    }

  // Actions
    public function actionList($model) {
        $api = $this->getApiVersionFromRequest();
        // Get the respective model instance
        switch ($model) {
            // 医院列表
            case "hospital":
                echo 1;exit;
                break;
                // 城市列表
            
            default:
                // Model not implemented error
                //$this->_sendResponse(501, sprintf('Error: Mode <b>list</b> is not implemented for model <b>%s</b>', $model));
                $this->_sendResponse(501, sprintf('Error: Invalid request', $model));
                Yii::app()->end();
        }
        // Did we get some results?
        if (empty($output)) {
            // No
            //$this->_sendResponse(200, sprintf('No items where found for model <b>%s</b>', $model));
            $this->_sendResponse(200, sprintf('No result', $model));
        } else {
            $this->renderJsonOutput($output);
            //  header('Content-Type: text/html; charset=utf-8');
            // var_dump($output);
        }
    }

    public function actionView($model, $id) {
        // Check if id was submitted via GET
        if (isset($id) === false) {
            $this->_sendResponse(500, 'Error: Parameter <b>id</b> is missing');
        }
        $output = null;
        $api = $this->getApiVersionFromRequest();
        switch ($model) {
            //科室列表
            case 'subcategory':
                echo 1;exit;
                break;
            
            default:
                $this->_sendResponse(501, sprintf('Mode <b>view</b> is not implemented for model <b>%s</b>', $model));
                Yii::app()->end();
        }
        // Did we find the requested model? If not, raise an error
        if (is_null($output)) {
            $this->_sendResponse(404, 'No result');
        } else {
            //$this->_sendResponse(200, CJSON::encode($output));
            $this->renderJsonOutput($output);
        }
    }

    public function actionCreate($model) {
        $get = $_GET;
        $post = $_POST;
//         if (empty($_POST)) {
//             // application/json
//             $post = CJSON::decode($this->getPostData());
//         } else {
//             // application/x-www-form-urlencoded
//             $post = $_POST;
//         }
//         $api = $this->getApiVersionFromRequest();
//         if ($api >= 4) {
//             $output = array('status' => EApiViewService::RESPONSE_NO, 'errorCode' => ErrorList::BAD_REQUEST, 'errorMsg' => 'Invalid request.');
//         } else {
//             $output = array('status' => false, 'error' => 'Invalid request.');
//         }

//         var_dump($get);var_dump($post);exit;
        switch ($get['model']) {
            // Get an instance of the respective model
            //手机验证码登录
            case 'userDoctorMobileLogin': 
                if (isset($post['UserDoctorMobileLoginForm'])) {
                      $loginType = 'sms';
                      $smsform = new UserDoctorMobileLoginForm();
                      $values = $post['UserDoctorMobileLoginForm'];
                      $smsform->setAttributes($values, true);
                      $smsform->role = StatCode::USER_ROLE_PATIENT;
                      $smsform->autoRegister = false;
                      $userMgr = new UserManager();
                      $isSuccess = $userMgr->mobileLogin($smsform);
                      if ($isSuccess) {
                          $output['status'] = 'ok';
                      } else {
                          $output['errors'] = $smsform->getErrors();
                          $output['loginType'] = $loginType;
                      }
                } else {
                    $output['errorMsg'] = 'Wrong parameters.';
                }
                break;
            //手机密码登录
            case 'userLoginForm':
                if (isset($post['UserLoginForm'])) {
                       $loginType = 'paw';
                       $pawform = new UserLoginForm();
                       $values = $post['UserLoginForm'];
                       $pawform->setAttributes($values, true);
                       $pawform->role = StatCode::USER_ROLE_PATIENT;
                       $pawform->rememberMe = true;
                       $userMgr = new UserManager();
                       $isSuccess = $userMgr->doLogin($pawform);
                       if ($isSuccess) {
                           $output['status'] = 'ok';
                       } else {
                           $output['errors'] = $pawform->getErrors();
                           $output['loginType'] = $loginType;
                       }
                   } else {
                       $output['errorMsg'] = 'Wrong parameters.';
                   }
                break;
          
            default:
                $this->_sendResponse(501, sprintf('Error: Invalid request', $model));
                Yii::app()->end();
        }
        $this->renderJsonOutput($output);
    }

    public function actionUpdate($model, $id) {
        if ($model == 'booking') {
            $bookingMgr = new BookingManager();
            $userId = $this->getCurrentUserId();
            if (empty($userId) || empty($id)) {
                $output['status'] = 'no';
                $output['error_code'] = EApiViewService::RESPONSE_VALIDATION_ERRORS;
                $output['message'] = 'Wrong parameters';
                $this->renderJsonOutput($output);
            }
            $output = $bookingMgr->actionCancelBooking($id, $userId);   
            $this->renderJsonOutput($output);
        }
    }

    public function actionDelete($model, $id) {
        
    }

    private function userLoginRequired($values) {
        if (isset($values['username']) === false || isset($values['token']) === false) {
            if ($this->getApiVersionFromRequest() >= 4) {
                $this->renderJsonOutput(array('status' => EApiViewService::RESPONSE_NO, 'errorCode' => ErrorList::BAD_REQUEST, 'errorMsg' => '没有权限执行此操作'));
            } else {
                $this->_sendResponse(ErrorList::UNAUTHORIZED, '没有权限执行此操作', 'application/json; charset=utf-8');
            }
        }
        $username = $values['username'];
        $token = $values['token'];
        $authMgr = new AuthManager();
        $authUserIdentity = $authMgr->authenticateUserByToken($username, $token);
        if (is_null($authUserIdentity) || $authUserIdentity->isAuthenticated === false) {
            if ($this->getApiVersionFromRequest() >= 4) {
                $this->renderJsonOutput(array('status' => EApiViewService::RESPONSE_NO, 'errorCode' => ErrorList::BAD_REQUEST, 'errorMsg' => '用户名或token不正确'));
            } else {
                $this->_sendResponse(ErrorList::UNAUTHORIZED, '用户名或token不正确', 'application/json; charset=utf-8');
            }
        }
        return $authUserIdentity->getUser();
    }

    private function _sendResponse($status = 200, $body = '', $content_type = 'text/html') {
        // set the status
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        header($status_header);
        // and the content type
        header('Content-type: ' . $content_type);

        // pages with body are easy
        if ($body != '') {
            // send the body
            echo $body;
        }
        // we need to create the body if none is passed
        else {
            // create some body messages
            $message = '';

            // this is purely optional, but makes the pages a little nicer to read
            // for your users.  Since you won't likely send a lot of different status codes,
            // this also shouldn't be too ponderous to maintain
            switch ($status) {
                case 401:
                    $message = 'You must be authorized to view this page.';
                    break;
                case 404:
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;
                case 500:
                    $message = 'The server encountered an error processing your request.';
                    break;
                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
            }

            // servers don't always have a signature turned on 
            // (this is an apache directive "ServerSignature On")
            $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

            // this should be templated in a real-world solution
            $body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
            <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                    <title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
                </head>
                <body>
                    <h1>' . $this->_getStatusCodeMessage($status) . '</h1>
                    <p>' . $message . '</p>
                    <hr />
                    <address>' . $signature . '</address>
                </body>
            </html>';

            echo $body;
        }
        Yii::app()->end();
    }

    private function _getStatusCodeMessage($status) {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    private function _checkAuth() {
        // Check if we have the USERNAME and PASSWORD HTTP headers set?
        if (!(isset($_SERVER['HTTP_X_USERNAME']) and isset($_SERVER['HTTP_X_PASSWORD']))) {
            // Error: Unauthorized
            $this->_sendResponse(401);
        }
        $username = $_SERVER['HTTP_X_USERNAME'];
        $password = $_SERVER['HTTP_X_PASSWORD'];
        // Find the user
        $user = User::model()->find('LOWER(username)=?', array(strtolower($username)));
        if ($user === null) {
            // Error: Unauthorized
            $this->_sendResponse(401, 'Error: User Name is invalid');
        } else if (!$user->validatePassword($password)) {
            // Error: Unauthorized
            $this->_sendResponse(401, 'Error: User Password is invalid');
        }
    }

    private function loadOverseasHospitalJson() {
        $overseasController = new OverseasController();


        $hospitals = array(
            array(
                'id' => 1,
                'name' => '新加坡伊丽莎白医院',
                'url' => '',
                'urlImage' => 'http://mingyihz.oss-cn-hangzhou.aliyuncs.com/static%2Foverseas_sg_elizabeth.jpg'
            ),
            array(
                'id' => 2,
                'name' => '新加坡邱德拔医院',
                'url' => '',
                'urlImage' => 'http://mingyihz.oss-cn-hangzhou.aliyuncs.com/static%2Foverseas_sg_ktph.jpg'
            ),
            array(
                'id' => 3,
                'name' => '新加坡中央医院',
                'url' => '',
                'urlImage' => 'http://mingyihz.oss-cn-hangzhou.aliyuncs.com/static%2Foverseas_sg_sgh.jpg'
            ),
            array(
                'id' => 4,
                'name' => '新加坡国立大学医院',
                'url' => '',
                'urlImage' => 'http://mingyihz.oss-cn-hangzhou.aliyuncs.com/static%2Foverseas_sg_nuh.jpg',
            )
        );
        $output = array('hospitals' => array());
        foreach ($hospitals as $hospital) {
            $obj = new stdClass();
            foreach ($hospital as $key => $value) {
                $obj->{$key} = $value;
                $output['hospitals'][] = $obj;
            }
        }

        return $output;
    }

    private function parseQueryOptions($values) {
        $options = array();
        if (isset($values['offset']))
            $options['offset'] = $values['offset'];
        if (isset($values['limit']))
            $options['limit'] = $values['limit'];
        if (isset($values['order']))
            $options['order'] = $values['order'];
        return $options;
    }

    private function getApiVersionFromRequest() {
        return Yii::app()->request->getParam("api", 1);
    }
    
    /**
     *
     *接收头信息
     *by  20160905
     **/
    private function em_getallheaders()
    {
        foreach ($_SERVER as $name => $value)
        {
            if (substr($name, 0, 5) == 'HTTP_')
            {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }

}