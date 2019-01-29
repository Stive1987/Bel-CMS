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

class Page extends Pages
{
	var $models     = array('ModelsPage');
	private $php    = false;
	private $_error = false;
	#####################################
	# Start Class
	#####################################
	public function __construct() {
		parent::__construct();
		if (parent::accessPage(strtolower(get_class($this))) === false) {
			$this->error(INFO, 'Désolé, vous n’avez pas accès à cette page', 'info');
			$this->_error = true;
		}
	}

	public function index ($page = false)
	{
		if (!empty($page) && $this->ModelsPage->TestExistPage($page) === true) {
			$title['title']  = Common::MakeConstant($page);
			$content['page'] = $this->ModelsPage->GetPage($page, $this->php);
			$this->set($title);
			$this->set($content);
			$this->render('index');
		} else {
			$this->error(INFO, 'La page demander n\'existe pas !', 'alert');
		}

	}
}
