<?php

// No direct access.
defined ( '_JEXEC' ) or die ();

/**
 * Script file of Gorilla.
 *
 * @package Joomla.Administrator
 * @subpackage com_gorilla
 */
class Com_GorillaInstallerScript {
	
	/**
	 * Executed after installed.
	 *
	 * @param   JoomlaupdateModelDefault  $parent  The class calling this method
	 *
	 * @return  void
	 * @see     JoomlaupdateModelDefault
	 */	
	function install($parent) {
		//$parent->getParent ()->setRedirectURL ( 'index.php?option=com_gorilla&view=guide&task=install' );
		echo '<p>' . JText::_ ( 'COM_GORILLA_INSTALL_TEXT' ) . '</p>';
	}
	
	/**
	 * Executed after uninstalled.
	 *
	 * @param   JoomlaupdateModelDefault  $parent  The class calling this method
	 *
	 * @return  void
	 * @see     JoomlaupdateModelDefault
	 */	
	function uninstall($parent) {
		echo '<p>' . JText::_ ( 'COM_GORILLA_UNINSTALL_TEXT' ) . '</p>';
	}
	
	/**
	 * Executed after updated.
	 *
	 * @param   JoomlaupdateModelDefault  $parent  The class calling this method
	 *
	 * @return  void
	 * @see     JoomlaupdateModelDefault
	 */	
	function update($parent) {
		//$parent->getParent ()->setRedirectURL ( 'index.php?option=com_gorilla&view=guide&task=update' );
		echo '<p>' . JText::_ ( 'COM_GORILLA_UPDATE_TEXT' ) . '</p>';
	}
	
	/**
	 * Executed before installing/updating.
	 *
	 * @param   String					  $type    Specify operation realized
	 * @param   JoomlaupdateModelDefault  $parent  The class calling this method
	 *
	 * @return  void
	 * @see     JoomlaupdateModelDefault
	 */	
	function preflight($type, $parent) {
		//echo '<p>' . JText::_ ( 'COM_GORILLA_PREFLIGHT_' . $type . '_TEXT' ) . '</p>';
	}
	
	/**
	 * Executed after installing/updating.
	 *
	 * @param   String					  $type    Specify operation realized
	 * @param   JoomlaupdateModelDefault  $parent  The class calling this method
	 *
	 * @return  void
	 * @see     JoomlaupdateModelDefault
	 */
	function postflight($type, $parent) {
		//echo '<p>' . JText::_ ( 'COM_GORILLA_POSTFLIGHT_' . $type . '_TEXT' ) . '</p>';
	}
}
