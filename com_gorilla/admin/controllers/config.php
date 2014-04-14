<?php

/**
 * Gorilla Config Manager
 *
 * @author     Gorilla Team
 * @copyright  2013-2014 SOHO Prospecting LLC (California - USA)
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link https://www.sohoprospecting.com
 *
 * Try not. Do or do not. There is no try.
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Config controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class GorillaControllerConfig extends JControllerForm
{

	/**
	 * The URL view list variable.
	 * Return from Cancel and Save & Exit.
	 *
	 * @var    string
	 * @since  12.2
	 */
	protected $view_list = 'dashboard';

}
