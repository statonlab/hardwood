<?php
/**
 * This Template generates the HTML for a single Alignment row in a BLAST report
 *
 * Variables Available in this template:
 *   $HSPs: an array of HSPs for the current BLAST result. This follows the structure
 *     layed out in the XML file but has been made an array instead of a SimpleXML object
 *     for ease of processing and abstration.
 */
?>

<div class="alignment-row-section hit-visualization" title="Your query sequence is shown at the bottom and the target sequence it aligned to is shown at the top. The shape connecting them indicates how much of the target and query are represented by the hit.">
  <div class="title">Hit Visualization</div>
  <img src="data:image/png;base64,<?php print $hit_visualization;?>"/>
  <p>The image above shows the relationship between query and target for this 
    particular BLAST hit.</p>
</div>
<div class="alignment-row-section alignment">
  <div class="title">Alignment</div>

  <?php
    foreach($HSPs as $hsp) {
  ?>

    <div class="hsp-title">HSP <?php print $hsp['Hsp_num']?></div>
    <div class="alignment-metrics">
      <span class="identity">
        Identity=&nbsp;
        <?php print $hsp['Hsp_identity']; ?>/<?php print $hsp['Hsp_align-len']; ?> (<?php print round($hsp['Hsp_identity']/$hsp['Hsp_align-len']*100, 2, PHP_ROUND_HALF_EVEN);?>%)
      </span>,&nbsp;
      <span class="positive">
        Positive=&nbsp;
        <?php print $hsp['Hsp_positive']; ?>/<?php print $hsp['Hsp_align-len']; ?> (<?php print round($hsp['Hsp_positive']/$hsp['Hsp_align-len']*100, 2, PHP_ROUND_HALF_EVEN);?>%)
      </span>
      <span class="coord-summary">
        Query Matches <?php print $hsp['Hsp_query-from'] . ' to ' . $hsp['Hsp_query-to']; ?>
        Hit Matches = <?php print $hsp['Hsp_hit-from'] . ' to ' . $hsp['Hsp_hit-to']; ?>
      </span>
    </div>
    <div class="alignment">
      <div class="alignment-row">
        <?php 
        // We want to display the alignment with a max 60 residues per line with line numbers indicated.
        // First break up the strings.
        $query = str_split($hsp['Hsp_qseq'], 60);
        $matches = str_split($hsp['Hsp_midline'], 60);
        $hit = str_split($hsp['Hsp_hseq'], 60);
        // determine the max length of the coordinate string to use when padding.
        $coord_length = strlen($hsp['Hsp_hit-from']) + 3;
        $coord_length = (strlen($hsp['Hsp_query-to']) + 3 > $coord_length) ? strlen($hsp['Hsp_query-to']) + 3 : $coord_length;

        // Now foreach chink determined above...
        foreach (array_keys($query) as $k) {
          // Determine the current coordinates.
          $coord['qstart'] = $hsp['Hsp_query-from'] + ($k * 60);
          $coord['qstart'] = ($k == 0) ? $coord['qstart'] : $coord['qstart'];
        
          // code added to fix the range issue
          // Cordinates can increase or decrease
          if($hsp['Hsp_hit-from'] < $hsp['Hsp_hit-to']) {
              $coord['hstart'] = $hsp['Hsp_hit-from'] + ($k * 60);    
            }
            else {
              $coord['hstart'] = $hsp['Hsp_hit-from'] - ($k * 60);
            }
            $coord['qstop'] = $hsp['Hsp_query-from'] + (($k + 1) * 60) - 1;
            $coord['qstop'] = ($coord['qstop'] > $hsp['Hsp_query-to']) ? $hsp['Hsp_query-to'] : $coord['qstop'];
      
            if ($hsp['Hsp_hit-from'] < $hsp['Hsp_hit-to']) {
              $coord['hstop'] = $hsp['Hsp_hit-from'] + (($k + 1) * 60) - 1;
              $coord['hstop'] = ($coord['hstop'] > $hsp['Hsp_hit-to']) ? $hsp['Hsp_hit-to'] : $coord['hstop'];
          
            }
            else {
              $coord['hstop'] = $hsp['Hsp_hit-from'] - (($k + 1) * 60) + 1;
              $coord['hstop'] = ($coord['hstop'] < $hsp['Hsp_hit-to']) ? $hsp['Hsp_hit-to'] : $coord['hstop'];
            }
          
            // Pad these coordinates to ensure columned display.
            foreach ($coord as $ck => $val) {
              $pad_type = (preg_match('/start/', $ck)) ? STR_PAD_LEFT : STR_PAD_RIGHT;
              $coord[$ck] = str_pad($val, $coord_length, '#', $pad_type);
              $coord[$ck] =  str_replace('#', '&nbsp', $coord[$ck]);
            }
        ?>
          <div class="alignment-subrow">
            <div class="query">
              <span class="alignment-title">Query:</span>&nbsp;&nbsp;
              <span class="alignment-start-coord"><?php print $coord['qstart']; ?></span>
              <span class="alignment-residues"><?php print $query[$k]; ?></span>
              <span class="alignment-stop-coord"><?php print $coord['qstop']; ?></span>
            </div>
            <div class="matches">
              <?php print  str_repeat('&nbsp;', 8); ?>
              <?php print str_repeat('&nbsp;', $coord_length); ?>
              <span class="alignment-residues"><?php print str_replace(' ', '&nbsp', $matches[$k]); ?></span>
            </div>
            <div class="hit">
              <span class="alignment-title">Sbjct:</span>&nbsp;&nbsp;
              <span class="alignment-start-coord"><?php print $coord['hstart']; ?></span>
              <span class="alignment-residues"><?php print $hit[$k]; ?></span>
              <span class="alignment-stop-coord"><?php print $coord['hstop']; ?></span>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>

  <?php
    }
  ?>
</div>