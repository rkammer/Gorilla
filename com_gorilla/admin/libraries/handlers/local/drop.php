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

// Import dependencies
require_once ( JPATH_COMPONENT_ADMINISTRATOR . '/libraries/handlers/handler.php' );
require_once ( JPATH_COMPONENT_ADMINISTRATOR . '/libraries/factories/factory.php' );
require_once ( JPATH_COMPONENT_ADMINISTRATOR . '/models/config.php' );

/**
 * Gorilla handle to manage files in local.
 *
 * @package		Joomla.Library
 * @subpackage	lib_gorilla
 */
class GorillaHandlerDrop extends GorillaHandler
{

	/**
	 * Move dropped file to dropped dir.
	 *
	 * @param   string   $guid      Guid to save file.
	 * @param   file     $file      File to move.
	 *
	 * @return true if success, false otherwise.
	 */
	public function move($guid, $file)
	{
		$this->_file = $file;
		$this->_guid = $guid;

		$app = JFactory::getApplication('administrator');
		$target_file = $app->getCfg('tmp_path') . '/' . $this->_guid;

		if (!move_uploaded_file($this->_file['tmp_name'], $target_file)) {
			$this->setError(JText::_('COM_GORILLA_HANDLER_DROP_CANNOT_SAVE'));
			return false;
		}
		return true;
	}

	/**
	 * Remove file from dropped dir.
	 *
	 * @param   string   $guid      Guid of file to be deleted.
	 *
	 * @return true if success, false otherwise.
	 */
	public function del($guid)
	{
		$this->_guid = $guid;

		$app = JFactory::getApplication('administrator');
		$target_file   = $app->getCfg('tmp_path') . '/' . $this->_guid;

		if (is_readable($target_file)) {
			if (unlink($target_file)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Get absolute path from file in dropped dir.
	 *
	 * @param   string   $guid      Guid
	 *
	 * @return string absolute path
	 */
	public function getAbsolutePath($guid) {
		$this->_guid = $guid;

		$app = JFactory::getApplication('administrator');
		$target_file   = $app->getCfg('tmp_path') . '/' . $this->_guid;
		return $target_file;
	}

}