#!/bin/bash
 
findpath=./
logfile=findtrojan.log
 
echo -e $(date +%Y-%m-%d_%H:%M:%S)" start\r" >>$logfile
echo -e '============changetime list==========\r\n' >> ${logfile}
find ${findpath} -name "*.php" -ctime -3 -type f -exec ls -l {} \; >> ${logfile}
 
echo -e '============nouser file list==========\r\n' >> ${logfile}
find  ${findpath} -nouser -nogroup -type f -exec ls -l {} \; >> ${logfile}
 
echo -e '============php one word trojan ==========\r\n' >> ${logfile}
find ${findpath} -name "*.php" -exec egrep -I -i -C1 -H  'exec\(|eval\(|assert\(|system\(|passthru\(|shell_exec\(|escapeshellcmd\(|pcntl_exec\(|gzuncompress\(|gzinflate\(|unserialize\(|base64_decode\(|file_get_contents\(|urldecode\(|str_rot13\(|\$_GET|\$_POST|\$_REQUEST|\$_FILES|\$GLOBALS' {} \; >> ${logfile}
#使用使用-l 代替-C1 -H 可以只打印文件名
echo -e $(date +%Y-%m-%d_%H:%M:%S)" end\r" >>$logfile

more $logfile
