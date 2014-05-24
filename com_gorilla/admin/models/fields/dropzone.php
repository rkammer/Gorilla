<?php

/**
 * Gorilla Document Manager
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
 * Custom field to create Dropzone programmatically.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */
class JFormFieldDropzone extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'Dropzone';

	/**
	 * The url to be call when add file.
	 *
	 * @var    string
	 */
	protected $addFileUrl;

	/**
	 * The url to be call when cancel file.
	 *
	 * @var    string
	 */
	protected $cancelFileUrl;

	/**
	 * Allow to upload more than one file.
	 *
	 * @var    boolean
	 */
	protected $uploadMultiple;

	/**
	 * The limit of files can be upload.
	 *
	 * @var    int
	 */
	protected $maxFiles;

	/**
	 * Method to set certain otherwise inaccessible properties of the form field object.
	 *
	 * @param   string  $name   The property name for which to the the value.
	 * @param   mixed   $value  The value of the property.
	 *
	 * @return  void
	 *
	 * @since   3.2
	 */
	public function __set($name, $value)
	{
		switch ($name)
		{
			case 'addFileUrl':
			case 'cancelFileUrl':
			$this->$name = (string) $value;
			break;

			case 'maxFiles':
			$this->$name = (int) $value;
			break;

			case 'uploadMultiple':
				$value = (string) $value;
				$this->$name = ($value === 'true' || $value === $name || $value === '1');
				break;

			default:
			parent::__set($name, $value);
		}
	}

	/**
	 * Method to get certain otherwise inaccessible properties from the form field object.
	 *
	 * @param   string  $name  The property name for which to the the value.
	 *
	 * @return  mixed  The property value or null.
	 *
	 * @since   11.1
	 */
	public function __get($name)
	{
		switch ($name)
		{
			case 'addFileUrl':
			case 'cancelFileUrl':
			case 'maxFiles':
			case 'uploadMultiple':
			return $this->$name;
		}

		return parent::__get($name);
	}

	/**
	 * Method to attach a JForm object to the field.
	 *
	 * @param   SimpleXMLElement  $element  The SimpleXMLElement object representing the <field /> tag for the form field object.
	 * @param   mixed             $value    The form field value to validate.
	 * @param   string            $group    The field name group control value. This acts as as an array container for the field.
	 *                                      For example if the field has name="foo" and the group value is set to "bar" then the
	 *                                      full field name would end up being "bar[foo]".
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   11.1
	 */
	public function setup(SimpleXMLElement $element, $value, $group = null)
	{
		// Make sure there is a valid JFormField XML element.
		if ((string) $element->getName() != 'field')
		{
			return false;
		}

		// Reset the input and label values.
		$this->input = null;
		$this->label = null;

		// Set the XML element object.
		$this->element = $element;

		// Set the group of the field.
		$this->group = $group;

		$attributes = array(
				'name', 'id', 'addFileUrl', 'cancelFileUrl', 'maxFilesize', 'uploadMultiple', 'maxFiles');

		foreach ($attributes as $attributeName)
		{
			$this->__set($attributeName, $element[$attributeName]);
		}

		return true;
	}

	/**
	 * Method to get the field label markup.
	 *
	 * @return  string  The field label markup.
	 *
	 * @since   11.1
	 */
	protected function getLabel()
	{
		return '';
	}

	/**
	 * Method to get the field input markup for a generic list.
	 * Use the multiple attribute to enable multiselect.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   11.1
	 */
	protected function getInput()
	{
		$html = array();
 		$script = array();

		$doc = JFactory::getDocument();

		$script[] = 'Dropzone.autoDiscover = false; ';

		foreach ($script as $line) {
			$doc->addScriptDeclaration($line);
		}

		$doc->addScript(JURI::root().'media/com_gorilla/js/gorilla.js');
		$doc->addScript(JURI::root().'media/com_gorilla/dropzone/dropzone.js');
		$doc->addStyleSheet(JURI::root().'media/com_gorilla/dropzone/css/basic.css');
		$doc->addStyleSheet(JURI::root().'media/com_gorilla/dropzone/css/dropzone.css');

		$html[] = '<div id="dropzone-div" class="dropzone dz-clickable gorilla-dropzone"></div>';

		$cparams = JComponentHelper::getParams('com_media');

		$params = array();
		$params['addFileUrl'] 		= $this->addFileUrl;
		$params['cancelFileUrl']	= $this->cancelFileUrl;
		$params['maxFilesize']      = $cparams->get('upload_maxsize', 0);
		$params['uploadMultiple']   = $this->uploadMultiple;
		$params['maxFiles']         = $this->maxFiles;
		$params['fileListSelector'] = '#' . $this->id;
		$params['token']            = JSession::getFormToken();

		$html[] = '<input type="hidden" id="dropzone-params" value=\'' . json_encode($params) . '\' />';
		$html[] = '<input type="hidden" id="' . $this->id . '" name="' . $this->name . '" value="" />';

		return implode($html);
	}

}
