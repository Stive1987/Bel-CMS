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

class Members extends Pages
{
	var $models = array('ModelsMembers');
	private $_error = false;

	public function __construct()
	{
		parent::__construct();
		if (parent::accessPage(strtolower(get_class($this))) === false) {
			$this->error(INFO, 'Désolé, vous n’avez pas accès à cette page', 'info');
			$this->_error = true;
		}
		if (isset($_SESSION['pages']->user->config['MAX_USER'])) {
			$this->nbpp = (int) $_SESSION['pages']->user->config['MAX_USER'];
		} else {
			$this->nbpp = (int) 10;
		}
		if ($_SESSION['pages']->members->active == 0) {
			$this->error(INFO, 'La page membres est désactiver', 'info');
			$this->_error = true;
		}
	}

	public function index ()
	{
		if ($this->_error === false) {
			$set['pagination'] = $this->pagination($this->nbpp, GET_PAGE, TABLE_USERS);
			$set['members'] = $this->ModelsMembers->GetUsers();
			$this->set($set);
			$this->render('index');
		}
	}

	public function view ($name)
	{
		if ($this->_error === false) {
			$name = Common::VarSecure($name);
			if ($name !== false) {
				$user = AutoUser::getInfosUser($name, true);
				if ($user->username == DELETE) {
					$this->error(ERROR, UNKNOW_MEMBER);
				} else {
					$groups = Config::GetGroups();
					foreach ($user->groups as $k => $v) {
						$user->groups[$k] = $groups[$v];
					}
					$set['members'] = $user;
					$st2['forum'] = $this->ModelsMembers->GetLastPost($user->hash_key);
					$this->set($set);
					$this->set($st2);
					$this->render('view');
				}
			} else {
				Common::Redirect('Members', 2);
				$this->view = array(ERROR, 'Aucun Membres', 'red');
			}
		}
	}

	public function AddFriend ()
	{
		if ($this->_error === false) {
			$id = constant('GET_ID');
			$user = User::getInfosUser($id, true);
			if ($user['username'] == DELETE) {
				$_SESSION['JQUERY'] = array('type' => 'danger', 'text' => UNKNOW_MEMBER);
			} else {
				parent::addFriendSQL ($user['hash_key']);
				if (parent::addFriendSQL ($user['hash_key'] == null)) {
					$_SESSION['JQUERY'] = array('type' => 'danger', 'text' => ADD_FRIEND_ERROR);
				} else {
					$_SESSION['JQUERY'] = array('type' => 'success', 'text' => ADD_FRIEND_SUCCESS);
				}
			}
		}
	}

	public function json ()
	{
		if ($this->_error === false) {
			$data = $this->ModelsMembers->getJson();
			$this->affiche = json_encode($data);
			//$this->set($data);
			//$this->render('json');
		}
	}
}
