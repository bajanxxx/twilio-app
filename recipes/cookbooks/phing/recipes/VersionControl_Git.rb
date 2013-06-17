bash "VersionControl_Git" do
    code <<-EOH
        sudo pear config-set preferred_state alpha
        sudo pear install VersionControl_Git
    EOH
    not_if "pear list | grep VersionControl_Git"
end