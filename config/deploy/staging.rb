server '54.156.9.108', user: 'webuser', roles: %w{app web}
SSHKit.config.command_map[:composer] = "php #{shared_path.join("composer.phar")}"