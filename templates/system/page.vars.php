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

  $cards = variable_get('hardwood_page_cards');

  $variables['hardwood_set_page_card'] = TRUE;
  if (isset($variables['node'])) {
    if (is_array($cards) && isset($cards[$variables['node']->nid])) {
      $variables['hardwood_set_page_card'] = FALSE;
    }
  }
}
