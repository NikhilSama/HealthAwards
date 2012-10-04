<div id='pagination' >
<?php
    $leftArrow = '&laquo';  //$this->Html->image("blue_arrow2_prev.gif", Array('height'=>7,'width'=>20,'border'=>0));
    $rightArrow = '&raquo'; // $this->Html->image("blue_arrow1.gif", Array('height'=>7,'width'=>20,'border'=>0));

    $prev = $this->Paginator->prev($leftArrow,array('escape'=>false));
    $prev = $prev?$prev:$leftArrow;
    $next = $this->Paginator->next($rightArrow,array('escape'=>false));
    $next = $next?$next:$rightArrow;

    $pages = $this->Paginator->numbers(array('separator'=>" | "));
	if($pages){ 

		//$counterVar= $this->Paginator->counter(array('format' => 'Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%'));
		
		$count1= $this->Paginator->counter(array('format' => '%page%'));
		$count2= $this->Paginator->counter(array('format' => '%current%'));

		if($count1>1){
			$page = (($count1-1) *$count2)+1;
			$current = ($count1 *$count2);
			$counterVar= $this->Paginator->counter(array('format' => 'Page '.$page.' - '.$current.' of %count%'));
		}else{
			$counterVar= $this->Paginator->counter(array('format' => 'Page %page% - %current% of %count%'));
		}
?>
	<table cellpadding="3" cellspacing="0" border="0" width="100%">
		<!--<tr><td align="left"><b>Results: <?php  echo $counterVar; ?></b></td></tr>-->
		<tr>
			<td align="left"><b>Results: <?php  echo $counterVar; ?></b></td>
			<td align="center">
			<?php 
				if(isset($testlist)) {
					$links= $this->Paginator->resultsPerPage(array('url'=>$testlist)); 
				}elseif(isset($pagingQueryStr)) {
					$links= $this->Paginator->resultsPerPage(array('url'=>$pagingQueryStr)); 
				}else 
				{
					$links= $this->Paginator->resultsPerPage(array()); 
				}
                if($links !="")
					echo "<b>Result Per Page:</b> ". $links;
			?>
	</td>
	
	<td align="right"><b>Page No:</b> <?php echo $prev." ".$pages." ".$next; ?></td></tr>
	</table>
<?php } ?>
</div>