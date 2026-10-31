# Mag Pro - WordPress Magazine & News Theme

**Author:** [Developer Zahir](https://developerzahir.com/)  
**Website:** [https://developerzahir.com/](https://developerzahir.com/)  
**License:** GNU General Public License v2 or later  

Mag Pro is a high-performance, responsive WordPress magazine and blog theme converted from the popular **MagPro** template. Built with modern web standards, it integrates full **Dark / Light mode switching**, a **Breaking News ticker**, Google Font Hind Siliguri, and a required companion plugin (**Mag Pro Elements**) bringing complete **Elementor page builder support** for all magazine post widgets and layouts.

---

## 🚀 Key Features

### 1. Dark & Light Mode System
- **Zero-FOUC (Flash of Unstyled Content):** Pre-render script reads user preference from `localStorage` before the body renders.
- **Header & Floating Switchers:** Accessible toggle buttons in the top ticker bar and persistent floating switch at the bottom corner.
- **CSS Custom Properties:** Seamless switching of background colors, card surfaces, borders, text, and headings across all theme areas and Elementor widgets.
- **OS Theme Detection:** Automatically adapts to device preferences (`prefers-color-scheme: dark`) when no manual choice has been set.

### 2. Mag Pro Magazine Styling
- **Typography:** Powered by Google Font `Hind Siliguri` (400, 500, 600, 700).
- **Icons:** Integrated Font Awesome 5/6 Free.
- **Category Badges:** Eye-catching crimson tags with hover micro-animations.
- **Image Hover Effects:** Fluid zoom animations (`scale(1.06)`) on article thumbnails.
- **Gradient Overlays:** Clean contrast gradients for hero banners and multimedia cards.
- **Header Breaking News Ticker:** Dynamic headline ticker with "BREAKING NEWS" pulse badge, current date, and prev/next controls.

### 3. Required Companion Plugin: `Mag Pro Elements`
- Bundled directly inside the theme (`mag-pro/inc/plugins/mag-pro-elements.zip`) and managed via **TGM Plugin Activation (TGMPA)**.
- Theme displays one-click installation and activation notices if the plugin is ever inactive.
- Fully compatible with **Elementor Website Builder** (requires Elementor).

---

## 🧩 Elementor Widgets Included

All MagPro XML post widgets have been converted into modular Elementor widgets under the **"Mag Pro Elements"** category:

1. **MagPro - Featured Hero Grid (`magpro-featured-hero`):**
   - Signature 5-post magazine layout (1 large lead card + 4 stacked cards).
   - Alternate 3-column and 4-column hero grid layouts.
2. **MagPro - Block 1 (`magpro-block-1`):**
   - 1 prominent lead post on the left + compact thumbnail list on the right.
3. **MagPro - Block 2 (`magpro-block-2`):**
   - 2-column magazine split with independent category selection per column.
4. **MagPro - Post Grid (`magpro-grid`):**
   - Responsive post grid (2, 3, or 4 columns) with category badges, author avatars, excerpts, and "Read More" links.
5. **MagPro - Post List (`magpro-list`):**
   - Horizontal post cards with rounded images, badges, titles, and excerpts.
6. **MagPro - Video / Multimedia Block (`magpro-videos`):**
   - Dark multimedia container with prominent video play icons, large featured video card, and playlist queue.
7. **MagPro - News Ticker (`magpro-news-ticker`):**
   - Standalone breaking / trending news ticker widget with animated rotation.
8. **MagPro - Tabbed Posts (`magpro-tabs`):**
   - Interactive 3-tab widget ("Recent", "Popular" by comments, and "Trending").
9. **MagPro - Social Follow Us (`magpro-social`):**
   - Branded follow buttons with follower counts for Facebook, Twitter/X, YouTube, Instagram, Pinterest, and Telegram.

---

## 🛠 Shortcodes & Classic Widgets

Every widget is also accessible via WordPress shortcodes:
- `[magpro_hero layout="5_posts|3_columns|4_columns" category="" count="5"]`
- `[magpro_block1 title="Tech News" category="" count="5"]`
- `[magpro_grid title="Featured" columns="3" count="6"]`
- `[magpro_list title="Recent" count="5"]`
- `[magpro_tabs count="4"]`
- `[magpro_ticker label="TRENDING" count="6"]`

Classic sidebar widgets are also registered under **Appearance > Widgets**:
- **MagPro - Tabbed Posts**
- **MagPro - Recent Posts**

---

## 📦 Directory Structure

```
blog-theme/
├── mag-pro/                      # Mag Pro WordPress Theme
│   ├── style.css                 # Theme header & styles (Author: Developer Zahir)
│   ├── functions.php             # Core setup & loader
│   ├── inc/
│   │   ├── magpro-core.php       # Enqueues, anti-FOUC script, ticker, dark toggle
│   │   └── plugins/
│   │       ├── class-tgm-plugin-activation.php
│   │       ├── tgm-config.php    # Requires Mag Pro Elements
│   │       ├── admin-notice.php  # Admin activation alerts
│   │       └── mag-pro-elements.zip # Bundled plugin archive
│   └── assets/
│       ├── css/magpro-theme.css  # Dark/Light color system & styles
│       └── js/magpro-theme.js    # Switcher & ticker logic
│
├── mag-pro-elements/             # Companion Elementor Plugin
│   ├── mag-pro-elements.php      # Main plugin entry
│   ├── assets/
│   │   ├── css/magpro-elements.css
│   │   └── js/magpro-elements.js
│   └── inc/
│       ├── class-magpro-helpers.php
│       ├── class-magpro-elementor-loader.php
│       ├── class-magpro-shortcodes.php
│       ├── class-magpro-wp-widgets.php
│       └── widgets/              # 9 Elementor Widget classes
│
└── MagPro .xml                   # Original Blogger source template
```

---

## 🔧 Installation

1. Copy or upload `mag-pro` to `wp-content/themes/`.
2. Activate **Mag Pro** under **Appearance > Themes**.
3. Follow the prompt to install & activate **Mag Pro Elements** and **Elementor**.
4. Create and design magazine pages using Elementor!
