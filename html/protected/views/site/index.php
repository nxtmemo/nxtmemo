<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

foreach ($memos as $memo) {

	if(Blacklist::lookup($memo['account'], $memo['txid'])) {
		continue;
	}

	$url = $this->createURL('site/index',array('s'=>$memo['message']));
	$url = $this->createURL('/');

	$memo['message'] =  mb_convert_encoding($memo['message'], 'UTF-8', 'UTF-8');
        $memo['message'] = htmlentities($memo['message'], ENT_QUOTES, 'UTF-8');

        $memo['message'] = preg_replace('/(\#)([^\s]+)/', '<a href="' . $url . '/tag/$2">$2</a>', $memo['message']);
	$memo['message'] = preg_replace('/(\@)([^\s]+)/', '<a href="' . $url . '/alias/$2">$2</a>', $memo['message']);

	$memo['message'] = autolink($memo['message'], 20);

    $this->widget('MemoWidget', array(
        'data' => $memo,
    ));

}

if($page > 1) {
?>

<div class="pagination" id="prev">
<a href="?page=<?php echo $page-1; ?>">Newer posts</a>
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
<div style="clear:both;"></div>
