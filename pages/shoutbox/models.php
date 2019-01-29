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

class ModelsShoutbox
{
	public function getMsg($id = false)
	{
		$return = null;
		$sql = New BDD();
		$sql->table('TABLE_SHOUTBOX');
		if (is_numeric($id)) {
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->queryOne();
		} else {
			$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
			$sql->queryAll();
		}
		if (!empty($sql->data)) {
			$return = $sql->data;
		}
		return $return;
	}

	public function insertMsg()
	{
		if (strlen($_SESSION['user']->hash_key) != 32) {
			$return['text'] = 'Erreur HashKey';
			$return['type'] = 'danger';
			return $return;
		} else {
			$data['hash_key'] = $_SESSION['user']->hash_key;
		}

		if (empty($_SESSION['user']->avatar) OR !is_file($_SESSION['user']->avatar)) {
			$data['avatar'] = DEFAULT_AVATAR;
		} else {
			$data['avatar'] = $_SESSION['user']->avatar;
		}

		if (empty($_REQUEST['text'])) {
			$return['text'] = 'Erreur Message Vide';
			$return['type'] = 'warning';
			return $return;
		} else {
			$data['msg'] = Common::VarSecure($_REQUEST['text'], '<a><b><p><strong>');
		}

		$sql = New BDD();
		$sql->table('TABLE_SHOUTBOX');
		$sql->sqldata($data);
		$sql->insert();
		if ($rowCount == 1) {
			$return['text']	= 'Message envoyer avec succès';
			$return['type']	= 'success';
		} else {
			$return['text']	= 'Problème d\'accès à la BDD';
			$return['type']	= 'error';		
		}

		return $return;

	}
}
