<?php

/**
 * Gorilla Document Manager
 *
 * @author     Rodrigo Petters
 * @copyright  2013-2014 SOHO Prospecting LLC (California - USA)
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link https://www.sohoprospecting.com
 *
 * Try not. Do or do not. There is no try.
 */

defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/../../../helpers/gorilla.php';

//Get notebook options
JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
$notebookList = JFormHelper::loadFieldType('NotebookList', false);
$notebookListOptions = $notebookList->getOptions();
?>

<fieldset id="filter-bar">
	<div class="filter-search fltlft">
		<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
		<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_GROUNDWATER_CONTENT_FILTER_SEARCH_DESC'); ?>" />

		<button type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
		<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
	</div>

	<div class="filter-select fltrt">
		<?php if(JRequest::getCmd('view') == 'documents'):?>
			<select name="filter.notebook_id" class="inputbox" onchange="this.form.submit()">
				<?php echo JHtml::_('select.options', $notebookListOptions, 'value', 'text', $this->state->get('filter.notebook_id'), true);?>
			</select>
		<?php endif; ?>

		<select name="filter_published" class="inputbox" onchange="this.form.submit()">
			<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
			<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true);?>
		</select>

		<select name="filter_access" class="inputbox" onchange="this.form.submit()">
			<option value=""><?php echo JText::_('JOPTION_SELECT_ACCESS');?></option>
			<?php echo JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'));?>
		</select>
	</div>
</fieldset>