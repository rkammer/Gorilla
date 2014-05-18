<?php

/**
 * Gorilla Document Manager
 *
 * @author     Gorilla Team
 * @copyright  2013-2014 SOHO Prospecting LLC (California - USA)
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link https://www.sohoprospecting.com
 *
 * Try not. Do or do not. There is no try.
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Gorilla handle to manage files
 *
 * @package		Joomla.Library
 * @subpackage	lib_gorilla
 */
abstract class GorillaHandler extends JObject
{

	/**
	 * File that will be handle.
	 *
	 *
	 * @var    file
	 */
	protected $_file;

	/**
	 * GUID is unique identified use to store and retrieve file.
	 *
	 * @var    string
	 */
	protected $_guid;

	/**
	 * File name necessary for download file.
	 *
	 * @var    string
	 */
	protected $_filename;

	/**
	 * Generate and unique name in tmp_dir based on guid.
	 *
	 * @return string Full file name
	 */
	protected function _getTempFilename() {
		$tmp_dir = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();
		return  $tmp_dir . '/' . $this->_guid;
	}

}