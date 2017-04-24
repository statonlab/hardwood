/**
 * Updates the file status box based on the same JSON used to
 * update the progress bar.
 *
 * To set the URL of the JSON callback add the following code to the
 * preprocess hook for your download template. This is already taken
 * care of for you if you use the generic_download_page.tpl.php
 * @code
 drupal_add_js(
 array(
 'trpdownloadApiProgressBar' => array(
 'progressPath' => url('/tripal/progress/job/'.$trpdownload_key.'/'.$variables['job_id'])
 )
 ),
 'setting'
 );
 * @endcode
 */
(function ($) {
  Drupal.behaviors.trpdownloadApiFileBoxFeedback = {
    attach: function (context, settings) {

      if (typeof Drupal.settings.trpdownloadApiProgressBar === 'undefined') {
        return;
      }

      setTimeout(trpdownloadapiUpdateStatus, 1000);

      function trpdownloadapiUpdateStatus() {
        var btn = $('#download-btn');
        $.ajax({
          type: 'GET',
          url: Drupal.settings.trpdownloadApiProgressBar.progressPath,
          data: '',
          dataType: 'json',
          success: function (progress) {
            // Display errors.
            if (progress.status == 0) {
              return;
            }
            // Update display.
            /*pane.removeClass('file-not-ready');
             pane.removeClass('file-ready');
             pane.removeClass('file-error');
             pane.addClass(progress.file_class);*/

            // If our progress is complete then stop checking.
            if (progress.percentage == 100) {
              btn.removeAttr("disabled").removeClass('disabled');
              return;
            }

            // If we encountered an error, stop checking
            if (progress.file_class == 'file-error') {
              $('.progress-wrapper .message').addClass('text-danger');
              btn.parent().prepend('<p class="text-danger">'
                + 'An error occurred while processing your request. '
                + 'Please <a href="/contact">contact us</a> to resolve this issue. '
                + 'We apologize for any inconvenience this may have caused.</p>');
              btn.remove()
              return;
            }

            // Only if our progress is not complete, disable link
            // and, of course, schedule when to check again.
            else {
              btn.attr("disabled", true);

              setTimeout(trpdownloadapiUpdateStatus, 1000);
            }
          },
          error: function (xmlhttp) {
            pb.displayError(Drupal.ajaxError(xmlhttp, pb.uri));
          }
        });
      };
    }
  };
}(jQuery));
