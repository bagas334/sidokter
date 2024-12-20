<?php

namespace App\Http\Livewire;

use App\Models\Kegiatan;
use Livewire\Component;
use Livewire\WithPagination;

class KegiatanTable extends Component
{
    use WithPagination;

    public $search = '';
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $kegiatan = Kegiatan::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('asal_fungsi', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.kegiatan-table', ['kegiatan' => $kegiatan]);
    }
}
