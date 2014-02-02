<?php

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
		
		if (empty ( $categoryId )) {
			$assetName = 'com_gorilla';
			$level = 'component';
		} else {
			$assetName = 'com_gorilla.category.' . ( int ) $categoryId;
			$level = 'category';
		}
		
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
	public static function addSubmenu($vName = 'notebooks') {
		JHtmlSidebar::addEntry ( JText::_ ( 'COM_GORILLA_SUBMENU_NOTEBOOKS' ), 'index.php?option=com_gorilla&view=notebooks', $vName == 'notebooks' );
// 		JHtmlSidebar::addEntry ( JText::_ ( 'COM_GORILLA_SUBMENU_CATEGORIES' ), 'index.php?option=com_categories&extension=com_folio', $vName == 'categories' );
// 		if ($vName == 'categories') {
// 			JToolbarHelper::title ( JText::sprintf ( 'COM_CATEGORIES_CATEGORIES_TITLE', JText::_ ( 'com_folio' ) ), 'folios-categories' );
// 		}
	}
}