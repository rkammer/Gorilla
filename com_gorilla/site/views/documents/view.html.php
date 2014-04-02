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

/**
 * Methods display a list of documents records.
 *
 * @package		Joomla.Site
 * @subpackage	com_gorilla
 */
class GorillaViewDocuments extends JViewLegacy
{

	/**
	 * State data
	 *
	 * @var    JRegistry
	 */
	protected $state;

	/**
	 * Items from models
	 *
	 * @var array
	 */
	protected $items;

	/**
	 * Notebook from models
	 *
	 * @var array
	 */
	protected $notebook;

	/**
	 * Params from xml
	 *
	 * @var JRegistry
	 */
	protected $params;

	/**
	 * Pagination for the list
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
	public function display($tpl = null)
	{
		$app = JFactory::getApplication();

		$this->state 		= $this->get('State');
		$this->items 		= $this->get('Items');
		
		// Check if return a notebook
		if (count($this->get('Items', 'Notebook')) == 0) {
			JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
			return false;			
		}
		
		$this->notebook		= $this->get('Items', 'Notebook')[0];
		$this->pagination   = $this->get('Pagination');

		// Check for errors
		if (count ( $errors = $this->get('Errors') )) {
			JError::raiseError ( 500, implode ( "\n", $errors ) );
			return false;
		}

		// Allow to use params in view
		$params = $app->getParams();
		$this->params = &$params;

		parent::display ( $tpl );
	}
}