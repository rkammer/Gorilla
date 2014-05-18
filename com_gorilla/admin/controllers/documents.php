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

jimport('joomla.application.component.controlleradmin');

require_once ( JPATH_COMPONENT_ADMINISTRATOR . '/libraries/factories/factory.php' );

/**
 * Documents list controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class GorillaControllerDocuments extends JControllerAdmin
{

	/**
	 * Proxy for getModel.
	 *
	 * @param	string	$name	The name of the model.
	 * @param	string	$prefix	The prefix for the PHP class name.
	 *
	 * @return	JModel
	 */
	public function getModel($name = 'Document', $prefix = 'GorillaModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}

	/**
	 * Called from form list to change order with drag and drop.
	 *
	 * @return	void
	 */
	public function saveOrderAjax()
	{
		$input = JFactory::getApplication()->input;
		$pks = $input->post->get('cid', array(), 'array');
		$order = $input->post->get('order', array(), 'array');
		JArrayHelper::toInteger($pks);
		JArrayHelper::toInteger($order);
		$model = $this->getModel();
		$return = $model->saveorder($pks, $order);
		if ($return)
		{
			echo "1";
		}
		JFactory::getApplication()->close();

	}

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