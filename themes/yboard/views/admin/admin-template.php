<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"><!-- Head -->
    <head>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
            <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
            <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
            <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/admin.js"></script>
            <meta charset="utf-8" >

                <title><?php echo  $this->pageTitle ?></title>

                <meta name="description" content="Dashboard" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <link rel="shortcut icon" href="<?php echo Yii::app()->theme->baseUrl; ?>/img/favicon.png" type="image/x-icon" />

                <!-- blueprint CSS framework -->
                <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" media="screen, projection" />
                <!--Basic Styles-->
                <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.css" rel="stylesheet" />
                <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
                <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/font-awesome.css" rel="stylesheet" />
                <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/weather-icons.css" rel="stylesheet" />

                <!--Fonts-->
                <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/admin.css" rel="stylesheet" type="text/css" />

                <link  type="text/css" rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/admin_theme.css" />
                <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/demo.css" rel="stylesheet" />
                <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/typicons.css" rel="stylesheet" />
                <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/animate.css" rel="stylesheet" />
                <link id="skin-link" href="" rel="stylesheet" type="text/css" />
                <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/yboard.js" ></script>

                <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->


                <!--[if lt IE 8]>
                <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
                <![endif]-->

                <?php Yii::app()->bootstrap->register(); ?>

                <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->

                </head>
                <!-- /Head -->
                <!-- Body -->
                <body>
                    <!-- Navbar -->
                    <div class="navbar">
                        <div class="navbar-inner">
                            <div class="navbar-container">
                                <!-- Navbar Barnd -->
                                <div class="navbar-header pull-left">
                                    <a href="<?php echo Yii::app()->baseUrl; ?>/admin/" class="navbar-brand">
                                        Yboard
                                    </a>
                                </div>
                                <!-- /Navbar Barnd -->

                                <!-- Sidebar Collapse -->
                                <div class="sidebar-collapse" id="sidebar-collapse">
                                    <i class="collapse-icon fa fa-bars"></i>
                                </div>
                                <!-- /Sidebar Collapse -->
                            </div>
                        </div>
                    </div>
                    <!-- /Navbar -->
                    <!-- Main Container -->
                    <div class="main-container container-fluid">
                        <!-- Page Container -->
                        <div class="page-container">
                            <!-- Page Sidebar -->
                            <div class="page-sidebar" id="sidebar">
                                <!-- Sidebar Menu -->
                                <?php
                                $this->widget('zii.widgets.CMenu', array(
                                    'items' => array(
                                        array('label' => '<i class="menu-icon glyphicon glyphicon-home"></i>'
                                            . 'Основное меню<i class="menu-expand"></i>',
                                            'url' => '#',
                                            "items" => array(
                                                array('label' => '<i class="menu-icon glyphicon glyphicon-home"></i>'
                                                    . 'Главная страница',
                                                    'url' => array('/site/index')),
                                                array('label' => 'Добавить объявление',
                                                    'url' => array('/adverts/create')),
                                                array('label' => 'Правила работы',
                                                    'url' => array('/site/page', 'view' => 'about')),
                                                array('label' => 'Обратная связь',
                                                    'url' => array('/site/contact')),
                                                array('url' => Yii::app()->createUrl("login/login"),
                                                    'label' => t("Login"),
                                                    'visible' => Yii::app()->user->isGuest),
                                                array('url' => Yii::app()->createUrl("registration"),
                                                    'label' => t("Register"),
                                                    'visible' => Yii::app()->user->isGuest),
                                                array('url' => Yii::app()->createUrl("registration"),
                                                    'label' => t("Profile"),
                                                    'visible' => !Yii::app()->user->isGuest),
                                                array('url' => Yii::app()->createUrl("login/logout"),
                                                    'label' => t("Logout")
                                                    . ' (' . Yii::app()->user->name . ')',
                                                    'visible' => !Yii::app()->user->isGuest),
                                            ),
                                            'linkOptions' => array('class' => 'menu-dropdown'),
                                        ),
                                        array('label' => "Панель администратора",
                                            'url' => array('/admin')),
                                        array('label' => t('Bulletin') . '<i class="menu-expand"></i>',
                                            'url' => "#",
                                            'items' => array(
                                                array('label' => "Управление",
                                                    'url' => array('/admin/adverts/index')),
                                                array('label' => "Добавить объявление",
                                                    'url' => array('/admin/adverts/create')),
                                            ),
                                            'linkOptions' => array('class' => 'menu-dropdown'),
                                        ),
                                        array('label' => 'Категории', 'url' => array('/admin/category')),
                                        array('label' => t("Pages"), 'url' => array('/cms/cms')),
                                        array('label' => "Настройки", 'url' => array('/admin/default/settings')),
                                        array('label' => "Помощь", 'url' => array('/admin/default/help')),
                                    ),
                                    'htmlOptions' => array('class' => 'nav sidebar-menu'),
                                    'encodeLabel' => FALSE,
                                    'submenuHtmlOptions' => array('class' => 'submenu'),
                                        )
                                );
                                ?>

                                <!-- /Sidebar Menu -->
                            </div>
                            <!-- /Page Sidebar -->
                            <!-- Page Content -->
                            <div class="page-content">
                                <!-- Page Breadcrumb -->
                                <div class="page-breadcrumbs">
                                    <?
                                    if (!isset($this->breadcrumbs))
                                        $this->breadcrumbs = array("Главная");
                                    $this->widget('zii.widgets.CBreadcrumbs', array(
                                        'links' => $this->breadcrumbs,
                                        'homeLink' => '<li><i class="fa fa-home"></i><a href="/yboard/admin/">Админка</a></li>',
                                        'htmlOptions' => array('class' => 'breadcrumb'),
                                        'inactiveLinkTemplate' => '<li><a href="{url}">{label}</a></li>',
                                        'activeLinkTemplate' => '<li><a href="{url}">{label}</a></li>',
                                        'tagName' => 'ul',
                                        'separator' => '',
                                    ));
                                    ?><!-- breadcrumbs -->
                                </div>
                                <!-- /Page Breadcrumb -->
                                <!-- Page Body -->
                                <div class="page-header position-relative">
                                    <div class="header-title">
                                        <h1><?php echo  $this->title ?></h1>
                                    </div>
                                </div>
                                <div class="page-body">
                                    <div id="sidebar">
                                        <?php
                                        $this->widget('zii.widgets.CMenu', array(
                                            //'type' => 'list',
                                            'items' => $this->menu,
                                            'htmlOptions' => array('class' => 'operations'),
                                            'encodeLabel' => false,
                                        ));
                                        ?>
                                    </div>
                                    <?php echo  $content ?>
                                </div>
                                <!-- /Page Body -->
                            </div>
                            <!-- /Page Content -->
                        </div>
                        <!-- /Page Container -->
                        <!-- Main Container -->

                    </div>

                    <!--Basic Scripts-->


                </body><!--  /Body -->
                </html>