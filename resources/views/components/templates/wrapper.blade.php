<div {{ $attributes->merge(['class'=>'flex justify-center items-center w-screen min-h-screen']) }}>
    <div
        class="min-h-screen w-full overflow-auto sm:min-h-max sm:max-w-sm sm:max-h-[748px] sm:border-[10px] sm:rounded-3xl sm:border-black">
        {{ $slot }}
    </div>
</div>
