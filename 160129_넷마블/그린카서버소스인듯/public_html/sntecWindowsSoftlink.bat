@echo off
setlocal

REM SNTEC 윈도우 소프트 링크
REM 로컬 소스의 DocumentRoot 경로 수정후 사용

REM set sntecLocalPath="D:\workspace_php\SNTEC\public_html"
REM cd %sntecLocalPath%

echo 로컬 소스의 DocumentRoot 경로를 입력하세요.
echo  ex)D:\src\SNTEC\public_html
set /p documentRoot=DocumentRoot : 

echo.
echo 입력하신 경로는 %documentRoot% 입니다.
set /p yesOrNo=맞으면 y를 넣어주세요 :

if "%yesOrNo%" == "y" goto symlink
if /i "%yesOrNo%" != "y" goto outWay

:symlink
cd %documentRoot%
mklink /d ".\himg" ".\www\himg"
mklink /d ".\common" ".\www\common" 
cd shopAdmin
mklink /d ".\include" "..\www\web\shopAdmin\include"
mklink /d ".\common" "..\www\web\shopAdmin\common"
mklink /d ".\himg" "..\www\web\shopAdmin\himg"

:outWay
echo 종료합니다.


pause
