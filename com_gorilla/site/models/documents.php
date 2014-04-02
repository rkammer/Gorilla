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

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of documents records.
 *
 * @package		Joomla.Site
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

		// Param documents_order_by
 		$ordering = '';
		switch ($params->get('documents_order_by')) {
			case 1:
				$ordering = 'a.created';
				break;
			case 2:
				$ordering = 'a.title';
				break;
			default:
				$ordering = 'a.ordering';
		}

		// Param documents_order_orientation
 		$orientation = 'asc';
		if ($params->get('documents_order_orientation') == 1) {
			$orientation = 'desc';
		}

		// Verifying params from the caller
		$id = JRequest::getInt('id');
		if ($id == 0) {
			$id = $params->get('notebook');
		}
		$this->setState('id', $id);

		parent::populateState($ordering, $orientation);
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
						'a.title, a.description '
				)
		);
		$query->from('#__gorilla_documents a');

		// Filter by id
		if ($id = $this->getState('id'))
		{
			$query->where('a.notebook_id = '.(int) $id);
		}

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

		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'a.ordering');
		$orderDirn	= $this->state->get('list.direction', 'asc');
		$query->order($db->escape($orderCol.' '.$orderDirn));

		return $query;
	}

}