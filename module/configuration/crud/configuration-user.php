<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Nathalie Portugal
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    
    $action = $_POST['action'];
    if($action=='select'){
        echo "SELECT u.iUseID, u.cUseUse, u.cUseNam, u.cUseDes, u.cUseEma, u.cUseTyp,p.cPerDsc,r.cRolDsc,u.cUseSta FROM tm_user AS u, tm_user_profile AS p, tm_user_role as r WHERE u.iProID=p.iPerID AND u.iRolID=r.iRolID";
        if ($stmt = $mysqli->prepare("SELECT u.iUseID, u.cUseUse, u.cUseNam, u.cUseDes, u.cUseEma, u.cUseTyp,p.cPerDsc,r.cRolDsc,u.cUseSta,u.cUsePas FROM tm_user AS u, tm_user_profile AS p, tm_user_role as r WHERE u.iProID=p.iPerID AND u.iRolID=r.iRolID")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($user_id, $user_user, $user_name, $user_description, $user_email, $user_type, $user_profile,$user_rol,$user_status,$user_pass);
            while($row = $stmt->fetch()) {
                echo $user_status;
                    if($user_status=='1'){$dsc_status='Activo'; $status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-ok" /></a>';}else{$dsc_status='Inactivo';$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-minus" /></a>';}
                    echo '<tr><td><input id="c'.$user_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$user_id.'"  data-user="'.$user_user.'"  data-name="'.$user_name.'"  data-description="'.$user_description.'"  data-mail="'.$user_email.'"  data-type="'.$user_type.'"  data-password="'.$user_pass.'"  data-profile="'.$user_profile.'"  data-rol="'.$user_rol.'" data-status="'.$user_status.'"></td>'.
                       '<td>'.$user_user.'</td>'.
                        '<td>'.$user_name.'</td>'.
                        '<td>'.$user_description.'</td>'.
                        '<td>'.$user_email.'</td>'.
                        '<td>'.$user_profile.'</td>'.
                        '<td>'.$user_rol.'</td>'.
                        '<td>'.$user_type.'</td>'.
                        '<td>'.$status.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$user_id.'"  data-user="'.$user_user.'"  data-name="'.$user_name.'"  data-description="'.$user_description.'"  data-mail="'.$user_email.'"  data-type="'.$user_type.'"  data-profile="'.$user_profile.'"  data-password="'.$user_pass.'"  data-rol="'.$user_rol.'" data-status="'.$user_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
        }
    }else{        
        $user_id = $_POST['id'];
        $user_user = $_POST['user'];
        $user_name = $_POST['name'];
        $user_description = $_POST['description'];
        $user_mail = $_POST['mail'];
        $user_profile = $_POST['profile'];
        $user_role = $_POST['role'];        
        $user_type = $_POST['type'];
        $user_Date = (string)getdate();        
        $user_Act = '1';
        $user_status = $_POST['status'];        
        $user_password = $_POST['password'];
        $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
        $password = hash('sha512', $user_password.$random_salt);
        if($action=='update'){
            if($user_status=='1'){
                $mysqli->query("UPDATE tm_user SET cUseUse='".$user_user."', cUsePas='".$password."', cUseSal='".$random_salt."', cUseNam='".$user_name."', cUseDes='".$user_description."', cUseEma='".$user_mail."', iProID='".$user_profile."', iRolID='".$user_role."', cUseTyp='".$user_type."', cUseSta='".$user_status."', dUseDatUpd='".$user_Date."' WHERE iUseID='".$user_id."'");
            }else{
                $mysqli->query("UPDATE tm_user SET cUseUse='".$user_user."', cUseNam='".$user_name."', cUseDes='".$user_description."', cUseEma='".$user_mail."', iProID='".$user_profile."', iRolID='".$user_role."', cUseTyp='".$user_type."', cUseSta='".$user_status."', dUseDatUpd='".$user_Date."' WHERE iUseID='".$user_id."'");
            }
        }
        else if($action=='insert')
        {
            echo "INSERT INTO tm_user (cUseUse, cUsePas, cUseSal, cUseNam, cUseDes, cUseEma, iProID, iRolID,dUseDatCre,cUseTyp,cUseSta) VALUES ('".$user_user."', '".$password."', '".$random_salt."', '".$user_name."', '".$user_description."', '".$user_mail."', '".$user_profile."', '".$user_role."', '".$user_Date."', '".$user_type."', '".$user_status."'";
            
            $mysqli->query("INSERT INTO tm_user (cUseUse, cUsePas, cUseSal, cUseNam, cUseDes, cUseEma, iProID, iRolID,dUseDatCre,cUseTyp,cUseSta) VALUES ('".$user_user."', '".$password."', '".$random_salt."', '".$user_name."', '".$user_description."', '".$user_mail."', '".$user_profile."', '".$user_role."', '".$user_Date."', '".$user_type."', '".$user_status."')");
        }
        else if($action == 'delete')
        {
            $_id = explode(",", $user_id);
            for($i=0; $i< sizeof($_id) ;$i++){
                $mysqli->query("DELETE FROM tm_user WHERE iUseID='".$_id[$i]."'");
            }
        }
    }