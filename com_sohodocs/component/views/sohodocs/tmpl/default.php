<?php defined('_JEXEC') or die('Restricted access'); ?>
<h1><?php echo JText::_('COM_SOHODOCS'); ?></h1>
<br/>

	<div class="btn-group">
		<button class="btn btn-info"><?php echo JText::_('COM_SOHODOCS'); ?></button>
		<button class="btn btn-info dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu">
			<li role="menuitem">
				<a href="index.php?option=com_sohodocs&view=pump">
				<?php echo JText::_('COM_SOHODOCS_PUMP'); ?>
				</a>
			</li>
		</ul>
    </div>