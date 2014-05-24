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

/**
 * Gorilla factory
 *
 * @package		Joomla.Library
 * @subpackage	lib_gorilla
 */
class GorillaFactory
{

	/**
	 * Create new GorillaHandlers according to the storage configuration.
	 *
	 * @param   string   $sufix       Handler Sufix. Complete list:
	 * 								  - Amazon
	 *                                - Drop
     *
	 * @param   array    $properties  Array of properties needed in constructor.
	 *
	 * @return Specialized GorillaHandler according with config.
	 */
	public static function getNewHandler($sufix, $properties = null) {

		switch($sufix) {
			case 'Amazon':

				// Import dependencies
				require_once ( JPATH_COMPONENT_ADMINISTRATOR . '/libraries/handlers/amazon/handler.php' );

				$class = "GorillaHandler".$sufix;

				if (isset($properties)) {
					return new $class(
							false,
							$properties['key_id'],
							$properties['secret_key'],
							$properties['bucket']
						);
				}
				return new $class(true);

			case 'Drop':

				// Import dependencies
				require_once ( JPATH_COMPONENT_ADMINISTRATOR . '/libraries/handlers/local/drop.php' );

				$class = "GorillaHandler".$sufix;

				return new $class();
		}


	}

}