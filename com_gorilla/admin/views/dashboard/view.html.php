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

defined('_JEXEC') or die;

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Dashboard View
 */
class GorillaViewDashboard extends JViewLegacy
{
    /**
    * Dashboard view display method
    * @return void
    */
	function display($tpl = null)
    {
    	JToolBarHelper::title(JText::_('COM_GORILLA'), 'dashboard');

    	// add submenu in view
    	GorillaHelper::addSubmenu('dashboard');

		//Check for errors.
        if (count($errors = $this->get('Errors')))
        {
        	JError::raiseError(500, implode('<br />', $errors));
            return false;
        }

        // Add toolbar in the display
        $this->addToolbar ();

        // Different layout for different version
		if (version_compare(JVERSION, '3', 'lt')) {
			parent::display ( $tpl . 'j25' );
		} else {
			// Add sidebar in the display
			$this->sidebar = JHtmlSidebar::render();

			parent::display ( $tpl );
		}
	}

	/**
	 * Create toolbar for the view.
	 *
	 * @return void
	 */
	protected function addToolbar() {

		// user permissions
		$canDo = GorillaHelper::getActions ();

		// Add title
		JToolbarHelper::title ( JText::_ ( 'COM_GORILLA_MANAGER_DASHBOARD' ), 'dashboard' );

		// Add preferences button if user has permission
		if ($canDo->get ( 'core.admin' )) {
			JToolbarHelper::preferences ( 'com_gorilla' );
		}
	}
}