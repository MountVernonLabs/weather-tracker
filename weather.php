<?
date_default_timezone_set('America/New_York');
function convertKelvin($temp){
	$f = round((1.8 * ($temp-273)+32));
	return $f;
}

function convertEpoch($time){
	$time = $time - 18000;
	$dt = new DateTime("@$time");
	$phpdate = $dt->format('Y-m-d H:i:s');
	return $phpdate;
}

include "config.php";

$json = file_get_contents("http://api.openweathermap.org/data/2.5/weather?zip=".$zip.",us");
$data = json_decode($json);

mysql_connect($mysql_host, $mysql_login, $mysql_pass) or die(mysql_error());
mysql_select_db("weather") or die(mysql_error());

echo convertEpoch($data->sys->sunrise);

mysql_query("INSERT INTO weather (sunrise, sunset, weather, description, temp, pressure, humidity, temp_min, temp_max, wind_speed, wind_direction, cloud_coverage) VALUES ('".convertEpoch($data->sys->sunrise)."','".convertEpoch($data->sys->sunset)."','".$data->weather{0}->main."','".$data->weather{0}->description."',".convertKelvin($data->main->temp).",".round($data->main->pressure).",".round($data->main->humidity).",".convertKelvin($data->main->temp_min).",".convertKelvin($data->main->temp_max).",".round($data->wind->speed).",".round($data->wind->deg).",".round($data->clouds->all).") ") or die(mysql_error());  

?>