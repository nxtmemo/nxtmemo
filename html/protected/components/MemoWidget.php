<?php

// protected/components/MemoWidget.php

class MemoWidget extends CWidget
{
    /**
     * @var CFormModel
     */
    public $data;

    public function run()
    {
		
        $this->render('memoWidget', array('data'=>$this->data));
    }
}
