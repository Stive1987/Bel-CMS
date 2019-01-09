<?php
/**
 * Bel-CMS [Content management system]
 * @version 0.0.1
 * @link https://bel-cms.be
 * @link https://stive.eu
 * @license http://opensource.org/licenses/GPL-3.0 copyleft
 * @copyright 2014-2019 Bel-CMS
 * @author Stive - determe@stive.eu
 */

if (!defined('CHECK_INDEX')) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit(ERROR_INDEX);
}

final class Secures
{
	public static function getAccessPage ($page = null) {
		if ($page === null) {
			return true;
		} else {
			return self::accessBDD();
		}
	}

	public static function accessBDD ()
	{
		$sql = New BDD();
		$sql->table('TABLE_PAGES_CONFIG');
		$sql->queryAll();
		if (empty($sql->data)) {
			$return = false;
		} else {
			$return = $sql->data;
		}

		return $return;
	}
}
