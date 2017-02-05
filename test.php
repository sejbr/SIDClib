<?php

require "steamid_convertlib.php";

$testACCID = new steamid('[U:1:76213643]');
$testSID32 = new steamid('STEAM_0:1:38106821');
$testSID64 = new steamid('76561198036479371');
echo $testACCID->steamid.PHP_EOL;
echo $testSID32->steamid.PHP_EOL;
echo $testSID64->steamid.PHP_EOL;
echo $testACCID->steam3.PHP_EOL;
echo $testSID32->steam3.PHP_EOL;
echo $testSID64->steam3.PHP_EOL;
echo $testACCID->communityid.PHP_EOL;
echo $testSID32->communityid.PHP_EOL;
echo $testSID64->communityid.PHP_EOL;
