<?php

/**
 * Helper class
 */
class Helper {

	public static function htmlOutput($string, $autolink = true) {

		$string = mb_convert_encoding($string, 'UTF-8', 'UTF-8');
		$string = CHtml::encode($string, ENT_QUOTES, 'UTF-8');

		if ($autolink)
			$string = autolink($string);
		return $string;
	}

}
