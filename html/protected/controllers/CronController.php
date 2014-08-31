<?php

class CronController extends Controller
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
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index'),
                //Only localhost can start cronjob
                'ips' => array('127.0.0.1'),
            ),
            array('deny', // deny all users
                'ips' => array('*'),
            ),
        );
    }


    public function actionIndex()
	{

		$key = CHttpRequest::getParam('key', '');

		if($key !== Yii::app()->params['cronKey']) {
                        echo "Not allowed";
			exit;
		}

		$index=Params::model()->findByPk('tx_firstIndex');

		$url = Yii::app()->params['nxt_prot'] . '://' . Yii::app()->params['nxt_host'] . ':' . Yii::app()->params['nxt_port'] . '/nxt?';  

		$query = array();
		$query['requestType'] = 'getAccountTransactions';
		$query['account'] = Yii::app()->params['nxt_account'];
		$query['firstIndex'] = $index->attributes['value'];
		$query['lastIndex'] = '999999999';
		$query['type'] = '1';
		$query['subtype'] = '0';
		$ch = curl_init($url . http_build_query($query));

                curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($ch);
                curl_close($ch);

		$array = json_decode($result);

		$memos = array();


		if(!isset($array->transactions)) {
		    echo "No transactions found";
		    exit;
		}

		//Update firstIndex
		if(count($array->transactions) > 0) {
		    $newindex = $index->attributes['value'] + count($array->transactions);
		    $index->updateByPk('tx_firstIndex', array('value'=>$newindex));
		}



		foreach($array->transactions as $tx) {

  			$message = isset($tx->attachment->message) ? $tx->attachment->message : '';

        		if (mb_detect_encoding($message, "ASCII, UTF-8") === FALSE) {

				$message = hex2bin($tx->attachment->message);
			}


			if($tx->recipientRS == Yii::app()->params['nxt_account'] && !empty($message) && mb_detect_encoding($message, "ASCII, UTF-8") !== FALSE) {

				$memo = new Memos();
				$memo->txid = $tx->transaction;
                		$memo->account = $tx->senderRS;
				$memo->timestamp = $tx->timestamp + Yii::app()->params['nxt_genesistime'];
				$memo->tags = '';
				$memo->getAlias();
				$memo->message = $message;
				if($memo->save()) {
					echo "Memo saved successfully <br/>";
				} else {
					echo "Error!";
                                }
			}
		}
	}



	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
