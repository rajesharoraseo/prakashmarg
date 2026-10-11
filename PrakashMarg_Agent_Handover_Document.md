# Prakash Marg - Project Handover & Technical Review Document

## 1. Project Overview & Vision
**Prakash Marg** is an enterprise-grade, monetized, and scalable WordPress platform dedicated to structured Indian spiritual knowledge (Temples, Scriptures, Deities, Saints, and Festivals). The project focuses on high engagement via interactive tools and is built with scalability, premium UI (Tailwind CSS), and e-commerce capabilities in mind.

This document serves as a comprehensive technical guide for any AI Agent or Developer taking over or contributing to the project.

---

## 2. Technical Stack & Architecture
- **CMS:** WordPress
- **Theme:** Custom Full Site Editing (FSE) Theme (`prakash-marg`).
- **Plugin:** Custom MU-Plugin (`prakash-marg-core`) acting as the core engine.
- **Styling:** Tailwind CSS (utility-first premium aesthetic, integrated within the theme via `theme.json` and custom CSS builds).
- **Architecture Pattern:** Custom Service Container (IoC) inside the core plugin for managing Entity Registries, Repositories, and APIs.
- **Automation:** Python scripts in the root directory for web scraping, database populating, and theme updates.

---

## 3. Directory Structure

### 3.1 Workspace Root (`c:\PrakashMarg`)
Contains utility scripts, standalone HTML mockups, and automation tools.
- `Project_Master_Plan.md` / `README.md`: High-level roadmap and feature summaries.
- `*.html` (e.g., `index.html`, `blog.html`, `single.html`): Frontend mockups and static references.
- `*.py` (e.g., `scraper_bot.py`, `add_ad_slot.py`, `fix_entity_blocks.py`): Python automation scripts for data scraping and mass file fixing.
- `*.php` (e.g., `populate.php`, `clear_fse.php`, `reset_fse.php`): Standalone utility scripts to manage WP data outside the typical admin flow.

### 3.2 Core Plugin (`wp-content/mu-plugins/prakash-marg-core`)
The brain of the platform. Encapsulates all backend logic.
- **`prakash-marg-core.php`**: Plugin bootstrapper.
- **`includes/Core.php`**: The Dependency Injection container that registers and boots services.
- **`includes/Entities/`**: Contains the `EntityRegistry.php` and subfolders for each of the 5 core entities (`Temple`, `Scripture`, `Deity`, `Saint`, `Festival`). Each entity class handles Custom Post Type (CPT) registration and meta fields.
- **`includes/Api/`**: Custom REST API endpoints (e.g., `SearchEndpoint.php`, `ToolsEndpoint.php`).

### 3.3 Theme (`wp-content/themes/prakash-marg`)
A block-based (FSE) WordPress theme.
- **`theme.json`**: Defines Global Styles, typography (`Tiro Devanagari Hindi`, `Mukta`), color palettes (Forest Green, Classic Gold, Ivory), and custom templates.
- **`blocks/`**: Contains 30+ custom dynamic Gutenberg blocks. Divided into categories:
  - **Entity Heroes:** `temple-hero`, `scripture-hero`, etc. (Dynamically styles heroes based on content type, e.g., Shani Chalisa gets a dark theme, Hanuman Chalisa gets a red/gold theme).
  - **Entity Details:** `temple-details`, `saint-details`, etc.
  - **Relationships:** `temple-relationships` (links entities together).
  - **Features:** `hero-search`, `jaap-counter`, `panchang-widget`, `daily-wisdom`, `lucky-number`.
  - **Monetization:** `sidebar-monetize`, `ad-slot`.
- **`templates/`**: FSE HTML templates for pages, archives, and single CPTs (e.g., `single-pm_temple.html`).
- **`style.css`**: Built Tailwind CSS and custom block styling.

---

## 4. Core Entities (The Entity Engine)
The platform revolves around 5 interconnected Custom Post Types (CPTs), prefixed with `pm_`:
1. **Temple (`pm_temple`)**: Includes meta for location, timings, deity, etc.
2. **Scripture (`pm_scripture`)**: Chalisa, Aarti, Granth. Includes language, author, meaning.
3. **Deity (`pm_deity`)**: Manifestations, mantras, associated festivals.
4. **Saint (`pm_saint`)**: Lineage, birthplaces, key teachings.
5. **Festival (`pm_festival`)**: Tithi, significance, associated deities.

All entities are registered via the `EntityRegistry` service in the MU-plugin.

---

## 5. Completed Sprints & Features

### Phase 1 & 2: Architecture & Entities
- Setup of WP Environment, MU-Plugin (`prakash-marg-core`), and Theme (`prakash-marg`).
- Implemented IoC container (`pm_core()`).
- Registered all 5 entities with rich schema and metadata.

### Phase 3: Frontend & Presentation Layer
- Built Dynamic Blocks (`hero`, `details`, `relationships`) for all entities.
- Implemented Tailwind CSS styling.
- Example Logic: `scripture-hero/render.php` reads the post title and dynamically changes the gradient theme (e.g., Dark blue for Shiv, Maroon for Durga).

### Recent Work (Frontend Integration - Search & Hero UI)
- **Header Refactoring (`parts/header.html`)**: Removed the static search bar from the header, replacing it with a search icon that triggers an overlay popup. Wrapped the overlay search input in a `<form action="/prakashmarg/" method="get">` to route standard searches to the `search.html` WordPress template.
- **Hero Section UI Upgrade (`templates/front-page.html`)**: Upgraded the hero banner to match the premium prototype. Changed the background overlay to a clean gradient that fades to transparent on the right, used `Mukta` extra-bold font for the title, and styled the hero search bar into a modern white pill shape. 
- **Top Ticker Bar (`style.css`)**: Increased the `.ticker-bar` height and text prominence for a more spacious, premium feel.
- **Search Logic (`assets/js/theme.js`)**: Restored the local static array search logic (from the old `main.js` backup) for both `initHeroSearch()` and `initOverlaySearch()`. This bypassed the missing REST endpoint (`/wp-json/pm/v1/search`) and provided immediate, fast autocomplete results.
- **Navigation & Buttons**: Fixed the href links for the hero buttons ("चालीसा पढ़ें" -> `/prakashmarg/index.php/chalisa-library`) and popular search pills to point to the correct WordPress paths.

---

## 6. Upcoming Sprints & Agent Action Items
The following phases are planned in `Project_Master_Plan.md`. An incoming agent should pick up from here:

### Phase 4: Homepage & UI Polish
- **Dainik Update Section**: Define the logic and content for the "Dainik Update" section.
- **Image Placeholders & Store Assets**: Replace/generate missing shop images (`product_hanuman_chalisa.jpg`, `rudraksha_mala.jpg`, etc.) and fix broken image paths in the frontend.
- **Menu Hover States**: Verify and fix the active/hover underline states for main navigation items across different pages.

### Phase 5: Advanced Search & Filtering (Sprint 6)
- **REST API**: Build/refine `/wp-json/pm/v1/search`.
- **AJAX Block**: Build `pm/advanced-search` block to filter entities dynamically by Location, Era, Tradition.

### Phase 6: E-Commerce & Monetization (Sprint 7)
- Integrate WooCommerce for eBooks and Pooja Samagri.
- Build `pm/ad-slot` for Adsense/Direct clients.
- Add Affiliate buttons (e.g., Amazon links for books).

### Phase 7: Interactive Tools (Sprint 8)
- **Jaap Counter**: Local-storage based digital counter block.
- **Daily Lucky Number**: Lead-gen numerology tool.
- **Panchang Widget**: Daily active user retention API tool.

---

## 7. Development Guidelines for Future Agents
1. **Never hardcode entity data**: Always pull from WP Meta using `get_post_meta()` and format via the Entity classes.
2. **FSE Principles**: Do not write PHP templates for frontend rendering unless it's a dynamic block `render.php`. Use `theme.json` and block markup inside `templates/*.html`.
3. **Tailwind Classes**: Use Tailwind utility classes within block templates. For complex, repetitive styles, abstract them safely.
4. **Monetization First**: Always consider where `sidebar-monetize` or `ad-slot` can fit into the layout without breaking the aesthetic.
5. **Hindi/Devanagari Support**: Maintain `Tiro Devanagari Hindi` for headings. Ensure UTF-8 encoding in all string manipulations (e.g., `mb_strtolower` used in `scripture-hero/render.php`).
