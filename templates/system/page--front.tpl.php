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

<div id="page-wrapper">
    <div id="page">

      <?php include_once "navbar.inc.php"; ?>

        <!-- FRONT PAGE JUMBOTRON -->
        <div class="jumbotron front-page">
            <div class="jumbotron-inner">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="text-center">
                                Welcome to the Hardwood Genomics Project
                            </h1>
                            <p class="lead text-center">
                                Genomic resources for hardwood trees
                            </p>

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
                                   class="btn btn-outline-secondary">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="main-wrapper">
            <div id="main" class="clearfix">

                <div class="section bg-gray">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h2 class="section-header">Available Tools</h2>
                            </div>
                        </div>
                        <div class="tools-container d-flex align-items-stretch flex-wrap">
                            <div class="card tool-card mb-1">
                                <div class="card-body">
                                    <span class="icon">
                                        <i class="fa fa-server"></i>
                                    </span>
                                    <div class="tool-card-content">
                                        <h4 class="card-title">Cross Site Search</h4>
                                        <p>
                                            Search across multiple websites in our network all at once
                                        </p>
                                        <a href="/cross-site-search"
                                           class="btn btn-outline-primary btn-sm">Try Cross Site Search</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card tool-card mb-1">
                                <div class="card-body">
                                    <span class="icon">
                                        <i class="fa fa-search"></i>
                                    </span>
                                    <div class="tool-card-content">
                                        <h4 class="card-title">Transcript Search</h4>
                                        <p>
                                            Filter transcripts by organism, description or sequence name
                                        </p>
                                        <a href="/tripal_elasticsearch/search_table"
                                           class="btn btn-outline-primary btn-sm">Try Transcript Search</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card tool-card mb-1">
                                <div class="card-body">
                                    <span class="icon">
                                        <i class="fa fa-bar-chart"></i>
                                    </span>
                                    <div class="tool-card-content">
                                        <h4 class="card-title">Expression Visualization</h4>
                                        <p>
                                            Use our interactive heat map to visualize expressions
                                        </p>
                                        <a href="/content/expression-visualization"
                                           class="btn btn-outline-primary btn-sm">Try Expression Visualization</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card tool-card mb-1">
                                <div class="card-body">
                                    <span class="icon">
                                        <i class="fa fa-align-center"></i>
                                    </span>
                                    <div class="tool-card-content">
                                        <h4 class="card-title">JBrowse</h4>
                                        <p>
                                            Use our interactive heat map to visualize expressions
                                        </p>
                                        <a href="/content/jbrowse"
                                           class="btn btn-outline-primary btn-sm">Try JBrowse</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card tool-card mb-1">
                                <div class="card-body">
                                    <span class="icon">
                                        <i class="fa fa-database"></i>
                                    </span>
                                    <div class="tool-card-content">
                                        <h4 class="card-title">Blast</h4>
                                        <p>
                                            Use our interactive heat map to visualize expressions
                                        </p>
                                        <a href="/blast"
                                           class="btn btn-outline-primary btn-sm">Try Blast</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card tool-card mb-1">
                                <div class="card-body">
                                    <span class="icon">
                                        <i class="fa fa-tree"></i>
                                    </span>
                                    <div class="tool-card-content">
                                        <h4 class="card-title">Explore Available Trees</h4>
                                        <p>
                                            Use our interactive heat map to visualize expressions
                                        </p>
                                        <a href="/organisms"
                                           class="btn btn-outline-primary btn-sm">Explore Available Trees</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
