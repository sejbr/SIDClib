<?php

/**
 * SteamID converting lib.
 * Can receive any kind of SteamID (SteamID/SteamID32, Steam3/AccID, SteamID64/CommunityID)
 * Usage:
 *  $instance = new SIDC('ID')
 *  $instance->[PropertyName] I.e. $instance->steamid
 * Properties:
 *  steamid - SteamID32 [STEAM_0:1:38106821]
 *  steam3 - AccountID/Steam3 [[U:1:76213643]]
 *  communityid - CommunityID/SteamID64 [76561197960265728]
 * Json Serialization:
 *  json_encode($instance)
 */
class SIDC implements JsonSerializable {

  private $steamid;
  private $steam3;
  private $communityid;

  /**
   * Construct method formatting the ID's
   * @method __construct
   * @param  string      $input Any kind of SteamID
   */
  function __construct($input)
  {
      if(ctype_digit($input))
      {
        //Process CommunityID matched ID
        $this->communityid = $input;
        $this->steamid = $this->SID64toSID($input);
        $this->steam3 = $this->SID64toACC($input);
      }
      elseif(preg_match('/^STEAM_0:[01]:[0-9]+/', $input))
      {
        //Process SteamID matched ID
        $this->steamid = $input;
        $this->communityid = $this->SIDtoSID64($input);
        $this->steam3 = $this->SIDtoACC($input);
      }
      elseif(preg_match('/U:+/', $input))
      {
        //Process Steam3 matched ID
        $this->steam3 = $input;
        $input = str_replace(array("[", "]"), '', $input);
        $this->steamid = $this->ACCtoSID($input);
        $this->communityid = $this->ACCtoSID64($input);
      }
      else
      {
        throw new Exception("Input doesn't match required criteria!", 1);
      }
  }

  /**
   * Setter prevention notice
   * @method __set
   * @param  string $name  Property name
   * @param  string $value Property value
   */
  public function __set($name, $value) {
    trigger_error("Cannot change properties of ".__CLASS__." instance!", E_USER_NOTICE);
  }

  /**
   * Properties getter
   * @method __get
   * @param  string $name  Property name
   */
  public function __get($name) {
    if(!isset($this->$name)) {
      return null;
    }

    return $this->$name;
  }

  /**
   * Method converting SteamID64/CommunityID [76561198036479371] to SteamID32 [STEAM_0:1:38106821]
   * @method SID64toSID
   * @param  string     $input CommunityID/SteamID64 String
   */
  private function SID64toSID($input)
  {
    $authsrv = bcsub($input, '76561197960265728') & 1;
    $authid = (bcsub($input, '76561197960265728') - $authsrv) / 2;
    return 'STEAM_0:'.$authsrv.':'.$authid;
  }

  /**
   * Method converting SteamID64/CommunityID [76561198036479371] to Steam3/AccountID [[U:1:76213643]]
   * @method SID64toACC
   * @param  string     $input CommunityID/SteamID64 String
   */
  private function SID64toACC($input)
  {
    $input = $this->SID64toSID($input);
    return $this->SIDtoACC($input);
  }

  /**
   * Method converting SteamID32 [STEAM_0:1:38106821] to SteamID64/CommunityID [76561198036479371]
   * @method SIDtoSID64
   * @param  string     $input SteamID32 String
   */
  private function SIDtoSID64($input)
  {
    $parts = explode(':', $input);
    return bcadd(bcadd(bcmul($parts[2], '2'), '76561197960265728'), $parts[1]);
  }

  /**
   * Method converting SteamID32 [STEAM_0:1:38106821] to AccountID/Steam3 [[U:1:76213643]]
   * @method SIDtoACC
   * @param  string   $input SteamID32 String
   */
  private function SIDtoACC($input)
  {
    $parts = explode(':', $input);
    return '[U:1:' . (($parts[2] * 2) + $parts[1]) . ']';
  }

  /**
   * Method converting AccountID/Steam3 [[U:1:76213643]] to SteamID32 [STEAM_0:1:38106821]
   * @method ACCtoSID
   * @param  string   $input AccountID/Steam3 String
   */
  private function ACCtoSID($input)
  {
    $parts = explode(':', str_replace(array("[", "]"), "", $input));

    if(is_int($id = $parts[2] / 2))
    {
      return 'STEAM_0:0:'.$id;
    }

    $id = ($parts[2] - 1) / 2;
    return 'STEAM_0:1:'.$id;
  }

  /**
   * Method converting AccountID/Steam3 [[U:1:76213643]] to SteamID64/CommunityID [76561198036479371]
   * @method ACCtoSID64
   * @param  string     $input AccountID/Steam3 String
   */
  private function ACCtoSID64($input)
  {
    $input = $this->ACCtoSID($input);
    return $this->SIDtoSID64($input);
  }

  /**
   * IDs array getter
   * @method getIds
   * @return array Steamid's array ('steamid' => val, 'steam3' => val, 'communityid' => val)
   */
  public function getArr()
  {
    return array('steamid' => $this->steamid, 'steam3' => $this->steam3, 'communityid' => $this->communityid);
  }

  /**
   * JsonSerialization processing for class serialization json_encode($instance)
   * @method jsonSerialize
   * @return string        JsonSerialization
   */
  public function jsonSerialize() {
    return json_encode(array('steamid' => $this->steamid, 'steam3' => $this->steam3, 'communityid' => $this->communityid));
  }

}
