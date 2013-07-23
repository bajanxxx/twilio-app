# configure and restart supervisord
# Author: Juni Samos jsamos@gmail.com

template "/etc/supervisor.d/sqs.conf" do
  source "sqs.erb"
  notifies :run, "bash[reread_supervisor_config]", :immediately
end

bash "reread_supervisor_config" do
  code <<-EOH
    sudo supervisorctl reread
    sudo supervisorctl update
  EOH
end