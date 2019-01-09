<?php
/**
 * Bel-CMS [Content management system]
 * @version 0.3.0
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

class User extends Pages
{
	var $models = array('ModelsUser');
	private $_error = false;

	public function index ()
	{
		if (Users::isLogged() === true) {
			$d = array();
			$d['user'] = $this->ModelsUser->getDataUser($_SESSION['USER']['HASH_KEY']);
			$this->set($d);
			$this->render('profil');
		} else {
			$this->redirect('User/login&echo', 3);
			Notification::warning(LOGIN_REQUIRE);
		}
	}
	public function profil ()
	{
		$d = array();
		$d['user'] = $this->ModelsUser->getDataUser($_SESSION['USER']['HASH_KEY']);
		$this->set($d);
		$this->render('profil');
	}
	public function login ()
	{
		if (Users::isLogged() === false) {
			$this->render('login');
		} else {
			$this->render('index');
		}
	}
	public function register ()
	{
			if (Users::isLogged() === false) {
				$_SESSION['TMP_QUERY_REGISTER'] = array();
				$_SESSION['TMP_QUERY_REGISTER']['number_1'] = rand(1, 9);
				$_SESSION['TMP_QUERY_REGISTER']['number_2'] = rand(1, 9);
				$_SESSION['TMP_QUERY_REGISTER']['overall']  = $_SESSION['TMP_QUERY_REGISTER']['number_1'] + $_SESSION['TMP_QUERY_REGISTER']['number_2'];
				$_SESSION['TMP_QUERY_REGISTER'] = Common::arrayChangeCaseUpper($_SESSION['TMP_QUERY_REGISTER']);
				$this->data = (bool) true;
				$this->render('register');
			} else {
				$this->redirect('user', 0);
			}
	}
	public function logout ()
	{
			$return = Users::logout();
			$this->error('Logout', $return['msg'], $return['type']);
			$this->redirect('user', 3);
	}
	public function lostpassword ()
	{
			if (Users::isLogged() === false) {
				$this->data = (bool) true;
				$this->render('lostpassword');
			}
	}
	private function sendLostPassword ()
	{
			unset($this->data['send']);
			$return = $this->ModelsUser->checkToken($this->data);
			if (!isset($return['pass'])) {
				$this->error('Password', $return['msg'], $return['type']);
				$this->redirect('User/LostPassword', 3);
			} else {
				$this->error('Password', $return['msg'], $return['type']);
			}
	}
	public function send ()
	{
			if ($this->data['send'] == 'register') {
				self::sendRegister();
			} else if ($this->data['send'] == 'login') {
				self::sendLogin();
			} else if ($this->data['send'] == 'mailpassword') {
				self::mailpassword();
			} else if ($this->data['send'] == 'editsocial') {
				self::editsocial();
			} else if ($this->data['send'] == 'editprofile') {
				self::editprofil();
			} else if ($this->data['send'] == 'lostpassword') {
				self::sendLostPassword();
			} else if ($this->data['send'] == 'sendavatar') {
				self::sendAvatar();
			} else if ($this->data['send'] == 'changeavatar') {
				self::changeAvatar();
			} else if ($this->data['send'] == 'deleteavatar') {
				self::deleteAvatar();
			} else {
				$this->redirect('user', 3);
			}
	}
	private function sendAvatar ()
	{
			$return = $this->ModelsUser->sendAvatarUpload();
			if ($return['type'] == 'success') {
				Notification::success($return['msg']);
				$this->redirect('user', 3);
			} else {
				Notification::error($return['msg']);
				$this->redirect('user', 3);
			}
	}
	private function changeAvatar ()
	{
			unset($_REQUEST['send']);
			$return = $this->ModelsUser->sendChangeAvatar($_REQUEST['value']);
			$this->jquery = array('type' => $return['type'], 'text' => $return['msg'] );
			$this->redirect('user', 3);
	}

	private function deleteAvatar ()
	{
			unset($_REQUEST['send']);
			$return = $this->ModelsUser->sendDeleteAvatar($_REQUEST['value']);
			$this->error('Delete Avatar', $return['msg'], $return['type']);
			$this->redirect('user', 3);
	}

	private function sendRegister ()
	{
		if (empty($this->data)) {
			Notification::alert('Pas de données');
			$this->redirect('user&echo', 2);
		} else if (
			empty($this->data['email']) or 
			empty($this->data['username']) or 
			empty($this->data['password']) or 
			empty($this->data['passwordrepeat']) or 
			empty($this->data['query_register'])
		) {
			Notification::alert('Un des champs obligatoire n\'est pas rempli');
			$this->redirect('User/register&echo', 3);
		} else {
			$return = $this->ModelsUser->sendRegistration($this->data);
			
			if ($return['type'] == 'error') {
				Notification::error($return['msg']);
				$this->redirect('User/register&echo', 3);
			} else if ($return['type'] == 'warning') {
				$this->redirect('User/register&echo', 3);
				Notification::warning($return['msg']);
			} else if ($return['type'] == 'success') {
				$this->redirect('User/Profil', 3);
				Notification::success($return['msg']);
			} else {
				$this->redirect('User/register&echo', 3);
				Notification::warning('Erreur inconnu');
			}
		}
	}
	private function sendLogin ()
	{
			if (empty($this->data)){
				$this->error(ERROR, 'Field Empty', 'error');
				$this->redirect('User/Login', 3);
			} else {
				$return = Users::login($this->data['username'], $this->data['password']);

				if ($return['type'] == 'error') {
					Notification::error($return['msg']);
					$this->redirect('User/Login&echo', 3);
				} else if ($return['type'] == 'warning') {
					$this->redirect('User/Login&echo', 3);
					Notification::warning($return['msg']);
				} else if ($return['type'] == 'success') {
					$this->redirect('User/Profil', 3);
					Notification::success($return['msg']);
				} else {
					$this->redirect('User/login&echo', 3);
					Notification::warning('Erreur inconnu');
				}
			}
	}
	private function editprofil ()
	{
			if (empty($this->data)) {
				$this->error(ERROR, 'Field Empty');
				$this->redirect('user/login', 3);
			} else {
				unset($this->data['send']);
				$return = $this->ModelsUser->sendEditProfil($this->data);
				$this->error('Edition Profile Information', $return['msg'], $return['type']);
				$this->redirect('User', 3);
			}
	}
	private function editsocial ()
	{
			if (empty($this->data)) {
				$this->error(ERROR, 'Field Empty');
				$this->redirect('user/login', 3);
			} else {
				unset($this->data['send']);
				$return = $this->ModelsUser->sendEditSocial($this->data);
				$this->error('Edit social media', $return['msg'], $return['type']);
				$this->redirect('User', 3);
			}
	}
	private function mailpassword ()
	{
			if (empty($this->data)) {
				$this->error(ERROR, 'Field Empty');
				$this->redirect('user/login', 3);
			} else {
				unset($this->data['send']);
				$return = $this->ModelsUser->sendEditPassword($this->data);
				$this->error('Edit mail & password', $return['msg'], $return['type']);
				$this->redirect('User', 2);
			}
	}
	public function GetUser($usermail = null, $userpass = null, $api_key = null)
	{
		if ($usermail !== null && $userpass !== null && $api_key) {
			if (defined('API_KEY')) {
				if (!empty($api_key) && $api_key == constant('API_KEY')) {
					$this->json = $this->ModelsUser->GetInfosUser($usermail, $userpass);
				}
			}
		} else {
			$this->json = null;
		}
	}
}
