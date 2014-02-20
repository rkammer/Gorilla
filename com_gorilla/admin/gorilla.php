<?php

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
$document->addStyleSheet('./media/com_gorilla/css/gorilla.css');

// Using legacy to keep MVC compatibility between 2.5 and 3
$controller = JControllerLegacy::getInstance('Gorilla');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
