# weather-tracker
Simple PHP script that pulls the weather every X minutes and stores the values in a MySQL database

# setup
1. Clone repository
2. Add SQL/weather.sql to your MySQL database
3. Configure config.php with your own connection database
4. Sign-up for an API key at http://openweathermap.org/appid
5. run php weather.php in your terminal

# historical weather
You can now also populate the table with historical weather from weather underground.  Just open historical.php and modify your start and end date.  Then from the terminal run php historial.php
