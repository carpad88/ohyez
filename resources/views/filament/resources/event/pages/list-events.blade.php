<x-filament-panels::page>
    @role('super_admin')
    {{ $this->table }}
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($this->table->getRecords() as $record)
                <x-filament::section>
                    <div class="text-xl font-extralight text-indigo-500">
                        {{ $record->date->format('d/m/Y') }}
                    </div>
                    <h2 class="text-3xl font-bold mb-8 text-indigo-800">
                        {{ $record->title }}
                    </h2>

                    @can('view_any_invitation')
                        <h3 class="text-2xl font-bold text-gray-500 tracking-wide mb-2">
                            {{ $record->invitations->count() }} Invitaciones
                        </h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <div class="border border-gray-100 p-4 rounded-lg flex items-end shadow-sm">
                                <p class="text-3xl font-semibold text-gray-950 dark:text-white leading-none">
                                    {{ $record->invitationsCount(App\Enums\InvitationStatus::Pending) }}
                                </p>
                                <p class="ml-1.5 text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Pendientes
                                </p>
                            </div>

                            <div class="border border-gray-100 p-4 rounded-lg flex items-end shadow-sm">
                                <p class="text-3xl font-semibold text-gray-950 dark:text-white leading-none">
                                    {{ $record->invitationsCount(App\Enums\InvitationStatus::Confirmed) }}
                                </p>
                                <p class="ml-1.5 text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Confirmadas
                                </p>
                            </div>

                            <div class="border border-gray-100 p-4 rounded-lg flex items-end shadow-sm">
                                <p class="text-3xl font-semibold text-gray-950 dark:text-white leading-none">
                                    {{ $record->invitationsCount(App\Enums\InvitationStatus::Declined) }}
                                </p>
                                <p class="ml-1.5 text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Declinadas
                                </p>
                            </div>
                        </div>
                    @endcan

                    <div class="grid sm:grid-cols-2 text-gray-500 mt-4 mb-8 text-lg">
                        <div>
                            <p><b>{{ $record->guestsCount() }}</b> Personas Invitadas</p>
                        </div>

                        <div>
                            <p><b>{{ $record->guestsConfirmed() }}</b> Personas confirmadas</p>
                        </div>
                    </div>

                    <div class="mt-6 px-3 flex justify-between sm:hidden">
                        @can('view_user')
                            <x-filament::icon-button
                                icon="heroicon-c-arrow-top-right-on-square"
                                size="xl"
                                label="Previsualizar"
                                tag="a"
                                class="border border-indigo-500"
                                href="{{ route('event.preview', ['event' => $record->id ]) }}"
                            />
                        @endcan

                        @can('update_event')
                            <x-filament::icon-button
                                icon="heroicon-c-pencil"
                                size="xl"
                                label="Editar"
                                tag="a"
                                class="border border-indigo-500"
                                href="{{ App\Filament\Resources\EventResource::getUrl('edit', ['record' => $record]) }}"
                            />
                        @endcan

                        @can('view_any_invitation')
                            <x-filament::icon-button
                                icon="heroicon-c-rectangle-stack"
                                size="xl"
                                label="Invitaciones"
                                tag="a"
                                class="border border-indigo-500"
                                href="{{ App\Filament\Resources\EventResource::getUrl('edit', ['record' => $record]) }}"
                            />
                        @endcan

                        @can('update_invitation')
                            <x-filament::icon-button
                                icon="heroicon-c-qr-code"
                                size="xl"
                                label="Previsualizar"
                                tag="a"
                                class="border border-indigo-500"
                                href="{{ App\Filament\Resources\EventResource::getUrl('edit', ['record' => $record]) }}"
                            />
                        @endcan
                    </div>

                    <div class="mt-6 hidden sm:flex gap-5">
                        @can('view_event')
                            <x-filament::button
                                outlined="true"
                                href="{{ route('event.preview', ['event' => $record->id ]) }}"
                                icon="heroicon-c-arrow-top-right-on-square"
                                tag="a"
                                target="_blank"
                            >
                                Previsualizar
                            </x-filament::button>
                        @endcan

                        @can('update_event')
                            <x-filament::button
                                outlined="true"
                                href="{{ App\Filament\Resources\EventResource::getUrl('edit', ['record' => $record]) }}"
                                icon="heroicon-c-pencil"
                                tag="a"
                            >
                                Editar
                            </x-filament::button>
                        @endcan

                        @can('view_any_invitation')
                            <x-filament::button
                                outlined="true"
                                href="{{ App\Filament\Resources\EventResource::getUrl('invitations', ['record' => $record]) }}"
                                icon="heroicon-c-rectangle-stack"
                                tag="a"
                            >
                                Invitaciones
                            </x-filament::button>
                        @endcan

                        @can('update_invitation')
                            <x-filament::button
                                outlined="true"
                                href="{{ App\Filament\Resources\EventResource::getUrl('attendance', ['record' => $record]) }}"
                                icon="heroicon-c-qr-code"
                                tag="a"
                            >
                                Asistencia
                            </x-filament::button>
                        @endcan
                    </div>
                </x-filament::section>
            @endforeach
        </div>
        @endrole
</x-filament-panels::page>
