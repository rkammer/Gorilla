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
class GorillaHandler extends JObject
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
	protected $_file_name;

	/**
	 * Upload file.
	 *
	 * @return true if success
	 */
// 	public function upload() {
// 		return true;
// 	}

	/**
	 * Prepare file and download.
	 *
	 * @param  file   $file File that will be handle.
	 *
	 * @return void
	 */
// 	public function download() {

// 		if (file_exists($this->_file)) {
// 			header('Content-Description: File Transfer');
// 			header('Content-Type: application/octet-stream');
// 			header('Content-Disposition: attachment; filename='.basename($this->_file));
// 			header('Expires: 0');
// 			header('Cache-Control: must-revalidate');
// 			header('Pragma: public');
// 			header('Content-Length: ' . filesize($this->_file));
// 			ob_clean();
// 			flush();
// 			readfile($this->_file);
// 			exit;
// 		}
// 	}

	/**
	 * Generate and unique name in tmp_dir based on guid.
	 *
	 * @return string Full file name
	 */
	protected function getTempFilename() {
		$tmp_dir = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();
		return  $tmp_dir . '/' . $this->_guid;
	}

}