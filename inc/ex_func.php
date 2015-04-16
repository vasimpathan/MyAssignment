<?php 

// +----------------------------------------------------------------------+
// | PHP Version 5														  |
// +----------------------------------------------------------------------+
// | Author: Ganesh Kharche	<ganeshkharche01@gmail.com>						  |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | This source file is protected by copyright	law. No	part of	this code |
// | may be	used/reproduced	without	permission of the authors.			  |
// +----------------------------------------------------------------------+


//*****************************************IMAGE FUNCTION **************************************//


function checkpath($PATH)
{
	if(!is_dir($PATH))
	{
		mkdir($PATH,0777);
	}
}

 function getextention($fname)
{
	$fext=explode(".",$fname);
	$ext=$fext[count($fext)-1];
	return $ext;
}




function renamefile($path, $filename)
{
	$arr=explode('.',$filename);
	$ext = $arr[count($arr)-1];
			
	$allowed = "/[^a-z0-9\\_]/i";
	$body = preg_replace($allowed,"",$arr[0]);
	
	$filename1 = $body.'.'.$ext;

	$cpt = 1;
	while (@file_exists($path.$filename1)) 
	{
		$body1 = $body . '_' . $cpt;
		$filename1 = $body1 . '.' . $ext;
		$cpt++;
	} 
	

	return $filename1;
}





function uploadFile($PATH,$FILENAME,$FILEBOX)
{
	
	 checkpath($PATH); 

	 $PATH = $PATH.'/';

	$ext=getextention($FILENAME);

	$fname=time()."_".mt_rand(1,1000).".".$ext;


	$FILENAME = renamefile($PATH,$fname);

	$file=$PATH.$FILENAME;
	
	
	$uploaded="TRUE";
	
	global $_FILES;
	
    if (! @file_exists($file))
    {


		if ( isset( $_FILES[$FILEBOX] ) )
        {
			if (is_uploaded_file($_FILES[$FILEBOX]['tmp_name']))
            {
				move_uploaded_file($_FILES[$FILEBOX]['tmp_name'], $file);
            }else{
				$uploaded="FALSE";
            }
        }
    } //end of if @fileexists
	return $FILENAME;
}





function get_single_value($field_get,$if_field,$pass_id,$tb_name)
{
	
$sql="SELECT $field_get FROM `$tb_name` WHERE $if_field='$pass_id' LIMIT 0 , 1";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	
	return $row[$field_get];
	
}




/******************************************************************************
*		File : functions.php                                              *
*       Date Created : Wednesday 11 July 2007, 10:57 AM                       *
*       Date Modified : Wednesday 11 July 2007, 10:57 AM                      *
*       File Comment : This file contain functions which will use in coding.  *
*******************************************************************************/
function createSelectCategoryList($id,$optionList,$selectedItem)
{		
	
	$selectedCat=explode(",",$selectedItem);
	//echo $selectedItem;
	echo $strsql="select * from tbl_category where parent=". $id . " and status=1";
	$c_res=mysql_query($strsql);
	if($c_rows=mysql_num_rows($c_res)==0)	
	{
	$optionList="";
	}
	else{
		
		while($c_row=mysql_fetch_assoc($c_res))
		{			
			if($id!=0)
			$optionList=$optionList." > ";
			$optionList=str_replace(" >  > "," > ",$optionList);
			//$optionList=$optionList.$c_row["category"];
			if (in_array($c_row["id"],$selectedCat))
				echo "<option value='".$c_row["id"]."' selected>".$optionList.$c_row["category"]."</option>";
			else
				echo "<option value='".$c_row["id"]."'>".$optionList.$c_row["category"]."</option>";			
				createSelectCategoryList($c_row["id"],$optionList.$c_row["category"],$selectedItem);			
		}
	}
}

// to format the textarea data on pages
function format_paragraph($data)
{
	return "<br>".nl2br($data);
}
// For Executing Query. This function returns a argument which contain recordset 
// object through it user can retrieve values of table.
function executeQuery($sql)
{
	$result = mysql_query($sql) or die("<span style='FONT-SIZE:11px; FONT-COLOR: #000000; font-family=tahoma;'><center>An Internal Error has Occured. Please report following error to the webmaster.<br><br>".$sql."<br><br>".mysql_error()."'</center></FONT>");
	return $result;
} 

// This function returns a recordset object that contain first record data.
function getSingleResult($sql)
{
	$response = "";
	$result = mysql_query($sql) or die("<center>An Internal Error has Occured. Please report following error to the webmaster.<br><br>".$sql."<br><br>".mysql_error()."'</center>");
	if ($line = mysql_fetch_array($result)) {
		$response = $line['0'];
	} 
	return $response;
} 

// For Executing Query. This function update the table by desired data.
function executeUpdate($sql)
{
	mysql_query($sql) or die("<center>An Internal Error has Occured. Please report following error to the webmaster.<br><br>".$sql."<br><br>".mysql_error()."'</center>");
}

// It returns the path of current file.
function getCurrentPath()
{
	global $_SERVER;
	return "http://" . $_SERVER['HTTP_HOST'] . getFolder($_SERVER['PHP_SELF']);
}

// This function adjusts the decimal point of argumented parameter and return the adjusted value.
function adjustAfterDecimal($param)
{
	if(strpos($param,'.')== "")
	{
		$final_value=$param.".00";
		return  $final_value;
	}
	$after_decimal  = substr($param , strpos($param,'.')+1, strlen($param) );	
	$before_decimal = substr($param,0 ,  strpos($param,'.'));
	if(strlen($after_decimal)<2)
	{
		if(strlen($after_decimal)==1)
		{
			$final_value=$param."0";
		}
		if(strlen($after_decimal)==0)
		{
			$final_value.="$param.00";
		}
	}
	else
	{
		$trim_value = substr($after_decimal,0,2);
		$final_value.=$before_decimal.".".$trim_value;
	}
	return $final_value;
}	

// This funtion is used for validating the front side users that he is logged in or not.
function validate_user()
{
	if($_SESSION['sess_uid']=='')
	{
		ms_redirect("login.php?back=$_SERVER[REQUEST_URI]&msg=Please Login Here To View details");
	}
	
}

// This funtion is used for validating the front side users that he is logged in or not.
function validate_emp()
{
	if($_COOKIE['sess_eid']=='')
	{
		$_SESSION['sess_eid']=$_COOKIE['sess_eid'];
		$_SESSION['sess_ename']=$_COOKIE['sess_ename'];
		$_SESSION['sess_type']=$_COOKIE['sess_type'];
		$_SESSION['sess_employer']=$_COOKIE['sess_employer'];
		ms_redirect("employer_login.php?back=$_SERVER[REQUEST_URI]");
	}
	else
	{
		$_SESSION['sess_eid']=$_COOKIE['sess_eid'];
		$_SESSION['sess_ename']=$_COOKIE['sess_ename'];
		$_SESSION['sess_type']=$_COOKIE['sess_type'];
		$_SESSION['sess_employer']=$_COOKIE['sess_employer'];
	}
	
}
// This funtion is used for validating the admin side users that he is logged in or not.


// This function is used for redirecting the file on desired file.
function ms_redirect($file, $exit=true, $sess_msg='')
{
	header("Location: $file");
	exit();
	
}
// This function is used by the paging functions.
function get_qry_str($over_write_key = array(), $over_write_value= array())
{
	global $_GET;
	$m = $_GET;
	if(is_array($over_write_key)){
		$i=0;
		foreach($over_write_key as $key){
			$m[$key] = $over_write_value[$i];
			$i++;
		}
	}else{
		$m[$over_write_key] = $over_write_value;
	}
	$qry_str = qry_str($m);
	return $qry_str;
} 
// This function is used by the paging functions.
function qry_str($arr, $skip = '')
{
	$s = "?";
	$i = 0;
	foreach($arr as $key => $value) {
		if ($key != $skip) {
			if(is_array($value)){
				foreach($value as $value2){
					if ($i == 0) {
						$s .= "$key%5B%5D=$value2";
					$i = 1;
					} else {
						$s .= "&$key%5B%5D=$value2";
					} 
				}		
			}else{
				if ($i == 0) {
					$s .= "$key=$value";
					$i = 1;
				} else {
					$s .= "&$key=$value";
				} 
			}
		} 
	} 
	return $s;
} 

function cust_send_mail($email_to,$emailto_name,$email_subject,$email_body,$email_from,$path,$reply_to,$html=true)
{
	require_once "class.phpmailer.php";
	global $SITE_NAME;
	$mail = new PHPMailer();
	$mail->IsSMTP(); // send via SMTP
	$mail->Mailer   = "mail"; // SMTP servers
    $mail->AddAttachment($path);
	$mail->From     = $email_from;
	$mail->FromName = $SITE_NAME;
	$mail->AddAddress($email_to,$emailto_name); 
	$mail->AddReplyTo($reply_to,$SITE_NAME);
	$mail->WordWrap = 50;                              // set word wrap
	$mail->IsHTML($html);                               // send as HTML
	$mail->Subject  =  $email_subject;
	$mail->Body     =  $email_body;
	$mail->Send();	
	return true;
	
}


// This function is the replacement of the print_r function. It will work only on the local mode.
function ms_print_r($var)
{
	global $local_mode;
	if ($local_mode || $debug) {
	echo "<pre>";
	print_r($var);
	echo "</pre>";
	}
} 
// This function is used to add slashes to a variable.
function add_slashes($param)
{
	$k_param = addslashes(stripslashes($param));
	return $k_param;
} 
// This function is used to strip slashes to a whole array.
function ms_stripslashes($text)
{
	if (is_array($text)) {
		$tmp_array = Array();
		foreach($text as $key => $value) {
			$tmp_array[$key] = ms_stripslashes($value);
			} 
		return $tmp_array;
	} else {
		return stripslashes($text);
	} 
} 
// This function is used to add slashes to whole array.
function ms_addslashes($text)
{
	if (is_array($text)) {
		$tmp_array = Array();
		foreach($text as $key => $value) {
			$tmp_array[$key] = ms_addslashes($value);
		} 
		return $tmp_array;
	} else {
		return addslashes(stripslashes($text));
	} 
} 
// This function is used to add strip html.
function html2text($html)
{
	$search = array ("'<head[^>]*?>.*?</head>'si", // Strip out javascript
		"'<script[^>]*?>.*?</script>'si", // Strip out javascript
		"'<[\/\!]*?[^<>]*?>'si", // Strip out html tags
		"'([\r\n])[\s]+'", // Strip out white space
		"'&(quot|#34);'i", // Replace html entities
		"'&(amp|#38);'i",
		"'&(lt|#60);'i",
		"'&(gt|#62);'i",
		"'&(nbsp|#160);'i",
		"'&(iexcl|#161);'i",
		"'&(cent|#162);'i",
		"'&(pound|#163);'i",
		"'&(copy|#169);'i",
		"'&#(\d+);'e"); // evaluate as php
	$replace = array ("",
		"",
		"",
		"\\1",
		"\"",
		"&",
		"<",
		">",
		" ",
		chr(161),
		chr(162),
		chr(163),
		chr(169),
		"chr(\\1)");
	$text = preg_replace ($search, $replace, $html); 
	return $text;
} 
// This function is used to generate sorting arrow in a listing.
function sort_arrows($column){
	global $_SERVER;
	return '<A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'asc')).'"><IMG SRC="images/white_up.gif" BORDER="0"></A> <A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'desc')).'"><IMG SRC="images/white_down.gif" BORDER="0"></A>';
}
function sort_arrow_front($column){
	global $_SERVER;
	return '<A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'asc')).'"><IMG SRC="images/white_up.gif" BORDER="0"></A> <A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'desc')).'"><IMG SRC="images/white_down.gif" BORDER="0"></A>';
}

function sort_arrows_front($column,$heading){
	global $_SERVER;
	return '<A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'asc')).'"><img src="images/sort_up.gif" alt="Sort Up" border="0" title="Sort Up"></A>&nbsp;'.$heading.'&nbsp;<A HREF="'.$_SERVER['PHP_SELF'].get_qry_str(array('order_by','order_by2'), array($column,'desc')).'"><img src="images/sort_down.gif" alt="Sort Down" border="0" title="Sort Down"></A>';
}
// This function is used to unlink a file.
function unlink_file( $file_name , $folder_name )
{
	$file_path = $folder_name."/".$file_name;
	@chmod ($folder_name , 0777);
	@touch($file_path);
	@unlink($file_path);
	return true;	
}


function dd_date_format($date) {
	if($date) {
		list($y,$m,$d)=explode("-",$date);		
		return "$m/$d/$y";
	}
}

function resize_img($imgPath, $maxWidth, $maxHeight, $directOutput = true, $quality = 90, $verbose,$imageType)
{
   // get image size infos (0 width and 1 height,
   //     2 is (1 = GIF, 2 = JPG, 3 = PNG)
  
     $size = getimagesize($imgPath);
		$arr=explode(".",$imgPath);		
   // break and return false if failed to read image infos
     if(!$size){
       if($verbose && !$directOutput)echo "<br />Not able to read image infos.<br />";
       return false;
     }

   // relation: width/height
     $relation = $size[0]/$size[1];
	 
	 $relation_original = $relation;
   
   
   // maximal size (if parameter == false, no resizing will be made)
     $maxSize = array($maxWidth?$maxWidth:$size[0],$maxHeight?$maxHeight:$size[1]);
   // declaring array for new size (initial value = original size)
     $newSize = $size;
   // width/height relation
     $relation = array($size[1]/$size[0], $size[0]/$size[1]);


	if(($newSize[0] > $maxWidth))
	{
		$newSize[0]=$maxSize[0];
		$newSize[1]=$newSize[0]*$relation[0];
		$newSize[0]=$maxWidth;
		$newSize[1]=$newSize[0]*$relation[0];		
		
	}
	else
	{
	
		$newSize[0]=$newSize[0];
		$newSize[1]=$newSize[0]*$relation[0];
		//$newSize[1]=$maxHeight;	
    }		
	
	if($maxHeight>0)
	$newSize[1]=$maxHeight;
     // create image
       switch($size[2])
       {
         case 1:
           if(function_exists("imagecreatefromgif"))
           {
             $originalImage = imagecreatefromgif($imgPath);
           }else{
             if($verbose && !$directOutput)echo "<br />No GIF support in this php installation, sorry.<br />";
             return false;
           }
           break;
         case 2: $originalImage = imagecreatefromjpeg($imgPath); break;
         case 3: $originalImage = imagecreatefrompng($imgPath); break;
         default:
           if($verbose && !$directOutput)echo "<br />No valid image type.<br />";
           return false;
       }


     // create new image

       $resizedImage = imagecreatetruecolor($newSize[0], $newSize[1]); 

       imagecopyresampled($resizedImage, $originalImage,0, 0, 0, 0,$newSize[0], $newSize[1], $size[0], $size[1]);
		$rz=$imgPath;
     // output or save
       if($directOutput)
		{
         imagejpeg($resizedImage);
		 }
		 else
		{
			
			 $rz=preg_replace("/\.([a-zA-Z]{3,4})$/","".$imageType.".".$arr[count($arr)-1],$imgPath);
         		imagejpeg($resizedImage, $rz, $quality);
         }
     // return true if successfull
       return $rz;
}



function watermarkImage ($SourceFile, $WaterMarkText, $DestinationFile) {
   list($width, $height) = getimagesize($SourceFile);
   $image_p = imagecreatetruecolor($width, $height);
   $image = imagecreatefromjpeg($SourceFile);
   imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height);
   $black = imagecolorallocate($image_p, 0, 0, 0);
   $font = 'arial.ttf';
   $font_size = 10;
   imagettftext($image_p, $font_size, 0, 10, 20, $black, $font, $WaterMarkText);
   if ($DestinationFile<>'') {
      imagejpeg ($image_p, $DestinationFile, 100);
   } else {
      header('Content-Type: image/jpeg');
      imagejpeg($image_p, null, 100);
   };
   imagedestroy($image);
   imagedestroy($image_p);
};



function insert_multiple_images($img_array)
{

if(array_filter($img_array)) 
{
	$errors= array();
	
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
		
		$file_name = $key.$_FILES['files']['name'][$key];
		$file_size =$_FILES['files']['size'][$key];
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$file_type=$_FILES['files']['type'][$key];	
      
	    if($file_size > 2097152){
			$errors[]='File size must be less than 2 MB';
        }
			
        
        $desired_dir="../images/products/";
		
		$ext=getextention($file_name);
		$fname=time()."_".mt_rand(1,1000).".".$ext;
		$file_name = renamefile($desired_dir,$fname);  
		
		
			
			if (!isset($_SESSION['image_name'])) {
   					 $_SESSION['image_name'] = array();
		}
		
		
		$img_names=array_push($_SESSION['image_name'],$file_name);
				
				
        if(empty($errors)==true){
            if(is_dir($desired_dir)==false){
                mkdir("$desired_dir", 0700);		// Create directory if it does not exist
            }
            if(is_dir("$desired_dir/".$file_name)==false){
				
				
                move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
            }
		
		
		// mysql_query($query);
		 			
        }else{
                print_r($errors);
        }
    }
	 $image_src=implode(',',array_unique($_SESSION['image_name']));
}
return $image_src;

}

/////**** multiple banner imaged
function insert_multiple_banners($img_array)
{

if(array_filter($img_array)) 
{
	$errors= array();
	
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
		
		$file_name = $key.$_FILES['files']['name'][$key];
		$file_size =$_FILES['files']['size'][$key];
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$file_type=$_FILES['files']['type'][$key];	
      
	    if($file_size > 2097152){
			$errors[]='File size must be less than 2 MB';
        }
			
        
        $desired_dir="images/holidays/";
		//$desired_dir="day_image/";
		$ext=getextention($file_name);
		$fname=time()."_".mt_rand(1,1000).".".$ext;
		$file_name = renamefile($desired_dir,$fname);  
		
		
			
			if (!isset($_SESSION['image_name'])) {
   					 $_SESSION['image_name'] = array();
		}
		
		
		$img_names=array_push($_SESSION['image_name'],$file_name);
				
				
        if(empty($errors)==true){
            if(is_dir($desired_dir)==false){
                mkdir("$desired_dir", 0700);		// Create directory if it does not exist
            }
            if(is_dir("$desired_dir/".$file_name)==false){
				
				
                move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
            }
		
		
		// mysql_query($query);
		 			
        }else{
                print_r($errors);
        }
    }
	 $image_src=implode(',',array_unique($_SESSION['image_name']));
}
return $image_src;

}









/*********************************************************************
 MULTIPLE DELETE REORED
*********************************************************************/

function delete_ids($ids,$key_field,$tb_name)
{
	 $ids=$_POST['ids'];
		//print_r($ids); 
		 $cou=count($ids);
		
		 if($cou != 0){	 
		
	for($i=0; $i < $cou; $i++)
	{
		 $sql_delete="DELETE FROM $tb_name WHERE $key_field='".$ids[$i]."'";
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
/*********************************************************************
 DELETE SINGLE REORED
*********************************************************************/
function delete_single($key_field,$delid,$tb_name)
{
		 $sql_delete="DELETE FROM $tb_name WHERE $key_field='".$delid."'"; 
			$res_delete=@mysql_query($sql_delete);
			ex_redirect("$ex_pagename?value=s3");
			exit;
}
/*********************************************************************
 change SINGLE REORED status
*********************************************************************/
function change_status($tb_name,$set_field,$status,$key_field,$key_id)
	{
		 $sql_sta="UPDATE $tb_name SET $set_field='".$status."' WHERE $key_field='".$key_id."'";
		$res_sql=@mysql_query($sql_sta);
	
		if($status == 'Active')
		{
			 ex_redirect("$ex_pagename?value=s12");exit;
			 
		}else{ ex_redirect("$ex_pagename?value=s11");exit; }
		
	}
	
/*********************************************************************	
		upload Fix Size IMAGE
*********************************************************************/

function fixsize_image_upload($img_name,$img_path,$newwidth,$newheight,$extension,$img_pass_name)
{
 	
	
if($extension=="jpg" || $extension=="jpeg" )
{
	$uploadedfile = $_FILES['file']['tmp_name'];

	$src = imagecreatefromjpeg($uploadedfile);

}

else if($extension=="png")
{
	$uploadedfile = $_FILES['file']['tmp_name'];
	
	$src = imagecreatefrompng($uploadedfile);

}else 
{
	$src = imagecreatefromgif($uploadedfile);
}


list($width,$height)=getimagesize($uploadedfile);

$tmp=imagecreatetruecolor($newwidth,$newheight);
imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

$filename=$img_pass_name.".".$extension; 
$filenameuploaded = $img_path.$img_pass_name.".".$extension;

imagejpeg($tmp,$filenameuploaded,100);

return  $filename;

}



function calculate_persent($product_prize,$product_discount)
{	
	  if($product_prize != ''){
		
			/* Calculate $percent% from $total */
			$discount_value = ($product_prize / 100) * $product_discount;
			$final_price = $product_prize - $discount_value;
			
			//Format numbers with number_format()
		
			$product_prize = number_format(floatval($product_prize));
			$discount_value = number_format(floatval($discount_value));
			$final_price = number_format(floatval($final_price));
			
			return $final_price;
	}


}

function rep($value)
{
	$arr= array(" ","&",'/');
	$rep_arr = array("+"," and ","/");
	return str_replace($arr,$rep_arr,strtolower($value));
}

/*********************************************************************
This function is used to Export Recored into excelsheet
*********************************************************************/
 
 function export_to_excel($tbl_name,$key_id,$id_array,$export_file_name)
{
	//$id_array = 	  $_POST['data']; // return array
	$id_count = count($id_array); // count array
	$out = '<table border=1>';
	$out .= '<tr>';

	$field_name  = mysql_list_fields('squaretech',$tbl_name);
	$count_field = mysql_num_fields($field_name); // count the table field
	//to Removev the unwanted  fields
	$removeArr=array('user_id','dealer_name','prifix','taluka_id','dist_id','state_id','mahindra_model_intrest','date_time','ip');
	$removeArrCount=count($removeArr);

	for($i = 0; $i < $count_field; $i++) { // name of all fields
		 $l= mysql_field_name($field_name,$i); 
			
			if (!in_array($l, $removeArr)) {
				
				$arrR = array($key_id,"_");
				$arrRep =array("Sr. No"," ");
		
			$out .=" <td><strong> ".ucwords(str_replace($arrR,$arrRep,$l))."</strong></td>";
		
			}
	}
	$out .= '</tr>';

	/*echo "<pre>";
			print_r($out);*/
			
	// number of id recoreds
	for($j = 0; $j < $id_count; $j++) { // each checked
	$id = $id_array[$j];
	
		  $sql="SELECT * FROM $tbl_name WHERE $key_id= '$id'";
		  $query = mysql_query($sql);

		while ($row_array = mysql_fetch_assoc($query)) {
			
			//Unset the unwanted row fields
				$row =array_diff_key($row_array,array_flip($removeArr));
		
			$newarr=array();
			$newarr=array_values($row);
			
			$array_count=count($newarr);
		
				$out .= '<tr>';
					for($i = 0; $i < $array_count; $i++) {
					

							if($i==0)
							{  //  row is primaery key id but convert into sr. no and  start with zero 
								$srno=$j+1;
								$out .="<td>".$srno."</td>";
															
							}else
							{
								if($newarr["$i"] != '0')
								{
									$out .="<td>".$newarr["$i"]."</td>";
								}else
								{
									$out .="<td></td>";
								}
							}
				}
			
			$out .= '</tr>';
		
		}
			/*echo "<pre>";
			
			print_r($out); die;*/

	}
	
		$out .= '</table>';
		
$export_file_name=$export_file_name.".xls";


header('Content-Type: application/force-download');
header('Content-disposition: attachment; filename="'.$export_file_name.'"');
// Fix for crappy IE bug in download.
//header("Pragma: ");
//header("Cache-Control: ");
echo $out; // output
exit;
}




function mail_body_design($mail_msg)
{
	global $ex_website_name;
	
	
	$msg="<div marginwidth='0' marginheight='0' style='background:#eee; width:700px;' align='center' border='0'>
<table width='95%' border='0' bgcolor='#eee' align='left'>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
<td colspan='3' style='background:#0E5089; color:#FFF;  font-size:12px;'>

<table width='100%' border='0'>
  <tr>
    <td><a href='http://www.virconindia.com/' style='color:#fff;' target='_blank'>Vircon India</a></td>
     <td style='font-size:18px;' align='right'>
    <img height='30' width='170' src='http://www.virconindia.com/images/logo.gif' alt='Vircon India' title='Vircon India' style='display:block'>
	 
	  </td>
  </tr>
</table>

</td>
</tr>
<tr>
    <td>
 <table width='100%' border='0' bgcolor='#FFFFFF'>
 
 <tr>
	 <td width='50'></td>
		<td  > 
		". $mail_msg ."
        </td>
	 <td width='50'></td>
</tr>
  <tr>
    <td width='50'>&nbsp;</td>
     <td style='font-size:13px;' > &nbsp;</td>
	 <td width='50'>&nbsp;</td> 
  </tr>
</table>
    </td>
</tr>
  
<td colspan='3' style='background:#0E5089; color:#FFF;  font-size:12px;'>

<table width='100%' border='0'>
  <tr>
    <td width='50'>&nbsp;</td>
     <td style='font-size:13px;' > &nbsp;</td>
	 <td width='50'>&nbsp;</td> 
  </tr>
  <tr>
    <td width='50'></td>
     <td style='font-size:13px;' >
    Contact Address :
	 <br>
	A-3, Liberty Society Phase II, Opp Lane No 5, North Main Road,<br> Koregaon Park, Pune 411001.  <br> Landline | (020) 39 39 55 22 / (020) 39 39 55 23 <br> Mobile | +91 95 45 45 7113 <br>

Email ID | 	<font style='color:#D51818;'>info@virconindia.com </font><br>
	 &copy;2013 <a href='http://www.virconindia.com/' style='color:#D51818;'>Vircon India.</a> All rights reserved.</i>
	  </td>
     <td width='50'>&nbsp;</td> 
  </tr>
   <tr>
    <td width='50'>&nbsp;</td>
     <td style='font-size:13px;' > &nbsp;</td>
	 <td width='50'>&nbsp;</td> 
  </tr>
</table>
</td>
</tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>";


return $msg;
	
}


function mail_body($msg)
{
	$body = '<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
 <tbody><tr>
  <td style="padding:0in 0in 0in 0in">
  <div align="center">
  <table  border="1" cellspacing="0" cellpadding="0" width="650" style="width:487.5pt; background:white;border:solid #C8E5F6">
   <tbody><tr>
    <td valign="top" style="border:none;padding:0in 0in 0in 0in">
    <table c="" border="1" cellspacing="0" cellpadding="0" width="650" style=";border:none;border-bottom:solid #eee 1.0pt">
     <tbody><tr>
      <td width="275" style="width:206.25pt;border:none; padding:7.5pt 22.5pt 7.5pt 22.5pt">
      <p><span style=""><img border="0" width="270" height="80" src="http://webtest.excellenceserver.com/travnext/img/logo.png" alt=""></span><o:p></o:p></p>
      </td>
      <td width="255" style="width:191.25pt;border:none;padding:22.5pt 22.5pt 22.5pt 22.5pt">
      <p class="MsoNormal" align="right" style="text-align:right"><strong><span style="font-size:10.5pt;font-family::Arial, Helvetica, sans-serif;color:#555555">Date</span></strong><span style="font-size:10.5pt;font-family:Arial, Helvetica, sans-serif;color:#555555"><br>
     Nov 16,2013<o:p></o:p></span></p>
      </td>
     </tr>
    </tbody></table>
    </td>
   </tr>
   <tr>
    <td valign="top" style="border:none;padding:0in 0in 0in 0in">
    <table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="650" style="width:487.5pt">
     <tbody><tr style="height:22.5pt">
      <td width="100%" colspan="3" style="width:100.0%;padding:0in 0in 0in 0in;   height:22.5pt">
      </td>
     </tr>
    
     <tr>
      <td width="30" style="width:22.5pt;padding:0in 0in 0in 0in">
      
      </td>
      <td width="590" style="width:442.5pt;padding:0in 0in 11.25pt 0in">
	  '.$msg.'
      </td>
      <td width="30" style="width:22.5pt;padding:0in 0in 0in 0in">
    
      </td>
     </tr>
     <tr>
      <td width="30" style="width:22.5pt;padding:0in 0in 0in 0in">
    
      </td>
      <td width="590" style="width:442.5pt;padding:0in 0in 0in 0in">
      <table class="MsoNormalTable" border="1" cellspacing="0" cellpadding="0" width="590" style="width:442.5pt;background:#EFFAFF;border:solid #C4E4F2 1.0pt">
       <tbody><tr>
        <td width="191" valign="top" style="width:143.25pt;border:none;padding:
        18.75pt 0in 18.75pt 18.75pt">
Travnext is just not a travel company but a mean to fulfill your travelling needs. We are a leading company and the only one providing wide range of holiday packages and services. We take pride in saying that with the brand name "Travnext", today we are serving around 100 corporate and several families with their travelling needs. 
        </td>
       
      
       </tr>
      </tbody></table>
      </td>
      <td width="30" style="width:22.5pt;padding:0in 0in 0in 0in">
    
      </td>
     </tr>
     <tr style="height:22.5pt">
      <td width="100%" colspan="3" style="width:100.0%;padding:0in 0in 0in 0in;
      height:22.5pt">
     
      </td>
     </tr>
    </tbody></table>
    </td>
   </tr>
  </tbody></table>
  </div>
  <p align="center" style="text-align:center"><span style="font-size:8.5pt;
  font-family:&quot;Arial&quot;,&quot;sans-serif&quot;"><a target="_blank" href=""> &nbsp;</a> &nbsp;<o:p></o:p></span></p>
  </td>
 </tr>
</tbody></table>';
return $body ;
}

		


?>
