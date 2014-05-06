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
		directSubmit    = task == 'note.cancel' || task == 'note.download';
		jformFileName   = note.getElementById('jform_file_name');
		jformUploadFile = note.getElementById('jform_upload_file');
		if ((!directSubmit) && (jformFileName.value == '') && (jformUploadFile.value == '')) {
			alert('<?php echo $this->escape(JText::_('COM_GORILLA_NOTE_CLIENT_MUST_HAVE_FILE'));?>');
			return false;
		}
		if (directSubmit || note.formvalidator.isValid(note.id('note-form'))) {
			Joomla.submitform(task, note.getElementById('note-form'));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_gorilla&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="note-form" class="form-validate" enctype="multipart/form-data">

	<?php echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', empty($this->item->id) ? JText::_('COM_GORILLA_NEW_NOTE', true) : JText::sprintf('COM_GORILLA_EDIT_NOTE', $this->item->id, true)); ?>
		<div class="row-fluid">
			<div class="span9">
				<div class="form-vertical">
					<?php echo $this->form->getControlGroup('container_id'); ?>
					<?php echo $this->form->getControlGroup('description'); ?>
					<?php echo $this->form->getControlGroup('upload_file'); ?>
				</div>
			</div>
			<div class="span3">
				<?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>
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

	<?php echo $this->form->getControlGroup('id'); ?>
	<?php echo $this->form->getControlGroup('guid'); ?>
	<?php echo $this->form->getControlGroup('file_name'); ?>
	<!-- <input type="hidden" name="id" value="<?php echo $this->form->getValue('id'); ?>" /> -->
	<!-- <input type="hidden" name="guid" value="<?php echo $this->form->getValue('guid'); ?>" /> -->
	<!-- <input type="hidden" name="file_name" value="<?php echo $this->form->getValue('file_name'); ?>" /> -->
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="MAX_FILE_SIZE" value="20000" />
	<?php echo JHtml::_('form.token'); ?>
</form>