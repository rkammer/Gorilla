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

// import joomla controller library
jimport('joomla.application.component.controller');

// Check if the user have access to manage  this component
if (!JFactory::getUser()->authorise('core.manage', 'com_gorilla'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// Add css and js files
$document = JFactory::getDocument();
$document->addStyleSheet('../media/com_gorilla/css/gorilla.css');
if (version_compare(JVERSION, '3', 'lt')) {
	//$document->addScript('../media/com_gorilla/jscolor/jscolor.js');
	//$document->addScript('../media/com_gorilla/js/jquery-2.0.3.min.js');
	//$document->addStyleSheet('../media/com_gorilla/css/gorilla-minicolors.css');
}

// Using legacy to keep MVC compatibility between 2.5 and 3
$controller = JControllerLegacy::getInstance('Gorilla');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
