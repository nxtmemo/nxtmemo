<?php

class SiteController extends Controller
{
    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }


    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index','page','login','logout'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'panel' action
                'actions' => array('panel'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

        /**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'

		$memos = array();
		$search = CHttpRequest::getParam('s', '');
		$acc = CHttpRequest::getParam('a', '');
		$tx = CHttpRequest::getParam('t', '');
		$alias = CHttpRequest::getParam('alias', '');

		$page = (int) CHttpRequest::getParam('page', 1);

		$memos = Yii::app()->db->createCommand();

		$memos->select('*');
		$memos->from('tbl_memos');

		if($tx) {

        		$memos->where("txid = :tx", array(':tx'=>$tx));

		} else if($search) {

		    $memos->where("message LIKE '%' :tag '%' OR tags LIKE '%' :tag '%' OR account LIKE '%' :tag '%' OR alias LIKE '%' :tag '%'", array(':tag'=>$search));	

		} else if($acc) {

		    $memos->where("account = :acc", array(':acc'=>$acc));

		} else if($alias) {

		    $memos->where("alias LIKE '%' :alias '%' OR message LIKE '%' :alias '%' OR tags LIKE '%' :alias '%'", array(':alias'=>$alias));
		}


		$memos->order('timestamp DESC');

		$memos->limit(Yii::app()->params['pageSize']);
		$memos->offset(($page - 1) * Yii::app()->params['pageSize']);

		$result = $memos->queryAll();


		$paginate = false;
		if(count($result) == Yii::app()->params['pageSize']) {
			$paginate = $page + 1;
		}

		$this->render('index',array('memos'=>$result,'paginate'=>$paginate,'page'=>$page));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the panel page
	 */
	public function actionPanel()
	{

		$user = Users::model()->findByPk(Yii::app()->user->name);

		$model=new PanelForm;
		if(isset($_POST['PanelForm']))
		{
			$model->attributes=$_POST['PanelForm'];
			if($model->validate())
			{
				$user->alias = $model->alias;
				$user->save();
			}
		}

		$model->aliases = $user->getAliases();


		$this->render('panel',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
