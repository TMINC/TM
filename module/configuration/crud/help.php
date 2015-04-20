<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    include_once '../../../includes/functions.php';    
    
    $action = $_POST['action'];
    if($action=='consult'){
        $sel = $_POST['sel'];
        if ($stmt = $mysqli->prepare("SELECT iHelID FROM tm_help WHERE cHelSta='1'")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($help_id);
            while($row = $stmt->fetch()) {
                if($sel==$help_id){$selected = " selected";}else{$selected = "";}
                echo '<option value="'.$help_id.'" '.$selected.'>'.$help_id.'</option>';
            }            
        }
    }else{
        if($action=='select'){
            echo "SELECT iHelID, cHelUsa, fo.iForID, fo.cForNam, iHelLevID, cHelTex, cHelSta FROM tm_help AS hp, tm_form AS fo WHERE hp.iForID=fo.iForID";
            if ($stmt = $mysqli->prepare("SELECT iHelID, cHelUsa, fo.iForID, fo.cForNam, iHelLevID, cHelTex, cHelSta FROM tm_help AS hp, tm_form AS fo WHERE hp.iForID=fo.iForID")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($help_id, $help_user, $help_form_id, $help_form_name, $help_level, $help_text, $help_status);
                while($row = $stmt->fetch()) {
                    if($help_level=='1'){$level='BAJA';}
                    if($help_level=='2'){$level='NORMAL';}
                    if($help_level=='3'){$level='ALTA';}
                    if($help_level=='4'){$level='URGENTE';}                    
                if($help_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-ok" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-minus" /></a>';}
                    echo'<tr><td><img src="img/details_open.png" style="cursor:pointer;" data-id="'.$help_id.'"></td>'. 
                        '<td><input id="c'.$help_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$help_id.'"></td>'.
                        '<td>'.$help_id.$status.'</td>'.
                        '<td>'.$help_user.'</td>'.                            
                        '<td>'.$help_form_id.'-'.$help_form_name.'</td>'.
                        '<td>'.$level.'</td>'.
                        '<td>'.$help_text.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$help_id.'" data-user="'.$help_user.'" data-form_id="'.$help_form_id.'" data-form_name="'.$help_form_name.'" data-level="'.$help_level.'" data-text="'.$help_text.'" data-status="'.$help_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $help_id = $_POST['id'];
           $help_user = $_POST['user'];
           $help_form_id = $_POST['form_id'];
           $help_level = $_POST['level'];
           $help_text = $_POST['text'];
           $help_status = $_POST['status'];
           if($_POST['status']=='true'){$help_status=1;}else{$help_status=0;}
           if($action=='insert'){   
               echo "INSERT INTO tm_help (cHelUsa, iForID, iHelLevID, cHelTex, cHelSta)  VALUES ('".$help_user."', '".$help_form_id."', '".$help_level."', '".$help_text."', '".$help_status."')";
               $mysqli->query("INSERT INTO tm_help (cHelUsa, iForID, iHelLevID, cHelTex, cHelSta)  VALUES ('".$help_user."', '".$help_form_id."', '".$help_level."', '".$help_text."', '".$help_status."')");
           } 
           if($action=='update'){ 
               $mysqli->query("UPDATE tm_help SET cHelUsa='".$help_user."', iForID='".$help_form_id."', iHelLevID='".$help_level."', cHelTex='".$help_text."', cHelSta='".$help_status."' WHERE iHelID='".$help_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $help_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_help WHERE iHelID='".$_id[$i]."'");
               }
           }
        }
        
         if($action=='reply'){
            $help = $_POST['help'];
            if ($stmt = $mysqli->prepare("SELECT iHelRepID, iHelID, cHelRepDes, cHelRepRev, iUseID FROM tm_help_reply WHERE iHelID = ".$help)){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($help_reply_id, $help_id, $help_reply_description, $help_reply_reviews, $user_id);
                while($row = $stmt->fetch()) {   
                    $_user=user_char($user_id, $mysqli);
                    echo '<tr><td>'.$_user.'</td>'.
                        '<td>'.$help_reply_description.'</td>'.
                        '<td>'.$help_reply_reviews.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;margin-right:15px;" class="like hint--left" data-hint="Me sirvio" data-id="'.$help_reply_id.'"><i class="glyphicon glyphicon-thumbs-up"></i></a>'.
                            '<a style="cursor:pointer;" class="edit_date hint--left" data-hint="Editar" data-id="'.$help_reply_id.'" data-id="'.$help_id.'" data-help_reply_description="'.$help_reply_description.'" data-help_reply_reviews="'.$help_reply_reviews.'"><i class="glyphicon glyphicon-edit" /></a>'.
                        '</td></tr>';                  
                }
            }
        }
        
    }