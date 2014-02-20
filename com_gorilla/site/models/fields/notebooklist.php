<?php

// No direct access.
defined('_JEXEC') or die;

JFormHelper::loadFieldClass('list');

require_once JPATH_ADMINISTRATOR . '/components/com_gorilla/helpers/gorilla.php';

/**
 * Custo field to list notebooks.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class JFormFieldNotebookList extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 */
	protected $type = 'NotebookList';

	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 */
	public function getOptions()
	{
		return GorillaHelper::getNotebookListOptions();
	}
}
