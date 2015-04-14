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
        if ($stmt = $mysqli->prepare("SELECT iForID, CONCAT(cForNam,' - ',cForCod) AS find FROM tm_form WHERE cForSta='1'")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($form_id, $form);
            while($row = $stmt->fetch()) {
                if($sel==$form){$selected = " selected";}else{$selected = "";}
                echo '<option value="'.$form_id.'" '.$selected.'>'.$form.'</option>';
            }            
        }
    }else{
        if($action=='select'){
            
            if ($stmt = $mysqli->prepare("SELECT iForID, cForNam, cForCod, cForSta FROM tm_form")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($form_id, $form_name, $form_code, $form_status);
                while($row = $stmt->fetch()) {            
                    if($form_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-ok" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-minus" /></a>';}
                    echo '<tr><td><input id="c'.$form_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$form_id.'"></td>'.
                        '<td>'.$form_id.$status.'</td>'.
                        '<td>'.$form_name.'</td>'.                            
                        '<td>'.$form_code.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$form_id.'" data-name="'.$form_name.'" data-code="'.$form_code.'" data-status="'.$form_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $form_id = $_POST['id'];
           $form_name = $_POST['name'];
           $form_code = $_POST['code'];
           $form_status = $_POST['status'];
           if($_POST['status']=='true'){$form_status=1;}else{$form_status=0;}
           if($action=='insert'){              
               $mysqli->query("INSERT INTO tm_form (cForNam, cForCod, cForSta) VALUES "
                       . "('".$form_name."', '".$form_code."', '".$form_status."')");
           } 
           if($action=='update'){ 
               $mysqli->query("UPDATE tm_form SET cForNam='".$form_name."', cForCod='".$form_code."', cForSta='".$form_status."' WHERE iForID='".$form_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $form_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_form WHERE iForID='".$_id[$i]."'");
               }
           }
        }
    }