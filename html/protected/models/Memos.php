<?php

/**
 * This is the model class for table "tbl_memos".
 *
 * The followings are the available columns in table 'tbl_memos':
 * @property integer $txid
 * @property string $account
 * @property integer $timestamp
 * @property string $tags
 * @property string $message
 */
class Memos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_memos';
	}

	public function getAlias() {


		$aliasQuery = Yii::app()->db->createCommand();

		$aliasQuery->select('alias');
		$aliasQuery->from('tbl_users');
		$aliasQuery->where("accountRS = :acc", array(':acc'=>$this->account));
		$aliasQuery->limit(1);

		$aliasUser = $aliasQuery->queryRow()['alias'];

		$url = Yii::app()->params['nxt_prot'] . '://' . Yii::app()->params['nxt_host'] . ':' . Yii::app()->params['nxt_port'] . '/nxt?';  

		$query = array();
		$query['requestType'] = 'getAliases';
		$query['account'] = $this->account;

		$ch = curl_init($url . http_build_query($query));

	        curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        	$result = curl_exec($ch);
	        curl_close($ch);

		$array = json_decode($result);

		foreach ($array->aliases as $alias) {

			if($alias->aliasName == $aliasUser) {
				$this->alias = $aliasUser;
				return true;
			}
		}

		$this->alias = '';
		return false;
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('txid, account, alias, timestamp, tags, message', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'txid' => 'Txid',
			'account' => 'Account',
			'alias' => 'Alias',
			'timestamp' => 'Timestamp',
			'tags' => 'Tags',
			'message' => 'Message',
		);
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('txid',$this->txid);
		$criteria->compare('account',$this->account,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('timestamp',$this->timestamp);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('message',$this->message,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Memos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
