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
defined ( '_JEXEC' ) or die ();

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'container.cancel' || document.formvalidator.isValid(document.id('container-form'))) {
			Joomla.submitform(task, document.getElementById('container-form'));
		}
	}

	// Replace next color when color is invalid
	jQuery(document).ready(function (){
		jQuery( "#jform_color_code" ).blur(function() {
			var colorCode = jQuery( "#jform_color_code" ).val();
			var colorCodeLengthRule = colorCode.length == 7;
			var colorCodeHashRule = colorCode.substr(0,1) == '#';
			if ( (!colorCodeLengthRule) || (!colorCodeHashRule) ) {
				var colorSuggValue = jQuery( "#color_code_suggest" ).val();
				jQuery( "#jform_color_code" ).val(colorSuggValue);
				jQuery( "span .minicolors-swatch > span" ).css("background-color",colorSuggValue);
			}
		});
	});
</script>

<form action="<?php echo JRoute::_('index.php?option=com_gorilla&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="container-form" class="form-validate">

	<?php echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', empty($this->item->id) ? JText::_('COM_GORILLA_NEW_CONTAINER', true) : JText::sprintf('COM_GORILLA_EDIT_CONTAINER', $this->item->id, true)); ?>
		<div class="row-fluid">
			<div class="span9">
				<div class="form-vertical">
					<?php echo $this->form->getControlGroup('color_code'); ?>
					<?php echo $this->form->getControlGroup('description'); ?>
				</div>
			</div>
			<div class="span3">
				<?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'permissions', JText::_('JCONFIG_PERMISSIONS_LABEL', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo $this->form->getControlGroups('permissions'); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('JGLOBAL_FIELDSET_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo $this->form->getControlGroups('publishing'); ?>
			</div>
			<div class="span6">
				<?php echo $this->form->getControlGroups('metadata'); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

	</div>

	<input type="hidden" name="task" value="" />
	<input type="hidden" id="color_code_suggest" value="<?php echo $this->form->getValue('color_code'); ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>