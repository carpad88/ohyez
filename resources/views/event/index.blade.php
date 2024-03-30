<x-layouts.invitation>
    <div class="flex justify-center items-center w-screen h-screen bg-indigo-950">
        <div
            class="h-screen w-full sm:max-w-sm sm:max-h-[768px] sm:overflow-auto sm:border-[10px] sm:rounded-3xl sm:border-black">
            <x-dynamic-component
                :component="$template"
                :event="$event"
                :invitation="$invitation"
            />
        </div>
    </div>
</x-layouts.invitation>
