<?php

/**
 * Gorilla Note Manager
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

jimport('joomla.application.component.controllerform');
require_once ( JPATH_COMPONENT_ADMINISTRATOR . '/libraries/factories/factory.php' );

/**
 * Note controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class GorillaControllerNote extends JControllerForm
{

	/**
	 * Method to download file.
	 *
	 * return mixed Exit() after download starts, false on failure.
	 *
	 */
	public function download()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Required objects
		$input = JFactory::getApplication()->input;

		// Get the form data
		$formData = new JRegistry($input->get('jform', '', 'array'));

		// Get fields from form
		$id        = $formData->get('id', '');
		$guid      = $formData->get('guid', '');

	}

}