---
name: Epsilon Marketplace
colors:
  surface: '#f7f9fb'
  surface-dim: '#d8dadc'
  surface-bright: '#f7f9fb'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f2f4f6'
  surface-container: '#eceef0'
  surface-container-high: '#e6e8ea'
  surface-container-highest: '#e0e3e5'
  on-surface: '#191c1e'
  on-surface-variant: '#45474c'
  inverse-surface: '#2d3133'
  inverse-on-surface: '#eff1f3'
  outline: '#75777d'
  outline-variant: '#c5c6cd'
  surface-tint: '#545f73'
  primary: '#091426'
  on-primary: '#ffffff'
  primary-container: '#1e293b'
  on-primary-container: '#8590a6'
  inverse-primary: '#bcc7de'
  secondary: '#006c4a'
  on-secondary: '#ffffff'
  secondary-container: '#82f5c1'
  on-secondary-container: '#00714e'
  tertiary: '#0b0054'
  on-tertiary: '#ffffff'
  tertiary-container: '#1a008e'
  on-tertiary-container: '#8580ff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#d8e3fb'
  primary-fixed-dim: '#bcc7de'
  on-primary-fixed: '#111c2d'
  on-primary-fixed-variant: '#3c475a'
  secondary-fixed: '#85f8c4'
  secondary-fixed-dim: '#68dba9'
  on-secondary-fixed: '#002114'
  on-secondary-fixed-variant: '#005137'
  tertiary-fixed: '#e3dfff'
  tertiary-fixed-dim: '#c3c0ff'
  on-tertiary-fixed: '#100069'
  on-tertiary-fixed-variant: '#372abf'
  background: '#f7f9fb'
  on-background: '#191c1e'
  surface-variant: '#e0e3e5'
typography:
  headline-xl:
    fontFamily: Plus Jakarta Sans
    fontSize: 40px
    fontWeight: '800'
    lineHeight: 48px
  headline-xl-mobile:
    fontFamily: Plus Jakarta Sans
    fontSize: 30px
    fontWeight: '800'
    lineHeight: 38px
  headline-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
  headline-lg-mobile:
    fontFamily: Plus Jakarta Sans
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
  headline-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 22px
    fontWeight: '700'
    lineHeight: 28px
  headline-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 18px
    fontWeight: '600'
    lineHeight: 24px
  body-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  body-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 12px
    fontWeight: '400'
    lineHeight: 16px
  label-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 20px
  label-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 12px
    fontWeight: '600'
    lineHeight: 16px
  label-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 11px
    fontWeight: '700'
    lineHeight: 14px
  price-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 24px
    fontWeight: '800'
    lineHeight: 28px
  price-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 18px
    fontWeight: '800'
    lineHeight: 22px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  gutter: 1.25rem
  gutter-desktop: 1.5rem
  margin: 1rem
  margin-tablet: 1.5rem
  margin-desktop: 2.5rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 2.5rem
---

## Brand & Style

This design system drives a transactional, peer-to-peer, and commercial classifieds marketplace where trust, transactional clarity, and speed of discovery are paramount. 

The visual style is **Modern Functionalist with Tactile Precision**:
- High-clarity layouts that emphasize visual content, structured metadata, and verifiable seller authority.
- The interface feels clean and unencumbered, prioritizing quick scanning across dense visual listings while maintaining calm breathing room on detail and checkout views.
- Deep, institutional indigo and navy anchor the core UI to project institutional stability and security, while energetic emerald accents direct attention unambiguously to transactional decisions, contact actions, and verified states.

## Colors

The palette establishes an immediate division between structural navigation and transactional focus:

- **Primary (`#1e293b` / `#0f172a`)**: The deep navy core anchors system headers, navigation bars, primary text elements, and core iconography. It provides maximum contrast against light surfaces without the severe harshness of pure black.
- **Secondary (`#059669` / `#10b981`)**: The vivid emerald green is strictly reserved for user momentum: primary calls-to-action ("Contact Seller", "Make Offer", "Place Ad"), price callouts, verified trust badges, and active state indicators.
- **Tertiary (`#4338ca` / `#312e81`)**: Rich indigo provides support for category taxonomy tags, secondary links, active filter states, and system-level informational accents.
- **Neutral (`#f8fafc`)**: The light slate canvas background provides subtle tone separation beneath crisp, pure white (`#ffffff`) card surfaces, eliminating sterile pure-white glare.
- **Borders & Dividers**: Structured via slate-200 (`#e2e8f0`) to guarantee deliberate, crisp delineations between listings, inputs, and layout blocks.

## Typography

The typography leverages **Plus Jakarta Sans** across all roles to achieve a contemporary, welcoming, yet precise presence.

- **Numerics & Prices**: Set using tabular lining figures (`tnum`) to ensure aligned pricing columns, rapid comparative scanning, and robust scannability across multi-listing feeds.
- **Headlines**: Weighted at Bold (700) to Extra Bold (800) to construct strong visual anchors above high-saturation imagery.
- **Body & Metadata**: Weighted at Regular (400) and SemiBold (600) to create a clean distinction between descriptive copy and critical metadata (timestamp, mileage, location, condition).

## Layout & Spacing

The layout uses a structured grid that adapts systematically to accommodate high-density listing inventory:

- **Desktop (12 Columns, max 1320px content boundary)**: Outer margins set to `margin-desktop` (`2.5rem`), gutters set to `gutter-desktop` (`1.5rem`). Search feeds display in a 4-column card grid or 1-column list with a fixed 320px left-hand facet rail.
- **Tablet (8 Columns, 768px – 1024px)**: Outer margins set to `margin-tablet` (`1.5rem`), gutters set to `gutter` (`1.25rem`). Search feeds collapse to a 2-column or 3-column configuration; filters transition to an expandable horizontal ribbon or sheet.
- **Mobile (4 Columns, <768px)**: Outer margins set to `margin` (`1rem`), gutters set to `0.75rem`. Feeds reflow to a 1-column feed or a high-density 2-column compact grid. Sticky bottom utility bar handles search triggers, chat shortcuts, and ad creation.
- **Rhythm**: Component spacing strictly adheres to a 4px/8px incremental scale, ensuring consistent baseline alignment between media containers and text specs.

## Elevation & Depth

This design system avoids heavy shadows, instead using light-slate canvas contrast, crisp micro-borders, and low-opacity ambient shadows:

- **Base Layer (Ground)**: Slate-50 canvas (`#f8fafc`).
- **Surface Layer (Cards & Panels)**: Pure white (`#ffffff`) paired with a `1px` structural outline of slate-200 (`#e2e8f0`).
- **Resting Elevation**: `0 1px 3px 0 rgba(15, 23, 42, 0.04), 0 1px 2px -1px rgba(15, 23, 42, 0.04)`. Ensures individual cards cleanly separate from the slate background without looking lifted.
- **Hover / Interactive Elevation**: Used on listing cards during cursor interaction: `0 10px 15px -3px rgba(15, 23, 42, 0.06), 0 4px 6px -4px rgba(15, 23, 42, 0.04)`, combined with a `-2px` vertical translation.
- **Overlay Elevation**: Used for flyouts, sticky purchase rails, and modal dialogues: `0 20px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04)` combined with backdrop blur (`blur(8px)` over 40% `#0f172a` overlay).

## Shapes

The geometric approach balances high-volume utility with approachable ergonomics:

- **Standard Cards & Containers**: Feature `rounded-xl` (`1rem` / `16px`) corners, producing friendly, distinctive boundaries around listing images and grouped data panels.
- **Interactive Controls (Inputs, Buttons, Pills)**: Feature `rounded-lg` (`0.5rem` / `8px`) to maintain sharp visual alignment with form labels and adjacent elements.
- **Category Tiles & Badges**: Utilize `rounded-xl` (`1rem`) to create smooth, touch-friendly touch targets.
- **Media Assets**: Listing image carousels inherit parent card radii (`16px` on top edges or full cards depending on layout mode).

## Components

### Buttons
- **Primary CTA**: Emerald green (`#059669`) background, white text, semi-bold typography, `rounded-lg`. Hover shifts to `#047857`. Focus state adds an emerald ring: `box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.35)`.
- **Secondary Action**: Slate-100 background, navy (`#1e293b`) text, hover shifts to slate-200.
- **Outline / Ghost**: 1px slate-200 border, white background, navy text. Hover introduces slate-50 fill and slate-300 border.

### Listing Cards
- Constructed with a pure white surface, a crisp 1px border (`#e2e8f0`), and `rounded-xl` geometry.
- Aspect ratio for primary thumbnail: 4:3 with subtle overflow clipping.
- Contains integrated badges (e.g., "Verified Seller", "Promoted") positioned with an 8px inset from top-left, featuring solid backgrounds with micro-shadows for high legibility over variable photography.
- Price displayed in `price-md` (`#1e293b` or `#059669`), paired with lightweight location and timestamp indicators in slate-500.

### Input Fields & Search Bars
- **Default State**: Pure white background, `1px` border in `#cbd5e1`, `rounded-lg`, 14px padding.
- **Focus State**: Border switches to navy (`#1e293b`) or indigo (`#4338ca`) coupled with a distinct 3px outer focus ring: `0 0 0 3px rgba(67, 56, 202, 0.15)`.
- **Global Search Bar**: Elevated pill or `rounded-xl` container with an integrated location pill, category dropdown, and an emerald search button on the trailing edge.

### Chips & Badges
- **Filter Chips**: 1px slate-200 border, white fill, slate-700 text. When active: deep indigo fill (`#312e81`), white text, no border.
- **Trust Badges**: Light emerald tint fill (`#ecfdf5`), dark emerald text (`#065f46`), 1px emerald border (`#a7f3d0`), paired with a checkmark icon.

### Checkboxes & Radio Buttons
- Crisp 1.5px border in slate-300.
- Selected state fills with secondary emerald (`#059669`) with white vector check/dot indicators.
- Focus rings match standard input states for accessible keyboard tab-navigation.

### Seller Profile & Chat Snippets
- Avatars use circular geometry with an absolute-positioned green presence indicator.
- Message bubbles cleanly delineate between user (deep indigo/navy fill, white text) and counterparty (slate-100 fill, slate-900 text).