<?php
/**
 * Pre-processes variables for the "page" theme hook.
 *
 * See template for list of available variables.
 *
 * @see page.tpl.php
 *
 * @ingroup theme_preprocess
 */
function hardwood_preprocess_page(&$variables) {
  // Primary nav.
  $variables['primary_nav'] = FALSE;
  if (!empty($variables['main_menu'])) {
    // Build links.
    $variables['primary_nav'] = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
    // Provide default theme wrapper function.
    $variables['primary_nav']['#theme_wrappers'] = ['menu_tree__primary'];
  }

  // Secondary nav.
  $variables['secondary_nav'] = FALSE;
  if (!empty($variables['secondary_menu'])) {
    // Build links.
    $variables['secondary_nav'] = menu_tree(variable_get('menu_secondary_links_source', 'user-menu'));
    // Provide default theme wrapper function.
    $variables['secondary_nav']['#theme_wrappers'] = ['menu_tree__secondary'];
  }

  // Manage display of cards
  $cards = variable_get('hardwood_page_cards', FALSE);

  $variables['hardwood_set_page_card'] = TRUE;
  if ($cards) {
    if (isset($variables['node'])) {
      if (is_array($cards) && isset($cards[$variables['node']->nid])) {
        $variables['hardwood_set_page_card'] = FALSE;
      }
    }
  }

  // Add help content
  hardwood_add_help_variables($variables);

  // Disable sticky header
  drupal_add_js('Drupal.behaviors.tableHeader = function(){};', [
    'type' => 'inline',
  ]);

  // Disable tripal ds
  drupal_add_js('Drupal.behaviors.tripal_ds = function(){};', [
    'type' => 'inline',
  ]);
}
