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
        if ($stmt = $mysqli->prepare("SELECT iPerID, cPerDsc AS find FROM tm_user_profile WHERE cPerSta='1'")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($perfil_id, $perfil_dsc);
            while($row = $stmt->fetch()) {
                if($sel==$perfil_dsc){$selected = " selected";}else{$selected = "";}
                echo '<option value="'.$perfil_id.'" '.$selected.'>'.$perfil_dsc.'</option>';
            }            
        }
    }
    else if($action=='consultRole'){
        $sel = $_POST['sel'];
        $profile = $_POST['prof'];
        if ($stmt = $mysqli->prepare("SELECT iRolID, cRolDsc AS find FROM tm_user_role WHERE iPerID='".$profile."'")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($perfil_id, $perfil_dsc);
            while($row = $stmt->fetch()) {
                if($sel==$perfil_dsc){$selected = " selected";}else{$selected = "";}
                echo '<option value="'.$perfil_id.'" '.$selected.'>'.$perfil_dsc.'</option>';
            }            
        }
    }
    else{
        if($action=='select'){
            echo "SELECT r.iRolID,r.iPerID,r.cRolDsc,p.cPerDsc,r.cRolSta FROM tm_user_role as r, tm_user_profile as p WHERE p.iPerID=r.iPerID";
            if ($stmt = $mysqli->prepare("SELECT r.iRolID,r.iPerID,r.cRolDsc,p.cPerDsc,r.cRolSta FROM tm_user_role as r, tm_user_profile as p WHERE p.iPerID=r.iPerID")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($rol_id,$perfil_id,$rol_dsc, $per_dsc, $rol_sta);
                while($row = $stmt->fetch()) {
                    if($rol_sta=='1'){$dsc_status='Activo'; $status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-ok" /></a>';}else{$dsc_status='Inactivo';$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-minus" /></a>';}
                    echo '<tr><td><input id="c'.$rol_id.$perfil_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$perfil_id.$perfil_id.'" data-Rid="'.$rol_id.'" data-Pid="'.$perfil_id.'"  data-description="'.$rol_dsc.'" data-status="'.$rol_sta.'"></td>'.
                        '<td>'.$rol_id.'</td>'.
                        '<td>'.$perfil_id.'</td>'.
                        '<td>'.$rol_dsc.'</td>'.
                        '<td>'.$per_dsc.'</td>'.
                        '<td>'.$status.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$rol_id.$perfil_id.'" data-status="'.$rol_sta.'" data-Rid="'.$rol_id.'" data-Pid="'.$perfil_id.'"  data-description="'.$rol_dsc.'" data-Pdescription="'.$per_dsc.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $rol_id = $_POST['Rid'];
           $perfil_id = $_POST['Pid'];
           $rol_dsc = $_POST['description'];
           if($_POST['status']=='true'){$rol_sta=1;}else{$rol_sta=0;}
           if($action=='insert'){
           $mysqli->query("INSERT INTO tm_user_role (iPerID, cRolDsc, cRolSta) VALUES ('".$perfil_id."', '".$rol_dsc."', '".$rol_sta."')");
           } 
           if($action=='update'){
               $mysqli->query("UPDATE tm_user_role SET iPerID='".$perfil_id."' , cRolDsc='".$rol_dsc."' , cRolSta='".$rol_sta."' WHERE iRolID='".$rol_id."'");
           }
           if($action=='delete'){
               $_Rid = explode(",", $rol_id);
               $_Pid = explode(",", $perfil_id);
               for($i=0; $i< sizeof($_Rid) ;$i++){
                    $mysqli->query("DELETE FROM tm_user_role WHERE iPerID='".$_Pid[$i]."' AND iRolID ='".$_Rid[$i]."'");
               }
           }
        }
    }