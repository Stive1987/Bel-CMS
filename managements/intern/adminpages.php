<?php
/**
 * Bel-CMS [Content management system]
 * @version 0.0.1
 * @link https://bel-cms.be
 * @link https://stive.eu
 * @license http://opensource.org/licenses/GPL-3.0 copyleft
 * @copyright 2014-2019 Bel-CMS
 * @author Stive - determe@stive.eu
 */

if (!defined('CHECK_INDEX')) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit(ERROR_INDEX);
}

class AdminPages
{
	var $active;
	var $vars      = array();

	public $render = null;

	function __construct()
	{
		if ($this->active === false) {
			self::pageOff();
		}

		if (isset($this->models)){
			foreach($this->models as $v){
				$this->loadModel($v);
			}
		}
	}

	private function pageOff ()
	{
		ob_start();
		
		Notification::warning('La page demander n\'est pas accesible', 'Page');

		$this->render = ob_get_contents();

		if (ob_get_length() != 0) {
			ob_end_clean();
		}
		return;
	}

	function set ($d) {
		$this->vars = array_merge($this->vars,$d);
	}

	public function render ($filename)
	{
		extract($this->vars);
		ob_start();

		$filename = MANAGEMENTS.'pages'.DS.'blog.managements.php'.DS.$filename.'.php';
		
		if (is_file($filename)) {
			require $filename;
		}

		$this->render = ob_get_contents();

		if (ob_get_length() != 0) {
			ob_end_clean();
		}
	}

	protected function loadModel ($name)
	{

	}
}