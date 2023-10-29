<?php
file_put_contents("crontest.txt", "start-> ".date("d.m.Y H:i:s")."\n", FILE_APPEND);
file_put_contents($_SERVER['DOCUMENT_ROOT']."/cron/crontest.txt", "start-> ".date("d.m.Y H:i:s")."\n", FILE_APPEND);
?>