<?php

namespace App\Livewire;

use App\Models\Kegiatan;
use App\Models\Mitra;
use App\Models\Pegawai;
use Livewire\Component;

class StatsCard extends Component
{
    public $selected_period = 'mom';
    public $count_kegiatan;
    public $average_beban_organik;
    public $count_organik_terlibat;
    public $count_mitra_terlibat;

    public function mount()
    {
        $this->updateStats();
    }

    public function updatedSelectedPeriod()
    {
        $this->updateStats();
    }

    public function updateStats()
    {
        if ($this->selected_period == 'mom') {
            $this->count_kegiatan = 12;
            $this->average_beban_organik = 3.3;
            $this->count_organik_terlibat = 56;
            $this->count_mitra_terlibat = 13;
        } elseif ($this->selected_period == 'qoq') {
            $this->count_kegiatan = 20;
            $this->average_beban_organik = 3.5;
            $this->count_organik_terlibat = 78;
            $this->count_mitra_terlibat = 21;
        } elseif ($this->selected_period == 'ytd') {
            $this->count_kegiatan = 80;
            $this->average_beban_organik = 3.7;
            $this->count_organik_terlibat = 120;
            $this->count_mitra_terlibat = 45;
        }

        //        $this->count_kegiatan = Kegiatan::countActiveKegiatan();
//        $this->average_beban_organik = Pegawai::getRerataBebanKerja();
//        $this->count_organik_terlibat = Pegawai::countPegawaiTerlibatKegiatan();
//        $this->count_mitra_terlibat = Mitra::countMitraTerlibatKegiatan();
    }

    public function render()
    {
        return view('livewire.stats-card');
    }
}
