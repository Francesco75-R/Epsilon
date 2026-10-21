---
name: Executive Slate & Gilt
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
  on-surface-variant: '#45464d'
  inverse-surface: '#2d3133'
  inverse-on-surface: '#eff1f3'
  outline: '#76777d'
  outline-variant: '#c6c6cd'
  surface-tint: '#565e74'
  primary: '#000000'
  on-primary: '#ffffff'
  primary-container: '#131b2e'
  on-primary-container: '#7c839b'
  inverse-primary: '#bec6e0'
  secondary: '#775a19'
  on-secondary: '#ffffff'
  secondary-container: '#fed488'
  on-secondary-container: '#785a1a'
  tertiary: '#000000'
  on-tertiary: '#ffffff'
  tertiary-container: '#161c22'
  on-tertiary-container: '#7e848c'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dae2fd'
  primary-fixed-dim: '#bec6e0'
  on-primary-fixed: '#131b2e'
  on-primary-fixed-variant: '#3f465c'
  secondary-fixed: '#ffdea5'
  secondary-fixed-dim: '#e9c176'
  on-secondary-fixed: '#261900'
  on-secondary-fixed-variant: '#5d4201'
  tertiary-fixed: '#dde3eb'
  tertiary-fixed-dim: '#c1c7cf'
  on-tertiary-fixed: '#161c22'
  on-tertiary-fixed-variant: '#41474e'
  background: '#f7f9fb'
  on-background: '#191c1e'
  surface-variant: '#e0e3e5'
typography:
  headline-xl:
    fontFamily: Plus Jakarta Sans
    fontSize: 36px
    fontWeight: '700'
    lineHeight: 44px
    letterSpacing: -0.02em
  headline-xl-mobile:
    fontFamily: Plus Jakarta Sans
    fontSize: 28px
    fontWeight: '700'
    lineHeight: 36px
    letterSpacing: -0.015em
  headline-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 28px
    fontWeight: '600'
    lineHeight: 36px
    letterSpacing: -0.015em
  headline-lg-mobile:
    fontFamily: Plus Jakarta Sans
    fontSize: 22px
    fontWeight: '600'
    lineHeight: 30px
    letterSpacing: -0.01em
  headline-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
    letterSpacing: -0.01em
  headline-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 16px
    fontWeight: '600'
    lineHeight: 24px
    letterSpacing: 0em
  body-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 26px
    letterSpacing: -0.005em
  body-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 22px
    letterSpacing: 0em
  body-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 12px
    fontWeight: '400'
    lineHeight: 18px
    letterSpacing: 0.01em
  label-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 20px
    letterSpacing: 0.01em
  label-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 12px
    fontWeight: '600'
    lineHeight: 16px
    letterSpacing: 0.02em
  label-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 11px
    fontWeight: '600'
    lineHeight: 14px
    letterSpacing: 0.04em
rounded:
  sm: 0.125rem
  DEFAULT: 0.25rem
  md: 0.375rem
  lg: 0.5rem
  xl: 0.75rem
  full: 9999px
spacing:
  gutter: 1.5rem
  gutter-mobile: 1rem
  margin: 2rem
  margin-mobile: 1rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 2rem
---

## Brand & Style

The design system projects an aura of discreet prestige, institutional trust, and high-tier membership utility. Designed for high-value portal experiences, it balances the razor-sharp efficiency of enterprise SaaS with the bespoke refinement of private banking and luxury hospitality. 

The aesthetic is Modern Executive: architectural, disciplined, and calm. Generous whitespace, precise micro-borders, and tactile layering eliminate cognitive clutter while elevating routine administrative tasks into premium interactions. Deep slate tones communicate authority and stability, while targeted touches of satin gold supply warmth and denote exclusivity, status, and milestone actions.

## Colors

The palette establishes an immediate optical hierarchy through deep structural slates, warm luminous golds, and architectural neutrals.

- **Primary (`#0F172A` / Slate 900):** Used for primary high-emphasis text, key interactive surfaces (primary buttons), and structural branding elements.
- **Secondary (`#C5A059` / Warm Satin Gold):** Reserved intentionally for premium accents, active status indicators, tier badges, key metric highlights, and focused states. Its muted, warm sheen prevents visual fatigue while maintaining an elite tone.
- **Tertiary (`#E2E8F0` / Slate 200):** Structural line-work, hairline dividers, and muted input borders.
- **Neutral Surface (`#F8FAFC` / Slate 50):** The primary canvas background, creating soft contrast beneath pure `#FFFFFF` card modules.
- **Text Layers:** 
  - Slate 800 (`#1E293B`) for primary titles and metrics.
  - Slate 700 (`#334155`) for readable body text and standard labels.
  - Slate 600 (`#475569`) for secondary metadata, timestamps, and column headers.
  - Slate 400 (`#94A3B8`) strictly for placeholder values and disabled icons.
- **Functional Semantics:**
  - Emerald (`#059669` / Success): Positive portfolio yields, active memberships, completed verifications.
  - Rose (`#E11D48` / Danger): Critical alerts, payment lapses, destructive actions.

## Typography

Typography is clean, modern, and structured using Plus Jakarta Sans across all tiers. Its geometry delivers high legibility across dense data tables, balances numerical figures cleanly, and introduces subtle warmth via contemporary humanist apertures.

Key guidelines:
- **Numerical Figures & KPI Metrics:** Utilize tabular figures (`font-variant-numeric: tabular-nums`) across cards and tables to prevent shifting layouts during dynamic data updates.
- **Overline Metadata & Badges:** Utilize `label-sm` set in uppercase with slight tracking (`letter-spacing: 0.04em`) to establish crisp section signifiers.
- **Headlines:** Use tightened negative tracking on titles larger than 20px to sustain density and an executive editorial finish.

## Layout & Spacing

The portal operates on a hybrid 12-column fluid grid system pinned inside an executive max-width canvas container (`max-w-7xl` or 1440px).

- **Grid Discipline:** Columns adapt gracefully across breakpoints:
  - **Desktop (≥1024px):** Fixed navigation sidebar (260px or 280px), main canvas with 12-column layout, `margin: 2rem`, `gutter: 1.5rem`.
  - **Tablet (768px – 1023px):** Collapsible off-canvas drawer navigation, 8-column layout, `margin: 1.5rem`, `gutter: 1.25rem`.
  - **Mobile (<768px):** Single-column stacked vertical layout, full-width content container, `margin-mobile: 1rem`, `gutter-mobile: 1rem`.
- **Card Interior Padding:** Maintain a strict rhythm of `space-md` (16px) for compact utility widgets and table containers; use `space-lg` (24px) for prominent hero metric units and standard content cards.

## Elevation & Depth

Visual hierarchy relies on crisp architectural surfaces and understated ambient diffusion, avoiding harsh drop shadows:

- **Base Canvas:** Flat `#F8FAFC` (Slate 50).
- **Default Card Surface:** Pure `#FFFFFF` resting atop the neutral canvas, delineated by a hairline border (`1px solid #F1F5F9` or `#E2E8F0`) paired with an ambient shadow: `box-shadow: 0 1px 3px 0 rgba(15, 23, 42, 0.04), 0 1px 2px -1px rgba(15, 23, 42, 0.02)`.
- **Hover & Active States:** Lift interactions transition the border to `rgba(197, 160, 89, 0.35)` (satin gold tone) with an elevated blur: `box-shadow: 0 4px 12px -2px rgba(15, 23, 42, 0.06), 0 2px 4px -2px rgba(15, 23, 42, 0.04)`.
- **Floating Modals & Flyouts:** High layer `box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04)`, bounded by a structural Slate 200 border.
- **Gold Accent Glow:** For key milestone highlights or VIP notifications, use a faint golden diffusion: `box-shadow: 0 0 0 1px #C5A059, 0 4px 16px -2px rgba(197, 160, 89, 0.20)`.

## Shapes

The design system employs a refined Soft geometry (`roundedness: 1`), conveying modern precision, discipline, and technological maturity without feeling blocky or playful.

- **Base Radius (`rounded-md` / 6px):** Form inputs, action buttons, table cell wrappers, and standard dropdown items.
- **Card Radius (`rounded-lg` / 8px):** Modular dashboard panels, data summary boxes, and dialog boxes.
- **Modal & Container Radius (`rounded-xl` / 12px):** Primary app modals, contextual slide-overs, and root surface panels.
- **Pills (`rounded-full`):** Exclusively designated for numeric counters, status badges, and user profile avatar crops.

## Components

### Iconography: Google Material Symbols
- Utilize Material Symbols (Outlined or Rounded variants) with a standard stroke weight (`font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24`).
- Standard icon box is 20px (`text-[20px]`) within form fields and buttons; 24px (`text-[24px]`) within sidebar navigation and metric widgets.
- Color: Default `text-slate-500`; active/highlighted `text-[#C5A059]`.

### Buttons
- **Primary:** Background Slate 900 (`#0F172A`), text `#FFFFFF`, subtle inner highlight, hover background Slate 800 (`#1E293B`).
- **Accent (Tier / Upgrade / Action):** Background `#C5A059`, text `#FFFFFF`, hover background `#B8934B`, active scale micro-interaction.
- **Secondary / Outline:** Background `#FFFFFF`, border `1px solid #E2E8F0`, text Slate 700 (`#334155`), hover border Slate 300, hover background Slate 50.
- **Ghost:** Background transparent, text Slate 600 (`#475569`), hover background Slate 100 (`#F1F5F9`).

### Inputs & Form Controls
- **Field Surface:** `#FFFFFF`, border `1px solid #E2E8F0`, padding `0.5rem 0.875rem`, text Slate 800.
- **Focus Ring:** Border transitions to `#C5A059` with a delicate outer ring: `ring-2 ring-[#C5A059]/20 outline-none`.
- **Checkboxes & Radios:** Hairline Slate 300 borders, check fill transitioning to Slate 900 or Gold `#C5A059` on selection with crisp white checkmark symbol.

### Chips & Member Badges
- **Executive / VIP Tier:** Background `rgba(197, 160, 89, 0.12)`, text `#947128`, border `1px solid rgba(197, 160, 89, 0.3)`.
- **Standard Status Chips:** Neutral Slate 100 fill, Slate 700 text; Success uses Emerald 50 fill with Emerald 700 text.

### Cards & Data Panels
- Surface `#FFFFFF`, border `1px solid #F1F5F9`, outer shadow `sm`.
- Include optional subtle top highlight border (`border-t-2 border-t-[#C5A059]`) to denote primary KPI widgets, featured membership tiers, or critical transaction summaries.

### Data Tables
- Header row: Surface `#F8FAFC`, uppercase `label-sm` tracking with `text-slate-600`, border-bottom `1px solid #E2E8F0`.
- Body rows: Surface `#FFFFFF`, alternating hover state `#F8FAFC/60`, border-bottom `1px solid #F1F5F9`, vertical cell align centered, height 52px.