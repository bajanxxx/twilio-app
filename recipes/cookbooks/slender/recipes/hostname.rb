bash "set_hostname" do
  user "root"
  code <<-EOH
    hostname slender-app.local
  EOH
end