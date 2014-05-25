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
	 * Enable tags in Document.
	 *
	 * @ return void
	 */
	function setupTagsInDocument() {

		$table = JTable::getInstance('Contenttype', 'JTable');
		if(!$table->load(array('type_alias' => 'com_gorilla.document')))
		{
			// Table content

			$table_special = new stdClass;
			$table_special->dbtable = '#__gorilla_document';
			$table_special->key = 'id';
			$table_special->type = 'Document';
			$table_special->prefix = 'GorillaTable';
			$table_special->config = 'array()';

			$table_common = new stdClass;
			$table_common->dbtable = '#__ucm_content';
			$table_common->key = 'ucm_id';
			$table_common->type = 'Corecontent';
			$table_common->prefix = 'JTable';
			$table_common->config = 'array()';

			$table_object = new stdClass;
			$table_object->special = $table_special;
			$table_object->common  = $table_common;

			// Field_mappings content

			$field_mappings_common = new stdClass;
			$field_mappings_common->core_content_item_id = 'id';
			$field_mappings_common->core_title = 'title';
			$field_mappings_common->core_state = 'published';
			$field_mappings_common->core_alias = 'alias';
			$field_mappings_common->core_created_time = 'created';
			$field_mappings_common->core_modified_time = 'modified';
			$field_mappings_common->core_body = 'description';
			$field_mappings_common->core_hits = 'null';
			$field_mappings_common->core_publish_up = 'publish_up';
			$field_mappings_common->core_publish_down = 'publish_down';
			$field_mappings_common->core_access = 'access';
			$field_mappings_common->core_params = 'null';
			$field_mappings_common->core_featured = 'null';
			$field_mappings_common->core_metadata = 'metadata';
			$field_mappings_common->core_language = 'null';
			$field_mappings_common->core_images = 'null';
			$field_mappings_common->core_urls = 'null';
			$field_mappings_common->core_version = 'null';
			$field_mappings_common->core_ordering = 'ordering';
			$field_mappings_common->core_metakey = 'metakey';
			$field_mappings_common->core_metadesc = 'metadesc';
			$field_mappings_common->core_catid = 'null';
			$field_mappings_common->core_xreference = 'null';
			$field_mappings_common->asset_id = 'asset_id';

			$field_mappings_special = new stdClass;
			$field_mappings_special->container_id = 'container_id';
			$field_mappings_special->filename = 'filename';
			$field_mappings_special->checked_out = 'checked_out';
			$field_mappings_special->checked_out_time = 'checked_out_time';
			$field_mappings_special->created_by = 'created_by';
			$field_mappings_special->modified_by = 'modified_by';
			$field_mappings_special->download_count = 'download_count';
			$field_mappings_special->guid = 'guid';

			$field_mappings = new stdClass;
			$field_mappings->common  = $field_mappings_common;
			$field_mappings->special = $field_mappings_special;

			// Content_history_options content

			$content_history_options_displayLookup1 = new stdClass;
			$content_history_options_displayLookup1->sourceColumn = 'created_by';
			$content_history_options_displayLookup1->targetTable = '#__users';
			$content_history_options_displayLookup1->targetColumn = 'id';
			$content_history_options_displayLookup1->displayColumn = 'name';

			$content_history_options_displayLookup2 = new stdClass;
			$content_history_options_displayLookup2->sourceColumn = 'modified_by';
			$content_history_options_displayLookup2->targetTable = '#__users';
			$content_history_options_displayLookup2->targetColumn = 'id';
			$content_history_options_displayLookup2->displayColumn = 'name';

			$content_history_options_displayLookup3 = new stdClass;
			$content_history_options_displayLookup3->sourceColumn = 'container_id';
			$content_history_options_displayLookup3->targetTable = '#__gorilla_containers';
			$content_history_options_displayLookup3->targetColumn = 'id';
			$content_history_options_displayLookup3->displayColumn = 'title';

			$content_history_options = new stdClass;
			$content_history_options->formFile =
				'administrator/components/com_gorilla/models/forms/document.xml';
			$content_history_options->hideFields =
				array('checked_out', 'checked_out_time');
			$content_history_options->ignoreChanges =
				array('modified_by', 'modified', 'checked_out', 'checked_out_time');
			$content_history_options->convertToInt =
				array('publish_up', 'publish_down', 'ordering');
			$content_history_options->displayLookup =
				array($content_history_options_displayLookup1,
			          $content_history_options_displayLookup2,
			          $content_history_options_displayLookup3);

			// Content type register

			$contenttype['type_title'] = 'Gorilla Document';
			$contenttype['type_alias'] = 'com_gorilla.document';
			$contenttype['table'] = json_encode($table_object);
			$contenttype['rules'] = '';
			$contenttype['router'] = 'GorillaHelperRoute::getGorillaRoute';
			$contenttype['field_mappings'] = json_encode($field_mappings);
			$contenttype['content_history_options'] = json_encode($content_history_options);

			$table->save($contenttype);
		}
	}

	/**
	 * Enable tags in Note.
	 *
	 * @ return void
	 */
	function setupTagsInNote() {

		$table = JTable::getInstance('Contenttype', 'JTable');
		if(!$table->load(array('type_alias' => 'com_gorilla.note')))
		{
			// Table content

			$table_special = new stdClass;
			$table_special->dbtable = '#__gorilla_note';
			$table_special->key = 'id';
			$table_special->type = 'Note';
			$table_special->prefix = 'GorillaTable';
			$table_special->config = 'array()';

			$table_common = new stdClass;
			$table_common->dbtable = '#__ucm_content';
			$table_common->key = 'ucm_id';
			$table_common->type = 'Corecontent';
			$table_common->prefix = 'JTable';
			$table_common->config = 'array()';

			$table_object = new stdClass;
			$table_object->special = $table_special;
			$table_object->common  = $table_common;

			// Field_mappings content

			$field_mappings_common = new stdClass;
			$field_mappings_common->core_content_item_id = 'id';
			$field_mappings_common->core_title = 'title';
			$field_mappings_common->core_state = 'published';
			$field_mappings_common->core_alias = 'alias';
			$field_mappings_common->core_created_time = 'created';
			$field_mappings_common->core_modified_time = 'modified';
			$field_mappings_common->core_body = 'description';
			$field_mappings_common->core_hits = 'null';
			$field_mappings_common->core_publish_up = 'publish_up';
			$field_mappings_common->core_publish_down = 'publish_down';
			$field_mappings_common->core_access = 'access';
			$field_mappings_common->core_params = 'null';
			$field_mappings_common->core_featured = 'null';
			$field_mappings_common->core_metadata = 'metadata';
			$field_mappings_common->core_language = 'null';
			$field_mappings_common->core_images = 'null';
			$field_mappings_common->core_urls = 'null';
			$field_mappings_common->core_version = 'null';
			$field_mappings_common->core_ordering = 'ordering';
			$field_mappings_common->core_metakey = 'metakey';
			$field_mappings_common->core_metadesc = 'metadesc';
			$field_mappings_common->core_catid = 'null';
			$field_mappings_common->core_xreference = 'null';
			$field_mappings_common->asset_id = 'asset_id';

			$field_mappings_special = new stdClass;
			$field_mappings_special->container_id = 'container_id';
			$field_mappings_special->checked_out = 'checked_out';
			$field_mappings_special->checked_out_time = 'checked_out_time';
			$field_mappings_special->created_by = 'created_by';
			$field_mappings_special->modified_by = 'modified_by';
			$field_mappings_special->guid = 'guid';

			$field_mappings = new stdClass;
			$field_mappings->common  = $field_mappings_common;
			$field_mappings->special = $field_mappings_special;

			// Content_history_options content

			$content_history_options_displayLookup1 = new stdClass;
			$content_history_options_displayLookup1->sourceColumn = 'created_by';
			$content_history_options_displayLookup1->targetTable = '#__users';
			$content_history_options_displayLookup1->targetColumn = 'id';
			$content_history_options_displayLookup1->displayColumn = 'name';

			$content_history_options_displayLookup2 = new stdClass;
			$content_history_options_displayLookup2->sourceColumn = 'modified_by';
			$content_history_options_displayLookup2->targetTable = '#__users';
			$content_history_options_displayLookup2->targetColumn = 'id';
			$content_history_options_displayLookup2->displayColumn = 'name';

			$content_history_options_displayLookup3 = new stdClass;
			$content_history_options_displayLookup3->sourceColumn = 'container_id';
			$content_history_options_displayLookup3->targetTable = '#__gorilla_containers';
			$content_history_options_displayLookup3->targetColumn = 'id';
			$content_history_options_displayLookup3->displayColumn = 'title';

			$content_history_options = new stdClass;
			$content_history_options->formFile =
				'administrator/components/com_gorilla/models/forms/note.xml';
			$content_history_options->hideFields =
				array('checked_out', 'checked_out_time');
			$content_history_options->ignoreChanges =
				array('modified_by', 'modified', 'checked_out', 'checked_out_time');
			$content_history_options->convertToInt =
				array('publish_up', 'publish_down', 'ordering');
			$content_history_options->displayLookup =
				array($content_history_options_displayLookup1,
					  $content_history_options_displayLookup2,
					  $content_history_options_displayLookup3);

			// Content type register

			$contenttype['type_title'] = 'Gorilla Note';
			$contenttype['type_alias'] = 'com_gorilla.note';
			$contenttype['table'] = json_encode($table_object);
			$contenttype['rules'] = '';
			$contenttype['router'] = 'GorillaHelperRoute::getGorillaRoute';
			$contenttype['field_mappings'] = json_encode($field_mappings);
			$contenttype['content_history_options'] = json_encode($content_history_options);

			$table->save($contenttype);
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
		$this->setupTagsInDocument();
		$this->setupTagsInNote();

		//echo '<p>' . JText::_ ( 'COM_GORILLA_POSTFLIGHT_' . $type . '_TEXT' ) . '</p>';
	}
}
