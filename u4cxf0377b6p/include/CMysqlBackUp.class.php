<?
class CMysqlBackUp
{
    var $strDir;
   var $strUrl='/'. WS_PANEL .'/settings/backup_mysql/dump/';
    function __construct()
    {
       $this->strDir=$_SERVER['DOCUMENT_ROOT'].'/'. WS_PANEL .'/settings/backup_mysql/dump/';
   
    }
    public function CreateDump($tables="*")
    {
            global $db;
            $return='';
           
            if($tables == '*')
            {
                    $tables = array();
                    $result = mysql_query('SHOW TABLES');
                    while($row = mysql_fetch_row($result))
                    {
                            $tables[] = $row[0];
                    }
            }
            else
            {
                    $tables = is_array($tables) ? $tables : explode(',',$tables);
            }
         
            foreach($tables as $table)
            {
                    $result = mysql_query('SELECT * FROM '.$table);
                    $num_fields = mysql_num_fields($result);
                    $return.= 'DROP TABLE IF NOT EXISTS '.$table.';';
                    $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
                    $return.= "\n\n".$row2[1].";\n\n";
                    for ($i = 0; $i < $num_fields; $i++)
                    {
                            while($row = mysql_fetch_row($result))
                            {
                                    $return.= 'INSERT INTO '.$table.' VALUES(';
                                    for($j=0; $j<$num_fields; $j++)
                                    {
                                            $row[$j] = @addslashes($row[$j]);
                                            $row[$j] = @ereg_replace("\n","\\n",$row[$j]);
                                            if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                                            if ($j<($num_fields-1)) { $return.= ','; }
                                    }
                                    $return.= ");\n";
                            }
                    }
                    $return.="\n\n\n";
            }
            if($return!='')
            {
                $strDumpName='db-backup-'.$_SERVER['HTTP_HOST'].'-'.time().'.sql';
                $handle = fopen($this->strDir.$strDumpName,'w+');
                fwrite($handle,$return);
                fclose($handle);
                return $strDumpName;  
            }
            else{
                return false;
            }
          
    }
    public function DeleteDump($strDumpName='')
    {
        if(empty($strDumpName))return false;
        if(!unlink($this->strDir.$strDumpName))return false;
        return true;
    }
	
}
?>