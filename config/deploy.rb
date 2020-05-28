# config valid for current version and patch releases of Capistrano
lock "~> 3.11"

set :application, "belkin_dom"
set :repo_url, "git@bitbucket.org:clarityproject/bd.git"

# Default branch is :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default deploy_to directory is /var/www/my_app_name
# set :deploy_to, "/var/www/my_app_name"

# Default value for :format is :airbrussh.
# set :format, :airbrussh

# You can configure the Airbrussh format using :format_options.
# These are the defaults.
# set :format_options, command_output: true, log_file: "log/capistrano.log", color: :auto, truncate: :auto

# Default value for :pty is false
# set :pty, true

# Default value for :linked_files is []
# append :linked_files, "config/database.yml", "config/secrets.yml"

# Default value for linked_dirs is []
# append :linked_dirs, "log", "tmp/pids", "tmp/cache", "tmp/sockets", "public/system"

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for local_user is ENV['USER']
# set :local_user, -> { `git config user.name`.chomp }

# Default value for keep_releases is 5
set :keep_releases, 5

# Uncomment the following to require manually verifying the host key before first deploy.
# set :ssh_options, verify_host_key: :secure

set :var_path, "var"

# Symfony console path
set :symfony_console_path, 		"bin/console"

# Symfony web path
set :web_path,              "public"

# Symfony log path
set :log_path,		fetch(:var_path) + '/logs'

# Symfony cache path
set :cache_path,		fetch(:var_path) + '/cache'

#Files that need to remain the same between deploys
set :linked_files,          [
	".env",
    fetch(:web_path) + '/robots.txt',
]

# Dirs that need to remain the same between deploys (shared dirs)
set :linked_dirs,           [fetch(:var_path) + '/sessions', "vendor", "public/uploads", fetch(:log_path)]

set :file_permissions_paths,         [fetch(:log_path), fetch(:cache_path)]

# Name used by the Web Server (i.e. www-data for Apache)
set :webserver_user,        "www-data"

# Assets install flags
set :assets_install_flags,  '--symlink'

set :composer_flags,        '--no-dev --prefer-dist --no-interaction --optimize-autoloader'

set :dump_name, Time.now.strftime('%F')+".sql"

namespace :host do

  task :sql_dump do
    on roles(%w{web app}) do
      execute "cd "+fetch(:dump_dir)+" && mysqldump -u "+fetch(:db_user)+" -p"+fetch(:db_pass)+" "+fetch(:db_name)+" > "+fetch(:db_dump_name)
    end
  end

  task :composer do
    on roles(%w{web app}) do
      within "#{release_path}" do
        execute "cd #{release_path} && composer install " + fetch(:composer_flags)
      end
    end
  end

  task :assets do
    on roles(%w{web app}) do
      within "#{release_path}" do
        execute "cd #{release_path} && php " + fetch(:symfony_console_path) + " assets:install " + fetch(:web_path)
      end
    end
  end

  task :warmup do
    on roles(%w{web app}) do
      within "#{release_path}" do
        execute "cd #{release_path} && php " + fetch(:symfony_console_path) + " cache:warmup --env=prod"
      end
    end
  end

  task :assetic do
    on roles(%w{web app}) do
      within "#{release_path}" do
        execute "cd #{release_path} && php " + fetch(:symfony_console_path) + " assetic:dump " + fetch(:web_path)
      end
    end
  end

  task :permissions do
    on roles(%w{web app}) do
      within "#{release_path}" do
        execute "cd #{release_path} && chmod -R 777 " + fetch(:log_path) + " " + fetch(:cache_path)
      end
    end
  end

  task :db_migrate do
    on roles(%w{web app}) do
      within "#{release_path}" do
        execute "cd #{release_path} && php " + fetch(:symfony_console_path) + " doctrine:migrations:migrate --env=prod"
      end
    end
  end

  task :npm_install do
    on roles(%w{web app}) do
      within "#{release_path}" do
        execute "cd #{release_path} && cd public/admin && npm install"
      end
    end
  end

  task :import_product_categories do
    on roles(%w{web app}) do
      within "#{release_path}" do
        execute "cd #{release_path} && php " + fetch(:symfony_console_path) + " bk:product:import-categories"
      end
    end
  end

end

after 'deploy:started',  'host:sql_dump'
after 'deploy:updated',  'host:composer'
after 'deploy:updated',  'host:npm_install'
after 'deploy:updated',  'host:assets'
after 'deploy:updated',  'host:warmup'
# after 'deploy:updated',  'host:assetic'
after 'deploy:updated',  'host:db_migrate'
# after 'deploy:updated',  'host:import_product_categories'
after 'deploy:updated',  'host:permissions'

