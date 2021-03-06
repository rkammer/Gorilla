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
 * Methods display a list of containers records.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class GorillaViewContainer extends JViewLegacy {

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
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise a Error object.
	 *
	 * @see     JViewLegacy
	 */
	public function display($tpl = null) {

		// call gets the data from the model file
		$this->item = $this->get ( 'Item' );
		$this->form = $this->get ( 'Form' );

		// error in SQL
		if (count ( $errors = $this->get ( 'Errors' ) )) {
			JError::raiseError ( 500, implode ( "\n", $errors ) );
			return false;
		}

		// Add toolbar in the display
		$this->addToolbar ();

		// Different layout for different version
		if (version_compare(JVERSION, '3', 'lt')) {
			parent::display ( $tpl . 'j25' );
		} else {
			parent::display ( $tpl );
		}
	}

	/**
	 * Create toolbar for the view.
	 *
	 * @return void
	 */
	protected function addToolbar() {

		// hide the main menu so we don't see links to the other views
		JFactory::getApplication ()->input->set ( 'hidemainmenu', true );

		// New record
		$isNew = ($this->item->id == 0);

		// Add title
		JToolbarHelper::title ( JText::_ ( 'COM_GORILLA_MANAGER_CONTAINERS' ), 'book' );

		// Add apply button
		JToolbarHelper::apply('container.apply');

		// Add save button
		JToolbarHelper::save ( 'container.save' );

		// Add save2new (after save, create new record)
		JToolbarHelper::save2new('container.save2new');

		// Add save2copy only when record already exists
		if (!$isNew) {
			JToolbarHelper::save2copy('container.save2copy');
		}

		// show a Cancel button if you create a new record,
		// or a Close button if you are editing an existing record
		if (empty ( $this->item->id )) {
			JToolbarHelper::cancel ( 'container.cancel' );
		} else {
			JToolbarHelper::cancel ( 'container.cancel', 'JTOOLBAR_CLOSE' );
		}
	}
}