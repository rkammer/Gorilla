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

/**
 * Table class for note.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class GorillaTableNote extends JTable {

	/**
	 * Object constructor to set table and key fields.  In most cases this will
	 * be overridden by child classes to explicitly set the table and key fields
	 * for a particular database table.
	 *
	 * @param   string           $table  Name of the table to model.
	 * @param   mixed            $key    Name of the primary key field in the table or array of field names that compose the primary key.
	 * @param   JDatabaseDriver  $db     JDatabaseDriver object.
	 *
	 * @see   JTable
	 */
	public function __construct(&$db) {
		parent::__construct ( '#__gorilla_notes', 'id', $db );
		JObserverMapper::addObserverClassToClass('JTableObserverTags', 'GorillaTableNote', array('typeAlias' => 'com_gorilla.note'));
	}

	/**
	 * Method to bind an associative array or object to the JTable instance.This
	 * method only binds properties that are publicly accessible and optionally
	 * takes an array of properties to ignore when binding.
	 *
	 * @param   mixed  $src     An associative array or object to bind to the JTable instance.
	 * @param   mixed  $ignore  An optional array or space separated list of properties to ignore while binding.
	 *
	 * @return  boolean  True on success.
	 *
	 * @see     JTable
	 * @throws  InvalidArgumentException
	 */
	public function bind($array, $ignore = '')
	{
		// Bind the metadata.
		if (isset($array['metadata']) && is_array($array['metadata']))
		{
			$registry = new JRegistry;
			$registry->loadArray($array['metadata']);
			$array['metadata'] = (string) $registry;
		}

		// Bind the rules.
		if (isset($array['rules']) && is_array($array['rules']))
		{
			$rules = new JAccessRules($array['rules']);
			$this->setRules($rules);
		}
		return parent::bind ( $array, $ignore );
	}

	/**
	 * Method to store a row in the database from the JTable instance properties.
	 * If a primary key value is set the row with that primary key value will be
	 * updated with the instance property values.  If no primary key value is set
	 * a new row will be inserted into the database with the properties from the
	 * JTable instance.
	 *
	 * @param   boolean  $updateNulls  True to update fields even if they are null.
	 *
	 * @return  boolean  True on success.
	 *
	 * @see     JTable
	 */
	public function store($updateNulls = false) {
		return parent::store ( $updateNulls );
	}

	/**
	 * Method to compute the default name of the asset.
	 * The default name is in the form table_name.id
	 * where id is the value of the primary key of the table.
	 *
	 * @return  string
	 */
	protected function _getAssetName()
	{
		$k = $this->_tbl_key;

		return $this->extension . '.note.' . (int) $this->$k;
	}

	/**
	 * Method to return the title to use for the asset table.
	 *
	 * @return  string
	 */
	protected function _getAssetTitle()
	{
		return $this->title;
	}

	/**
	 * Get the parent asset id for the record
	 *
	 * @param   JTable   $table  A JTable object for the asset parent.
	 * @param   integer  $id     The id for the asset
	 *
	 * @return  integer  The id of the asset's parent
	 *
	 * @since   11.1
	 */
	protected function _getAssetParentId(JTable $table = null, $id = null)
	{
		$assetId = null;

		// For while, we don't have hierarchy in notes

		// This is a category under a category.
// 		if ($this->parent_id > 1)
// 		{
// 			// Build the query to get the asset id for the parent category.
// 			$query = $this->_db->getQuery(true)
// 			->select($this->_db->quoteName('asset_id'))
// 			->from($this->_db->quoteName('#__gorilla_notes'))
// 			->where($this->_db->quoteName('id') . ' = ' . $this->parent_id);

// 			// Get the asset id from the database.
// 			$this->_db->setQuery($query);

// 			if ($result = $this->_db->loadResult())
// 			{
// 				$assetId = (int) $result;
// 			}
// 		}
// 		// This is a category that needs to parent with the extension.
// 		elseif ($assetId === null)
// 		{
			// Build the query to get the asset id for the parent category.
			$query = $this->_db->getQuery(true)
			->select($this->_db->quoteName('id'))
			->from($this->_db->quoteName('#__assets'))
			->where($this->_db->quoteName('name') . ' = ' . $this->_db->quote($this->extension));

			// Get the asset id from the database.
			$this->_db->setQuery($query);

			if ($result = $this->_db->loadResult())
			{
				$assetId = (int) $result;
			}
// 		}

		// Return the asset id.
		if ($assetId)
		{
			return $assetId;
		}
		else
		{
			return parent::_getAssetParentId($table, $id);
		}
	}

}