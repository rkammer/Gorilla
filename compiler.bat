@echo off
echo Building com_gorilla
 
set str= %date:~4,2%.%date:~7,2%.%date:~10,4%.%time:~0,2%.%time:~3,2%
set str=%str: =%
 
cd\
cd Documents and Settings\rkammer\My Documents\sandbox\gorilla\component
7za a -tzip -r com_gorilla.%str%.zip *.*
 
copy com_gorilla.%str%.zip Z:\Common\Products\Gorilla\Builds\com_gorilla.%str%.zip
del com_gorilla.%str%.zip