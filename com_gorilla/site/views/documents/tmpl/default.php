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
<script type="text/javascript">
	jQuery(document).ready(function() {

        // attach event to each download button
        jQuery('.download-button').click(function(){

            var $form = jQuery("#downloadForm");
            if ($form.length == 0) {
                $form = jQuery("<form>").attr({ "target": "_blank", "id": "downloadForm", "method": "POST", "action": "index.php?option=com_gorilla&task=documents.download" }).hide();
                jQuery("body").append($form);
            }

            var $download_id        = jQuery(this).children(".download-id");
            var $download_guid      = jQuery(this).children(".download-guid");
            var $download_filename  = jQuery(this).children(".download-filename");

            $form.append(jQuery("<input>").attr({"value":$download_id.val(), "name":'id'}));
            $form.append(jQuery("<input>").attr({"value":$download_guid.val(), "name":'guid'}));
            $form.append(jQuery("<input>").attr({"value":$download_filename.val(), "name":'filename'}));
            $form.append(jQuery("<input>").attr({"value":'1', "name":'<?php echo JSession::getFormToken(); ?>'}));

            $form.submit();

        });

	});
</script>
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
                <div style="background-color: <?php echo $this->container->color_code; ?>;" class="container-box-small" title="<?php echo $this->container->title; ?>">&nbsp;</div>
                <p class="lead" style="margin-bottom: 0px;">
                <a href="<?php echo JRoute::_('index.php?option=com_gorilla&view=document&id=' . $item->id); ?>"><b><?php echo $item->title; ?></b></a>
                <a class="btn btn-micro active hasTooltip download-button" href="#">
				    <i class="icon-download"></i>
				    <input type="hidden" class="download-id" value="<?php echo $item->id; ?>" />
				    <input type="hidden" class="download-guid" value="<?php echo $item->guid; ?>" />
				    <input type="hidden" class="download-filename" value="<?php echo $item->filename; ?>" />
				</a>
                </p>
                <?php if ($this->params->get('show_document_description') == 1) : ?>
                    <p class="muted"><?php echo $item->description; ?></p>
                <?php endif; ?>
                <!-- <button class="btn btn-small" type="button"><i class="icon-file"></i> Document</button> -->
                <!-- <button class="btn btn-small" type="button"><i class="icon-folder-open"></i> Open</button> -->
                <!-- <button class="btn btn-small" type="button"><i class="icon-download"></i> Download</button> -->
                <hr/>
            </div>
        </div>
	<?php endforeach; ?>

	<div class="pagination center">
		<?php echo $this->pagination->getListFooter(); ?>
	</div>
</div>