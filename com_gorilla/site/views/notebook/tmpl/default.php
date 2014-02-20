<?php
defined ( '_JEXEC' ) or die ();
?>

<a href="<?php echo JRoute::_('index.php?option=com_gorilla&view=notebooks'); ?>"><?php echo JText::_('COM_GORILLA_NOTEBOOK_BACK_TO_NOTEBOOKS'); ?></a>

<?php foreach ($this->items as $item) : ?>
<div class="row">
	<div class="span9">		
        <div style="background-color:<?php echo $item->color_code; ?>;" class="notebook-box-large">&nbsp;</div> <h1><?php echo $item->title; ?></h1>		
    </div>	
</div>

<div class="row">
    <div class="span9">
        <blockquote>
        <p class="muted"><?php echo $item->description; ?></p>
        </blockquote>
    </div>
</div>
<?php endforeach; ?>


<div class="row">
    <div class="span9 well">
        <a href="#"><h2>Document One</h2></a>
        <p class="muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <button class="btn" type="button"><i class="icon-file"></i> Document</button>
        <button class="btn" type="button"><i class="icon-folder-open"></i> Open</button>
        <button class="btn" type="button"><i class="icon-download"></i> Download</button>
    </div>
</div>

<div class="row">
    <div class="span9 well">
        <a href="#"><h2>Document Two</h2></a>
        <p class="muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <button class="btn" type="button"><i class="icon-file"></i> Document</button>
        <button class="btn" type="button"><i class="icon-folder-open"></i> Open</button>
        <button class="btn" type="button"><i class="icon-download"></i> Download</button>
    </div>
</div>

<div class="row">
    <div class="span9 well">
        <a href="#"><h2>Document Three</h2></a>
        <p class="muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <button class="btn" type="button"><i class="icon-file"></i> Document</button>
        <button class="btn" type="button"><i class="icon-folder-open"></i> Open</button>
        <button class="btn" type="button"><i class="icon-download"></i> Download</button>
    </div>
</div>

<div class="row">
    <div class="span9 well">
        <a href="#"><h2>Document Four</h2></a>
        <p class="muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <button class="btn" type="button"><i class="icon-file"></i> Document</button>
        <button class="btn" type="button"><i class="icon-folder-open"></i> Open</button>
        <button class="btn" type="button"><i class="icon-download"></i> Download</button>
    </div>
</div>

<div class="pagination center">
    <ul>
        <li><a href="#">Prev</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        <li><a href="#">Next</a></li>
    </ul>
</div>