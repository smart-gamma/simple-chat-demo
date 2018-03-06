set :stage_config_path, 'capistrano/stages'
set :deploy_config_path, 'capistrano/config/deploy.rb'

# Load DSL and set up stages
require "capistrano/setup"

# Include default deployment tasks
require "capistrano/deploy"
require "capistrano/scm/git"
install_plugin Capistrano::SCM::Git

require "capistrano/symfony"
require "capistrano/composer"
require "capistrano/file-permissions"

# Load custom tasks from `lib/capistrano/tasks` if you have any defined
Dir.glob("capistrano/config/tasks/*.rake").each { |r| import r }
