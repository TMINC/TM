<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    include_once '../../../includes/functions.php';
    
    $action = $_POST['action'];
    if($action=='service'){
        if ($stmt = $mysqli->prepare("SELECT numero_servicio, numero_viaje, cliente, calificacion, proveedor, clase_vehiculo, tipo_vehiculo, categoria_vehiculo, placa, chofer1, origen, destino, Fecha_Hra_Plan_Recojo, Fecha_Hra_Real_Recojo, Fecha_Hra_Plan_Llegada, Fecha_Hra_Real_Llegada, Observaciones FROM vtm_report_service_level")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($numero_servicio, $numero_viaje, $cliente, $calificacion, $proveedor, $clase_vehiculo, $tipo_vehiculo, $categoria_vehiculo, $placa, $chofer1, $origen, $destino, $fecha_hora_plan_recojo, $fecha_hora_real_recojo, $fecha_hora_plan_llegada, $fecha_hora_real_llegada, $observaciones);
            while($row = $stmt->fetch()) { 
                echo '<tr><td class="small center">'.$numero_servicio.'</td>'.
                    '<td class="small center">'.$numero_viaje.'</td>'.
                    '<td class="small">'.$cliente.'</td>'.
                    '<td class="small center">'.$calificacion.'</td>'.
                    '<td class="small">'.$proveedor.'</td>'.                            
                    '<td class="small">'.$clase_vehiculo.'</td>'.
                    '<td class="small">'.$tipo_vehiculo.'</td>'.
                    '<td class="small">'.$categoria_vehiculo.'</td>'.
                    '<td class="small center">'.$placa.'</td>'.
                    '<td class="small">'.$chofer1.'</td>'.
                    '<td class="small">'.$origen.'</td>'.
                    '<td class="small">'.$destino.'</td>'.
                    '<td class="small">'.$fecha_hora_plan_recojo.'</td>'.
                    '<td class="small">'.$fecha_hora_real_recojo.'</td>'.                        
                    '<td class="small">'.$fecha_hora_plan_llegada.'</td>'.
                    '<td class="small">'.$fecha_hora_real_llegada.'</td>'.
                    '<td class="small">'.$observaciones.'</td></tr>';
            }
        } 
    }
    if($action=='price'){
        if ($stmt = $mysqli->prepare("SELECT numero_servicio, numero_viaje, cliente, Precio, proveedor, Costo, Margen_S, Margen_P, origen, destino, ruta, Kms_Total, Precio_KM, Costo_KM, Margen_KM, Total, Precio_M3, Costo_M3, Utilid_M3, Ton_Total, Precio_Ton, Costo_Ton, utilid_Ton FROM vtm_report_price_vs_real_cost")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($numero_servicio, $numero_viaje, $cliente, $precio, $proveedor, $costo, $margen_s, $margen_p, $origen, $destino, $ruta, $kms_total, $precio_km, $costo_km, $margen_km, $total, $precio_m3, $costo_m3, $utilid_m3, $ton_total, $precio_ton, $costo_ton, $utilid_ton);
            while($row = $stmt->fetch()) { 
                echo '<tr><td class="small center">'.$numero_servicio.'</td>'.
                    '<td class="small center">'.$numero_viaje.'</td>'.
                    '<td class="small">'.$cliente.'</td>'.
                    '<td class="small" style="text-align:right;">'.number_format($precio,2).'</td>'.
                    '<td class="small">'.$proveedor.'</td>'.                        
                    '<td class="small" style="text-align:right;">'.number_format($costo,2).'</td>'.
                    '<td class="small" style="text-align:right;">'.number_format($margen_s,2).'</td>'.
                    '<td class="small" style="text-align:right;">'.number_format($margen_p,2).'</td>'.
                    '<td class="small">'.$origen.'</td>'.
                    '<td class="small">'.$destino.'</td>'.
                    '<td class="small">'.$ruta.'</td>'.
                    '<td class="small">'.$kms_total.'</td>'.                        
                    '<td class="small" style="text-align:right;">'.number_format($precio_km,2).'</td>'.
                    '<td class="small" style="text-align:right;">'.number_format($costo_km,2).'</td>'.
                    '<td class="small" style="text-align:right;">'.number_format($margen_km,2).'</td>'.                        
                    '<td class="small" style="text-align:right;">'.number_format($total,2).'</td>'.
                    '<td class="small" style="text-align:right;">'.number_format($precio_m3,2).'</td>'.
                    '<td class="small" style="text-align:right;">'.number_format($costo_m3,2).'</td>'.
                    '<td class="small" style="text-align:right;">'.number_format($utilid_m3,2).'</td>'.
                    '<td class="small" style="text-align:right;">'.number_format($ton_total,2).'</td>'.
                    '<td class="small" style="text-align:right;">'.number_format($precio_ton,2).'</td>'.
                    '<td class="small" style="text-align:right;">'.number_format($costo_ton,2).'</td>'.
                    '<td class="small" style="text-align:right;">'.number_format($utilid_ton,2).'</td></tr>';
            }
        } 
    }