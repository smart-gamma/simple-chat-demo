set :yarn_flags, '--silent --no-progress'
set :yarn_roles, :web
set :yarn_env_variables, {}

namespace :yarn do

  desc 'Install the project dependencies via yarn.'
  task :install do
    on roles fetch(:yarn_roles) do
      within fetch(:yarn_target_path, release_path) do
        with fetch(:yarn_env_variables, {}) do
          execute fetch(:yarn_bin), 'install', fetch(:yarn_flags)
        end
      end
    end
  end

  desc 'Run Encore'
  task :run_encore do
    on roles fetch(:yarn_roles) do
      within fetch(:yarn_target_path, release_path) do
        with fetch(:yarn_env_variables, {}) do
          execute fetch(:yarn_bin), 'run encore production'
        end
      end
    end
  end

  desc 'Yarn tasks'
  task :build do
    invoke 'yarn:install'
    invoke 'yarn:run_encore'
  end
end

namespace :load do
  task :defaults do
    set :yarn_bin, :yarn
  end
end