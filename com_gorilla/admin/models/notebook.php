<?php

// No direct access.
defined('_JEXEC') or die;

/**
 * Model class for notebook.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class GorillaModelNotebook extends JModelAdmin {
	
	// The prefix to use with controller messages.
	protected $text_prefix = 'COM_GORILLA';
	
	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $name     The table name. Optional.
	 * @param   string  $prefix   The class prefix. Optional.
	 * @param   array   $options  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @throws  Exception
	 * 
	 * @see     JModelLegacy
	 */	
	public function getTable($type = 'Notebook', $prefix = 'GorillaTable', $config = array()) {
		return JTable::getInstance ( $type, $prefix, $config );
	}
	
	/**
	 * Method for getting the form from the model.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed  A JForm object on success, false on failure
	 *
	 * @see     JModelForm
	 */	
	public function getForm($data = array(), $loadData = true) {
		$app = JFactory::getApplication ();
		$form = $this->loadForm ( 'com_gorilla.notebook', 'notebook', array (
				'control' => 'jform',
				'load_data' => $loadData 
			) 
		);
		if (empty ( $form )) {
			return false;
		}
		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  array    The default data is an empty array.
	 *
	 * @see  	JModelForm
	 */	
	protected function loadFormData() {
		$data = JFactory::getApplication ()->getUserState ( 'com_gorilla.edit.notebook.data', array () );
		if (empty ( $data )) {
			$data = $this->getItem ();
		}
		return $data;
	}
	
	/**
	 * Prepare and sanitise the table data prior to saving.
	 *
	 * @param   JTable  $table  A reference to a JTable object.
	 *
	 * @return  void
	 *
	 * @see   JModelAdmin
	 */	
	protected function prepareTable($table) {
		$table->title = htmlspecialchars_decode ( $table->title, ENT_QUOTES );
	}
}