<?php

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods to load documents from a notebook
 *
 * @package		Joomla.Site
 * @subpackage	com_gorilla
 */
class GorillaModelNotebook extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JModelList
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
					'id', 'a.id',
					'title', 'a.title',
					'access', 'a.access', 'access_level',
					'published', 'a.published',
					'ordering', 'a.ordering'
			);
		}
		parent::__construct($config);
	}
	
	/**
	 * Method to auto-populate the model state.
	 *
	 * This method should only be called once per instantiation and is designed
	 * to be called on the first call to the getState() method unless the model
	 * configuration flag to ignore the request is set.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 *
	 * @see     JModelList
	 */
	protected function populateState($ordering = null, $direction = null) 
	{
		$app = JFactory::getApplication();		

		// Allow to use params in view
		$params = $app->getParams();
		$this->setState('params', $params);

		// Verifying params from the caller		
		$id = JRequest::getInt('id');
		if ($id == 0) {
			$id = $params->get('notebook');
		}
		$this->setState('id', $id);		
	}
	
	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$user	= JFactory::getUser();
	
		// Select the required fields from the table.
		$query->select(
				$this->getState(
						'list.select',
						'a.id, a.title, a.alias, a.color_code, a.description, a.ordering '
				)
		);
	
		$query->from('#__gorilla_notebooks a');
	
		// Filter by published (state)
		$published = $this->getState('filter.published');
		if (is_numeric($published)) {
			$query->where('a.published = ' . (int) $published);
		}
		elseif ($published === '') {
			$query->where('(a.published IN (0, 1))');
		}
		
		// Filter by access level.
		$groups = implode(',', $user->getAuthorisedViewLevels());
		$query->where('a.access IN ('.$groups.')');		
	
		// Filter by id
		if ($id = $this->getState('id'))
		{
			$query->where('a.id = '.(int) $id);
		}
	
		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'a.ordering');
		$orderDirn	= $this->state->get('list.direction', 'asc');
		$query->order($db->escape($orderCol.' '.$orderDirn));
	
		return $query;
	}
	
}