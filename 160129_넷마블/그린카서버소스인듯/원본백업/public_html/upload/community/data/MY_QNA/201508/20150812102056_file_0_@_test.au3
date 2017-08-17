6
;Login info;
$Path = "C:\Program Files\World of Warcraft\WoW.exe";Default path
$Accountname = "Account Name"; Put your WoW account name there..
$Pass = "Account Password";Put your WoW password there...
;;;;;;;;;;;;;;;;;;;;;;;;;;;;;

Logon()

Func Logon()
If WinExists("World of Warcraft") Then
$hWnd = WinGetHandle("World Of Warcraft");Handle of WoW, for controlsend
Sleep(100)

ControlSend($hWnd, "", "", $Accountname);Sends it to the game, wether your in game or not. Account name.
Sleep(100)

ControlSend($hWnd, "", "", "{TAB}");Moves down to the password field.
Sleep(100)

ControlSend($hWnd, "", "", $Pass);Sends it to the game, wether your in game or not.
Sleep(100)

ControlSend($hWnd, "", "", "{ENTER}");Moves down to the password field.
Sleep(100)

Else
Run($Path, "")
Sleep(8000);25 seconds is a bit much...
$hWnd = WinGetHandle("World Of Warcraft");Handle of WoW, for controlsend
Sleep(100)

ControlSend($hWnd, "", "", "Accountname");Sends it to the game, wether your in game or not. Account name.
Sleep(100)

ControlSend($hWnd, "", "", "{TAB}");Moves down to the password field.
Sleep(100)

ControlSend($hWnd, "", "", "AccountPassword");Sends it to the game, wether your in game or not.
Sleep(100)

ControlSend($hWnd, "", "", "{ENTER}");Moves down to the password field.
Sleep(100)
EndIf

EndFunc


just simply type your Account name and Password where its suppose to go. also if you have wow installing another place change the Path thats highlighted in red also. Now once you've edit the script whether you put it in notepad or AutoIT you must save it so lets save it as login.au3 then run it and voila you now have a script that will open wow and login for you.

;Login info;
$Path = "C:\Program Files\World of Warcraft\WoW.exe";Default path
$Accountname = "Account Name"; Put your WoW account name there..
$Pass = "Account Password";Put your WoW password there...
;;;;;;;;;;;;;;;;;;;;;;;;;;;;;