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
defined ( '_JEXEC' ) or die ();

/**
 * Helper for Gorilla.
 *
 * @package Joomla.Administrator
 * @subpackage com_gorilla
 *
 * @link http://worms.wikia.com/wiki/Super_Banana_Bomb
 */
class GorillaHelper {

	/**
	 * function that is used to check to see what permissions the current user has.
	 * Essentially, it is just looking at the component permission settings for the
	 * groups that this user is in.
	 *
	 * @param int $categoryId
	 *        	For category level permissions.
	 *
	 * @return JObject A string if successful, otherwise a Error object.
	 *
	 * @see JViewLegacy
	 */
	public static function getActions($categoryId = 0) {
		$user = JFactory::getUser ();
		$result = new JObject ();

// 		if (empty ( $categoryId )) {
			$assetName = 'com_gorilla';
			$level = 'component';
// 		} else {
// 			$assetName = 'com_gorilla.category.' . ( int ) $categoryId;
// 			$level = 'category';
// 		}

		$actions = JAccess::getActions ( 'com_gorilla', $level );
		foreach ( $actions as $action ) {
			$result->set ( $action->name, $user->authorise ( $action->name, $assetName ) );
		}

		return $result;
	}

	/**
	 * Add submenus for the views of backend
	 *
	 * @param string $vName view's name
	 *
	 * @return void
	 */
	public static function addSubmenu($vName = 'containers') {

		if (version_compare(JVERSION, '3', 'lt')) {
			JSubMenuHelper::addEntry ( JText::_ ( 'COM_GORILLA_SUBMENU_DASHBOARD' ), 'index.php?option=com_gorilla&view=dashboard', $vName == 'dashboard' );
		}
		else {
			JHtmlSidebar::addEntry ( JText::_ ( 'COM_GORILLA_SUBMENU_DASHBOARD' ), 'index.php?option=com_gorilla&view=dashboard', $vName == 'dashboard' );
		}

		if (version_compare(JVERSION, '3', 'lt')) {
			JSubMenuHelper::addEntry ( JText::_ ( 'COM_GORILLA_SUBMENU_CONTAINERS' ), 'index.php?option=com_gorilla&view=containers', $vName == 'containers' );
		}
		else {
			JHtmlSidebar::addEntry ( JText::_ ( 'COM_GORILLA_SUBMENU_CONTAINERS' ), 'index.php?option=com_gorilla&view=containers', $vName == 'containers' );
			// 		JHtmlSidebar::addEntry ( JText::_ ( 'COM_GORILLA_SUBMENU_CATEGORIES' ), 'index.php?option=com_categories&extension=com_folio', $vName == 'categories' );
			// 		if ($vName == 'categories') {
			// 			JToolbarHelper::title ( JText::sprintf ( 'COM_CATEGORIES_CATEGORIES_TITLE', JText::_ ( 'com_folio' ) ), 'folios-categories' );
			// 		}
		}

		if (version_compare(JVERSION, '3', 'lt')) {
			JSubMenuHelper::addEntry ( JText::_ ( 'COM_GORILLA_SUBMENU_DOCUMENTS' ), 'index.php?option=com_gorilla&view=documents', $vName == 'documents' );
		}
		else
		{
			JHtmlSidebar::addEntry ( JText::_ ( 'COM_GORILLA_SUBMENU_DOCUMENTS' ), 'index.php?option=com_gorilla&view=documents', $vName == 'documents' );
		}

        if (version_compare(JVERSION, '3', 'lt')) {
			JSubMenuHelper::addEntry ( JText::_ ( 'COM_GORILLA_SUBMENU_NOTES' ), 'index.php?option=com_gorilla&view=notes', $vName == 'documents' );
		}
		else
		{
			JHtmlSidebar::addEntry ( JText::_ ( 'COM_GORILLA_SUBMENU_NOTES' ), 'index.php?option=com_gorilla&view=notes', $vName == 'notes' );
		}

		//if (JFactory::getUser()->authorise('core.admin', 'com_gorilla')) {
			if (version_compare(JVERSION, '3', 'lt')) {
				JSubMenuHelper::addEntry ( JText::_ ( 'COM_GORILLA_SUBMENU_CONFIG' ), 'index.php?option=com_gorilla&view=config', $vName == 'config' );
			}
			else
			{
				JHtmlSidebar::addEntry ( JText::_ ( 'COM_GORILLA_SUBMENU_CONFIG' ), 'index.php?option=com_gorilla&view=config', $vName == 'config' );
			}
		//}

	}

	/**
	 * Generic list (combo) creater for containers.
	 *
	 * @return array  The field option objects.
	 */
	public static function getContainerListOptions() {
		// Initialize variables.
		$options = array();

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('a.id AS value, a.title AS text');
		$query->from('#__gorilla_containers AS a');
		$query->where('a.published = 1');
		$query->order('a.ordering, a.alias');

		// Get the options.
		$db->setQuery($query);

		$options = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum())
		{
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		// Merge any additional options in the XML definition.
		//$options = array_merge(parent::getOptions(), $options);
		array_unshift($options, JHtml::_('select.option', '', JText::_('COM_GORILLA_CONTAINER_LIST_SELECT')));

		return $options;
	}

    /**
	 * Generates and returns a guid
	 *
	 * @return string guid
	 */
    public static function getGUID()
    {
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $guid = substr($charid, 0, 8).chr(45)
               .substr($charid, 8, 4).chr(45)
               .substr($charid,12, 4).chr(45)
               .substr($charid,16, 4).chr(45)
               .substr($charid,20,12);
        return $guid;
    }
}