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

JFormHelper::loadFieldClass('list');

require_once dirname(__FILE__) . '/../../helpers/gorilla.php';

/**
 * Custo field to list containers.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class JFormFieldContainerList extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 */
	protected $type = 'ContainerList';

	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 */
	public function getOptions()
	{
		return GorillaHelper::getContainerListOptions();
	}
}
