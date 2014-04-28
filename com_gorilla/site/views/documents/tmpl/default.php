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

$container = $this->params->get('container');
$show_back_to_containers_button = ($container == "");
$add_href = 'index.php?option=com_gorilla&view=documents';
?>

<?php if ($show_back_to_containers_button) :  ?>
<a href="<?php echo JRoute::_('index.php?option=com_gorilla&view=containers'); ?>"><i class="icon-arrow-left"></i>Back</a>
<?php endif; ?>
<div class="container-fluid" width=60%>

	<div class="row">
		<div class="span12">
			<?php if ($this->params->get('show_container_color_code') == 1) : ?>
                <div style="background-color:<?php echo $this->container->color_code; ?>;" title="<?php echo $this->container->title; ?>" class="container-box-large">&nbsp;</div>
	        <?php endif; ?>
	        <h1 class="containerj25-h1"><?php echo $this->container->title; ?></h1>
	    </div>
	</div>

	<?php if ($this->params->get('show_container_description') == 1) : ?>
	<div class="row">
	    <div class="span12">
	        <blockquote>
	        <p class="muted"><?php echo $this->container->description; ?></p>
	        </blockquote>
	    </div>
	</div>
	<?php endif; ?>

	<?php foreach ($this->items as $key => $item) : ?>
        <div class="row">
            <div class="span12">
                <div style="background-color: <?php echo $this->container->color_code; ?>;" class="container-box-small" title="<?php echo $this->container->title; ?>">&nbsp;</div> <a href="#"><p class="lead" style="margin-bottom: 0px;"><b><?php echo $item->title; ?></b></p></a>
                <?php if ($this->params->get('show_document_description') == 1) : ?>
                    <p class="muted"><?php echo $item->description; ?></p>
                <?php endif; ?>
                <button class="btn btn-small" type="button"><i class="icon-file"></i> Document</button>
                <button class="btn btn-small" type="button"><i class="icon-folder-open"></i> Open</button>
                <button class="btn btn-small" type="button"><i class="icon-download"></i> Download</button>
                <hr/>
            </div>
        </div>
	<?php endforeach; ?>

	<div class="pagination center">
		<?php echo $this->pagination->getListFooter(); ?>
	</div>
</div>