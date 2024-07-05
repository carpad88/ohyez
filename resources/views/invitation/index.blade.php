<x-layouts.invitation>
    <x-templates.og-tags :$event/>

    <div class="flex justify-center items-center w-screen min-h-screen bg-indigo-950">
        <div
            class="bg-rose-100 min-h-screen w-full overflow-auto sm:min-h-max sm:max-w-sm sm:max-h-[748px] sm:border-[10px] sm:rounded-3xl sm:border-black">
            <x-dynamic-component
                :component="$template"
                :event="$event"
                :invitation="$invitation ?? null"
            />
        </div>
    </div>
</x-layouts.invitation>
