<?php 
function delOld(){
$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error");
mysql_select_db("datalogger");
$q="delete from datalogger"; 
mysql_query($q);
mysql_close($db); 
return 0;
}

function hist($sensor){ 
$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error"); 
mysql_select_db("datalogger"); 
for ($i=0;$i<=23;$i++) 
{ 
        if($sensor == 6 or $sensor == 7 or $sensor == 8){
                $q=   "insert into history (date_time, sensor, temperature, humidity)( "; 
                $q=$q."select date_add(curdate(),interval $i hour),'$sensor', round(avg(temperature),2),round(avg(humidity),2)"; 
                $q=$q."from datalogger "; 
                $q=$q."where sensor = '$sensor' "; 
                $q=$q."and date_time >=date_add(curdate(),interval $i hour) ";$ii=$i+1; 
                $q=$q."and date_time < date_add(curdate(),interval $ii hour) "; 
                $q=$q.") "; 
                mysql_query($q); 
                //$res = mysql_query($q); 
        	//echo "query=".$q ;
        	//echo "res=".$res;
        	//echo " err=". mysql_error();
                
        }elseif ($sensor == 0) {
                $q=   "insert into history (date_time, sensor, moisture)( "; 
                $q=$q."select date_add(curdate(),interval $i hour),'$sensor', round(avg(moisture),2)"; 
                $q=$q."from datalogger "; 
                $q=$q."where sensor = '$sensor' "; 
                $q=$q."and date_time >=date_add(curdate(),interval $i hour) ";$ii=$i+1; 
                $q=$q."and date_time < date_add(curdate(),interval $ii hour) "; 
                $q=$q.") "; 
                mysql_query($q); 
                //$res = mysql_query($q); 
        	//echo "query=".$q ;
        	//echo "res=".$res;
        	//echo " err=". mysql_error();
                
        }else{
                $q=   "insert into history (date_time, sensor, quality)( "; 
                $q=$q."select date_add(curdate(),interval $i hour),'$sensor', round(avg(quality),2)"; 
                $q=$q."from datalogger "; 
                $q=$q."where sensor = '$sensor' "; 
                $q=$q."and date_time >=date_add(curdate(),interval $i hour) ";$ii=$i+1; 
                $q=$q."and date_time < date_add(curdate(),interval $ii hour) "; 
                $q=$q.") "; 
                mysql_query($q); 
                //$res = mysql_query($q); 
                //echo "query=".$q ;
                //echo "res=".$res;
                //echo " err=". mysql_error();
                
        }
} 
mysql_close($db); 
return 0; 
} 
hist(0); 
hist(1); 
hist(6); 
hist(7); 
hist(8); 
// delOld();
?>

