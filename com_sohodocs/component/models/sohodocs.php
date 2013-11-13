<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	// import Joomla modelitem library
	jimport('joomla.application.component.modelitem');

	/**
	* SohoWater Model
	*/
	class SohoDocsModelSohoDocs extends JModelItem{

		/**
		* @var string msg
		*/
		protected $msg;

		/**
		* Get the message
		* @return string The message to be displayed to the user
		*/
		public function getHello(){
			if(!isset($this->msg)){
				$this->msg = 'Hello World! - SOHODocs Component';
			}
			return $this->msg;
		}
	}