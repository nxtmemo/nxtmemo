<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $token;
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// token is required
			array('token', 'required'),

			// token needs to be authenticated
			array('token', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'token'=>'NXT Token for ' . Yii::app()->params['nxt_token_website'],
		);
	}

	/**
	 * Authenticates the token.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity('username','password');
			$this->_identity->token=$this->token;


			if($this->_identity->authenticate()) {

				Yii::app()->user->login($this->_identity);
				Yii::app()->getController()->redirect(array('site/panel'));

			} else {
				$this->addError('token','Token invalid or too old.');
			}
		}
	}

	/**
	 * @return boolean whether login is successful
	 */
	public function login()
	{

		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity();
			$this->_identity->token = $this->token;

			echo $this->_identity->token;

			if($this->_identity->authenticate()) {

				Yii::app()->user->login($this->_identity,0);
				return true;
			} else {

				return false;
			}
		}
	}
}
