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

class Shoutbox extends Pages
{
	var $models = 'ModelsShoutbox';
	#####################################
	# Start Class
	#####################################
	public function __construct($id = null)
	{
		parent::__construct();
	}

	public function send ()
	{
		$return = self::insertMsg();
		$this->jquery = array('type' => $return['type'], 'text' => $return['text'] );
	}
	public function getLast ()
	{
		$id = (int) $_GET['id'];
		$return = null;
		$sql = New BDD();
		$sql->table('TABLE_SHOUTBOX');
		$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
		$where = array('name' => 'id', 'value' => $id, 'op' => '>');
		$sql->where($where);
		$sql->queryAll();
		if (!empty($sql->data)) {
			$return = $sql->data;
		} else {
			$return = array();
		}
		return $return;
	}
	public function get()
	{
		$return = '';
			$get = self::getLast();
		$i = 1;
		foreach ($get as $k => $v):
			$i++;
			if ($i & 0) {
				$left_right =  'by_myself right';
			} else {
				$left_right =  'from_user left';
			}
			$username = AutoUser::getNameAvatar($v->hash_key);
			$msg = ' ' . $v->msg;
			$msg = preg_replace("#([\t\r\n ])(www|ftp)\.(([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^ \"\n\r\t<]*)?)#i", '\1<a href="http://\2.\3" onclick="window.open(this.href); return false;">\2.\3</a>', $msg);
			$msg = preg_replace("#([\n ])([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $msg);
			$msg = preg_replace_callback('`((https?|ftp)://\S+)`', 'cesure_href',$msg);

			$return .= '<li class="'.$left_right.'" id="id_'.$v->id.'">
				<a data-toggle="tooltip" title="'.$username->username.'" href="Members/View/'.$username->username.'" class="avatar">
					<img src="'.$username->avatar.'">
				</a>
				<div class="message_wrap"> <span class="arrow"></span>
					<div class="info"> <a data-toggle="tooltip" title="'.$username->username.'" href="Members/View/'.$username->username.'" class="name">'.$username->username.'</a> <span class="time">'.$v->date_msg.'</span>
					</div>
					<div class="text">'.$msg.'</div>
				</div>
			</li>';
		endforeach;

		$this->affiche = $return;
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
			$return['type'] = 'danger';
			return $return;
		} else {
			$data['msg'] = Common::VarSecure($_REQUEST['text'], '<a><b><p><strong>');
		}

		$this->sql = New BDD();
		$this->sql->table('TABLE_SHOUTBOX');
		$this->sql->sqldata($data);
		$this->sql->insert();

		$return['text']	= 'Message envoyer avec succès';
		$return['type']	= 'success';

		return $return;

	}
}
