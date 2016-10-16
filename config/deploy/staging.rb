server 'ws-chat.smart-gamma.com', user: 'ws-chat', roles: %w{app web}
SSHKit.config.command_map[:composer] = "php #{shared_path.join("composer.phar")}"