<?php
/*
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $$page['help']: Dynamic help text, mostly for admin pages.
 * - $$page['highlighted']: Items for the highlighted content region.
 * - $$page['content']: The main content of the current page.
 * - $$page['sidebar_first']: Items for the first sidebar.
 * - $$page['sidebar_second']: Items for the second sidebar.
 * - $$page['header']: Items for the header region.
 * - $$page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */

?>

<div id="page-wrapper" class="front-page">
    <div id="page">

      <?php include_once "navbar.inc.php"; ?>

        <!-- FRONT PAGE JUMBOTRON -->
        <div class="jumbotron front-page">
            <div class="jumbotron-inner">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="text-center">
                                Hardwood Genomics Project
                            </h1>
                            <p class="lead text-center"
                               style="margin-top: 40px">
                                An open-source database for comparative and
                                functional genomics in forest trees and woody
                                plant species. Available data include genomes,
                                gene models, transcriptomes, gene expression,
                                functional annotation, and genetic markers.
                            </p>

                            <a href="/cross-site-search" class="announcement mt-4 mx-auto align-items-center pl-2 pr-3 d-flex justify-content-between">
                                <div>
                                    <span class="announcement-subtext text-xs">NEW</span>
                                    <span>Try searching across multiple genomic databases from a single page!</span>
                                </div>
                                <i class="fa fa-arrow-right"></i>
                            </a>

                          <?php if ($page['front_search']): ?>
                              <div class="row justify-content-center">
                                  <div class="col-12 col-md-8 col-xl-6 input-group-lg es-search-form-in-home">
                                    <?php print render($page['front_search']); ?>
                                  </div>
                              </div>
                          <?php endif; ?>

                            <div class="margin-top-1 text-center">
                                <a href="/contact"
                                   class="btn btn-success">Contribute Data</a>
                                <a href="/contact"
                                   class="btn btn-outline-secondary">Contact
                                    Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="main-wrapper">
            <div id="main" class="clearfix">
              <?php $main_content_classes = !empty($page['sidebar_first']) || !empty($page['sidebar_second']) ? 'col-sm-8 col-md-9' : 'col-12'; ?>
              <?php if ($page['content']): ?>
                  <div class="section">
                      <div class="container">
                          <div class="row">
                              <div class="<?php print $main_content_classes; ?>">
                                <?php if ($messages): ?>
                                  <?php print $messages; ?>
                                <?php endif; ?>
                                  <a id="main-content"></a>
                                <?php if ($tabs): ?>
                                  <?php print render($tabs); ?>
                                <?php endif; ?>

                                <?php print render($page['content']); ?>
                              </div>

                              <div class="col-sm-4 col-md-3">
                                <?php if ($page['sidebar_first']): ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <div id="sidebar-first"
                                                 class="column sidebar">
                                              <?php print render($page['sidebar_first']); ?>
                                            </div> <!-- /#sidebar-first -->
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($page['sidebar_second']): ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <div id="sidebar-second"
                                                 class="column sidebar">
                                              <?php print render($page['sidebar_second']); ?>
                                            </div> <!-- /#sidebar-second -->
                                        </div>
                                    </div>
                                <?php endif; ?>
                              </div>

                          </div>
                      </div>
                  </div>

                <?php if ($page['front_middle']): ?>
                      <div class="section bg-gray">
                        <?php print render($page['front_middle']) ?>
                      </div>
                <?php endif; ?>

                <?php if ($page['front_footer']): ?>
                      <div class="section">
                        <?php print render($page['front_footer']) ?>
                      </div>
                <?php endif; ?>
              <?php endif; ?>
            </div>
        </div> <!-- /#main, /#main-wrapper -->

        <div id="footer" class="secondary-footer">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                      <?php print render($page['footer']); ?>
                    </div>
                </div>
            </div>
        </div> <!-- /#footer -->

      <?php include_once "footer.inc.php"; ?>
    </div>
</div> <!-- /#page, /#page-wrapper -->
