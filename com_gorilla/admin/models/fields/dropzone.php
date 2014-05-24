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
	 * The max size that file can have.
	 *
	 * @var    int
	 */
	protected $maxFilesize;

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

			case 'maxFilesize':
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
			case 'maxFilesize':
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

		//$this->default = isset($element['value']) ? (string) $element['value'] : $this->default;

		// Set the field default value.
		//$this->value = $value;

		foreach ($attributes as $attributeName)
		{
			$this->__set($attributeName, $element[$attributeName]);
		}

		// Allow for repeatable elements
		//$repeat = (string) $element['repeat'];
		//$this->repeat = ($repeat == 'true' || $repeat == 'multiple' || (!empty($this->form->repeat) && $this->form->repeat == 1));

		// Set the visibility.
		//$this->hidden = ($this->hidden || (string) $element['type'] == 'hidden');

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
		/*

		$script[] = 'jQuery(document).ready(function() { ';

		$script[] = 'var $myDropzone = new Dropzone("div#dropzone-div", { ';
		$script[] = '	url: "index.php?option=com_gorilla&task=document.dropfile", ';
		$script[] = '	paramName: "file", ';
		$script[] = '	maxFilesize: 10, // MB ';
		$script[] = '	clickable: true, ';
		$script[] = '	uploadMultiple: false, ';
		$script[] = '	maxFiles: 1, ';
		$script[] = '	addRemoveLinks: true, ';
		$script[] = '	autoProcessQueue: true ';
		$script[] = '}); ';

		$script[] = '$myDropzone.on("maxfilesexceeded", function(file) { ';
		$script[] = '	this.removeFile(file); ';
		$script[] = '}); ';

		$script[] = '$myDropzone.on("sending", function(file, xhr, formData) { ';
		$script[] = '   var fileRegistered = registerFile(file, xhr); ';
		$script[] = '   var files = JSON.parse(filesJsonText(jQuery("' . $this->id . '").val())); ';
		$script[] = '   files.files.push(fileRegistered); ';
		$script[] = '   jQuery("' . $this->id . '").val(JSON.stringify(files)); ';
		$script[] = '	// Will send the token along with the file as POST data. ';
		$script[] = '	formData.append("clientname", fileRegistered.clientName); ';
		$script[] = '	formData.append("' . JSession::getFormToken() . '", "1"); ';
		$script[] = '}); ';

		$script[] = '$myDropzone.on("addedfile", function(file) { ';
		$script[] = '}); ';

		$script[] = '$myDropzone.on("error", function(file, msg) { ';
		$script[] = '	// Nothing to do. ';
		$script[] = '	// Dropzone show progress bar in red and ';
		$script[] = '	// on mouse over user can see error message. ';
		$script[] = '}); ';

		$script[] = '$myDropzone.on("success", function(file, responseText) { ';
		$script[] = '	jQuery("#jform_new_guid").val(responseText); ';



		$script[] = '}); ';

		$script[] = '$myDropzone.on("removedFile", function(file) { ';
		//$script[] = '	jQuery("#jform_new_guid").val(""); ';
		$script[] = '});	 ';

		$script[] = '}); '; // ready
		*/

		/* Dropzone no query style. But it doesn't work.
		$script[] = 'Dropzone.options.dropzoneDiv = {';
		$script[] = '	url: "index.php?option=com_gorilla&task=document.dropfile",';
		$script[] = '	paramName: "file",';
		$script[] = '	maxFilesize: 10, // MB';
		$script[] = '	clickable: true,';
		//$script[] = '	previewsContainer: ".dropzone-previews",';
		$script[] = '	uploadMultiple: false,';
		$script[] = '	maxFiles: 1,';
		$script[] = '	addRemoveLinks: true,';
		$script[] = '	autoProcessQueue: true,';

		//$script[] = '	accept: function(file, done) {';
		//$script[] = '		alert("here"); ';
		//$script[] = '		done(); ';
		//$script[] = '	},';

		$script[] = '	maxfilesexceeded: function(file) {';
		$script[] = '		this.removeFile(file); ';
		$script[] = '		alert("max"); ';
		$script[] = '	},';

		$script[] = '	sending: function(file, xhr, formData) {';
		$script[] = '		formData.append("' . JSession::getFormToken() . '", "1"); ';
		$script[] = '	    alert("sending");';
		$script[] = '	},';

		$script[] = '	addedfile: function(file) {';
		$script[] = '	    alert("added");';
		$script[] = '	},';

		$script[] = '	error: function(file, msg) {';
		$script[] = '	    alert("error");';
		$script[] = '	},';

		$script[] = '	success: function(file, responseText) {';
		$script[] = '	    alert("success");';
		$script[] = '	},';

		$script[] = '	removedFile: function(file) {';
		$script[] = '	    alert("removed");';
		$script[] = '	}';

		$script[] = '};';
		*/

		foreach ($script as $line) {
			$doc->addScriptDeclaration($line);
		}

		$doc->addScript(JURI::root().'media/com_gorilla/js/gorilla.js');
		$doc->addScript(JURI::root().'media/com_gorilla/dropzone/dropzone.js');
		$doc->addStyleSheet(JURI::root().'media/com_gorilla/dropzone/css/basic.css');
		$doc->addStyleSheet(JURI::root().'media/com_gorilla/dropzone/css/dropzone.css');

		$html[] = '<div id="dropzone-div" class="dropzone dz-clickable gorilla-dropzone"></div>';

		$params = array();
		$params['addFileUrl'] 		= $this->addFileUrl;
		$params['cancelFileUrl']	= $this->cancelFileUrl;
		$params['maxFilesize']      = $this->maxFilesize;
		$params['uploadMultiple']   = $this->uploadMultiple;
		$params['maxFiles']         = $this->maxFiles;
		$params['fileListSelector'] = '#' . $this->id;
		$params['token']            = JSession::getFormToken();

		$html[] = '<input type="hidden" id="dropzone-params" value=\'' . json_encode($params) . '\' />';
		$html[] = '<input type="hidden" id="' . $this->id . '" name="' . $this->name . '" value="" />';

		return implode($html);
	}

}
