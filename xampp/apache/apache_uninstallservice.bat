@echo off

if "%OS%" == "Windows_NT" goto WinNT

:Win9X
echo Don't be stupid! Win9x don't know Services
echo Please use apache_stop.bat instead
goto exit

:WinNT
echo Are you sure you wan't this?
echo now stopping Apache2.2 when it runs
net stop Apache2.2
echo Time to say good bye to Apache2.2 :(
..\xampp_cli.exe deinstallservice apache

:exit
pause
