<?php

// No direct access.
defined('_JEXEC') or die;

/**
 * Methods to access configurations
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class GorillaModelConfig extends JModelLegacy
{

	/**
	 * Method to build query
	 *
	 * @param string $key Key value of configuration. 
	 * Ex.: 'COLOR_CODE_COLORS'
	 * 
	 * @return string 
	 */	
	private function getQueryByKey($key = '') {
		$db 	= $this->getDbo();
		$query	= $db->getQuery(true);
		
		// Build query		
		$query->select('`id`, `key`, `value`');
		$query->from('#__gorilla_config');
		
		// Filter by key
		if (!empty($key)) {
			$query->where('(`key` = \''.$key.'\')');
		}
		
		return $query;
	}	
	
	/**
	 * Method to get data from the query
	 *
	 * @param string $key Key value of configuration. 
	 * Ex.: 'COLOR_CODE_COLORS'
	 * 
	 * @return list of object 
	 */	
	public function getConfigByKey($key = '') {
		$db 	= $this->getDbo();
		$query	= $this->getQueryByKey($key);
		
		// Get the options.
		$db->setQuery($query);
		
		$list = $db->loadObjectList();
		
		// Check for a database error.
		if ($db->getErrorNum())
		{
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		return $list;		
	}

	/**
	 * Method to get next color to be used in notebook
	 *
	 * @return string color code. Ex.: '#000000'
	 */	
	public function getNextColor() {
		// Get what's the next color
		$next = $this->getConfigByKey('COLOR_CODE_NEXTCOLOR');
		
		// Get json with colors list
		$json = $this->getConfigByKey('COLOR_CODE_COLORS');
		
		// Convert json into array		
		$colors = json_decode($json[0]->value);
		
		// Get color code corresponding to the next position
		return $colors[$next[0]->value]->color;		
	}

	/**
	 * Method to change next color
	 *
	 * @return void
	 */	
	public function setNextColor() {
		// Get what's the next color
		$next = $this->getConfigByKey('COLOR_CODE_NEXTCOLOR');
		
		$db 	= $this->getDbo();
		$query	= $db->getQuery(true);
		
		// Build update
		$query->update('#__gorilla_config');
		
		// Reset next color or increment
		if ($next[0]->value == 6) {
			$query->set('`value` = 0');
		}
		else {
			$query->set('`value` = `value` + 1');			
		}
		
		// Only the right configuration
		$query->where('(`key` = \'COLOR_CODE_NEXTCOLOR\')');
		
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