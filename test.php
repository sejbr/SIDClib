<?php

require "sidclib.php";

$testACCID = new sidc('[U:1:76213643]');
$testSID32 = new sidc('STEAM_0:1:38106821');
$testSID64 = new sidc('76561198036479371');

echo PHP_EOL.'-->AccountID/Steam3 ([U:1:76213643]) input test: '.PHP_EOL;
echo $testACCID->steamid.PHP_EOL;
echo $testACCID->steam3.PHP_EOL;
echo $testACCID->communityid.PHP_EOL.PHP_EOL;

echo '-->SteamID/SteamID32 (STEAM_0:1:38106821) input test: '.PHP_EOL;
echo $testSID32->steamid.PHP_EOL;
echo $testSID32->steam3.PHP_EOL;
echo $testSID32->communityid.PHP_EOL.PHP_EOL;

echo '-->SteamID64/CommunityID (76561198036479371) input test: '.PHP_EOL;
echo $testSID64->steamid.PHP_EOL;
echo $testSID64->steam3.PHP_EOL;
echo $testSID64->communityid.PHP_EOL.PHP_EOL;

echo '-->Array output test: '.PHP_EOL;
var_dump($testSID32->getArr());

echo PHP_EOL.'-->JSONSerialization output test: '.PHP_EOL;
echo json_encode($testSID32).PHP_EOL.PHP_EOL;
