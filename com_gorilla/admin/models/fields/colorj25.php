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

JFormHelper::loadFieldClass('text');

/**
 * Custo field to list containers.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class JFormFieldColorJ25 extends JFormFieldText
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 */
	protected $type = 'ColorJ25';

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   11.1
	 */
	protected function getInput()
	{
		// Include JS library
		JHtml::_('script', 'media/com_gorilla/jscolor/jscolor.js');

		return parent::getInput();
	}
}
