<?php
defined('_JEXEC') or die;
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Guide View
 */
class GorillaViewGuide extends JViewLegacy
{
    /**
    * View display method
    * @return void
    */
	function display($tpl = null) 
    {
    	JToolBarHelper::title(JText::_('COM_GORILLA'), 'guide');
    	
		//Check for errors.
        if (count($errors = $this->get('Errors'))) 
        {
        	JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
		
        //adds scripts and styles
        $this->addScripts();		
        
        // Display the template
        parent::display($tpl);
	}
	
    /**
     * Add script to Bootstrap work out.
     *
     * @return void
     */
    protected function addScripts(){
        $doc = JFactory::getDocument();
        $doc->addScript('../media/com_gorilla/js/jquery-2.0.3.min.js');
        $doc->addScript('../media/com_gorilla/js/bootstrap.js');
        $doc->addStyleSheet('../media/com_gorilla/css/bootstrap.css');
    }	
}