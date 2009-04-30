<?php
/*******************************************************************************
 *                         MySQL Database Class
 *******************************************************************************
 *      Author:     Micah Carrick
 *      Email:      email@micahcarrick.com
 *      Website:    http://www.micahcarrick.com
 *
 *      File:       db.class.php
 *      Version:    1.0.4
 *      Copyright:  (c) 2005 - Micah Carrick 
 *                  You are free to use, distribute, and modify this software 
 *                  under the terms of the GNU General Public License.  See the
 *                  included license.txt file.
 *      
 *******************************************************************************
 *  VERION HISTORY:
 *  
 *      v1.0.4 [07.06.2005] - Added ability to add NULL values in update_array
 *                            and insert_array functions.
 *      v1.0.3 [05.10.2005] - Fixed bug in update_array funciton
 *      v1.0.2 [05.09.2005] - Fixed select_one function for queries returning 0
 *      v1.0.1 [04.28.2005] - Fixed bug in select_one function (returned null!)
 *      v1.0.0 [04.17.2005] - Initial Version
 *
 *******************************************************************************
 *  DESCRIPTION:
 *
 *      This class aids in MySQL database connectivity. It was written with
 *      my specific needs in mind.  It simplifies the database tasks I most
 *      often need to do thus reducing redundant code.  It is also written
 *      with the mindset to provide easy means of debugging erronous sql and
 *      data during the development phase of a web application.
 *
 *      The future may call for adding a slew of other features, however, at
 *      this point in time it just has what I often need.  I'm not trying to
 *      re-write phpMyAdmin or anything.  :)  Hope you find it  useful.
 *
 *      A screenshot and sample script can be found on my website.
 *
 *******************************************************************************
 */

// constants used by class
define('MYSQL_TYPES_NUMERIC', 'int real ');
define('MYSQL_TYPES_DATE', 'datetime timestamp year date time ');
define('MYSQL_TYPES_STRING', 'string blob ');

class db_class {
 
   var $last_error;         // holds the last error. Usually mysql_error()
   var $last_query;         // holds the last query executed.
   var $row_count;          // holds the last number of rows from a select
   
   var $host;               // mySQL host to connect to
   var $user;               // mySQL user name
   var $pw;                 // mySQL password
   var $db;                 // mySQL database to select

   var $db_link;            // current/last database link identifier
   var $auto_slashes;       // the class will add/strip slashes when it can
   
   function db_class() {
   
      // class constructor.  Initializations here.
      
      // Setup your own default values for connecting to the database here. You
      // can also set these values in the connect() function and using
      // the select_database() function.
      
      $this->host = 'localhost';
      $this->user = '';
      $this->pw = '';
      $this->db = '';
 
      $this->auto_slashes = true;
   }

   function connect($host='', $user='', $pw='', $db='', $persistant=true) {
 
      // Opens a connection to MySQL and selects the database.  If any of the
      // function's parameter's are set, we want to update the class variables.  
      // If they are NOT set, then we're giong to use the currently existing
      // class variables.
      // Returns true if successful, false if there is failure.  
      
      if (!empty($host)) $this->host = $host; 
      if (!empty($user)) $this->user = $user; 
      if (!empty($pw)) $this->pw = $pw; 

 
      // Establish the connection.
      if ($persistant) 
         $this->db_link = mysql_pconnect($this->host, $this->user, $this->pw);
      else 
         $this->db_link = mysql_connect($this->host, $this->user, $this->pw);
 
      // Check for an error establishing a connection
      if (!$this->db_link) {
         $this->last_error = mysql_error();
         return false;
      } 
  
      // Select the database
      if (!$this->select_db($db)) return false;
 
      return $this->db_link;  // success
   }

   function select_db($db='') {
 
      // Selects the database for use.  If the function's $db parameter is 
      // passed to the function then the class variable will be updated.
 
      if (!empty($db)) $this->db = $db; 
      
      if (!mysql_select_db($this->db)) {
         $this->last_error = mysql_error();
         return false;
      }
 
      return true;
   }
   
   function select($sql) {
      
      // Performs an SQL query and returns the result pointer or false
      // if there is an error.
 
      $this->last_query = $sql;
      
      $r = mysql_query($sql);
      if (!$r) {
         $this->last_error = mysql_error();
         return false;
      }
      $this->row_count = mysql_num_rows($r);
      return $r;
   }

   function select_one($sql) {
 
      // Performs an SQL query with the assumption that only ONE column and
      // one result are to be returned.
      // Returns the one result.
 
      $this->last_query = $sql;
      
      $r = mysql_query($sql);
      if (!$r) {
         $this->last_error = mysql_error();
         return false;
      }
      if (mysql_num_rows($r) > 1) {
         $this->last_error = "Your query in function select_one() returned more that one result.";
         return false;     
      }
      if (mysql_num_rows($r) < 1) {
         $this->last_error = "Your query in function select_one() returned no results.";        
         return false;
      }
      $ret = mysql_result($r, 0);
      mysql_free_result($r);
      if ($this->auto_slashes) return stripslashes($ret);
      else return $ret;
   }
   
   function get_row($result, $type='MYSQL_BOTH') {
 
      // Returns a row of data from the query result.  You would use this
      // function in place of something like while($row=mysql_fetch_array($r)). 
      // Instead you would have while($row = $db->get_row($r)) The
      // main reason you would want to use this instead is to utilize the
      // auto_slashes feature.
      
      if (!$result) {
         $this->last_error = "Invalid resource identifier passed to get_row() function.";
         return false;  
      }
      
      if ($type == 'MYSQL_ASSOC') $row = mysql_fetch_array($result, MYSQL_ASSOC);
      if ($type == 'MYSQL_NUM') $row = mysql_fetch_array($result, MYSQL_NUM);
      if ($type == 'MYSQL_BOTH') $row = mysql_fetch_array($result, MYSQL_BOTH); 
      
      if (!$row) return false;
      if ($this->auto_slashes) {
         // strip all slashes out of row...
         foreach ($row as $key => $value) {
            $row[$key] = stripslashes($value);
         }
      }
      return $row;
   }
   
   function dump_query($sql) {
   
      // Useful during development for debugging  purposes.  Simple dumps a 
      // query to the screen in a table.
 
      $r = $this->select($sql);
      if (!$r) return false;
      echo "<div style=\"border: 1px solid blue; font-family: sans-serif; margin: 8px;\">\n";
      echo "<table cellpadding=\"3\" cellspacing=\"1\" border=\"0\" width=\"100%\">\n";
      
      $i = 0;
      while ($row = mysql_fetch_assoc($r)) {
         if ($i == 0) {
            echo "<tr><td colspan=\"".sizeof($row)."\"><span style=\"font-face: monospace; font-size: 9pt;\">$sql</span></td></tr>\n";
            echo "<tr>\n";
            foreach ($row as $col => $value) {
               echo "<td bgcolor=\"#E6E5FF\"><span style=\"font-face: sans-serif; font-size: 9pt; font-weight: bold;\">$col</span></td>\n";
            }
            echo "</tr>\n";
         }
         $i++;
         if ($i % 2 == 0) $bg = '#E3E3E3';
         else $bg = '#F3F3F3';
         echo "<tr>\n";
         foreach ($row as $value) {
            echo "<td bgcolor=\"$bg\"><span style=\"font-face: sans-serif; font-size: 9pt;\">$value</span></td>\n";
         }
         echo "</tr>\n";
      }
      echo "</table></div>\n";
   }
   
   function insert_sql($sql) {
       
      // Inserts data in the database via SQL query.
      // Returns the id of the insert or true if there is not auto_increment
      // column in the table.  Returns false if there is an error.      
 
      $this->last_query = $sql;
      
      $r = mysql_query($sql);
      if (!$r) {
         $this->last_error = mysql_error();
         return false;
      }
      
      $id = mysql_insert_id();
      if ($id == 0) return true;
      else return $id; 
   }

   function update_sql($sql) {
 
      // Updates data in the database via SQL query.
      // Returns the number or row affected or true if no rows needed the update.
      // Returns false if there is an error.

      $this->last_query = $sql;
      
      $r = mysql_query($sql);
      if (!$r) {
         $this->last_error = mysql_error();
         return false;
      }
      
      $rows = mysql_affected_rows();
      if ($rows == 0) return true;  // no rows were updated
      else return $rows;
      
   }
   
   function insert_array($table, $data) {
      
      // Inserts a row into the database from key->value pairs in an array. The
      // array passed in $data must have keys for the table's columns. You can
      // not use any MySQL functions with string and date types with this 
      // function.  You must use insert_sql for that purpose.
      // Returns the id of the insert or true if there is not auto_increment
      // column in the table.  Returns false if there is an error.
      
      if (empty($data)) {
         $this->last_error = "You must pass an array to the insert_array() function.";
         return false;
      }
      
      $cols = '(';
      $values = '(';
      
      foreach ($data as $key=>$value) {     // iterate values to input
          
         $cols .= "$key,";  
         
         $col_type = $this->get_column_type($table, $key);  // get column type
         if (!$col_type) return false;  // error!
         
         // determine if we need to encase the value in single quotes
         if (is_null($value)) {
            $values .= "NULL,";   
         } 
         elseif (substr_count(MYSQL_TYPES_NUMERIC, "$col_type ")) {
            $values .= "$value,";
         }
         elseif (substr_count(MYSQL_TYPES_DATE, "$col_type ")) {
            $value = $this->sql_date_format($value, $col_type); // format date
            $values .= "'$value',";
         }
         elseif (substr_count(MYSQL_TYPES_STRING, "$col_type ")) {
            if ($this->auto_slashes) $value = addslashes($value);
            $values .= "'$value',";  
         }
      }
      $cols = rtrim($cols, ',').')';
      $values = rtrim($values, ',').')';     
      
      // insert values
      $sql = "INSERT INTO $table $cols VALUES $values";
      return $this->insert_sql($sql);
      
   }
   
   function update_array($table, $data, $condition) {
      
      // Updates a row into the database from key->value pairs in an array. The
      // array passed in $data must have keys for the table's columns. You can
      // not use any MySQL functions with string and date types with this 
      // function.  You must use insert_sql for that purpose.
      // $condition is basically a WHERE claus (without the WHERE). For example,
      // "column=value AND column2='another value'" would be a condition.
      // Returns the number or row affected or true if no rows needed the update.
      // Returns false if there is an error.
      
      if (empty($data)) {
         $this->last_error = "You must pass an array to the update_array() function.";
         return false;
      }
      
      $sql = "UPDATE $table SET";
      foreach ($data as $key=>$value) {     // iterate values to input
          
         $sql .= " $key=";  
         
         $col_type = $this->get_column_type($table, $key);  // get column type
         if (!$col_type) return false;  // error!
         
         // determine if we need to encase the value in single quotes
         if (is_null($value)) {
            $sql .= "NULL,";   
         } 
         elseif (substr_count(MYSQL_TYPES_NUMERIC, "$col_type ")) {
            $sql .= "$value,";
         }
         elseif (substr_count(MYSQL_TYPES_DATE, "$col_type ")) {
            $value = $this->sql_date_format($value, $col_type); // format date
            $sql .= "'$value',";
         }
         elseif (substr_count(MYSQL_TYPES_STRING, "$col_type ")) {
            if ($this->auto_slashes) $value = addslashes($value);
            $sql .= "'$value',";  
         }

      }
      $sql = rtrim($sql, ','); // strip off last "extra" comma
      if (!empty($condition)) $sql .= " WHERE $condition";
      
      // insert values
      return $this->update_sql($sql);
   }
   
   function execute_file ($file) {
 
      // executes the SQL commands from an external file.
      
      if (!file_exists($file)) {
         $this->last_error = "The file $file does not exist.";
         return false;
      }
      $str = file_get_contents($file);
      if (!$str) {
         $this->last_error = "Unable to read the contents of $file.";
         return false; 
      }
      
      $this->last_query = $str; 
      
      // split all the query's into an array
      $sql = explode(';', $str);
      foreach ($sql as $query) {
         if (!empty($query)) {
            $r = mysql_query($query);
 
            if (!$r) {
               $this->last_error = mysql_error();
               return false;
            }
         }
      }
      return true;
    
   }
   
   function get_column_type($table, $column) {
      
      // Gets information about a particular column using the mysql_fetch_field
      // function.  Returns an array with the field info or false if there is
      // an error.
 
      $r = mysql_query("SELECT $column FROM $table");
      if (!$r) {
         $this->last_error = mysql_error();
         return false;
      }
      $ret = mysql_field_type($r, 0);
      if (!$ret) {
         $this->last_error = "Unable to get column information on $table.$column.";
         mysql_free_result($r);
         return false;
      }
      mysql_free_result($r);
      return $ret;
      
   }
   
   function sql_date_format($value) {

      // Returns the date in a format for input into the database.  You can pass
      // this function a timestamp value such as time() or a string value
      // such as '04/14/2003 5:13 AM'. 
      
      if (gettype($value) == 'string') $value = strtotime($value);
      return date('Y-m-d H:i:s', $value);

   }
   function print_last_error($show_query=true) {
      
      // Prints the last error to the screen in a nicely formatted error message.
      // If $show_query is true, then the last query that was executed will
      // be displayed aswell.
 
      ?>
      <div style="border: 1px solid red; font-size: 9pt; font-family: monospace; color: red; padding: .5em; margin: 8px; background-color: #FFE2E2">
         <span style="font-weight: bold">db.class.php Error:</span><br><?= $this->last_error ?>
      </div>
      <?
      if ($show_query && (!empty($this->last_query))) {
      $this->print_last_query();
      }
 
   }

   function print_last_query() {
    
      // Prints the last query that was executed to the screen in a nicely formatted
      // box.
     
      ?>
      <div style="border: 1px solid blue; font-size: 9pt; font-family: monospace; color: blue; padding: .5em; margin: 8px; background-color: #E6E5FF">
         <span style="font-weight: bold">Last SQL Query:</span><br><?= str_replace("\n", '<br>', $this->last_query) ?>
      </div>
      <?  
   }
} 

?>
 