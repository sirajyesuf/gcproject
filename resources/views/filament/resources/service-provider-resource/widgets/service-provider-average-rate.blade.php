<x-filament::widget>
    <x-filament::card>
        <div class="text-center">
            <p class="text-2xl font-bold  text-gray-800">Average Rate</p>
            {{ $this->getAverageRate()}}  star

        </div>
    </x-filament::card>
</x-filament::widget>