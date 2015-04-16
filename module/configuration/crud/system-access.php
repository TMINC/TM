<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Nathalie Portugal
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    
    $action = $_POST['action'];
    if($action=='consult'){
        $rol_id = $_POST['id'];
        if ($stmt = $mysqli->prepare("SELECT f.iForID, f.cForNam FROM tm_form as f,tm_system_access as a  WHERE f.iForID=a.iForID AND a.iRolID='".$rol_id."'")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($form_id, $form_dsc);
            while($row = $stmt->fetch()) {
               echo $form_id.",";
            }
        }
    }
    else if($action=='consultAll'){
        $data_rol = $_POST['dataRol'];        
        if ($stmt = $mysqli->prepare("SELECT f.iForID, f.cForNam FROM tm_form as f WHERE f.cForSta='1'")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($form_id, $form_dsc);
            while($row = $stmt->fetch()) {
                $inserta = true;
                $_id = explode(",", $data_rol);
                for($i=0; $i< sizeof($_id) ;$i++){
                    if($_id[$i]==$form_id){
                        $inserta=false;
                        break;
                    } 
                }
                if($inserta){echo '<option value="'.$form_id.'">'.$form_dsc.'</option>';}
                else{echo '<option selected value="'.$form_id.'">'.$form_dsc.'</option>';}  
            }            
        }
    }
    else{
        if($action=='select'){
            echo "SELECT r.iRolID, p.cPerDsc,r.cRolDsc,r.cRolSta FROM tm_user_role as r, tm_user_profile as p WHERE p.iPerID=r.iPerID";
            if ($stmt = $mysqli->prepare("SELECT r.iRolID, p.cPerDsc,r.cRolDsc,r.cRolSta FROM tm_user_role as r, tm_user_profile as p WHERE p.iPerID=r.iPerID AND r.cRolSta='1'")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($rol_id,$perfil_dsc,$rol_dsc, $rol_sta);
                while($row = $stmt->fetch()) {
                    if($rol_sta=='1'){$dsc_status='Activo'; $status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-ok" /></a>';}else{$dsc_status='Inactivo';$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-minus" /></a>';}
                    echo '<tr><td><input id="c'.$rol_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$rol_id.'"  data-pdescription="'.$perfil_dsc.'"  data-description="'.$rol_dsc.'" data-status="'.$rol_sta.'"></td>'.
                        '<td>'.$rol_id.'</td>'.
                        '<td>'.$perfil_dsc.'</td>'.
                        '<td>'.$rol_dsc.'</td>'.
                        '<td>'.$status.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$rol_id.'"  data-pdescription="'.$perfil_dsc.'"  data-description="'.$rol_dsc.'" data-status="'.$rol_sta.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $rol_id = $_POST['id'];
           $access = $_POST['access_id'];
           echo $rol_id."----".$access;
           if($action=='update'){
               $_access = explode(",", $access);
               $mysqli->query("DELETE FROM tm_system_access WHERE iRolID='".$rol_id."'");
               for($i=0; $i< sizeof($_access) ;$i++){                   
                    $mysqli->query("INSERT INTO tm_system_access (iRolID, iForID) VALUES ('".$rol_id."', '".$_access[$i]."')");
               }
           }
        }
    }