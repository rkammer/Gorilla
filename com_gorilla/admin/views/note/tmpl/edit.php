<?php

/**
 * Gorilla Note Manager
 *
 * @author     Gorilla Team
 * @copyright  2013-2014 SOHO Prospecting LLC (California - USA)
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link https://www.sohoprospecting.com
 *
 * Try not. Do or do not. There is no try.
 */

// No direct access.
defined ( '_JEXEC' ) or die ();

jimport( 'joomla.form.form' );

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'note.cancel' || document.formvalidator.isValid(document.id('note-form'))) {
			Joomla.submitform(task, document.getElementById('note-form'));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_gorilla&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="note-form" class="form-validate" enctype="multipart/form-data">

	<?php echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', empty($this->item->id) ? JText::_('COM_GORILLA_NEW_NOTE', true) : JText::sprintf('COM_GORILLA_EDIT_NOTE', $this->item->id, true)); ?>
		<div class="row-fluid">
			<div class="span8">
				<div class="form-vertical">
					<?php echo $this->form->getControlGroup('container_id'); ?>
					<?php echo $this->form->getControlGroup('description'); ?>
				</div>
			</div>
			<div class="span4">
			    <?php echo $this->form->getControlGroup('tags'); ?>
				<?php echo $this->form->getControlGroup('published'); ?>
				<?php echo $this->form->getControlGroup('access'); ?>
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
				<?php echo $this->form->getControlGroups('jmetadata'); ?>
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

		<?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

	</div>

	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>