<section class="p-10">
    @php
        $locale = 'es_ES';
        $dateFormatter = new IntlDateFormatter($locale, IntlDateFormatter::LONG, IntlDateFormatter::NONE);
    @endphp

    @if($status == 'pending')
        <h2>Confirmación <br>de asistencia</h2>

        @if(now() < $invitation->event->date->subWeek())
            <p class="text-lg leading-tight">
                Para mi es muy importante contar con tu presencia y quiero que formes parte de este gran
                día.
            </p>

            <button wire:click="mountAction('confirmAttendance')" class="button mb-8">
                <x-phosphor-user-check-duotone class="size-5"/>
                <span>Confirmar</span>
            </button>

            <p class="my-4 text-base leading-tight">
                Por favor, confirma tu asistencia antes del
                <b>{{ $dateFormatter->format($invitation->event->date->subWeek()) }}</b>. Al no responder
                para antes de esa fecha lo tomaré como un NO.
            </p>
        @else
            <p class="text-lg leading-tight px-4">
                La fecha límite para confirmar tu asistencia ya pasó, pero si aun quieres confirmar puedes comunicarte
                conmigo.
            </p>
        @endif
    @endif

    @if($status == 'confirmed')
        <h2>Asistencia confirmada</h2>

        <h3 class="font-bold mb-8 text-lg">¡Gracias por confirmar tu asistencia!</h3>

        @if(now() < $invitation->event->date->subDays(3))
            <div class="space-y-2">
                <p>Los boletos estarán disponibles el<br></p>
                <p class="font-bold">{{ $dateFormatter->format($invitation->event->date->subDays(3)) }}</p>
                <p>No olvides descargarlos y presentarlos en la entrada el día<br>del evento.</p>
            </div>
        @else
            <p>No olvides descargar tus boletos y presentarlos en la entrada el día del evento.</p>

            <button wire:click="mountAction('showQrCode')" class="button"
                @disabled(!$this->invitation->allConfirmedGuestsHaveTableAssigned())
            >
                <x-phosphor-qr-code-duotone class="size-5"/>
                <span>Ver boletos</span>
            </button>
        @endif
    @endif

    @if($status == 'declined')
        <h2 class="font-bold text-3xl leading-none">¡Lamento que no puedas asistir!</h2>
        <p class="mt-4">Si tienes alguna pregunta o necesitas más información, no dudes en contactarme.</p>
    @endif

    <x-filament-actions::modals/>
</section>
