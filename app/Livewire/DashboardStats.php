<?php

namespace App\Livewire;

use App\Models\Kegiatan;
use Carbon\Carbon;
use Livewire\Component;

class DashboardStats extends Component
{
    public $selected_period = 'qoq';
    public $count_kegiatan;
    public $average_beban_organik;
    public $count_organik_terlibat;
    public $count_mitra_terlibat;

    public $label_linechart_kegiatan;
    public $value_linechart_kegiatan;

    public $label_columnchart_kegiatan_organik;
    public $value_columnchart_kegiatan_organik;

    public $label_doughnut_kegiatan_fungsi;
    public $value_doughnut_kegiatan_fungsi;

    public function mount()
    {
        $this->updatedSelectedPeriod();
    }

    public function updatedSelectedPeriod()
    {
        switch ($this->selected_period){
            case 'mom' : {
                $this->updateStatsMonthOnMonth();
                break;
            }
            case 'qoq' : {
                $this->updateStatsQuarterOnQuarter();
                break;
            }
            case 'ytd' :
            {
                $this->updateStatsYearToDate();
                break;
            }
        }
    }

    private function updateStatsMonthOnMonth()
    {
        $daysInMonth = Carbon::now()->daysInMonth;
        $this->label_linechart_kegiatan = range(1, $daysInMonth);
        $kegiatanData = Kegiatan::getCountOfKegiatanGroupedByDayThisMonth();
        $this->value_linechart_kegiatan = array_fill(0, $daysInMonth, 0);

        foreach ($this->label_linechart_kegiatan as $day) {
            if (isset($kegiatanData[$day])) {
                $this->value_linechart_kegiatan[$day - 1] = $kegiatanData[$day]->count;
            }
        }

        $this->label_columnchart_kegiatan_organik = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $this->value_columnchart_kegiatan_organik = [5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60];

        $this->label_doughnut_kegiatan_fungsi = ['Fungsi 1', 'Fungsi 2', 'Fungsi 3', 'Fungsi 4', 'Fungsi 5'];
        $this->value_doughnut_kegiatan_fungsi = [10, 20, 30, 40, 50];

        $this->count_kegiatan = 12;
        $this->average_beban_organik = 3.3;
        $this->count_organik_terlibat = 56;
        $this->count_mitra_terlibat = 13;
    }

    private function updateStatsQuarterOnQuarter()
    {
        $startOfQuarter = Carbon::now()->firstOfQuarter();
        $endOfQuarter = Carbon::now()->lastOfQuarter();

        $firstWeek = $startOfQuarter->week();
        $lastWeek = $endOfQuarter->week();
        $weeksInQuarter = $lastWeek - $firstWeek + 1;
        $this->label_linechart_kegiatan = range($firstWeek, $lastWeek);

        $kegiatanData = Kegiatan::getCountOfKegiatanGroupedByWeekThisQuarter();
        $this->value_linechart_kegiatan = array_fill(0, $weeksInQuarter, 0);
        foreach ($this->label_linechart_kegiatan as $index => $week) {
            if (isset($kegiatanData[$week])) {
                $this->value_linechart_kegiatan[$index] = $kegiatanData[$week]->count;
            }
        }

        $this->label_columnchart_kegiatan_organik = ['Q1', 'Q2', 'Q3', 'Q4'];
        $this->value_columnchart_kegiatan_organik = [50, 100, 150, 200];

        $this->label_doughnut_kegiatan_fungsi = ['Fungsi 1', 'Fungsi 2', 'Fungsi 3', 'Fungsi 4', 'Fungsi 5'];
        $this->value_doughnut_kegiatan_fungsi = [100, 200, 300, 400, 500];

        $this->count_kegiatan = 20;
        $this->average_beban_organik = 3.5;
        $this->count_organik_terlibat = 78;
        $this->count_mitra_terlibat = 21;
    }

    private function updateStatsYearToDate()
    {
        $this->label_linechart_kegiatan = ['2018', '2019', '2020', '2021'];
        $this->value_linechart_kegiatan = [1000, 2000, 3000, 4000];

        $this->label_columnchart_kegiatan_organik = ['2018', '2019', '2020', '2021'];
        $this->value_columnchart_kegiatan_organik = [500, 1000, 1500, 2000];

        $this->label_doughnut_kegiatan_fungsi = ['Fungsi 1', 'Fungsi 2', 'Fungsi 3', 'Fungsi 4', 'Fungsi 5'];
        $this->value_doughnut_kegiatan_fungsi = [1000, 2000, 3000, 4000, 5000];

        $this->count_kegiatan = 80;
        $this->average_beban_organik = 3.7;
        $this->count_organik_terlibat = 120;
        $this->count_mitra_terlibat = 45;
    }

    public function updateStats()
    {
//        if ($this->selected_period == 'mom') {
//            $this->count_kegiatan = 12;
//            $this->average_beban_organik = 3.3;
//            $this->count_organik_terlibat = 56;
//            $this->count_mitra_terlibat = 13;
//        } elseif ($this->selected_period == 'qoq') {
//            $this->count_kegiatan = 20;
//            $this->average_beban_organik = 3.5;
//            $this->count_organik_terlibat = 78;
//            $this->count_mitra_terlibat = 21;
//        } elseif ($this->selected_period == 'ytd') {
//            $this->count_kegiatan = 80;
//            $this->average_beban_organik = 3.7;
//            $this->count_organik_terlibat = 120;
//            $this->count_mitra_terlibat = 45;
//        }

        //        $this->count_kegiatan = Kegiatan::countActiveKegiatan();
//        $this->average_beban_organik = Pegawai::getRerataBebanKerja();
//        $this->count_organik_terlibat = Pegawai::countPegawaiTerlibatKegiatan();
//        $this->count_mitra_terlibat = Mitra::countMitraTerlibatKegiatan();
    }
    public function render()
    {
        return view('livewire.dashboard-stats');
    }
}
