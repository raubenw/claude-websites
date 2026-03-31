# DijiSol Website Building Workspace

## Context
Werner Raubenheimer (DijiSol Solutions) manages multiple client websites on HostGator shared hosting (IP: 108.167.143.76, cPanel user: solutions).

## Hosting & Deployment
- **FTP credential variable**: `$ftpCred = 'claude-ftp@wernerraubenheimer.com:0*QH+.=Cd^4?B8uKZXdvs$eH'`
- **FTP upload pattern**: `curl.exe -T $localFile $ftpUrl -u $ftpCred -s --max-time 60`
- **FTP password contains `$`** — always use single-quoted strings in PowerShell
- Server files use `\r\n` line endings — use index-based string operations (`.IndexOf()`, `.Substring()`, `.Insert()`) instead of `.Replace()` or `.Contains()` with here-strings

## Active Client Sites

| Client | Domain | WP Path | Theme |
|--------|--------|---------|-------|
| Back on Track | backontrackwellness.co.za | /public_html/website_8cdc39b6/ | backontrack |
| MeHealth | mehealth.co.za | /public_html/mehealth/ | mehealth |

## Database (Back on Track)
- Host: localhost
- DB/User: solution_WPMYw
- Password: s9Zjs9/y9ch5
- Table prefix: Aoi_

## Conventions
- Always download file from server before editing (never edit stale local copies)
- Save working copies to `C:\temp\` before uploading
- Verify changes on live site after FTP upload with curl
- Clean up any diagnostic PHP scripts uploaded to the server after use
- Use PowerShell on Windows — avoid bash-style commands
- For email sending on shared hosting: always use domain-based from address (e.g., noreply@domain.co.za), never Gmail
