<p>
    This analysis contains expression data
    for <?php print $variables['features_count']; ?> features
    across <?php print $variables['biomaterials_count']; ?> biosamples.
</p>

<?php if($variables['file']): ?>
<table class="table table-valign-middle table-sm table-hover">
  <tbody>
  <tr class="no-border">
    <td class="text-muted download-td"><i class="fa fa-file-text-o"></i></td>
    <th>
      Expression Data
      <div>
        <a class="text-sm text-muted font-normal" href="<?php print file_create_url($variables['file']) ?>" target="_blank">
            Download all expression data associated with this analysis
        </a>
      </div>
    </th>
    <td class="text-right"><a target="_blank" href="<?php print file_create_url($variables['file']) ?>" class="btn btn-primary"><i class="fa fa-download"></i></a></td>
  </tr>
  </tbody>
</table>
<?php endif; ?>

<script>
  (function ($) {
    $(function () {
      var message = $('<span />');
      var link = $('#expressionDownloadLink');
      link.after(message);
      link.click(function (e) {
        e.preventDefault();
        var src = $(this).attr('href');
        var iframe = $('<iframe />', {
          src: src,
          width: 1,
          height: 1
        });
        $('body').append(iframe);
        message.html('Generating file. Download will start automatically...');
      });
    });
  })(jQuery);
</script>
