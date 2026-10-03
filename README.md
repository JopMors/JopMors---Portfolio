# Jop — Portfolio (HTML · CSS · PHP · JS)

A plain PHP/HTML/CSS/JavaScript version of the Spine portfolio — no framework, no build step needed to run it.

## Run it locally

```bash
php -S localhost:8000
```

Run that inside this folder, then open http://localhost:8000.

## Put it online

Upload everything except `tools/` to any host that runs PHP (8.0+). `index.php` is the page.

---

## Where to change what

| I want to change… | File |
| --- | --- |
| Name, "Jop Mörs", role, description, email, socials, projects, jobs, studies, skills, capabilities | `includes/data.php` |
| Projects (launched or ongoing) | `includes/data.php` → `$projects` (`'status' => 'launched'` or `'ongoing'`) |
| Hide a project's GitHub button (closed source) | `'closedSource' => true` on that project in `includes/data.php` |
| Spindle's page | `includes/projects/spindle.php` (live at `/projects/spindle/`) |
| Section order | `index.php` |
| Navigation links | `includes/nav.php` |
| A section's layout | `includes/<section>.php` (`hero`, `statement`, `what-i-do`, `work`, `capabilities`, `timeline`, `contact`) |
| The code on the laptop screen | `includes/code-screen.php` |
| Colours, fonts | `assets/css/site.css` (`:root`) |
| Your own CSS | bottom of `assets/css/site.css` |
| The liquid-glass look (`.lg`, `.lg-strong`, `.lg-dark`, `.lg-clear`) | `assets/css/liquid-glass.css` |
| The zoom intro (timing, camera) | `assets/js/hero.js` — constants at the top |
| Animations of the other sections | `assets/js/effects.js`, `ui.js`, `what-i-do.js`, `dock.js`, `nav.js` |
| Contact form behaviour | `assets/js/form.js` |
| Images, logos, fonts | `assets/img/`, `assets/fonts/` |

### Adding a page for another launched project

1. In `includes/data.php`, give the project `'status' => 'launched'` and a `'slug'` (e.g. `'my-app'`).
2. Copy `projects/spindle/index.php` to `projects/my-app/index.php` and change `$slug` to `'my-app'`.
3. Copy `includes/projects/spindle.php` to `includes/projects/my-app.php` and rewrite its content.

The home page's Work section then shows a "View project" button for it automatically. Pages in sub-folders use `asset('…')` for file paths so images and styles still resolve.

### About the CSS classes

The markup uses Tailwind-style class names (`text-m-muted`, `rounded-[28px]`, …). They're already compiled into `assets/css/tailwind.css`, so the site works as-is. If you add a class that isn't used anywhere yet, either:

- write it as normal CSS at the bottom of `assets/css/site.css`, or
- regenerate the file (needs Node.js once): `cd tools && npm install && npm run build:css` (or `npm run watch:css` while editing).

Colour classes all start with `m-`: `bg-m-bg`, `text-m-text`, `text-m-muted`, `text-m-label`, `text-m-accent`, `border-m-line/10`.

### Changing the intro photo

The photo is `assets/img/workspace/master.webp` (+ `master-blur.webp`). If you replace it, update the MacBook position in image pixels in **both** `includes/hero.php` (the lid's size/offsets) and `assets/js/hero.js` (`LID`, `DISPLAY`).

### Contact form

Submissions go to Formspree (form `xrpbndan`) via `fetch` in `assets/js/form.js`; the form's `action` is the no-JS fallback.
