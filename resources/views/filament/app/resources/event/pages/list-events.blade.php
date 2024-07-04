<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($this->table->getRecords() as $record)
            <x-filament::section>
                <div class="flex flex-col gap-y-6 justify-between h-full">
                    <div class="flex justify-between items-end">
                        <div class="text-sm">
                            ID del evento: <span class="font-bold">{{ $record->code }}</span>
                        </div>

                        <x-filament::badge size="sm">
                            {{ $record->plan()->name }}
                        </x-filament::badge>
                    </div>

                    <div class="flex-1 grid grid-cols-7 gap-4 items-start">
                        <div class="col-span-3 border rounded-lg">
                            <img
                                src="{{ $record->template->coverUrl() ?? 'https://placehold.co/300x400'}}"
                                alt="template cover"
                                class="rounded-lg w-full transition-transform group-hover:scale-90"
                            >
                        </div>
                        <div class="col-span-4">
                            <div class="mb-6">
                                <div class="font-extralight">
                                    {{ $record->date?->format('d / M / Y') }}
                                </div>
                                <h2 class="text-2xl font-bold text-indigo-800">
                                    {{ $record->title }}
                                </h2>
                            </div>

                            <div class="border p-3 rounded-lg mb-4 text-gray-700 dark:text-gray-500">
                                <div
                                    class="flex justify-between font-bold {{ $record->hasFeaturesWithCode('COA') ? 'pb-3 border-b' : ''}}">
                                    <div>Invitaciones</div>
                                    <div>{{ $record->invitations->count() }}</div>
                                </div>

                                @if($record->hasFeaturesWithCode('COA'))
                                    <div class="text-gray-500 dark:text-gray-400 text-sm font-medium space-y-2 pt-3">
                                        <div class="flex justify-between">
                                            <p>Pendientes</p>
                                            <p>{{ $record->invitationsCount(App\Enums\InvitationStatus::Pending) }}</p>
                                        </div>

                                        <div class="flex justify-between">
                                            <p>Confirmadas</p>
                                            <p>{{ $record->invitationsCount(App\Enums\InvitationStatus::Confirmed) }}</p>
                                        </div>

                                        <div class="flex justify-between">
                                            <p>Declinadas</p>
                                            <p>{{ $record->invitationsCount(App\Enums\InvitationStatus::Declined) }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="border p-3 rounded-lg text-sm">
                                <div
                                    class="flex justify-between font-bold {{ $record->hasFeaturesWithCode('COA') ? 'pb-3 border-b' : ''}}">
                                    <div>Personas invitadas</div>
                                    <div>{{ $record->guests->count() }}</div>
                                </div>

                                @if($record->hasFeaturesWithCode('COA'))
                                    <div class="text-gray-500 dark:text-gray-400 font-medium pt-3">
                                        <div class="flex justify-between">
                                            <p>Personas confirmadas</p>
                                            <p>{{ $record->guestsConfirmed() }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="px-3 flex justify-between sm:hidden">
                            @can('view_event')
                                <x-filament::icon-button
                                    icon="phosphor-arrow-square-out-duotone"
                                    size="xl"
                                    label="Previsualizar"
                                    tag="a"
                                    class="border border-indigo-500"
                                    href="{{ route('event.preview', ['event' => $record->id ]) }}"
                                />
                            @endcan

                            @can('update_event')
                                <x-filament::icon-button
                                    icon="phosphor-pencil-duotone"
                                    size="xl"
                                    label="Editar"
                                    tag="a"
                                    class="border border-indigo-500"
                                    href="{{ App\Filament\App\Resources\EventResource::getUrl('edit', ['record' => $record]) }}"
                                />
                            @endcan

                            @can('view_any_invitation')
                                <x-filament::icon-button
                                    icon="phosphor-envelope-open-duotone"
                                    size="xl"
                                    label="Invitaciones"
                                    tag="a"
                                    class="border border-indigo-500"
                                    href="{{ App\Filament\App\Resources\EventResource::getUrl('invitations', ['record' => $record]) }}"
                                />
                            @endcan
                        </div>

                        <div class="hidden sm:flex gap-x-4">
                            @can('view_event')
                                <x-filament::button
                                    outlined="true"
                                    href="{{ route('event.preview', ['event' => $record->id ]) }}"
                                    icon="phosphor-arrow-square-out-duotone"
                                    tag="a"
                                    color="gray"
                                    target="_blank"
                                >
                                    Previsualizar
                                </x-filament::button>
                            @endcan

                            @can('update_event')
                                <x-filament::button
                                    outlined="true"
                                    href="{{ App\Filament\App\Resources\EventResource::getUrl('edit', ['record' => $record]) }}"
                                    icon="phosphor-pencil-duotone"
                                    tag="a"
                                    color="gray"
                                >
                                    Editar
                                </x-filament::button>
                            @endcan

                            @can('view_any_invitation')
                                <x-filament::button
                                    outlined="true"
                                    href="{{ App\Filament\App\Resources\EventResource::getUrl('invitations', ['record' => $record]) }}"
                                    icon="phosphor-envelope-open-duotone"
                                    tag="a"
                                    color="gray"
                                >
                                    Invitaciones
                                </x-filament::button>
                            @endcan
                        </div>
                    </div>
                </div>
            </x-filament::section>
        @endforeach
    </div>

    <x-filament-actions::modals/>
</x-filament-panels::page>
