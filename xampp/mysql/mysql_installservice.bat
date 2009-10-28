@echo off 

if "%OS%" == "Windows_NT" goto WinNT 

:Win9X 
echo Don't be stupid! Win9x don't know Services 
echo Please use mysql_start.bat instead 
goto exit 

:WinNT 
echo Installing MySQL as an Service 
..\xampp_cli.exe installservice mysql
echo Try to start the MySQL deamon as service ... 
net start MySQL 

:exit 
pause
