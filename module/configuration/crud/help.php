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
                    if($help_level=='1'){$level='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="BAJA"><i class="glyphicon glyphicon-stats" /></a>';}
                    if($help_level=='2'){$level='<a class="hint--left hint--warning" style="float:right;cursor:pointer;" data-hint="NORMAL"><i class="glyphicon glyphicon-stats" /></a>';}
                    if($help_level=='3'){$level='<a class="hint--left hint--info" style="float:right;cursor:pointer;" data-hint="ALTA"><i class="glyphicon glyphicon-stats" /></a>';}
                    if($help_level=='4'){$level='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="URGENTE"><i class="glyphicon glyphicon-stats" /></a>';}                    
                    if($help_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Abierto"><i class="glyphicon glyphicon-tag" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Cerrado"><i class="glyphicon glyphicon-tag" /></a>';}
                    $help_reply = '<a class="hint--right hint--info" style="float:right;cursor:pointer;" data-hint="'.views($help_id,$mysqli).'"><i class="glyphicon glyphicon-comment" /></a>';
                    echo'<tr><td><img src="img/details_open.png" style="cursor:pointer;" data-id="'.$help_id.'"></td>'. 
                        '<td><input id="c'.$help_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$help_id.'"></td>'.
                        '<td>'.$help_id.$status.'</td>'.
                        '<td>'.$help_user.'</td>'.                            
                        '<td>'.$help_form_id.'-'.$help_form_name.$level.'</td>'.
                        '<td>'.$help_text.$help_reply.'</td>'.
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
               $mysqli->query("INSERT INTO tm_help (cHelUsa, iForID, iHelLevID, cHelTex, cHelSta) VALUES ('".$help_user."', '".$help_form_id."', '".$help_level."', '".$help_text."', '".$help_status."')");
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
    }
     if($action=='review'){ 
        $help_count = $_POST['count'];
        $help_reply_id = $_POST['reply_id'];
        $mysqli->query("UPDATE tm_help_reply SET cHelRepRev='".$help_count."' WHERE iHelRepID='".$help_reply_id."'");
    }
    if($action=='reply'){
            $help = $_POST['help'];
            if ($stmt = $mysqli->prepare("SELECT iHelRepID, iHelID, cHelRepDes, cHelRepRev, iUseID, dHelRepDat FROM tm_help_reply WHERE iHelID = ".$help)){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($help_reply_id, $help_id, $help_reply_description, $help_reply_reviews, $user_id, $help_reply_date);
                while($row = $stmt->fetch()) {   
                    $_user=user_char($user_id, $mysqli);
                    echo '<tr><td><i class="glyphicon glyphicon-user" style="margin-right:5px;"></i> '.$_user.'</td>'.
                        '<td>'.$help_reply_date.'</td>'.
                        '<td>'.$help_reply_description.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="like hint--left hint--info" data-hint="Votos" data-id="'.$help_reply_id.'" data-review="'.$help_reply_reviews.'"><i class="glyphicon glyphicon-thumbs-up"></i></a><span class="label label-info" style="margin-left:5px;font-size:10px;">'.$help_reply_reviews.'</span>'.                            
                        '</td></tr>';                  
                }
            }
        }