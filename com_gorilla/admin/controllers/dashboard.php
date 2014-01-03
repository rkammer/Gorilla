<?php
defined('_JEXEC') or die;

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * @package     Joomla.Administrator
 * @subpackage  com_groundwater
 */
class GorillaControllerDashboard extends JControllerLegacy
{
		public function dashboard(){
			$app  = JFactory::getApplication();
			$link = '/admin/index.php?option=com_gorilla';
			$app->redirect($link);
		}
}
