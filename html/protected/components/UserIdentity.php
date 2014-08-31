<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	
	public $token;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		
		echo $this->token;
		
		//$this->token = $token;
		
		$url = Yii::app()->params['nxt_prot'] . '://' . Yii::app()->params['nxt_host'] . ':' . Yii::app()->params['nxt_port'] . '/nxt?';  
		
		$query = array();
		$query['requestType'] = 'decodeToken';
		$query['token'] = $this->token;		
		$query['website'] = Yii::app()->params['nxt_token_website'];
		$ch = curl_init($url . http_build_query($query));
        
        curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        
		//print_r($result);
		$obj = json_decode($result);
		
		
		if(!isset($obj->errorCode) && $obj->valid == 'true') {
			
			if(($obj->timestamp + Yii::app()->params['nxt_genesistime']) > (time() - Yii::app()->params['tokenMaxAge'])) {
					
				$this->setState('name', $obj->accountRS);
					
				//try to load model with available id i.e. unique key
				$user = Users::model()->findByPk($obj->accountRS);  
				
				//now check if the model is null
				if(!$user) $user = new Users();
				
				$user->accountRS = $obj->accountRS;
				$user->login_timestamp = ($obj->timestamp + Yii::app()->params['nxt_genesistime']);
				
				//save
				$user->save();	
					
					
				return true;	
			}
		}
		
		return false;
	}
	
}