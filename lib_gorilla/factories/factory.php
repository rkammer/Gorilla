<?php

/**
 * Gorilla Document Manager
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

// Import dependencies
jimport('gorilla.handlers.handler');
jimport('gorilla.handlers.amazon.handler');

/**
 * Gorilla factory
 *
 * @package		Joomla.Library
 * @subpackage	lib_gorilla
 */
class GorillaFactory
{

	/**
	 * Get Gorilla configuration object.
	 *
	 * @return GorillaModelConfig
	 */
	public static function getNewConfig() {

		return new GorillaModelConfig();

	}

	/**
	 * Create new GorillaHandlers according to the storage configuration.
	 *
	 * @return Specialized GorillaHandler according with config.
	 */
	public static function getNewHandler() {

		return new GorillaHandlerAmazon();

	}

}