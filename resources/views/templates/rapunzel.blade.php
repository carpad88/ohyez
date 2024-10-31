<x-layouts.invitation :css="$event->template->view" :date="$event->date->format('Y-m-d').'T'.$event->time">
    <x-templates.og-tags :$event/>

    @php
        $content = fluent($event->content);
        $templateFolder = 'templates/'.$event->template->id;
    @endphp

    <x-templates.wrapper class="bg-[#7c4985]">
        <main>
            @if($event->hasFeaturesWithCode('MUS') && $event->music)
                <x-templates.music-player song="{{$event->music}}"/>
            @endif

            <!--<editor-fold desc="Cover">-->
            <section class="min-h-screen sm:min-h-[728px] flex flex-col justify-center items-center">
                <img src="{{ Storage::url("$templateFolder/cover-tl.webp") }}" alt="cover-top-left"
                     class="w-1/4 absolute top-0 left-0">
                <img src="{{ Storage::url("$templateFolder/cover-tr.webp") }}" alt="cover-top-right"
                     class="w-full absolute top-0">

                @if($event->logo)
                    <div class="w-2/3 overflow-hidden mt-20 pr-4">
                        <img src="{{ Storage::disk('events')->url($event->logo) }}" alt="Logo Image">
                    </div>
                @else
                    <h1 class="text-5xl font-bold z-10">{{ $content->get('cover.fifteen') }}</h1>
                @endif

                <p class="mt-6 z-10 text-xl font-mono text-[#e9ab1c]">{{ $event->date->format('d • m • Y') }}</p>
                <img src="{{ Storage::url("$templateFolder/sun.svg") }}" alt="sun"
                     class="size-10 mx-auto mt-2 animate-spin-slow">
                <img src="{{ Storage::url("$templateFolder/cover-b.webp") }}" alt="cover-bottom"
                     class="w-full absolute bottom-0">
            </section>
            <!--</editor-fold>-->

            <!--<editor-fold desc="Counter">-->
            @if($event->counter)
                <section class="-translate-y-7">
                    <img src="{{ Storage::url("$templateFolder/counter.webp") }}" alt="counter-top"
                         class="w-full">

                    <h2 class="mt-6">Faltan</h2>

                    <div
                        id="counter"
                        class="p-4 flex justify-evenly"
                        x-data="counter"
                        x-on:unload.window="if (intervalId !== null) clearInterval(intervalId)"
                    >
                        <div>
                            <h3 x-text="timeLeft.days"></h3>
                            <p>Días</p>
                        </div>
                        <div>
                            <img src="{{ Storage::url("$templateFolder/sun.svg") }}" alt="sun"
                                 class="animate-spin-slow">
                            <p>•</p>
                        </div>
                        <div>
                            <h3 x-text="timeLeft.hours"></h3>
                            <p>Horas</p>
                        </div>
                        <div>
                            <img src="{{ Storage::url("$templateFolder/sun.svg") }}" alt="sun"
                                 class="animate-spin-slow">
                            <p>•</p>
                        </div>
                        <div>
                            <h3 x-text="timeLeft.minutes"></h3>
                            <p>Min</p>
                        </div>
                        <div>
                            <img src="{{ Storage::url("$templateFolder/sun.svg") }}" alt="sun"
                                 class="animate-spin-slow">
                            <p>•</p>
                        </div>
                        <div>
                            <h3 x-text="timeLeft.seconds"></h3>
                            <p>Seg</p>
                        </div>
                    </div>

                    <img src="{{ Storage::url("$templateFolder/counter-b.webp") }}" alt="counter-bottom"
                         class="mx-auto w-2/3 mt-8">
                </section>
            @endif
            <!--</editor-fold>-->

            <!--<editor-fold desc="Welcome">-->
            @if($content->get('welcome.visible'))
                <section class="h-[450px]">
                    <div>
                        <p class="mx-auto w-3/4 px-4">{{ $content->get('welcome.message') }}</p>
                        <img src="{{ Storage::url("$templateFolder/sun-outlined.svg") }}" alt="sun"
                             class="size-14 mx-auto mt-4">
                    </div>

                    <img src="{{ Storage::url("$templateFolder/message.webp") }}" alt="message-bottom"
                         class="w-full absolute bottom-0">
                </section>
            @endif
            <!--</editor-fold>-->

            <!--<editor-fold desc="Mentions">-->
            <section class="py-12 h-[500px]">
                @if($event->event_type === \App\Enums\EventType::XV)
                    @if($content->get('mentions.parents.fifteen.visible'))
                        <div class="mention">
                            <h3>Mis padres</h3>
                            <p>{{ $content->get('mentions.parents.fifteen.femaleName') }}</p>
                            <p>{{ $content->get('mentions.parents.fifteen.maleName') }}</p>
                        </div>
                    @endif
                @endif

                @if($content->get('mentions.special.visible'))
                    <div class="space-y-8 mt-8">
                        @foreach($content->get('mentions.special.relatives') as $mention)
                            <div class="mention">
                                <h3>{{ $mention['relation'] }}</h3>
                                <p>{{ $mention['her'] }}</p>
                                <p>{{ $mention['him'] }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                <img src="{{ Storage::url("$templateFolder/mentions.webp") }}" alt="mentions"
                     class="w-full absolute bottom-0">
            </section>
            <!--</editor-fold>-->

            <!--<editor-fold desc="Special Mentions">-->
            <section class="pt-24 pb-32 bg-[#e5deec]">
                <img src="{{ Storage::url("$templateFolder/counter-b.webp") }}" alt="special-mentions"
                     class="w-2/3 absolute top-0 mx-auto inset-x-0 -translate-y-12">

                <p>Quiero agradecerle de todo corazón a</p>

                <h2 class="text-xl my-6">Leonel Anaya y Teresa Mejía</h2>

                <p class="px-8">
                    mis amados abuelos, por sus palabras de aliento, sus gestos de amor, su cariño y
                    el amor incondicional que me han brindado a lo largo de mi vida.
                </p>
            </section>
            <!--</editor-fold>-->

            <!--<editor-fold desc="Places">-->
            <section class="h-[740px]">
                <div class="-translate-y-20">
                    <img src="{{ Storage::url("$templateFolder/mentions-b.webp") }}" alt="mentions-b"
                         class="w-full">

                    <div id="places" class="px-10">
                        @if($content->get('locations.ceremony.visible'))
                            <div class="text-right">
                                <h2>Ceremonia</h2>
                                <h3>{{ $content->get('locations.ceremony.name') }}</h3>
                                <p>{{ $content->get('locations.ceremony.address') }}</p>
                                @php
                                    $ceremonyLink = urlencode($content->get('locations.ceremony.name').'+'.$content->get('locations.ceremony.address'));
                                @endphp

                                <a href="{{ 'https://www.google.com/maps?q='.$ceremonyLink }}"
                                   target="_blank"
                                >
                                    <x-phosphor-map-trifold class="size-5"/>
                                    <span>Como llegar</span>
                                </a>
                            </div>
                        @endif

                        <div class="mt-24 text-left">
                            <h2>Recepción</h2>
                            <h3>{{ $content->get('locations.reception.name') }}</h3>
                            <p>{{ $content->get('locations.reception.address') }}</p>
                            @php
                                $locationLink = urlencode($content->get('locations.reception.name').'+'.$content->get('locations.reception.address'));
                            @endphp

                            <a href="{{ 'https://www.google.com/maps?q='.$locationLink}}"
                               target="_blank"
                            >
                                <x-phosphor-map-trifold class="size-5 inline-block"/>
                                <span>Como llegar</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <!--</editor-fold>-->

            <img src="{{ Storage::url("$templateFolder/divider-1.webp") }}" alt="divider"
                 class="w-full">

            <!--<editor-fold desc="Program">-->
            @if($content->get('program.visible'))
                <section class="py-8">
                    <h2>Programa</h2>
                    @php
                        $icons = ['program-1', 'program-2', 'program-3', 'program-4', 'program-5', 'program-6']
                    @endphp
                    <ul class="w-[268px] mx-auto">
                        @foreach($content->get('program.items') as $i => $item)
                            <li class="h-28 flex {{$loop->even ? 'flex-row-reverse' : ''}} justify-between items-center mb-0">
                                <div class="flex-1 px-6 {{$loop->even ? 'text-left' : 'text-right'}}">
                                    <h3 class="text-lg leading-none">{{ $item['name'] }}</h3>
                                    <p class="font-bold">{{ $item['time'] }}</p>
                                </div>
                                <div class="relative size-28 ">
                                    <div
                                        class="absolute size-32 rounded-full border-[2.5px] border-[#a5a77f] -left-2 -top-2">
                                        <img
                                            src="{{ Storage::url("$templateFolder/{$icons[$loop->index]}.svg") }}"
                                            alt="icon"
                                            class="w-full h-full">
                                    </div>
                                </div>

                            </li>
                            @if(!$loop->last)
                                <div class="h-2 relative {{$loop->even ? 'scale-x-[-1]' : ''}}">
                                    <img src="{{ Storage::url("$templateFolder/program-divider.webp") }}"
                                         alt="divider"
                                         class="mx-auto w-5/6 inset-y-0 -translate-y-[14px] rotate-[2deg]">
                                </div>
                            @endif
                        @endforeach
                    </ul>
                </section>
            @endif
            <!--</editor-fold>-->

            <img src="{{ Storage::url("$templateFolder/divider-2.webp") }}" alt="divider"
                 class="w-full my-6 px-4">

            <!--<editor-fold desc="Dress code">-->
            @if($content->get('dressCode.visible'))
                <section>
                    <h2 class="text-2xl leading-none">Código de vestimenta</h2>

                    <div>
                        <h3 class="text-5xl font-light">{{ $content->get('dressCode.code') }}</h3>
                        <img src="{{ Storage::url("$templateFolder/dresscode.webp") }}" alt="dress-code"
                             class="mx-auto w-1/2 my-6">
                    </div>

                    <div class="relative h-[500px]">
                        <p class="mt-12 pl-24 pr-16">
                            Te solicito amablemente que evites vestir de color lila, azul cielo o rosa pastel ya que
                            esos colores están reservado para hacerme lucir en ese día tan especial.
                        </p>

                        <img src="{{ Storage::url("$templateFolder/dresscode-b.webp") }}" alt="dress-code"
                             class="absolute bottom-0 w-full my-6">
                    </div>
                </section>
            @endif
            <!--</editor-fold>-->

            <!--<editor-fold desc="Gallery">-->
            @if($content->get('gallery.visible'))
                <section>
                    <h2>Galería</h2>
                    <div class="grid gap-4 px-6">
                        @if(count($content->get('gallery.items')) > 0)
                            @foreach($content->get('gallery.items') as $image)
                                <img src="{{ Storage::disk('events')->url($image) }}"
                                     alt="Gallery Image"
                                     class="w-full h-full object-cover border border-gray-400"
                                >
                            @endforeach
                        @else
                            @foreach([1, 2, 3] as $item)
                                <img src="{{ 'https://placehold.co/300'}}"
                                     alt="Gallery Image"
                                     class="w-full h-full object-cover border border-gray-400"
                                >
                            @endforeach
                        @endif

                    </div>
                </section>
            @endif
            <!--</editor-fold>-->

            <img src="{{ Storage::url($templateFolder.'/divider-1.webp') }}" alt="divider"
                 class="w-full my-6 mx-auto scale-x-[-1]">

            <!--<editor-fold desc="Gifts">-->
            @php
                $tablesVisible = $content->get('presents.tables.visible');
                $envelopeVisible = $content->get('presents.envelope');
            @endphp

            @if($tablesVisible || $envelopeVisible)
                <section class="text-left mt-16">
                    <div class="px-8 space-y-12">
                        @if($content->get('presents.tables.visible'))
                            <div>
                                <h2 class="mb-0">Mesa de regalos</h2>
                                @foreach($content->get('presents.tables.items') as $item)
                                    <a href="{{ $item['url'] }}"
                                       target="_blank"
                                    >
                                        <x-phosphor-gift class="size-5"/>
                                        <span>{{ $item['name'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        @if($content->get('presents.envelope'))
                            <div class="">
                                <h2>Lluvia de sobres</h2>
                                <p class="font-bold my-2 text-xl">¡Tu compañía es el regalo más especial para mí!</p>
                                <p> Pero si deseas obsequiarme algo más, el día del evento habrá sobres
                                    <x-phosphor-envelope-duotone class="size-5 inline"/>
                                    y un buzón
                                    <x-phosphor-mailbox-duotone class="size-5 inline"/>
                                    para depositarlos.
                                </p>

                            </div>
                        @endif
                    </div>

                    <img src="{{ Storage::url("$templateFolder/gifts.webp") }}" alt="gifts"
                         class=" w-full">
                </section>
            @endif
            <!--</editor-fold>-->

            <!--<editor-fold desc="RSVP">-->
            @if($invitation)
                <livewire:invitation.rsvp :invitation="$invitation"/>
            @else
                <section class="py-24 px-8">
                    <h2>Confirmación <br>de asistencia</h2>

                    <p class="text-lg leading-tight">
                        Para mi es muy importante contar con tu presencia y quiero que formes parte de este gran
                        día.
                    </p>

                    <p class="my-4 text-lg leading-tight">
                        Por favor, confirma tu asistencia cuanto antes.
                    </p>

                    <button class="button">
                        <x-phosphor-user-check-duotone class="size-5"/>
                        <span>Confirmar</span>
                    </button>
                </section>
            @endif
            <!--</editor-fold>-->

            <!--<editor-fold desc="Socials">-->
            @if($content->get('socials.visible'))
                <section>
                    <h2>Socials</h2>
                    <div class="flex flex-col items-center space-y-4">
                        @php
                            $socials = [
                                'facebook' => 'i-entypo-social-facebook',
                                'instagram' => 'i-entypo-social-instagram',
                                'twitter' => 'i-entypo-social-twitter',
                                'whatsapp' => 'i-entypo-social-whatsapp',
                            ];
                        @endphp

                        @foreach($content->get('socials.items') as $item)
                            <a
                                href="{{ $item['url'] }}"
                                class="flex items-center space-x-2"
                                target="_blank">
                                <i class="{{ $socials[$item['red']] }}"></i>
                                <spa>@
                                    <nbsp/>{{ $item['hashtag'] }}</spa>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
            <!--</editor-fold>-->

            <!--<editor-fold desc="Recommendations">-->
            @if($content->get('recommendations.visible') )
                <section class="py-12">
                    <h2>Recomendaciones</h2>

                    @foreach($content->get('recommendations.items') as $recommendation)
                        <div>
                            <h3 class="font-bold">{{ $recommendation['name'] }}</h3>
                            <p>{{ $recommendation['place'] }}</p>
                            <p>{{ $recommendation['address'] }}</p>
                            <button type="button" class="border border-black p-3 mt-4">Como llegar</button>
                        </div>
                    @endforeach
                </section>
            @endif
            <!--</editor-fold>-->

            <!--<editor-fold desc="Faqs">-->
            @if($content->get('faqs.visible') )
                <section class="py-12">
                    <h2>Preguntas frecuentes </h2>

                    @foreach($content->get('faqs.items') as $faq)
                        <div>
                            <p class="italic">{{ $faq['question'] }}</p>
                            <p class="font-medium">{{ $faq['answer'] }}</p>
                        </div>
                    @endforeach
                </section>
            @endif
            <!--</editor-fold>-->

            <img src="{{ Storage::url("$templateFolder/end.webp") }}" alt="end"
                 class="w-full">
        </main>
    </x-templates.wrapper>
</x-layouts.invitation>
