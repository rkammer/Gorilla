<?php

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

require_once ( JPATH_COMPONENT_ADMINISTRATOR . '/libraries/factories/factory.php' );

/**
 * Documents list controller class.
 *
 * @package		Joomla.Site
 * @subpackage	com_gorilla
 */
class GorillaControllerDocuments extends JControllerForm
{

	/**
	 * Called from form list to download file in new window.
	 *
	 * return void
	 *
	 */
	public function download() {
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Required objects
		$input = JFactory::getApplication()->input;

		$id        = $input->get('id', '', 'int');
		$guid      = $input->get('guid', '', 'string');
		$filename  = $input->get('filename', '', 'string');

		// Validate file association
		if (empty($id) || empty($guid) || empty($filename)) {
			jexit(JText::sprintf('COM_GORILLA_DOCUMENT_NO_FILE'));
		}

		// Get handler and download
		$GorillaHandler = GorillaFactory::getNewHandler('Amazon');
		if (!$GorillaHandler->download($guid, $filename)) {
			$errors = '';
			foreach ($GorillaHandler->getErrors() as $error) {
				$errors .= $error.'<br />';
			}
			jexit($errors);
		}
	}

}