<?php
/**
 * Category input field
 *
 * @uses $vars['name_override'] Override name attribute (only use if you are planning to attach custom logic to assigning categories to entities)
 * @uses $vars['value'] An array of category GUIDs that should be checked by default (you can leave this empty if you are passing $vars['entity']
 * @uses $vars['entity'] An entity, which is being edited
 * @uses $vars['multiple'] If set to true, input type will be set to checkbox, otherwise radio
 * @uses $vars['required'] For now, this will be ignored as HTML spec does not provide clear guidelines
 */
elgg_load_js('categories.tree.js');
elgg_load_css('categories.base.css');

elgg_push_context('categories-input');

$entity = elgg_extract('entity', $vars, false);

$name = 'categories';
if (isset($vars['name_override'])) {
	$name = elgg_extract('name_override', $vars);
}

$multiple = elgg_extract('multiple', $vars, HYPECATEGORIES_INPUT_MULTIPLE);
$required = elgg_extract('required', $vars, true);

$value = elgg_extract('value', $vars, false);
if (elgg_instanceof($entity)) {
	$value = hj_categories_get_entity_categories($entity->guid, array(), true);
}

$page_owner = elgg_get_page_owner_entity();

if (!elgg_instanceof($page_owner, 'group')
		|| !HYPECATEGORIES_GROUP_CATEGORIES) {
	$page_owner = elgg_get_site_entity();
}


echo elgg_view('input/hidden', array(
	'name' => "{$name}",
	'value' => true,
	'required' => $required
));
	
echo '<div class="categories-input">';
echo elgg_view_menu('categories', array(
	'entity' => $page_owner,
	'sort_by' => 'priority',
	'input' => array(
		'name' => $name,
		'value' => $value,
		'multiple' => $multiple,
	)
));
echo '</div>';

elgg_pop_context();