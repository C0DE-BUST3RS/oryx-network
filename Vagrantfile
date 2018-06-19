# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    config.vm.provider "virtualbox" do |v|
      v.memory = 1024
      v.cpus = 2
    end

    # Every Vagrant virtual environment requires a box to build off of.
    config.vm.box = "ubuntu/trusty64"

    # Create a private network, which allows host-only access to the machine using a specific IP.
    config.vm.network "private_network", ip: "192.168.33.22"

    # Forward ports
    ## Apache HTTP
    config.vm.network "forwarded_port", guest: 80, host: 8080
    ## MySQL
    config.vm.network "forwarded_port", guest: 3306, host: 3306
    # PostgreSQL Server
    config.vm.network "forwarded_port", guest: 5432, host: 16432

    # Share an additional folder to the guest VM. The first argument is the path on the host to the actual folder.
    # The second argument is the path on the guest to mount the folder.
    config.vm.synced_folder "./public", "/var/www/app", owner: "www-data", group: "www-data"

    # Define the bootstrap file: A (shell) script that runs after first setup of your box (= provisioning)
    config.vm.provision :shell, path: "scripts/provision-vagrant.sh"

end