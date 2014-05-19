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
jimport('joomla.application.component.helper');

?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (document.formvalidator.isValid(document.id('dashboard-form')))
		{
			Joomla.submitform(task, document.getElementById('dashboard-form'));
		}
	}
</script>
<form action="" method="post" name="adminForm" id="dashboard-form" class="form-validate">

	<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span5">
		<div class="cpanel">

			<div class="gorilla-dashboard-box-main-div">
			    <a href="index.php?option=com_gorilla&view=containers" class="gorilla-dashboard-box-a gorilla-shadow">
			        <div class="gorilla-dashboard-box-containers-div"></div>
			        <span class="gorilla-dashboard-box-span"><?php echo JText::_('COM_GORILLA_SUBMENU_CONTAINERS'); ?></span>
			    </a>
			</div>

            <div class="gorilla-dashboard-box-main-div">
			    <a href="index.php?option=com_gorilla&view=documents" class="gorilla-dashboard-box-a gorilla-shadow">
			        <div class="gorilla-dashboard-box-documents-div"></div>
			        <span class="gorilla-dashboard-box-span"><?php echo JText::_('COM_GORILLA_SUBMENU_DOCUMENTS'); ?></span>
			    </a>
			</div>

			<div class="gorilla-dashboard-box-main-div">
			    <a href="index.php?option=com_gorilla&view=notes" class="gorilla-dashboard-box-a gorilla-shadow">
			        <div class="gorilla-dashboard-box-notes-div"></div>
			        <span class="gorilla-dashboard-box-span"><?php echo JText::_('COM_GORILLA_SUBMENU_NOTES'); ?></span>
			    </a>
			</div>

			<div class="gorilla-dashboard-box-main-div">
			    <a href="index.php?option=com_gorilla&view=config" class="gorilla-dashboard-box-a gorilla-shadow">
			        <div class="gorilla-dashboard-box-config-div"></div>
			        <span class="gorilla-dashboard-box-span"><?php echo JText::_('COM_GORILLA_SUBMENU_CONFIG'); ?></span>
			    </a>
			</div>

		</div>
	</div>
	<div id="j-main-container" class="span5 gorilla-shadow">
		<div class="cpanel">
			<div class="gorilla-dashboard-logo"></div>
			<span><h2><?php echo JText::_('COM_GORILLA_DESCRIPTION'); ?></h2></span>
		</div>
	</div>
	<input type="hidden" name="task" id="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>