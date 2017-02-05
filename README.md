# steamid_convertlib
PHP SteamID converting library

# Usage
$var = new steamid('STEAMID');

$var->steamid;

$var->steam3;

$var->communityid;

# Example

$steamid = new steamid('STEAM_0:1:38106821');

echo $steamid->steamid.PHP_EOL;

echo $steamid->steam3.PHP_EOL;

echo $steamid->communityid.PHP_EOL;

### Output:

STEAM_0:1:38106821

[U:1:76213643]

76561198036479371


# Required
BC (Included in PHP since v4.0.4)
