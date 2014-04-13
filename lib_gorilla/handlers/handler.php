<?php

/**
 * Gorilla Document Manager
 *
 * @author     Rodrigo Petters
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

	//TODO define which type is $_file
	
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
	 * Upload file.
	 *
	 * @return true if success
	 */	
	public function upload() {
		
	}
	
	/**
	 * Prepare file and get link to download.
	 *
	 * @return string Full download link
	 */
	public function getDownloadLink() {
	
	}	
	
}