<?php
/**
 * @file
 * Provides a generic download page with progress bar and file download link.
 *
 * It is expected that the name of a tripal download type has been provided as the first
 * arguement (trpdownload_key) to this template. This template will then use information
 * registered with this API to:
 *  1. Create a tripal job which calls the generate_file function specified in
 *       hook_register_trpdownload_type() for this tripal download type. It passes along
 *       any unused url parameters and the query paramters to the generate_file function.
 *  2. Store the job_id in the URL allowing the user to bookmark their download and/or
 *       come back to it later (perhaps just to give it time to generate the file).
 *  3. Reports the progress of the Tripal job to the user so they can determine how long
 *       it will take before their file is ready.
 *  4. Once ready, this page provides a link that downloads the generated file to the
 *       users computer.
 */
$info = $variables['download_args']['type_info'];
?>

<!-- Change the URL to include the job code and remove the query parameters.
      This is done via javascript/HTML5 in order to avoid the page refresh. -->
<?php if (isset($variables['path'])) : ?>
  <script>
    window.history.replaceState('', 'Download: Job Submitted', "<?php print $variables['path'];?>");
  </script>
<?php endif; ?>

<div class="download-page">

<?php if (isset($variables['job_id'])) { ?>

  <div class="context-text">We are working on generating the file you requested. Refer to the progress bar below for status.</div>
  <div class="progress-pane"></div>
  <div class="download-pane">
    <?php print theme_image(array(
      'path' => drupal_get_path('module','trpdownload_api').'/theme/icons/file_generic.128.png',
      'alt' => 'file download icon',
      'attributes' => array()
    ));?>
    <div class="inner-pane file">
      <h2>File:</h2>
      <div class="file-link">
        <?php print l(
          $variables['download_args']['filename'],
          $variables['file_download_url'],
          array('attributes' => array('download' => $variables['download_args']['filename'], 'target' => '_blank'))
        );?></div>
      <div class="file-format">Format: <?php print $variables['download_args']['format_name']?></div>
    </div>
    <div class="inner-pane summary">
      <?php if (isset($info['functions']['summarize']) AND function_exists($info['functions']['summarize'])) { ?>
      <h2>Summary:</h2>
        <?php print call_user_func($info['functions']['summarize'], $variables, drupal_get_query_parameters());
      } ?>
    </div>
  </div>

<?php } else { ?>

  <div class="messages error">We are unable to generate the file you requested. Please contact the Site Administrator.</div>

<?php } ?>
</div>
