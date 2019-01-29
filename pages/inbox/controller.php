<?php
/**
 * Bel-CMS [Content management system]
 * @version 0.0.3
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

class Inbox extends Pages
{
	#####################################
	# Declaration variables
	#####################################
	var $models = array('ModelsInbox');
	#####################################
	# Start Class
	#####################################
	public function __construct ()
	{
		parent::__construct();
		$this->isConnected = isset($_SESSION['user']->hash_key) ? true : false;
		if ($this->isConnected === false) {
			$this->redirect('User/Login', 0);
		}
	}
	#####################################
	# Get Index page for inbox
	#####################################
	public function index ()
	{
		if ($this->isConnected === true) {
			$set['inbox'] = $this->ModelsInbox->getMessages();
			$this->set($set);
			$this->render('index');
		}
	}
	#####################################
	# Get message for inbox
	#####################################
	public function showMessage($id)
	{
		if (!is_numeric($id)) {
			$this->error(INBOX, ERROR_NO_ID, 'danger');
		} else {
			$set = $this->ModelsInbox->showMessage($id);
			if (array_key_exists('type', $set) && array_key_exists('text', $set)) {
				$this->error(INBOX, $set['text'], $set['type']);
			} else {
				if (count($set) == 0) {
					$this->error(INBOX, ERROR_NO_MESSAGE_EXIST, 'danger');
				} else {
					$set['inbox'] = $this->ModelsInbox->showMessage($id);
					$this->set($set);
					$this->render('show');
				}
			}
		}
	}
	#####################################
	# Get Users for new message
	#####################################
	public function getUsers ()
	{
		$search = $_GET['term'];
		$this->json = array('username' => $this->ModelsInbox->getUsers($search));
	}
	#####################################
	# Send
	#####################################
	public function send ()
	{
		if ($this->isConnected === true) {
			if ($this->data['send'] == 'new') {
				self::sendNewMessage();
			} else if ($this->data['send'] == 'reponse') {
				self::sendReponse();
			}
		}
	}
	#####################################
	# Send new message
	#####################################
	private function sendNewMessage ()
	{
		$return = $this->ModelsInbox->sendNewMessage($this->data['username'], $this->data['message']);
		$this->error(INBOX, $return['text'], $return['type']);
		$this->redirect('Inbox', 2);
	}
	#####################################
	# Send reponse message
	#####################################
	private function sendReponse ()
	{
		$return = $this->ModelsInbox->sendReponse($this->data['id'], $this->data['message']);
		$this->error(INBOX, $return['text'], $return['type']);
		$redirect = 'Inbox/ShowMessage/'.$return['id'];
		$this->redirect($redirect, 2);
	}
	#####################################
	# Get count message
	#####################################
	public function countUnreadMessage()
	{
		if ($this->isConnected === true) {
			$this->json = $this->ModelsInbox->countUnreadMessage();
		}
	}
}
