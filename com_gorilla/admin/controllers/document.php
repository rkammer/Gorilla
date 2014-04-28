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

jimport('joomla.application.component.controllerform');
require_once ( JPATH_COMPONENT_ADMINISTRATOR . '/libraries/factories/factory.php' );

/**
 * Document controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class GorillaControllerDocument extends JControllerForm
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
		$file_name = $formData->get('file_name', '');

		// Validate file association
		if (empty($id) || empty($guid) || empty($file_name)) {

			$this->setError(JText::sprintf('COM_GORILLA_DOCUMENT_NO_FILE'));
			$this->setMessage($this->getError(), 'warning');

			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_item
					. $this->getRedirectToItemAppend($id, 'id'), false
				)
			);

 			return false;
		}

		// Get handler and download
		$GorillaHandler = GorillaFactory::getNewHandler('Amazon');
		if (!$GorillaHandler->download($guid, $file_name)) {
			foreach ($GorillaHandler->getErrors() as $error) {
				$this->setError($error);
				$this->setMessage($error, 'error');
			}

			$this->setRedirect(
					JRoute::_(
							'index.php?option=' . $this->option . '&view=' . $this->view_item
							. $this->getRedirectToItemAppend($id, 'id'), false
					)
			);

			return false;
		}
	}

}