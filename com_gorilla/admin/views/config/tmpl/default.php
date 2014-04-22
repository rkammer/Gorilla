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

// No direct access to this file
defined('_JEXEC') or die;

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (document.formvalidator.isValid(document.id('config-form')))
		{
			Joomla.submitform(task, document.getElementById('config-form'));
		}
	}
</script>
<form action="" method="post" name="adminForm" id="config-form" class="form-validate">

	<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
	<?php else : ?>
	<div id="j-main-container">
	<?php endif;?>

	<!-- <div class="row-fluid"> -->

		<ul class="nav nav-tabs" id="configTabs">
			<?php $fieldSets = $this->form->getFieldsets(); ?>
			<?php foreach ($fieldSets as $name => $fieldSet) : ?>
				<?php $label = empty($fieldSet->label) ? 'COM_GORILLA_' . strtoupper($name) . '_FIELDSET_LABEL' : $fieldSet->label; ?>
				<li><a href="#<?php echo $name; ?>" data-toggle="tab"><?php echo JText::_($label); ?></a></li>
			<?php endforeach; ?>
		</ul>
		<div class="tab-content">
			<?php $fieldSets = $this->form->getFieldsets(); ?>
			<?php foreach ($fieldSets as $name => $fieldSet) : ?>
				<div class="tab-pane" id="<?php echo $name; ?>">
					<?php
					if (isset($fieldSet->description) && !empty($fieldSet->description))
					{
						echo '<p class="tab-description">' . JText::_($fieldSet->description) . '</p>';
					}
					?>
					<?php foreach ($this->form->getFieldset($name) as $field) : ?>
						<div class="control-group">
							<div class="control-label">
								<?php echo $field->label; ?>
							</div>
							<?php echo $field->input; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>

		<input type="hidden" name="task" id="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<script type="text/javascript">
	jQuery('#configTabs a:first').tab('show'); // Select first tab
</script>