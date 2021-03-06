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

defined ( '_JEXEC' ) or die ();

$cols = $this->params->get('number_of_columns');
$span = "span" . (12 / $cols);
?>

<div class="container-fluid <?php echo $this->params->get('pageclass_sfx'); ?>">


    <div class="row">
	    <div class="span12">
            <?php if ($this->params->get('show_page_heading', 1)) : ?>
            <div class="page-header">
                <h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
            </div>
            <?php endif; ?>
	    </div>
	</div>

	<?php foreach (array_chunk($this->items, isset($cols) ? $cols : 1) as $row) : ?>
	<div class="row-fluid">
		<?php foreach ($row as $col) : ?>
            <div class="<?php echo $span ?>">
                <?php if ($this->params->get('show_color_code') == 1) : ?>
                    <div style="background-color:<?php echo $col->color_code; ?>;" class="container-box-small" title="<?php echo $col->title; ?>">&nbsp;</div>
                <?php endif; ?>
                <a href="<?php echo JRoute::_('index.php?option=com_gorilla&view=documents&id='.(int) $col->id); ?>">
                    <?php echo $col->title; ?>
                </a>
                <?php if ($this->params->get('show_description') == 1) : ?>
                    <p class="muted containerj25-p-muted">
                        <?php echo $col->description; ?>
                    </p>
                <?php endif; ?>
            </div>
	    <?php endforeach; ?>
	    <?php for ($i = count($row); $i < $cols; $i++) : ?>
		<div class="<?php echo $span; ?>">
	    </div>
	    <?php endfor; ?>
	</div>
	<?php endforeach; ?>

    <div class="gorilla-footer">
         <p><img src="../media/com_gorilla/img/icon-32.png">&nbsp;<?php echo JText::_('COM_GORILLA_POWERED','Powered by Gorilla Document Manager');?></p>
    </div>

</div>