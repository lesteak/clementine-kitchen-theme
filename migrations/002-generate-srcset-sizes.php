<?php
/**
 * One-off: make the srcset crops for attachments whose ORIGINAL file is gone.
 *
 * `wp media regenerate --only-missing` cannot create new sizes without the
 * original. For those attachments we resize from the existing same-aspect-ratio
 * crop (e.g. hero-small 660x250 from the 1980x750 file) and record it in
 * _wp_attachment_metadata. Idempotent; run after `wp media regenerate --only-missing --yes`.
 *
 *   wp eval-file wp-content/themes/clementine-kitchen-theme/migrations/002-generate-srcset-sizes.php
 */

// new size => [source size to downscale from, width, height]
$targets = array(
  'hero-medium'      => array('hero', 1320, 500),
  'hero-small'       => array('hero', 660, 250),
  'letterbox-medium' => array('letterbox', 1320, 200),
  'letterbox-small'  => array('letterbox', 660, 100),
  'cropped-small'    => array('cropped', 300, 300),
  'cta-small'        => array('cta', 300, 200),
);

$made = 0;

foreach (get_posts(array('post_type' => 'attachment', 'numberposts' => -1, 'post_mime_type' => 'image')) as $att) {
  $file = get_attached_file($att->ID);
  if ($file && file_exists($file)) {
    continue; // original exists: normal regenerate handles it
  }

  $meta = wp_get_attachment_metadata($att->ID);
  if (empty($meta['sizes']) || empty($meta['file'])) {
    continue;
  }

  $dir = dirname(wp_upload_dir()['basedir'] . '/' . $meta['file']);
  $changed = false;

  foreach ($targets as $name => $t) {
    list($source, $w, $h) = $t;

    if (isset($meta['sizes'][$name]) || empty($meta['sizes'][$source])) {
      continue;
    }

    $src_path = $dir . '/' . $meta['sizes'][$source]['file'];
    if (!file_exists($src_path)) {
      continue;
    }

    $editor = wp_get_image_editor($src_path);
    if (is_wp_error($editor)) {
      continue;
    }

    $editor->resize($w, $h, true);
    $saved = $editor->save($editor->generate_filename(null, $dir));

    if (is_wp_error($saved)) {
      continue;
    }

    $meta['sizes'][$name] = array(
      'file'      => $saved['file'],
      'width'     => $saved['width'],
      'height'    => $saved['height'],
      'mime-type' => $saved['mime-type'],
    );
    $changed = true;
    $made++;
  }

  if ($changed) {
    wp_update_attachment_metadata($att->ID, $meta);
    WP_CLI::log("  {$att->ID} " . basename($meta['file']));
  }
}

WP_CLI::success("Generated $made crops for attachments without originals.");
