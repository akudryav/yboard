<?php

/**
 * Контролер сайта включающий отдельные возможности 
 * Процедура установки 
 * Форма контактов 
 */
class SiteController extends Controller {

    /**
     * Declares class-based actions.
     * 
     */
    public $layout = '/main-template';

    public function actions() {
        return array(
            // Дублирование, метода "создание объявления" удален
            // 'create' => 'application.controllers.site.CreateAction',
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            'page' => array(
                'class' => 'CViewAction',
            ),
            'sitemap' => array(
                'class' => 'ext.sitemap.ESitemapAction',
                'importListMethod' => 'getBaseSitePageList',
                'classConfig' => array(
                    array('baseModel' => 'Adverts',
                        'route' => '/adverts/view',
                        'params' => array('id' => 'id')),
                    array('baseModel' => 'Category',
                        'route' => '/adverts/category',
                        'params' => array('cat_id' => 'id')),
                ),
            ),
            'sitemapxml' => array(
                'class' => 'ext.sitemap.ESitemapXMLAction',
                'classConfig' => array(
                    array('baseModel' => 'Adverts',
                        'route' => '/adverts/view',
                        'params' => array('id' => 'id')),
                    array('baseModel' => 'Category',
                        'route' => '/adverts/category',
                        'params' => array('cat_id' => 'id')),
                ),
                //'bypassLogs'=>true, // if using yii debug toolbar enable this line
                'importListMethod' => 'getBaseSitePageList',
            ),
        );
    }

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform actions
                'actions' => array('index', 'error', 'contact', 'bulletin', 'category', 'captcha', 'page', 'advertisement', 'search'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user
                'actions' => array('create'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user
                'actions' => array('importUsers', 'importBulletins'),
                'users' => array('admin'),
            ),
        );
    }

    /**
     * Вывод главной
     * отличается наличием виджета категорий вверху
     */
    public function actionIndex() {
        
        $roots = Category::model()->roots()->findAll();
        
        
        $IndexAdv = new CActiveDataProvider('Adverts', array(
            'criteria' => array(
                'limit' => '10',
                'order' => 'id DESC',
            ))
        );
        
        /*
        $criteria = new CDbCriteria();
        $criteria->limit = 10;
        $criteria->order = 'id desc';
        $IndexAdv = Adverts::model()->findAll($criteria);
         * 
         */
        
        
        
        $this->render('index', array(
            'roots' => $roots,
            'IndexAdv' => $IndexAdv,
        ));
    }

    public function actionInstall() {
        global $CONFIG; // Путь к файлу конфигурации для его изменения
        $this->layout = "/install-layout";
        $db_error = false;
        $error = false;
        $model = new InstallForm;

        if ( is_file( dirname($CONFIG)."/install" ) ) {

            if (!is_writable($CONFIG)) {
                $model->addError("site_name", "Файл " . $CONFIG . " должен быть доступен для записи");
            }

            if (!is_writable(Yii::getPathOfAlias('application.config.settings') . ".php")) {
                $model->addError("site_name", "Файл " 
                        .Yii::getPathOfAlias('application.config.settings') . ".php" 
                        . " должен быть доступен для записи");
            }

            if (!is_writable(Yii::getPathOfAlias('application.runtime'))) {
                $model->addError("site_name", "папка " 
                        .Yii::getPathOfAlias('application.runtime') 
                        . " должена быть доступена для записи");
            }

            if (!is_writable(Yii::app()->basePath . "/../assets")) {
                $model->addError("site_name", "папка /assets должена быть доступена для записи");
            }
            
            if( ini_get( "short_open_tag" ) === "Off" or !ini_get( "short_open_tag" ) ){
                $error = t("Your configuration requires changes.").t("
short_open_tag option must be enabled in the php.ini or another method available");
            }

            if (isset($_POST['InstallForm']) and !$error) {
                $model->attributes = $_POST['InstallForm'];

                // данные Mysql 
                $server = trim(stripslashes($_POST['InstallForm']['mysql_server']));
                $username = trim(stripslashes($_POST['InstallForm']['mysql_login']));
                $password = trim(stripslashes($_POST['InstallForm']['mysql_password']));
                $db_name = trim(stripslashes($_POST['InstallForm']['mysql_db_name']));

                // данные пользователя                     
                if (!$model->validate() or $model->userpass !== $model->userpass2) {
                    $model->addError('userpass2', "Пароли не совпадают");
                }

                if (!$model->errors) {
                    $db_con = mysqli_connect($server, $username, $password) or $db_error = mysqli_error();
					mysqli_set_charset($db_con, "utf8");
                    mysqli_select_db($db_con, $db_name) or $db_error = mysqli_error($db_con);
                }

                if (!$db_error and ! $model->errors) {
                    $config_data = require $CONFIG;



                    $dump_file = file_get_contents(Yii::getPathOfAlias('application.data.install') . '.sql');

                    // Сохранение данных о пользователе 
                    $dump_file.=" INSERT INTO `users` 
                                    (`username`, `password`, `email`, `activkey`, `superuser`, `status`)     VALUES "
                            . "('" . $model->username . "', '" . Yii::app()->user->crypt($model->userpass) . "', "
                            . "'" . $model->useremail . "', '" . Yii::app()->user->crypt(microtime() . $model->userpass) . "',"
                            . " 2, 1);";

                    mysqli_multi_query($db_con, $dump_file) or $db_error = mysqli_error($db_con);

                    if (!$db_error) {
                        // Заполнение конфигурации
                        $config_data['components']['db'] = array(
                            'connectionString' => 'mysql:host=' . $server . ';dbname=' . $db_name,
                            'emulatePrepare' => true,
                            'username' => $username,
                            'password' => $password,
                            'charset' => 'utf8',
                            'tablePrefix' => '',
                        );
                        $config_data['name'] = trim(stripslashes($_POST['InstallForm']['site_name']));
                        $config_data['params'] = "require";

                        $config_array_str = var_export($config_data, true);
                        $config_array_str = str_replace("'params' => 'require',", "'params' => require 'settings.php',", $config_array_str);
                        //Сохранение конфигурации 
                        file_put_contents($CONFIG, "<?php return " . $config_array_str . " ?>");

                        // Сохранение настроек
                        $settings = new ConfigForm(Yii::getPathOfAlias('application.config.settings') . ".php");
                        $settings->updateParam('adminEmail', $model->useremail);
                        $settings->saveToFile();
                        
                        unlink( dirname($CONFIG)."/install" );

                        $this->redirect(array('site/index'));
                    }
                }
            }

            $this->render('install', array('model' => $model, 'db_error' => $db_error, 'error' => $error));
        } else {
            $this->redirect(array('site/index'));
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        //$this->layout = "/install-layout";
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionAbout() {
        $this->render('pages/about');
    }

    /**
     * Displays the contact page
     * @param int $id User's id
     */

    public function actionView($id) {
        $model = $this->loadAdvert($id);
        $model->views++;
        $model->disableBehavior('CTimestampBehavior');
        $model->save();
        $this->render('bulletin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadAdvert($id) {
        $model = loadAdvert::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadCategory($id) {
        $model = Category::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadUser($id) {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function getBaseSitePageList() {

        $list = array(
            array(
                'loc' => Yii::app()->createAbsoluteUrl('/'),
                'frequency' => 'weekly',
                'priority' => '1',
            ),
            array(
                'loc' => Yii::app()->createAbsoluteUrl('/site/contact'),
                'frequency' => 'yearly',
                'priority' => '0.8',
            ),
            array(
                'loc' => Yii::app()->createAbsoluteUrl('/site/page', array('view' => 'about')),
                'frequency' => 'monthly',
                'priority' => '0.8',
            ),
            array(
                'loc' => Yii::app()->createAbsoluteUrl('/site/page', array('view' => 'privacy')),
                'frequency' => 'yearly',
                'priority' => '0.3',
            ),
        );
        return $list;
    }

}


