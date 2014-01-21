<?php

// No direct access.
defined ( '_JEXEC' ) or die ();

/*
<?php foreach ($this->form->getFieldset('myfields') as $field)
: ?>
<div class="control-group">
<div class="control-label">
<?php echo $field->label; ?>
</div>
<div class="controls">
<?php echo $field->input; ?>
</div>
</div>
<?php endforeach; ?>
*/
?>
<form
	action="<?php echo JRoute::_('index.php?option=com_gorilla&layout=edit&id='.(int) $this->item->id); ?>"
	method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="row-fluid">
		<div class="span10 form-horizontal">
			<fieldset>
			<?php echo JHtml::_('bootstrap.startPane', 'myTab', array('active' => 'details')); ?>
				<?php echo JHtml::_('bootstrap.addPanel', 'myTab', 'details', empty($this->item->id) ? JText::_('COM_GORILLA_NEW_NOTEBOOK', true) : JText::sprintf('COM_GORILLA_EDIT_NOTEBOOK', $this->item->id, true)); ?>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('title'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('alias'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('alias'); ?></div>
				</div>				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
				</div>				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('access'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('access'); ?></div>
				</div>				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('description'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('description'); ?></div>
				</div>				
				<?php echo JHtml::_('bootstrap.endPanel'); ?>
				<input type="hidden" name="task" value="" />
				<?php echo JHtml::_('form.token'); ?>
			<?php echo JHtml::_('bootstrap.endPane'); ?>
			</fieldset>
			<fieldset>
			<?php echo JHtml::_('bootstrap.startPane', 'myTabPublish', array('active' => 'publish')); ?>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
				</div>				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('created'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('created'); ?></div>
				</div>				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('publish_up'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('publish_up'); ?></div>
				</div>				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('publish_down'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('publish_down'); ?></div>
				</div>				
			<?php echo JHtml::_('bootstrap.endPane'); ?>
			</fieldset>
			<fieldset>
			<?php echo JHtml::_('bootstrap.startPane', 'myTabMetadata', array('active' => 'metadata')); ?>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('metadesc'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('metadesc'); ?></div>
				</div>				
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('metakey'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('metakey'); ?></div>
				</div>				
			<?php echo JHtml::_('bootstrap.endPane'); ?>
			</fieldset>			
		</div>
	</div>
</form>