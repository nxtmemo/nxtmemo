<?php

/**
 * This is the model class for table "tbl_users".
 *
 * The followings are the available columns in table 'tbl_users':
 * @property string $accountRS
 * @property string $alias
 * @property integer $login_timestamp
 */
class Users extends CActiveRecord {
	public $aliases;
	public $aliasData;

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'tbl_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array( array('accountRS, login_timestamp', 'required'), array('login_timestamp', 'numerical', 'integerOnly' => true), array('accountRS', 'length', 'max' => 25), array('alias', 'length', 'max' => 1000),
		// The following rule is used by search().
		// @todo Please remove those attributes that should not be searched.
		array('accountRS, alias, login_timestamp', 'safe', 'on' => 'search'), );
	}

	public function getAliases() {

		$this -> aliases = array();

		if ($this -> alias) {
			$this -> aliases[$this -> alias] = $this -> alias;
		}

		$this -> aliases[0] = 'No alias - ' . $this -> accountRS;

		$url = Yii::app() -> params['nxt_prot'] . '://' . Yii::app() -> params['nxt_host'] . ':' . Yii::app() -> params['nxt_port'] . '/nxt?';

		$query = array();
		$query['requestType'] = 'getAliases';
		$query['account'] = $this -> accountRS;

		$ch = curl_init($url . http_build_query($query));

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		$array = json_decode($result);

		foreach ($array->aliases as $alias) {

			if ($alias -> aliasName != $this -> alias) {
				$this -> aliases[$alias -> aliasName] = $alias -> aliasName;
			}
		}

		return $this -> aliases;

	}

	public function getAliasData() {

		$this -> aliasData = array();

		$url = Yii::app() -> params['nxt_prot'] . '://' . Yii::app() -> params['nxt_host'] . ':' . Yii::app() -> params['nxt_port'] . '/nxt?';

		$query = array();
		$query['requestType'] = 'getAlias';
		$query['aliasName'] = $this -> alias;

		$ch = curl_init($url . http_build_query($query));

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		$array = json_decode($result);

		if (!empty($array) && isset($array -> aliasURI)) {
			$this -> aliasData = json_decode($array -> aliasURI);
		}

		return $this -> aliasData;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array('accountRS' => 'Account Rs', 'alias' => 'Alias', 'login_timestamp' => 'Login Timestamp', );
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria -> compare('accountRS', $this -> accountRS, true);
		$criteria -> compare('alias', $this -> alias, true);
		$criteria -> compare('login_timestamp', $this -> login_timestamp);

		return new CActiveDataProvider($this, array('criteria' => $criteria, ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

}
