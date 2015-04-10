<?php
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
?>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <h3 class="heading"><i class="glyphicon icon-truck"></i>SERVICIO(S)-TRANSPORTE</h3>
            <div class="clearfix sepH_b">
                <div class="btn-group col_vis_menu">
                    <a href="#" data-toggle="dropdown" class="btn dropdown-toggle btn-default">COLUMNAS <span class="caret"></span></a>
                    <ul class="dropdown-menu tableMenu" id="dt_maintenance_nav">
                        <li><div class="checkbox"><label class="" for="dt_col_1"><input type="checkbox" value="0" id="dt_col_1" name="toggle-cols" checked="checked" class="uni_style"/> &hookrightarrow;</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_2"><input type="checkbox" value="1" id="dt_col_2" name="toggle-cols" checked="checked" class="uni_style"/> &check;</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_3"><input type="checkbox" value="2" id="dt_col_3" name="toggle-cols" checked="checked" class="uni_style"/> NRO.ORDEN</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_4"><input type="checkbox" value="3" id="dt_col_4" name="toggle-cols" checked="checked" class="uni_style"/> TIPO SERVICIO</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_5"><input type="checkbox" value="4" id="dt_col_5" name="toggle-cols" checked="checked" class="uni_style"/> CLIENTE</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_6"><input type="checkbox" value="5" id="dt_col_6" name="toggle-cols" checked="checked" class="uni_style"/> VOLUMEN</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_7"><input type="checkbox" value="6" id="dt_col_7" name="toggle-cols" checked="checked" class="uni_style"/> PESO</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_8"><input type="checkbox" value="7" id="dt_col_8" name="toggle-cols" checked="checked" class="uni_style"/> DISTANCIA</label></div></li>                        
                    </ul>
                </div>
                <!-- actions for datatables -->
                <div class="dt_maintenance_actions pull-left">
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn dropdown-toggle btn-default">ACCIONES <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0);" class="plan"><i class="glyphicon glyphicon-thumbs-up"></i> PLANIFICAR</a></li>
                            <li><a href="javascript:void(0);" class="set_free" data-tableid="dt_maintenance"><i class="glyphicon glyphicon-flag"></i> LIBERAR</a></li>
                            <li><a href="javascript:void(0);" class="refuse" data-tableid="dt_maintenance"><i class="glyphicon glyphicon-thumbs-down"></i> RECHAZAR</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <table class="table table-striped table-bordered dTableR" id="dt_maintenance">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th class="center" style="width: 120px;">NRO.ORDEN</th>
                        <th class="center">CLIENTE</th>
                        <th class="center">TIPO SERVICIO</th>
                        <th class="center">VOLUMEN</th>
                        <th class="center">&nbsp;&nbsp;&nbsp;PESO&nbsp;&nbsp;&nbsp;</th>
                        <th class="center">DISTANCIA</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
<!-- Editar Citas -->
    <div class="modal" id="modal_date">
        <div class="modal-dialog">
            <div class="modal-content">        
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">Ã—</button>
                    <h3><i class="glyphicon glyphicon-file" style="margin-top: 3px;font-size:15px;"></i> EDICI&Oacute;N</h3>
                </div>
                <div class="modal-body">
                    <form id="validation_date_form">
                        <table class="table table-bordered">
                            <tr>
                                <td><b>NRO.SOLICITUD :</b></td>
                                <td colspan="2"><input class="form-control" readonly="true" type="text" id="editDateId"></td>
                            </tr>
                            <tr class="hidden">
                                <td><b>ID :</b></td>
                                <td colspan="2"><input class="form-control" readonly="true" type="text" id="editOrderDateId"></td>
                            </tr>                            
                            <tr>
                                <td><b>FECHA - HORA (ORIGEN):</b></td>
                                <td class="form-group" style="width: 50%;">
                                    <div id="dateOriginDate" class="input-group date">
                                        <input class="form-control" type="text" readonly="" id="editDateOriginDate" name="editDateOriginDate">
                                        <span class="input-group-addon"><i class="splashy-calendar_day_up"></i></span>
                                    </div>
                                </td>
                                <td class="form-group">                        
                                    <div class="input-group bootstrap-timepicker">
                                        <input class="form-control" type="text" id="editDateOriginHour" name="editDateOriginHour" readonly="true">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                </td>
                            </tr>                            
                            <tr>
                                <td><b>FECHA - HORA (DESTINO):</b></td>
                                <td class="form-group">
                                    <div id="dateDestinationDate" class="input-group date">
                                        <input class="form-control" type="text" readonly="" id="editDateDestinationDate" name="editDateDestinationDate">
                                        <span class="input-group-addon"><i class="splashy-calendar_day_down"></i></span>
                                    </div>
                                </td>
                                <td class="form-group">                        
                                    <div class="input-group bootstrap-timepicker">
                                        <input class="form-control" type="text" id="editDateDestinationHour" name="editDateDestinationHour" readonly="true">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hide">
                                <td><b>ACCI&Oacute;N :</b></td>
                                <td colspan="2"><input class="form-control" type="text" id="editDateAction"></td>
                            </tr> 
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-primary" id="save_date"><i class="glyphicon glyphicon-saved"></i> GUARDAR</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal" id="plan">
        <div class="modal-dialog" style="width:80%;">
            <div class="modal-content">        
                <div class="modal-header">
                    <button class="close hidden" data-dismiss="modal">×</button>
                    <h3><i class="glyphicon glyphicon-file" style="margin-top: 3px;font-size:15px;"></i> PLANIFICACI&Oacute;N DE TRANSPORTE</h3>
                </div>
                <div class="modal-body">
                    <form id="validation_adjudication_direct">
                        <table class="table table-bordered">
                            <tr>
                                <td><b>NRO.PLANIFICACI&Oacute;N :</b></td>
                                <td class="form-group"><input class="form-control" readonly="true" type="text" id="editPlanId" name="editPlanId"></td>
                            </tr>
                            <tr>
                                <td><b>NRO.PEDIDO(S) :</b></td>
                                <td class="form-group"><input class="form-control" readonly="true" type="text" id="editPlanOrderId" name="editPlanOrderId"></td>
                            </tr>
                            <tr>
                                <td><b>CANTIDAD DE TRANSPORTE(S) :</b></td>
                                <td>
                                    <select id="searchable" multiple="multiple">
                                        <optgroup label="Africa"><option value="DZ">Algeria</option><option value="AO">Angola</option><option value="BJ">Benin</option><option value="BW">Botswana</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="CM">Cameroon</option><option value="CV">Cape Verde</option><option value="CF">Central African Republic</option><option value="TD">Chad</option><option value="KM">Comoros</option><option value="CD">Congo [DRC]</option><option value="CG">Congo [Republic]</option><option value="DJ">Djibouti</option><option value="EG">Egypt</option><option value="GQ">Equatorial Guinea</option><option value="ER">Eritrea</option><option value="ET">Ethiopia</option><option value="GA">Gabon</option><option value="GM">Gambia</option><option value="GH">Ghana</option><option value="GN">Guinea</option><option value="GW">Guinea-Bissau</option><option value="CI">Ivory Coast</option><option value="KE">Kenya</option><option value="LS">Lesotho</option><option value="LR">Liberia</option><option value="LY">Libya</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="ML">Mali</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="YT">Mayotte</option><option value="MA">Morocco</option><option value="MZ">Mozambique</option><option value="NA">Namibia</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="RW">Rwanda</option><option value="RE">Réunion</option><option value="SH">Saint Helena</option><option value="SN">Senegal</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SO">Somalia</option><option value="ZA">South Africa</option><option value="SD">Sudan</option><option value="SZ">Swaziland</option><option value="ST">São Tomé and Príncipe</option><option value="TZ">Tanzania</option><option value="TG">Togo</option><option value="TN">Tunisia</option><option value="UG">Uganda</option><option value="EH">Western Sahara</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option></optgroup><optgroup label="Antarctica"><option value="AQ">Antarctica</option><option value="BV">Bouvet Island</option><option value="TF">French Southern Territories</option><option value="HM">Heard Island and McDonald Island</option><option value="GS">South Georgia and the South Sandwich Islands</option></optgroup><optgroup label="Asia"><option value="AF">Afghanistan</option><option value="AM">Armenia</option><option value="AZ">Azerbaijan</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BT">Bhutan</option><option value="IO">British Indian Ocean Territory</option><option value="BN">Brunei</option><option value="KH">Cambodia</option><option value="CN">China</option><option value="CX">Christmas Island</option><option value="CC">Cocos [Keeling] Islands</option><option value="GE">Georgia</option><option value="HK">Hong Kong</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Iran</option><option value="IQ">Iraq</option><option value="IL">Israel</option><option value="JP">Japan</option><option value="JO">Jordan</option><option value="KZ">Kazakhstan</option><option value="KW">Kuwait</option><option value="KG">Kyrgyzstan</option><option value="LA">Laos</option><option value="LB">Lebanon</option><option value="MO">Macau</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="MN">Mongolia</option><option value="MM">Myanmar [Burma]</option><option value="NP">Nepal</option><option value="KP">North Korea</option><option value="OM">Oman</option><option value="PK">Pakistan</option><option value="PS">Palestinian Territories</option><option value="PH">Philippines</option><option value="QA">Qatar</option><option value="SA">Saudi Arabia</option><option value="SG">Singapore</option><option value="KR">South Korea</option><option value="LK">Sri Lanka</option><option value="SY">Syria</option><option value="TW">Taiwan</option><option value="TJ">Tajikistan</option><option value="TH">Thailand</option><option value="TR">Turkey</option><option value="TM">Turkmenistan</option><option value="AE">United Arab Emirates</option><option value="UZ">Uzbekistan</option><option value="VN">Vietnam</option><option value="YE">Yemen</option></optgroup><optgroup label="Europe"><option value="AL">Albania</option><option value="AD">Andorra</option><option value="AT">Austria</option><option value="BY">Belarus</option><option value="BE">Belgium</option><option value="BA">Bosnia and Herzegovina</option><option value="BG">Bulgaria</option><option value="HR">Croatia</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="DK">Denmark</option><option value="EE">Estonia</option><option value="FO">Faroe Islands</option><option value="FI">Finland</option><option value="FR">France</option><option value="DE">Germany</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GG">Guernsey</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IE">Ireland</option><option value="IM">Isle of Man</option><option value="IT">Italy</option><option value="JE">Jersey</option><option value="XK">Kosovo</option><option value="LV">Latvia</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MK">Macedonia</option><option value="MT">Malta</option><option value="MD">Moldova</option><option value="MC">Monaco</option><option value="ME">Montenegro</option><option value="NL">Netherlands</option><option value="NO">Norway</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="RO">Romania</option><option value="RU">Russia</option><option value="SM">San Marino</option><option value="RS">Serbia</option><option value="CS">Serbia and Montenegro</option><option value="SK">Slovakia</option><option value="SI">Slovenia</option><option value="ES">Spain</option><option value="SJ">Svalbard and Jan Mayen</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="UA">Ukraine</option><option value="GB">United Kingdom</option><option value="VA">Vatican City</option><option value="AX">Åland Islands</option></optgroup><optgroup label="North America"><option value="AI">Anguilla</option><option value="AG">Antigua and Barbuda</option><option value="AW">Aruba</option><option value="BS">Bahamas</option><option value="BB">Barbados</option><option value="BZ">Belize</option><option value="BM">Bermuda</option><option value="BQ">Bonaire, Saint Eustatius and Saba</option><option value="VG">British Virgin Islands</option><option value="CA">Canada</option><option value="KY">Cayman Islands</option><option value="CR">Costa Rica</option><option value="CU">Cuba</option><option value="CW">Curacao</option><option value="DM">Dominica</option><option value="DO">Dominican Republic</option><option value="SV">El Salvador</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GP">Guadeloupe</option><option value="GT">Guatemala</option><option value="HT">Haiti</option><option value="HN">Honduras</option><option value="JM">Jamaica</option><option value="MQ">Martinique</option><option value="MX">Mexico</option><option value="MS">Montserrat</option><option value="AN">Netherlands Antilles</option><option value="NI">Nicaragua</option><option value="PA">Panama</option><option value="PR">Puerto Rico</option><option value="BL">Saint Barthélemy</option><option value="KN">Saint Kitts and Nevis</option><option value="LC">Saint Lucia</option><option value="MF">Saint Martin</option><option value="PM">Saint Pierre and Miquelon</option><option value="VC">Saint Vincent and the Grenadines</option><option value="SX">Sint Maarten</option><option value="TT">Trinidad and Tobago</option><option value="TC">Turks and Caicos Islands</option><option value="VI">U.S. Virgin Islands</option><option value="US">United States</option></optgroup><optgroup label="South America"><option value="AR">Argentina</option><option value="BO">Bolivia</option><option value="BR">Brazil</option><option value="CL">Chile</option><option value="CO">Colombia</option><option value="EC">Ecuador</option><option value="FK">Falkland Islands</option><option value="GF">French Guiana</option><option value="GY">Guyana</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="SR">Suriname</option><option value="UY">Uruguay</option><option value="VE">Venezuela</option></optgroup><optgroup label="Oceania"><option value="AS">American Samoa</option><option value="AU">Australia</option><option value="CK">Cook Islands</option><option value="TL">East Timor</option><option value="FJ">Fiji</option><option value="PF">French Polynesia</option><option value="GU">Guam</option><option value="KI">Kiribati</option><option value="MH">Marshall Islands</option><option value="FM">Micronesia</option><option value="NR">Nauru</option><option value="NC">New Caledonia</option><option value="NZ">New Zealand</option><option value="NU">Niue</option><option value="NF">Norfolk Island</option><option value="MP">Northern Mariana Islands</option><option value="PW">Palau</option><option value="PG">Papua New Guinea</option><option value="PN">Pitcairn Islands</option><option value="WS">Samoa</option><option value="SB">Solomon Islands</option><option value="TK">Tokelau</option><option value="TO">Tonga</option><option value="TV">Tuvalu</option><option value="UM">U.S. Minor Outlying Islands</option><option value="VU">Vanuatu</option><option value="WF">Wallis and Futuna</option></optgroup>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;width: 80px;">ASIG.TRANS.</th>
                                                <th style="text-align: center;">NRO.</th>
                                                <th style="text-align: center;">ORIGEN</th>
                                                <th style="text-align: center;">DESTINO</th>
                                                <th style="text-align: center;">TRANSPORTISTA</th>
                                                <th style="text-align: center;">ADJUDICACI&Oacute;N</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <a class="plan_trip hint--left hint--info" data-hint="Asignaci&oacute;n de Transporte" ><i class="glyphicon glyphicon-pencil"></i></a>
                                                </td>
                                                <td>0001</td>
                                                <td>LIMA <a class="pop_over hint--left hint--info" data-placement="right" data-content="21/10/2015 04:00" data-hint="Cita Recojo" style="cursor:help;float:right;" data-original-title="LIMA"><i class="glyphicon glyphicon-calendar"></i></a></td>
                                                <td>TRUJILLO <a class="pop_over hint--left hint--info" data-placement="right" data-content="21/10/2015 04:00" data-hint="Cita Llegada" style="cursor:help;float:right;" data-original-title="TRUJILLO"><i class="glyphicon glyphicon-calendar"></i></a></td>
                                                <td>JAD SERVICIOS S.A.C <a class="pop_over hint--left hint--info" data-placement="right" data-content="PESO: 100 ton. LONGITUD: 200 m. ANCHURA: 300 m. ALTURA: 400 m." data-hint="Caracter&iacute;sticas del Transporte" style="cursor:help;float:right;" data-original-title="D2D494"><i class="glyphicon glyphicon-list"></i></a></td>
                                                <td>DIRECTA</td>                                                
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <a href="JavaScript:void(0);" style="cursor:pointer;" class="plan_trip hint--left" data-hint="Viaje" data-origin="" data-destination="" data-adjudication="" data-carrier=""><i class="glyphicon glyphicon-pencil"></i></a>
                                                </td>
                                                <td>0002</td>
                                                <td>LIMA <a class="pop_over hint--left hint--info" data-placement="right" data-content="21/10/2015 04:00" data-hint="Cita Recojo" style="cursor:help;float:right;" data-original-title="LIMA"><i class="glyphicon glyphicon-calendar"></i></a></td>
                                                <td>TRUJILLO <a class="pop_over hint--left hint--info" data-placement="right" data-content="21/10/2015 04:00" data-hint="Cita Llegada" style="cursor:help;float:right;" data-original-title="TRUJILLO"><i class="glyphicon glyphicon-calendar"></i></a></td>
                                                <td>JAD SERVICIOS S.A.C <a class="pop_over hint--left hint--info" data-placement="right" data-content="PESO: 100 ton. LONGITUD: 200 m. ANCHURA: 300 m. ALTURA: 400 m." data-hint="Caracter&iacute;sticas del Transporte" style="cursor:help;float:right;" data-original-title="D2D494"><i class="glyphicon glyphicon-list"></i></a></td>
                                                <td>DIRECTA</td>                                                
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <a href="JavaScript:void(0);" style="cursor:pointer;" class="plan_trip hint--left" data-hint="Viaje"><i class="glyphicon glyphicon-pencil"></i></a>
                                                </td>
                                                <td>0003</td>
                                                <td>LIMA</td>
                                                <td>AREQUIPA</td>
                                                <td>SUBASTA <a class="pop_over hint--left hint--info" data-placement="right" data-content="PESO: 100 ton. LONGITUD: 200 m. ANCHURA: 300 m. ALTURA: 400 m." data-hint="Caracter&iacute;sticas del Transporte" style="cursor:help;float:right;" data-original-title="D2D494"><i class="glyphicon glyphicon-list"></i></a></td>
                                                <td>9 PARTICIPANTE(S)</td>                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>    
                        </table>
                    </form>                    
                </div>
                <div class="modal-footer">
                    <a href="JavaScript:void(0);" class="btn btn-default" id="plan_close" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> CANCELAR</a>
                    <a href="JavaScript:void(0);" class="btn btn-primary" id="plan_save"><i class="glyphicon glyphicon-saved"></i> GUARDAR</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Adjudication Type-->
    <div class="modal" id="adjudication">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h3><i class="glyphicon glyphicon-tasks" style="margin-top: 3px;font-size:15px;"></i> ADJUDICACI&Oacute;N</h3>
                </div>
                <div class="modal-body">
                    <form id="validation_adjudication">
                        <table class="table table-bordered" >
                            <tr>
                                <td><b>TIPO :</b></td>
                                <td class="form-group"><select class="form-control chzn_edit" id="editAdjudicationType" name="editAdjudicationType" data-placeholder="SELECCIONE TIPO DE ADJUDICACION..."></select></td>
                            </tr>
                        </table>                        
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="JavaScript:void(0);" class="btn btn-default" id="adjudication_close" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> CANCELAR</a>
                    <a href="JavaScript:void(0);" class="btn btn-primary" id="adjudication_save"><i class="glyphicon glyphicon-ok"></i> CONTINUAR</a>
                </div>
            </div>
        </div>
    </div>    
    <!-- hide elements-->
    <div class="hide">           
        <!-- confirmation box -->
        <div id="confirm_dialog" class="cbox_content">
            <div class="sepH_c tac"><strong>Esta seguro de eliminar el(los) registro(s)?</strong></div>
            <div class="tac">
                <a href="#" class="btn btn-gebo confirm_yes btn-default">S&iacute;</a>
                <a href="#" class="btn confirm_no btn-default">No</a>
            </div>
        </div>
    </div>
    <!-- JQuery Implementation -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate.min.js"></script>
    <script src="lib/jquery-ui/jquery-ui-1.10.0.custom.min.js"></script>
    <!-- touch events for jquery ui-->
    <script src="js/forms/jquery.ui.touch-punch.min.js"></script>
    <!-- easing plugin -->
    <script src="js/jquery.easing.1.3.min.js"></script>
    <!-- smart resize event -->
    <script src="js/jquery.debouncedresize.min.js"></script>
    <!-- js cookie plugin -->
    <script src="js/jquery_cookie_min.js"></script>
    <!-- main bootstrap js -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- bootstrap plugins -->
    <script src="js/bootstrap.plugins.min.js"></script>
    <!-- typeahead -->
    <script src="lib/typeahead/typeahead.min.js"></script>
    <!-- code prettifier -->
    <script src="lib/google-code-prettify/prettify.min.js"></script>
    <!-- sticky messages -->
    <script src="lib/sticky/sticky.min.js"></script>
    <!-- lightbox -->
    <script src="lib/colorbox/jquery.colorbox.min.js"></script>
    <!-- jBreadcrumbs -->
    <script src="lib/jBreadcrumbs/js/jquery.jBreadCrumb.1.1.min.js"></script>
    <!-- hidden elements width/height -->
    <script src="js/jquery.actual.min.js"></script>
    <!-- custom scrollbar -->
    <script src="lib/slimScroll/jquery.slimscroll.js"></script>
    <!-- fix for ios orientation change -->
    <script src="js/ios-orientationchange-fix.js"></script>
    <!-- to top -->
    <script src="lib/UItoTop/jquery.ui.totop.min.js"></script>
    <!-- mobile nav -->
    <script src="js/selectNav.js"></script>
    <!-- moment.js date library -->
    <script src="lib/moment/moment.min.js"></script>
    <!-- masked inputs -->
    <script src="js/forms/jquery.inputmask.min.js"></script>
    <!-- datepicker -->
    <script src="lib/datepicker/bootstrap-datepicker.min.js"></script>
    <!-- timepicker -->
    <script src="lib/timepicker/js/bootstrap-timepicker.min.js"></script>
    <!-- common functions -->
    <script src="js/pages/tm_common.js"></script>
    <!-- styled form elements -->
    <script src="lib/uniform/jquery.uniform.min.js"></script>    
    <!-- datatable -->
    <script src="lib/datatables/jquery.dataTables.min.js"></script>
    <script src="lib/datatables/extras/Scroller/media/js/dataTables.scroller.min.js"></script>
    <!-- datatable table tools -->
    <script src="lib/datatables/extras/TableTools/media/js/TableTools.min.js"></script>
    <script src="lib/datatables/extras/TableTools/media/js/ZeroClipboard.js"></script>
    <!-- datatables bootstrap integration -->
    <script src="lib/datatables/jquery.dataTables.bootstrap.min.js"></script>
    <!-- tooltips -->
    <script src="lib/qtip2/jquery.qtip.min.js"></script>
    <!-- chosen -->
    <script src="lib/chosen/chosen.jquery.min.js"></script>
    <!-- multiselect -->
    <script src="lib/multi-select/js/jquery.multi-select.js"></script>
    <script src="lib/multi-select/js/jquery.quicksearch.js"></script>
    <!-- validations -->
    <script src="lib/validation/jquery.validate.min.js"></script>
    <script src="lib/validation/localization/messages_es.js"></script>
    <!-- crud functions -->
    <script src="js/controller/crud_allocation-service.js"></script>
    <!-- lock screen-->    
    <script src="js/np/idle-time.js"></script>
    <script src="js/np/lock-screen.js"></script>
    <script src="js/np/sha512.js"></script>
    <script>
        $(document).ready(function() {
            //* show all elements & remove preloader
            setTimeout('$("html").removeClass("js")',1000);
            $('#collapseThree').addClass(' in');
            $('#allocation-service').addClass(' active');
        });
    </script>