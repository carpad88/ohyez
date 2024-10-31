<x-layouts.invitation :css="$event->template->view">
    <x-templates.og-tags :$event/>

    @php
        $content = fluent($event->content);
    @endphp

    <x-templates.wrapper class="bg-indigo-950">
        <main id="template">
            <!--<editor-fold desc="Cover">-->
            <section>
                @if($event->logo)
                    <div class="mx-auto size-[12rem] overflow-hidden ">
                        <img src="{{ asset("gallery/$event->logo") }}" alt="Logo Image">
                    </div>
                @else
                    @if($event->event_type === \App\Enums\EventType::XV)
                        <h1 class="text-5xl font-bold">{{ $content->get('cover.fifteen') }}</h1>
                    @endif

                    @if($event->event_type === \App\Enums\EventType::Wedding)
                        <h1 class="text-4xl font-bold">
                            {{ $content->get('cover.bride') }} & {{ $content->get('cover.groom') }}
                        </h1>
                    @endif
                @endif

                <p class="mt-8 text-xl font-extralight">{{ $event->date->format('d \d\e M, Y') }}</p>
            </section>
            <!--</editor-fold>-->

            <!--<editor-fold desc="Counter">-->
            @if($event->counter)
                <section>
                    <h2>Counter</h2>
                    @php
                        $date = $event->date->format('Y-m-d').'T'.$event->time;
                    @endphp

                    <div
                        class="grid grid-cols-4 w-full px-4 font-extralight"
                        x-data="{
                            targetDate: new Date('{{ $date }}'),
                            timeLeft: null,
                            intervalId: null,
                            calculateTimeLeft() {
                                const now = new Date();
                                const difference = this.targetDate - now;

                                return {
                                    days: Math.floor(difference / (1000 * 60 * 60 * 24)),
                                    hours: Math.floor((difference / (1000 * 60 * 60)) % 24),
                                    minutes: Math.floor((difference / 1000 / 60) % 60),
                                    seconds: Math.floor((difference / 1000) % 60)
                                };
                            },
                            init() {
                                this.timeLeft = this.calculateTimeLeft();
                                if (this.intervalId !== null) clearInterval(this.intervalId);

                                this.intervalId = setInterval(() => {
                                    this.timeLeft = this.calculateTimeLeft();
                                }, 1000);
                            }
                        }"
                        x-on:unload.window="if (intervalId !== null) clearInterval(intervalId)"
                    >
                        <div class="flex flex-col items-center">
                            <div x-text="timeLeft.days"></div>
                            <p>días</p>
                        </div>
                        <div class="flex flex-col items-center">
                            <div x-text="timeLeft.hours"></div>
                            <p>horas</p>
                        </div>
                        <div class="flex flex-col items-center">
                            <div x-text="timeLeft.minutes"></div>
                            <p>minutos</p>
                        </div>
                        <div class="flex flex-col items-center">
                            <div x-text="timeLeft.seconds"></div>
                            <p>segundos</p>
                        </div>
                    </div>
                </section>
            @endif
            <!--</editor-fold>-->

            <!--<editor-fold desc="Welcome">-->
            @if($content->get('welcome.visible'))
                <section>
                    <h2>Message</h2>
                    <p class="font-light leading-loose">{{ $content->get('welcome.message') }}</p>
                </section>
            @endif
            <!--</editor-fold>-->

            <!--<editor-fold desc="Mentions">-->
            <section>
                <h2>Mentions</h2>

                @if($event->event_type === \App\Enums\EventType::XV)
                    @if($content->get('mentions.parents.fifteen.visible'))
                        <div>
                            <h3>Mis papás</h3>
                            <p>{{ $content->get('mentions.parents.fifteen.femaleName') }}</p>
                            <p>{{ $content->get('mentions.parents.fifteen.maleName') }}</p>
                        </div>
                    @endif
                @endif

                @if($event->event_type === \App\Enums\EventType::Wedding)
                    @if($content->get('mentions.parents.bride.visible'))
                        <div>
                            <h3>Padres de la novia</h3>
                            <p>{{ $content->get('mentions.parents.bride.femaleName') }}</p>
                            <p>{{ $content->get('mentions.parents.bride.maleName') }}</p>
                        </div>
                    @endif

                    @if($content->get('mentions.parents.groom.visible'))
                        <div>
                            <h3>Padres del novio</h3>
                            <p>{{ $content->get('mentions.parents.groom.femaleName') }}</p>
                            <p>{{ $content->get('mentions.parents.groom.maleName') }}</p>
                        </div>
                    @endif
                @endif

                @if($content->get('mentions.special.visible'))
                    <div class="space-y-4 mt-8">
                        <h3>Menciones especiales</h3>
                        @foreach($content->get('mentions.special.relatives') as $mention)
                            <div>
                                <h4 class="font-bold">{{ $mention['relation'] }}</h4>
                                <p>{{ $mention['her'] }}</p>
                                <p>{{ $mention['him'] }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
            <!--</editor-fold>-->

            <!--<editor-fold desc="Places">-->
            <section>
                <h2>Places</h2>

                @if($content->get('locations.ceremony.visible'))
                    <div>
                        <h3>Ceremonia</h3>
                        <p>{{ $content->get('locations.ceremony.name') }}</p>
                        <p>{{ $content->get('locations.ceremony.address') }}</p>
                        <button>Como llegar</button>
                    </div>
                @endif

                <div class="mt-12">
                    <h3>Recepción</h3>
                    <p>{{ $content->get('locations.reception.name') }}</p>
                    <p>{{ $content->get('locations.reception.address') }}</p>
                    <button>Como llegar</button>
                </div>
            </section>
            <!--</editor-fold>-->

            <!--<editor-fold desc="Dress code">-->
            @if($content->get('dressCode.visible'))
                <section>
                    <h2>Dress code</h2>

                    <div>
                        <h3>Código de vestimenta</h3>
                        <p>{{ $content->get('dressCode.code') }}</p>
                    </div>

                    @if($content->get('dressCode.colors.visible'))
                        <p class="mt-12">Los siguientes colores están
                            reservados {{ join(', ', $content->get('dressCode.colors.items')) }}
                        </p>
                    @endif
                </section>
            @endif
            <!--</editor-fold>-->

            <!--<editor-fold desc="Program">-->
            @if($content->get('program.visible'))
                <section>
                    <h2>Program</h2>
                    <ul class="space-y-4">
                        @foreach($content->get('program.items') as $item)
                            <li>
                                <h3>{{ $item['name'] }}</h3>
                                <p>{{ $item['time'] }}</p>
                            </li>
                        @endforeach
                    </ul>
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

            <!--<editor-fold desc="Gifts">-->
            <section>
                <h2>Gifts</h2>

                @if($content->get('presents.tables.visible'))
                    <div>
                        <h3>Mesa de regalos</h3>
                        <div class="flex flex-col items-center space-y-4">
                            @foreach($content->get('presents.tables.items') as $item)
                                <a
                                    href="{{ $item['url'] }}"
                                    class="border border-black px-6 py-3 flex items-center space-x-2"
                                    target="_blank">
                                    <spa>@
                                        <nbsp/>{{ $item['name'] }}</spa>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($content->get('presents.account.visible'))
                    <div class="mt-12">
                        <h3>Datos bancarios</h3>
                        <div class="">
                            <p>{{ $content->get('presents.account.bank') }}</p>
                            <p>{{ $content->get('presents.account.beneficiary') }}</p>
                            <p>{{ $content->get('presents.account.card') }}</p>
                        </div>
                    </div>
                @endif

                @if($content->get('presents.envelope'))
                    <div class="mt-12">
                        <h3>Mensaje para sobres</h3>
                    </div>
                @endif
            </section>
            <!--</editor-fold>-->

            <!--<editor-fold desc="Gallery">-->
            @if($content->get('gallery.visible'))
                <section>
                    <h2>Gallery</h2>
                    <div class="grid gap-4">
                        @foreach([1, 2, 3] as $item)
                            <img src="{{ 'https://placehold.co/300'}}"
                                 alt="Gallery Image"
                                 class="w-full h-full object-cover border border-gray-400"
                            >
                        @endforeach
                    </div>
                </section>
            @endif
            <!--</editor-fold>-->

            <!--<editor-fold desc="RSVP">-->
            <section>
                <h2>Confirmar asistencia</h2>
                <button>Confirmar</button>
            </section>
            <!--</editor-fold>-->

            <!--<editor-fold desc="Recommendations">-->
            @if($content->get('recommendations.visible') )
                <section>
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
                <section>
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
        </main>
    </x-templates.wrapper>
</x-layouts.invitation>
