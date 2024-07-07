@props(['song'])

<div x-data="{ playing: true }" id="player">
    <button x-show="playing" @click="$refs.song.pause(); playing = false;">
        <x-phosphor-pause-duotone class="size-6"/>
    </button>

    <button x-show="!playing" @click="$refs.song.play(); playing = true;">
        <x-phosphor-play-duotone class="size-6"/>
    </button>

    <audio x-ref="song" autoplay>
        <source src="{{ Storage::disk('s3-events')->url($song) }}" type="audio/mpeg"/>
    </audio>
</div>
