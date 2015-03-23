<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    
    $action = $_POST['action'];
    if($action=='consult'){
        $sel = $_POST['sel'];
        $type_measure = $_POST['type'];
        if ($stmt = $mysqli->prepare("SELECT iMeaID, CONCAT(cMeaAbr,' - ',cMeaDes) AS find FROM tm_measure WHERE cMeaSta='1' AND cMeaTyp = ?")){
            $stmt->bind_param('s', $type_measure);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($measure_id, $measure);
            while($row = $stmt->fetch()) {
                if($sel==$measure_id){$selected = " selected";}else{$selected = "";}
                echo '<option value="'.$measure_id.'" '.$selected.'>'.$measure.'</option>';
            }            
        }
    }else{
        if($action=='select'){
            if ($stmt = $mysqli->prepare("SELECT iMeaID, cMeaAbr, cMeaDes, cMeaTyp, cMeaSta FROM tm_measure")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($measure_id, $measure_abbreviation, $measure_description, $measure_type, $measure_status);
                while($row = $stmt->fetch()) {
                    if($measure_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-check" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-unchecked" /></a>';}
                    if($measure_type=='1'){$type='LONGITUD';}if($measure_type=='2'){$type='VOLUMEN';}if($measure_type=='3'){$type='MASA';}if($measure_type=='4'){$type='TIEMPO';}if($measure_type=='5'){$type='SUPERFICIE';}if($measure_type=='6'){$type='MONEDA';}
                    echo '<tr><td><input id="c'.$measure_id.'" name="row_sel" type="checkbox" class="row_sel" data-id="'.$measure_id.'"></td>'.
                        '<td>'.$measure_id.$status.'</td>'.
                        '<td>'.$measure_abbreviation.'</td>'.
                        '<td>'.$measure_description.'</td>'.
                        '<td>'.$type.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$measure_id.'" data-abbreviation="'.$measure_abbreviation.'" data-description="'.$measure_description.'" data-type="'.$measure_type.'" data-status="'.$measure_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $measure_id = $_POST['id'];
           $measure_abbreviation = $_POST['abbreviation'];
           $measure_description = $_POST['description'];
           $measure_type = $_POST['type'];
           if($_POST['status']=='true'){$measure_status=1;}else{$measure_status=0;}
           if($action=='insert'){
               $mysqli->query("INSERT INTO tm_measure (cMeaAbr, cMeaDes, cMeaTyp, cMeaSta) VALUES ('".$measure_abbreviation."', '".$measure_description."', '".$measure_type."', '".$measure_status."')");
           } 
           if($action=='update'){
               $mysqli->query("UPDATE tm_measure SET cMeaAbr='".$measure_abbreviation."' , cMeaDes='".$measure_description."', cMeaTyp='".$measure_type."', cMeaSta='".$measure_status."' WHERE iMeaID='".$measure_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $measure_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_measure WHERE iMeaID='".$_id[$i]."'");
               }
           }
        }
    }