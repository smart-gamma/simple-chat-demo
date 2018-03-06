# config valid only for current version of Capistrano
lock '3.10.1'

set :application, 'ws-chat'
set :repo_url, 'git@bitbucket.org:stas_zozulja/simple-chat-demo.git'

set :branch, 'master'

set :deploy_to, '/home/webuser/chat'
set :symfony_env,  "prod"
set :sensio_distribution_version, 5

set :app_path, "app"
set :web_path, "web"
set :var_path, "var"
set :bin_path, "bin"

set :app_config_path, "app/config"
set :log_path, "var/logs"
set :cache_path, "var/cache"

set :symfony_console_path, "bin/console"
set :symfony_console_flags, "--no-debug"

set :assets_install_path, "web"
set :assets_install_flags,  '--symlink'

set :linked_files, []

set :file_permissions_paths, ["var"]
set :permission_method, :acl
set :file_permissions_paths, ["var/logs", "var/cache", "var/sessions"]
set :file_permissions_users, ["www-data"]

set :symfony_directory_structure, 3

set :format, :airbrussh

set :format_options, command_output: true, log_file: 'log/capistrano.log', color: :auto, truncate: :auto

set :pty, true

append :linked_files, 'app/config/parameters.yml'
set :linked_dirs, %w{var/logs vendor}

set :keep_releases, 5
set :log_level, :debug

after "deploy:starting", "composer:install_executable"
before "deploy:updated", "deploy:set_permissions:acl"
after "deploy:publishing", "yarn:build"