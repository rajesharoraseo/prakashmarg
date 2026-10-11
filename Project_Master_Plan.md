# Prakash Marg - Master Project Plan & Roadmap

**Vision:** An enterprise-grade, monetized, and scalable WordPress platform dedicated to structured Indian spiritual knowledge (Temples, Scriptures, Deities, Saints, and Festivals), complete with interactive tools and e-commerce capabilities.

---

## ✅ Completed Phases (Foundation & Core)
### Phase 1: Core Setup & Architecture
- Setup WordPress environment and `prakash-marg` FSE Theme.
- Established `prakash-marg-core` MU-Plugin and IoC Service Container.

### Phase 2: Entity Implementations
- Built Schema, Metadata, and Relationships for 5 Core Entities: **Temples, Scriptures, Deities, Saints, and Festivals**.

### Phase 3: Frontend & Presentation Layer
- Built all Dynamic Gutenberg Blocks (`hero`, `details`, `relationships`) for all 5 entities.
- Implemented Tailwind CSS for a premium, unified aesthetic.
- Verified dynamic rendering and data mapping across all inner pages.

---

## 🚧 Upcoming Phases (Execution & Polish)

### Phase 4: Homepage & UI Polish (Immediate Next Step)
- Refine `front-page.html` to create a "Wow" factor.
- Enhance typography, layout spacing, and hero sections to look highly premium and trustworthy.

### Phase 5: Advanced Search & Filtering (Sprint 6)
- **Goal**: Allow users to explore entities seamlessly.
- Create a custom REST API endpoint `/wp-json/pm/v1/search`.
- Build an interactive AJAX Search Block (`pm/advanced-search`) with real-time filters (by Location, Era, Tradition).

### Phase 6: E-Commerce & Monetization (Sprint 7)
- **WooCommerce Integration**: Ensure eBooks and Pooja Samagri shop pages inherit the premium theme design.
- **Custom Ad Blocks**: Build `pm/ad-slot` to support Google AdSense and direct client banners (e.g., Astrologers).
- **Affiliates**: Add "Buy/Affiliate" buttons to relevant entities (e.g., buy scripture books on Amazon).

### Phase 7: Interactive Tools for High Engagement (Sprint 8)
- Build **Jaap Counter (मंत्र जाप)**: Interactive digital counter saving progress locally.
- Build **Daily Lucky Number (दैनिक अंक ज्योतिष)**: Lead-gen tool for numerology directing users to Astrologer clients.
- Build **Festival Countdown & Panchang Widgets**: APIs/Calculations to increase daily active users.

### Phase 8: Go-Live & Migration
- Final testing, caching, and performance optimization.
- Migrate database and files from local XAMPP to a production live server/domain (prakashmarg.com).
