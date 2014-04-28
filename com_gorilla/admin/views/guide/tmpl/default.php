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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

?>
<script>
	AccessConfig = function()
	{
		task = document.getElementById("task");
		task.setAttribute('value', 'guide.config');
		form = document.getElementById("guide-form");
		form.setAttribute('action', 'index.php?option=com_config&view=component&component=com_gorilla');
		form.submit();
	}
	AccessGorilla = function()
	{
		task = document.getElementById("task");
		task.setAttribute('value', 'guide.config');
		form = document.getElementById("guide-form");
		form.setAttribute('action', 'index.php?option=com_gorilla&view=containers');
		form.submit();
	}
</script>
<form action="" method="post" name="adminForm" id="guide-form" class="form-validate">

	<div class="form-horizontal">

		<div class="row-fluid">
		    <div class="span12">
		        <h1><?php echo $this->installation ? JText::_('COM_GORILLA_GUIDE_THANK_YOU_INSTALLATION') : JText::_('COM_GORILLA_GUIDE_THANK_YOU_UPDATE'); ?></h1>
		    </div>
		</div>
		<div class="row-fluid">
		    <div class="span12">
		        <p><?php echo JText::_('COM_GORILLA_DESCRIPTION'); ?></p>
		    </div>
		</div>
		<div class="row-fluid">
		    <div class="span12">
		        <p class="text-success"><i class="icon-ok"></i> <?php echo JText::_('COM_GORILLA_GUIDE_DATABASE_CHECKED'); ?></p>
		        <p class="text-success"><i class="icon-ok"></i> <?php echo JText::_('COM_GORILLA_GUIDE_COMPONENT_CHECKED'); ?></p>
		    </div>
		</div>
		<div class="row-fluid">
		    <div class="span12">
		        <button class="btn btn-large" type="button" id="access-config" onclick="AccessConfig()"><i class="icon-cog"></i> <?php echo JText::_('COM_GORILLA_GUIDE_CONFIG_BUTTON_LABEL'); ?></button>
		        <button class="btn btn-large btn-primary" type="button" id="access-gorilla" onclick="AccessGorilla()"><i class="icon-ok icon-white"></i> <?php echo JText::_('COM_GORILLA_GUIDE_START_BUTTON_LABEL'); ?></button>
		    </div>
		</div>
		<input type="hidden" name="task" id="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>