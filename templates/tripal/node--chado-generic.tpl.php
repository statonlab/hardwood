<?php

if ($teaser) {
    print render($content);
} else {
    $node_type = $node->type; ?>

    <script type="text/javascript">
        // We do not use Drupal Behaviors because we do not want this
        // code to be executed on AJAX callbacks. This code only needs to
        // be executed once the page is ready.
        jQuery(document).ready(function ($) {

            // Hide all but the first data pane
            $('.tripal-data-pane').hide().filter(':first-child').show()

            // When a title in the table of contents is clicked, then
            // show the corresponding item in the details box
            $('.tripal_toc_list_item_link').click(function () {
                var id = $(this).attr('id') + '-tripal-data-pane'
                $('.tripal-data-pane').hide().filter('#' + id).fadeIn('fast')
                $('.tripal_toc_list_item_link').removeClass('active')
                $(this).addClass('active')
                return false
            })

            // If a ?pane= is specified in the URL then we want to show the
            // requested content pane. For previous version of Tripal,
            // ?block=, was used.  We support it here for backwards
            // compatibility
            var pane
            pane = window.location.href.match(/[\?|\&]pane=(.+?)[\&|\#]/)
            if (pane == null) {
                pane = window.location.href.match(/[\?|\&]pane=(.+)/)
            }
            // if we don't have a pane then try the old style ?block=
            if (pane == null) {
                pane = window.location.href.match(/[\?|\&]block=(.+?)[\&|\#]/)
                if (pane == null) {
                    pane = window.location.href.match(/[\?|\&]block=(.+)/)
                }
            }
            if (pane != null) {
                $('.tripal-data-pane').hide().filter('#' + pane[1] + '-tripal-data-pane').show()
                $('.tripal_toc_list_item_link[href="'+pane[0]+'"]').addClass('active')
            }

            if(pane === null) {
                $('.tripal_toc_list_item_link').first().addClass('active')
            }

            // Remove the 'active' class from the links section, as it doesn't
            // make sense for this layout
            //$('a.active').removeClass('active')
        })
    </script>
    <div class="row">
        <div class="col-sm-2">
            <?php
            // print the table of contents. It's found in the content array
            if (array_key_exists('tripal_toc', $content)) {
                print $content['tripal_toc']['#markup'];

                // we may want to add the links portion of the contents to the sidebar
                //print render($content['links']);

                // remove the table of contents and links so thye doent show up in the
                // data section when the rest of the $content array is rendered
                unset($content['tripal_toc']);
                unset($content['links']);
            }
            ?>
        </div>
        <div class="col-sm-10">
            <?php
            // print the rendered content
            foreach ($content as $key => $value) {
                if (isset($content[$key]['#markup'])) {
                    $content[$key]['#markup'] = rtrim(trim($content[$key]['#markup']), '</div>');
                }
            }
            print render($content);
            ?>
        </div>
    </div>
    <?php
}


