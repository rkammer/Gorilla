<?php
defined ( '_JEXEC' ) or die ();

$cols = $this->params->get('number_of_columns');
$span = "span" . (12 / $cols);
?>

<div class="container-fluid <?php echo $this->params->get('pageclass_sfx') ?>">


    <div class="row">
	    <div class="span12">
            <?php if ($this->params->get('show_page_heading', 1)) : ?>
            <div class="page-header">
                <h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
            </div>
            <?endif;?>
	    </div>
	</div>

	<?php foreach (array_chunk($this->items, isset($cols) ? $cols : 1) as $row) : ?>
	<div class="row-fluid">
		<?php foreach ($row as $col) : ?>
		<div class="<?php echo $span ?>">
			<?php if ($this->params->get('show_color_code') == 1) : ?>
                <div style="background-color:<?php echo $col->color_code; ?>;" class="notebook-box-small">&nbsp;</div>
            <?php endif; ?>
            <a href="<?php echo JRoute::_('index.php?option=com_gorilla&view=notebook&id='.(int) $col->id); ?>">
                <?php echo $col->title; ?>
            </a>
			<?php if ($this->params->get('show_description') == 1) : ?>
                <p class="muted notebookj25-p-muted">
                    <?php echo $col->description; ?>
                </p>
            <?php endif; ?>
	    </div>
	    <?php endforeach; ?>
	    <?php //if (count($row) == 1) : ?>
	    <?php for ($i = count($row); $i < $cols; $i++) : ?>
		<div class="<?php echo $span ?>">
	    </div>
	    <?php endfor; ?>
	    <?php //endif; ?>
	</div>
	<?php endforeach; ?>

</div>