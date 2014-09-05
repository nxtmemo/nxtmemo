<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class PanelForm extends CFormModel {
	public $alias;
	public $aliases;
	public $name;
	public $email;
	public $subject;
	public $body;
	public $verifyCode;

	/**
	 * Declares the validation rules.
	 */
	public function rules() {
		return array( array('alias', 'checkAliasOwner'), );
	}

	public function checkAliasOwner($attribute) {

		if ($this -> alias !== '0') {

			$url = Yii::app() -> params['nxt_prot'] . '://' . Yii::app() -> params['nxt_host'] . ':' . Yii::app() -> params['nxt_port'] . '/nxt?';

			$query = array();
			$query['requestType'] = 'getAlias';
			$query['aliasName'] = $this -> alias;

			$ch = curl_init($url . http_build_query($query));

			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			$obj = json_decode($result);

			if (!isset($obj -> accountRS) || $obj -> accountRS !== Yii::app() -> user -> name) {

				$this -> addError($attribute, 'Alias does not exist or belong to you.');
			}
		} else {
			$this -> alias = '';
		}

	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels() {
		return array('alias' => 'Choose your alias', );
	}

}
