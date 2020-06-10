<?php

namespace Boravel\Traits\Actions;

use Boravel\Resources\CertificateHealth;

trait ManagesCertificateHealth
{
    public function certificateHealth(int $siteId)
    {
        return new CertificateHealth($this->get("certificate-health/{$siteId}"));
    }
}
