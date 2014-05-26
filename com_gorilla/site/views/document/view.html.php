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

require_once JPATH_COMPONENT . '/models/container.php';

/**
 * Methods display a document record.
 *
 * @package		Joomla.Site
 * @subpackage	com_gorilla
 */
class GorillaViewDocument extends JViewLegacy
{

	/**
	 * State data
	 *
	 * @var    JRegistry
	 */
	protected $state;

	/**
	 * Item from models
	 *
	 * @var array
	 */
	protected $item;

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
		$documents  		= $this->get('Items');

		// Check if return a container
		if (count($documents) != 1) {
			JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
			return false;
		}
		$this->item = $documents[0];

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