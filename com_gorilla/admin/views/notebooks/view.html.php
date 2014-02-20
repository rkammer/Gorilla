<?php

// No direct access.
defined('_JEXEC') or die;

/**
 * Methods display a list of notebooks records.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class GorillaViewNotebooks extends JViewLegacy {
	
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
		GorillaHelper::addSubmenu('notebooks');
		
		// error in SQL
		if (count ( $errors = $this->get ( 'Errors' ) )) {
			JError::raiseError ( 500, implode ( "\n", $errors ) );
			return false;
		}
		
		// Add toolbar in the display
		$this->addToolbar ();
		
		// Add sidebar in the display
		$this->sidebar = JHtmlSidebar::render();
		
		parent::display ( $tpl );
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
		JToolbarHelper::title ( JText::_ ( 'COM_GORILLA_MANAGER_NOTEBOOKS' ), 'book' );
		
		// Add add-new button
		JToolbarHelper::addNew ( 'notebook.add' );
		
		// Add edit button if user has permission
		if ($canDo->get ( 'core.edit' )) {
			JToolbarHelper::editList ( 'notebook.edit' );
		}
		
		// Add other default edit buttons
		if ($canDo->get('core.edit.state')) {
			JToolbarHelper::publish('notebooks.publish', 'JTOOLBAR_PUBLISH', true);
			JToolbarHelper::unpublish('notebooks.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			JToolbarHelper::archiveList('notebooks.archive');
			JToolbarHelper::checkin('notebooks.checkin');
		}

		// Add trash buttons (works only in Joomla 3)
		$state = $this->get('State');
		if ($state->get('filter.published') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('', 'notebooks.delete', 'JTOOLBAR_EMPTY_TRASH');
		} elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('notebooks.trash');
		}		
		
		// Add preferences button if user has permission
		if ($canDo->get ( 'core.admin' )) {
			JToolbarHelper::preferences ( 'com_gorilla' );
		}
		
		JHtmlSidebar::setAction('index.php?option=com_gorilla&view=notebooks');
		
		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_PUBLISHED'), 'filter_published',
			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 
				'value', 'text', $this->state->get('filter.published'), true)
		);		
		
		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_ACCESS'), 'filter_access',
			JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'))
		);		
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
				'a.access' => JText::_('JGRID_HEADING_ACCESS')
		);
	}	
}