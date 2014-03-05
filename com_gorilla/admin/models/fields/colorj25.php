<?php

// No direct access.
defined('_JEXEC') or die;

JFormHelper::loadFieldClass('text');

/**
 * Custo field to list notebooks.
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
