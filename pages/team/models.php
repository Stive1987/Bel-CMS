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

class ModelsTeam
{
	public function GetGroups ()
	{
		$return = array();

		$sql = New BDD();
		$sql->table('TABLE_GROUPS');
		$sql->orderby(array(array('name' => 'name', 'type' => 'ASC')));
		$sql->queryAll();
		$return = $sql->data;
		unset($sql);

		return $return;
	}

	public function GetUsers ($where)
	{
		$return = array();

		if (isset($GLOBALS['CONFIG_PAGES']['team']['config']['MAX_USER'])) {
			$nbpp = (int) $GLOBALS['CONFIG_PAGES']['team']['config']['MAX_USER'];
		} else {
			$nbpp = (int) 10;
		}
		$page = (Dispatcher::RequestPages() * $nbpp) - $nbpp;

		$sql = New BDD();
		$sql->table('TABLE_USERS');
		$sql->limit(array(0 => $page, 1 => $nbpp), true);
		$where = "WHERE `groups` LIKE '%".$where."%'";
		$sql->where($where);
		$sql->orderby(array(array('name' => 'username', 'type' => 'ASC')));
		$sql->queryAll();
		$return = $sql->data;
		unset($sql);

		foreach ($return as $k => $v) {
			$sql = New BDD();
			$sql->table('TABLE_USERS_PROFILS');
			$where = 	array(
							'name'  => 'hash_key',
							'value' => $v->hash_key
						);
			$sql->where($where);
			$sql->queryOne();
			$return[$k]->profils = $sql->data;
			unset($sql);
		}

		return $return;
	}
}
