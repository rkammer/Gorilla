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
 * Gorilla master display controller.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class GorillaController extends JControllerLegacy
{
    // Set the default view of component
	protected $default_view = 'dashboard';

	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types,
	 *                          for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 */
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/gorilla.php';

		$view	= JFactory::getApplication()->input->get('view', 'containers');
		$layout = JFactory::getApplication()->input->get('layout', 'default');
		$id		= JFactory::getApplication()->input->getInt('id');

		// Protect edit view from direct access
		if ($view == 'container' && $layout == 'edit' && !$this->checkEditId('com_gorilla.edit.container', $id))
		{
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_gorilla&view=containers', false));
			return false;
		}

		// Protect edit view from direct access
		if ($view == 'document' && $layout == 'edit' && !$this->checkEditId('com_gorilla.edit.document', $id))
		{
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_gorilla&view=documents', false));
			return false;
		}

		// Not allow config without config permission
		if ($view == 'config' && !JFactory::getUser()->authorise('core.admin', 'com_gorilla'))
		{
			$this->setError(JText::sprintf('JERROR_ALERTNOAUTHOR', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_gorilla&view=dashboard', false));
			return false;
		}

		parent::display();

		return $this;
	}
}