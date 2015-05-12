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
        if ($stmt = $mysqli->prepare("SELECT iCenID, cCenNam FROM tm_center WHERE cCenSta='1'")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($center_id, $center_name);
            while($row = $stmt->fetch()) {
                if($sel==$center_id){$selected = " selected";}else{$selected = "";}
                echo '<option value="'.$center_id.'" '.$selected.'>'.$center_name.'</option>';
            }            
        }
    }else{
        if($action=='select'){
            if ($stmt = $mysqli->prepare("SELECT iCenID, cCenNam, iCenTyp, cCenAdd, cCenLat, cCenLon, cs.iCusID, cs.cCusNam, cCenSta FROM tm_center AS c, tm_customer AS cs WHERE c.iCusID=cs.iCusID")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($center_id, $center_name, $center_type, $center_address, $center_latitud, $center_longitud, $customer_id, $customer_name, $center_status);
                while($row = $stmt->fetch()) {
                    if($center_type=='1'){$type="CENTRO DE ACOPIO";}if($center_type=='2'){$type="PLANTA";}if($center_type=='3'){$type="PUERTO DESTINO";}
                    if($center_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-ok" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-minus" /></a>';}
                    echo '<tr><td><input id="c'.$center_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$center_id.'"></td>'.
                        '<td>'.$center_id.$status.'</td>'.
                        '<td>'.$center_name.'</td>'.
                        '<td>'.$type.'</td>'.
                        '<td>'.$center_address.'<a style="cursor:help;float:right;" class="pop_over hint--right hint--info" data-hint="Detalle" data-content="&measuredangle;: '.$center_latitud.', '.$center_longitud.'" title="'.$center_name.'" data-placement="left"><i class="glyphicon glyphicon-map-marker"/></a></td>'.
                        '<td>'.$customer_name.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$center_id.'" data-name="'.$center_name.'" data-address="'.$center_address.'" data-type="'.$center_type.'" data-latitud="'.$center_latitud.'" data-longitud="'.$center_longitud.'" data-customer="'.$customer_id.'" data-status="'.$center_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $center_id = $_POST['id'];
           $center_name = $_POST['name'];
           $center_address = $_POST['address'];
           $center_type = $_POST['type'];
           $center_latitud = $_POST['latitud'];
           $center_longitud = $_POST['longitud'];
           $customer_id = $_POST['customer'];
           if($_POST['status']=='true'){$center_status=1;}else{$center_status=0;}
           if($action=='insert'){
               $mysqli->query("INSERT INTO tm_center (cCenNam, iCenTyp, cCenAdd, cCenLat, cCenLon, iCusID, cCenSta) VALUES ('".$center_name."', '".$center_type."', '".$center_address."', '".$center_latitud."', '".$center_longitud."', '".$customer_id."', '".$center_status."')");
           } 
           if($action=='update'){
               $mysqli->query("UPDATE tm_center SET cCenNam='".$center_name."' , iCenTyp='".$center_type."', cCenAdd='".$center_address."', cCenLat='".$center_latitud."', cCenLon='".$center_longitud."', iCusID='".$customer_id."', cCenSta='".$center_status."' WHERE iCenID='".$center_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $center_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_center WHERE iCenID='".$_id[$i]."'");
               }
           }
        }
    }