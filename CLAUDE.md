# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Theme Overview
This is a WordPress theme built on JointsWP, a Foundation 6 starter theme. The theme uses Gulp for build processes, Sass for styling, and follows WordPress theming conventions.

## Build Commands

### Development
- `npm run watch` - Watch for changes and rebuild assets automatically
- `npm run browsersync` - Watch with live browser reload (update `LOCAL_URL` in gulpfile.js:16)

### Production Build
- `npm run build` - Compile and minify all assets (runs automatically after `npm install`)

### Individual Asset Compilation
- `npm run styles` - Compile SCSS files only
- `npm run scripts` - Compile JavaScript files only
- `npm run images` - Optimize images only

### Code Quality
- `npm run stylelint` - Lint SCSS files
- `npm run stylelint-fix` - Auto-fix SCSS linting issues

## Architecture

### Asset Structure
- **Source Files:**
  - SCSS: `assets/styles/scss/` → Compiled to `assets/styles/`
  - JavaScript: `assets/scripts/js/` → Compiled to `assets/scripts/`
  - Images: `assets/images/src/` → Optimized to `assets/images/`

### WordPress Function Organization
All WordPress functionality is modularized in the `functions/` directory:
- `theme-support.php` - WordPress theme features
- `enqueue-scripts.php` - Asset loading
- `menu.php` - Navigation menus
- `sidebar.php` - Widget areas
- `comments.php` - Comment system
- `cleanup.php` - WordPress cleanup functions
- `page-navi.php` - Pagination

Optional modules (commented out in functions.php):
- `editor-styles.php` - Admin editor styling
- `disable-emoji.php` - Remove emoji support
- `related-posts.php` - Related posts functionality
- `custom-post-type.php` - Custom post type template
- `login.php` - Custom login styling
- `admin.php` - Admin customizations

### Foundation Framework
- Uses Foundation 6.5.3 with selective component loading in gulpfile.js:22-56
- Settings configured in `assets/styles/scss/_settings.scss`
- Custom styles in `assets/styles/scss/_global.scss`

### Styling Configuration
- Two stylelint configs: `.stylelintrc.json` (primary) and `.stylelintrc.yml`
- Uses `stylelint-config-standard-scss` with custom rules
- Sass compilation with autoprefixer and source maps

### Local Development
- Update `LOCAL_URL` in gulpfile.js:16 to match your local WordPress URL
- BrowserSync proxy configuration for live reloading

## Key Files to Modify
- `functions.php` - Enable/disable theme features by uncommenting includes
- `assets/styles/scss/_settings.scss` - Foundation configuration
- `assets/styles/scss/_global.scss` - Custom theme styles
- `assets/scripts/js/` - Custom JavaScript (auto-concatenated)
- `gulpfile.js` - Build process and Foundation component selection