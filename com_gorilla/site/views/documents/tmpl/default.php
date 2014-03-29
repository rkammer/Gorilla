<?php
defined ( '_JEXEC' ) or die ();

$document = $this->params->get('document');
$show_back_to_notebooks_button = ($document == "");
$add_href = 'index.php?option=com_gorilla&view=documents';
?>

<?php if ($show_back_to_notebooks_button) :  ?>
<a href="<?php echo JRoute::_('index.php?option=com_gorilla&view=notebooks'); ?>"><i class="icon-arrow-left"></i>Back</a>
<?php endif; ?>
<div class="container-fluid" width=60%>

	<?php $notebook = $this->items[0] ?>
	<div class="row">
		<div class="span12">		
	        <div style="background-color:<?php echo $notebook->notebook_color_code; ?>;" class="notebook-box-large">&nbsp;</div> <h1 class="notebookj25-h1"><?php echo $notebook->notebook_title; ?></h1>		
	    </div>	
	</div>
	
	<div class="row">
	    <div class="span12">
	        <blockquote>
	        <p class="muted"><?php echo $notebook->notebook_description; ?></p>
	        </blockquote>
	    </div>
	</div>

	<?php foreach ($this->items as $key => $item) : ?>
	<div class="row">
	    <div class="span12 well">
	        <a href="#"><h2><?php echo $item->title; ?></h2></a>
	        <p class="muted"><?php echo $item->description; ?></p>
	        <button class="btn" type="button"><i class="icon-file"></i> Document</button>
	        <button class="btn" type="button"><i class="icon-folder-open"></i> Open</button>
	        <button class="btn" type="button"><i class="icon-download"></i> Download</button>
	    </div>
	</div>	
	<?php endforeach; ?>
	
	<div class="pagination center">
		<?php echo $this->pagination->getListFooter(); ?>
	</div>	
</div>