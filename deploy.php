<?php
namespace Deployer;

require 'recipe/common.php';


set('keep_releases', 4);
// Keep the WP theme slug: the live symlink is themes/clementine-kitchen-theme (not themes/current)
set('current_path', '{{deploy_path}}/clementine-kitchen-theme');
// Start editable

set('repository', 'git@github.com:lesteak/clementine-kitchen-theme.git');

set('ssh_type', 'native');
set('ssh_multiplexing', true);

// End editable

// Do not modify anything under this line unless you know what you're doing

import('hosts.yml');

task('deploy:gulp', function() {
  $do_gulp = askConfirmation('Compile src?', false);
  if( $do_gulp ) { runLocally('npm run build'); }
})->desc('Create dist folder');

task('deploy:upload_dist', function() {
  upload('dist', '{{release_path}}');
})->desc('Upload dist folder to server');

task('deploy:theme_composer', function() {
  cd('{{release_path}}');
  run('composer install --no-dev --no-interaction -o');
  // run('~/composer.phar install --no-dev -o');
})->desc('Remote composer install');

task('deploy:cache_flush', function () {
  run('wp --path=public_html cache flush || true');
  run('wp --path=public_html litespeed-purge all || true');
})->desc('Flush WP object cache and LiteSpeed page cache');

task('deploy', [
  'deploy:setup',
  'deploy:lock',
  'deploy:gulp',
  'deploy:release',
  'deploy:update_code',
  'deploy:theme_composer',
  'deploy:upload_dist',
  'deploy:symlink',
  'deploy:cache_flush',
  'deploy:unlock',
  'deploy:cleanup',
])->desc('Executing Deploy task');


after('deploy:failed', 'deploy:unlock');
