<?php
/**
 * Bel-CMS [Content management system]
 * @version 1.0.0
 * @link https://bel-cms.be
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2014-2019 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if (!defined('CHECK_INDEX')) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit(ERROR_INDEX);
}
#########################################
# Notification Alert (red, blue, green, orange)
#########################################
final class Notification
{
	public static function alert($text = NO_TEXT_DEFINED, $title = INFO, $full = false)
	{
		if ($full === true) {
			echo self::renderFull(null, $text, $title);
			die();
		} else {
			echo self::render(null, $text, $title);
		}
	}
	public static function error ($text = NO_TEXT_DEFINED, $title = ERROR, $full = false)
	{
		if ($full === true) {
			echo self::renderFull('error', $text, $title);
			die();
		} else {
			echo self::render ('error', $text, $title);
		}
	}
	public static function warning ($text = NO_TEXT_DEFINED, $title = WARNING, $full = false)
	{
		if ($full === true) {
			echo self::renderFull('warning', $text, $title);
			die();
		} else {
			echo self::render ('warning', $text, $title);
		}
	}
	public static function success ($text = NO_TEXT_DEFINED, $title = SUCCESS, $full = false)
	{
		if ($full === true) {
			echo self::renderFull('success', $text, $title);
			die();
		} else {
			echo self::render ('success', $text, $title);
		}
	}
	public static function infos ($text = NO_TEXT_DEFINED, $title = INFO, $full = false)
	{
		if ($full === true) {
			echo self::renderFull('infos', $text, $title);
			die();
		} else {
			echo self::render ('infos', $text, $title);
		}
	}
	private static function render ($type = null, $text = 'BEL-CMS : Alert neutral', $title = 'Alert !')
	{

		$render  = '<section class="belcms_notification">';
		$render .= '<header class="belcms_notification_header '.$type.'">';
		$render .= '<i class="fas fa-exclamation-triangle"></i>';
		$render .= '<span>'.$title.'</span>';
		$render .= '</header>';
		$render .= '<div class="belcms_notification_msg">';
		$render .= $text;
		$render .= '</div> ';
		$render .= '</section>';
		return $render;
	}
	public static function renderFull ($type = null, $text = 'BEL-CMS : Alert neutral', $title = 'Alert !')
	{
		$render  = '<!DOCTYPE html>';
		$render .= '<html lang="fr">';
		$render .= '<head>';
		$render .= '<meta charset="utf-8">';
		$render .= '<title>Error : '.$title.'</title>';
		$render .= '<link rel="stylesheet" href="/assets/styles/belcms.notification.css">';
		$render .= '<style type="text/css">';
		$render .= 'body {background-color: #1a232f;background-image: -moz-radial-gradient(center center,circle cover,#273648,#0d1218 100%);background-image: -webkit-radial-gradient(center center,circle cover,#273648,#0d1218 100%);background-image: -o-radial-gradient(center center,circle cover,#273648,#0d1218 100%);background-image: -ms-radial-gradient(center center,circle cover,#273648,#0d1218 100%);background-image: radial-gradient(center center,circle cover,#273648,#0d1218 100%);}section#error {width: 100%;max-width: 700px;margin: 300px calc(50% - 350px) auto;height: 300px;}</style>';
		$render .= '</head>';
		$render .= '<body>';
		$render .= '<section id="error">';
		$render .= '<section class="belcms_notification">';
		$render .= '<header class="belcms_notification_header '.$type.'">';
		$render .= '<i class="fas fa-exclamation-triangle"></i>';
		$render .= '<span>'.$title.'</span>';
		$render .= '</header>';
		$render .= '<div class="belcms_notification_msg">';
		$render .= $text;
		$render .= '</div> ';
		$render .= '</section>';
		$render .= '</section>';
		$render .= '</body>';
		$render .= '</html>';
		return $render;
	}
}
