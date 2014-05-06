<?php

/**
 * Gorilla Note Manager
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

jimport('joomla.application.component.controlleradmin');

/**
 * Notes list controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class GorillaControllerNotes extends JControllerAdmin
{

	/**
	 * Proxy for getModel.
	 *
	 * @param	string	$name	The name of the model.
	 * @param	string	$prefix	The prefix for the PHP class name.
	 *
	 * @return	JModel
	 */
	public function getModel($name = 'Note', $prefix = 'GorillaModel')
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}

	/**
	 * Called from form list to change order with drag and drop.
	 *
	 * @return	void
	 */
	public function saveOrderAjax()
	{
		$input = JFactory::getApplication()->input;
		$pks = $input->post->get('cid', array(), 'array');
		$order = $input->post->get('order', array(), 'array');
		JArrayHelper::toInteger($pks);
		JArrayHelper::toInteger($order);
		$model = $this->getModel();
		$return = $model->saveorder($pks, $order);
		if ($return)
		{
			echo "1";
		}
		JFactory::getApplication()->close();

	}
}