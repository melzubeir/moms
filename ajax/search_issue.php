<?php
ob_start();
session_start();
$limit = 10;
$adjacent = 3;
include('../includes/connect.php');
$task=$_REQUEST["task"];
extract($_POST);

if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
$actionfunction = $_REQUEST['actionfunction'];
  
   call_user_func($actionfunction,$_REQUEST,$con,$limit,$adjacent);
}
function showData($data,$con,$limit,$adjacent){

  			
		   if(!empty($_REQUEST[task])){
		                $sql = "SELECT *,iss.created  FROM publication_issue iss join publication pub ON iss.id_publication = pub.id_publication where 1";
						$sqls='';
						
						$sqls='';
						
						if($_REQUEST[search_issue_status]=='0' || $_REQUEST[search_issue_status]=='1'){
						
						   $sqls.=" AND active='".$_REQUEST[search_issue_status]."'";
						}
						if(!empty($_REQUEST[search_issue_country])){
						
						   $sqls.=" AND country ='".$_REQUEST[search_issue_country]."'";
						}
						if(!empty($_REQUEST[search_issue_language])){
						
						   $sqls.=" AND language='".$_REQUEST[search_issue_language]."'";
						}
						if(!empty($_REQUEST[search_issue_type])){
						
						   $sqls.=" AND id_publication_type='".$_REQUEST[search_issue_type]."'";
						}
						if(!empty($_REQUEST[search_issue_frequency])){
						
						   $sqls.=" AND id_frequency='".$_REQUEST[search_issue_frequency]."'";
						}
						if(!empty($_REQUEST[search_issue_outlet])){
						
						   $sqls.=" AND pub.name_publication_en ='".$_REQUEST[search_issue_outlet]."'";
						}
						
						
						if(!empty($_REQUEST[issue_from_date]) && !empty($_REQUEST[issue_to_date])){
						
						   if($_REQUEST[search_date_type]=='expected_date'){
						     
							 $sqls.=" AND ".$_REQUEST[search_date_type]." between '".date('Y-m-d',strtotime($_REQUEST[issue_from_date]))."' and '".date('Y-m-d',strtotime($_REQUEST[issue_to_date]))."'";
						   
						   }elseif(!empty($_REQUEST[search_date_type])){
						     
							 $sqls.=" AND iss.".$_REQUEST[search_date_type]." between '".date('Y-m-d',strtotime($_REQUEST[issue_from_date]))."' and '".date('Y-m-d',strtotime($_REQUEST[issue_to_date]))."'";
						   
						   }else
						   if($_REQUEST[issue_from_date] == $_REQUEST[issue_to_date])
						   {
						    $sqls.=" AND issue_date = '".date('Y-m-d',strtotime($_REQUEST[issue_from_date]))."'";
						   }
						   else
						   {
						     $sqls.=" AND issue_date between '".date('Y-m-d',strtotime($_REQUEST[issue_from_date]))."' and '".date('Y-m-d',strtotime($_REQUEST[issue_to_date]))."'";
						   }
						}
						
						
		
		       }

  $page = $data['page'];
   if($page==1){
   $start = 0;  
  }
  else{
  $start = ($page-1)*$limit;
  }
  $sql = "SELECT *,iss.created  FROM publication_issue iss join publication pub ON iss.id_publication = pub.id_publication where 1 $sqls order by iss.created DESC";
  
  $rows  = mysql_query($sql);
  $rows  = mysql_num_rows($rows);
  //$c  = mysql_num_rows($rows);
  
  $sql = "SELECT *,iss.created,iss.id_issue,iss.created_by  FROM publication_issue iss join publication pub ON iss.id_publication = pub.id_publication where 1 $sqls order by iss.created DESC limit $start,$limit";
   //echo $sql;
  $data = mysql_query($sql);
  	   
	   
	  if($_SESSION['moms_uid'] == '1' && $_SESSION['moms_type'] == "super_admin")
	 {
	    $str='<table class="table-fill">
			<thead>
			<tr>
			    <th class="text-left">Issue Date</th>
				<th class="text-left">Name<span style="color:#22b5d4;">NameName</span></th>
				<!--<th class="text-left">Type</th>
				<th class="text-left">Language</th>
				<th class="text-left">Frequency</th>
				<th class="text-left">Country</th>-->
				<th class="text-left">Received Date</th>
				<th class="text-left">Received By</th>
				<th class="text-left">Expected Date</th>			
				<th class="text-left">Scanned Date</th>
				<th class="text-left">Scanned By</th>
				<th class="text-left">Processed Date</th>
				<th class="text-left">Processed By</th>
				<th class="text-center" style="width:85px">Action</th>
			</tr>
			</thead>';
	 
	 }
	 else
	 if($_SESSION['moms_uid'] == '1' && $_SESSION['moms_type'] == "admin")
	 { $str='<table class="table-fill">
			<thead>
			<tr>
			    <th class="text-left">Issue Date</th>
				<th class="text-left">Name<span style="color:#22b5d4;">NameName</span></th>
				<!--<th class="text-left">Type</th>
				<th class="text-left">Language</th>
				<th class="text-left">Frequency</th>
				<th class="text-left">Country</th>-->
				<th class="text-left">Received Date</th>
				<th class="text-left">Received By</th>
				<th class="text-left">Expected Date</th>			
				<th class="text-left">Scanned Date</th>
				<th class="text-left">Scanned By</th>
				<th class="text-left">Processed Date</th>
				<th class="text-left">Processed By</th>
				<th class="text-center" style="width:85px">Action</th>
			</tr>
			</thead>';
	 
	 
	 }
	 if($_SESSION['moms_uid'] == '1')
	 {
	  $str='<table class="table-fill">
			<thead>
			<tr>
			    <th class="text-left">Issue Date</th>
				<th class="text-left">Name<span style="color:#22b5d4;">NameName</span></th>
				<!--<th class="text-left">Type</th>
				<th class="text-left">Language</th>
				<th class="text-left">Frequency</th>
				<th class="text-left">Country</th>-->
				<th class="text-left">Received Date</th>
				<th class="text-left">Received By</th>
				<th class="text-left">Expected Date</th>			
				<th class="text-left">Scanned Date</th>
				<th class="text-left">Scanned By</th>
				<th class="text-left">Processed Date</th>
				<th class="text-left">Processed By</th>
				<th class="text-center" style="width:85px">Action</th>
			</tr>
			</thead>';
	 
	 }
     else
     
	 if($_SESSION['moms_type'] == "super_admin")
	 {
		 $str='<table class="table-fill">
			<thead>
			<tr>
			    <th class="text-left">Issue Date</th>
				<th class="text-left">Name<span style="color:#22b5d4;">NameName</span></th>
				<!--<th class="text-left">Type</th>
				<th class="text-left">Language</th>
				<th class="text-left">Frequency</th>
				<th class="text-left">Country</th>-->
				<th class="text-left">Received Date</th>
				<th class="text-left">Received By</th>
				<th class="text-left">Expected Date</th>			
				<th class="text-left">Scanned Date</th>
				<th class="text-left">Scanned By</th>
				<th class="text-left">Processed Date</th>
				<th class="text-left">Processed By</th>
				<th class="text-center" style="width:85px">Action</th>
			</tr>
			</thead>';
	 }
	 else
	 if($_SESSION['moms_type'] == "admin")
	 {
		 $str='<table class="table-fill">
			<thead>
			<tr>
			    <th class="text-left">Issue Date</th>
				<th class="text-left">Name<span style="color:#22b5d4;">NameName</span></th>
				<!--<th class="text-left">Type</th>
				<th class="text-left">Language</th>
				<th class="text-left">Frequency</th>
				<th class="text-left">Country</th>-->
				<th class="text-left">Received Date</th>
				<th class="text-left">Received By</th>
				<th class="text-left">Expected Date</th>			
				<th class="text-left">Scanned Date</th>
				<th class="text-left">Scanned By</th>
				<th class="text-left">Processed Date</th>
				<th class="text-left">Processed By</th>
			</tr>
			</thead>';
	 
	 }
	   
	   
	   
	   
	   
	   
	   
	  
			
  if(mysql_num_rows($data)>0){
   while( $row = mysql_fetch_array($data)){
               
				$get_name=mysql_fetch_assoc(mysql_query("select * from publication where id_publication=".$row['id_publication']));
				
				
				//Get frequency name
				$frequency=mysql_fetch_assoc(mysql_query("select name_frequency from frequency where id_frequency=".$get_name['id_frequency']));
				
				
				//Get Country details
                $country=mysql_fetch_assoc(mysql_query("select name_country from country where id_country=".$get_name['country']));
				
				//Get Type details
				
				
				$get_type=mysql_fetch_assoc(mysql_query("select name_publication_type_en from publication_type where id_publication_type=".$get_name['id_publication_type']));
				
			      //Get Processed by 
				  if(!empty($row['done_by'])){
				  	$Processed=mysql_fetch_assoc(mysql_query("select username from users where id_users=".$row['done_by']));
				  }
				  
				   //Get Scanned by 
				 
				 $Scanned=mysql_fetch_assoc(mysql_query("select username from users where id_users=".$row['created_by']));
				 
				// echo "select username from users where id_users=".$row['created_by'];
					
       if($get_name['active']=='1')
	   {
          $img = "images/greencircle.png";
       } 
	   else
	   {
	      $img = "images/redcircle.png";
	   }
	   
	   if(!empty($row['expected_date']) && $row['expected_date']!='0000-00-00 00:00:00')
	   {
	    $date_e = date('d-m-Y',strtotime($row['expected_date']));
	   }
	   else
	   {
	    $date_e = 'N/A';
	   }
	   
	    if(!empty($row['received_date']) && $row['received_date']!='0000-00-00 00:00:00')
	   {
	    $date_r = date('d-m-Y',strtotime($row['received_date']));
	   }
	   else
	   {
	    $date_r = 'N/A';
	   }
	   
	   
	    
	    if(!empty($row['received_by']))
	   {
	   
	    $get_uname = mysql_fetch_assoc(mysql_query("select * from users where id_users = '".$row['received_by']."'"));
	   
	    $recd_by = $get_uname['username'];
	   }
	   else
	   {
	    $recd_by = 'N/A';
	   }
	   
	   
	   	   
	    
	    if(!empty($row['created']) && $row['created']!='0000-00-00 00:00:00')
	   {
	    $cr_by = date('d-m-Y',strtotime($row['created']));
	   }
	   else
	   {
	    $cr_by = 'N/A';
	   }
	   
	   
	    if(!empty($Scanned['username']))
	   {
	    $scn_pub = $Scanned['username'];
	   }
	   else
	   {
	    $scn_pub = 'N/A';
	   }
	   
	    if(!empty($row['done_time']) && $row['done_time']!='0000-00-00 00:00:00')
	   {
	    $done_time = date('d-m-Y',strtotime($row['done_time']));
	   }
	   else
	   {
	    $done_time = 'N/A';
	   }
	   
	   
	    if(!empty($Processed['username']))
	   {
	    $pro_pub = $Processed['username'];
	   }
	   else
	   {
	    $pro_pub = 'N/A';
	   }
	   
	   
	      $edit_link = '<a href="add_issue.php?task=edit&id='.$row['id_publication_issue'].'" class="slit"><img src="images/Edit_2.png" width="16" height="15"></a>';
	   
	     
	      $del_link = '<a href="javascript:void(0)" onClick="confirm_delete('.$row['id_publication_issue'].',3)"><img src="images/Delete_2.png" width="16" height="15"></a>';
	   
	   
	   
	 if($_SESSION['moms_uid'] == '1' && $_SESSION['moms_type'] == "super_admin")
	 {
	   $str.='<tr>
	            <td class="text-left" style="text-align:left;padding-left:10px;"><a href="add_issue.php?task=view&id='.$row['id_publication_issue'].'" class="slit">'.$row['issue_date'].'</a></td>
			    <td class="text-left" style="text-align:left;padding-left:10px;">'.$get_name['name_publication_en'].'</td>
				<!--<td class="text-left" style="text-align:left;padding-left:10px;">'.$get_type['name_publication_type_en'].'</td>
				
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$get_name['language'].'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$frequency['name_frequency'].'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$country['name_country'].'</td>-->
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$date_r.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$recd_by.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$date_e.'</td>    
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$cr_by.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$scn_pub.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$done_time.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$pro_pub.'</td>
				<td class="text-left"style="text-align:center">'.$edit_link.'|'.$del_link.'</td>
			</tr>';
	 }
	 else
	 if($_SESSION['moms_uid'] == '1' && $_SESSION['moms_type'] == "admin")
	 {
	 $str.='<tr>
	            <td class="text-left" style="text-align:left;padding-left:10px;"><a href="add_issue.php?task=view&id='.$row['id_publication_issue'].'" class="slit">'.$row['issue_date'].'</a></td>
			    <td class="text-left" style="text-align:left;padding-left:10px;">'.$get_name['name_publication_en'].'</td>
				<!--<td class="text-left" style="text-align:left;padding-left:10px;">'.$get_type['name_publication_type_en'].'</td>
				
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$get_name['language'].'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$frequency['name_frequency'].'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$country['name_country'].'</td>-->
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$date_r.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$recd_by.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$date_e.'</td>    
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$cr_by.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$scn_pub.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$done_time.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$pro_pub.'</td>
				<td class="text-left"style="text-align:center">'.$del_link.'</td>
			</tr>';
	 
	 }
	 else
     if($_SESSION['moms_uid'] == '1')
	 {
	 
	     $str.='<tr>
	            <td class="text-left" style="text-align:left;padding-left:10px;"><a href="add_issue.php?task=view&id='.$row['id_publication_issue'].'" class="slit">'.$row['issue_date'].'</a></td>
			    <td class="text-left" style="text-align:left;padding-left:10px;">'.$get_name['name_publication_en'].'</td>
				<!--<td class="text-left" style="text-align:left;padding-left:10px;">'.$get_type['name_publication_type_en'].'</td>
				
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$get_name['language'].'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$frequency['name_frequency'].'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$country['name_country'].'</td>-->
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$date_r.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$recd_by.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$date_e.'</td>    
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$cr_by.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$scn_pub.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$done_time.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$pro_pub.'</td>
				<td class="text-left"style="text-align:center">'.$del_link.'</td>
			</tr>';
	 
	 }
	 else
	 if($_SESSION['moms_type'] == "super_admin")
	 {
	   $str.='<tr>
	            <td class="text-left" style="text-align:left;padding-left:10px;"><a href="add_issue.php?task=view&id='.$row['id_publication_issue'].'" class="slit">'.$row['issue_date'].'</a></td>
			    <td class="text-left" style="text-align:left;padding-left:10px;">'.$get_name['name_publication_en'].'</td>
				<!--<td class="text-left" style="text-align:left;padding-left:10px;">'.$get_type['name_publication_type_en'].'</td>
				
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$get_name['language'].'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$frequency['name_frequency'].'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$country['name_country'].'</td>-->
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$date_r.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$recd_by.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$date_e.'</td>    
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$cr_by.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$scn_pub.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$done_time.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$pro_pub.'</td>
				<td class="text-left"style="text-align:center">'.$edit_link.'</td>
			</tr>';
	 }
	 else
	 if($_SESSION['moms_type'] == "admin")
	 {
	 
	   $str.='<tr>
	            <td class="text-left" style="text-align:left;padding-left:10px;"><a href="add_issue.php?task=view&id='.$row['id_publication_issue'].'" class="slit">'.$row['issue_date'].'</a></td>
			    <td class="text-left" style="text-align:left;padding-left:10px;">'.$get_name['name_publication_en'].'</td>
				<!--<td class="text-left" style="text-align:left;padding-left:10px;">'.$get_type['name_publication_type_en'].'</td>
				
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$get_name['language'].'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$frequency['name_frequency'].'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$country['name_country'].'</td>-->
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$date_r.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$recd_by.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$date_e.'</td>    
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$cr_by.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$scn_pub.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$done_time.'</td>
				<td class="text-left" style="text-align:left;padding-left:10px;">'.$pro_pub.'</td>
		</tr>';
	 }
	   		?>
			<script type="text/javascript">
			$('.slit').on('click', function ( e ) {
					$.fn.custombox( this, {
					effect: 'slit'
				});
				e.preventDefault();
			});
			</script>
			<?php
   }
   }else{
    $str .= "<tr><td colspan='12'>No Record Found</td></tr>";
   }
   $str.='</table>';
   
echo $str; 
pagination($limit,$adjacent,$rows,$page);  
}
function pagination($limit,$adjacents,$rows,$page){	
 
 if(!empty($_REQUEST['task'])){
    
	
	 $click = $_REQUEST[type];
   
 }
 else
 {
     $click = 'All';
 }
 


	$pagination='';
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$prev_='';
	$first='';
	$lastpage = ceil($rows/$limit);	
	$next_='';
	$last='';
	if($lastpage > 1)
	{	
		
		//previous button
		if ($page > 1) 
			$prev_.= "<a class='page-numbers' onclick=\"issue_search('$prev')\" style='cursor:pointer'>previous</a>";
		else{
			//$pagination.= "<span class=\"disabled\">previous</span>";	
			}
		
		//pages	
		if ($lastpage < 5 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
		$first='';
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"active\"><a>$counter</a></span>";
				else
					$pagination.= "<a class='page-numbers' onclick=\"issue_search('$counter')\" style='cursor:pointer'>$counter</a>";					
			}
			$last='';
		}
		elseif($lastpage > 3 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			$first='';
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"active\"><a>$counter</a></span>";
					else
						$pagination.= "<a class='page-numbers' onclick=\"issue_search('$counter')\" style='cursor:pointer'>$counter</a>";					
				}
			$last.= "<a class='page-numbers'  onclick=\"issue_search('$lastpage')\" style='cursor:pointer'>Last</a>";			
			}
			
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
		       $first.= "<a class='page-numbers' href=\"?page=1\">First</a>";	
			for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"active\"><a>$counter</a></span>";
					else
						$pagination.= "<a class='page-numbers' onclick=\"issue_search('$counter')\" style='cursor:pointer'>$counter</a>";					
				}
				$last.= "<a class='page-numbers'  onclick=\"issue_search('$lastpage')\" style='cursor:pointer'>Last</a>";			
			}
			//close to end; only hide early pages
			else
			{
			    $first.= "<a class='page-numbers' onclick=\"issue_search('1')\" style='cursor:pointer'>First</a>";	
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"active\"><a>$counter</a></span>";
					else
						$pagination.= "<a class='page-numbers' onclick=\"issue_search('$counter')\" style='cursor:pointer'>$counter</a>";					
				}
				$last='';
			}
            
			}
		if ($page < $counter - 1) 
			$next_.= "<a class='page-numbers'  onclick=\"issue_search('$next')\" style='cursor:pointer'>next</a>";
		else{
			//$pagination.= "<span class=\"disabled\">next</span>";
			}
		$pagination = "<div class=\"pagination\">".$first.$prev_.$pagination.$next_.$last;
		//next button
		
		$pagination.= "</div>\n";		
	}

	echo "<br>".$pagination; 
	?> 
	  <div class="row"> 
		  <div class="result_r">Result = <?=$rows?></div>   
	  </div>
	<?php	   
}