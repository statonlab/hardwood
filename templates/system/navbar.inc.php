<?php if ($main_menu || $secondary_menu): ?>
 <nav id="navigation" class="main-header navbar navbar-light bg-faded navbar-full navbar-toggleable-md">
  <div class="container">
   <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
   </button>

   <a class="navbar-brand" href="/">
    <span class="logo-icon"><i class="fa fa-leaf"></i></span>
    <div class="logo-wrapper">
     <span class="logo-text"><?php print variable_get('site_name') ?></span>
     <div class="text-muted text-xs hidden-xs-down">
       <?php print variable_get('site_slogan') ?>
     </div>
    </div>
   </a>

   <div class="collapse navbar-collapse" id="navbar-collapse">
     <?php
     if (!empty($primary_nav)):
       print render($primary_nav);
     endif;
     ?>
   </div>
  </div>
 </nav> <!-- /.section, /#navigation -->
<?php endif; ?>