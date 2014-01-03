<?php
defined('_JEXEC') or die;

/**
 * Groundwater master display controller.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_groundwater
 */
class GorillaController extends JControllerLegacy
{
    // Set the default view of component
	protected $default_view = 'dashboard';
	
	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, 
	 *                          for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 */	
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/gorilla.php';
		
		parent::display();
		return $this;
	}
}