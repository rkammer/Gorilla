<?php
defined('_JEXEC') or die;
 
/**
 * Methods display a guide to component.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class GorillaViewGuide extends JViewLegacy
{
	
	/**
	 * Indication if is installation or update
	 *
	 * @var boolean
	 */	
	protected $installation;
	
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
        
        //TODO get this from task
        $this->installation = false;
        
        //adds scripts and styles
        //$this->addScripts();		
        
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