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

class ModelsManagementForum
{
	protected function GetThreads($id = null)
	{
		$sql = New BDD();
		$sql->table('TABLE_FORUM_THREADS');
		if ($id === null) {
			$sql->orderby(array(array('name' => 'id_forum', 'type' => 'ASC')));
			$sql->queryAll();
			$return = $sql->data;
			foreach ($return as $k => $v) {
				$return[$k]->id_forum = self::GetForum($v->id_forum);
			}
		} else {
			$tmp_where[] = array(
				'name'  => 'id',
				'value' => (int) $id
			);
			$sql->where($tmp_where);
			$sql->queryOne();
			$return = $sql->data;
			$return->id_forum = self::GetForum($return->id_forum);
		}
		return $return;
	}

	protected function GetForum ($id = null)
	{
		$sql = New BDD();
		$sql->table('TABLE_FORUM');
		if ($id === null) {
			$sql->orderby(array(array('name' => 'title', 'type' => 'ASC')));
			$sql->queryAll();
		} else {
			$tmp_where[] = array(
				'name'  => 'id',
				'value' => (int) $id
			);
			$sql->where($tmp_where);
			$sql->queryOne();
			$sql->data->groups = explode('|', $sql->data->groups);
		}
		$return = $sql->data;
		return $return;
	}

	protected function SendAddForum ($data = false)
	{
		if ($data !== false) {
			// SECURE DATA
			$insert['title']    = Common::VarSecure($data['title'], '');
			$insert['subtitle'] = Common::VarSecure($data['subtitle'], '');
			$insert['orderby']  = (int) $data['orderby'];
			$insert['icon']     = Common::VarSecure($data['icon'], '');
			$insert['id_forum'] = (int) $data['id_forum'];
			$insert['options']  = 'lock=0';
			// Check title empty
			if (empty($insert['title'])) {
				$return = array(
					'type' => 'success',
					'text' => ERROR_TITLE_EMPTY
				);
			} else {
				// SQL INSERT
				$sql = New BDD();
				$sql->table('TABLE_FORUM_THREADS');
				$sql->sqlData($insert);
				$sql->insert();
				// SQL RETURN NB INSERT 
				if ($sql->rowCount == 1) {
					$return = array(
						'type' => 'success',
						'text' => NEW_THREADS_SUCCESS
					);
				} else {
					$return = array(
						'type' => 'alert',
						'text' => NEW_THREADS_ERROR
					);
				}
			}
		} else {
			$return = array(
				'type' => 'alert',
				'text' => ERROR_NO_DATA
			);
		}
		return $return;
	}

	protected function SendEditForum ($data = false)
	{
		if ($data !== false) {
			// SECURE DATA
			$id               = (int) $data['id'];
			$edit['title']    = Common::VarSecure($data['title'], '');
			$edit['subtitle'] = Common::VarSecure($data['subtitle'], '');
			$edit['orderby']  = (int) $data['orderby'];
			$edit['icon']     = Common::VarSecure($data['icon'], '');
			$edit['id_forum'] = (int) $data['id_forum'];

			if (empty($edit['title'])) {
				$return = array(
					'type' => 'success',
					'text' => ERROR_TITLE_EMPTY
				);
			} else {
				// SQL EDIT
				$where = array('name' => 'id','value' => $id);
				$sql = New BDD();
				$sql->table('TABLE_FORUM_THREADS');
				$sql->where($where);
				$sql->sqlData($edit);
				$sql->update();
				// SQL RETURN NB INSERT 
				if ($sql->rowCount == 1) {
					$return = array(
						'type' => 'success',
						'text' => NEW_THREADS_SUCCESS
					);
				} else {
					$return = array(
						'type' => 'alert',
						'text' => NEW_THREADS_ERROR
					);
				}
			}
		} else {
			$return = array(
				'type' => 'alert',
				'text' => ERROR_NO_DATA
			);
		}
		return $return;
	}

	protected function DelThreads ($id = false)
	{
		if ($id !== false) {
			// Secure ID
			$id = (int) $id;
			// SQL DELETE
			$where = array('name' => 'id','value' => $id);
			$sql = New BDD();
			$sql->table('TABLE_FORUM_THREADS');
			$sql->where($where);
			$sql->delete();
			// SQL RETURN NB INSERT 
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => DEL_THREADS_SUCCESS
				);
			} else {
				$return = array(
					'type' => 'alert',
					'text' => DEL_THREADS_ERROR
				);
			}
		} else {
			$return = array(
				'type' => 'alert',
				'text' => ERROR_ID_EMPTY_INT
			);
		}
		return $return;
	}

	protected function SendAddCat ($data = false)
	{
		if ($data !== false) {
			// SECURE DATA
			$insert['title']    = Common::VarSecure($data['title'], '');
			$insert['subtitle'] = Common::VarSecure($data['subtitle'], '');
			$insert['orderby']  = (int) $data['orderby'];
			$insert['activate'] = (int) $data['activate'];
			$insert['groups']   = isset($data['groups']) ? implode('|', $data['groups']) : 0;
			// SQL INSERT
			$sql = New BDD();
			$sql->table('TABLE_FORUM');
			$sql->sqlData($insert);
			$sql->insert();
			// SQL RETURN NB INSERT 
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => NEW_CAT_SUCCESS
				);
			} else {
				$return = array(
					'type' => 'alert',
					'text' => NEW_CAT_ERROR
				);
			}
		} else {
			$return = array(
				'type' => 'alert',
				'text' => ERROR_NO_DATA
			);
		}
		return $return;
	}

	protected function SendEditCat ($data = false)
	{
		if ($data !== false) {
			// SECURE DATA
			$id               = (int) $data['id'];
			$edit['title']    = Common::VarSecure($data['title'], '');
			$edit['subtitle'] = Common::VarSecure($data['subtitle'], '');
			$edit['groups']   = implode('|', $data['groups']);
			$edit['activate'] = (int) $data['activate'];
			$edit['orderby']  = (int) $data['orderby'];
			// SQL EDIT
			$where = array('name' => 'id','value' => $id);
			$sql = New BDD();
			$sql->table('TABLE_FORUM');
			$sql->where($where);
			$sql->sqlData($edit);
			$sql->update();
			// SQL RETURN NB INSERT 
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => EDIT_CAT_SUCCESS
				);
			} else {
				$return = array(
					'type' => 'alert',
					'text' => EDIT_CAT_ERROR
				);
			}
		} else {
			$return = array(
				'type' => 'alert',
				'text' => ERROR_ID_EMPTY_INT
			);
		}
		return $return;
	}

	protected function DelCat ($id = false)
	{
		if ($id !== false) {
			// Secure ID
			$id = (int) $id;
			// SQL DELETE
			$where = array('name' => 'id','value' => $id);
			$sql = New BDD();
			$sql->table('TABLE_FORUM');
			$sql->where($where);
			$sql->delete();
			// SQL RETURN NB INSERT 
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => DEL_CAT_SUCCESS
				);
			} else {
				$return = array(
					'type' => 'alert',
					'text' => DEL_CAT_ERROR
				);
			}
		} else {
			$return = array(
				'type' => 'alert',
				'text' => ERROR_ID_EMPTY_INT
			);
		}
		return $return;
	}

	protected function isCat () 
	{
		$sql = New BDD();
		$sql->table('TABLE_FORUM');
		$sql->count();
		if ($sql->data <= 1) {
			$return = true;
		} else {
			$return = false;
		}
		return $return;
	}

}