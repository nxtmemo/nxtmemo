<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app() -> request -> baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app() -> request -> baseUrl; ?>/css/form.css" />
	
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css" rel="stylesheet">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<title><?php echo CHtml::encode($this -> pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	
		<div id="logo"><a href="<?php echo $this -> createURL('site/index'); ?>"><?php echo CHtml::encode(Yii::app() -> name); ?></a></div>
		<div id="menu">
			<a href="<?php echo $this -> createURL('site/panel'); ?>">[My account]</a>
			<a href="<?php echo $this -> createURL('site/page', array('view' => 'setup')); ?>">[Alias setup]</a>
			<a href="<?php echo $this -> createURL('/site/page', array('view' => 'about')); ?>">[FAQ]</a>
		    <?php if(!Yii::app()->user->isGuest) { ?>
		    <a href="<?php echo $this -> createURL('site/logout'); ?>">[Logout]</a>	
		    <?php } ?>
		</div>
		<div class="clearfix"></div>
		<div style="text-align:center;">Send your messages to <?php echo Yii::app() -> params['nxt_account']; ?> (alias <a href="<?php echo $this -> createURL('site/index', array('alias' => Yii::app() -> params['nxt_alias'])); ?>"><?php echo Yii::app() -> params['nxt_alias']; ?></a>)</div>
	 <form action="<?php echo $this -> createURL('site/index'); ?>" method="POST">
	    <div class="input-group" style="margin:25px;">
	    	
	    	<?php
			$value = CHttpRequest::getParam('t', '');
			$value = CHttpRequest::getParam('s', '');
			$value = CHttpRequest::getParam('a', $value);
			$value = CHttpRequest::getParam('alias', $value);
			?>
	    	
	    	<input class="form-control" type="text" name="s" placeholder="Enter search term, alias or NXT account" value="<?php echo $value; ?>" />
				<span class="input-group-btn">
					<button id="buttonLookup2" type="submit" class="btn btn-primary">
						Go
					</button>
				</span>
			</div>
	    </form>
	<!-- header -->
	

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this -> widget('zii.widgets.CBreadcrumbs', array('links' => $this -> breadcrumbs, )); ?><!-- breadcrumbs -->
	<?php endif ?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		nxtmemo.com
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
