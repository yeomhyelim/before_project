@echo off
setlocal

REM SNTEC ������ ����Ʈ ��ũ
REM ���� �ҽ��� DocumentRoot ��� ������ ���

REM set sntecLocalPath="D:\workspace_php\SNTEC\public_html"
REM cd %sntecLocalPath%

echo ���� �ҽ��� DocumentRoot ��θ� �Է��ϼ���.
echo  ex)D:\src\SNTEC\public_html
set /p documentRoot=DocumentRoot : 

echo.
echo �Է��Ͻ� ��δ� %documentRoot% �Դϴ�.
set /p yesOrNo=������ y�� �־��ּ��� :

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
echo �����մϴ�.


pause
