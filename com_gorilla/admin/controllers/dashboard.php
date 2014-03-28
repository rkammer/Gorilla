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

defined('_JEXEC') or die;

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * @package     Joomla.Administrator
 * @subpackage  com_gorilla
 */
class GorillaControllerDashboard extends JControllerLegacy
{
		public function dashboard(){
			$app  = JFactory::getApplication();
			$link = '/admin/index.php?option=com_gorilla';
			$app->redirect($link);
		}
}
