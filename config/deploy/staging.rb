set :default_env, { path: "/usr/local/bin:$PATH" }

set :composer_flags,        '--prefer-dist --no-interaction --optimize-autoloader'

set :environment,   "dev"
set :symfony_env,   "dev"

set :branch,        "master"
set :deploy_to,     "/srv/belkin_dom/src"

set :sql_root_pass, "12345"

set :db_user,       "root"
set :db_pass,       "12345"
set :db_name,       "bk_dev"
set :dump_dir,      "/srv/belkin_dom/sql_dumps/"
set :db_dump_name,  Time.now.strftime('%F')+".sql"

set :links_dir,     "/srv/belkin_dom"

# # The server-based syntax can be used to override options:
# # ------------------------------------

server '188.166.160.54',
  user: 'root',
  roles: %w{web app},
  ssh_options: {
    keys: %w(~/.ssh/id_rsa),
    forward_agent: false,
    user: 'root', # overrides user setting above
    auth_methods: %w(publickey password),
  }