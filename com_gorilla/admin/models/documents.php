<?php

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of documents records.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class GorillaModelDocuments extends JModelList
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
					'ordering', 'a.ordering',
					'notebook_id', 'a.notebook_id', 'notebook_title'
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
	protected function populateState($ordering = null, $direction = null) {
		
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);		
		
		$published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', '', 'string');
		$this->setState('filter.published', $published);	

		$accessId = $this->getUserStateFromRequest($this->context . '.filter.access', 'filter_access', null, 'int');
		$this->setState('filter.access', $accessId);		
		
		$notebookId = $this->getUserStateFromRequest($this->context.'.filter.notebook_id', 'filter_notebook_id', null, 'int');
		$this->setState('filter.notebook_id', $notebookId);		
		
		parent::populateState ( 'a.ordering', 'asc' );
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
				'a.id, a.title, a.alias, a.description, a.notebook_id, ' .
				'a.filename, a.published, ' .
				'a.access, a.ordering, a.checked_out, a.checked_out_time, a.metadesc, ' .
				'a.metakey, a.created, a.created_by, a.modified, a.modified_by, ' .
				'a.publish_up, a.publish_down, a.asset_id, a.download_count '
			)
		);
		
		// Join over the notebooks for the notebook title.
		$query->select('un.title AS notebook_title');
		$query->join('INNER', '#__gorilla_notebooks AS un ON un.id = a.notebook_id');		
		
		// Join over the users for the author user.
		$query->select('ua.name AS author_name');
		$query->join('LEFT', '#__users AS ua ON ua.id = a.created_by');
		
		// Join over the users for the checked out user.
		$query->select('uc.name AS editor');
		$query->join('LEFT', '#__users AS uc ON uc.id = a.checked_out');
		
		// Join over the asset groups.
		$query->select('ag.title AS access_level');
		$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');		
		
		$query->from('#__gorilla_documents a');
		
		// Filter by published (state)
		$published = $this->getState('filter.published');
		if (is_numeric($published)) {
			$query->where('a.published = ' . (int) $published);
		}
		elseif ($published === '') {
			$query->where('(a.published IN (0, 1))');
		}
	
		// Filter by search in title.
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			}
			elseif (stripos($search, 'author:') === 0) {
				$search = $db->Quote('%'.$db->escape(substr($search, 7), true).'%');
				$query->where('(ua.name LIKE '.$search.' OR ua.username LIKE '.$search.')');
			}
			else {
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('(a.title LIKE '.$search.')');
			}
		}
		
		// Filter by notebook.
		if ($notebookId = $this->getState('filter.notebook_id'))
		{
			$query->where('a.notebook_id = ' . (int) $notebookId);
		}		
		
		// Filter by access level.
		if ($access = $this->getState('filter.access'))
		{
			$query->where('a.access = ' . (int) $access);
		}		
		
		// Filter by author
		$authorId = $this->getState('filter.author_id');
		if (is_numeric($authorId)) {
			$type = $this->getState('filter.author_id.include', true) ? '= ' : '<>';
			$query->where('a.created_by '.$type.(int) $authorId);
		}
		
		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'a.ordering');
		$orderDirn	= $this->state->get('list.direction', 'asc');				
		$query->order($db->escape($orderCol.' '.$orderDirn));
		
		return $query;
	}
	
}

