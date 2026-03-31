---
name: wp-db-script
description: "Create and run WordPress database scripts. Use when querying WooCommerce settings, modifying wp_options, checking orders, or diagnosing WordPress database issues."
---

# WordPress Database Script Workflow

## When to Use
- Querying or modifying WooCommerce settings
- Checking WordPress options, posts, or user data
- Diagnosing email, shipping, or payment issues
- Any direct database operation

## Procedure

### 1. Create PHP script in `C:\temp\`
```php
<?php
$db = new mysqli('localhost', 'solution_WPMYw', 's9Zjs9/y9ch5', 'solution_WPMYw');
if ($db->connect_error) { echo "DB Error: " . $db->connect_error; exit; }

// Your query here — use prepared statements for dynamic values

$db->close();
```

### 2. Upload via FTP
```powershell
$ftpCred = 'claude-ftp@wernerraubenheimer.com:0*QH+.=Cd^4?B8uKZXdvs$eH'
curl.exe -T "C:\temp\script.php" "ftp://108.167.143.76/public_html/website_8cdc39b6/script.php" -u $ftpCred -s --max-time 30
```

### 3. Run and capture output
```powershell
curl.exe -s "https://backontrackwellness.co.za/script.php" --max-time 20 -o C:\temp\result.txt
Get-Content C:\temp\result.txt
```

### 4. Clean up — ALWAYS delete the script from server
```powershell
curl.exe -s "ftp://108.167.143.76/public_html/website_8cdc39b6/" -u $ftpCred -Q "DELE /public_html/website_8cdc39b6/script.php" --max-time 15
```

## Critical Notes
- Table prefix is `Aoi_` (not `wp_`)
- WooCommerce stores settings as serialized PHP arrays — use `serialize()` / `unserialize()`
- ALWAYS clean up scripts from the server after use (security)
