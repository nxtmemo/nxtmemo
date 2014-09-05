<?php

// protected/components/ProfileWidget.php

class ProfileWidget extends CWidget {
	/**
	 * @var CFormModel
	 */
	public $data;

	public function run() {

		$this -> render('profileWidget', array('data' => $this -> data));
	}

}
