---
name: ftp-deploy
description: "Deploy theme files to HostGator via FTP. Use when uploading front-page.php, style.css, functions.php, or any theme file to backontrackwellness.co.za or mehealth.co.za."
---

# FTP Deploy Workflow

## When to Use
- After editing any WordPress theme file
- When deploying CSS, PHP, JS, or image changes to live sites

## Procedure

### 1. Download latest from server
```powershell
$ftpCred = 'claude-ftp@wernerraubenheimer.com:0*QH+.=Cd^4?B8uKZXdvs$eH'
curl.exe -o "C:\temp\<localname>" "<ftpUrl>" -u $ftpCred -s --max-time 60
```

### 2. Edit locally in `C:\temp\`
Use index-based PowerShell string operations for PHP files:
```powershell
$raw = [System.IO.File]::ReadAllText("C:\temp\<file>")
# Use .IndexOf(), .Substring(), string concatenation
[System.IO.File]::WriteAllText("C:\temp\<file>", $result)
```

### 3. Upload to server
```powershell
curl.exe -T "C:\temp\<localname>" "<ftpUrl>" -u $ftpCred -s --max-time 60
```

### 4. Verify on live site
```powershell
curl.exe -s "https://<domain>/" --max-time 30 -o C:\temp\verify.txt
Get-Content C:\temp\verify.txt | Select-String "expected-pattern"
```

## Critical Notes
- FTP password contains `$` — **always single-quote** the credential string
- Server uses `\r\n` line endings — never use `.Replace()` with here-strings
- Save curl output to files to avoid PowerShell terminal buffer issues
