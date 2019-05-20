<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use SiAtmo\Service;


class ServiceTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $service = Service::create(["keterangan" => "Ganti Motor","biayaService" => 16000000]);
        $this->assertDatabaseHas('service', [
                "keterangan" => "Ganti Motor","biayaService" => 16000000
            ]);
        Service::find($service->kodeService)->update(["keterangan" => "Ganti Busi","biayaService" => 50000]);
        $this->assertDatabaseHas('service', [
                'keterangan' => 'Ganti Busi','biayaService' => 50000
            ]);
        Service::destroy($service->kodeService);
        $this->assertDatabaseMissing('service', [
            'keterangan' => 'Ganti Busi','biayaService' => 50000
            ]);
    }
}
