# Chat History - Claude Websites Project

## Date: January 31, 2026

### Session Summary

This document captures the conversation history for creating and managing websites with Claude AI assistance.

---

## De Beer Bonsmara Website Updates

### Logo Replacement

- Replaced cow emoji (🐄) icons with actual De Beer Bonsmara logo image across all pages
- Logo URL: `https://i0.wp.com/debeerbonsmara.com/wp-content/uploads/2025/08/DeBeer-Bonsmaara-Transparent-Logo.png`

### Logo Sizing Updates

- **Preloader logo:** Updated to `400px` width (was 120px)
- **Nav logo:** Updated to `150px` width (was 55px)
- Updated in `css/styles.css`:
  - `.preloader-logo-img { width: 400px; }`
  - `.logo-icon-img { width: 150px; }`

### Contact Form Implementation

Created PHP backend (`send-mail.php`) for HostGator hosting:

- Handles both contact form and newsletter subscriptions
- Sends all submissions to `subscribe@debeerbonsmara.com`
- Features:
  - Input sanitization for security
  - JSON responses for AJAX handling
  - Works with HostGator's PHP mail function
  - No third-party services required (no Formspree/Mailchimp)

### JavaScript Form Handlers Updated

Updated `js/main.js` to:

- Submit forms via AJAX to PHP handler
- Show loading states while sending
- Display success/error messages
- Handle both contact form and newsletter popup

### Deployment

- Site deployed to live at debeerbonsmara.com
- Contact form: ✅ Working
- Newsletter form: ✅ Working

---

## GitHub Repository Setup

### Repository Created

- **URL:** https://github.com/raubenw/claude-websites
- **Visibility:** Public
- **Description:** Websites created with Claude AI - De Beer Bonsmara, Open Web Access

### Repository Structure

```
claude-websites/
├── debeerbonsmara/          # De Beer Bonsmara website (live)
│   ├── index.html
│   ├── cattle.html
│   ├── grass.html
│   ├── honey.html
│   ├── packages.html
│   ├── send-mail.php
│   ├── css/
│   │   └── styles.css
│   └── js/
│       └── main.js
├── openwebaccess-site/      # Open Web Access agency site
│   └── demos/
│       ├── chiro-demo/      # SpineAlign Chiropractic demo
│       ├── dental/          # Ivory Dental Studio demo
│       ├── mehealth/        # MeHealth e-commerce (mehealth.co.za)
│       └── photography/     # Lumière Photography demo
├── enhancements/
├── functions.php
├── style.css
├── INSTRUCTIONS.md
├── .gitignore
└── view-source_*.html       # Reference files
```

### Git Commands Used

```bash
# Initialize repository
git init

# Add all files
git add .

# Initial commit
git commit -m "Initial commit: De Beer Bonsmara and Open Web Access websites"

# Create GitHub repo and set remote
gh repo create claude-websites --public --source=. --remote=origin --description "Websites created with Claude AI - De Beer Bonsmara, Open Web Access"

# Push to GitHub
git push -u origin main

# Rename folder
git mv local-website debeerbonsmara
git commit -m "Rename local-website to debeerbonsmara"
git push
```

---

## Projects in Repository

### 1. De Beer Bonsmara (`/debeerbonsmara`)

- **Type:** Static HTML5/CSS3/JavaScript website
- **Purpose:** Cattle farm website selling Bonsmara cattle, grass products, and honey
- **Shopping Cart:** Snipcart (integrated, awaiting live API key)
- **Contact Forms:** PHP-based, emails to subscribe@debeerbonsmara.com
- **Hosting:** HostGator

### 2. Open Web Access (`/openwebaccess-site`)

- **Type:** Web agency portfolio site
- **Purpose:** Marketing site for Open Web Access web development services
- **Demo Sites:** Includes SpineAlign Chiropractic demo for South African market

---

## Technical Stack

- **Frontend:** HTML5, CSS3, Vanilla JavaScript
- **Backend:** PHP (for contact forms)
- **Shopping Cart:** Snipcart
- **Hosting:** HostGator (existing WordPress hosting)
- **Version Control:** Git/GitHub

---

## MeHealth Website (mehealth.co.za)

### Date: March 1-2, 2026

### Project Overview

- **Type:** E-commerce site for M&E Pure Essential Oils
- **Client:** Mariaan (084 764 0549)
- **Domain:** mehealth.co.za
- **Hosting:** HostGator
- **Path:** `/openwebaccess-site/demos/mehealth/`

### Products (8 total)

**Oils & Creams:**

1. Lavender & Wintergreen Gift Set — R285
2. Homemade Natural Cream — R185
3. doTERRA Essential Oils — R340
4. Tea Tree Essential Oil — R195
5. Essential Oil Gift Package — R450

**Coffee & Wellness:** 6. Reishi Mushroom Coffee — R340 7. Mushroom Coffee Blend — R320 8. Alkaline Water — R85

### Database Credentials

- **Database:** solution_mehealth
- **DB User:** solution_mehealth_admin
- **DB Password:** `]@{RTQB_7UlE[6A=ue2RUysc`

### WordPress Admin Credentials

- **Username:** me_health_wp_admin
- **Password:** `XC8U(fqqsBVvfpfY%L`
- **Email:** raubenw@gmail.com

### Technical Details

- **Shopping Cart:** Snipcart (ZAR currency, demo API key)
- **Contact Form:** WordPress wp_mail() via `contact.php`
- **Theme:** Earthy sage green palette, wellness-themed
- **Images:** 10 real product photos from Mariaan

### Commits

- `d41c635` — contact.php WordPress handler, AJAX contact form
- `f140652` — Replace Unsplash with real product images, restructure for M&E Pure Essential Oils
- `2b98ff6` — Fix mobile horizontal overflow and improve hero text readability
- `ca4d224` — Fix mobile horizontal shift: overflow-x clip, flex-shrink on navbar items, reposition cart badge

---

## Photography Demo Site — Lumière Photography

### Date: March 10, 2026

### Overview

Created a photography demo site for the Open Web Access agency portfolio, located at `openwebaccess-site/demos/photography/`. Inspired by three South African photography websites:

- nadineduttonphotography.co.za
- dianthusphotography.mypixieset.com
- vschoor.wixsite.com/larissaphotography

### Demo Brand

- **Name:** Lumière Photography
- **Persona:** Sophie — natural light photographer based in South Africa
- **Style:** Moody elegant, warm tones, serif + sans-serif pairing

### Files Created

- `openwebaccess-site/demos/photography/index.html` — Full single-page site
- `openwebaccess-site/demos/photography/css/styles.css` — Complete responsive stylesheet
- `openwebaccess-site/demos/photography/js/main.js` — All interactivity

### Features

- **Hero:** 3-image crossfade slider with Ken Burns effect, overlay, dual CTAs
- **Marquee Strip:** Scrolling service categories (Weddings, Couples, Families, etc.)
- **Portfolio:** 8-item masonry grid with category filter (All/Weddings/Couples/Family/Portraits), hover overlays, lightbox with keyboard navigation
- **Services:** 6 cards — Weddings, Engagements, Family, Portraits, Events, Product
- **Parallax Quote:** Fixed background with inspirational photography quote
- **About:** Dual image layout, photographer bio, stats (500+ Sessions, 8 Years, 50k+ Photos)
- **Testimonials:** Slider with 4 cards, prev/next, dots, autoplay
- **Pricing:** 3 tiers — Mini Session R1,200 / Full Session R2,500 / Wedding from R8,500
- **Instagram Grid:** 6 images with hover overlay
- **Contact:** Split layout — info + form with service dropdown
- **WhatsApp Float:** Fixed bottom-right CTA
- **Preloader:** SVG shutter icon with pulse animation
- **Responsive:** Full breakpoints at 1024/900/768/480px

### Design

- **Fonts:** Playfair Display (headings) + Raleway (body)
- **Palette:** Warm gold `#b08d6e`, charcoal `#1a1714`, cream `#f2ece4`, off-white `#faf8f5`
- **Animations:** AOS (Animate on Scroll), CSS keyframes for marquee/preloader/scroll indicator
- **Images:** Unsplash placeholders (wedding, couple, family, portrait themes)
- **Footer:** "Crafted by Open Web Access" attribution

### Commits

- `4c0ffbb` — Add photography demo site - Lumière Photography portfolio
- `872a9f6` — Update chat history with photography demo, finalize all demo files

---

## FTP Deployment Setup

### Date: March 16, 2026

### Overview

Set up FTP deployment via `curl.exe` in PowerShell to upload demos directly to the openwebaccess.com server. DNS for `ftp.wernerraubenheimer.com` did not resolve, so the server IP is used instead.

### FTP Credentials

> **IMPORTANT:** There are TWO openwebaccess FTP directories in cPanel:
>
> - `openwebaccess/` — **CORRECT** (WordPress root, contains `demos/`)
> - `openwebaccess.com/` — **WRONG** (empty, different directory)

- **FTP Username:** `claude-owa@openwebaccess.com` _(corrected — old `claude@openwebaccess.com` maps to the wrong directory)_
- **FTP Password:** `K-b#PMY4f59qS,U)M6sXo7G%`
- **FTP Server (hostname):** ftp.wernerraubenheimer.com (DNS not resolving — use IP)
- **FTP Server (IP):** 108.167.143.76
- **FTP Port:** 21 (FTP & explicit FTPS)
- **FTP Root maps to:** `openwebaccess/` directory (WordPress root with `demos/`)

### Upload Method

Using `curl.exe` with passive FTP from PowerShell:

```powershell
# Upload file
$ErrorActionPreference="Continue"; curl.exe --ftp-pasv --max-time 30 -s -u "claude-owa@openwebaccess.com:K-b#PMY4f59qS,U)M6sXo7G%" -T "local/file.html" "ftp://108.167.143.76/demos/dental/file.html" 2>&1

# List directory (save to temp file to avoid PS stderr issues)
$ErrorActionPreference="Continue"; curl.exe --ftp-pasv --max-time 20 -s -u "claude-owa@openwebaccess.com:K-b#PMY4f59qS,U)M6sXo7G%" "ftp://108.167.143.76/demos/" -o "$env:TEMP\ftplist.txt" 2>&1; Get-Content "$env:TEMP\ftplist.txt"
```

### Deployed Demos

- **Photography demo:** `openwebaccess.com/demos/photography/`
- **Dental demo:** `openwebaccess.com/demos/dental/`
- Other demos on server: chiro, chiro_old, flooring-after, flooring-before, health, italianrestaurant-after, italianrestaurant-before, photography, womenshealth-after, womenshealth-before

---

## Dental Demo Site — Ivory Dental Studio

### Date: March 16, 2026

### Overview

Created a full dental practice demo site for the Open Web Access agency portfolio, located at `openwebaccess-site/demos/dental/`. A premium single-page site designed for South African dental practices.

### Demo Brand

- **Name:** Ivory Dental Studio
- **Location:** Pretoria, South Africa
- **Style:** Clean, professional, teal + warm coral accents

### Files Created

- `openwebaccess-site/demos/dental/index.html` — Full single-page site (43,107 bytes)
- `openwebaccess-site/demos/dental/css/styles.css` — Complete responsive stylesheet (29,784 bytes)
- `openwebaccess-site/demos/dental/js/main.js` — All interactivity (7,251 bytes)

### Features

- **Hero:** 3-slide image slider with semi-transparent overlay, dual CTAs (Book/Call)
- **Trust Strip:** 4 trust indicators — HPCSA Registered, 15+ Years, Gentle Dentistry, 5-Star Google
- **About:** Overlapping image layout with 15+ years badge (gradient), lead paragraph, feature checklist
- **Services:** 6 cards — General, Cosmetic, Orthodontics, Dental Implants, Emergency, Paediatric. Alternating teal/coral top borders and icon colours
- **Before/After CTA:** Parallax section with lightened overlay and warm tint
- **Team:** 3 members — Dr. James van der Merwe, Dr. Naledi Mokoena, Lisa Botha (hygienist)
- **Testimonials:** Slider with 4 cards, prev/next arrows, dots, autoplay, gradient background
- **Pricing:** 3 tiers — Check-up R650 / Professional Clean R950 / Teeth Whitening R3,500. Featured card with gradient badge
- **Accreditations:** SADA, HPCSA, SAAAD, ITI — gradient text effect
- **Contact:** Split layout — info (phone/email/WhatsApp/address) + hours table + form with service dropdown
- **Google Maps:** Embedded map of Pretoria area
- **WhatsApp Float:** Fixed bottom-right button
- **Preloader:** Tooth SVG icon with pulse animation
- **Responsive:** Full breakpoints at 1024/768/480px

### Design

- **Fonts:** DM Serif Display (headings) + Inter (body) via Google Fonts
- **Palette:** Teal `#0e7490`, warm coral `#e8986d`, gold `#d4a24e`, heading dark `#1a2a33`
- **Animations:** AOS (Animate on Scroll 2.3.1), CSS transitions on cards/buttons
- **Images:** Unsplash placeholders (dental themes)
- **Footer:** "Crafted by Open Web Access" attribution

### Bug Fixes Applied

1. **Mobile horizontal shift** — Fixed with `overflow-x: clip` on body + `overflow: hidden` on `.about-images`
2. **15+ badge overlap on mobile** — Changed to `position: relative` on mobile, reduced to 80px
3. **White space under about images** — Reduced margins, changed aspect ratio to 3/4 on mobile
4. **Hero overlay too blue** — Lightened from 82%/55% to 68%/35% opacity, added warm peach tint
5. **Site too bland** — Added warm coral accent colour, gradient text effects on section titles and accreditations, coloured top borders on service cards, gradient buttons, richer testimonials background, gradient badges
6. **Broken Unsplash image** — Replaced dead `photo-1629909615957` with working `photo-1629909613654` for dental interior

### Live URL

https://openwebaccess.com/demos/dental/

---

## New Client: Back on Track Chiropractic & Wellness — Dr Sarvesh Maharajh

### Date: March 16, 2026

### Client Details

- **Business:** Back on Track Chiropractic and Wellness
- **Practitioner:** Dr Sarvesh Maharajh
- **Location:** Kloof, KwaZulu-Natal, South Africa
- **Website URL:** https://backontrackwellness.co.za/
- **Facebook:** https://www.facebook.com/p/Back-on-track-Chiropractic-and-Wellness-Dr-Sarvesh-Maharajh-61556066109976/

### Hosting & WordPress

- **Hosting:** HostGator (same server as other sites)
- **Server IP:** 108.167.143.76
- **WordPress:** Installed and running
- **WP Login:** `backontrackwellness.co.za/wp-login.php`
- **WP Username:** `solutions`
- **WP Password:** `J@nuar132022P@5sw0rd`

### Application Password (for MCP/API access)

- **App Name:** VSCode MCP
- **App Password:** `Z1Mc WxZB 82sO 4HfY kEA7 Ziap`

### MCP Configuration

- **File:** `.vscode/mcp.json`
- **Server name:** `BackOnTrackWellness`
- **Package:** `@automattic/mcp-wordpress-remote` (installed globally via npm)
- **Status:** Server starts and shows "Running" but **WordPress connection fails during initialization**

### Known Issue: Apache Authorization Header

The WordPress Application Passwords authentication returns 401 because **Apache on HostGator shared hosting strips the `Authorization` header** before PHP can read it.

**Fix required:** Add these lines to the **top** of `.htaccess` in the WordPress root:

```apache
# Enable Application Passwords auth header
RewriteEngine On
RewriteCond %{HTTP:Authorization} ^(.*)
RewriteRule ^(.*) - [E=HTTP_AUTHORIZATION:%1]
SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1
```

This can be done via:

- cPanel → File Manager → edit `.htaccess`
- Or FTP upload (need FTP credentials for this site)

Once the `.htaccess` fix is applied, the WordPress MCP should connect and allow direct site management from VS Code.

### Local Files

- **Client directory:** `openwebaccess-site/Kliente/Sarvesh/` (created for storing client images)
- **Images:** Need to be manually downloaded from Facebook (Facebook blocks automated scraping — requires login)

### MCP Tools Available

- **Playwright MCP:** Working — can browse web, take screenshots, interact with pages
- **WordPress MCP:** Installed but blocked by Apache auth header issue (see above)

### Next Steps

- [ ] Fix `.htaccess` to enable Application Password authentication
- [ ] Verify WordPress MCP connection works
- [ ] Download images from Facebook page manually
- [ ] Build chiropractic website for backontrackwellness.co.za

---

## Back on Track Chiropractic Website — Built & Deployed

### Date: March 16-17, 2026

### Overview

Built a complete HTML/CSS/JS website for Dr Sarvesh Maharajh's "Back on Track Chiropractic and Wellness" practice. WordPress MCP connection issues were unresolvable (Apache strips Authorization headers on HostGator shared hosting), so a static site was built and deployed via FTP instead.

### New FTP Credentials (Broader Access)

- **FTP Username:** `claude-ftp@wernerraubenheimer.com`
- **FTP Password:** `0*QH+.=Cd^4?B8uKZXdvs$eH`
- **FTP Server:** `108.167.143.76` (DNS for `ftp.wernerraubenheimer.com` does NOT resolve — must use IP)
- **FTP Root:** `/home2/solutions/` (has access to ALL sites on this cPanel account)
- **PowerShell note:** Use single quotes for cred string to preserve literal `$` in password

### Deployment Path

`/home2/solutions/public_html/website_8cdc39b6/`

### Live URL

https://backontrackwellness.co.za/

### Client Details

- **Practitioner:** Dr Sarvesh Maharajh (M.Tech Chiropractic DUT)
- **Address:** 16 Pioneer Road, Kloof, KZN, 3610
- **Phone:** +27 84 888 8308
- **Email:** dr.srmaharajh@gmail.com
- **Instagram:** @backontrack_chiro_and_wellness
- **YouTube:** @BackOnTrackWellness (49 subscribers, 16 videos)

### Files Deployed

| File                               | Size          | Purpose                       |
| ---------------------------------- | ------------- | ----------------------------- |
| `index.html`                       | 32,002 bytes  | Complete single-page website  |
| `css/styles.css`                   | 29,569 bytes  | Full responsive stylesheet    |
| `js/main.js`                       | 8,360 bytes   | All interactivity             |
| `contact.php`                      | 3,565 bytes   | PHP contact form handler      |
| `images/hero-banner.jpg`           | 56,482 bytes  | Facebook profile banner       |
| `images/red-light-therapy.jpg`     | 240,862 bytes | Red light therapy image       |
| `images/infrared-therapy-info.jpg` | 57,565 bytes  | Infrared therapy info graphic |
| `images/infrared-full-body.jpg`    | 147,346 bytes | Full body infrared therapy    |

### Local Source Files

- `openwebaccess-site/Kliente/Sarvesh/site/index.html`
- `openwebaccess-site/Kliente/Sarvesh/site/css/styles.css`
- `openwebaccess-site/Kliente/Sarvesh/site/js/main.js`
- `openwebaccess-site/Kliente/Sarvesh/site/contact.php`
- `openwebaccess-site/Kliente/Sarvesh/images/` (4 source images from Facebook)

### Design

- **Color Scheme:** Primary teal `#0d6e6e`, accent coral `#e8733a`
- **Red Light Section:** Red `#e04040` on dark bg `#1a1015`
- **Fonts:** Playfair Display (headings) + Inter (body) via Google Fonts
- **Layout:** Single-page with smooth scroll navigation

### Site Sections

1. **Navigation** — Sticky nav with mobile hamburger, orange "Book Appointment" CTA
2. **Hero** — Facebook banner with teal overlay, "Get Your Life Back on Track", stats row
3. **About** — Dr Maharajh bio, icon grid (Spinal Health/Rehab/Light Therapy/Mental Wellness), quote block
4. **Services** — 6 cards: Chiropractic Adjustments, Rehabilitation, Red Light Therapy (featured/Popular), Postural Assessment, Wellness Programmes, Sports Injuries
5. **Red Light Therapy** — Dark featured section with 3-image gallery, benefits list (Reduces Inflammation, Accelerates Healing, Non-Invasive, Improved Circulation)
6. **Videos** — Featured Sciatica video (YouTube embed) + 5 lazy-loading thumbnail cards (Poor Posture, Core Stability, Levator Scapulae, Low Back Strength, Barefoot Shoes)
7. **Contact** — Info cards (Location/Phone/Email/Instagram), Google Maps embed, contact form with service dropdown
8. **Footer** — 4-column (Brand/Quick Links/Services/Contact), social icons, "Website by Open Web Access"
9. **WhatsApp Float** — Fixed bottom-right CTA
10. **Back to Top** — Appears on scroll

### YouTube Videos Embedded

| Video ID      | Title                                                | Views |
| ------------- | ---------------------------------------------------- | ----- |
| `fC6Mjb-qmyA` | Sciatica: Symptoms, Red Flags & Treatment (FEATURED) | 422   |
| `8obxojxLjLg` | Poor Posture & Correction                            | 229   |
| `jl2H06JLseQ` | Core Stability: McGill Big 3                         | 158   |
| `gzwYoo8yt1M` | Levator Scapulae & Neck Pain                         | 101   |
| `jy7R26fHZG0` | Low Back Strength & Mobility                         | 54    |
| `6cSsa3hAOfU` | Barefoot Shoes: What's the Hype?                     | 1,252 |

### Contact Form (contact.php)

- **Method:** POST only
- **Security:** Session-based rate limiting (30s), honeypot field, input sanitization, header injection prevention
- **Sends to:** dr.srmaharajh@gmail.com via PHP `mail()`
- **From:** noreply@backontrackwellness.co.za
- **Response:** JSON (success/error)
- **Note:** HostGator bot protection (Imunify) sets a JS cookie challenge on first PHP request — transparent to real browser users

### WordPress Coexistence

- WordPress is still installed in the same directory
- Apache's `DirectoryIndex` serves `index.html` before `index.php`
- WordPress `.htaccess` has `RewriteCond %{REQUEST_FILENAME} !-f` which skips existing static files
- Our static files (index.html, css/, js/, images/, contact.php) are served directly

### Testing Completed

- [x] Desktop visual review — all sections render correctly
- [x] Mobile responsive (375px) — hamburger nav, stacked cards, no overflow
- [x] Contact form — submission successful, emails sent
- [x] YouTube embeds — featured video embeds, thumbnails lazy-load on click
- [x] Google Maps — renders correctly with Kloof location
- [x] WhatsApp float and Back to Top buttons working
- [x] Server cleanup — removed test.txt and placeholder.txt files

---

---

## MeHealth WordPress + WooCommerce Store

### Date: March 17, 2026

### Overview

Built a full WordPress + WooCommerce e-commerce store for Mariaan at mehealth.co.za, replacing the previous static HTML demo with a live, functional shop. Products include dōTERRA essential oils, natural creams, mushroom coffee, diffusers, and accessories.

### WordPress Custom Theme: `mehealth`

Created a complete custom WordPress theme with WooCommerce integration:

| File              | Purpose                                                                                                 |
| ----------------- | ------------------------------------------------------------------------------------------------------- |
| `functions.php`   | Theme setup, WC support, AJAX add-to-cart, cart fragments, EFT email instructions, contact form handler |
| `header.php`      | DOCTYPE, announcement bar, navigation with WC cart, mobile toggle                                       |
| `footer.php`      | 4-column footer, WhatsApp float, scroll-to-top                                                          |
| `front-page.php`  | Full homepage: hero, categories, about, WC product grid, testimonials, contact form                     |
| `style.css`       | Complete CSS with WooCommerce overrides, responsive design                                              |
| `page.php`        | Generic page template                                                                                   |
| `woocommerce.php` | WC wrapper template                                                                                     |
| `index.php`       | Required WP fallback                                                                                    |
| `js/main.js`      | AJAX add-to-cart, contact form, preloader, AOS, navbar, product filter                                  |

### Design System

- **Primary:** Sage green `#5b7c5e`
- **Accent:** Honey `#c8956c`
- **Fonts:** Cormorant Garamond (headings) + Nunito Sans (body)
- **Icons:** Emoji-based (🌿, 🛒, etc.)

### WooCommerce Configuration

- **Currency:** ZAR (South African Rand)
- **Payments:** EFT (Bank Transfer) + Cash on Collection
- **Shipping:** South Africa only
- **Email:** mariaan@mehealth.co.za
- **Permalinks:** /%postname%/

### Products Imported (20 total)

#### Published with prices (10):

| Product                                             | Price | Category          |
| --------------------------------------------------- | ----- | ----------------- |
| Essential Oil Gift Package (Lavender & Wintergreen) | R285  | Oils & Creams     |
| Essential Oil Gift Package                          | R340  | Oils & Creams     |
| dōTERRA Essential Oil 15ml                          | R340  | Oils & Creams     |
| Tea Tree Essential Oil 15ml                         | R195  | Oils & Creams     |
| Reishi Mushroom Capsules                            | R450  | Coffee & Wellness |
| Mushroom Coffee                                     | R185  | Coffee & Wellness |
| Alkaline Water 5L                                   | R120  | Coffee & Wellness |
| Natural Face Cream                                  | R185  | Oils & Creams     |
| Fox Diffuser                                        | R1150 | Diffusers         |
| Cola Diffuser                                       | R1150 | Diffusers         |

#### Published without prices (10 — pending Mariaan's pricing):

- Oil Storage Case, Natural Cream 50ml, Natural Cream 100ml, Oregano Latte Coffee
- Essential Oil Roller Bottle, dōTERRA Breathe 15ml, dōTERRA Tea Tree 15ml
- dōTERRA Peppermint 15ml, dōTERRA Lavender 15ml, dōTERRA Oregano 15ml

### Images Deployed (27 total)

- **8 static images:** hero.jpg, mariaan.jpg, category-oils.jpg, category-wellness.jpg, social-1 through social-4
- **8 existing product images:** From demo site
- **11 new product images:** From `openwebaccess-site/Kliente/Mehealth/` (long Afrikaans filenames mapped to short names)

### Key Technical Decisions

1. **Static HTML → WordPress:** The old static demo `index.html` was served before WordPress's `index.php`. Renamed to `index-static-backup.html` so WordPress takes over.
2. **Snipcart removed:** The Snipcart JS/CSS were in the old static HTML, not in WordPress. Renaming `index.html` eliminated all Snipcart references and console errors.
3. **FTP deployment:** Used PowerShell `[System.Net.FtpWebRequest]` functions for all file operations (upload, list, delete, rename).
4. **PHP bootstrap scripts:** Created temporary `activate-theme.php` and `import-products.php` for one-time setup, then deleted for security.

### Announcement Bar Update

- **Before:** `✨ Free delivery on orders over R500 | Handmade with love in South Africa 🇿🇦`
- **After:** `💛 Handmade with love in South Africa 🇿🇦`

### Server Details

- **Host:** HostGator shared hosting
- **WordPress path:** `/home2/solutions/mehealth.co.za/`
- **Theme path:** `/mehealth.co.za/wp-content/themes/mehealth/`
- **FTP:** 108.167.143.76
- **WP Admin:** me_health_wp_admin
- **DB:** solution_mehealth

### Site Status

- ✅ WordPress serving at mehealth.co.za (no more static HTML)
- ✅ All 20 products published and visible in Shop
- ✅ Zero console errors
- ✅ Announcement bar updated with yellow heart
- ✅ Footer shows correct info (Middelburg, mariaan@mehealth.co.za)
- ⚠️ Site in "Coming soon" mode — needs to be made public when ready
- ⚠️ 10 products need pricing from Mariaan

### Plugins Active

1. WooCommerce 10.6.1
2. WooCommerce Payfast Gateway 1.7.5
3. The Courier Guy Shipping 5.4.0
4. Wordfence Security 8.1.4

---

## Future Tasks

- [x] Add more demo sites to Open Web Access portfolio (photography + dental demos added)
- [x] Set up FTP deployment for openwebaccess.com
- [x] Build Back on Track Chiropractic website for Dr Sarvesh Maharajh
- [x] Build MeHealth WordPress + WooCommerce store
- [ ] Get pricing from Mariaan for 10 unprice products
- [ ] Disable "Coming soon" mode on mehealth.co.za when ready to launch
- [ ] Test add-to-cart and checkout flow end-to-end
- [ ] Test contact form email delivery
- [ ] Mobile responsive testing
- [ ] Consider adding more product pages to De Beer Bonsmara
- [ ] Consider GitHub Actions for automated deployment on push

---

_This chat history is maintained as part of the claude-websites repository._

---

## Dentist On Olifants Website Fixes

### Date: March 31, 2026

### Overview

Applied fixes to the Dentist On Olifants static website hosted on HostGator.

### Location & FTP Details

- **Live URL:** https://openwebaccess.com/clients/dentistonolifants/
- **Server path:** `/openwebaccess/clients/dentistonolifants/`
- **FTP:** 108.167.143.76 with `claude-ftp@wernerraubenheimer.com`

### Fixes Applied

| Issue | Fix |
|-------|-----|
| Location button not linking to maps | Updated icon/button to link to Google Maps: `https://www.google.com/maps/search/25+Olifants+Road+Emmarentia+Randburg` |
| Incorrect address | Changed to "25 Olifants Road, Emmarentia" everywhere (hero, contact section, footer) |
| Saturday hours showing open | Added "Saturday: Closed" row to practice hours table |
| Top bar hours incorrect | Updated from "Mon–Sat" to "Mon–Fri: 8am – 5pm \| Sat: Closed" |
| Wrong team member showing | Removed Kayshree Mudly (team-1.png), replaced with Dr. Evanti Sims (team-2.png) as Lead Dental Surgeon |

### Files Modified

- `index.html` — All content fixes applied

---

## MeHealth Mobile Layout Fixes

### Date: March 31, 2026

### Overview

Applied three mobile layout improvements to mehealth.co.za after user feedback from mobile screenshots.

### Issues Reported & Fixed

| Issue | User Request | Fix Applied |
|-------|--------------|-------------|
| Hero badge cut off at top | "The top button gets cut off. Please add more spacing" | Added `margin-top: 20px` to `.hero-badge` in mobile media query (line 1791) |
| Product footer crowded on mobile | "Place vertically centered underneath each other" | Added mobile CSS for `.product-footer`: `flex-direction: column; align-items: center; gap: 12px;` (lines 1794-1797) |
| Testimonial text incorrect | "Change the line to 'the Lavender and peppermint gift set...'" | Changed "Wintergreen" to "Peppermint" in testimonials section (front-page.php line 312) |

### Files Modified

| File | Changes |
|------|---------|
| `style.css` | Added `margin-top: 20px` to `.hero-badge` mobile styles; Added `.product-footer` mobile stacking rule |
| `front-page.php` | Changed "Lavender & Wintergreen Gift Set" to "Lavender & Peppermint Gift Set" in first testimonial |

### Deployment

- **Uploaded via FTP:** Both files uploaded to `/mehealth.co.za/wp-content/themes/mehealth/`
- **Verified live:** CSS changes confirmed at lines 1791-1797; Testimonial text shows "Peppermint"
- **QC check:** All 3 changes verified exact match to user requirements

### CSS Changes (style.css mobile query)

```css
.hero-badge {
    font-size: 0.75rem;
    padding: 6px 14px;
    margin-top: 20px;  /* NEW - prevents cutoff */
}

.product-footer {      /* NEW - vertical stacking */
    flex-direction: column;
    align-items: center;
    gap: 12px;
}
```

---

## Fox Diffuser Image Replacement

### Date: March 31, 2026

### Overview

Replaced the Fox Diffuser product image on mehealth.co.za with a new colorful orange fox image provided by the user.

### Details

| Field | Value |
|-------|-------|
| Product | Fox Diffuser (R1,150) |
| Old image | Generic diffuser photo |
| New image | Colorful orange fox diffuser with small oil bottle |
| Source file | `Fox Diffuser R1150jpg.jpg` (93,988 bytes) |
| Server path | `/wp-content/uploads/2026/03/Fox-diffuser-R1150-met-klein-olie.jpg` |

### Deployment

- **Method:** Direct FTP upload to existing image path (overwrites old image)
- **Verified:** HTTP HEAD shows Content-Length: 93,988 bytes, Last-Modified: 2026-03-31 17:55:14 GMT
- **No WooCommerce changes needed:** Product already linked to this image path

---

## MeHealth Shop Page Styling & Lightbox

### Date: March 31, 2026

### Overview

Fixed the MeHealth.co.za shop page styling to match the homepage tile design, and added a lightbox popup feature for product images.

### Problems Fixed

1. **Shop page images cropped/zoomed** — WooCommerce default styling was showing products cropped at 300x300. Fixed with inline CSS in `woocommerce.php` template that loads after WooCommerce's CSS.

2. **Homepage images too zoomed** — Changed `object-fit: cover` to `object-fit: contain` with padding so full products are visible.

### Features Added

- **Image lightbox popup** — Click any product image (homepage or shop) to see a larger version in a modal overlay
  - Dark semi-transparent backdrop
  - Close via X button, click outside, or ESC key
  - Loads full-size image (strips WooCommerce thumbnail suffixes)
  - Mobile-friendly

### Technical Solution

Added inline `<style>` block directly in `woocommerce.php` template (loads after WooCommerce CSS) with:
- `object-fit: contain` for full product display
- `padding: 25px` for breathing room
- `background-color: #f5f1ec` (cream) for consistent look
- CSS Grid layout for product cards
- Card shadows and hover effects
- Styled add-to-cart buttons

### Files Modified

| File | Changes |
|------|---------|
| `style.css` | Added homepage product image `object-fit: contain`, lightbox CSS, WooCommerce shop selectors |
| `woocommerce.php` | Added inline CSS block for shop page styling (bypasses WooCommerce CSS specificity) |
| `main.js` | Added lightbox module with click handlers for product images |

### Path

`/mehealth.co.za/wp-content/themes/mehealth/`

---
