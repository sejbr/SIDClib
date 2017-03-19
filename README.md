# SIDClib - SteamID convertion library
PHP SteamID convertion library

# Properties

* ###### steamid:
SteamID32 [STEAM_0:1:38106821]

* ###### steam3:
AccountID/Steam3 [[U:1:76213643]]
    
* ###### communityid:
CommunityID/SteamID64 [76561197960265728]

# Methods

* ###### getArr():
    Returns Array of all SteamID's

* ###### Supports JsonSerialization of the instance via:
    `json_encode($instance)`


# Example usage

### Code

  ```php
  $steamid = new sidc('STEAM_0:1:38106821');

  echo $steamid->steamid;
  echo $steamid->steam3;
  echo $steamid->communityid;

  var_dump($steamid->getArr());

  echo json_encode($instance);
  ```

### Output:

  ```
  STEAM_0:1:38106821
  [U:1:76213643]
  76561198036479371

  array(3) {
    ["steamid"]=>
    string(18) "STEAM_0:1:38106821"
    ["steam3"]=>
    string(14) "[U:1:76213643]"
    ["communityid"]=>
    string(17) "76561198036479371"
  }

  {\"steamid\":\"STEAM_0:1:38106821\",\"steam3\":\"[U:1:76213643]\",\"communityid\":\"76561198036479371\"}
  ```


# Required
BC (Included in PHP since v4.0.4)
