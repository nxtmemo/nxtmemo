<?php
// protected/components/views/profileWidget.php

if (isset($data -> photo_url)) {
	echo '<img class="profilePhoto" src="' . Helper::htmlOutput($data -> photo_url, false) . '" />';
	unset($data -> photo_url);
}

echo '<h3>@' . $alias . '</h3>';

if (empty($data)) {

	echo '<code>No data</code>';

} else {

	foreach ($data as $key => $value) {

		$flag = '';

		if(!is_string($key) || !is_string($value)) {
			continue;
		}

		$key = (string) $key;
		$value = (string) $value;

		if ($key == 'country') {

			$file = dirname(Yii::app() -> request -> scriptFile) . '/images/flags/16/' . strtolower($value) . '.png';

			if (file_exists($file)) {
				$flag = Yii::app() -> createURL('/') . '/images/flags/16/' . strtolower($value) . '.png';
			}
		}

		echo '<div><b>' . Helper::htmlOutput($key) . ':</b> <code>';

		if ($flag) {

			echo '<img src="' . Helper::htmlOutput($flag) . '" alt="' . Helper::htmlOutput($value) . '" />';

		} else {

			print_r(Helper::htmlOutput($value));
		}

		echo '</code></div>';
	}
}
?>
