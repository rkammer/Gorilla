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

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

$user		= JFactory::getUser();
$canConfig	= $user->authorise('core.admin','com_gorilla');
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task == 'config.cancel' || document.formvalidator.isValid(document.id('config-form'))) {
			Joomla.submitform(task, document.getElementById('config-form'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="" method="post" name="adminForm" id="config-form" class="form-validate">
	<div class="width-60 fltlft">

		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_GORILLA_CONFIG_AMAZON_FIELDSET_LABEL'); ?></legend>
			<ul class="adminformlist">
				<?php foreach($this->form->getFieldset('amazon') as $field): ?>
					<li><?php echo $field->label; ?>
						<?php echo $field->input; ?></li>
				<?php endforeach; ?>
			</ul>
		</fieldset>

	</div>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="return" value="<?php echo JRequest::getCmd('return');?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>