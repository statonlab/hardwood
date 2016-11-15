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

    <nav id="navigation" class="main-header navbar navbar-light bg-faded navbar-sticky-top">
      <div class="container">
        <a class="navbar-brand" href="/">
          <span class="logo-icon"><i class="fa fa-leaf"></i></span>
          <div class="logo-wrapper">
            <span class="logo-text"><?php print variable_get('site_name'); ?></span>
            <div class="text-muted text-xs hidden-xs-down">
              <?php print variable_get('site_slogan'); ?>
            </div>
          </div>
        </a>

        <?php
        if ($main_menu):
          print theme('links__system_main_menu', array(
            'links' => $main_menu,
            'attributes' => array(
              'id' => 'main-menu',
              'class' => array('nav', 'navbar-nav')
            )
          ));
        endif;
        ?>

        <?php if (!user_is_logged_in()): ?>
          <ul class="nav navbar-nav float-xs-right">
            <li class="nav-item"><a href="/?q=user/login" class="nav-link">Login</a></li>
          </ul>
        <?php endif; ?>

        <?php
        if ($secondary_menu):
          print theme('links__system_secondary_menu', array(
            'links' => $secondary_menu,
            'attributes' => array(
              'id' => 'secondary-menu',
              'class' => array('nav', 'navbar-nav', 'float-xs-right')
            )
          ));
        endif;
        ?>
      </div>
    </nav> <!-- /.section, /#navigation -->

    <?php /*
        if (breadcrumb)
        <div id="breadcrumb">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <?php print breadcrumb; ?>
                    </div>
                </div>
            </div>
        </div>
        */ ?>

    <!-- FRONT PAGE JUMBOTRON -->
    <div class="jumbotron front-page">
      <div class="jumbotron-inner">
        <div class="container">
          <h1 class="text-xs-center">
            Welcome to the Hardwood Genomics Project
          </h1>
          <p class="lead text-xs-center">
            We house transcriptome and genome resources for hardwood trees
          </p>
          <div class="margin-top-1 text-xs-center">
            <a href="#" class="btn btn-success">Contribute Data</a>
            <a href="#" class="btn btn-outline-secondary">Contact Us</a>
          </div>
        </div>
      </div>
    </div>

    <?php if ($page['front_search']): ?>
      <div class="section bg-gray">
        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 offset-md-3">
              <?php print render($page['front_search']); ?>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($messages): ?>
      <div class="section">
        <div class="container">
          <div class="row">
            <div class="col-xs-12">
              <?php print $messages; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <div id="main-wrapper">
      <div id="main" class="clearfix">
        <div class="section">
          <div class="container">
            <div class="row">
              <div class="col-xs-12">

                <a id="main-content"></a>

                <?php if ($tabs): ?>
                  <div class="tabs"><?php print render($tabs); ?></div>
                <?php endif; ?>

                <?php if ($action_links): ?>
                  <ul class="action-links"><?php print render($action_links); ?>
                    ?>
                  </ul>
                <?php endif; ?>

                <!-- Main Content Goes Here -->
                <div class="col-xs-12">
                  <h2 class="section-header">
                    Species and Resources
                  </h2>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6 col-md-4">
                  <div class="card">
                    <img class="card-img-top img-fluid" src="<?php print base_path() . path_to_theme() . '/dist/images/castanea-crenata-leaf.jpg'; ?>" alt="Card image cap">
                    <div class="card-block">
                      <h4 class="card-title">
                        <a href="#">Chinese Chestnut</a>
                      </h4>
                      <p class="card-text">Some quick example text to build on
                        the card title and
                        make up the bulk of the card's content.</p>
                      <a href="#" class="btn btn-outline-success">Go
                        somewhere</a>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6 col-md-4">
                  <div class="card">
                    <img class="card-img-top img-fluid" src="<?php print base_path() . path_to_theme() . '/dist/images/american_beech_leaves.jpg'; ?>" alt="Card image cap">
                    <div class="card-block">
                      <h4 class="card-title"><a href="#">American Beech</a></h4>
                      <p class="card-text">Some quick example text to build on
                        the card title and
                        make up the bulk of the card's content.</p>
                      <a href="#" class="btn btn-outline-success">Go
                        somewhere</a>
                    </div>
                  </div>
                </div>

                <div class="clearfix hidden-md-up"></div>

                <div class="col-sm-6 col-md-4">
                  <div class="card">
                    <img class="card-img-top img-fluid" src="<?php print base_path() . path_to_theme() . '/dist/images/American-chestnut-allen-breed-ap.jpg'; ?>?>" alt="Card image cap">
                    <div class="card-block">
                      <h4 class="card-title"><a href="#">American Chestnut</a>
                      </h4>
                      <p class="card-text">Some quick example text to build on
                        the card title and
                        make up the bulk of the card's content.</p>
                      <a href="#" class="btn btn-outline-success">Go
                        somewhere</a>
                    </div>
                  </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-xs-12">
                  <a href="#" class="btn btn-link btn-lg">See All</a>
                </div>

              </div>
            </div><!-- /.row, .col-sm -->

          </div><!-- /.container -->
        </div> <!-- /.section -->
      </div>
    </div> <!-- /#main, /#main-wrapper -->

    <?php if ($page['content']): ?>
      <div class="section bg-gray">
        <div class="container">
          <div class="row">
            <div class="col-xs-12">
              <div class="card">
                <div class="card-block">
                  <?php print render($page['content']); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <div class="section bg-gray">
      <div class="container">
        <div class="col-sm-4">
          <img src="<?php print base_path() . path_to_theme() . '/dist/images/ut2.png'; ?>" alt="UTK Logo" class="img-fluid img-max-h100">
        </div>
        <div class="col-sm-4 text-xs-center">
          <img src="<?php print base_path() . path_to_theme() . '/dist/images/nsf.gif'; ?>" alt="NSF Logo" class="img-fluid img-max-h100">
        </div>
        <div class="col-sm-4">
          <h5>Sitemap</h5>
          <div class="row">
            <div class="col-sm-6">
              <?php print theme('links__system_main_menu', array(
                'links' => $main_menu,
                'attributes' => array(
                  'id' => 'main-menu',
                  'class' => array('list-unstyled')
                )
              )); ?>
            </div>
            <div class="col-sm-6">
              <?php print theme('links__system_secondary_menu', array(
                'links' => $secondary_menu,
                'attributes' => array(
                  'id' => 'secondary-menu',
                  'class' => array('list-unstyled')
                )
              )); ?>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div id="footer" class="secondary-footer">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <?php print render($page['footer']); ?>
          </div>
        </div>
      </div>
    </div> <!-- /.section, /#footer -->

  </div>
</div> <!-- /#page, /#page-wrapper -->
