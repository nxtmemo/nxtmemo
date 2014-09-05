<?php
// protected/components/views/memoWidget.php
?>
<blockquote class="memo">
<p><?php echo $data['message']; ?></p>
    <footer>
        <cite>
        	<?php if($data['alias']) { ?>
        	     <a href="<?php echo Yii::app()->createURL('site/index',array('alias'=>$data['alias'])); ?>"><?php echo $data['alias']; ?></a> (<a href="<?php echo $accurl = Yii::app()->createURL('site/index',array('a'=>$data['account']));; ?>"><?php echo $data['account']; ?></a>),
        	<?php } else { ?>
        		 <a href="<?php echo $accurl = Yii::app()->createURL('site/index',array('a'=>$data['account']));; ?>"><?php echo $data['account']; ?></a>,
        	<?php } ?>
        	 <?php echo date("F j, Y, H:i", $data['timestamp']); ?></cite>
    </footer>
</blockquote>
<?php if(!CHttpRequest::getParam('t')) { ?>
<div class="permalink"><a href="<?php echo Yii::app()->createURL('site/index',array('t'=>$data['txid'])); ?>"><small>Permalink</small></a></div>
<?php } ?>

