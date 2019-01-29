<?php
/**
 * Bel-CMS [Content management system]
 * @version 0.0.1
 * @link http://www.bel-cms.be
 * @link http://www.stive.eu
 * @license http://opensource.org/licenses/GPL-3.0 copyleft
 * @copyright 2014-2016 Bel-CMS
 * @author Stive - mail@stive.eu
 */

if (!defined('CHECK_INDEX')) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit(ERROR_INDEX);
}

class ModelsPage
{
	public function GetPage ($name = false, $php = false)
	{
		$return = null;

		if ($name !== false) {

			$sql = New BDD();
			$sql->table('TABLE_PAGE');
			$where = array(
				'name'  => 'name',
				'value' => Common::MakeConstant($name)
			);
			$sql->where($where);
			$sql->queryOne();
			$return = $sql->data;
			if ($php === false) {
				$return->content = Common::VarSecure($return->content, 'html');
			}
			$return->name = Common::MakeConstant($return->name);
		}

		return $return;
	}

	public function  TestExistPage ($name = false) {
		$sql = New BDD();
		$sql->table('TABLE_PAGE');
		$where = array(
			'name'  => 'name',
			'value' => Common::MakeConstant($name)
		);
		$sql->fields(array('id'));
		$sql->where($where);
		$sql->queryOne();

		$count  = $sql->rowCount;

		if ($count == 1) {
			$return = true;
		} else {
			$return = false;
		}

		return $return;
	}
}