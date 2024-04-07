<x-filament::modal id="qr-scanner" :close-by-clicking-away="false">
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
            <h2>Mesa {{ $invitation->table }}</h2>
            <div>
                Familia: {{ $invitation?->family }}
            </div>

            <div>
                Personas: {{ count($invitation?->guests) }}
            </div>

            <ul>
                @foreach($invitation->guests as $guest)
                    <li>{{ $guest['name'] }}</li>
                @endforeach
            </ul>

            <x-filament::button wire:click="checkIn">
                Confirmar
            </x-filament::button>
        @endif
    </div>
</x-filament::modal>
