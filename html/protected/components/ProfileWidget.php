<?php

// protected/components/ProfileWidget.php

class ProfileWidget extends CWidget {
	/**
	 * @var CFormModel
	 */
	public $data;
	public $alias;

	public function run() {

		$this -> render('profileWidget', array('data' => $this -> data, 'alias' => $this -> alias));
	}

}
