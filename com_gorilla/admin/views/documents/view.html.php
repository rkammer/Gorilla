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

// No direct access.
defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/../../helpers/gorilla.php';

/**
 * Methods display a list of documents records.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class GorillaViewDocuments extends JViewLegacy {

	/**
	 * Items from models
	 *
	 * @var array
	 */
	protected $items;

	/**
	 * Current state of the list
	 *
	 * @var array
	 */
	protected $state;

	/**
	 * Current pagination for the data set
	 *
	 * @var JPagination
	 */
	protected $pagination;

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
		$this->items = $this->get ( 'Items' );

		// get current state of the list
		$this->state = $this->get('State');

		// get a JPagination object for the data set
		$this->pagination = $this->get('Pagination');

		// add submenu in view
		GorillaHelper::addSubmenu('documents');

		// error in SQL
		if (count ( $errors = $this->get ( 'Errors' ) )) {
			JError::raiseError ( 500, implode ( "\n", $errors ) );
			return false;
		}

		// Add scripts and styles
		$this->addScripts();

		// Add toolbar in the display
		$this->addToolbar();

		// Different layout for different version
		if (version_compare(JVERSION, '3', 'lt')) {

			// Load filter
			$this->filter = $this->addFilter();

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

		// Add toolbar
		$bar = JToolBar::getInstance ( 'toolbar' );

		// Add title
		JToolbarHelper::title ( JText::_ ( 'COM_GORILLA_MANAGER_DOCUMENTS' ), 'stack' );

		// Add add-new button
		JToolbarHelper::addNew ( 'document.add' );

		// Add edit button if user has permission
		if ($canDo->get ( 'core.edit' )) {
			JToolbarHelper::editList ( 'document.edit' );
		}

		// Add other default edit buttons
		if ($canDo->get('core.edit.state')) {
			JToolbarHelper::publish('documents.publish', 'JTOOLBAR_PUBLISH', true);
			JToolbarHelper::unpublish('documents.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			JToolbarHelper::archiveList('documents.archive');
			JToolbarHelper::checkin('documents.checkin');
		}

		// Add trash buttons (works only in Joomla 3)
		$state = $this->get('State');
		if ($state->get('filter.published') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('', 'documents.delete', 'JTOOLBAR_EMPTY_TRASH');
		} elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('documents.trash');
		}

		// Add preferences button if user has permission
		if ($canDo->get ( 'core.admin' )) {
			JToolbarHelper::preferences ( 'com_gorilla' );
		}

		if (version_compare(JVERSION, '3', 'lt')) {

		}
		else {
			JHtmlSidebar::setAction('index.php?option=com_gorilla&view=documents');

			JHtmlSidebar::addFilter(
				JText::_('JOPTION_SELECT_PUBLISHED'), 'filter_published',
				JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'),
					'value', 'text', $this->state->get('filter.published'), true)
			);

			//Get container options
			JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
			$containerList = JFormHelper::loadFieldType('ContainerList', false);
			$containerListOptions = $containerList->getOptions();

			JHtmlSidebar::addFilter(
				JText::_('COM_GORILLA_DOCUMENTS_FIELD_CONTAINER_ID_LABEL'), 'filter_container_id',
				JHtml::_('select.options', $containerListOptions, 'value', 'text', $this->state->get('filter.container_id')),
				true
			);

			JHtmlSidebar::addFilter(
				JText::_('JOPTION_SELECT_ACCESS'), 'filter_access',
				JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'))
			);
		}
	}

	/**
	 * Return fields that can be sorted in the grid
	 *
	 * @return array
	 */
	protected function getSortFields()
	{
		return array(
				'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
				'a.published' => JText::_('JSTATUS'),
				'a.title' => JText::_('JGLOBAL_TITLE'),
				'a.id' => JText::_('JGRID_HEADING_ID'),
				'a.access' => JText::_('JGRID_HEADING_ACCESS'),
				'a.container_id' => JText::_('COM_GORILLA_DOCUMENTS_FIELD_CONTAINER_ID_LABEL')
		);
	}

	/**
	 * Add the filter.
	 * Only for Joomla 2.5.
	 */
	protected function addFilter()
	{
		$original_layout = $this->getLayout();
		$this->setLayout('j25');
		$this->addTemplatePath( JPATH_ROOT . '/administrator/components/com_gorilla/views/common/tmpl' );
		$filter = $this->loadTemplate('filter');
		$this->setLayout(  $original_layout );
		return $filter;
	}

	/**
	 * Add extra scripts and style to display
	 *
	 * @return void
	 */
	protected function addScripts()
	{
		if (version_compare(JVERSION, '3', 'lt')) {
			$doc = JFactory::getDocument();
			$doc->addScript(JURI::root().'media/com_gorilla/js/jquery-2.0.3.min.js');
			//$doc->addScript(JURI::root().'media/com_gorilla/js/bootstrap.js');
			//$doc->addStyleSheet(JURI::root().'media/com_gorilla/css/bootstrap.css');
			$doc->addStyleSheet(JURI::root().'media/com_gorilla/css/gorilla-minicolors.css');
		}
	}
}