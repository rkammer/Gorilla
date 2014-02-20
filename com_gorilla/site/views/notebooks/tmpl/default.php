<?php
defined ( '_JEXEC' ) or die ();

$cols = $this->params->get('number_of_columns');
$span = "span" . (12 / $cols); 
?>

<div class="row">
    <div class="span12">
        <h1 class="notebook-title"><?php echo JText::_('COM_GORILLA_NOTEBOOKS_TITLE'); ?></h1>
    </div>
</div>

<?php foreach (array_chunk($this->items, $cols) as $row) : ?>
<div class="row-fluid">
	<?php foreach ($row as $col) : ?>
	<div class="<?php echo $span ?>">
		<?php if ($this->params->get('show_color_code') == 1) : ?><div style="background-color:<?php echo $col->color_code; ?>;" class="notebook-box-small">&nbsp;</div> <?php endif; ?><a href="<?php echo JRoute::_('index.php?option=com_gorilla&view=notebook&id='.(int) $col->id); ?>"><?php echo $col->title; ?></a>
		<?php if ($this->params->get('show_description') == 1) : ?><p class="muted"><?php echo $col->description; ?></p><?php endif; ?>
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
