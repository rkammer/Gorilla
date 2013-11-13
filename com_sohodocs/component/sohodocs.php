<?php

	error_reporting(E_ALL);

	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import joomla controller library
	jimport('joomla.application.component.controller');

	// Get an instance of the controller prefixed by SohoWater
	$controller = JControllerLegacy::getInstance('SohoDocs');

	// Perform the Request task
	$input = JFactory::getApplication()->input;
	$controller->execute($input->getCmd('task'));

	// Redirect if set by the controller
	$controller->redirect();