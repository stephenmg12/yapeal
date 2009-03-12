<?php
/* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=2: */

/**
 * Yapeal installer - Character Select for no JavaScript User.
 *
 *
 * PHP version 5
 *
 * LICENSE: This file is part of Yet Another Php Eve Api library also know as Yapeal.
 *  Yapeal is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Lesser General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Yapeal is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public License
 *  along with Yapeal. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Claus Pedersen <satissis@gmail.com>
 * @author Michael Cummings <mgcummings@yahoo.com>
 * @copyright Copyright (c) 2008-2009, Claus Pedersen, Michael Cummings
 * @license http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @package Yapeal
 */

/**
 * @internal Only let this code be included or required not ran directly.
 */
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
  exit();
}
// Check for c_action
check_c_action();
$config = $_POST['config'];
OpenSite('Character Selection',false,false);
/*
 * Set values
 */
if (conRev($ini_yapeal['version'])<471) {
  $oldrev = 417;
} else {
  $oldrev = conRev($ini_yapeal['version']);
}; // if (conRev($ini_yapeal['version'])<=471)
echo '<h2>'.ED_UPDATING_FROM_REV.' '.$oldrev.' '.ED_TO_REV.' '.$setupversion.'</h2>' . PHP_EOL;
if ($config['api_user_id'] !="" && ($config['api_limit_key'] !="" || $config['api_full_key'] !="")) {
  $params = array();
  $params['userID'] = $config['api_user_id'];
  if ($config['api_full_key'] !="") {
    $params['apiKey'] = $config['api_full_key'];
  } else {
    $params['apiKey'] = $config['api_limit_key'];
  };
  
  // poststring
  if (count($params) > 0) {
    $poststring = http_build_query($params, NULL, '&');
  } else {
    $poststring = "";
  };
  $ch = curl_init();
  $header = array(
    "Accept: text/xml,application/xml,application/xhtml+xml;q=0.9,text/html;q=0.8,text/plain;q=0.7,image/png;q=0.6,*/*;q=0.5",
    "Accept-Language: en-us;q=0.9,en;q=0.8,*;q=0.7",
    "Accept-Charset: utf-8;q=0.9,windows-1251;q=0.7,*;q=0.6",
    "Keep-Alive: 300"
  );
  $options = array(CURLOPT_URL => 'http://api.eve-online.com/account/Characters.xml.aspx',
                   CURLOPT_ENCODING => '',
                   CURLOPT_FOLLOWLOCATION => TRUE,
                   CURLOPT_HEADER => FALSE,
                   CURLOPT_MAXREDIRS => 5,
                   CURLOPT_RETURNTRANSFER => TRUE,
                   CURLOPT_SSL_VERIFYHOST => FALSE,
                   CURLOPT_SSL_VERIFYPEER => FALSE,
                   CURLOPT_VERBOSE => FALSE,
                   CURLOPT_USERAGENT => 'PHPApi',
                   CURLOPT_HTTPHEADER => $header,
                   CURLOPT_POST => TRUE,
                   CURLOPT_POSTFIELDS => $poststring
                  );
  curl_setopt_array($ch, $options);
  $content = curl_exec($ch);
  curl_close($ch);
  //echo $content.'<hr>';
  // create our xml parser
  try {
    $xml = new SimpleXMLElement($content);
  }
  catch (Exception $e) {
  }

  if ($xml) {
    if (isset($xml->error)) {
      /*
       * Show XML error is there is one
       */
      echo '<center><font class="warning">'.ERROR.': '.$xml->error.'</font></center>';
    } else {
      /*
       * Set some default values from the previus page
       */
      $characters = array();
      echo '<form action="'.$_SERVER['SCRIPT_NAME'].'?lang='.$_GET['lang'].'&amp;edit=go" method="post">' . PHP_EOL
          .'<input type="hidden" name="config[DB_Host]" value="'.$config['DB_Host'].'" />' . PHP_EOL
          .'<input type="hidden" name="config[DB_Username]" value="'.$config['DB_Username'].'" />' . PHP_EOL
          .'<input type="hidden" name="config[DB_Password]" value="'.$config['DB_Password'].'" />' . PHP_EOL
          .'<input type="hidden" name="config[DB_Database]" value="'.$config['DB_Database'].'" />' . PHP_EOL
          .'<input type="hidden" name="config[DB_Prefix]" value="'.$config['DB_Prefix'].'" />' . PHP_EOL
          .'<input type="hidden" name="config[db_action]" value="'.$config['db_action'].'" />' . PHP_EOL
          .'<input type="hidden" name="config[cache_xml]" value="'.DisableChecker($config['cache_xml']).'" />' . PHP_EOL
          .'<input type="hidden" name="config[db_account]" value="'.DisableChecker($config['db_account']).'" />' . PHP_EOL
          .'<input type="hidden" name="config[db_char]" value="'.DisableChecker($config['db_char']).'" />' . PHP_EOL
          .'<input type="hidden" name="config[db_corp]" value="'.DisableChecker($config['db_corp']).'" />' . PHP_EOL
          .'<input type="hidden" name="config[db_eve]" value="'.DisableChecker($config['db_eve']).'" />' . PHP_EOL
          .'<input type="hidden" name="config[db_map]" value="'.DisableChecker($config['db_map']).'" />' . PHP_EOL
          .'<input type="hidden" name="config[debug]" value="'.$config['debug'].'" />' . PHP_EOL
          .'<input type="hidden" name="config[api_user_id]" value="'.$config['api_user_id'].'" />' . PHP_EOL
          .'<input type="hidden" name="config[api_full_key]" value="'.$config['api_full_key'].'" />' . PHP_EOL
          .'<input type="hidden" name="config[config_pass]" value="'.$config['config_pass'].'" />' . PHP_EOL
          .'<input type="hidden" name="c_action" value="'.$_POST['c_action'].'" />' . PHP_EOL
      /*
       * List Characters
       */
          .'<table>' . PHP_EOL
          .'  <tr>' . PHP_EOL
          .'    <th colspan="2">'.INSTALLER_CHAR_SELECT.'</th>' . PHP_EOL
          .'  </tr>' . PHP_EOL;
      foreach ($xml->result->rowset->row as $row) {
        if ($conf['creatorCharacterID']==$row['characterID']) { $checked = ' checked="checked"'; } else { $checked = ''; };
        echo '<tr>' . PHP_EOL
            .'  <td width="15" style="vertical-align:middle;">' . PHP_EOL
            .'    <input type="radio" name="config[api_char_info]" value="'.$row['name'].'^-_-^'.$row['characterID'].'^-_-^'.$row['corporationName'].'^-_-^'.$row['corporationID'].'"'.$checked.' />' . PHP_EOL
            .'  </td>' . PHP_EOL
            .'  <td>' . PHP_EOL
            .'    <table style="background-color: #606060;">' . PHP_EOL
            .'      <tr>' . PHP_EOL
            .'        <td class="tableinfolbl" style="width: 64px;"><img src="http://img.eve.is/serv.asp?s=64&amp;c='.$row['characterID'].'" width="64" height="64" /></td>' . PHP_EOL
            .'        <td>'.$row['name'].'<br />'.$row['corporationName'].'</td>' . PHP_EOL
            .'      </tr>' . PHP_EOL
            .'    </table>' . PHP_EOL
            .'  </td>' . PHP_EOL
            .'</tr>' . PHP_EOL;
      };
      echo '</table><br />' . PHP_EOL
      /*
       * List API Selection for Character
       */
          .'<table>' . PHP_EOL
          .'  <tr>' . PHP_EOL
          .'    <th colspan="2">'.UPD_CHAR_API_PULL_SELECT.'</th>' . PHP_EOL
          .'  </tr>' . PHP_EOL
          .'  <tr>' . PHP_EOL
          .'    <td colspan="2" class="tableinfolbl" style="text-align:center;">'.UPD_CHAR_API_PULL_SELECT_DES.'</td>' . PHP_EOL
          .'  </tr>' . PHP_EOL;
      /*
       * Get the selected Character APIs from the database config
       */
      if (isset($conf['charAPIs'])) {
        $charSelectedAPIs = explode(" ",$conf['charAPIs']);
      } else {
        $charSelectedAPIs = array();
      }; // if is set $conf['charAPIs']
      /*
       * Build the Character API list
       */
      foreach ($charAPIs as $API=>$APIDes) {
			  if (in_array($API,$charSelectedAPIs)) { $check = ' checked="checked"'; } else { $check = ''; }; // if (in_array($API,$corpSelectedAPIs))
				echo '  <tr>' . PHP_EOL
            .'    <td width="15" style="vertical-align:middle;">' . PHP_EOL
            .'      <input type="checkbox" name="config[charAPIs][]" value="'.$API.'"'.$check.' />' . PHP_EOL
            .'    </td>' . PHP_EOL
            .'    <td>'.$APIDes.'</td>' . PHP_EOL
            .'  </tr>' . PHP_EOL;
      }
      /*
       * List API Selection for Corporation
       */
      echo '</table><br />' . PHP_EOL
          .'<table>' . PHP_EOL
          .'  <tr>' . PHP_EOL
          .'    <th colspan="2">'.UPD_CORP_API_PULL_SELECT.'</th>' . PHP_EOL
          .'  </tr>' . PHP_EOL
          .'  <tr>' . PHP_EOL
          .'    <td colspan="2" class="tableinfolbl" style="text-align:center;">'.UPD_CORP_API_PULL_SELECT_DES.'</td>' . PHP_EOL
          .'  </tr>' . PHP_EOL;
      /*
       * Get the selected Corporation APIs from the database config
       */
      if (isset($conf['corpAPIs'])) {
        $corpSelectedAPIs = explode(" ",$conf['corpAPIs']);
      } else {
        $corpSelectedAPIs = array();
      }; // if is set $conf['corpAPIs']
      /*
       * Build the Corporation API list
       */
      foreach ($corpAPIs as $API=>$APIDes) {
			  if (in_array($API,$corpSelectedAPIs)) { $check = ' checked="checked"'; } else { $check = ''; }; // if (in_array($API,$corpSelectedAPIs))
				echo '  <tr>' . PHP_EOL
            .'    <td width="15" style="vertical-align:middle;">' . PHP_EOL
            .'      <input type="checkbox" name="config[corpAPIs][]" value="'.$API.'"'.$check.' />' . PHP_EOL
            .'    </td>' . PHP_EOL
            .'    <td>'.$APIDes.'</td>' . PHP_EOL
            .'  </tr>' . PHP_EOL;
      }
      echo '</table>' . PHP_EOL
      /*
       * Add Submit button
       */
          .'<input type="submit" value="'.UPDATE.'" />' . PHP_EOL
          .'</form>' . PHP_EOL;
    };
  } else {
    /*
     * If API server is offline, notise the user
     */
    echo '<center><font class="warning">'.INSTALLER_ERROR_API_SERVER_OFFLINE.'</font></center>';
  };
} else {
  /*
   * If the API info is wrong, notise the user
   */
  echo INSTALLER_ERROR_NO_API_INFO;
};
CloseSite();
?>