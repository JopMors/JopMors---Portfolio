# Jop Mörs — Portfolio

The static (HTML · CSS · JS) build of my portfolio, served by GitHub Pages at [jopmors.com](https://jopmors.com).

## Don't edit the HTML here

These pages are generated from the PHP version of the site. Make changes there, then rebuild into this folder:

```bash
php tools/build-static.php "../JopMors---Portfolio"
```

Run that from the PHP project. It re-renders every page to `index.html` and copies `assets/`; `CNAME`, this README and `.git` are left alone.

## Run it locally

```bash
python3 -m http.server 8000
```

Then open http://localhost:8000.

## Contact form

Submissions go to Formspree (form `xrpbndan`) from `assets/js/form.js`.
