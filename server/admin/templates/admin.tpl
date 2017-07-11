<!DOCTYPE html><!-- saved from url=(0016)http://localhost -->
<html>
    <head>
        <title>
        </title>
        <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=800" />
        <meta name="description" content="Página de configuración de WeatherPi" />
        <meta name="Builder" content="Francisco M. Fernández Cano" />
        <meta name="buildDate" content="domingo, 4 de junio de 2017" />
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
        <meta http-equiv="pragma" content="no-cache" />
        <link rel="stylesheet" type="text/css" href="css/textstyles.css" />
        <script type="text/javascript" src="js/mobileRedirect.js"></script>
        <style type="text/css">
            a img {border:0px;}
            body {background: url('images/skulls.gif') repeat;margin: 145px auto;}
            div.container {margin: 145px auto;width: 800px;height: 1350px;background: url('images/light_leather.jpg') repeat; border: 2px solid orange; border-radius: 10px;}
            .shape_3 {background: url('images/grey_wood.jpg') repeat;border: 2px solid orange; border-radius: 10px;}
            .shape_6 {background: url('images/shape_6.png') no-repeat;}
            .shape_8 {background: url('images/shape_8.png') no-repeat;}
            .shape_29 {background: url('images/shape_29.png') no-repeat;}
            .shape_30 {background: url('images/shape_30.png') no-repeat;}
            @media only screen and (-moz-min-device-pixel-ratio: 1.5), only screen and (-o-min-device-pixel-ratio: 3/2), only screen and (-webkit-min-device-pixel-ratio: 1.5), only screen and (min-devicepixel-ratio: 1.5), only screen and (min-resolution: 1.5dppx) {.shape_3 {background: url('images/shape_3@2x.png') no-repeat;background-size: 797px 56px;}.shape_6 {background: url('images/shape_6@2x.png') no-repeat;background-size: 199px 60px;}.shape_8 {background: url('images/shape_8@2x.png') no-repeat;background-size: 199px 48px;}.shape_29 {background: url('images/shape_29@2x.png') no-repeat;background-size: 144px 29px;}.shape_30 {background: url('images/shape_30@2x.png') no-repeat;background-size: 144px 29px;}}
            .button1{
                 text-decoration:none; 
                 text-align:center; 
                 padding:5px 5px; 
                 border:solid 4px #720000; 
                 -webkit-border-radius:50px;
                 -moz-border-radius:50px; 
                 border-radius: 50px; 
                 font:18px Arial, Helvetica, sans-serif; 
                 font-weight:bold; 
                 color:#E5FFFF; 
                 background-color:#c73b3b; 
                 background-image: -moz-linear-gradient(top, #c73b3b 0%, #a51919 100%); 
                 background-image: -webkit-linear-gradient(top, #c73b3b 0%, #a51919 100%); 
                 background-image: -o-linear-gradient(top, #c73b3b 0%, #a51919 100%); 
                 background-image: -ms-linear-gradient(top, #c73b3b 0% ,#a51919 100%); 
                 filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a51919', endColorstr='#a51919',GradientType=0 ); 
                 background-image: linear-gradient(top, #c73b3b 0% ,#a51919 100%);   
                 -webkit-box-shadow:2px 2px 2px #bababa, inset 0px 0px 1px #ffffff; 
                 -moz-box-shadow: 2px 2px 2px #bababa,  inset 0px 0px 1px #ffffff;  
                 box-shadow:2px 2px 2px #bababa, inset 0px 0px 1px #ffffff;
            }
            .button2{
                 text-decoration:none; 
                 text-align:center; 
                 padding:11px 32px; 
                 border:solid 4px #00720a; 
                 -webkit-border-radius:50px;
                 -moz-border-radius:50px; 
                 border-radius: 50px; 
                 font:18px Arial, Helvetica, sans-serif; 
                 font-weight:bold; 
                 color:#E5FFFF; 
                 background-color:#4cc73b; 
                 background-image: -moz-linear-gradient(top, #4cc73b 0%, #19a54c 100%); 
                 background-image: -webkit-linear-gradient(top, #4cc73b 0%, #19a54c 100%); 
                 background-image: -o-linear-gradient(top, #4cc73b 0%, #19a54c 100%); 
                 background-image: -ms-linear-gradient(top, #4cc73b 0% ,#19a54c 100%); 
                 filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#19a54c', endColorstr='#19a54c',GradientType=0 ); 
                 background-image: linear-gradient(top, #4cc73b 0% ,#19a54c 100%);   
                 -webkit-box-shadow:2px 2px 2px #bababa, inset 0px 0px 1px #ffffff; 
                 -moz-box-shadow: 2px 2px 2px #bababa,  inset 0px 0px 1px #ffffff;  
                 box-shadow:2px 2px 2px #bababa, inset 0px 0px 1px #ffffff;
            }

            .button3{
                 text-decoration:none; 
                 text-align:center; 
                 padding:5px 5px; 
                 border:solid 4px #90720a; 
                 -webkit-border-radius:50px;
                 -moz-border-radius:50px; 
                 border-radius: 50px; 
                 font:15px Arial, Helvetica, sans-serif; 
                 font-weight:bold; 
                 color:#E5FFFF; 
                 background-color:#4cc73b; 
                 background-image: -moz-linear-gradient(top, #ccc73b 0%, #a9a54c 100%); 
                 background-image: -webkit-linear-gradient(top, #ccc73b 0%, #a9a54c 100%); 
                 background-image: -o-linear-gradient(top, #ccc73b 0%, #a9a54c 100%); 
                 background-image: -ms-linear-gradient(top, #ccc73b 0% ,#a9a54c 100%); 
                 filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a9a54c', endColorstr='#a9a54c',GradientType=0 ); 
                 background-image: linear-gradient(top, #ccc73b 0% ,#a9a54c 100%);   
                 -webkit-box-shadow:2px 2px 2px #bababa, inset 0px 0px 1px #ffffff; 
                 -moz-box-shadow: 2px 2px 2px #bababa,  inset 0px 0px 1px #ffffff;  
                 box-shadow:2px 2px 2px #bababa, inset 0px 0px 1px #ffffff;
            }

        </style>
    </head>
    <body>
        <script type="text/javascript">
            function enableDestructiveButtons(toggleCheckbox) {
            var checkbox = document.getElementById('Activate');
            if (toggleCheckbox) {
                checkbox.checked = !checkbox.checked;
            }
            var buttons = document.getElementsByClassName('Dangerous');
            for (var i = 0; i < buttons.length; i++) {
                buttons[i].disabled = !checkbox.checked;
            }
            }
        </script>
        <div class="shadow">
            <div class="container" style="height:1350px;">
                <header>
                    <div style="position:relative">
                        <div class="shape_1" style="left:550px;top:-95px;width:285px;height:142px;z-index:1;position:absolute;">
                        <img src="images/sunny.png" height="142" width="285" />
                        </div>
                    </div>
                    <div style="position:relative">
                        <div class="shape_1" style="left:360px;top:-130px;width:122px;height:153px;z-index:2;position:absolute">
                        <img src="images/logo3.png" height="153" width="122" />
                        </div>
                    </div>
                    <div style="position:relative">
                        <div class="shape_2" style="left:-26px;top:-131px;width:351px;height:183px;z-index:3;position:absolute;">
                            <img src="images/cloud3.png" height="183" width="351" />
                        </div>
                    </div>
                    <div style="position:relative">
                        <div class="shape_3" style="left:-1px;top:-2px;width:799px;height:56px;z-index:3;position:absolute;">
                        </div>
                    </div>
                    <div style="position:relative">
                        <div class="shape_2" style="left:0px;top:0px;width:790px;height:0px;z-index:5;position:absolute;">
                            <div style="margin: 0px 0px 0px 0px; ">
                                <p style="line-height:41px;text-align:center;margin-top:10px;margin-bottom:10px;" class="Style4">Weather<span class="Style8">Pi</span>
                                <span class="Style6"> Config:</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="content" data-minheight="840">
                    <form method="post" enctype="multipart/form-data">
                        <div style="position:relative">
                            <div class="shape_0" style="left:10px;top:70px;width:250px;height:130px;z-index:0;position:absolute;border-size:1px;border: 2px solid grey; border-radius: 10px;">
                                <div style="margin: 0px 2.16px 0px 2.16px; ">
                                    <p style="line-height:21px;margin-top:0px;margin-bottom:11px;text-align:center;" class="Style1">{camera}</p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{activated1}<input type="checkbox" value="1" name="Camera_active" id="camera_enabled" value="1"></p>
                                    <script type="text/javascript">
                                        document.getElementById("camera_enabled").checked = {camera_enabled};
                                    </script>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">Resolución Horizontal: <input type="text" name="CamResHor" value="{camera_resolution_hor}" maxlength="4" size="4"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">Resolución Vertical: <input type="text" name="CamResVer" value="{camera_resolution_ver}" maxlength="4" size="4"></p>
                                </div>
                            </div>
                        </div>
                        <div style="position:relative">
                            <div class="shape_13" style="left:10px;top:205px;width:250px;height:200px;z-index:1;position:absolute;border-size:1px;border: 2px solid grey; border-radius: 10px;">
                                <div style="margin: 0px 2.16px 0px 2.16px; ">
                                    <p style="line-height:21px;margin-top:0px;margin-bottom:11px;text-align:center;" class="Style1">{baro}</p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{activated2}<input type="checkbox" name="BMP_active" value="1" id="pressure_enabled"></p>
                                    <script type="text/javascript">
                                        document.getElementById("pressure_enabled").checked = {pressure_enabled};
                                    </script>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{cs}<input type="text" name="Pin_cs" value="{pressure_cs}" size="2" maxlength="2"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{sck}<input type="text" name="Pin_sck" value="{pressure_sck}" size="2" maxlength="2"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{sdi}<input type="text" name="Pin_sdi" value="{pressure_sdi}" size="2" maxlength="2"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{sdo}<input type="text" name="Pin_sdo" value="{pressure_sdo}" size="2" maxlength="2"></p>
                                </div>
                            </div>
                        </div>

                        <div style="position:relative">
                            <div class="shape_23" style="left:10px;top:410px;width:250px;height:390px;z-index:8;position:absolute;border-size:1px;border: 2px solid grey; border-radius: 10px;">
                                <div style="margin: 0px 2.16px 0px 2.16px; ">
                                    <p style="line-height:21px;margin-top:0px;margin-bottom:11px;text-align:center;" class="Style18">{server_ext}</p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{server_meteotemplate}<input type="checkbox" name="Meteotemplate_enabled" value="1" id="Meteotemplate_enabled"></p>
                                    <script type="text/javascript">
                                        document.getElementById("Meteotemplate_enabled").checked = {meteotemplate_enabled};
                                    </script>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{server_meteotemplate_API}<input type="text" name="Meteotemplate_API_URL" value="{meteotemplate_API_URL}"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{server_meteotemplate_secret}<input type="password" name="Meteotemplate_password" value="{meteotemplate_password}"></p>
                                    <hr />
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{server_wunderground}<input type="checkbox" name="Wunderground_enabled" value="1" id="Wunderground_enabled"></p>
                                    <script type="text/javascript">
                                        document.getElementById("Wunderground_enabled").checked = {wunderground_enabled};
                                    </script>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{server_wunderground_url}<input type="text" name="Wunderground_url" value="{wunderground_API_URL}"></p>
                                    <p style="line-height:14px;margin-botton:11px;margin-top:0px;" class="Style3">{server_wunderground_station}<input type="text" name="Wunderground_station" value="{wunderground_station}"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{password}<input type="password" name="Wunderground_pass" value="{wunderground_password}"></p>
                                    <hr />
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{server_pws}<input type="checkbox" name="PWS_enabled" value="1" id="PWS_enabled"></p>
                                    <script type="text/javascript">
                                        document.getElementById("PWS_enabled").checked = {pwsweather_enabled};
                                    </script>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{server_pws_url}<input type="text" name="PWS_url" value="{pwsweather_API_URL}"></p>
                                    <p style="line-height:14px;margin-botton:11px;margin-top:0px;" class="Style3">{server_wunderground_station}<input type="text" name="PWS_station" value="{pwsweather_station}"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{password}<input type="password" name="PWS_pass" value="{pwsweather_password}"></p>

                                </div>
                            </div>
                        </div>
                        <div style="position:relative">
                            <div class="shape_5" style="left:270px;top:70px;width:250px;height:70px;z-index:20;position:absolute;border-size:1px;border: 2px solid red; border-radius: 10px;">
                                <div style="margin: 0px 0px 0px 0px; ">
                                    <p style="text-align:center;margin-top:10px;margin-bottom:11px;" class="Style1">{ver}<br /><span class="Style18">{client_version}</span></p>
                                </div>
                            </div>
                        </div>
                        <div style="position:relative">
                            <div class="shape_9" style="left:270px;top:145px;width:250px;height:165px;z-index:3;position:absolute;border-size:1px;border: 2px solid grey; border-radius: 10px;">
                                <div style="margin: 0px 2.16px 0px 2.16px; ">
                                    <p style="line-height:21px;margin-top:0px;margin-bottom:11px;text-align:center;" class="Style1">{temp}</p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{activated2}<input type="checkbox" name="DHT_active" id="dht_enabled" value="1"></p>
                                    <script type="text/javascript">
                                        document.getElementById("dht_enabled").checked = {dht_enabled};
                                    </script>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{pin}<input type="text" name="Dht_pin" value="{dht_pin}" size="2" maxlength="2"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{sensor} 
                                        <select name="Dht_type" id="Dht_type">
                                            <option value="22" selected="selected">DHT22/AM2302</option>
                                            <option value="11">DHT11</option>
                                        </select>
                                        <script type="text/javascript">
                                            var dht = "{dht_sensor}";
                                            var Dht_type = document.getElementById('Dht_type');
                                            for(var i, j = 0; i = Dht_type.options[j]; j++)
                                            {
                                                if(i.value == dht) {
                                                    Dht_type.selectedIndex = j;
                                                    break;
                                                }
                                            }
                                        </script>
                                    </p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{retries}<input type="text" name="Dht_ret" value="{dht_retries}" size="2" maxlength="2"></p>
                                </div>
                            </div>
                        </div>
                        <div style="position:relative">
                            <div class="shape_15" style="left:270px;top:315px;width:250px;height:200px;z-index:4;position:absolute;border-size:1px;border: 2px solid grey; border-radius: 10px;">
                                <div style="margin: 0px 2.16px 0px 2.16px; ">
                                    <p style="line-height:21px;margin-top:0px;margin-bottom:11px;text-align:center;" class="Style1">{gauge}</p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{activated2}<input type="checkbox" name="Pluvio_active" value="1" id="rain_enabled"></p>
                                    <script type="text/javascript">
                                        document.getElementById("rain_enabled").checked = {rain_enabled};
                                    </script>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{pin}<input type="text" name="Rain_pin" value="{rain_input_pin}" size="2" maxlength="2"> | {pud}
                                        <select name="Rain_pud" id="rain_pud">
                                            <option value="up">up</option>
                                            <option value="down">down</option>
                                        </select>
                                        <script type="text/javascript">
                                            var r_pud = "{rain_pud}";
                                            var Rain_pud = document.getElementById('rain_pud');
                                            for(var i, j = 0; i = Rain_pud.options[j]; j++)
                                            {
                                                if(i.value == r_pud) {
                                                    Rain_pud.selectedIndex = j;
                                                    break;
                                                }
                                            }
                                        </script>
                                    </p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{debounce}<input type="text" name="Rain_deb" value="{rain_debounce_millis}" size="3" maxlength="3"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{wide}<input type="text" name="Rain_wide" value="{rain_size_wide_mm}" size="4" maxlength="4"> x {long}<input type="text" name="Rain_long" value="{rain_size_long_mm}" size="4" maxlength="4"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{drops}<input type="text" name="Rain_drops" value="{rain_drops}" size="3" maxlength="3"></p>
                                </div>
                            </div>
                        </div>
                        <div style="position:relative">
                            <div class="shape_11" style="left:270px;top:520px;width:250px;height:135px;z-index:5;position:absolute;border-size:1px;border: 2px solid grey; border-radius: 10px;">
                                <div style="margin: 0px 2.16px 0px 2.16px; ">
                                    <p style="line-height:21px;margin-top:0px;margin-bottom:11px;text-align:center;" class="Style1">{client_log}</p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{backups}<input type="text" name="Num_bck" value="{logging_backup_count}" size="2" maxlength="2"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{level}
                                        <select name="Client_log" id="logging_level">
                                            <option value="INFO">INFO</option>
                                            <option value="DEBUG">DEBUG</option>
                                        </select>
                                        <script type="text/javascript">
                                            var c_log = "{logging_level}";
                                            var Client_log = document.getElementById('logging_level');
                                            for(var i, j = 0; i = Client_log.options[j]; j++)
                                            {
                                                if(i.value == c_log) {
                                                    Client_log.selectedIndex = j;
                                                    break;
                                                }
                                            }
                                        </script>
                                    </p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{log_max}<input type="text" name="Bck_size" value="{logging_max_file_size_kb}" size="4" maxlength="4"></p>
                                </div>
                            </div>
                        </div>
                        <div style="position:relative">
                            <div class="shape_11" style="left:270px;top:660px;width:250px;height:80px;z-index:5;position:absolute;border-size:1px;border: 2px solid grey; border-radius: 10px;">
                                <div style="margin: 0px 2.16px 0px 2.16px;">
                                    <p style="line-height:21px;margin-top:opx;margin-bottom:11px;text-align:center;" class="Style1">{interface}</p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{lang}
                                        <select name="Language" id="language">
                                            <option value="spanish">Castellano</option>
                                            <option value="english">English</option>
                                        </select>
                                        <script type="text/javascript">
                                            var c_lang = "{language}";
                                            var Language = document.getElementById('language');
                                            for(var i, j = 0; i= Language.options[j]; j++)
                                            {
                                                if(i.value == c_lang){
                                                    Language.selectedIndex = j;
                                                    break;
                                                }
                                            }
                                        </script>                                    
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div style="position:relative">
                            <a href="">
                            <div style="left:270px;top:745px;width:250px;height:100px;z-index:6;position:absolute;border-size:1px;border:2px solid grey;border-radius:10px;">
                                <div style="margin: 8px 2.16px 2.16px 2.16px; ">
                                    <p style="line-height:22px;text-align:center;margin-top:0px;margin-bottom:0px;" class="Style7">
                                        <input class="button3" type="submit" name="setConfig" value="{update_config}" /> <input class="button3" type="submit" name="configDefaults" value="{default_config}" />
                                    </p>
                                </div>
                            </div>
                            </a>
                        </div>

                        <div style="position:relative">
                            <div class="shape_17" style="left:530px;top:70px;width:250px;height:280px;z-index:6;position:absolute;border-size:1px;border: 2px solid grey; border-radius: 10px;">
                                <div style="margin: 0px 2.16px 0px 2.16px; ">
                                    <p style="line-height:21px;margin-top:0px;margin-bottom:11px;text-align:center;" class="Style1">{anemometer}</p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{activated2}<input type="checkbox" name="Wind_active" value="1" id="wind_enabled"></p>
                                    <script type="text/javascript">
                                        document.getElementById("wind_enabled").checked = {wind_enabled};
                                    </script>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{pin}<input type="text" name="Wind_pin" value="{wind_input_pin}" size="2" maxlength="2"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{debounce}<input type="text" name="Wind_deb" value="{wind_debounce_millis}" size="3" maxlength="3"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{edges_rev}<input type="text" name="Wind_edges" value="{wind_edges_per_revolution}" size="1" maxlength="1"></p>
                                    <!-- EXCLUDED
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{hsf}<input type="text" name="Wind_hsf" value="{wind_high_speed_factor}" size="6" maxlength="6"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{lsf}<input type="text" name="Wind_lsf" value="{wind_low_speed_factor}" size="6" maxlength="6"></p>
                                    -->
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{diameter}<input type="text" name="Wind_diameter" value="{wind_diameter_mm}" size="6" maxlength="4"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{max_rot}<input type="text" name="Wind_rot" value="{wind_max_rotation_seconds}" size="2" maxlength="2"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{pud}
                                        <select name="Wind_pud" id="wind_pud">
                                            <option value="up">up</option>
                                            <option value="down">down</option>
                                        </select>
                                        <script type="text/javascript">
                                            var w_pud = "{wind_pud}";
                                            var Wind_pud = document.getElementById('wind_pud');
                                            for(var i, j = 0; i = Wind_pud.options[j]; j++)
                                            {
                                                if(i.value == w_pud) {
                                                    Wind_pud.selectedIndex = j;
                                                    break;
                                                }
                                            }
                                        </script>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div style="position:relative">
                            <div class="shape_25" style="left:530px;top:365px;width:250px;height:65px;z-index:7;position:absolute;border-size:1px;border: 2px solid grey; border-radius: 10px;">
                                <div style="margin: 0px 2.16px 0px 2.16px; ">
                                    <p style="line-height:21px;margin-top:0px;margin-bottom:11px;text-align:center;" class="Style1">{vane}</p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{activated1}<input type="checkbox" name="Vane_active" value="1" id="wind_vane_enabled"></p>
                                    <script type="text/javascript">
                                        document.getElementById("wind_vane_enabled").checked = {wind_vane_enabled};
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div style="position:relative">
                            <div class="shape_25" style="left:535px;top:440px;width:250px;height:69px;z-index:7;position:absolute;border-size:1px;border: 2px solid grey; border-radius: 10px;">
                                <div style="margin: 0px 2.16px 0px 2.16px; ">
                                    <p style="line-height:21px;margin-top:0px;margin-bottom:11px;text-align:center;" class="Style1">{working}</p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{mode}
                                        <select name="Demo_mode" id="demo_mode_enabled">
                                            <option value="0">live</option>
                                            <option value="1">demo</option>
                                        </select>
                                        <script type="text/javascript">
                                            var c_demo = "{demo_mode_enabled}"
                                            var Demo_mode = document.getElementById('demo_mode_enabled');
                                            for (var i, j = 0; i=Demo_mode.options[j]; j++)
                                                {
                                                    if(i.value == c_demo){
                                                        Demo_mode.selectedIndex = j;
                                                        break;
                                                    }
                                                }
                                        </script>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div style="position:relative">
                            <div class="shape_23" style="left:530px;top:520px;width:250px;height:79px;z-index:8;position:absolute;border-size:1px;border: 2px solid grey; border-radius: 10px;">
                                <div style="margin: 0px 2.16px 0px 2.16px; ">
                                    <p style="line-height:21px;margin-top:0px;margin-bottom:11px;text-align:center;" class="Style18">{server_log}</p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{level}
                                        <select name="Server_log" id="log_level">
                                            <option value="info">info</option>
                                            <option value="debug">debug</option>
                                        </select>
                                        <script type="text/javascript">
                                            var s_log = "{log_level}";
                                            var Server_log = document.getElementById('log_level');
                                            for(var i, j = 0; i = Server_log.options[j]; j++)
                                            {
                                                if(i.value == s_log) {
                                                    Server_log.selectedIndex = j;
                                                    break;
                                                }
                                            }
                                        </script>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div style="position:relative">
                            <div class="shape_19" style="left:530px;top:610px;width:250px;height:205px;z-index:2;position:absolute;border-size:1px;border: 2px solid grey; border-radius: 10px;">
                                <div style="margin: 0px 2.16px 0px 2.16px; ">
                                    <p style="line-height:21px;margin-top:0px;margin-bottom:11px;text-align:center;" class="Style1">{rasp_config}</p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{temp_shtdwn}<input type="text" name="Temp_shtdwn" value="{temperature_shutdown_at}" size="2" maxlength="2"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{http_req}<input type="text" name="Wait_req" value="{timeout_http_request_seconds}" size="2" maxlength="2"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{time_shtdwn}<input type="text" name="Tpo_shtdwn" value="{timeout_shutdown_seconds}" size="3" maxlength="3"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{update_every}<input type="text" name="Update" value="{upload_interval_seconds}" size="3" maxlength="3"></p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{max_upload}<input type="text" name="Max_size" value="{upload_max_size_kb}" size="4" maxlength="4"></p>
                                </div>
                            </div>
                        </div>
                      
                        <div style="position:relative">
                            <div class="shape_11" style="left:530px;top:825px;width:250px;height:60px;z-index:5;position:absolute;border-size:1px;border: 2px solid grey; border-radius: 10px;">
                                <div style="margin: 0px 2.16px 0px 2.16px;">
                                    <p style="line-height:21px;margin-top:opx;margin-bottom:11px;text-align:center;" class="Style1">{connection}</p>
                                    <p style="line-height:14px;margin-bottom:11px;margin-top:0px;" class="Style3">{modem}<input type="checkbox" name="Huawei_enabled" value="1" id="Huawei_enabled"></p>
                                    <script type="text/javascript">
                                      document.getElementById("Huawei_enabled").checked = {huawei_enabled};
                                    </script>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div style="position:relative">
                        <div style="left:-4px;top:875px;height:43px;background: url('images/shape_shadow_27.png') no-repeat;width:805px;position:absolute;z-index:27">
                        </div>
                        <div class="shape_27" style="left:-2.5px;top:874.5px;width:805px;height:37px;z-index:27;position:absolute;">
                            <img src="images/shape_27.png" height="37" width="805" alt="(placeholder)" />
                        </div>
                    </div>
                    <div style="position:relative">
                        <div class="shape_28" style="left:30px;top:911px;width:740px;height:100 px;z-index:28;position:absolute;">
                            <div style="margin: 0px 2.16px 0px 2.16px; ">
                                <p style="line-height:21px;text-align:center;margin-top:0px;margin-bottom:11px;" class="Style1">{upload_app}</p>
                                <form action="upload_file.php" method="post" enctype="multipart/form-data">
                                    <label class="Style18" for="file">{update}</label>
                                    <input class="button2" type="file" name="file" id="file">
                                    <input class="button2" type="submit" name="submit" value="{upload}">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div style="position:relative">
                        <div style="left:-4px;top:998px;height:43px;background: url('images/shape_shadow_27.png') no-repeat;width:805px;position:absolute;z-index:27">
                        </div>
                        <div class="shape_27" style="left:-2.5px;top:997.5px;width:805px;height:37px;z-index:27;position:absolute;">
                            <img src="images/shape_27.png" height="37" width="805" alt="(placeholder)" />
                        </div>
                    </div>
                    <div style="position:relative">
                        <div class="button1" style="left:220px;top:1038px;width:350px;height:24px;z-index:8;position:absolute;">
                            <div style="margin: 7px 2.16px 2.16px 2.16px; ">
                                <form>
                                    <p style="line-height:0px;text-align:center;margin-top:0px;margin-bottom:0px;" class="Style7">
                                        <input type="checkbox" name="confirm" id="Activate" onclick="enableDestructiveButtons(false)"/><span onclick="enableDestructiveButtons(true)">{activate_destructive}</span>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div style="position:relative">
                        <div class="shape_32" style="left:10px;top:1094px;width:780px;height:190px;z-index:32;position:absolute;">
                            <div style="margin: 0px 2.16px 0px 2.16px; ">
                                <p style="line-height:21px;text-align:center;margin-top:0px;margin-bottom:11px;" class="Style1">{manage_db}</p>
                                    <form action="prune.php" method="get">
                                      <p style="line-height:21px;text-align:center;margin-top:0px;margin-bottom:11px;" class="Style3">{purge}<input type="text" name="days" value="" size="3" maxlength="3">{days}.
                                        <input class="Dangerous" type="submit" value="{erase}" disabled />
                                      </p>
                                    </form>
                                    <form method="post">
                                      <p style="line-height:21px;text-align:center;margin-top:0px;margin-bottom:11px;" class="Style3">
                                        {reset_msg}
                                        <input class="Dangerous" type="submit" name="clearAll" value="{reset}" disabled />
                                      </p>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
                <footer data-top='1016' data-height='134'>
                    <div style="position:relative">
                        <div class="shape_7" style="left:0px;top:1151px;width:800px;height:134px;z-index:7;position:absolute;">
                            <img src="images/grass.png" height="134" width="800" />
                        </div>
                        <div class="shape_33" style="left:0px;top:1271px;width:800px;heigh:130px;z-index:100;position:absolute;">
                            <p>{copy}
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>

