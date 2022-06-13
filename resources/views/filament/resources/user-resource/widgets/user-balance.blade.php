<x-filament::widget>
    <x-filament::card>
        <div class="text-center">
            <p class="text-2xl font-bold text-emerald-600">Balance</p>
            <span class="text-red-900">{{ $this->getBalance()}}</span> ETB
        </div>
    </x-filament::card>
</x-filament::widget>