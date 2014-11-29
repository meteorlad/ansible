<?php
namespace Codeaken\Ansible;

class Inventory
{
    private $hosts = [];

    public function addHost($name, $ip, AuthMethod $authMethod)
    {
        $this->hosts[$name] = new Inventory\Host($name, $ip, $authMethod);
    }

    public function getHostByName($name)
    {
        if ( ! isset($this->hosts[$name])) {
            return false;
        }

        return $this->hosts[$name];
    }

    public function save($filename)
    {
        $lines = [];
        foreach ($this->hosts as $host) {
            $name       = $host->getName();
            $ip         = 'ansible_ssh_host=' . $host->getIp();
            $remoteUser = 'ansible_ssh_user=' . $host->getAuth()->getRemoteUser();

            $lines[] = "$name $ip $remoteUser";
        }

        file_put_contents($filename, implode("\n", $lines));
    }
}
