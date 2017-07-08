<?php
require_once '../common/common.php';

function handleRequest() {
  $logger = Logger::Instance();
  $contentBz2 = file_get_contents('php://input');
  if (!$contentBz2) {  // note that bzip2 never outputs ""
    return array('status' => 'no data received');
  }
  $data = json_decode(bzdecompress($contentBz2), true);
  if (!$data) {
    $logger->critical('json decoding or bzip2 decompression failed');
    return array('status' => 'invalid json or bzip2');
  }
  $logger->debug('Received data with keys: '.implode(array_keys($data), ', '));

  $db = new Database();  // TODO: Handle failure.
  $config = $db->getConfig();
  $response = array();
  try {
    $db->beginTransaction();
    $meta = $data['meta'];  // Metadata is required in each request.
    $clientVersionOnClient = get($meta['client_version'], NOT_AVAILABLE);
    $clientVersionOnServer = get($config['c:client_version'], NOT_AVAILABLE);
    $meteotemplateEnabled = get($config['s:meteotemplate_enabled'], 0);
    $wundergroundEnabled = get($config['s:wunderground_enabled'], 0);
    $logger->debug('client version: '.$clientVersionOnClient
        .' -- server has: '.$clientVersionOnServer);

    // Check whether the server has a different client version, and if so, make the wrapper download
    // it. We don't care whether the version on the server is actually newer or older.
    if ($clientVersionOnClient != $clientVersionOnServer) {
      $logger->notice('updating client '.$clientVersionOnClient.' to '.$clientVersionOnServer);
      $response['exit'] = 102;  // retval 102 will exit -> update -> restart the client
      // We trigger the client update also if our status is not OK, since that may be caused by an
      // outdated client version.
    }

    // TODO: If 'upto' is only the newest wind timestamp, we don't really need it.
    $meta['upto'] = 0;  // means n/a
    if (isset($data['wind'])) {
      $meta['upto'] = $db->insertWind($data['wind']);
    }
    $meta['fails'] = $data['upload']['fails'];
    $db->insertMetadata($meta);

    if (isset($data['temp'])) {
      $logger->debug('Calling insertTemperature');
      $db->insertTemperature($data['temp']);
    }

    if (isset($data['link'])) {
      $db->insertLinkStatus($data['link']);
    }

    if (isset($data['temp_hum'])) {
      $logger->debug('Calling insertTempHum');
      $db->insertTempHum($data['temp_hum']);
    }

    if (isset($data['press'])) {
      $logger->debug('Calling insertPress');
      $db->insertPress($data['press']);
    }
    
    if (isset($data['rain'])) {
      $logger->debug('Calling insertRain');
      $db->insertRain($data['rain']);
    }
    
    if (isset($data['vane'])) {
      $logger->debug('Calling insertVane');
      $db->insertVane($data['vane']);
    }

    if (isset($data['picture'])) {
      $logger->debug('Calling insertPicture');
      $db->insertPicture($data['picture']);
    }

    if (isset($data['door'])) {
      $db->insertDoor($data['door']);
    }
    

    if (isset($data['pilots'])) {
      $db->insertPilotCount($data['pilots']);
    }

    if (isset($data['adc'])) {
      $db->insertAdcValues($data['adc']);
    }

    if (isset($data['status'])) {
      $db->insertStatus($data['status']);
    }

    $db->commit();
    
    if ($meteotemplateEnabled == 1) {
      $logger->debug('Calling meteotemplate');
      $meteotemplatePASS = get($config['s:meteotemplate_password']);
      $meteotemplateURL = get($config['s:meteotemplate_API_URL']);
      $db->meteotemplate($meteotemplateURL, $meteotemplatePASS);
    }
    
    if ($wundergroundEnabled == 1) {
      $logger->debug('Calling wunderground');
      $wundergroundStation = get($config['s:wunderground_station']);
      $wundergroundPass = get($config['s:wunderground_password']);
      $wundergroundUrl = get($config['s:wunderground_API_URL']);
      $db->wunderground ($wundergroundUrl, $wundergroundStation, $wundergroundPass);
    }

    $response['status'] = 'ok';
    // TODO: Add support for reboot, shutdown etc.
  } catch (Exception $e) {
    $db->rollback();
    $logger->critical('Exception in ul.php: '.$e);
    $response['status'] = 'failure: '.$e;
  }
  return $response;
}

$jsonResponse = json_encode(handleRequest());
echo $jsonResponse;
Logger::Instance()->debug('RESPONSE: '.$jsonResponse);
?>
