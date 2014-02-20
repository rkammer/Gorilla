<?php
defined('_JEXEC') or die;

// import joomla controller library
jimport('joomla.application.component.controller');

// Add css and js files
$document = JFactory::getDocument();
$document->addStyleSheet('./media/com_gorilla/css/gorilla.css');

// Get an instance of the controller prefixed by SohoWater
$controller = JControllerLegacy::getInstance('Gorilla');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();