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
 * Methods display a list of notebooks records.
 *
 * @package		Joomla.Site
 * @subpackage	com_gorilla
 */
class GorillaViewNotebook extends JViewLegacy
{

	/**
	 * Items from models
	 *
	 * @var array
	 */
	protected $items;

	/**
	 * Params from xml
	 *
	 * @var JRegistry
	 */
	protected $params;

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

		$this->items = $this->get ( 'Items' );
		if (count ( $errors = $this->get ( 'Errors' ) )) {
			JError::raiseError ( 500, implode ( "\n", $errors ) );
			return false;
		}

		// Allow to use params in view
		$params = $app->getParams();
		$this->params = &$params;

		parent::display ( $tpl );
	}
}