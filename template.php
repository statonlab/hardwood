<?php
/**
 * Implements theme_preprocess_page
 *
 * @param $variables
 */
function hardwood_preprocess_page(&$variables) {
  // Add Bootstrap classes to menu elements in both main menu and secondary menu
  if ($variables['main_menu']) {
    $main_menu = array();
    foreach ($variables['main_menu'] as $key => $item) {
      $item['attributes']['class'][] = 'nav-link';
      $main_menu[$key . ' nav-item'] = $item;

    }
    $variables['main_menu'] = $main_menu;
  }

  if ($variables['secondary_menu']) {
    $secondary_menu = array();
    foreach ($variables['secondary_menu'] as $key => $item) {
      $item['attributes']['class'][] = 'nav-link';
      $secondary_menu[$key . ' nav-item'] = $item;

    }
    $variables['secondary_menu'] = $secondary_menu;
  }
}

/**
 * Add `btn` class to all buttons.
 * @param $variables
 */
function hardwood_preprocess_button(&$variables) {
  $variables['element']['#attributes']['class'][] = 'btn';


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
 * @param $variables
 */
function hardwood_preprocess_textfield(&$variables) {
  $variables['element']['#attributes']['class'][] = 'form-control';
}

/**
 * Implements theme_textfield()
 *
 * The only reason we need this is to remove the default
 * `form-text` class that drupal adds to text fields.
 * @param $variables
 * @return string
 */
function hardwood_textfield($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'text';
  element_set_attributes($element, array(
    'id',
    'name',
    'value',
    'size',
    'maxlength'
  ));
  //_form_set_class($element, array('form-text'));

  $extra = '';
  if ($element['#autocomplete_path'] && !empty($element['#autocomplete_input'])) {
    drupal_add_library('system', 'drupal.autocomplete');
    $element['#attributes']['class'][] = 'form-autocomplete';

    $attributes = array();
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
 * @param $variables
 * @return string
 */
function hardwood_textarea($variables) {
  $element = $variables['element'];
  element_set_attributes($element, array('id', 'name'));
  _form_set_class($element, array('form-control'));

  $wrapper_attributes = array(
    'class' => array('form-textarea-wrapper'),
  );

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
 * @param $variables
 * @return string
 */
function hardwood_password($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'password';
  element_set_attributes($element, array('id', 'name', 'size', 'maxlength'));
  _form_set_class($element, array('form-control'));

  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}

/**
 * Implement theme_form_search_block_form_alter()
 * @param $form
 */
function hardwood_form_search_block_form_alter(&$form) {
  $form['search_block_form']['#attributes']['placeholder'] = "Search...";
  $form['search_block_form']['#field_prefix'] = false;
  $form['search_block_form']['#field_suffix'] = false;
}

/**
 * Implements theme_form_element
 * @param $variables
 * @return string
 */
function hardwood_form_element($variables) {
  $element = &$variables['element'];

  // This function is invoked as theme wrapper, but the rendered form element
  // may not necessarily have been processed by form_builder().
  $element += array(
    '#title_display' => 'before',
  );

  // Add a class for disabled elements to facilitate cross-browser styling.
  if (!empty($element['#attributes']['disabled'])) {
    $attributes['class'][] = 'disabled';
  }

  $output = '';
  // If #title is not set, we don't display any label or required marker.
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }
  $prefix = isset($element['#field_prefix']) ? $element['#field_prefix'] : '<div class="form-group">';
  $suffix = isset($element['#field_suffix']) ? $element['#field_suffix'] : '</div>';

  switch ($element['#title_display']) {
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $variables);
      $output .= ' ' . $element['#children'] . "\n";
      break;

    case 'after':
      $output .= ' ' . $element['#children'];
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      $output .= ' ' . $element['#children'] . "\n";
      break;
  }

  if (!empty($element['#description'])) {
    $output .= '<div class="form-text text-muted">' . $element['#description'] . "</div>\n";
  }

  return $prefix . $output . $suffix;
}

/**
 * Implements theme_button()
 *
 * @param $variables
 * @return string
 */
function hardwood_button($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'submit';
  element_set_attributes($element, array('id', 'name', 'value'));

  if (!empty($element['#attributes']['disabled'])) {
    $element['#attributes']['class'][] = 'disabled';
  }

  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}

function hardwood_status_messages($variables) {
  $display = $variables['display'];
  $output = '';

  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
  );
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

function hardwood_menu_tree($variables) {
  return '<ul class="list-unstyled">' . $variables['tree'] . '</ul>';
}

function hardwood_preprocess_menu_tree(&$variables) {
  //kpr($variables);
}

