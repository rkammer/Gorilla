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
$add_href = 'index.php?option=com_gorilla&view=document';
?>
<?php if ($show_back_to_containers_button) :  ?>
<a href="<?php echo JRoute::_('index.php?option=com_gorilla&view=documents&id=' . $this->item->container_id); ?>"><i class="icon-arrow-left"></i>Back</a>
<?php endif; ?>
<div class="container-fluid" width=60%>

	<div class="row">
		<div class="span12">
	        <h1><?php echo $this->item->title; ?></h1>
	    </div>
	</div>

	<div class="row">
	    <div class="span12">
	        <blockquote>
	        <p class="muted"><?php echo $this->item->description; ?></p>
	        </blockquote>
	    </div>
	</div>
</div>