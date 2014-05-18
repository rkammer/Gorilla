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
 * Methods display a list of documents records.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class GorillaViewDocument extends JViewLegacy {

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
	 * Access to config model in view.
	 *
	 * @var    GorillaConfig
	 */
	protected $config;

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

		// Add scripts and styles
		$this->addScripts();

		// Add toolbar in the display
		$this->addToolbar ();

		// Get config object
		$this->config  = GorillaFactory::getNewConfig();

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
		JToolbarHelper::title ( JText::_ ( 'COM_GORILLA_MANAGER_DOCUMENTS' ), 'stack' );

		// Add apply button
		JToolbarHelper::apply('document.apply');

		// Add save button
		JToolbarHelper::save ( 'document.save' );

		// Add save2new (after save, create new record)
		JToolbarHelper::save2new('document.save2new');

		// Add save2copy only when record already exists
		if (!$isNew) {
			JToolbarHelper::save2copy('document.save2copy');
		}

		// show a Cancel button if you create a new record,
		// or a Close button if you are editing an existing record
		if (empty ( $this->item->id )) {
			JToolbarHelper::cancel ( 'document.cancel' );
		} else {
			JToolbarHelper::cancel ( 'document.cancel', 'JTOOLBAR_CLOSE' );
		}

		// Download button
		if (!empty ( $this->item->id )) {
			JToolbarHelper::custom('document.download', 'download', 'download', 'COM_GORILLA_TOOLBAR_DOWNLOAD', false);
		}
	}

	/**
	 * Add extra scripts and style to display
	 *
	 * @return void
	 */
	protected function addScripts()
	{
// 		$doc = JFactory::getDocument();

// 		$script = array();
// 		//$script[] = 'Dropzone.autoDiscover = false;';
// 		$script[] = 'Dropzone.options.dropzoneDiv = {';
// 		$script[] = '	url: "index.php?option=com_gorilla&task=document.dropfile",';
// 		$script[] = '	paramName: "file",';
// 		$script[] = '	maxFilesize: 2, // MB';
// 		$script[] = '	clickable: true,';
// 		$script[] = '	uploadMultiple: false,';
// 		$script[] = '	maxFiles: 1,';
// 		$script[] = '	addRemoveLinks: true,';
// 		$script[] = '	autoProcessQueue: true,';
// 		$script[] = '	accept: function(file, done) {';
// 		$script[] = '			done("Naha, you dont.");';
// 		$script[] = '		}';
// 		$script[] = '};';

// 		foreach ($script as $line) {
// 			$doc->addScriptDeclaration($line);
// 		}

// 		$doc->addScript(JURI::root().'media/com_gorilla/dropzone/dropzone.js');
// 		$doc->addStyleSheet(JURI::root().'media/com_gorilla/dropzone/css/basic.css');
// 		$doc->addStyleSheet(JURI::root().'media/com_gorilla/dropzone/css/dropzone.css');
	}
}