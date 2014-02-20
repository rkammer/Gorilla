<?php

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
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise a Error object.
	 *
	 * @see     JViewLegacy
	 */	
	public function display($tpl = null) {
		$this->items = $this->get ( 'Items' );
		if (count ( $errors = $this->get ( 'Errors' ) )) {
			JError::raiseError ( 500, implode ( "\n", $errors ) );
			return false;
		}
		parent::display ( $tpl );
	}
}