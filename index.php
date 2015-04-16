<?php include('inc/ex_globle.php'); ?>
<?php 
   /****************************** GET Id for edit recored****************************/
   	$id=$_GET['id'];
   	$sql_edit="SELECT * FROM ex_user_info WHERE user_id='".$id."'";
   	$res_edit=mysql_query($sql_edit);
   	$row_edit=mysql_fetch_array($res_edit);
   	/****************************** GET Id for edit recored****************************/
   	
   if(isset($_POST['delete']))
   {	
   		 $ids=$_POST['ids'];
   		 $cou=count($ids);		
   		 if($cou != 0){	 		
		for($i=0; $i < $cou; $i++)
		{
			 $sql_delete="DELETE FROM ex_user_info WHERE user_id='".$ids[$i]."'";
			 $res_delete=@mysql_query($sql_delete);
		}
		
			ex_redirect("$ex_pagename?value=s3");
			exit;
			
		}else
		{
			ex_redirect("$ex_pagename?value=e7");
			exit;
			
		}	
   }
   
   
   /****************************DELETE SINGLE RECORED*********************************/
   
   if(isset($_GET['delid']))
   {	
   	$delid=$_GET['delid']; 
   	$sql_delete="DELETE FROM ex_user_info WHERE user_id='".$delid."'";
   	$res_delete=@mysql_query($sql_delete);
	ex_redirect("$ex_pagename?value=s3");
   	exit;
   }
   
  
   /***************************ORDER SAVE END*********************************/
   if(isset($_POST['submit']))
   {
   		$name	 = $_POST["fullname"];
		$country = $_POST["country"];
		$email	 = $_POST["email"];
		$mobile  = $_POST["mobile"];
		$dob  = $_POST["dob"];
		$description    = $_POST["description"];
		

   	if($id)
   	{
			$sql ='update ex_user_info set name="'.$name.'",country="'.$country.'",email="'.$email.'",dob="'.$dob.'",mobile="'.$mobile.'",description="'.$description.'" where user_id="'.$id.'"';
			$retval = mysql_query( $sql, $con );
			ex_redirect("$ex_pagename?value=s2");
   		
   	}else{
		
			$sql = 'insert into ex_user_info(name,country,email,dob,mobile,description) 
			values("'.$name.'","'.$country.'","'.$email.'","'.$dob.'","'.$mobile.'","'.$description.'")';
			$retval = mysql_query( $sql, $con );
			ex_redirect("$ex_pagename?value=s1");
   			
   	}
   }
   ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <?php include('inc/admin-header.php'); ?>
      <script type="text/javascript" src="js/jquery.js"></script>
	  <script type="text/javascript" src="js/validation.js"></script>
      <div id="main">
         <div id="content">
            <div class="toolbar-placeholder">
               <div class="toolbarBox toolbarHead">
                  <ul class="cc_button">
                     <li>
                        <a id="desc-category-new" class="toolbar_btn" href="<?php echo $ex_pagename; ?>?key=add" title="Add new">
                           <span class="process-icon-new"></span>
                           <div>Add new</div>
                        </a>
                     </li>
                     <li>
                        <a id="desc-contact-back" class="toolbar_btn" href="index.php" title="Back to list">
                           <span class="process-icon-back"></span>
                           <div>Back to list</div>
                        </a>
                     </li>
                  </ul>
                  <div class="pageTitle">
                     <h3>
                        <span id="current_obj" style="font-weight: normal;">
                        <span class="breadcrumb item-0 ">Manage 
                        <img alt="&gt;" style="margin-right:5px" src="img/separator_breadcrumb.png">
                        </span>
                        <span class="breadcrumb item-1 ">
                        </span><?php if($id){ ?>Edit <?php  }elseif($_GET['key']){ ?>Add <?php }else{ ?>Manage <?php } ?> User Infomation</span>
                     </h3>
                  </div>
               </div>
            </div>
			<script type="text/javascript">
	/* Jquery validation */
	$(document).ready(function(){

		$(".form.d").validate({
				rules: {
					fullname: {
					required: true
					},
					 country: {
					required: true
					}, 
					email: {
					required: true,
					email: true
					},
					mobile: {
					required: true,
					minlength: 5,
					nourl: true
					}
				},
				messages: {
					fullname: "<span style='color:red;font-style:italic;'><br>Please enter your full name</span>", 
					country: "<span style='color:red;font-style:italic;'><br>Please select your country</span>", 
                    email: "<span style='color:red;font-style:italic;'><br>Please enter a valid email address</span>",
                    mobile: "<span style='color:red;font-style:italic;'><br>Please enter mobile number</span>"
				}
		  });				
	});
</script>
<style>
.alert.success {
  border-color: #b0d86e;
  color: #578C00;
}
.alert {
  background: #ffffff;
  border: 1px solid #bbbbbb;
  color: #6D6D6D;
  padding: 7px 7px 7px 35px;
  margin-bottom: 20px;
  position: relative;
  width: 84%;
}
</style>
            <div class="leadin"></div>
            <fieldset id="fieldset_0">
               <legend>Add User Info</legend>
               <table width="100%"  border="0">

                  <td>
                     <?php if($id || $_GET['key']){ ?>
                     <!--<form id="form_add"  name="form_add" action="" method="post" enctype="multipart/form-data">-->
					 <form class="form d" method="post" action="">
					
                        <table width="55%" border="0"  cellspacing="10">
                           <tr>
                              <td colspan="2">
                                 <?php if(isset($_GET['value'])) { error_or_success_msg($_GET['value']);} ?>
                              </td>
                           </tr>

                           <tr>
                              <td><label>Name:</label>	</td>
                              <td>
                                 <input name="fullname" id="fullname"  size="44" type="text" value="<?php if($id){ echo $row_edit['name']; }?>" > <sup>*</sup>
                                 
                              </td>
                           </tr>
							
							<tr>
                              <td><label>Date of birth:</label>	</td>
                              <td>
                                 <input name="dob" id="dob"  size="44" type="date" value="<?php if($id){ echo $row_edit['dob']; }?>" style="width:86%"> <sup>*</sup>
                              </td>
                           </tr>
						   
							
						   
						   <tr>
                              <td><label>Email</label>	</td>
                              <td>
                                 <input name="email" id="email"  size="44" type="text" value="<?php if($id){ echo $row_edit['email']; }?>" > <sup>*</sup>
                                
                              </td>
                           </tr>
						   
						   <tr>
                              <td><label>Mobile</label>	</td>
                              <td>
                                 <input name="mobile" id="mobile"  size="44" type="text" value="<?php if($id){ echo $row_edit['mobile']; }?>" > <sup>*</sup>
                                
                              </td>
                           </tr>
						   
						   <tr>
                              <td><label>Country</label>	</td>
                              <td>
								<?php 
								$sql = "select *from ex_country";
								$res = mysql_query($sql)?>
								<select name="country" id="country" style="width:88%">
								<option value="">Select Country</option>
								<?php while($row_pro=mysql_fetch_array($res)){?>
								<option value="<?php  echo $row_pro['country_id']; ?>" 
								<?php if($row_pro['country_id'] == $row_edit['country']){ ?> selected="selected" <?php } ?>>
								<?php  echo $row_pro['country_name']; ?></option>
								<?php  }?>
								</select>    
                              </td>
                           </tr>
						   
						   <tr>
                              <td><label>Message</label>	</td>
                              <td><textarea cols="45" rows="4" id="description" name="description"><?php if($id){ echo $row_edit['description']; }?></textarea></td>
                           </tr>

                           
                           <tr>
                              <td width="300">&nbsp;	</td>
                              <td><input  id="category_form_submit_btn" value="Save"   name="submit" class="button" type="submit"></td>
                           </tr>

                        </table>
                     </form>
                     <?php }else{ ?>
                     <?php 
                        $sql_data="SELECT * FROM ex_user_info order by user_id asc";
                        $res_data=@mysql_query($sql_data);
                        $row_num_package=@mysql_num_rows($res_data);
                        if($row_num_package > 0)
                        { ?>   
                     <div id="tablewrapper">
                        <div id="tableheader">
                           <div class="search">
                              <select id="columns" onChange="sorter.search('query')" style="display:none;"></select>
                              <span style="float:left; padding:3px; font-size:14px; color:#000; font-weight:bold;">Search  Details :</span>
                              <input type="text" id="query" onKeyUp="sorter.search('query')" />
                           </div>
                           <span class="details">
                              <div>Records <span id="startrecord"></span>-<span id="endrecord"></span> of <span id="totalrecords"></span></div>
                              <div><a href="javascript:sorter.reset()">reset</a></div>
                           </span>
                        </div>
                        <div id="ordResp"><?php if(isset($_GET['value'])) { error_or_success_msg($_GET['value']);} ?></div>
                        <table width="100%" align="center">
                           <tr>
                              <td colspan="2" >
                              </td>
                           </tr>
                        </table>
                        <form  id="form" name="form" action="" method="post">
                           <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
                              <thead>
                                 <tr>
                                    <th class="nosort"><h3>ID</h3></th>
                                    <th  class="asc" ><h3>User Name</h3></th>
									<th  class="asc" ><h3>DOB</h3> </th>
									
                                    <th  class="asc" ><h3>Email</h3> </th>
                                    <th  class="asc" ><h3>Mobile</h3></th>
									<th class="head"><h3>Country</h3></th>
                                    <th class="head"><h3>Description</h3></th>
                                    <th class="nosort"><h3>Edit / Delete</h3></th>
									<th class="nosort"><h3>Action</h3></th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                    $i=1;
                                    while($row_data=@mysql_fetch_array($res_data))
                                    { ?>  
                                 <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['name']; ?></td>
									 <td><?php echo $row_data['dob']; ?></td>
                                    <td><?php echo $row_data['email']; ?></td>
									<td><?php echo $row_data['mobile']; ?></td>
									<td>
									<?php  
										$sql_country = "select country_name from ex_country where country_id='".$row_data['country']."'";
										$res_country = mysql_query($sql_country);
										while($row_pro=mysql_fetch_array($res_country))
										 {
											echo $row_pro['country_name']; 
										 }
									?>
									</td>
									<td><?php if(strlen($row_data['description']) >80){ echo substr($row_data['description'],0,80).'....';}else { echo $row_data['description'];} ?></td>
                                    <td>
                                       <a href="<?php echo $ex_pagename; ?>?id=<?php echo $row_data['user_id']; ?>" title="Edit Record">
                                       <img src="img/edit.gif" onclick="d()"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                       <a href="<?php echo $ex_pagename; ?>?delid=<?php echo $row_data['user_id']; ?>" title="Delete Record" onclick="return confirm('Do you really want to delete record?');"><img src="img/delete.gif" /></a>
                                    </td>
                                   <td align="center" >
								   <input type="checkbox" name="ids[]" id="ids[]" style="margin-right:7px;" value="<?php echo $row_data['user_id']; ?>" /></td>  
                                 </tr>
                                 <?php $i++; } ?>
                              </tbody>
                           </table>
                           <br />
                            <table width="100%">
							<tr><td>
							<input type="submit" name="delete" id="delete"  class="button" value="Delete Selected" onclick="return confirm('Do you really want to delete record?');" />			</td>
							</tr></table>
                           <div id="tablefooter">
                              <div id="tablenav">
                                 <div>
                                    <img src="img/first.gif" width="16" height="16" alt="First Page" onClick="sorter.move(-1,true)" />
                                    <img src="img/previous.gif" width="16" height="16" alt="First Page" onClick="sorter.move(-1)" />
                                    <img src="img/next.gif" width="16" height="16" alt="First Page" onClick="sorter.move(1)" />
                                    <img src="img/last.gif" width="16" height="16" alt="Last Page" onClick="sorter.move(1,true)" />
                                 </div>
                                 <div>
                                    <select id="pagedropdown"></select>
                                 </div>
                                 <div>
                                    <a href="javascript:sorter.showall()">view all</a>
                                 </div>
                              </div>
                              <div id="tablelocation">
                                 <div class="page">Page <span id="currentpage"></span> of <span id="totalpages"></span></div>
                              </div>
                           </div>
                     </div>
                     </form>
                     <?php }else{  no_record_message(); } ?>	
                     <script type="text/javascript" src="js/script.js"></script>
                     <script type="text/javascript">
                        var sorter = new TINY.table.sorter('sorter','table',{
                        	headclass:'head',
                        	ascclass:'asc',
                        	descclass:'desc',
                        	evenclass:'evenrow',
                        	oddclass:'oddrow',
                        	evenselclass:'evenselected',
                        	oddselclass:'oddselected',
                        	paginate:true,
                        	size:5,
                        	colddid:'columns',
                        	currentid:'currentpage',
                        	totalid:'totalpages',
                        	startingrecid:'startrecord',
                        	endingrecid:'endrecord',
                        	totalrecid:'totalrecords',
                        	hoverid:'selectedrow',
                        	pageddid:'pagedropdown',
                        	navid:'tablenav',
                        	sortcolumn:1,
                        	sortdir:1,
                        	sum:[],
                        	avg:[],
                        	columns:[{index:7, format:'%', decimals:1},{index:8, format:'$', decimals:0}],
                        	init:true
                        });
                     </script>
                     <?php } ?>
                  </td>
                  </tr>
               </table>
            </fieldset>
            <div style="clear:both;height:0;line-height:0">&nbsp;</div>
         </div>
         <div style="clear:both;height:0;line-height:0">&nbsp;</div>
      </div>
      <style type="text/css">
         .ajax-file-upload-statusbar{border:1px solid #0ba1b5;margin-top:10px;width:100%;margin-right:10px;margin:5px;padding:5px 5px 5px 5px}
         .ajax-file-upload-filename{width:100%;height:auto;margin:0 5px 5px 10px;color:#807579}
         .ajax-file-upload-progress{margin:0 10px 5px 10px; padding:5px; position:relative;width:85%;border:1px solid #ddd;padding:1px;border-radius:3px;display:inline-block}
         .ajax-file-upload-bar{background-color:#0ba1b5;width:90%;height:25px;}
         .ajax-file-upload-percent{position:absolute;display:inline-block;top:3px;left:48%}
         .ajax-file-upload-red{
         display: inline-block;
         margin-bottom: 0;
         font-weight: 400;
         text-align: center;
         vertical-align: top;
         cursor: pointer;
         background-image: none;
         border: 1px solid transparent;
         white-space: nowrap;
         padding:2px;
         font-size: 14px;
         line-height: 1.428571429;
         /* border-radius: 4px; */
         -webkit-user-select: none;
         color: #fff;
         background-color: #FF6600;
         border-color: #FF6600;
         }
         .ajax-file-upload-green{background-color:#77b55a;-moz-border-radius:4px;-webkit-border-radius:4px;border-radius:4px;margin:0;padding:0;display:inline-block;color:#fff;font-family:arial;font-size:13px;font-weight:normal;padding:4px 15px;text-decoration:none;cursor:pointer;text-shadow:0 1px 0 #5b8a3c;vertical-align:top;margin-right:5px}
         .ajax-file-upload{font-size:16px;font-weight:bold;padding:15px 0px;cursor:pointer;line-height:20px;height:30px;margin:0 10px 10px 0;display:inline-block;color:#888;text-decoration:none;padding:6px 10px 4px 10px;color:#fff;background:#428bca;vertical-align:middle; cursor:pointer;}
         .ajax-file-upload:hover{background:#3396c9;-moz-box-shadow:0 2px 0 0 #15719f;-webkit-box-shadow:0 2px 0 0 #15719f;box-shadow:0 2px 0 0 #15719f}.ajax-upload-dragdrop{border:2px dotted #a5a5c7;color:#dadce3;text-align:left;vertical-align:middle;padding:10px 10px 0 10px; cursor:pointer;}
      </style>
  		
      </div>
      </div>
      </body>
</html>