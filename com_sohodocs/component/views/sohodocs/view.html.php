<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

    //defined DS constant for Joomla 3.0
    if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

	// import Joomla view library
	jimport('joomla.application.component.view');

	/**
	* HTML View class for the SOHODocs Component
	*/
	class SohoDocsViewSohoDocs extends JViewLegacy{

        // Overwriting JView display method
        function display($tpl = null) {

            // Assign data to the view
            $this->msg = $this->get('Hello');

			// Check for errors.
            if(count($errors = $this->get('Errors'))){
				JError::raiseError(500, implode('<br />', $errors));
				return false;
			}

            //adds scripts and styles
//            $this->addScripts();

            // Display the view
            parent::display($tpl);

        }

        //bootstrap and jquery already included in 3.0
        protected function addScripts(){
//            $doc = JFactory::getDocument();
//            $doc->addScript(JURI::root().'components'.DS.'com_sohowater'.DS.'js'.DS.'jquery-1.8.2.js');
//            $doc->addScript(JURI::root().'components'.DS.'com_sohowater'.DS.'js'.DS.'bootstrap.js');
//            $doc->addStyleSheet(JURI::root().'components'.DS.'com_sohowater'.DS.'css'.DS.'bootstrap.css');
        }
	}