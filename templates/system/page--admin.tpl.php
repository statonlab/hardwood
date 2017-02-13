<?php

/**
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
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
?>
<style>.container-fluid {
  max-width: 1900px !important;
 }

 .indentation {
  display: none;
 }</style>
<div id="page-wrapper" class="admin-page">
 <div id="page">

   <?php include_once "navbar.inc.php"; ?>

   <?php /*if ($breadcrumb): ?>
        <div id="breadcrumb">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <?php print $breadcrumb; ?>
              </div>
            </div>
          </div>
        </div>
    <?php endif; */ ?>

  <div id="main-wrapper">
   <div id="main" class="clearfix">

     <?php if ($title): ?>
      <div class="section page-header">
       <div class="container">
        <div class="row">
         <div class="col-12">
           <?php print render($title_prefix); ?>
          <h1 class="title" id="page-title"><?php print $title; ?></h1>
           <?php print render($title_suffix); ?>
         </div>
        </div>
       </div>
      </div><!-- /.section -->
     <?php endif; ?>

    <div class="section">
     <div class="container">
      <div class="row">
        <?php if ($page['sidebar_first'] || $page['sidebar_second'] || $page['admin_menu']): ?>

         <div class="col-lg-2">
          <?php if($page['admin_menu']): ?>
          <?php print render($page['admin_menu']); ?>
          <?php endif; ?>

           <?php if ($page['sidebar_first']): ?>
            <div id="sidebar-first" class="column sidebar">
              <?php print render($page['sidebar_first']); ?>
            </div> <!-- /#sidebar-first -->
           <?php endif; ?>

           <?php if ($page['sidebar_second']): ?>
            <div id="sidebar-second" class="column sidebar">
              <?php print render($page['sidebar_second']); ?>
            </div> <!-- /#sidebar-second -->
           <?php endif; ?>
         </div>

        <?php endif; ?>

        <?php $main_content_classes = !empty($page['sidebar_first']) || !empty($page['sidebar_second']) || !empty($page['admin_menu']) ? 'col-lg-10' : 'col-12'; ?>
       <div class="<?php print $main_content_classes ?>">

         <?php if ($page['highlighted']): ?>
          <div id="highlighted"><?php print render($page['highlighted']); ?></div>
         <?php endif; ?>

        <a id="main-content"></a>

         <?php if ($tabs): ?>
           <?php print render($tabs); ?>
         <?php endif; ?>

         <?php print render($page['help']); ?>

         <?php if ($action_links): ?>
          <ul class="action-links"><?php print render($action_links); ?></ul>
         <?php endif; ?>

         <?php if ($messages): ?>

          <div class="col-12">
            <?php print $messages; ?>
          </div>

         <?php endif; ?>
        <div class="main-content-wrapper">
          <?php print render($page['content']); ?>
        </div>
         <?php print $feed_icons; ?>
       </div>
      </div><!-- /.row, .col-sm -->
     </div><!-- /.container -->
    </div> <!-- /.section -->
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
