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
    $variables['primary_nav']['#theme_wrappers'] = array('menu_tree__primary');
  }

  /* Secondary nav.
  $variables['secondary_nav'] = FALSE;
  if ($variables['secondary_menu']) {
    // Build links.
    $variables['secondary_nav'] = menu_tree(variable_get('menu_secondary_links_source', 'user-menu'));
    // Provide default theme wrapper function.
    $variables['secondary_nav']['#theme_wrappers'] = array('menu_tree__secondary');
  }*/
}

/**
 * Overrides theme_menu_tree() for book module.
 */
function hardwood_menu_tree__book_toc(&$variables) {
  $output = '<div class="book-toc btn-group pull-right">';
  $output .= '  <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">';
  $output .= t('!icon Outline !caret', array(
    '!icon' => '<span class="fa fa-list"></span>',
    '!caret' => '<span class="caret"></span>',
  ));
  $output .= '</button>';
  $output .= '<div class="dropdown-menu" role="menu">' . $variables['tree'] . '</div>';
  $output .= '</div>';
  return $output;
}

/**
 * Overrides theme_menu_tree() for book module.
 */
function hardwood_menu_tree__book_toc__sub_menu(&$variables) {
  return '<div class="dropdown-menu" role="menu">' . $variables['tree'] . '</div>';
}