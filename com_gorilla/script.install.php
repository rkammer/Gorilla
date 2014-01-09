<?php
// No direct access to this file
defined('_JEXEC') or die;
 
/**
 * Class to help installation of Gorilla component.
 */
class com_gorillaInstallerScript
{

	function install($parent) 
	{
		$parent->getParent()->setRedirectURL('index.php?option=com_gorilla&view=guide&task=install');
	}

	function uninstall($parent) 
	{
		//echo '<p>' . JText::_('COM_GORILLA_UNINSTALL_TEXT') . '</p>';
	}

	function update($parent) 
	{
		$parent->getParent()->setRedirectURL('index.php?option=com_gorilla&view=guide&task=update');
	}

	function preflight($type, $parent) 
	{
		//echo '<p>' . JText::_('COM_GORILLA_PREFLIGHT_' . $type . '_TEXT') . '</p>';
	}

	function postflight($type, $parent) 
	{
		//echo '<p>' . JText::_('COM_GORILLA_POSTFLIGHT_' . $type . '_TEXT') . '</p>';
	}
}