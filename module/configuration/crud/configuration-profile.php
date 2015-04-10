<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Nathalie Portugal
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    
    $action = $_POST['action'];
    if($action=='consult'){
        $sel = $_POST['sel'];
        if ($stmt = $mysqli->prepare("SELECT iPerID, cPerDsc, cPerSta AS find FROM tm_user_profile")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($perfil_id, $perfil_dsc, $perfil_sta);
            while($row = $stmt->fetch()) {
                if($sel==$customer){$selected = " selected";}else{$selected = "";}
                echo '<option value="'.$perfil_id.'" '.$selected.'>'.$perfil_dsc.'</option>';
            }            
        }
    }else{
        if($action=='select'){
            echo "SELECT iPerID, cPerDsc, cPerSta FROM tm_user_profile";
            if ($stmt = $mysqli->prepare("SELECT iPerID, cPerDsc, cPerSta FROM tm_user_profile")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($perfil_id, $perfil_dsc, $perfil_sta);
                while($row = $stmt->fetch()) {
                    if($perfil_sta=='1'){$dsc_status='Activo'; $status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-ok" /></a>';}else{$dsc_status='Inactivo';$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-minus" /></a>';}
                    echo '<tr><td><input id="c'.$perfil_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$perfil_id.'" data-description="'.$perfil_dsc.'" data-status="'.$perfil_sta.'"></td>'.
                       '<td>'.$perfil_id.'</td>'.
                        '<td>'.$perfil_dsc.'</td>'.
                        '<td>'.$status.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$perfil_id.'" data-description="'.$perfil_dsc.'" data-status="'.$perfil_sta.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $perfil_id = $_POST['id'];
           $perfil_dsc = $_POST['description'];
           if($_POST['status']=='true'){$perfil_sta=1;}else{$perfil_sta=0;}
           if($action=='insert'){
           $mysqli->query("INSERT INTO tm_user_profile (cPerDsc, cPerSta) VALUES ('".$perfil_dsc."', '".$perfil_sta."')");
           } 
           if($action=='update'){
               $mysqli->query("UPDATE tm_user_profile SET cPerDsc='".$perfil_dsc."' , cPerSta='".$perfil_sta."' WHERE iPerID='".$perfil_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $perfil_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_user_profile WHERE iPerID='".$_id[$i]."'");
               }
           }
        }
    }