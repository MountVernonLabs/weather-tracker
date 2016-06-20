<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "mv-dev";

$date = '2016-06-17';
$end_date = '1945-01-01';

date_default_timezone_set('America/New_York');

 while (strtotime($date) >= strtotime($end_date)) {
      // Show Year
      echo "Getting weather for ".date("Y-m-d",strtotime($date))."\n";

      $weather_data = file_get_contents("https://www.wunderground.com/history/airport/KDAA/".date("Y",strtotime($date))."/".date("n",strtotime($date))."/".date("j",strtotime($date))."/DailyHistory.html?req_city=Mount+Vernon&req_state=VA&req_statename=Virginia&reqdb.zip=22121&reqdb.magic=1&reqdb.wmo=99999&format=2");
      $weather_data = str_replace("<br />","",$weather_data);

      $weather_entries = explode("\n",$weather_data);

      foreach ($weather_entries as $entry){
          $data = explode(",",$entry);
          if ($data[0] == "TimeEDT" || $data[0]==""){}else{
            //echo $data[0]."\n";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $timestamp = new DateTime($data[13], new DateTimeZone('UTC'));
            $timestamp->setTimezone(new DateTimeZone('America/New_York'));

            $sql = "INSERT INTO weather (temp,humidity,pressure,visability,wind_speed,precipitiation,weather,description,wind_direction,time)
            VALUES (".round($data[1]).",".round($data[3]).",".round(33.8638816*$data[4]).",".round($data[5]).",".round($data[7]).",".round($data[9]).",'".$data[10]."','".strtolower($data[11])."',".round($data[12]).",'".$timestamp->format('Y-m-d H:i:s')."')";

            if ($conn->query($sql) === TRUE) {
                //echo "New record created successfully\n";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();

          }
      }
      $date = date("Y-m-d", strtotime("-1 day", strtotime($date)));
      sleep(10);

 }




?>
