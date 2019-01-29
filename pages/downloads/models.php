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

class ModelsDownloads
{
	public function GetCat ($id = false)
	{
		$sql = New BDD;
		$sql->table('TABLE_DOWNLOADS_CAT');
		if ($id && is_int($id)) {
			$id = (int) $id;
			$where = array('name' => 'id', 'value' => $id);
			$sql->where($where);
			$sql->queryOne();
			$sql->data->groups = explode('|', $sql->data);
		} else {
			$sql->orderby(array(array('name' => 'name', 'type' => 'ASC')));
			# $sql->limit(array(0 => $page, 1 => $nbpp), true);
			$sql->queryAll();

			foreach ($sql->data as $k => $v) {
				$sql->data[$k]->groups = explode('|', $v->groups);
			}
		}
		$return = $sql->data;
		return $return;
	}

	public function GetDlNoGroup ()
	{
		$sql = New BDD;
		$sql->table('TABLE_DOWNLOADS');
		$where = 'WHERE `cat` IS NULL ';
		$sql->where($where);
		$sql->orderby(array(array('name' => 'name', 'type' => 'ASC')));
		$sql->queryAll();

		if ($sql->rowCount > 0) {
			foreach ($sql->data as $k => $v) {
				$sql->data[$k]->groups = explode('|', $v->groups);
			}
		}

		$return = $sql->data;
		return $return;
	}

	public function GetDl ($cat = null)
	{
		if ($cat !== null && is_int($cat)) {
			$sql = New BDD;
			$sql->table('TABLE_DOWNLOADS');
			$where = array('name' => 'cat', 'value' => (int) $cat);
			$sql->where($where);
			$sql->orderby(array(array('name' => 'name', 'type' => 'ASC')));
			$sql->queryAll();

			foreach ($sql->data as $k => $v) {
				$sql->data[$k]->groups = explode('|', $v->groups);
			}

			$return = $sql->data;
			return $return;
		}
	}

	public function GetDetail ($id = null)
	{
		$return = array();
		if ($id !== null && is_int($id)) {
			$sql = New BDD;
			$sql->table('TABLE_DOWNLOADS');
			$where = array('name' => 'id', 'value' => (int) $id);
			$sql->where($where);
			$sql->queryOne();
			$return = $sql->data;
		}
		return $return;
	}

	public function GetNameCat ($cat = null)
	{
		$return = '';
		if ($cat !== null && is_int($cat)) {
			$id = (int) $id;
			$sql = New BDD;
			$sql->table('TABLE_DOWNLOADS_CAT');
			$where = array('name' => 'id', 'value' => $cat);
			$sql->where($where);
			$sql->fields(array('name'));
			$sql->queryOne();

			$return = $sql->data->name;
		}
		return $return;

	}

	public function GetFile ($id = null) {
		$return = null;
		if ($id !== null && is_int($id)) {
			$sql = New BDD;
			$sql->table('TABLE_DOWNLOADS');
			$where = array('name' => 'id', 'value' => (int) $id);
			$sql->where($where);
			$sql->queryOne();
			$return = $sql->data;
		}
		return $return;
	}

	public function AddClick ($id = false) {
		if ($id !== false && is_int($id)) {
			$get = New BDD();
			$get->table('TABLE_DOWNLOADS');
			$where = array(
				'name'  => 'id',
				'value' => (int) $id
			);
			$get->where($where);
			$get->queryOne();
			if (!empty($get->data)) {
				$data = $get->data;
				$plus = (int) $data->countdl + 1;
				$update = New BDD();
				$update->table('TABLE_DOWNLOADS');
				$update->where($where);
				$update->sqlData(array('countdl' => $plus));
				$update->update();
			}
		}
	}

	public function AddView ($id = false) {
		if ($id !== false && is_int($id)) {
			$get = New BDD();
			$get->table('TABLE_DOWNLOADS');
			$where = array(
				'name'  => 'id',
				'value' => (int) $id
			);
			$get->where($where);
			$get->queryOne();
			if (!empty($get->data)) {
				$data = $get->data;
				$plus = (int) $data->countview + 1;
				$update = New BDD();
				$update->table('TABLE_DOWNLOADS');
				$update->where($where);
				$update->sqlData(array('countview' => $plus));
				$update->update();
			}
		}
	}
}
