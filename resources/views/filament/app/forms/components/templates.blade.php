<div class="grid grid-cols-4 gap-4">
    @foreach($templates as $template)
        <label class="template-card cursor-pointer">
            <input type="radio" wire:model="{{ $getStatePath() }}" value="{{ $template->id }}" class="hidden">
            <div class="relative rounded-xl shadow group bg-yellow-500">
                <h2 class="font-bold z-10 absolute top-0 left-0 w-full p-4 group-hover:hidden transition-all">{{ $template->name }}</h2>
                <img
                    src="https://placehold.co/300x400"
                    alt="{{ $template->name }}"
                    class="rounded-lg w-full h-full transition-transform group-hover:scale-90"
                >
            </div>
        </label>
    @endforeach
</div>
