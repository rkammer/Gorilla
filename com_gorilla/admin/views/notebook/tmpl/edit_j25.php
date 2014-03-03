<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_gorilla
 */

// No direct access.
defined('_JEXEC') or die;

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

$user		= JFactory::getUser();
$canConfig	= $user->authorise('core.admin','com_gorilla');
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task == 'notebook.cancel' || document.formvalidator.isValid(document.id('notebook-form'))) {			
			Joomla.submitform(task, document.getElementById('notebook-form'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}

    // Avoid jQuery and Mootools conflict
    var $j = jQuery.noConflict(true);

	$j(document).ready(function(){
		$j( "#jform_color_code" ).blur(function() {
			var colorCode = $j( "#jform_color_code" ).val();
			var colorCodeLengthRule = colorCode.length == 7;
			var colorCodeHashRule = colorCode.substr(0,1) == '#';
			if ( (!colorCodeLengthRule) || (!colorCodeHashRule) ) {
				var colorSuggValue = $j( "#color_code_suggest" ).val();
				$j( "#jform_color_code" ).val(colorSuggValue);
				$j( "#colorBox" ).css("background-color",colorSuggValue);
			}
			//else {
			//	$j( "#colorBox" ).css("background-color",colorCode);
			//}
		});
    });	
</script>

<form action="<?php echo JRoute::_('index.php?option=com_gorilla&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="notebook-form" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->id) ? JText::_('COM_GORILLA_NEW_NOTEBOOK') : JText::sprintf('COM_GORILLA_EDIT_NOTEBOOK', $this->item->id); ?></legend>
			<ul class="adminformlist">
				<li>
					<?php echo $this->form->getLabel('title'); ?>
					<?php echo $this->form->getInput('title'); ?>
				</li>
				<li>
					<?php echo $this->form->getLabel('alias'); ?>
					<?php echo $this->form->getInput('alias'); ?>
				</li>
				<li>
					<?php echo $this->form->getLabel('published'); ?>
					<?php echo $this->form->getInput('published'); ?>
				</li>
				<li>
					<?php echo $this->form->getLabel('access'); ?>
					<?php echo $this->form->getInput('access'); ?>
				</li>				
				<li>
					<?php echo $this->form->getLabel('color_code'); ?>
					<?php echo $this->form->getInput('color_code'); ?>
				</li>				
				<li>
					<?php echo $this->form->getLabel('id'); ?>
					<?php echo $this->form->getInput('id'); ?>
				</li>
				<li>
					<?php echo $this->form->getLabel('description'); ?>
					<?php echo $this->form->getInput('description'); ?>
				</li>				
			</ul>	
		</fieldset>
	</div>
	
	<div class="width-40 fltrt">
		<?php echo JHtml::_('sliders.start', 'notebook-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
	
		<?php echo JHtml::_('sliders.panel', JText::_('JGLOBAL_FIELDSET_PUBLISHING'), 'publishing-details'); ?>
			<fieldset class="panelform">
				<ul class="adminformlist">
					<?php foreach($this->form->getFieldset('publishing') as $field): ?>
						<li><?php echo $field->label; ?>
							<?php echo $field->input; ?></li>
					<?php endforeach; ?>
				</ul>
			</fieldset>
			
			<?php echo JHtml::_('sliders.panel', JText::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'), 'meta-options'); ?>
			<fieldset class="panelform">
				<?php echo $this->loadTemplate('j25_metadata'); ?>
			</fieldset>			
		<?php echo JHtml::_('sliders.end'); ?>
	
	</div>
	<div class="clr"></div>
	<?php if ($canConfig): ?>
		<div  class="width-100 fltlft">

			<?php echo JHtml::_('sliders.start', 'permissions-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

			<?php echo JHtml::_('sliders.panel', JText::_('JCONFIG_PERMISSIONS_LABEL'), 'access-rules'); ?>
			<fieldset class="panelform">
				<?php echo $this->form->getLabel('rules'); ?>
				<?php echo $this->form->getInput('rules'); ?>
			</fieldset>

			<?php echo JHtml::_('sliders.end'); ?>
		</div>
	<?php endif; ?>	
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" id="color_code_suggest" value="<?php echo $this->form->getValue('color_code'); ?>" />
		<input type="hidden" name="return" value="<?php echo JRequest::getCmd('return');?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>