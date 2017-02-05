<?php

/**
 * SteamID converting lib.
 * Can receive any kind of SteamID (SteamID/SteamID32, Steam3/AccID, SteamID64/CommunityID)
 * Usage $instance->[steamid/steam3/communityid]
 */
class steamid {

  var $input;
  var $steamid;
  var $steam3;
  var $communityid;

  /**
   * Construct method formatting the ID's
   * @method __construct
   * @param  string      $input Any kind of SteamID
   */
  function __construct($input)
  {
      if(ctype_digit($input))
      {
        $this->communityid = $input;
        $this->steamid = $this->SID64toSID($input);
        $this->steam3 = $this->SID64toACC($input);
      }
      elseif(preg_match('/^STEAM_0:[01]:[0-9]+/', $input))
      {
        $this->steamid = $input;
        $this->communityid = $this->SIDtoSID64($input);
        $this->steam3 = $this->SIDtoACC($input);
      }
      elseif(preg_match('/U:+/', $input))
      {
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
   * Method converting SteamID64/CommunityID [76561198036479371] to SteamID32 [STEAM_0:1:38106821]
   * @method SID64toSID
   * @param  string     $input CommunityID/SteamID64 String
   */
  function SID64toSID($input)
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
  function SID64toACC($input)
  {
    $input = $this->SID64toSID($input);
    return $this->SIDtoACC($input);
  }

  /**
   * Method converting SteamID32 [STEAM_0:1:38106821] to SteamID64/CommunityID [76561198036479371]
   * @method SIDtoSID64
   * @param  string     $input SteamID32 String
   */
  function SIDtoSID64($input)
  {
    $parts = explode(':', $input);
    return bcadd(bcadd(bcmul($parts[2], '2'), '76561197960265728'), $parts[1]);
  }

  /**
   * Method converting SteamID32 [STEAM_0:1:38106821] to AccountID/Steam3 [[U:1:76213643]]
   * @method SIDtoACC
   * @param  string   $input SteamID32 String
   */
  function SIDtoACC($input)
  {
    $parts = explode(':', $input);
    return '[U:1:' . (($parts[2] * 2) + $parts[1]) . ']';
  }

  /**
   * Method converting AccountID/Steam3 [[U:1:76213643]] to SteamID32 [STEAM_0:1:38106821]
   * @method ACCtoSID
   * @param  string   $input AccountID/Steam3 String
   */
  function ACCtoSID($input)
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
  function ACCtoSID64($input)
  {
    $input = $this->ACCtoSID($input);
    return $this->SIDtoSID64($input);
  }

}
