<?php

/**
 * Template to keep the user updated on the progress of their BLAST
 *
 * Available Variables:
 *  - $status_code: a numerical code describing the status of the job. See the table
 *    below for possible values.
 *  - $status: a string describing the status of the job. See the table below for
 *    possible values
 *
 *    CODE          STATUS                DESCRIPTION
 *     0             Pending               The tripal job has been created but has not yet been launched.
 *     1             Running               The Tripal job is currently running.
 *    999            Cancelled             The Tripal job was cancelled by an administrator.
 */
?>

<script>
Drupal.behaviors.blastuiSetTimeout = {
  attach: function (context, settings) {
    setTimeout(function(){
       window.location.reload(1);
    }, 5000);
  }
};

</script>

<?php
  // JOB IN QUEUE
  if ($status_code === 0) {
    drupal_set_title('BLAST Job in Queue');
?>

  <p>Your BLAST has been registered and will be started shortly. This page will automatically refresh.</p>

<?php
  }
  // JOB IN PROGRESS
  elseif ($status_code === 1) {
    drupal_set_title('BLAST Job in Progress');
?>

  <p>Your BLAST job is currently running. The results will be listed here as soon as it completes. This page will automatically refresh.</p>

<?php
  }
  // JOB CANCELLED
  elseif ($status_code === 999) {
    drupal_set_title('BLAST Job Cancelled');
?>

  <p>Unfortunately your BLAST job has been cancelled by an Administrator.  This page will automatically refresh.</p>

<?php
 }
?>