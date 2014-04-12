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
defined ( '_JEXEC' ) or die ();

jimport( 'joomla.html.parameter' );

/**
 * Script file of Gorilla.
 *
 * @package Joomla.Administrator
 * @subpackage com_gorilla
 */
class Com_GorillaInstallerScript {

	/**
	 * Default configurations
	 *
	 * @ return void
	 */
	function configure() {
		//load params
		$component = JComponentHelper::getComponent("com_gorilla");

		//data array for bind, check and save
		$params	= array(
				'params'	=> $component->params->toArray(),
				'id'		=> $component->id
		);

		$table	= JTable::getInstance('extension');
		// Load the previous Data
		if (!$table->load($params['id'])) {
			$this->setError($table->getError());
			return false;
		}

		// Change configurations
		$cParams = $component->params;
		$cParams->set('show_description', 				$cParams->get('show_description', 				'1') );
		$cParams->set('show_color_code', 				$cParams->get('show_color_code', 				'1') );
		$cParams->set('order_by', 						$cParams->get('order_by', 						'0') );
		$cParams->set('order_orientation', 				$cParams->get('order_orientation', 				'0') );
		$cParams->set('number_of_columns', 				$cParams->get('number_of_columns', 				'3') );
		$cParams->set('show_container_description', 	$cParams->get('show_container_description', 		'1') );
		$cParams->set('show_container_color_code', 		$cParams->get('show_container_color_code', 		'1') );
		$cParams->set('show_document_description', 		$cParams->get('show_document_description', 		'1') );
		$cParams->set('documents_order_by', 			$cParams->get('documents_order_by', 			'0') );
		$cParams->set('documents_order_orientation', 	$cParams->get('documents_order_orientation', 	'0') );
		$params['params'] = $cParams->toArray();

		// Bind the data.
		if (!$table->bind($params)) {
			$this->setError($table->getError());
			return false;
		}

		// Check the data.
		if (!$table->check()) {
			$this->setError($table->getError());
			return false;
		}

		// Store the data.
		if (!$table->store()) {
			$this->setError($table->getError());
			return false;
		}

	}

	/**
	 * Executed after installed.
	 *
	 * @param   JoomlaupdateModelDefault  $parent  The class calling this method
	 *
	 * @return  void
	 * @see     JoomlaupdateModelDefault
	 */
	function install($parent) {
		//$parent->getParent ()->setRedirectURL ( 'index.php?option=com_gorilla&view=guide&task=install' );
		echo '<p>' . JText::_ ( 'COM_GORILLA_INSTALL_TEXT' ) . '</p>';
	}

	/**
	 * Executed after uninstalled.
	 *
	 * @param   JoomlaupdateModelDefault  $parent  The class calling this method
	 *
	 * @return  void
	 * @see     JoomlaupdateModelDefault
	 */
	function uninstall($parent) {
		echo '<p>' . JText::_ ( 'COM_GORILLA_UNINSTALL_TEXT' ) . '</p>';
	}

	/**
	 * Executed after updated.
	 *
	 * @param   JoomlaupdateModelDefault  $parent  The class calling this method
	 *
	 * @return  void
	 * @see     JoomlaupdateModelDefault
	 */
	function update($parent) {
		//$parent->getParent ()->setRedirectURL ( 'index.php?option=com_gorilla&view=guide&task=update' );
		echo '<p>' . JText::_ ( 'COM_GORILLA_UPDATE_TEXT' ) . '</p>';
	}

	/**
	 * Executed before installing/updating.
	 *
	 * @param   String					  $type    Specify operation realized
	 * @param   JoomlaupdateModelDefault  $parent  The class calling this method
	 *
	 * @return  void
	 * @see     JoomlaupdateModelDefault
	 */
	function preflight($type, $parent) {
		//echo '<p>' . JText::_ ( 'COM_GORILLA_PREFLIGHT_' . $type . '_TEXT' ) . '</p>';
	}

	/**
	 * Executed after installing/updating.
	 *
	 * @param   String					  $type    Specify operation realized
	 * @param   JoomlaupdateModelDefault  $parent  The class calling this method
	 *
	 * @return  void
	 * @see     JoomlaupdateModelDefault
	 */
	function postflight($type, $parent) {

		$this->configure();

		//echo '<p>' . JText::_ ( 'COM_GORILLA_POSTFLIGHT_' . $type . '_TEXT' ) . '</p>';
	}
}
