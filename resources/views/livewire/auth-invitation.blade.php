<div class="min-h-screen grid grid-cols-[1fr_auto_1fr] grid-rows-[1fr_5rem] p-8 bg-indigo-950">
    <div class="flex flex-col items-center justify-center col-start-2">
        <div class="w-60 h-60 bg-amber-400 rounded-full"></div>

        <form wire:submit="authenticate" class="flex flex-col items-center py-16 max-w-sm">

            <h2 class="text-xl text-gray-300 font-medium mb-6">
                Cógido de acceso
            </h2>

            {{ $this->form }}

            <button type="submit"
                    class="bg-yellow-500 text-indigo-950 mt-8  px-8 py-3 rounded-xl ">
                Ver invitación
            </button>
        </form>
    </div>

    <div class="flex items-center justify-center text-gray-500 space-x-1 font-serif text-xs col-start-2">
       <span>By</span> <x-logo class="w-10 h-10 " /> <span>© All rights reserved {{ now()->year }}</span>
    </div>

    <x-filament-actions::modals/>
</div>
