<?php
/* @var $this SiteController */

$this -> pageTitle = $title;
?>
<div class="row">
	<div class="col-md-6">
		<?php

		foreach ($memos as $memo) {
		
			if(Blacklist::lookup($memo['account'], $memo['txid'])) {
				continue;
			}
		
			$url = $this->createURL('site/index',array('s'=>$memo['message']));
			$url = $this->createURL('/');
		
			$memo['message'] = Helper::htmlOutput($memo['message']);
		
		    $memo['message'] = preg_replace('/(\#)([^\s]+)/', '<a href="' . $url . '/tag/$2">#$2</a>', $memo['message']);
			$memo['message'] = preg_replace('/(\@)([^\s]+)/', '<a href="' . $url . '/alias/$2">@$2</a>', $memo['message']);
		
			$memo['message'] = autolink($memo['message'], 20);
		
		    $this->widget('MemoWidget', array(
		        'data' => $memo,
		    ));
		
		}

		if($page > 1) {
	?>

		<div class="pagination" id="prev">
			<a href="?page=<?php echo $page - 1; ?>">Newer posts</a>
		</div>
		<?php
		}

		if($paginate) {
	?>
		<div class="pagination" id="next">
			<a href="?page=<?php echo $paginate; ?>">Older posts</a>
		</div>
		<?php
		}
	?>
	</div>

	<div class="col-md-6">
		<?php
		if ($aliasData) {
			$this -> widget('ProfileWidget', array('data' => $aliasData, ));
		}
	?>
	</div>

</div>

<div class="clearfix"></div>
