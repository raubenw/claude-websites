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
│       └── chiro-demo/      # SpineAlign Chiropractic demo
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

- **FTP Username:** claude@openwebaccess.com
- **FTP Password:** `K-b#PMY4f59qS,U)M6sXo7G%`
- **FTP Server (hostname):** ftp.wernerraubenheimer.com (DNS not resolving — use IP)
- **FTP Server (IP):** 108.167.143.76
- **FTP Port:** 21 (FTP & explicit FTPS)
- **Server Directory:** /home2/solutions/openwebaccess.com
- **FTP Root maps to:** openwebaccess.com/ (website root)

### Upload Method

Using `curl.exe` with passive FTP from PowerShell:

```powershell
# Create directory
curl.exe --ftp-pasv --max-time 10 -u "claude@openwebaccess.com:PASSWORD" ftp://108.167.143.76/ -Q "MKD demos/photography"

# Upload file
curl.exe --ftp-pasv --max-time 30 -u "claude@openwebaccess.com:PASSWORD" -T "local/file.html" ftp://108.167.143.76/demos/photography/file.html
```

### Deployed

- **Photography demo:** uploaded to `openwebaccess.com/demos/photography/`
  - `index.html` (65,866 bytes)
  - `css/styles.css`
  - `js/main.js`

---

## Future Tasks

- [ ] Configure Snipcart live API key (pending client payment method decision)
- [x] Add more demo sites to Open Web Access portfolio (photography demo added)
- [x] Set up FTP deployment for openwebaccess.com
- [ ] Consider adding more product pages to De Beer Bonsmara
- [ ] Replace Snipcart demo API key with live key for MeHealth
- [ ] Generate WordPress salts for mehealth.co.za wp-config.php
- [ ] Consider GitHub Actions for automated deployment on push

---

_This chat history is maintained as part of the claude-websites repository._
