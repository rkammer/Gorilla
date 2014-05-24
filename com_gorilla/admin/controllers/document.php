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
require_once ( JPATH_COMPONENT_ADMINISTRATOR . '/helpers/gorilla.php' );
require_once ( JPATH_COMPONENT_ADMINISTRATOR . '/models/config.php' );

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
		$filename  = $formData->get('filename', '');

		// Validate file association
		if (empty($id) || empty($guid) || empty($filename)) {

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
		if (!$GorillaHandler->download($guid, $filename)) {
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

	/**
	 * Method to upload file from dropzone.
	 *
	 * Echo string File GUID when success,
	 * Echo 403 error message when otherwise.
	 *
	 * return void
	 */
	public function dropfile() {

		// Check for request forgeries.
		if (!JSession::checkToken()) {
			header("HTTP/1.0 403");
			echo JText::_('JINVALID_TOKEN');
			die();
		}

		$app = JFactory::getApplication();
		$clientName = $app->input->get('clientname', '', 'string');

		$GorillaConfig = new GorillaModelConfig();
		$maxInBytes = $GorillaConfig->getUploadMaxsizeBytes();

		// Testing file size
		if($_FILES['file']['size'] > $maxInBytes) {
			header("HTTP/1.0 403");
			echo JText::sprintf('COM_GORILLA_DOCUMENT_MAXIMUM_FILE_SIZE', $maxInBytes/1024/1024);
			die();
		}

		// Generate new guid
		$guid = GorillaHelper::getGUID();

		// Get handler to move to dropped directory
		$GorillaHandler = GorillaFactory::getNewHandler('Drop');
		$GorillaHandler->move($guid, $_FILES['file']);

		ob_clean();

		// Check for errors
		if ( count($GorillaHandler->getErrors()) == 0 )
		{
			$return = array();
			$return['clientName'] = $clientName;
			$return['serverName'] = $guid;
			echo json_encode($return);
			die();
		}
		else {
			$error_msg = '';
			foreach ($GorillaHandler->getErrors() as $error) {
				$error_msg .= $error;
			}
			header("HTTP/1.0 403");
			echo $error_msg;
			die();
		}
	}

	/**
	 * Method to remove file from dropzone.
	 *
	 * Echo empty string when success,
	 * Echo 403 error message when otherwise.
	 *
	 * return void
	 */
	public function removefile() {

		// Check for request forgeries.
		if (!JSession::checkToken()) {
			header("HTTP/1.0 403");
			echo JText::_('JINVALID_TOKEN');
			die();
		}

		$app  = JFactory::getApplication();
		$guid = $app->input->get('servername', '', 'string');

		// Get handler to move to dropped directory
		$GorillaHandler = GorillaFactory::getNewHandler('Drop');
		if (!$GorillaHandler->del($guid)) {
			header("HTTP/1.0 403");
			echo JText::_('COM_GORILLA_HANDLER_DROP_CANNOT_DELETE');
			die();
		}

		echo '';
		die();
	}

}