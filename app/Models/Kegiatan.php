<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;
    protected $fillable = [
        'nama',
        'asal_fungsi',
        'tanggal_mulai',
        'tanggal_akhir',
        'target',
        'terlaksana',
        'satuan',
        'harga_satuan',
        'catatan',
    ];


    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_akhir' => 'date',
        'harga_satuan' => 'integer',
    ];

    public static function getKegiatanById($id)
    {
        return self::find($id);
    }

    public function penugasanPegawai()
    {
        return $this->hasMany(PenugasanPegawai::class, 'kegiatan');
    }

    public function penugasanMitra()
    {
        return $this->hasMany(PenugasanMitra::class, 'kegiatan');
    }

    public function sampel()
    {
        return $this->hasMany(Sampel::class, 'kegiatan_id');
    }

    public static function getCountOfKegiatanGroupedByDayThisMonth()
    {
        return self::whereMonth('tanggal_mulai', Carbon::now()->month)
            ->whereYear('tanggal_mulai', Carbon::now()->year)
            ->selectRaw('DAY(tanggal_mulai) as day, COUNT(*) as count')
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get()
            ->keyBy('day');;
    }

    public static function getCountOfKegiatanGroupedByWeekThisQuarter()
    {
        $startOfQuarter = Carbon::now()->firstOfQuarter()->startOfDay();
        $endOfQuarter = Carbon::now()->lastOfQuarter()->endOfDay();

        $counts = self::whereBetween('tanggal_mulai', [$startOfQuarter, $endOfQuarter])
            ->selectRaw('WEEK(tanggal_mulai, 1) as week, COUNT(*) as count')
            ->groupBy('week')
            ->orderBy('week', 'asc')
            ->get()
            ->keyBy('week');

        return $counts;
    }



    public static function countActiveKegiatan()
    {
        $today = Carbon::today();

        return self::where('tanggal_mulai', '<', $today)
            ->where('tanggal_akhir', '>', $today)
            ->count();
    }

    public static function countByAsalFungsi()
    {
        return self::select('asal_fungsi')
            ->selectRaw('count(*) as total')
            ->groupBy('asal_fungsi')
            ->get()
            ->keyBy('asal_fungsi')
            ->map->total;
    }

    public static function countByMonth()
    {
        $startDate = Carbon::now()->startOfYear();
        $endDate = Carbon::now()->endOfYear();

        $data = self::select(DB::raw('MONTH(tanggal_mulai) as month'), DB::raw('YEAR(tanggal_mulai) as year'), DB::raw('count(*) as total'))
            ->whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->groupBy(DB::raw('YEAR(tanggal_mulai)'), DB::raw('MONTH(tanggal_mulai)'))
            ->orderBy(DB::raw('YEAR(tanggal_mulai)'))
            ->orderBy(DB::raw('MONTH(tanggal_mulai)'))
            ->get();

        $monthlyTotals = $data->groupBy('month')->map(function ($items) {
            return $items->sum('total');
        });

        $monthNames = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec'
        ];

        $currentYear = Carbon::now()->year;
        $months = collect(range(1, 12))->map(function ($month) use ($monthlyTotals, $monthNames, $currentYear) {
            return [
                'month' => $monthNames[$month] ?? '???',
                'total' => $monthlyTotals->get($month, 0)
            ];
        });

        $sortedMonths = $months->sortBy(function ($item) use ($monthNames) {
            $monthNumber = array_search($item['month'], $monthNames);
            return sprintf('%02d', $monthNumber);
        });

        $sortedMonths = $sortedMonths->values();

        return [
            'label' => $sortedMonths->pluck('month')->toArray(),
            'jumlah' => $sortedMonths->pluck('total')->toArray(),
        ];
    }
}
