<div class="section bg-inverse main-footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <a href="https://ag.tennessee.edu/Pages/default.aspx"
                   target="_blank">
                    <img src="<?php print base_path() . path_to_theme() . '/dist/images/ut3.png'; ?>"
                         alt="UTK Logo" class="img-fluid img-max-h100">
                </a>
            </div><!-- /.col -->
            <div class="col-sm-4 text-center">
                <a href="https://www.nsf.gov" target="_blank">
                    <img src="<?php print base_path() . path_to_theme() . '/dist/images/nsf.gif'; ?>"
                         alt="NSF Logo" class="img-fluid img-max-h100">
                </a>
            </div><!-- /.col -->
            <div class="col-sm-4 text-center">
                <a href="http://tripal.info" target="_blank">
                    <img src="<?php print base_path() . path_to_theme() . '/dist/images/powered_by_tripal.png'; ?>"
                         alt="Tripal Logo" class="img-fluid img-max-h100">
                </a>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!-- /.section -->

<?php if (isset($help_items) && $help_items): ?>
    <div class="help-button-block">
        <a href="#" class="help-button-trigger">
            <i class="fa fa-hand-o-up"></i>
             Help
        </a>
        <div class="help-button-content">
          <?php foreach ($help_items as $item): ?>
              <div>
                  <a href="<?php print "/node/{$item['node']->nid}" ?>" class="help-node-title">
                      <strong>
                        <?php print $item['node']->title ?>
                      </strong>
                  </a>
                <?php if (!empty($item['topics'])): ?>
                    <ul class="list-unstyled ml-4">
                      <?php foreach ($item['topics'] as $topic): ?>
                        <li>
                            <a href="<?php print "/node/{$item['node']->nid}?help_pane=help-tabs--tab_{$topic->id}"?>" class="help-tab-title">
                            <?php print $topic->title ?>
                            </a>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                <?php endif ?>
              </div>
          <?php endforeach; ?>
        </div><!-- /.help-button-content -->
    </div><!-- /.help-button-block -->
<?php endif; ?>
<?php print theme('survey_modal');?>

