# Database changes: Option Tree -> ACF migration

Theme options moved from Option Tree to an ACF Pro options page
(**Theme Options** in the WP admin menu). Fields are registered in code
(`lib/theme-options-fields.php`), so no ACF field group sync/import is needed.
Read values with `tofino_get_option('field_name', $default)`.

## Deploy steps (in order)

1. Deploy theme code. Run `composer install --no-dev -o` (drops `valendesigns/option-tree`
   from `vendor/` and regenerates the autoloader).
2. Run the migration (idempotent, never overwrites existing ACF values):

       wp eval-file wp-content/themes/clementine-kitchen-theme/migrations/001-option-tree-to-acf.php

3. Verify the site front end + **Theme Options** page.
4. Cleanup once verified (removes the dead Option Tree rows):

       wp option delete option_tree option_tree_settings ot_media_post_ID

## wp_options changes

| Change | Rows |
|---|---|
| Added by step 2 | `options_<name>` + `_options_<name>` (ACF field-key ref) for each non-empty saved option. On this site: `footer_text`, `menu_fixed_checkbox`, `menu_position_select`, `footer_sticky_checkbox`, `notification_position`, `maintenance_mode_text`, `contact_form_success_message` |
| Deleted by step 4 | `option_tree`, `option_tree_settings`, `ot_media_post_ID` |

No posts, postmeta or other tables are touched. `theme_tracking_uid` (option) and the
`theme_tracking` transient from the removed theme tracker are harmless leftovers; optionally
`wp option delete theme_tracking_uid` and `wp transient delete theme_tracking`.

## Behaviour notes

- Production's saved checkboxes were `[""]` (truthy), so **Disable Fixed Menu** and
  **Sticky Footer** are ON live. The migration keeps this: body class `footer-sticky`, no `menu-fixed`.
- Theme Tracker (phoned home to tracker.lambdacreatives.com; saved as disabled) was removed.
- Option Tree's `ot_get_option()` no longer exists; the `[option id="..."]` shortcode now uses ACF.

# Responsive images (srcset)

Images are output via `tofino_image()` (`lib/images.php`), which uses `wp_get_attachment_image()`
to emit `srcset`/`sizes`. New same-ratio crops registered in `functions.php`:
`hero-medium` 1320x500, `hero-small` 660x250, `letterbox-medium` 1320x200, `letterbox-small` 660x100,
`cropped-small` 300x300, `cta-small` 300x200. JPEG quality for generated crops is 75.

## Deploy steps (after the theme is live)

1. Back up the DB, then create the crops for existing uploads (adds files to `wp-content/uploads`, updates
   `_wp_attachment_metadata` postmeta on each attachment; nothing is deleted):

       wp media regenerate --only-missing --yes

2. 13 attachments have no original file on disk (ids 535, 536, 546, 564, 569, 571, 572, 577, 582, 583, 589, 595, 610),
   so step 1 reports "13 failed". Make their crops from the existing same-ratio files:

       wp eval-file wp-content/themes/clementine-kitchen-theme/migrations/002-generate-srcset-sizes.php

3. Purge caches: `wp cache flush && wp litespeed-purge all`.

Both steps are idempotent. Rollback = deploy the previous release; extra crop files are harmless.
