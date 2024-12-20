<div class="pb-2.5 flex flex-row space-x-1">
    <button
        id="bulan-btn"
        class="btn-sm w-20 text-sm font-medium text-white bg-teal-600 border border-teal-600 rounded-lg focus:outline-none transition-colors duration-300"
        onclick="toggleActive('bulan-btn')">
        Bulan
    </button>
    <button
        id="triwulan-btn"
        class="btn-sm w-20 text-sm font-medium text-cyan-950 border border-gray-300 rounded-lg focus:outline-none transition-colors duration-300"
        onclick="toggleActive('triwulan-btn')">
        Triwulan
    </button>
    <button
        id="tahun-btn"
        class="btn-sm w-20 text-sm font-medium text-cyan-950 border border-gray-300 rounded-lg focus:outline-none transition-colors duration-300"
        onclick="toggleActive('tahun-btn')">
        Tahun
    </button>
</div>

<script>
    function toggleActive(activeId) {
        const buttons = document.querySelectorAll('.btn-sm');

        buttons.forEach(button => {
            if (button.id === activeId) {
                button.classList.add('bg-teal-600', 'text-white');
                button.classList.remove('text-cyan-950', 'border-gray-300');
                button.classList.add('border-teal-600');
            } else {
                button.classList.remove('bg-teal-600', 'text-white');
                button.classList.add('text-cyan-950', 'border-gray-300');
                button.classList.remove('border-teal-600');
            }
        });
    }
</script>
