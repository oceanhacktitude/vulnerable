<?php
/***** REQUIRES $start and $total_rows to exist before this page is included *****/

// determine page numbers
$current_page = $start / $per_page + 1;
$last_page = ceil($total_rows / $per_page);

// determine prev, next, and end links
$end = (($start + $per_page) < $total_rows) ? ($start + $per_page) : $total_rows;
$prev_start = $start - $per_page;
$next_start = $start + $per_page;
$last_start = (($last_page - 1) * $per_page);

echo '<div id="showing">Showing ' . ($start + 1) . ' to ' . $end .' of ' . $total_rows . ' records.</div>
      <div id="pagination">';
        
        // previous page links if this is not the first page
        if($prev_start >= 0)
		{
            echo '<a class="bluespace" href="?start=0" title="First page"> << </a> 
                  <a class="bluespace" href="?start=' . $prev_start . '" title="Previous page"> < </a> ';
        }
		else
		{
            echo '<span class="bluespace" title="First page"> << </span> 
                  <span class="bluespace" title="Previous page"> < </span> ';
        }
        
        // how many links you want (works best if odd)
        $link_count = 7;
     
        // determine start number 
        if ($current_page < ceil($link_count/2) or $last_page < $link_count){
            // this current page is near the beginning
            $start_i = 0;
        }else if ($last_page - $current_page < ceil($link_count/2)){
            // this current page is near the end
            $start_i = $last_page - $link_count;
        }else{
            // this current page is in the middle
            $start_i = $current_page - ceil($link_count/2);
        }
        
        // determine end of loop
        $end_i = $start_i + $link_count - 1;
        
        // print links, loop until we've printed $link_count pages OR we reach the last page
        for ($i = $start_i; $i <= $end_i and $i < $last_page; $i++)
		{
            // human version of the page number    
            $page_num = $i + 1;
            
            // the start number for this page
            $page_start = $i * $per_page; 
            
            // only print a link if it's not the current page
            if($page_num != $current_page)
			{
                echo '<a class="bbluespace" href="?start=' . $page_start . '" title="Page ' . $page_num . '">' . $page_num . '</a>';
            }
			else
			{
                echo '<span class="bbluespace">' . $page_num . '</span>';  
            }
            
            // add a separator if it's not the last page
            //if($i < $end_i and $page_num < $last_page){
            //  echo '|';
            //}
        }
        
        // next page links if this isn't the last page
        if($next_start < $total_rows)
		{
			echo '<a class="bluespace" href="?start=' . $next_start . '" title="Next page"> > </a>
				  <a class="bluespace" href="?start=' . $last_start . '" title="Last page"> >> </a> ';
        }
		else
		{
            echo '<span class="bluespace" title="Next page"> > </span> 
                  <span class="bluespace" title="Last page"> >> </span> ';
        }
        
 echo '</div>';
 ?>
