<x-filament::modal
    id="qr-scanner"
    :close-by-clicking-away="false"
    @close-modal="$dispatch('resetInvitation')"
>
    <x-slot name="heading">
        Check In de Invitados
    </x-slot>

    <x-slot name="footerActions">
        <x-filament::button
            outlined
            size="sm"
            icon="heroicon-o-arrow-left"
            @click="$dispatch('close-modal', { id: 'qr-scanner' })"
        >
            Cerrar
        </x-filament::button>
    </x-slot>

    <div
        x-data="{
                qrScanner: null,
                startScanner() {
                    const options = { maxScansPerSecond: 1, highlightScanRegion: true }
                    this.qrScanner = new QrScanner($refs.qrVideo, result => this.validateQRCode(result), options);
                    this.qrScanner.start();
                },
                stopScanner() {
                    if (this.qrScanner) {
                        this.qrScanner.stop();
                    }
                },
                validateQRCode(result) {
                    $wire.validateQRCode(result.data);
                    this.stopScanner();
                }
            }"
        @close-modal.window="stopScanner"
    >
        @if(!$invitation)
            <div class="flex flex-col items-center">
                <x-filament::button
                    size="xl"
                    @click="startScanner"
                    icon="heroicon-o-qr-code"
                    class="mb-4"
                >
                    Escanear QR
                </x-filament::button>

                <video x-ref="qrVideo" class="w-full"></video>
            </div>
        @endif

        @if($invitation)
            <div class="text-center">
                <h2 class="text-5xl font-extralight">MESA {{ $invitation->table }}</h2>

                <div class="text-2xl font-bold mt-8 text-indigo-500">
                    {{ $invitation?->family }}
                </div>

                <div class="font-medium mb-6 text-lg text-gray-600">
                    {{ count($invitation?->guests) }} personas
                </div>

                <ul class="flex justify-center gap-4 flex-wrap mb-12">
                    @foreach($invitation->guests as $guest)
                        <li class="text-sm border border-indigo-300 px-1 py-0.5 rounded-md bg-indigo-100">
                            {{ $guest['name'] }}
                        </li>
                    @endforeach
                </ul>

                <x-filament::button wire:click="checkIn" class="w-full">
                    Confirmar
                </x-filament::button>
            </div>
        @endif
    </div>
</x-filament::modal>
