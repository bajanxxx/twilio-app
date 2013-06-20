Slender Deploy App
==================

Deploys a full application on a single vagrant or real machine

Vagrant
=======
* $ vagrant up
* $ vagrant ssh
* $ sudo ssh-keygen -t rsa -C "your_email@example.com"
* $ cat /root/.ssh/id_rsa.pub (and add it to you ssh keys on github)
* $ cd /var/www/
* $ sudo phing

Real Machine
=======

Currently there are more steps than I would like do to the file structure

* ssh into the machine
* $ sudo ssh-keygen -t rsa -C "your_email@example.com"
* $ cat /root/.ssh/id_rsa.pub (and add it to you ssh keys on github)
* $ cd /var
* $ rm -rf www
* $ sudo git clone https://github.com/dwsla/slender-app.git
* $ sudo mv slender-app/* .
* $ sudo rm -rf slender-app/ Vagrantfile  recipes/ .gitignore .vagrant
* $ cd www
* $ sudo phing

NOTE: you may see an error message complaining some directories don't exists, but the will be created

Example properties
==============
What's the environment of this machine?: qa

What's the basename of the site (e.g. example.com): dws.la

What's the base uri on the api? (e.g. mysite maps => http::/api.url.com/mysite): dwsla

What's the github uri for the API? git@github.com: dwsla/dws.la-api.git

What's the github uri for the CMS? git@github.com: dwsla/dws.la-cms.git

What's the github uri for the Front End? git@github.com: dwsla/dws.la.git
