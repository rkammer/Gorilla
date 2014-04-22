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

defined('_JEXEC') or die;

/**
 * Methods display the config.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class GorillaViewConfig extends JViewLegacy
{

	/**
	 * Store the data retrieved from the model
	 *
	 * @var    array
	 */
	protected $item;

	/**
	 * Array of form objects.
	 *
	 * @var    array
	 */
	protected $form;

    /**
    * View display method
    * @return void
    */
	function display($tpl = null)
    {
    	// call gets the data from the model file
    	$this->item = $this->get ( 'Item' );
    	$this->form = $this->get ( 'Form' );

    	// add submenu in view
    	GorillaHelper::addSubmenu('config');

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

		// hide the main menu so we don't see links to the other views
		//JFactory::getApplication ()->input->set ( 'hidemainmenu', true );

		// Add title
		JToolbarHelper::title ( JText::_ ( 'COM_GORILLA_MANAGER_CONFIG' ), 'cog' );

		// Add apply button
		JToolbarHelper::apply('config.apply');

		// Add save button
		JToolbarHelper::save ( 'config.save' );

		// Add cancel button
		JToolbarHelper::cancel ( 'config.cancel' );

		// Add preferences button if user has permission
		if ($canDo->get ( 'core.admin' )) {
			JToolbarHelper::preferences ( 'com_gorilla' );
		}
	}

}