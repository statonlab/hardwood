<?php

/**
 * Include all necessary files.
 */
include_once drupal_get_path('theme',
    'hardwood') . '/templates/system/page.vars.php';

/**
 * Add `btn` class to all buttons.
 *
 * @param $variables
 */
function hardwood_preprocess_button(&$variables) {
  $variables['element']['#attributes']['class'][] = 'btn';
  $variables['element']['#attributes']['class'][] = 'mb-2';

  if (is_array($variables['element']['#attributes']['class'])) {
    if (in_array('btn-default',
        $variables['element']['#attributes']['class']) || in_array('btn-danger',
        $variables['element']['#attributes']['class']) || in_array('btn-warning',
        $variables['element']['#attributes']['class']) || in_array('btn-info',
        $variables['element']['#attributes']['class'])
    ) {
      return;
    }
  }

  // Special styles for Delete/Destructive Buttons.
  if (stristr($variables['element']['#value'], 'Delete') !== FALSE) {
    $variables['element']['#attributes']['class'][] = 'btn-danger';
  }
  else {
    $variables['element']['#attributes']['class'][] = 'btn-primary';
  }
}

/**
 * Add class `form-control` to text fields
 *
 * @param $variables
 */
function hardwood_preprocess_textfield(&$variables) {
  $variables['element']['#attributes']['class'][] = 'form-control';
}

/**
 * Add class `form-control` to file fields
 *
 * @param $variables
 */
function hardwood_preprocess_file(&$variables) {
  $variables['element']['#attributes']['class'][] = 'form-control';
}

/**
 * Implements theme_textfield()
 *
 * The only reason we need this is to remove the default
 * `form-text` class that drupal adds to text fields.
 *
 * @param $variables
 *
 * @return string
 */
function hardwood_textfield($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'text';
  element_set_attributes($element, [
    'id',
    'name',
    'value',
    'size',
    'maxlength',
  ]);
  //_form_set_class($element, array('form-text'));

  $extra = '';
  if ($element['#autocomplete_path'] && !empty($element['#autocomplete_input'])) {
    drupal_add_library('system', 'drupal.autocomplete');
    $element['#attributes']['class'][] = 'form-autocomplete';

    $attributes = [];
    $attributes['type'] = 'hidden';
    $attributes['id'] = $element['#autocomplete_input']['#id'];
    $attributes['value'] = $element['#autocomplete_input']['#url_value'];
    $attributes['disabled'] = 'disabled';
    $attributes['class'][] = 'autocomplete';
    $extra = '<input' . drupal_attributes($attributes) . ' />';
  }

  $output = '<input' . drupal_attributes($element['#attributes']) . ' />';

  return $output . $extra;
}

/**
 * Implements theme_textarea()
 *
 * Add .form-control to textarea fields
 *
 * @param $variables
 *
 * @return string
 */
function hardwood_textarea($variables) {
  $element = $variables['element'];
  element_set_attributes($element, ['id', 'name']);
  _form_set_class($element, ['form-control']);

  $wrapper_attributes = [
    'class' => ['form-textarea-wrapper'],
  ];

  // Add resizable behavior.
  if (!empty($element['#resizable'])) {
    drupal_add_library('system', 'drupal.textarea');
    $wrapper_attributes['class'][] = 'resizable';
  }

  $output = '<div' . drupal_attributes($wrapper_attributes) . '>';
  $output .= '<textarea' . drupal_attributes($element['#attributes']) . '>' . check_plain($element['#value']) . '</textarea>';
  $output .= '</div>';

  return $output;
}

/**
 * Implements theme_password()
 *
 * Add .form-control to password fields
 *
 * @param $variables
 *
 * @return string
 */
function hardwood_password($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'password';
  element_set_attributes($element, ['id', 'name', 'size', 'maxlength']);
  _form_set_class($element, ['form-control']);

  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}

/**
 * Implements theme_form_search_block_form_alter()
 *
 * Alter the search form.
 *
 * @param $form
 */
function hardwood_form_search_block_form_alter(&$form) {
  $form['search_block_form']['#attributes']['placeholder'] = "Search...";
  $form['search_block_form']['#field_prefix'] = FALSE;
  $form['search_block_form']['#field_suffix'] = FALSE;
}

/**
 * Implements theme_form_element().
 *
 * Apply bootstrap wrappings and classes on all form elements.
 *
 * @param $variables
 *
 * @return string
 */
function hardwood_form_element($variables) {
  $element = &$variables['element'];

  // This function is invoked as theme wrapper, but the rendered form element
  // may not necessarily have been processed by form_builder().
  $element = array_merge($element, ['#title_display' => 'before']);

  // Add a class for disabled elements to facilitate cross-browser styling.
  if (!empty($element['#attributes']['disabled'])) {
    $attributes['class'][] = 'disabled';
  }

  // Add element #id for #type 'item'.
  if (isset($element['#markup']) && !empty($element['#id'])) {
    $attributes['id'] = $element ['#id'];
  }
  // Add element's #type and #name as class to aid with JS/CSS selectors.
  $attributes['class'] = ['form-item'];
  if (!empty($element['#type'])) {
    $attributes['class'][] = 'form-type-' . strtr($element['#type'], '_', '-');
  }
  if (!empty($element['#name'])) {
    $attributes['class'][] = 'form-item-' . strtr($element['#name'], [
        ' ' => '-',
        '_' => '-',
        '[' => '-',
        ']' => '',
      ]);
  }

  $output = '<div' . drupal_attributes($attributes) . '>' . "\n";

  // If #title is not set, we don't display any label or required marker.
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }

  $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span>' : '<div class="form-group">';
  $suffix = isset($element['#field_suffix']) ? '<span class="field-prefix">' . $element['#field_suffix'] . '</span>' : '</div>';

  switch ($element['#title_display']) {
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $variables);
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;

    case 'after':
      $output .= ' ' . $prefix . $element['#children'] . $suffix;
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;
  }

  if (!empty($element['#description'])) {
    $output .= '<div class="form-text text-muted">' . $element['#description'] . "</div>\n";
  }

  $output .= "</div>\n";

  return '<div class="form-group">' . $output . '</div>';
}

/**
 * Implements theme_button()
 *
 * @param $variables
 *
 * @return string
 */
function hardwood_button($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'submit';
  element_set_attributes($element, ['id', 'name', 'value']);

  $element ['#attributes']['class'][] = 'form-' . $element ['#button_type'];
  if (!empty($element['#attributes']['disabled'])) {
    $element['#attributes']['class'][] = 'disabled';
  }

  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}

/**
 * Alter status messages to use bootstrap alerts.
 *
 * @param $variables
 *
 * @return string
 */
function hardwood_status_messages($variables) {
  $display = $variables['display'];
  $output = '';

  $status_heading = [
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
  ];
  foreach (drupal_get_messages($display) as $type => $messages) {
    switch ($type) {
      case "error":
        $cc = 'alert-danger';
        break;
      case "warning":
        $cc = 'alert-warning';
        break;
      case 'status':
        $cc = 'alert-info';
        break;
    }
    $output .= "<div class=\"alert $cc\">\n";
    if (!empty($status_heading[$type])) {
      $output .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
    }
    if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        $output .= '  <li>' . $message . "</li>\n";
      }
      $output .= " </ul>\n";
    }
    else {
      $output .= reset($messages);
    }
    $output .= "</div>\n";
  }

  return $output;
}

/**
 * Add the menu menu wrapper.
 *
 * @param $variables
 *
 * @return string
 */
function hardwood_menu_tree__primary(array &$variables) {
  return '<ul class="navbar-nav ml-lg-auto mr-md-auto mr-lg-0">' . $variables['tree'] . '</ul>';
}

/**
 * Returns HTML for a menu link and submenu.
 *
 * @param array $variables
 *   An associative array containing:
 *   - element: Structured array data for a menu link.
 *
 * @return string
 *   The constructed HTML.
 *
 * @see theme_menu_link()
 *
 * @ingroup theme_functions
 */
function hardwood_menu_link__main_menu(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  $title = $element['#title'];
  $href = $element['#href'];
  $options = !empty($element['#localized_options']) ? $element['#localized_options'] : [];
  $attributes = !empty($element['#attributes']) ? $element['#attributes'] : [];
  $attributes['class'][] = 'nav-item';
  $options['attributes']['class'][] = 'nav-link';

  if ($element['#below']) {
    // Prevent dropdown functions from being added to management menu so it
    // does not affect the navbar module.
    if (($element['#original_link']['menu_name'] == 'management') && (module_exists('navbar'))) {
      $sub_menu = drupal_render($element['#below']);
    }
    elseif ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] == 1)) {
      // Add our own wrapper.
      //$element['#below']['#theme_wrappers'] = array('menu_tree__sub_menu');
      $sub_menu = '<div class="dropdown-menu">' . drupal_render($element['#below']) . '</div>';

      // Generate as standard dropdown.
      $attributes['class'][] = 'dropdown';

      $options['html'] = TRUE;

      // Set dropdown trigger element to # to prevent inadvertant page loading
      // when a submenu link is clicked.
      $options['attributes']['class'][] = 'dropdown-toggle';
      $options['attributes']['data-toggle'] = 'dropdown';
    }
  }

  return '<li' . drupal_attributes($attributes) . '>' . l($title, $href,
      $options) . $sub_menu . "</li>\n";
}

/**
 * Generates dropdown menu wrapper.
 *
 * @param array $variables
 *
 * @return string
 */
function hardwood_menu_tree_link__sub_menu(array &$variables) {
  return '<div class="dropdown-menu">' . $variables['tree'] . '</div>';
}

/**
 * Implements hook_theme_registry_alter().
 *
 * @param $theme_registry
 */
function hardwood_theme_registry_alter(&$theme_registry) {
  $path = path_to_theme();

  // Tell the theme system to look in the "templates" subdirectory within our theme directory
  // Force tripal_blast to use our blast_report template
  $theme_registry['show_blast_report']['theme paths'] = [0 => $path . '/templates'];
  $theme_registry['show_blast_report']['theme path'] = $path . '/templates';
  $theme_registry['show_blast_report']['path'] = $path . '/templates';
  $theme_registry['show_blast_report']['template'] = 'blast/blast_report';

  $theme_registry['trpdownload_page']['path'] = $path . '/templates';
  $theme_registry['trpdownload_page']['template'] = 'other/generic_download_page';

  foreach ($theme_registry as $key => $theme) {
    if (isset($theme['template']) && strpos($theme['template'],
        'node--chado-generic') !== FALSE
    ) {
      $theme_registry[$key]['path'] = $path . '/templates';
      $theme_registry[$key]['template'] = 'tripal/node--chado-generic';
    }
  }
}

/**
 * Alter the search form to use Bootstrap fields.
 *
 * @param $form
 * @param $form_state
 */
function hardwood_form_main_search_box_form_alter(&$form, &$form_state) {
  $input_group_classes = "input-group";
  if (drupal_is_front_page()) {
    $input_group_classes .= ' input-group-lg';
  }
  $form['search']['search_box']['#field_prefix'] = '<div class="' . $input_group_classes . '">';
  $form['search']['search_box']['#field_suffix'] = '';
  $form['search']['search_box']['#attributes']['placeholder'] = 'Search...';
  $form['search']['search_submit']['#prefix'] = '<div class="input-group-btn">';
  // Close both the .input-group-btn and .input-group divs
  $form['search']['search_submit']['#suffix'] = '</div></div>';
}

/**
 * Add `form-control` class to the category <select> element in the contact
 * page.
 *
 * @param $form
 * @param $form_state
 */
function hardwood_form_contact_site_form_alter(&$form, &$form_state) {
  $form['cid']['#attributes']['class'][] = 'form-control';
}

/**
 * Alter or add JS files to pages.
 *
 * @param $javascript
 */
function hardwood_js_alter(&$javascript) {
  unset($javascript['misc/collapse.js']);
  drupal_add_js(drupal_get_path('theme', 'hardwood') . '/dist/js/collapse.js',
    []);
}

/**
 * Implements theme_progress_bar()
 *
 * Changes the progress bar markup to match BS4
 *
 * @param $variables
 *
 * @return string
 */
function hardwood_progress_bar($variables) {
  $output = "<div class=\"progress\">";
  $output .= "<div class=\"progress-bar\" role=\"progressbar\" style=\"width:{$variables['percent']}%\" aria-valuenow=\"{$variables['percent']}\" aria-valuemin=\"0\" aria-valuemax=\"100\">{$variables['percent']}%</div>";
  $output .= "</div>";
  $output .= '<div class="message">' . $variables['message'] . '</div>';

  return $output;
}
