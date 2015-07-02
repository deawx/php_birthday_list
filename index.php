<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<!--
    Using JavaScript To Perform A Task Traditionally Solved With Server-Side Scripting
    Copyright (C) 2009 Doug Vanderweide
    
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
    -->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Using JavaScript To Perform A Task Traditionally Solved With Server-Side Scripting Example 1: Standard PHP / MySQL Approach</title>
        <link href="../demo.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
    	<h1>
        	Using JavaScript To Perform A Task Traditionally Solved With Server-Side Scripting<br />
            Example 1: Standard PHP / MySQL Approach
        </h1>
        <h3>This Week's Birthdays</h3>
		<?php
        //connect to db server
		if(!$link = mysql_connect('host', 'user', 'password')) {
			echo "<p><strong>Could not connect to database server.</strong></p>\n";	
		}
		//select database
		elseif(!mysql_select_db('database_name')) {
			echo "<p><strong>Could not select database.</strong></p>\n";
		}
		else {
			//get today's date info
			$today = getdate(1242171456);
			
			/*
			OPTION 1: This week only. Birthdays falling between Sunday and Saturday of this week are shown.
			*/
			
			//find the sunday of this week
			$sun = time() - (86400 * $today['wday']);
			//find the saturday of this week
			$sat = time() + ((6 - $today['wday']) * 86400);
			
			//get month and day for each
			$sun_mon = date('m', $sun);
			$sun_day = date('d', $sun);
			$sat_mon = date('m', $sat);
			$sat_day = date('d', $sat);
		
			//get records
			if(!$rs = mysql_query("SELECT person_name, person_surname, person_birthdate, person_department FROM table_name WHERE MONTH(person_birthdate) >= $sun_mon AND MONTH(person_birthdate) <= $sat_mon AND DAYOFMONTH(person_birthdate) >= $sun_day AND DAYOFMONTH(person_birthdate) <= $sat_day ORDER BY MONTH(person_birthdate), DAYOFMONTH(person_birthdate), person_surname, person_name, person_department")) {
				echo "<p><strong>There was an error parsing the query.</strong></p>\n";
			}
			//no records found
			elseif(mysql_num_rows($rs) == 0) {
				echo "<p><strong>No staff birthdays this week.</strong></p>\n";
			}
			else {
				echo "<p>Option 1: This week's birthdays</p>\n";
				//output birthdays
				echo "<table class=\"bordered\" cellspacing=\"0\">\n";
				echo "<tr><th>Name</th><th>Birthday</th><th>Age</th><th>Department</th></tr>\n";
				while($row = mysql_fetch_array($rs)) {
					$age = time() - strtotime($row['person_birthdate']);
					$age = floor($age / 31536000);
					
					echo "<tr>";
					echo "<td>$row[person_name] $row[person_surname]</td>";
					echo "<td>" . date('F j, Y', strtotime($row['person_birthdate'])) . "</td>";
					echo "<td>$age</td>";
					echo "<td>$row[person_department]</td>";
					echo "</tr>\n";
				}
				echo "</table><br />\n";
			}
			
			/*
			OPTION 2: Today and six days hence.
			*/
			
			//get starting and ending months and days
			$end = 1242171456 + 518400;
			$start_month = date('m', 1242171456);
			$start_day = date('d', 1242171456);
			$end_month = date('m', $end);
			$end_day = date('d', $end);
			
			//get records
			if(!$rs = mysql_query("SELECT person_name, person_surname, person_birthdate, person_department FROM table_name WHERE MONTH(person_birthdate) >= $start_month AND MONTH(person_birthdate) <= $end_month AND DAYOFMONTH(person_birthdate) >= $start_day AND DAYOFMONTH(person_birthdate) <= $end_day ORDER BY MONTH(person_birthdate), DAYOFMONTH(person_birthdate), person_surname, person_name, person_department")) {
				echo "<p><strong>There was an error parsing the query.</strong></p>\n";
			}
			//no records found
			elseif(mysql_num_rows($rs) == 0) {
				echo "<p><strong>No staff birthdays this week.</strong></p>\n";
			}
			else {
				echo "<p>Option 2: Today and six days hence; also shows only birth month and day</p>\n";
				//output birthdays
				echo "<table class=\"bordered\" cellspacing=\"0\">\n";
				echo "<tr><th>Name</th><th>Birthday</th><th>Department</th></tr>\n";
				while($row = mysql_fetch_array($rs)) {
					echo "<tr>";
					echo "<td>$row[person_name] $row[person_surname]</td>";
					echo "<td>" . date('F j', strtotime($row['person_birthdate'])) . "</td>";
					echo "<td>$row[person_department]</td>";
					echo "</tr>\n";
				}
				echo "</table><br />\n";
			}
        }
        ?>
        <p><em>For demo purposes, the date of May 12, 2009 is being used.</em></p>
        <p><a href="javascript.html">Example 2: JavaScript Approach</a></p>
        <p><a href="http://www.dougv.com/blog/2009/05/13/using-javascript-to-perform-a-task-traditionally-solved-with-server-side-scripting/">Using JavaScript To Perform A Task Traditionally Solved With Server-Side Scripting</a></p>
    </body>
</html>
