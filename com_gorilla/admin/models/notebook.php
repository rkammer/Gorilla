<?php

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');
JLoader::import( 'config', JPATH_ADMINISTRATOR.'/components/com_gorilla/models' );

/**
 * Model class for notebook.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class GorillaModelNotebook extends JModelAdmin {
	
	/**
	 * The type alias for this content type.
	 *
	 * @var      string
	 * @since    3.2
	 */
	public $typeAlias = 'com_gorilla.notebook';
	
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
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
			
			// Prime some default values.
			if ($this->getState('notebook.id') == 0)
			{
				// Get next color
				$GorillaModelConfig = new GorillaModelConfig();				
				$data->set('color_code', $GorillaModelConfig->getNextColor());
			}			
		}
		return $data;
	}
	
	private function getNextColor() {
		
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
	protected function prepareTable($table) 
	{
		$date = JFactory::getDate();
		$user = JFactory::getUser();		
		
		$table->title = htmlspecialchars_decode ( $table->title, ENT_QUOTES );
		$table->alias = JApplication::stringURLSafe($table->alias);
		
		if (empty($table->alias))
		{
			$table->alias = JApplication::stringURLSafe($table->title);
		}		
		
		if (empty($table->id))
		{
			// Set the values
		
			// Set ordering to the last item if not set
			if (empty($table->ordering))
			{
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__gorilla_notebooks');
				$max = $db->loadResult();
		
				$table->ordering = $max + 1;
				
				$table->created    = $date->toSql();
				$table->created_by = $user->get('id');				
			}
			
			// Define next color only if actual was used
			$GorillaModelConfig = new GorillaModelConfig();
			
			if (JString::strtoupper($table->color_code) == JString::strtoupper($GorillaModelConfig->getNextColor())) {
				$GorillaModelConfig->setNextColor();
			}
		}				
		else
		{
			// Set the values
			$table->modified    = $date->toSql();
			$table->modified_by = $user->get('id');
		}
	
	}
	
	/**
	 * Method to save the form data.
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since	3.1
	 */
	public function save($data)
	{
		$app = JFactory::getApplication();
	
		// Alter the title for save as copy
		if ($app->input->get('task') == 'save2copy')
		{
			list($name, $alias) = $this->generateNewTitle($data['alias'], $data['title']);
			$data['title']	= $name;
			$data['alias']	= $alias;
			$data['state']	= 0;
		}
	
		return parent::save($data);
	}

	/**
	 * Method to change the title & alias.
	 *
	 * @param   string   $alias        The alias.
	 * @param   string   $title        The title.
	 *
	 * @return	array  Contains the modified title and alias.
	 *
	 * @since	12.2
	 */
	protected function generateNewTitle($alias, $title)
	{
		// Alter the title & alias
		$table = $this->getTable();
		while ($table->load(array('alias' => $alias)))
		{
			$title = JString::increment($title);
			$alias = JString::increment($alias, 'dash');
		}
	
		return array($title, $alias);
	}	
	
}