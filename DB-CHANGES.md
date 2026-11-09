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
