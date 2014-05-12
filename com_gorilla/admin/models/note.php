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

// Import dependencies
jimport('joomla.application.component.modeladmin');
JLoader::import( 'config', JPATH_ADMINISTRATOR.'/components/com_gorilla/models' );

require_once dirname(__FILE__) . '/../helpers/gorilla.php';
require_once ( JPATH_COMPONENT_ADMINISTRATOR . '/libraries/factories/factory.php' );

//Import filesystem libraries.
jimport('joomla.filesystem.file');

/**
 * Model class for note.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class GorillaModelNote extends JModelAdmin {

	/**
	 * The type alias for this content type.
	 *
	 * @var      string
	 * @since    3.2
	 */
	public $typeAlias = 'com_gorilla.note';

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
	public function getTable($type = 'Note', $prefix = 'GorillaTable', $config = array()) {
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
		$form = $this->loadForm ( 'com_gorilla.note', 'note', array (
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
		$data = JFactory::getApplication ()->getUserState ( 'com_gorilla.edit.note.data', array () );
		if (empty ( $data )) {
			$data = $this->getItem ();

			// Prime some default values.
			// if ($this->getState('note.id') == 0)
			// {
				// Get next color
				// $GorillaModelConfig = new GorillaModelConfig();
				// $data->set('color_code', $GorillaModelConfig->getNextColor());
			// }

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
				$db->setQuery('SELECT MAX(ordering) FROM #__gorilla_notes');
				$max = $db->loadResult();

				$table->ordering = $max + 1;

			}
			$table->created    = $date->toSql();
			$table->created_by = $user->get('id');

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
			list($name, $alias) = $this->generateNewTitle(null, $data['alias'], $data['title']);
			$data['title']	= $name;
			$data['alias']	= $alias;
			$data['state']	= 0;
		}

		if (empty($data['id'])) {
			// Generate new GUID
			$data['guid'] = GorillaHelper::getGUID();
		}

		// $files = $app->input->files->get('jform', '', 'array');
		// if (empty($files['upload_file']['name'])) {
			// Must have a file when new
			// if (empty($data['id'])) {
				// $this->setError(JText::sprintf('COM_GORILLA_NOTE_MUST_HAVE_FILE'), 'warning');
				// return false;
			// }
		// }
		// else {
			// $file_name = $this->_upload($files['upload_file'], $data['guid']);
			// if (!$file_name) {
				// $this->setError(JText::sprintf('COM_GORILLA_NOTE_ERROR_ON_UPLOAD'));
				// return false;
			// }

			// $data['file_name'] = $file_name;
		// }


		return parent::save($data);
	}

	/**
	 * Method to change the title & alias.
	 *
	 * @param   integer  $category_id  The id of the category.
	 * @param   string   $alias        The alias.
	 * @param   string   $title        The title.
	 *
	 * @return	array  Contains the modified title and alias.
	 *
	 * @since	12.2
	 */
	protected function generateNewTitle($category_id, $alias, $title)
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

	/**
	 * Method to sanitized and persiste uploaded file.
	 *
	 * @param   file     $file  	   Uploaded file in tmp dir
	 * @param   string   $guid  	   Guid to identify file
	 *
	 * @return	mixed  	 File name on success, false on failure
	 */
	// protected function _upload(&$file, $guid)
	// {
		// $file_name = '';

		// Sanitize file name
		// $file['name']      = JFile::makeSafe($file['name']);
		// $file_name         = $file['name'];

		// Getting max size in Bytes (1024 to KB, 1025 to MB)
		// $max = ini_get('upload_max_filesize') * 1024 * 1024;

		// Testing file size
		// if($file['size'] > $max) {
			// $this->setError(JText::sprintf('COM_GORILLA_NOTE_MAXIMUM_FILE_SIZE', $max));
			// return false;
		// }

		// if($guid == '') {
			// $this->setError(JText::sprintf('COM_GORILLA_NOTE_GUID_EMPTY'));
			// return false;
		// }

		// Upload
		// $GorillaHandler = GorillaFactory::getNewHandler('Amazon');
		// if (!$GorillaHandler->upload($guid, $file)) {
			// foreach ($GorillaHandler->getErrors() as $error) {
				// $this->setError($error);
			// }
			// return false;
		// }

		// return $file_name;
	}

}