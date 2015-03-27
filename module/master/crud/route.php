<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    
    $action = $_POST['action'];
    if($action=='consult'){
        $sel = $_POST['sel'];
        if ($stmt = $mysqli->prepare("SELECT iRouID, cRouNam FROM tm_route WHERE cRouSta='1'")){
           $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($route_id, $route_name);
            while($row = $stmt->fetch()) {
                if($sel==$route_id){$selected = " selected";}else{$selected = "";}
                echo '<option value="'.$route_id.'" '.$selected.'>'.$route_name.'</option>';
            }            
        }
    }else{
        if($action=='select'){
            if ($stmt = $mysqli->prepare("SELECT iRouID, cRouNam, cRouOri, cRouDes, cRouKil, cRouTim, cRouSta FROM tm_route")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($route_id, $route_name, $route_origin, $route_destination, $route_kilometers, $route_time, $route_status);
                while($row = $stmt->fetch()) {
                    if($route_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-ok" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-minus" /></a>';}
                    echo '<tr><td><input id="c'.$route_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$route_id.'"></td>'.
                        '<td>'.$route_id.$status.'</td>'.
                        '<td>'.$route_name.'</td>'.
                        '<td>'.$route_origin.'</td>'.
                        '<td>'.$route_destination.'</td>'.
                        '<td>'.$route_kilometers.'</td>'.
                        '<td>'.$route_time.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$route_id.'" data-name="'.$route_name.'" data-origin="'.$route_origin.'" data-destination="'.$route_destination.'" data-kilometers="'.$route_kilometers.'" data-time="'.$route_time.'" data-status="'.$route_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $route_id = $_POST['id'];
           $route_name = $_POST['name'];
           $route_origin = $_POST['origin'];
           $route_destination = $_POST['destination'];
           $route_kilometers = $_POST['kilometers'];
           $route_time = $_POST['time'];
           if($_POST['status']=='true'){$route_status=1;}else{$route_status=0;}
           if($action=='insert'){
               echo "INSERT INTO tm_route (cRouNam, cRouOri, cRouDes, cRouKil, cRouTim, cRouSta) VALUES ('".$route_name."', '".$route_origin."', '".$route_destination."', '".$route_kilometers."', '".$route_time."', '".$route_status."')";
               $mysqli->query("INSERT INTO tm_route (cRouNam, cRouOri, cRouDes, cRouKil, cRouTim, cRouSta) VALUES ('".$route_name."', '".$route_origin."', '".$route_destination."', '".$route_kilometers."', '".$route_time."', '".$route_status."')");
           } 
           if($action=='update'){
               $mysqli->query("UPDATE tm_route SET cRouNam='".$route_name."' , cRouOri='".$route_origin."', cRouDes='".$route_destination."', cRouKil='".$route_kilometers."', cRouTim='".$route_time."', cRouSta='".$route_status."' WHERE iRouID='".$route_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $route_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_route WHERE iRouID='".$_id[$i]."'");
               }
           }
        }
    }