<?php
require '../common/common.php';
require './clase_plantilla.php';

$db = new Database(true /* create missing tables */);
if (!array_key_exists('c:client_version', $db->getConfig())) {  // first run
  echo '<h2>Inizializando...</h2><p><i>Parece ser la primera ejecución. Creando una configuración por defecto...';
  $db->populateConfig();
  buildClientAppZip($db);
  echo ' Listo.</i></p>';
}

if (isset($_POST['clearAll'])) {
  $db->dropTablesExceptConfig();
  $db->createMissingTables();
} else if (isset($_POST['configDefaults'])) {
  $db->populateConfig();
  buildClientAppZip($db);
} else if (isset($_POST['setConfig'])){
  if (isset($_POST['setConfig'])) {
    if (isset($_POST['Camera_active'])) {
        $db->setConfig('c:camera_enabled', 1);
    } else {
        $db->setConfig('c:camera_enabled', 0);
    }
    $db->setConfig('c:camera_resolution_hor', $_POST['CamResHor']);
    $db->setConfig('c:camera_resolution_ver', $_POST['CamResVer']);
    if (isset($_POST['BMP_active'])) {
        $db->setConfig('c:pressure_enabled', 1);
    } else {
        $db->setConfig('c:pressure_enabled', 0);
    }
    $db->setConfig('c:pressure_cs', $_POST['Pin_cs']);
    $db->setConfig('c:pressure_sck', $_POST['Pin_sck']);
    $db->setConfig('c:pressure_sdi', $_POST['Pin_sdi']);
    $db->setConfig('c:pressure_sdo', $_POST['Pin_sdo']);
    $db->setConfig('c:timeout_http_request_seconds', $_POST['Wait_req']);
    $db->setConfig('c:temperature_shutdown_at', $_POST['Temp_shtdwn']);
    $db->setConfig('c:timeout_shutdown_seconds', $_POST['Tpo_shtdwn']);
    $db->setConfig('c:upload_interval_seconds', $_POST['Update']);
    $db->setConfig('c:upload_max_size_kb', $_POST['Max_size']);
    if (isset($_POST['DHT_active'])) {
        $db->setConfig('c:dht_enabled', 1);
    } else {
        $db->setConfig('c:dht_enabled', 0);
    }
    $db->setConfig('c:dht_pin', $_POST['Dht_pin']);
    $db->setConfig('c:dht_sensor', $_POST['Dht_type']);
    $db->setConfig('c:dht_retries', $_POST['Dht_ret']);
    if (isset($_POST['Pluvio_active'])) {
        $db->setConfig('c:rain_enabled', 1);
    } else {
        $db->setConfig('c:rain_enabled', 0);
    }
    $db->setConfig('c:rain_input_pin', $_POST['Rain_pin']);
    $db->setConfig('c:rain_pud', $_POST['Rain_pud']);
    $db->setConfig('c:rain_debounce_millis', $_POST['Rain_deb']);
    $db->setConfig('c:rain_size_wide_mm', $_POST['Rain_wide']);
    $db->setConfig('c:rain_size_long_mm', $_POST['Rain_long']);
    $db->setConfig('c:rain_drops', $_POST['Rain_drops']);
    $db->setConfig('c:logging_level', $_POST['Client_log']);
    if (isset($_POST['Wind_active'])) {
        $db->setConfig('c:wind_enabled', 1);
    } else {
        $db->setConfig('c:wind_enabled', 0);
    }
    $db->setConfig('c:wind_debounce_millis', $_POST['Wind_deb']);
    $db->setConfig('c:wind_edges_per_revolution', $_POST['Wind_edges']);
    //$db->setConfig('c:wind_high_speed_factor', $_POST['Wind_hsf']);
    $db->setConfig('c:wind_input_pin', $_POST['Wind_pin']);
    //$db->setConfig('c:wind_low_speed_factor', $_POST['Wind_lsf']);
    $db->setConfig('c:wind_max_rotation_seconds', $_POST['Wind_rot']);
    $db->setConfig('c:wind_diameter', $_POST['Wind_diameter']);
    $db->setConfig('c:wind_pud', $_POST['Wind_pud']);
    if (isset($_POST['Vane_active'])){
        $db->setconfig('c:wind_vane_enabled', 1);
    } else {
        $db->setconfig('c:wind_vane_enabled', 0);
    }
    if (isset($_POST['Huawei_enabled'])){
      $db->setconfig('c:huawei_enabled', 1);
    } else {
      $db->setconfig('c:huawei_enabled', 0);
    }
    $db->setConfig('c:demo_mode_enabled', $_POST['Demo_mode']);
    $db->setConfig('s:log_level', $_POST['Server_log']);
      
    if (isset($_POST['Meteotemplate_enabled'])){
        $db->setConfig('s:meteotemplate_enabled', 1);
    } else {
        $db->setConfig('s:meteotemplate_enabled', 0);
    }
    $db->setConfig('s:meteotemplate_API_URL', $_POST['Meteotemplate_API_URL']);
    $db->setConfig('s:meteotemplate_password', $_POST['Meteotemplate_password']);

    if (isset($_POST['Wunderground_enabled'])) {
        $db->setConfig('s:wunderground_enabled', 1);
    } else {
        $db->setConfig('s:wunderground_enabled', 0);
    }
    $db->setConfig('s:wunderground_API_URL', $_POST['Wunderground_url']);
    $db->setConfig('s:wunderground_password', $_POST['Wunderground_pass']);
    $db->setConfig('s:wunderground_station', $_POST['Wunderground_station']);

    if (isset($_POST['PWS_enabled'])) {
        $db->setConfig('s:pwsweather_enabled', 1);
    } else {
        $db->setConfig('s:pwsweather_enabled', 0);
    }
    $db->setConfig('s:pwsweather_API_URL', $_POST['PWS_url']);
    $db->setConfig('s:pwsweather_password', $_POST['PWS_pass']);
    $db->setConfig('s:pwsweather_station', $_POST['PWS_station']);

    $db->setConfig('c:language', $_POST['Language']);
    
    buildClientAppZip($db);
  }
}

$dbhandle = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        // Mostrar mensaje de error para evitar un fallo brusco sin los parametros de conexión son incorrectos.
        if ($dbhandle->connect_error) {
            exit("There was an error with your connection: ".$dbhandle->connect_error);
        }

$configQuery = "(SELECT * FROM config)";
$configResult = $dbhandle->query($configQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

$Contenido=new Plantilla("admin");

$variables=array();
if ($configResult) {
    while ($rowConfig = mysqli_fetch_array($configResult)) {
        $variables = array (substr($rowConfig['k'], 2) => $rowConfig['v']) + $variables;
    }
}
$language = $variables['language'];
require ('./language/lang_' . $language . '.php');

$variables = $variables + array (
    'activated1' => $lang['activated1'],
    'activated2' => $lang['activated2'],
    'password' => $lang['password'],
    'update_config' => $lang['update_config'],
    'default_config' => $lang['default_config'],
    'update' => $lang['update'],
    'ver' => $lang['ver'],
    'pud' => $lang['pud'],
    'pin' => $lang['pin'],
    'debounce' => $lang['debounce'],
    'level' => $lang['level'],
    'upload' => $lang['upload'],
    'upload_app' => $lang['upload_app'],
    'activate_destructive' => $lang['activate_destructive'],
    'manage_db' => $lang['manage_db'],
    'purge' => $lang['purge'],
    'days' => $lang['days'],
    'erase' => $lang['erase'],
    'reset_msg' => $lang['reset_msg'],
    'reset' => $lang['reset'],
    'camera' => $lang['camera'],
    'hor_res' => $lang['hor_res'],
    'ver_res' => $lang['ver_res'],
    'baro' => $lang['baro'],
    'cs' => $lang['cs'],
    'sck' => $lang['sck'],
    'sdi' => $lang['sdi'],
    'sdo' => $lang['sdo'],
    'temp' => $lang['temp'],
    'sensor' => $lang['sensor'],
    'retries' => $lang['retries'],
    'gauge' => $lang['gauge'],
    'wide' => $lang['wide'],
    'long' => $lang['long'],
    'drops' => $lang['drops'],
    'anemometer' => $lang['anemometer'],
    'edges_rev' => $lang['edges_rev'],
    'hsf' => $lang['hsf'],
    'lsf' => $lang['lsf'],
    'max_rot' => $lang['max_rot'],
    'diameter' => $lang['diameter'],
    'vane' => $lang['vane'],
    'working' => $lang['working'],
    'mode' => $lang['mode'],
    'rasp_config' => $lang['rasp_config'],
    'temp_shtdwn' => $lang['temp_shtdwn'],
    'http_req' => $lang['http_req'],
    'time_shtdwn' => $lang['time_shtdwn'],
    'update_every' => $lang['update_every'],
    'max_upload' => $lang['max_upload'],
    'client_log' => $lang['client_log'],
    'backups' => $lang['backups'],
    'log_max' => $lang['log_max'],
    'server_log' => $lang['server_log'],
    'server_ext' => $lang['server_ext'],
    'server_meteotemplate' => $lang['server_meteotemplate'],
    'server_meteotemplate_API' => $lang['server_meteotemplate_API'],
    'server_meteotemplate_explanation' => $lang['server_meteotemplate_explanation'],
    'server_meteotemplate_secret' => $lang['server_meteotemplate_secret'],
    'server_wunderground' => $lang['server_wunderground'],
    'server_wunderground_url' => $lang['server_wunderground_url'],
    'server_wunderground_station' => $lang['server_wunderground_station'],
    'server_pws' => $lang['server_pws'],
    'server_pws_url' => $lang['server_pws_url'],
    'interface' => $lang['interface'],
    'lang' => $lang['language'],
    'copy' => $lang['copy'],
    'modem' => $lang['modem'],
    'connection' => $lang['connection']
);
    
$Contenido->asigna_variables($variables);

$ContenidoString=$Contenido->muestra();
echo $ContenidoString;
?>
