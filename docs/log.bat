set date_tmp=%date:/=%
set time_tmp=%time: =0%
set yyyy=%date_tmp:~0,4%
set yy=%date_tmp:~2,2%
set mm=%date_tmp:~4,2%
set dd=%date_tmp:~6,2%
set hh=%time_tmp:~0,2%
set mi=%time_tmp:~3,2%
set ss=%time_tmp:~6,2%
set sss=%time_tmp:~9,2%
rem tail -f ..\fuel\app\logs\%yyyy%\%mm%\%dd%.php
tail -f ..\fuel\app\logs\%yyyy%\%mm%\%dd%.php
pause