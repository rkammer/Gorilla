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

jimport('joomla.application.component.modeladmin');

require_once ( JPATH_COMPONENT_ADMINISTRATOR . '/libraries/factories/factory.php' );

/**
 * Methods to access configurations
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class GorillaModelConfig extends JModelAdmin
{

	/**
	 * The type alias for this content type.
	 *
	 * @var      string
	 * @since    3.2
	 */
	public $typeAlias = 'com_gorilla.config';

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
	public function getTable($type = 'Config', $prefix = 'GorillaTable', $config = array()) {
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
		$form = $this->loadForm ( 'com_gorilla.config', 'config', array (
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
	 * Method to build query
	 *
	 * @param string $key Key value of configuration.
	 *
	 * @return string
	 */
	private function getQueryForConfig($key = '') {
		$db 	= $this->getDbo();
		$query	= $db->getQuery(true);

		// Build query
		$query->select($db->quoteName(array('id', 'key', 'value')));
		$query->from('#__gorilla_config');

		// Filter by key
		if (!empty($key)) {
			$query->where($db->quoteName('key') . ' = ' . $db->quote($key));
		}

		return $query;
	}

	/**
	 * Method to get all records from database.
	 *
	 * @return  array    The default data is an empty array.
	 *
	 * @see  	JModelForm
	 */
	private function getAllConfigRecords() {
		$db 	= $this->getDbo();
		$query	= $this->getQueryForConfig();

		// Get the options.
		$db->setQuery($query);

		// Get all config records
		$list = $db->loadObjectList();

		return $list;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  array    The default data is an empty array.
	 *
	 * @see  	JModelForm
	 */
	protected function loadFormData() {
		$data = JFactory::getApplication ()->getUserState ( 'com_gorilla.edit.config.data', array () );
		if (empty ( $data )) {

			$all_fields = array();
			$all_fields['id'] = 1; // dummy ID

			$configs = $this->getAllConfigRecords();
 			if (isset($configs)) {
 				foreach ($configs as $config)
 				{
 					$all_fields[strtolower($config->key)] = $config->value;
 				}
 			}

 			$data = JArrayHelper::toObject($all_fields, 'JObject');
		}
		return $data;
	}

	/**
	 * Update config by key
	 *
	 * @param string $key Key value of configuration.
	 *
	 * @return boolean true when sucessfull
	 *
	 *
	 * @throws JException
	 */
	private function setConfigByKey($key, $value) {
		$db 	= $this->getDbo();
		$query	= $this->getQueryForConfig($key);

		// Build update
		$query->update('#__gorilla_config');

		$query->set($db->quoteName('value') .' = ' . $db->quote($value));

		// Only the right configuration
		$query->where($db->quoteName('key') .' = ' . $db->quote($key));

		// Execute update
		$db->setQuery($query);
		$db->execute();

		// Check for a database error.
		if ($db->getErrorNum())
		{
			JError::raiseWarning(500, $db->getErrorMsg());
		}
	}

	/**
	 * Method to save the form data.
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  boolean  True on success.
	 */
	public function save($data)
	{
		// Validate fields

		// Amazon Tab
		if (!empty($data['amazon_bucket'])) {

			$handlerAmazon = array(
					'key_id'     => $data['amazon_key_id'],
					'secret_key' => $data['amazon_secret_key'],
					'bucket'     => $data['amazon_bucket']
			);

			$GorillaHandler = GorillaFactory::getNewHandler('Amazon', $handlerAmazon);
			if (!$GorillaHandler->createBucket()) {
				foreach ($GorillaHandler->getErrors() as $error) {
					$this->setError($error);
				}
				return false;
			}

		}

		// For each field
		foreach ($data as $key => $value)
		{
			try {
				$this->setConfigByKey($key, $value);
			}
			catch (Exception $e)
			{
				$this->setError($e->getMessage());

				return false;
			}
		}

		return true;
	}

	/**
	 * Method to get config record by key.
	 *
	 * @param string $key Key value of configuration.
	 *
	 * @return one Config object
	 */
	public function getConfigByKey($key) {
		$db 	= $this->getDbo();
		$query	= $this->getQueryForConfig($key);

		// Get the options.
		$db->setQuery($query);

		//$list = $db->loadObjectList();
		$row = $db->loadObject();

		// Check for a database error.
		if ($db->getErrorNum())
		{
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		//return $list;
		return $row;
	}


	/**
	 * Method to get next color to be used in container
	 *
	 * @return string color code. Ex.: '#000000'
	 */
	public function getNextColor() {
		// Get what's the next color
		$next = $this->getConfigByKey('COLOR_CODE_NEXTCOLOR');

		// Get json with colors list
		$json = $this->getConfigByKey('COLOR_CODE_COLORS');

		// Convert json into array
		$colors = json_decode($json->value);

		// Get color code corresponding to the next position
		return $colors[$next->value]->color;
	}

	/**
	 * Method to change next color
	 *
	 * @return void
	 *
	 * @throws JException
	 */
	public function setNextColor() {
		// Get what's the next color
		$next = $this->getConfigByKey('COLOR_CODE_NEXTCOLOR');

		$db 	= $this->getDbo();
		$query	= $db->getQuery(true);

		// Build update
		$query->update('#__gorilla_config');

		// Reset next color or increment
		if ($next->value == 6) {
			$query->set($db->quoteName('value') . ' = 0');
		}
		else {
			$query->set($db->quoteName('value') . ' = ' . $db->quoteName('value') . ' + 1');
		}

		// Only the right configuration
		$query->where($db->quoteName('key') .' = ' . $db->quote('COLOR_CODE_NEXTCOLOR'));

		// Get the options.
		$db->setQuery($query);

		// Execute update
		$db->execute();

		// Check for a database error.
		if ($db->getErrorNum())
		{
			JError::raiseWarning(500, $db->getErrorMsg());
		}
	}

}