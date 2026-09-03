# TPHB — The Praise House Baltimore
**Custom WordPress Theme**

A modern, ACF-powered WordPress theme for RCCG The Praise House Baltimore.

---

## Requirements

| Requirement | Minimum |
|---|---|
| WordPress | 6.0+ |
| PHP | 8.0+ |
| MySQL | 5.7+ / MariaDB 10.3+ |

---

## Required Plugins

These **must** be installed and activated before the theme will function correctly.

| Plugin | Purpose | Notes |
|---|---|---|
| **Advanced Custom Fields PRO** | Powers all editable content fields in WP Admin | Paid — licence key required. Get it at [advancedcustomfields.com](https://www.advancedcustomfields.com/) |
| **WP Mail SMTP** (or equivalent) | Ensures contact forms send email reliably on shared hosting | Free tier at [wordpress.org/plugins/wp-mail-smtp](https://wordpress.org/plugins/wp-mail-smtp/). Configure with BlueHost SMTP credentials. |

### Recommended Plugins

| Plugin | Purpose |
|---|---|
| **UpdraftPlus** | Automated backups |
| **Wordfence Security** | Firewall and malware scanning |
| **WP Super Cache** or **LiteSpeed Cache** | Performance (BlueHost supports LiteSpeed) |

---

## Installation on BlueHost

### Step 1 — Install WordPress
1. Log in to your BlueHost cPanel.
2. Under **Website**, click **WordPress** (Softaculous).
3. Click **Install** and complete the wizard. Note the admin URL, username, and password.

### Step 2 — Upload the Theme
**Option A — WP Admin (easiest)**
1. Zip the entire `tphbweb/` folder → `tphbweb.zip`.
2. In WP Admin go to **Appearance → Themes → Add New → Upload Theme**.
3. Upload `tphbweb.zip` and click **Activate**.

**Option B — FTP / cPanel File Manager**
1. In cPanel open **File Manager** and navigate to `public_html/wp-content/themes/`.
2. Upload and extract the `tphbweb/` folder there.
3. In WP Admin go to **Appearance → Themes** and activate **TPHB - The Praise House Baltimore**.

### Step 3 — Install Plugins
1. In WP Admin go to **Plugins → Add New**.
2. Search for and install **WP Mail SMTP** — activate it.
3. Upload and activate **Advanced Custom Fields PRO** (upload the zip from your ACF account).

### Step 4 — Configure WP Mail SMTP
1. Go to **WP Mail SMTP → Settings**.
2. Set **From Email** to `info@rccgthepraisehouse.org` and **From Name** to `RCCG The Praise House Baltimore`.
3. Under **Mailer**, select **Other SMTP** and enter BlueHost's SMTP details:
   - SMTP Host: `mail.rccgthepraisehouse.org` (or BlueHost's mail server — check cPanel → Email → Email Accounts)
   - Port: `465` (SSL) or `587` (TLS)
   - Username: the full email address (`info@rccgthepraisehouse.org`)
   - Password: the email account password (set in cPanel → Email Accounts)
4. Use the **Email Test** tab to send a test and confirm delivery.

---

## WP Admin Setup Checklist

After theme activation, complete the following in **Settings → Site Settings** (visible in the WP Admin left sidebar after ACF PRO is activated).

### Site Options
- [ ] Phone Number
- [ ] Public Email Address (shown on the site)
- [ ] Address
- [ ] Sunday Service Time
- [ ] Wednesday Service Time
- [ ] Zoom Meeting ID
- [ ] Facebook URL
- [ ] Instagram URL
- [ ] YouTube Channel URL
- [ ] WhatsApp URL
- [ ] YouTube Channel ID *(for Live service detection — get from YouTube Studio URL)*
- [ ] YouTube API Key *(create at console.cloud.google.com)*

### Form Notification Emails
All default to `info@rccgthepraisehouse.org`. Update individually if you want form submissions routed to different inboxes.

- [ ] Contact Page — Notification Email
- [ ] Homepage Contact ("Get in Touch") — Notification Email
- [ ] Prayer Request — Notification Email
- [ ] Plan a Visit — Notification Email

### Media / Hero Content
- [ ] About Page Hero Video URL *(looping background video)*
- [ ] Who We Are Hero Video URL *(looping background video)*
- [ ] Sermons Archive Hero Background *(image)*

### Leadership & Ministry Team
Under **Settings → Leadership & Ministry Team**, add each ministry team member:
- Name, Ministry Department, Role, Photo, Initials (used if no photo)

### Homepage Settings
Go to **Pages → Home → Edit** to set:
- Pastor Photo (homepage hero card)
- Co-Pastor Photo (homepage hero card)
- Donate Button URL & Label

### About Page Settings
Go to **Pages → About Us → Edit** to set:
- Senior Pastor Photo + Bio
- Co-Pastor Photo + Bio
- Our Journey Timeline items (date, title, description, photo or icon)

### New Here Page Settings
Go to **Pages → New Here → Edit** to set:
- Welcome Slideshow scenes (background image, eyebrow, headline, subtext, optional CTA button, duration)

### Give Page Settings
Go to **Pages → Give → Edit** to set:
- Intro text, Cash App username + QR, Zelle contact + QR, Online Donate button URL + label

---

## Pages and Their Templates

Create the following pages in **Pages → Add New**, assigning the correct template under **Page Attributes → Template**.

| Page Title | Slug | Template |
|---|---|---|
| Home | `/` | *(set as front page in Settings → Reading)* |
| About Us | `about-us` | **About Us** |
| Who We Are | `who-we-are` | **Who We Are** |
| New Here | `new-here` | **New Here** |
| Contact | `contact` | *(default page template)* |
| Give | `give` | **Give** |
| Gallery | `gallery` | *(default page template)* |
| Sermons | *(archive)* | *(auto-generated archive)* |
| Events | *(archive)* | *(auto-generated archive)* |

> **Important:** Set the front page in **Settings → Reading → A static page → Front page: Home**.

---

## Content Migration from Local Environment

### Export Content (on the local site)
1. In WP Admin go to **Tools → Export → All content** and download the `.xml` file.
2. Go to **Tools → Export** again and export **ACF field data** if the ACF Import/Export tool is visible (ACF PRO includes this).

### Import Content (on BlueHost)
1. In WP Admin go to **Tools → Import → WordPress** — install the importer if prompted.
2. Upload the `.xml` file. Assign authors as needed.
3. Check **Download and import file attachments** to pull media from the local site (requires the local site to be accessible, or migrate uploads separately — see below).

### Migrate Media (Uploads)
The uploads folder (`wp-content/uploads/`) is not included in this theme repo. To migrate:
1. Zip the local `wp-content/uploads/` folder.
2. Upload via cPanel File Manager to `public_html/wp-content/uploads/`.
3. Extract in place.

### Re-assign ACF Values
After import, visit each key page in WP Admin and confirm the ACF field groups are populated (About Us, New Here, Give). If values didn't carry over from the import, re-enter them manually using the checklist above.

---

## Custom Post Types

The theme registers these post types automatically — no plugin needed:

| Post Type | Slug | Purpose |
|---|---|---|
| `sermon` | `/sermon/` | Sunday sermons |
| `reflection` | `/reflections/` | Written reflections / devotionals |
| `tphb_event` | `/events/` | Events |
| `tphb_outreach` | `/outreach/` | Community outreach posts |
| `testimonial` | — | Testimonials (internal, not public) |
| `hero_slide` | — | Homepage hero slides (internal) |
| `prayer_request` | — | Prayer request submissions (private) |

---

## External Dependencies

All loaded from CDN — no build step required.

| Library | Version | Purpose |
|---|---|---|
| Google Fonts (Inter + Lato) | — | Typography |
| Swiper.js | 11 | Carousels and slideshows |

---

## Development Notes

- All PHP template files are in the theme root and `template-parts/`.
- All styles are in `assets/css/main.css` — `style.css` in the root is for WordPress theme metadata only.
- JavaScript is in `assets/js/main.js`.
- ACF field groups are registered in code in `functions.php` — the `acf-json/` folder is kept for any DB-synced overrides.
- Form submissions use WordPress AJAX (`wp_ajax_*` hooks) with nonce verification and IP-based rate limiting.
- The `tphb_option()` helper in `functions.php` reads from the ACF Options page.

---

## Contact

**RCCG The Praise House Baltimore**
Website: [rccgthepraisehouse.org](https://rccgthepraisehouse.org)
Email: info@rccgthepraisehouse.org
