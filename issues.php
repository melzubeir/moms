<?php
ob_start();
session_start();
 
include('includes/connect.php');
include('includes/conf.php');
include('includes/head.php');
include('includes/functions.php');
if(empty($_SESSION['moms_uname'])){
	$_SESSION['msg']='login';
	header('Location:login.php');	
}
//Get Country details
$country=mysql_query("select * from country");
//Get Language details
$languages=mysql_query("select * from tbl_languages Order BY name ASC");



extract($_POST);
if(isset($_POST['submit']))
{


		if(($_FILES['logo']['name'])!="")
		{
			$add_file=$_FILES['logo']['name'];
			$name = time()."@".$add_file;
			$logo="momslogo/print/".$name;
			
			move_uploaded_file($_FILES["logo"]["tmp_name"],$logo);
		}
		if(($_FILES['rate_sheet']['name'])!="")
		{
			$add_file=$_FILES['rate_sheet']['name'];
			$name = time()."@".$add_file;
			$rate_sheet="ratesheet/".$name;
			
			move_uploaded_file($_FILES["rate_sheet"]["tmp_name"],$rate_sheet);
		}


$ins_user=mysql_query("INSERT INTO tbl_print_media(`status`,`mediaOutlet`,`type`,`id_frequency`,`id_country`,`language_id`,`id_publication_genre`,`logo`,`id_publisher`,`del_method`,`circulation`,`ad_rate`,`rate_sheet`,`url`,`phone`,`email`,`created_date`,`modified_date`,`frequency_date`) VALUES ('".$status."','".$mediaOutlet."','".$type."','".$id_frequency."','".$id_country."','".$language_id."','".$id_publication_genre."','".$logo."','".$id_publisher."','".$del_method."','".$circulation."','".$ad_rate."','".$rate_sheet."','".$url."','".$phone."','".$email."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','".$frequency_date."')");	




		if($ins_user)
		{
			$_SESSION['msg'] = "ins_succ";
			header("location:index.php");
		}
}

if(isset($_POST["update"]))
{
    extract($_POST);
	
	$Printmedia=mysql_query("select logo,rate_sheet from tbl_print_media where id=".$id);
	$getMedia=mysql_fetch_assoc($Printmedia);
	
	if(($_FILES['logo']['name'])!="")
		{
			$add_file=$_FILES['logo']['name'];
			$name = time()."@".$add_file;
			$logo="momslogo/print/".$name;
			unset($getMedia['logo']);
			
			move_uploaded_file($_FILES["logo"]["tmp_name"],$logo);
	}else{
	         $logo=$getMedia['logo'];
	
	}
	if(($_FILES['rate_sheet']['name'])!="")
	{
			$add_file=$_FILES['rate_sheet']['name'];
			$name = time()."@".$add_file;
			$rate_sheet="ratesheet/".$name;
			unset($getMedia['rate_sheet']);
			move_uploaded_file($_FILES["rate_sheet"]["tmp_name"],$rate_sheet);
	}else{
	         $rate_sheet=$getMedia['rate_sheet'];
	}
	
							
	$sql_update = mysql_query("UPDATE tbl_print_media  SET  `status` = '".$status."',`mediaOutlet` = '".$mediaOutlet."', `type` = '".$type."',`id_frequency` = '".$id_frequency."',`id_country` = '".$id_country."', `language_id` = '".$language_id."',`id_publication_genre` = '".$id_publication_genre."',`logo` = '".$logo."', `id_publisher` = '".$id_publisher."',`del_method` = '".$del_method."',`ad_rate` = '".$ad_rate."', `rate_sheet` = '".$rate_sheet."',`url` = '".$url."',`phone` = '".$phone."',`email` = '".$email."',`modified_date` = '".date('Y-m-d H:i:s')."' WHERE `id`='".$_POST['id']."'");
	
	
	
	 $_SESSION['msg']='upd_succ';
	 header("location:index.php");   
}

if($_REQUEST['task']=='delete')
{

     $Printmedia=mysql_fetch_assoc(mysql_query("select logo,rate_sheet from tbl_print_media where id=".$_REQUEST['id']));
	 
	 unset($Printmedia['logo']);
	 unset($Printmedia['rate']);
	
	
	 $sql_update = mysql_query("delete from tbl_print_media WHERE `id`='".$_REQUEST['id']."'");
	 
	 $_SESSION['msg']='del_succ';
	 header("location:index.php");  
}


if(isset($_POST['digital_submit']))
{


		if(($_FILES['logo']['name'])!="")
		{
			$add_file=$_FILES['logo']['name'];
			$name = time()."@".$add_file;
			$logo="momslogo/digital/".$name;
			
			move_uploaded_file($_FILES["logo"]["tmp_name"],$logo);
		}
		
$ins_user=mysql_query("INSERT INTO tbl_digital_media(`status`,`mediaOutlet`,`type`,`id_country`,`language_id`,`id_publication_genre`,`logo`,`id_publisher`,`subscription`,`hits`,`source_rank`,`url`,`phone`,`email`,`created_date`,`modified_date`) VALUES ('".$status."','".$mediaOutlet."','".$type."','".$id_country."','".$language_id."','".$id_publication_genre."','".$logo."','".$id_publisher."','".$subscription."','".$hits."','".$source_rank."','".$url."','".$phone."','".$email."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')");	




		if($ins_user)
		{
			$_SESSION['msg'] = "ins_succ";
			header("location:index.php");
		}
}

if(isset($_POST["digital_update"]))
{
    extract($_POST);
	
	$Printmedia=mysql_query("select logo from tbl_digital_media where id=".$id);
	$getMedia=mysql_fetch_assoc($Printmedia);
	
	if(($_FILES['logo']['name'])!="")
		{
			$add_file=$_FILES['logo']['name'];
			$name = time()."@".$add_file;
			$logo="momslogo/digital/".$name;
			unset($getMedia['logo']);
			
			move_uploaded_file($_FILES["logo"]["tmp_name"],$logo);
	}else{
	         $logo=$getMedia['logo'];
	
	}
	
	
							
	$sql_update = mysql_query("UPDATE tbl_digital_media  SET  `status` = '".$status."',`mediaOutlet` = '".$mediaOutlet."', `type` = '".$type."',`id_country` = '".$id_country."', `language_id` = '".$language_id."',`id_publication_genre` = '".$id_publication_genre."',`subscription` = '".$subscription."',`hits` = '".$hits."',`source_rank` = '".$source_rank."',`logo` = '".$logo."', `id_publisher` = '".$id_publisher."',`url` = '".$url."',`phone` = '".$phone."',`email` = '".$email."',`modified_date` = '".date('Y-m-d H:i:s')."' WHERE `id`='".$_POST['id']."'");
	
	 $_SESSION['msg']='upd_succ';
	 header("location:index.php");   
}
if($_REQUEST['task']=='digital_delete')
{

     $Digitalmedia=mysql_fetch_assoc(mysql_query("select logo from tbl_digital_media where id=".$_REQUEST['id']));
	 
	 unset($Digitalmedia['logo']);


	 $sql_update = mysql_query("delete from tbl_digital_media WHERE `id`='".$_REQUEST['id']."'");
	 
	 $_SESSION['msg']='del_succ';
	 header("location:index.php");  
}




if(isset($_POST['broad_submit']))
{


		if(($_FILES['logo']['name'])!="")
		{
			$add_file=$_FILES['logo']['name'];
			$name = time()."@".$add_file;
			$logo="momslogo/broad/".$name;
			
			move_uploaded_file($_FILES["logo"]["tmp_name"],$logo);
		}
		
$ins_user=mysql_query("INSERT INTO tbl_broad_media(`status`,`mediaOutlet`,`type`,`id_country`,`language_id`,`id_publication_genre`,`logo`,`owner`,`rate`,`url`,`phone`,`email`,`created_date`,`modified_date`) VALUES ('".$status."','".$mediaOutlet."','".$type."','".$id_country."','".$language_id."','".$id_publication_genre."','".$logo."','".$owner."','".$rate."','".$url."','".$phone."','".$email."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')");	




		if($ins_user)
		{
			$_SESSION['msg']='ins_succ';
			header("location:index.php");
		}
}

if(isset($_POST["broad_update"]))
{
    extract($_POST);
	
	$Printmedia=mysql_query("select logo from tbl_digital_media where id=".$id);
	$getMedia=mysql_fetch_assoc($Printmedia);
	
	if(($_FILES['logo']['name'])!="")
		{
			$add_file=$_FILES['logo']['name'];
			$name = time()."@".$add_file;
			$logo="momslogo/broad/".$name;
			unset($getMedia['logo']);
			
			move_uploaded_file($_FILES["logo"]["tmp_name"],$logo);
	}else{
	         $logo=$getMedia['logo'];
	
	}
	
	
							
	$sql_update = mysql_query("UPDATE tbl_digital_media  SET  `status` = '".$status."',`mediaOutlet` = '".$mediaOutlet."', `type` = '".$type."',`id_country` = '".$id_country."', `language_id` = '".$language_id."',`id_publication_genre` = '".$id_publication_genre."'`logo` = '".$logo."', `owner` = '".$owner."',, `rate` = '".$rate."'`url` = '".$url."',`phone` = '".$phone."',`email` = '".$email."',`modified_date` = '".date('Y-m-d H:i:s')."' WHERE `id`='".$_POST['id']."'");
	
	 $_SESSION['msg']='upd_succ';
	 header("location:index.php");   
}


if($_REQUEST['task']=='broad_delete')
{
     $Broadmedia=mysql_fetch_assoc(mysql_query("select logo from tbl_broad_media where id=".$_REQUEST['id']));
	 
	 unset($Broadmedia['logo']);

	 $sql_update = mysql_query("delete from tbl_broad_media WHERE `id`='".$_REQUEST['id']."'");
	 
	 $_SESSION['msg']='del_succ';
	 header("location:index.php");  
}
?>




<script type="text/javascript">
function validation(){

 if($('#status').val().trim() == "")
  {
     alert("Please Select Status");
	 $('#status').focus();
	 return false;
  }
  
  if($('#mediaOutlet').val().trim() == "")
  {
     alert("Please Select Media Outlet");
	 $('#mediaOutlet').focus();
	 return false;
  }
  
  if($('#type').val().trim() == "")
  {
     alert("Please Select Type.");
	 $('#type').focus();
	 return false;
  }
  if($('#id_frequency').val().trim() == "")
  {
     alert("Please Select Frequency.");
	 $('#id_frequency').focus();
	 return false;
  }
  if($('#id_country').val().trim() == "")
  {
     alert("Please Select Country.");
	 $('#id_country').focus();
	 return false;
  }
  if($('#language_id').val().trim() == "")
  {
     alert("Please Select Language.");
	 $('#language_id').focus();
	 return false;
  }
  if($('#id_publication_genre').val().trim() == "")
  {
     alert("Please Select Media Outlet Genre.");
	 $('#id_publication_genre').focus();
	 return false;
  }
  if($('#id_publisher').val().trim() == "")
  {
     alert("Please Enter Publisher.");
	 $('#id_publisher').focus();
	 return false;
  }
  if($('#del_method').val().trim() == "")
  {
     alert("Please Select Delivery Method.");
	 $('#del_method').focus();
	 return false;
  }
  if($('#circulation').val().trim() == "")
  {
     alert("Please Enter Circulation.");
	 $('#circulation').focus();
	 return false;
  }
  if($('#ad_rate').val().trim() == "")
  {
     alert("Please Enter Rate.");
	 $('#language_id').focus();
	 return false;
  }
  var url = document.getElementById("url").value;
      
  if(url != "")
  {
        var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
       
        if (!pattern.test(url)) {
            alert("Please enter valid website url");
            document.getElementById("url").focus();
            document.getElementById("url").value ='';
            return false;
        }
  }    
  if($('#phone').val().trim() == "")
  {
     alert("Please Enter Phone No.");
	 $('#phone').focus();
	 return false;
  }
  if($('#email').val().trim() == "")
  {
     alert("Please Enter Email");
	 $('#email').focus();
	 return false;
  }
  else if(validEmail($('#email').val().trim()) == false)
  {
	  alert("Please enter Valid email address.");
      $('#email').focus();
      return false;
  }
  

}
function digital_validation(){

 if($('#dig_status').val().trim() == "")
  {
     alert("Please Select Status");
	 $('#dig_status').focus();
	 return false;
  }
  
  if($('#dig_mediaOutlet').val().trim() == "")
  {
     alert("Please Select Media Outlet");
	 $('#dig_mediaOutlet').focus();
	 return false;
  }
  
  if($('#dig_type').val().trim() == "")
  {
     alert("Please Select Type.");
	 $('#dig_type').focus();
	 return false;
  }
  if($('#dig_id_country').val().trim() == "")
  {
     alert("Please Select Country.");
	 $('#dig_id_country').focus();
	 return false;
  }
  if($('#dig_language_id').val().trim() == "")
  {
     alert("Please Select Language.");
	 $('#dig_language_id').focus();
	 return false;
  }
  if($('#dig_id_publication_genre').val().trim() == "")
  {
     alert("Please Select Media Outlet Genre.");
	 $('#dig_id_publication_genre').focus();
	 return false;
  }
  
  if($('#dig_source_rank').val().trim() == "")
  {
     alert("Please Select Source Rank.");
	 $('#dig_source_rank').focus();
	 return false;
  }
  if($('#dig_subscription').val().trim() == "")
  {
     alert("Please Select Subscription.");
	 $('#dig_subscription').focus();
	 return false;
  }
  if($('#dig_id_publisher').val().trim() == "")
  {
     alert("Please Enter Publisher.");
	 $('#dig_id_publisher').focus();
	 return false;
  }
  if($('#dig_hits').val().trim() == "")
  {
     alert("Please Enter Hits/Month.");
	 $('#dig_hits').focus();
	 return false;
  }
  var url = document.getElementById("dig_url").value;
      
  if(url != "")
  {
        var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
       
        if (!pattern.test(url)) {
            alert("Please enter valid website url");
            document.getElementById("dig_url").focus();
            document.getElementById("dig_url").value ='';
            return false;
        }
  }    
  if($('#dig_phone').val().trim() == "")
  {
     alert("Please Enter Phone No.");
	 $('#dig_phone').focus();
	 return false;
  }
  if($('#dig_email').val().trim() == "")
  {
     alert("Please Enter Email");
	 $('#dig_email').focus();
	 return false;
  }
  else if(validEmail($('#dig_email').val().trim()) == false)
  {
	  alert("Please enter Valid email address.");
      $('#dig_email').focus();
      return false;
  }
  

}
function broad_validation(){

 if($('#broad_status').val().trim() == "")
  {
     alert("Please Select Status");
	 $('#broad_status').focus();
	 return false;
  }
  
  if($('#broad_mediaOutlet').val().trim() == "")
  {
     alert("Please Select Media Outlet");
	 $('#broad_mediaOutlet').focus();
	 return false;
  }
  
  if($('#broad_type').val().trim() == "")
  {
     alert("Please Select Type.");
	 $('#broad_type').focus();
	 return false;
  }
  if($('#broad_id_country').val().trim() == "")
  {
     alert("Please Select Country.");
	 $('#broad_id_country').focus();
	 return false;
  }
  if($('#broad_language_id').val().trim() == "")
  {
     alert("Please Select Language.");
	 $('#broad_language_id').focus();
	 return false;
  }
  if($('#broad_id_publication_genre').val().trim() == "")
  {
     alert("Please Select Media Outlet Genre.");
	 $('#broad_id_publication_genre').focus();
	 return false;
  }
  if($('#owner').val().trim() == "")
  {
     alert("Please Enter Owner Name.");
	 $('#owner').focus();
	 return false;
  }
  if($('#broad_rate').val().trim() == "")
  {
     alert("Please Enter Rate.");
	 $('#broad_rate').focus();
	 return false;
  }
  var url = document.getElementById("broad_url").value;
      
  if(url != "")
  {
        var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
       
        if (!pattern.test(url)) {
            alert("Please enter valid website url");
            document.getElementById("broad_url").focus();
            document.getElementById("broad_url").value ='';
            return false;
        }
  }    
  if($('#broad_phone').val().trim() == "")
  {
     alert("Please Enter Phone No.");
	 $('#broad_phone').focus();
	 return false;
  }
  if($('#broad_email').val().trim() == "")
  {
     alert("Please Enter Email");
	 $('#broad_email').focus();
	 return false;
  }
  else if(validEmail($('#broad_email').val().trim()) == false)
  {
	  alert("Please enter Valid email address.");
      $('#broad_email').focus();
      return false;
  }
  

}
function confirm_delete(Id,task)
{
    var conf = confirm("Are you sure, want to delete record?");
	if(conf == true)
	{
		window.location.href = 'index.php?id='+Id+'&task='+task;
	}
}
</script>

<!--Date picker starts here-->
<!--<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>-->
<link rel='stylesheet prefetch' href='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css'>
<script src='http://codepen.io/assets/libs/fullpage/jquery.js'></script>
  <script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script><script src='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js'></script>
<script type="text/javascript">
var $j = jQuery.noConflict();
$j(function () {
  $j("#datepicker").datepicker({ 
        autoclose: true, 
        todayHighlight: true
  });
});
$j(function () {
  $j("#datepicker2").datepicker({ 
        autoclose: true, 
        todayHighlight: true
  });
});
</script>  
<!--Date picker end here-->

<?php /*?>function getFrequency(getval){
   if(getval=='10'){
   $("#freq_date").html("<select name='frequency_date'><option value='Sunday'>Sunday</option><option value='Monday'>Monday</option><option value='Tuesday'>Tuesday</option><option value='Wednesday'>Wednesday</option><option value='Thursday'>Thursday</option><option value='Friday'>Friday</option><option value='Saturday'>Saturday</option></select>");
   }
   else if(getval=='12'){
   
   $("#freq_date").html("<select name='frequency_date'><option value='01'>January</option>
<option value='02'>February</option>
<option value='03'>March</option>
<option value='04'>April</option>
<option value='05'>May</option>
<option value='06'>June</option>
<option value='07'>July</option>
<option value='08'>August</option>
<option value='09'>September</option>
<option value='10'>October</option>
<option value='11'>November</option>
<option value='12'>December</option>
</select>");
   
   }
    
}<?php */?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
function filter_type(getValue) {
	

		var datasrch="type="+getValue;
			$.ajax({
				url: 'ajax/print_media.php',
				type: 'POST',
				data: datasrch,
				cache:false,
				success:function(html){
				
					$("#getContent").html(html);
				}
			});
}
function digital_filter_type(getValue) {
	

		var datasrch="type="+getValue;
			$.ajax({
				url: 'ajax/digital_media.php',
				type: 'POST',
				data: datasrch,
				cache:false,
				success:function(html){
				
					$("#getdigitalContent").html(html);
				}
			});
}
function broad_filter_type(getValue) {
	

		var datasrch="type="+getValue;
			$.ajax({
				url: 'ajax/broad_media.php',
				type: 'POST',
				data: datasrch,
				cache:false,
				success:function(html){
				
					$("#getbroadContent").html(html);
				}
			});
}
</script>

<body>
    <div class="bg-overlay"></div>

    <div class="container-fluid">
        <div class="row">
            
           <?php include('includes/side_bar.php'); ?>
            <div class="col-md-8 col-sm-12" style="padding:0;">
                
                <div id="menu-container">

                    <div id="menu-1" class="about content">
                        <div class="row">
                          <div class="cd-tabs">
	<nav>
		<ul class="cd-tabs-navigation">
			<li><a data-content="store1" href="#0">Print Media</a></li>
			<li><a data-content="store2" href="#0">Digital Media</a></li>
			<li><a data-content="store3" href="#0">Broadcast Media</a></li>
			
		</ul> <!-- cd-tabs-navigation -->
	</nav>

	<ul class="cd-tabs-content" style="background:#fff;">
	    
		<!--Print Media Starts Here-->
		<?    
		    extract($_POST);
		    if(!empty($_POST['search'])){
		                $sql = "SELECT * FROM tbl_print_media where 1";
						$sqls='';
						if(!empty($search_status)){
						
						   $sqls.=" AND status='".$search_status."'";
						}
						if(!empty($search_country)){
						
						   $sqls.=" AND id_country ='".$search_country."'";
						}
						if(!empty($search_language)){
						
						   $sqls.=" AND language_id='".$search_language."'";
						}
						if(!empty($search_type)){
						
						   $sqls.=" AND type='".$search_type."'";
						}
						if(!empty($search_frequency)){
						
						   $sqls.=" AND id_frequency='".$search_frequency."'";
						}
						if(!empty($search_outlet)){
						
						   $sqls.=" AND mediaOutlet ='".$search_outlet."'";
						}
						if(!empty($from_date) && !empty($to_date)){
						
						   $sqls.=" AND created_date between ".$from_date." and ".$to_date."";
						}
			           
						$sql_count = mysql_fetch_assoc(mysql_query("SELECT count(*) as total FROM tbl_print_media where 1 $sqls"));
						$sql= $sql.$sqls;	
		
		       }else{
			
						$sql = "SELECT * FROM tbl_print_media";
			            
						$sql_count = mysql_fetch_assoc(mysql_query("SELECT count(*) as total FROM tbl_print_media"));
			   }
					
			
				$result = mysql_query($sql) or die(mysql_error());
		   ?> 
		
		
		<li data-content="store1">
		<? include('messages.php')?>
		
			<p>
            <div class="row">
            <form action="index.php" method="post">
             <fieldset class="col-md-6">
              <select name="search_status">
			      <option>Status</option>
			  	  <option value="A">Active</option>
			  	  <option value="I">Inactive</option>
			  </select>
              </fieldset>
              <fieldset class="col-md-6">
			  
              <select name="search_country">
			  <option value="">Country</option>
			     <?php while($getCountry=mysql_fetch_assoc($country)){?>
					<option value="<?=$getCountry['id_country']?>"><?=$getCountry['name_country']?></option>
					<?php }?>
			  
			  </select>
              </fieldset>
              
               <fieldset class="col-md-6">
			   
                <select  name="search_language">
				    <option value="">Language</option>
				    <?php while($getLanguages=mysql_fetch_assoc($languages)){?>
					<option value="<?=$getLanguages['id']?>"><?=$getLanguages['name']?></option>
					<?php }?>
				</select>
                </fieldset>
                <fieldset class="col-md-6">
                <select name="search_type">
					<option value="">Type</option>
					<option value="">All</option>
					<option value="Magazines">Magazines</option>
					<option value="Newspaper">Newspaper</option>
				</select>
                </fieldset>
                                            
                <fieldset class="col-md-6">
				<?php
				$frequency=mysql_query("select * from frequency");
				?>
                 <select name="search_frequency">
				 	<option value="">Frequency</option>
					<?php while($getFrequency=mysql_fetch_assoc($frequency)){?>
					<option value="<?=$getFrequency['id_frequency']?>"><?=$getFrequency['name_frequency']?></option>
					<?php }?>
					
				 </select>
                 </fieldset>
                <fieldset class="col-md-6">
				<?php
				$outlet=mysql_query("select id,mediaOutlet from tbl_print_media");
				?>
                <select name="search_outlet">
				    <option value="">Media Outlet Name</option>
				    <?php while($getOutlet=mysql_fetch_assoc($outlet)){?>
					<option value="<?=$getOutlet['id']?>"><?=$getOutlet['mediaOutlet']?></option>
					<?php }?>	
				</select>
                </fieldset>
				
				
			   
                                            
                <fieldset class="col-md-6">
                <div id="datepicker" style="width:160px; float:left" class="input-group date" data-date-format="mm-dd-yy">
    <input class="form-control" type="text" name="from_date" placeholder="From Date" readonly />
    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			   </div>
			   <div id="datepicker2"  style="width:160px; float:left; padding-left:10px;" class="input-group date" data-date-format="mm-dd-yy">
    <input class="form-control" type="text" name="to_date"  placeholder="To Date" readonly />
    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			   </div>
               </fieldset>
			  			   
			                                
                 <fieldset class="col-md-4">
                 <input type="submit" name="search" value="Search" id="submit" class="button">
                  </fieldset>
                  </form>
              </div>
             
                   
          <div class="row" style="overflow:auto;" id="getContent">
		  <div class="add_left"><a href="add_print_media.php" class="fadein">Add Media Outlet</a></div>
           <div class="result_r">Result = <?=$sql_count['total']?></div>
		  
          <table class="table-fill">
			<thead>
			<tr>
				<th class="text-left">Name</th>
				<th class="text-left">Type</th>
				<th class="text-left">Frequency</th>
				<th class="text-left">Country</th>
				<th class="text-left">Status</th>
				<th class="text-left">Action</th>
			</tr>
			</thead>
			<tbody class="table-hover">
			<?   
	
        if(mysql_num_rows($result)>0){
		while($row = mysql_fetch_assoc($result))

		{ 	    //Get frequency name
				$frequency=mysql_fetch_assoc(mysql_query("select name_frequency from frequency where id_frequency=".$row['id_frequency']));
				//Get Country details
                $country=mysql_fetch_assoc(mysql_query("select name_country from country where id_country=".$row['country_id']))
			
			?>
			<tr>
				<td class="text-left"><?=$row['mediaOutlet']?></td>
				<td class="text-left"><?=$row['type']?></td>
				<td class="text-left"><?=$frequency['name_frequency']?></td>
				<td class="text-left"><?=$country['name_country']?></td>
				<td class="text-left"><?=($row['status']=='A')?'Active':'Inactive'?></td>
				<td class="text-left">
				<?php if($_SESSION['moms_type']=='super_admin'){?> 
				<a href="add_print_media.php?task=edit&id=<?=$row['id']?>" class="slit">Edit</a> | <?php }?>
				<a href="add_print_media.php?task=view&id=<?=$row['id']?>" class="slit">View</a>
				<?php if($_SESSION['moms_type']=='super_admin'){?>
				 | <a href="javascript:void(0)" onClick="confirm_delete('<?=$row['id']?>','delete')">Delete</a>
				 <?php }?>
				 </td>
			</tr>
			<script type="text/javascript">
			$('.slit').on('click', function ( e ) {
					$.fn.custombox( this, {
					effect: 'slit'
				});
				e.preventDefault();
			});
			</script>
			
			<?php $i++;}}else{ echo '<tr><td colspan="6">No Record Found</td></tr>';}

		?>
         
</tbody>
</table>







          </div>                           
                     
           <div class="row">
           <div class="add_left" onClick="filter_type('Magazines')">Magazines</div>
           <div class="add_left" onClick="filter_type('Newspapers')">Newspapers</div>
		   <div class="add_left" onClick="filter_type('All')">All</div>
           </div>           
                                    
         </p>
		</li>
		<!--Print Media End Here-->
		
		
		
		
		<!--Digital Media Starts Here-->
		<?    
		    extract($_POST);
		    if(!empty($_POST['digital_search'])){
		                $sql = "SELECT * FROM tbl_digital_media where 1";
						$sqls='';
						if(!empty($search_digit_status)){
						
						   $sqls.=" AND status='".$search_digit_status."'";
						}
						if(!empty($search_digit_country)){
						
						   $sqls.=" AND id_country ='".$search_digit_country."'";
						}
						if(!empty($search_digit_language)){
						
						   $sqls.=" AND language_id='".$search_digit_language."'";
						}
						if(!empty($search_digit_type)){
						
						   $sqls.=" AND type='".$search_digit_type."'";
						}
						if(!empty($search_digit_outlet)){
						
						   $sqls.=" AND mediaOutlet ='".$search_digit_outlet."'";
						}
						
			           
						$sql_count = mysql_fetch_assoc(mysql_query("SELECT count(*) as total FROM tbl_digital_media where 1 $sqls"));
						$sql= $sql.$sqls;	
		
		       }else{
			
						$sql = "SELECT * FROM tbl_digital_media";
			            
						$sql_count = mysql_fetch_assoc(mysql_query("SELECT count(*) as total FROM tbl_digital_media"));
			   }
					
			
				$result = mysql_query($sql) or die(mysql_error());
		   ?> 
		
		
		<li data-content="store2">
		<? include('messages.php')?>
		
			<p>
            <div class="row">
            <form action="index.php" method="post">
             <fieldset class="col-md-6">
              <select name="search_digit_status">
			      <option>Status</option>
			  	  <option value="A">Active</option>
			  	  <option value="I">Inactive</option>
			  </select>
              </fieldset>
              <fieldset class="col-md-6">
			  
              <select name="search_digit_country">
			  <option value="">Country</option>
			     <?php while($getCountry=mysql_fetch_assoc($country)){?>
					<option value="<?=$getCountry['id_country']?>"><?=$getCountry['name_country']?></option>
					<?php }?>
			  
			  </select>
              </fieldset>
              
               <fieldset class="col-md-6">
			   
                <select  name="search_digit_language">
				    <option value="">Language</option>
				    <?php while($getLanguages=mysql_fetch_assoc($languages)){?>
					<option value="<?=$getLanguages['id']?>"><?=$getLanguages['name']?></option>
					<?php }?>
				</select>
                </fieldset>
                <fieldset class="col-md-6">
                <select name="search_digit_type">
					<option value="">Type</option>
					<option value="">All</option>
					<option value="Magazines">Magazines</option>
					<option value="Newspaper">Newspaper</option>
				</select>
                </fieldset>
				
				
				<fieldset class="col-md-6">
				<?php
				$Genre=mysql_query("select id_publication_genre,name_publication_genre  from publication_genre");
				?>
                <select name="search_outlet">
				    <option value="">Publisher</option>
				    <?php while($getGenre=mysql_fetch_assoc($Genre)){?>
					<option value="<?=$getGenre['id_publication_genre']?>"><?=$getGenre['name_publication_genre']?></option>
					<?php }?>	
				</select>
                </fieldset>
                                            
                
                <fieldset class="col-md-6">
				<?php
				$outlet=mysql_query("select id,mediaOutlet from tbl_print_media");
				?>
                <select name="search_outlet">
				    <option value="">Media Outlet Name</option>
				    <?php while($getOutlet=mysql_fetch_assoc($outlet)){?>
					<option value="<?=$getOutlet['id']?>"><?=$getOutlet['mediaOutlet']?></option>
					<?php }?>	
				</select>
                </fieldset>
				                            
                <fieldset class="col-md-4">
                <input type="submit" name="digital_search" value="Search" class="button">
                </fieldset>
                </form>
              </div>
             
                   
          <div class="row" style="overflow:auto;" id="getdigitalContent">
		  <div class="add_left"><a href="add_digital_media.php" class="fadein">Add Media Outlet</a></div>
           <div class="result_r">Result = <?=$sql_count['total']?></div>
		  
          <table class="table-fill">
			<thead>
			<tr>
				<th class="text-left">Name</th>
				<th class="text-left">Type</th>
				<th class="text-left">Country</th>
				<th class="text-left">Status</th>
				<th class="text-left">Action</th>
			</tr>
			</thead>
			<tbody class="table-hover">
			<?   
	
        if(mysql_num_rows($result)>0){
		while($row = mysql_fetch_assoc($result))
		{ 	 
				//Get Country details
                $country=mysql_fetch_assoc(mysql_query("select name_country from country where id_country=".$row['country_id']))
			
			?>
			<tr>
				<td class="text-left"><?=$row['mediaOutlet']?></td>
				<td class="text-left"><?=$row['type']?></td>
				<td class="text-left"><?=$country['name_country']?></td>
				<td class="text-left"><?=($row['status']=='A')?'Active':'Inactive'?></td>
				<td class="text-left">
				<?php if($_SESSION['moms_type']=='super_admin'){?> 
				<a href="add_digital_media.php?task=edit&id=<?=$row['id']?>" class="slit">Edit</a> | 
				<? }?>
				<a href="add_digital_media.php?task=view&id=<?=$row['id']?>" class="slit">View</a> 
				<?php if($_SESSION['moms_type']=='super_admin'){?> 
				| <a href="javascript:void(0)" onClick="confirm_delete('<?=$row['id']?>','digital_delete')">Delete</a>
				<?php }?>
				</td>
			</tr>
			<script type="text/javascript">
			$('.slit').on('click', function ( e ) {
					$.fn.custombox( this, {
					effect: 'slit'
				});
				e.preventDefault();
			});
			</script>
			
			<?php $i++;}}else{ echo '<tr><td colspan="6">No Record Found</td></tr>';}

		?>
         
</tbody>
</table>







          </div>                           
                     
           <div class="row">
           <div class="add_left" onClick="digital_filter_type('Editorial')">Editorial</div>
           <div class="add_left" onClick="digital_filter_type('Social Media')">Social Media</div>
		   <div class="add_left" onClick="digital_filter_type('Blogs')">Blogs</div>
		   <div class="add_left" onClick="digital_filter_type('Forums')">Forums</div>
		   <div class="add_left" onClick="digital_filter_type('All')">All</div>
           </div>           
                                    
         </p>
		</li>
		<!--Digital Media End Here-->
		
		
		
		
		
		
		<!--Broad Media Starts Here-->
		<?    
		    extract($_POST);
		    if(!empty($_POST['broad_search'])){
		                $sql = "SELECT * FROM tbl_broad_media where 1";
						$sqls='';
						if(!empty($search_broad_status)){
						
						   $sqls.=" AND status='".$search_digit_status."'";
						}
						if(!empty($search_broad_country)){
						
						   $sqls.=" AND id_country ='".$search_digit_country."'";
						}
						if(!empty($search_broad_language)){
						
						   $sqls.=" AND language_id='".$search_digit_language."'";
						}
						if(!empty($search_broad_type)){
						
						   $sqls.=" AND type='".$search_digit_type."'";
						}
						if(!empty($search_broad_outlet)){
						
						   $sqls.=" AND mediaOutlet ='".$search_digit_outlet."'";
						}
						
			           
						$sql_count = mysql_fetch_assoc(mysql_query("SELECT count(*) as total FROM tbl_broad_media where 1 $sqls"));
						$sql= $sql.$sqls;	
		
		       }else{
			
						$sql = "SELECT * FROM tbl_broad_media";
			            
						$sql_count = mysql_fetch_assoc(mysql_query("SELECT count(*) as total FROM tbl_broad_media"));
			   }
					
			
				$result = mysql_query($sql) or die(mysql_error());
		   ?> 
		
		
		<li data-content="store3">
		<? include('messages.php')?>
		
			<p>
            <div class="row">
            <form action="index.php" method="post">
             <fieldset class="col-md-6">
              <select name="search_broad_status">
			      <option>Status</option>
			  	  <option value="A">Active</option>
			  	  <option value="I">Inactive</option>
			  </select>
              </fieldset>
              <fieldset class="col-md-6">
			  
              <select name="search_broad_country">
			  <option value="">Country</option>
			     <?php while($getCountry=mysql_fetch_assoc($country)){?>
					<option value="<?=$getCountry['id_country']?>"><?=$getCountry['name_country']?></option>
					<?php }?>
			  
			  </select>
              </fieldset>
              
               <fieldset class="col-md-6">
			   
                <select  name="search_broad_language">
				    <option value="">Language</option>
				    <?php while($getLanguages=mysql_fetch_assoc($languages)){?>
					<option value="<?=$getLanguages['id']?>"><?=$getLanguages['name']?></option>
					<?php }?>
				</select>
                </fieldset>
                <fieldset class="col-md-6">
                <select name="search_broad_type">
					<option value="">Type</option>
					<option value="">All</option>
					<option value="TV">TV</option>
					<option value="Radio">Radio</option>
				</select>
                </fieldset>
				
				
				
                                            
                
                <fieldset class="col-md-6">
				 <?php
				$Genre=mysql_query("select * from publication_genre Order BY name_publication_genre ASC");
				?>
                <select name="search_broad_genre" id="search_broad_genre">
				<option value="">Media Outlet Genre</option>
				    <?php while($getGenre=mysql_fetch_assoc($Genre)){?>
					<option value="<?=$getGenre['id_publication_genre']?>" <? if($row['id_publication_genre']==$getGenre['id_publication_genre'])echo 'Selected'?>><?=$getGenre['name_publication_genre']?></option>
					<?php }?>
				</select>
                </fieldset>
			
				
				 <fieldset class="col-md-6">
				<?php
				$outlet=mysql_query("select id,mediaOutlet from tbl_broad_media");
				?>
                <select name="search_broad_outlet">
				    <option value="">Media Outlet Name</option>
				    <?php while($getOutlet=mysql_fetch_assoc($outlet)){?>
					<option value="<?=$getOutlet['id']?>"><?=$getOutlet['mediaOutlet']?></option>
					<?php }?>	
				</select>
                </fieldset>
				
				
				
				                            
                <fieldset class="col-md-4">
                <input type="submit" name="broad_search" value="Search" class="button">
                </fieldset>
                </form>
              </div>
             
                   
          <div class="row" style="overflow:auto;" id="getbroadContent">
		  <div class="add_left"><a href="add_broadcast.php" class="fadein">Add Media Outlet</a></div>
           <div class="result_r">Result = <?=$sql_count['total']?></div>
		  
          <table class="table-fill">
			<thead>
			<tr>
				<th class="text-left">Name</th>
				<th class="text-left">Type</th>
				<th class="text-left">Language</th>
				<th class="text-left">Country</th>
				<th class="text-left">Status</th>
				<th class="text-left">Action</th>
			</tr>
			</thead>
			<tbody class="table-hover">
			<?   
	
        if(mysql_num_rows($result)>0){
		while($row = mysql_fetch_assoc($result))
		{ 	 
				//Get Country details
                $country=mysql_fetch_assoc(mysql_query("select name_country from country where id_country=".$row['country_id']));
				
				//Get Language details
                $language=mysql_fetch_assoc(mysql_query("select name from tbl_languages where id=".$row['language_id']))
			
			?>
			<tr>
				<td class="text-left"><?=$row['mediaOutlet']?></td>
				<td class="text-left"><?=$row['type']?></td>
				<td class="text-left"><?=$country['name_country']?></td>
				<td class="text-left"><?=$language['name']?></td>
				<td class="text-left"><?=($row['status']=='A')?'Active':'Inactive'?></td>
				<td class="text-left">
				<?php if($_SESSION['moms_type']=='super_admin'){?> 
				<a href="add_broadcast.php?task=edit&id=<?=$row['id']?>" class="slit">Edit</a> | 
				<?php }?>
				<a href="add_broadcast.php?task=view&id=<?=$row['id']?>" class="slit">View</a> 
				<?php if($_SESSION['moms_type']=='super_admin'){?> 
				| <a href="javascript:void(0)" onClick="confirm_delete('<?=$row['id']?>','broad_delete')">Delete</a>
				<?php }?>
				</td>
			</tr>
			<script type="text/javascript">
			$('.slit').on('click', function ( e ) {
					$.fn.custombox( this, {
					effect: 'slit'
				});
				e.preventDefault();
			});
			</script>
			
			<?php $i++;}}else{ echo '<tr><td colspan="6">No Record Found</td></tr>';}

		?>
         
</tbody>
</table>







          </div>                           
                     
           <div class="row">
           <div class="add_left" onClick="broad_filter_type('TV')">TV</div>
           <div class="add_left" onClick="broad_filter_type('Radio')">Radio</div>
		   <div class="add_left" onClick="broad_filter_type('All')">All</div>
           </div>           
                                    
         </p>
		</li>
		<!--Broad Media End Here-->
		
		
		
		
		
		
		



		<li data-content="settings">
			<p>Settings Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam nam magni, ullam nihil a suscipit, ex blanditiis, adipisci tempore deserunt maiores. Nostrum officia, ratione enim eaque nihil quis ea, officiis iusto repellendus. Animi illo in hic, maxime deserunt unde atque a nesciunt? Non odio quidem deserunt animi quod impedit nam, voluptates eum, voluptate consequuntur sit vel, et exercitationem sint atque dolores libero dolorem accusamus ratione iste tenetur possimus excepturi. Accusamus vero, dignissimos beatae tempore mollitia officia voluptate quam animi vitae.</p>

			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique ipsam eum reprehenderit minima at sapiente ad ipsum animi doloremque blanditiis unde omnis, velit molestiae voluptas placeat qui provident ab facilis.</p>
		</li>

		<li data-content="trash">
			<p>Trash Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio itaque a iure nostrum animi praesentium, numquam quidem, nemo, voluptatem, aspernatur incidunt. Fugiat aspernatur excepturi fugit aut, dicta reprehenderit temporibus, nobis harum consequuntur quo sed, illum.</p>

			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima doloremque optio tenetur, natus voluptatum error vel dolorem atque perspiciatis aliquam nemo id libero dicta est saepe laudantium provident tempore ipsa, accusamus similique laborum, consequatur quia, aut non maiores. Consectetur minus ipsum aliquam pariatur dolorem rerum laudantium minima perferendis in vero voluptatem suscipit cum labore nemo explicabo, itaque nobis debitis molestias officiis? Impedit corporis voluptates reiciendis deleniti, magnam, fuga eveniet! Velit ipsa quo labore molestias mollitia, quidem, alias nisi architecto dolor aliquid qui commodi tempore deleniti animi repellat delectus hic. Alias obcaecati fuga assumenda nihil aliquid sed vero, modi, voluptatem? Vitae voluptas aperiam nostrum quo harum numquam earum facilis sequi. Labore maxime laboriosam omnis delectus odit harum recusandae sint incidunt, totam iure commodi ducimus similique doloremque! Odio quaerat dolorum, alias nihil quam iure delectus repellendus modi cupiditate dolore atque quasi obcaecati quis magni excepturi vel, non nemo consequatur, mollitia rerum amet in. Nesciunt placeat magni, provident tempora possimus ut doloribus ullam!</p>
		</li>
		
	</ul> <!-- cd-tabs-content -->
</div> <!-- cd-tabs -->
                        </div> <!-- /.row -->

                     
                    </div> <!-- /.about -->

                    <div id="menu-2" class="services content">
                        <div class="row">
                           <div class="cd-tabs">
	<nav>
		<ul class="cd-tabs-navigation">
			<li><a data-content="inbox" class="selected" href="#0">Inbox</a></li>
			<li><a data-content="new" href="#0">New</a></li>
			<li><a data-content="gallery" href="#0">Gallery</a></li>
			
		</ul> <!-- cd-tabs-navigation -->
	</nav>

	<ul class="cd-tabs-content">
		<li data-content="inbox" class="selected">
			<p>Inbox Lorem ipsum dolor sit amet, consectetur adipisicing elit. Earum recusandae rem animi accusamus quisquam reprehenderit sed voluptates, numquam, quibusdam velit dolores repellendus tempora corrupti accusantium obcaecati voluptate totam eveniet laboriosam?</p>

			<p>Inbox Lorem ipsum dolor sit amet, consectetur adipisicing elit. Earum recusandae rem animi accusamus quisquam reprehenderit sed voluptates, numquam, quibusdam velit dolores repellendus tempora corrupti accusantium obcaecati voluptate totam eveniet laboriosam?</p>
		</li>

		<li data-content="new">
			<p>New Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non a voluptatibus, ex odit totam cumque nihil eos asperiores ea, labore rerum. Doloribus tenetur quae impedit adipisci, laborum dolorum eaque ratione quaerat, eos dicta consequuntur atque ex facere voluptate cupiditate incidunt.</p>

			<p>New Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non a voluptatibus, ex odit totam cumque nihil eos asperiores ea, labore rerum. Doloribus tenetur quae impedit adipisci, laborum dolorum eaque ratione quaerat, eos dicta consequuntur atque ex facere voluptate cupiditate incidunt.</p>
		</li>

		<li data-content="gallery">
			<p>Gallery Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque tenetur aut, cupiditate, libero eius rerum incidunt dolorem quo in officia.</p>

			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ipsa vero, culpa doloremque voluptatum consectetur mollitia, atque expedita unde excepturi id, molestias maiores delectus quos molestiae. Ab iure provident adipisci eveniet quisquam ratione libero nam inventore error pariatur optio facilis assumenda sint atque cumque, omnis perspiciatis. Maxime minus quam voluptatum provident aliquam voluptatibus vel rerum. Soluta nulla tempora aspernatur maiores! Animi accusamus officiis neque exercitationem dolore ipsum maiores delectus asperiores reprehenderit pariatur placeat, quaerat sed illum optio qui enim odio temporibus, nulla nihil nemo quod dicta consectetur obcaecati vel. Perspiciatis animi corrupti quidem fugit deleniti, atque mollitia labore excepturi ut.</p>
		</li>

		
	</ul> <!-- cd-tabs-content -->
</div> <!-- cd-tabs -->
                        </div> <!-- /.row -->
                    </div> <!-- /.services -->

                   

                 

                </div> <!-- /#menu-container -->

            </div> <!-- /.col-md-8 -->

        </div> <!-- /.row -->
    </div> <!-- /.container-fluid -->
    
    <div class="container-fluid">   
        <div class="row">
            <div class="col-md-12 footer">
              <p id="footer-text">Copyright &copy; 2020 <a href="https://allcontent.io/" target="_blank">ALLCONTENT Corporation</a></p>
            </div><!-- /.footer --> 
        </div>
    </div> <!-- /.container-fluid -->

    <script src="js/vendor/jquery-1.10.1.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>
    <!--<script src="js/jquery.easing-1.3.js"></script>-->
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript">
            
			jQuery(function ($) {

                $.supersized({

                    // Functionality
                    slide_interval: 3000, // Length between transitions
                    transition: 1, // 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
                    transition_speed: 700, // Speed of transition

                    // Components                           
                    slide_links: 'blank', // Individual links for each slide (Options: false, 'num', 'name', 'blank')
                    slides: [ // Slideshow Images
                        {
                            image: 'images/0001.jpg'
                        }, {
                            image: 'images/0002.jpg'
                        }, {
                            image: 'images/0003.jpg'
                        }, {
                            image: 'images/0004.jpg'
                        }, {
                            image: 'images/0005.jpg'
			    	           }
                    ]

                });
            });
            
    </script>
    
  <!-- External JS -->
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="http://alexgorbatchev.com/pub/sh/current/scripts/shCore.js"></script>
    <script src="http://agorbatchev.typepad.com/pub/sh/3_0_83/scripts/shBrushJScript.js"></script>
    <script src="http://agorbatchev.typepad.com/pub/sh/3_0_83/scripts/shBrushCss.js"></script>
    <script src="http://alexgorbatchev.com/pub/sh/current/scripts/shBrushXml.js"></script>

    <!-- jQuery Custombox JS -->
    <script src="src/jquery.custombox.js"></script>

    <!-- Demo page JS -->
    <script src="demo/js/demo.js"></script>

    <script>
        if ( $(window).width() > 360 ) {
            SyntaxHighlighter.all();
        }
    </script>  	
</body>
</html>