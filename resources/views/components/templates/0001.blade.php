@props(['event', 'invitation'])

<main class="h-full bg-pattern pb-2 bg-rose-100">
    <!--<editor-fold desc="Home">-->
    <section class="flex h-screen sm:max-h-[768px]">
        <div class="w-full relative">
            <img src="{{asset('/img/cover-top.webp')}}" alt="bg-top" class="w-full absolute">
            <div class="w-full h-full flex flex-col items-center justify-center px-4 relative z-10">
                <svg id="b" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                    <g id="circles">
                        <g style="opacity: .5;">
                            <path
                                d="M84.8,82.97c-18.63,18.63-48.94,18.63-67.57,0-18.63-18.63-18.63-48.94,0-67.57,18.63-18.63,48.94-18.63,67.57,0s18.63,48.94,0,67.57ZM17.44,15.6c-18.52,18.52-18.52,48.64,0,67.16,18.52,18.52,48.64,18.52,67.16,0,18.52-18.52,18.52-48.64,0-67.16-18.52-18.52-48.64-18.52-67.16,0Z"
                                style="fill: #e5b6a8; stroke-width: 0;"/>
                        </g>
                        <g style="opacity: .5;">
                            <path
                                d="M81.54,84.6c-18.63,18.63-48.94,18.63-67.57,0-18.63-18.63-18.63-48.94,0-67.57,18.63-18.63,48.94-18.63,67.57,0,18.63,18.63,18.63,48.94,0,67.57ZM14.18,17.24c-18.52,18.52-18.52,48.64,0,67.16s48.64,18.52,67.16,0c18.52-18.52,18.52-48.64,0-67.16-18.52-18.52-48.64-18.52-67.16,0Z"
                                style="fill: #e5b6a8; stroke-width: 0;"/>
                        </g>
                        <g style="opacity: .5;">
                            <path
                                d="M86.03,84.6c-18.63,18.63-48.94,18.63-67.57,0-18.63-18.63-18.63-48.94,0-67.57s48.94-18.63,67.57,0c18.63,18.63,18.63,48.94,0,67.57ZM18.67,17.24c-18.52,18.52-18.52,48.64,0,67.16s48.64,18.52,67.16,0,18.52-48.64,0-67.16c-18.52-18.52-48.64-18.52-67.16,0Z"
                                style="fill: #e5b6a8; stroke-width: 0;"/>
                        </g>
                    </g>
                    <g id="type">
                        <path
                            d="M42.48,15.38s.09,0,.13.03c.89.57,1.82.77,1.82,1.53,0,.35-.24.68-.59,1.16-1.14,1.55-3.01,3.48-2.88,4.76.7-1.01,3.11-4.39,5.11-6.35.02-.01.06,0,.08,0,.73.47,1.57.68,1.62,1.15.03.33-.18.72-.46,1.19-.51.85-1.47,2.53-1.68,3.62.85-1.28,3.54-5.16,5.47-7.04.02-.01.06,0,.08,0,.93.57,1.6.74,1.63,1.21.02.33-.19.73-.5,1.19-1.94,2.87-3.73,6.54-2.79,7.03-.41.1-.8.16-1.15.16-.85,0-1.43-.35-1.43-1.3,0-1.49,1.8-4.24,4.09-7.77.06-.09.09-.18.09-.31-1.66,1.66-4.73,5.98-5.53,7.2-1.24,0-1.67-.41-1.7-1.16-.04-1.19.83-2.76,2.08-4.72.04-.07.09-.15.11-.23-1.65,1.68-4.26,5.14-5.07,6.35-1.24,0-1.53-.65-1.53-1.4,0-1.88,1.35-3.14,2.93-5.24.2-.27.45-.72.07-1.08h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M52.76,18.58s.06,0,.08,0c.89.57,1.83.74,1.83,1.21,0,.33-.29.71-.64,1.19-.3.41-.89,1.48-.89,2.1,0,.34.17.35.3.35.8,0,2.09-1.81,2.58-2.47.05-.06.19.05.14.11-.94,1.22-1.96,2.57-2.89,2.57-.81,0-1.69-.44-1.69-1.66,0-.88.51-1.94,1.12-2.88.1-.16.2-.35.07-.53h0ZM54.21,16.11s.03,0,.04,0c.49.16,1.73.59,1.73,1.17,0,.35-.7,1.15-1.23,1.45-.47-.18-1.13-.62-1.13-.94s.27-.79.53-1.24c.08-.13.14-.35.07-.45h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M57.39,18.58c.1.36.71.58,1.12.77.31.14.41.34.46.63.12.79.45,1.46.45,2,0,.78-.74,1.76-2.15,1.76-1,0-1.89-.49-2.63-1.48l.06-.05c.68.77,1.26,1.06,1.68,1.06.56,0,.9-.47.9-1.16,0-.62-.25-1.45-.24-2.27-.23.33-.51.74-.88,1.25-.05.07-.19-.05-.14-.11.42-.62.68-1.04,1.12-1.89.05-.17.12-.34.22-.51h.03Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M36.35,25.05c.48,0,.88.26,1.07.79-1.69-.22-4.13,1.97-4.91,3.48.15,1.85.55,3.79,1.65,3.49v.05c-.28.31-.88.66-1.59.66-1.17,0-1.79-1.22-2.13-2.82-.74,1.69-1.78,3.39-3.08,3.39-.4,0-.83-.28-.96-.65,1.32.32,3.06-1.26,3.99-2.97-.3-1.55-.37-3.42-.43-4.9,0-.13-.03-.25-.13-.38.02-.01.06-.01.08,0,.55.42,1.51.57,2.07.78.53.19.45.63.45.9,0,.54,0,1.35.06,2.21.75-1.6,2.73-4,3.86-4h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M42.29,24.29s.06,0,.08,0c.66.47,1.1.89,1.1,1.52,0,2.06-5.68,7.26-7.48,7.26-1.1,0-1.58-1.03-1.58-1.51,0-1.41,1.6-3.61,3.07-5.68.19-.27.42-.72.03-1.08.05,0,.09,0,.13.03.91.57,1.88.99,1.88,1.53,0,.35-.21.68-.54,1.16-1.13,1.63-3.69,5.24-2.73,5.24,1.77,0,6.1-5.58,6.1-7.96,0-.19-.02-.36-.05-.53h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M47.62,28.28c.48,0,1.11.19,1.54.65l-.02.03c-.09-.08-.17-.1-.26-.1-.72,0-2.49,3.08-2.56,3.81,1.11-.53,2.57-3.24,3.24-4.19.66.59,1.72.63,1.72,1.29,0,.77-1.2,2.26-1.2,2.81,0,.2.14.27.26.27.53,0,1.54-1.06,2.43-2.46.05-.06.19.05.14.11-.51.7-1.65,2.57-2.83,2.57-.93,0-1.61-.44-1.61-1.34,0-.75.47-1.87,1.16-2.98l-.03-.03c-.75,1.13-2.56,4.35-3.66,4.35-.44,0-1.42-.27-1.42-1.39,0-1.37,1.38-3.41,3.08-3.41h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M53.76,28.01s.06,0,.08,0c.89.57,1.83.74,1.83,1.21,0,.33-.29.71-.64,1.19-.29.39-.99,1.47-.97,2.2.75-1.08,2.38-3.32,3.76-4.12.08-.13.13-.17.29-.17.51,0,1.74.74,1.74,1.14,0,.17-.11.31-.18.38-.82.91-1.76,2.09-1.76,2.7,0,.24.11.33.3.33.82,0,2.27-1.85,2.74-2.47.05-.06.19.05.14.11-.94,1.22-2.11,2.57-3.05,2.57-.81,0-1.69-.59-1.69-1.65,0-.76.74-1.84,1.15-2.44-1.33.96-2.79,2.95-3.41,3.87-.68,0-1.53-.1-1.53-1.45,0-.88.51-1.94,1.12-2.88.1-.16.2-.35.07-.53h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M58.35,27.47c.36,0,.61-.18.97-.76.03-.03.11,0,.09.03-.43.7-.72.84-1.06.84-.92,0-1.34-.99-2.2-.99-.33,0-.59.15-1.02.85-.02.03-.11,0-.09-.03.42-.68.7-.93,1.14-.93.88,0,1.3.99,2.16.99Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M58.35,27.7c-.51,0-.87-.27-1.21-.53-.31-.23-.6-.46-.99-.46-.23,0-.46.06-.91.79-.04.07-.14.1-.23.05-.08-.04-.11-.13-.08-.2.4-.65.72-1,1.26-1,.49,0,.83.27,1.17.52.31.24.61.46.99.46.28,0,.5-.11.87-.7.07-.08.17-.09.25-.04.07.04.09.12.06.19-.46.76-.79.91-1.18.91ZM55.03,27.38s0,0,0,0c0,0,0,0,0,0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M64.56,27.98c.7,0,1.4.45,1.4,1.53,0,.83-.42,1.83-1.12,2.56.76-.09,1.63-.75,2.27-1.66.05-.06.19.05.14.11-.34.5-1.38,1.71-2.58,1.72-.55.51-1.24.85-2.02.85-1.17,0-2-.53-2-1.63,0-1.2.89-2.45,2.33-2.59.36-.56.98-.89,1.57-.89h0ZM62.95,31.27c-.12.33-.2.69-.19,1.02,0,.53.2.6.39.6.39,0,.78-.27,1.11-.69-.69-.11-1.08-.49-1.3-.93h0ZM64.24,28.28c-.35,0-.75.19-1,.57h.03c.23,0,.91.04,1.4.66l-.02.03c-.09-.08-.17-.1-.26-.1-.31,0-.93.67-1.31,1.51.16.52.51,1,1.28,1.1.51-.71.85-1.75.8-2.59-.05-.85-.46-1.18-.93-1.18h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M68.49,28.01c.1.36.71.58,1.12.77.31.14.41.34.46.63.12.79.45,1.46.45,2,0,.78-.74,1.76-2.15,1.76-1,0-1.89-.49-2.63-1.48l.06-.05c.68.77,1.26,1.06,1.68,1.06.56,0,.9-.47.9-1.16,0-.62-.25-1.45-.24-2.27-.23.33-.51.74-.88,1.25-.05.07-.19-.05-.14-.11.42-.62.68-1.04,1.12-1.89.05-.17.12-.34.22-.51h.03Z"
                            style="fill: #fda4af; stroke-width: 0;"/>

                        <path
                            d="M16.5,41.53c.08,0,.16,0,.24.06,1.63,1.04,3.34,1.41,3.34,2.8,0,.64-.43,1.24-1.07,2.12-2.09,2.85-6.02,7.26-5.85,9.71,1.68-2.55,8.82-14.07,12.37-14.07,1.13,0,3.24.54,3.24,2.59,0,2.51-3.66,6.45-6.96,6.45-1.3,0-2.67-.66-3.18-1.85.05.25.2.51.32.74,1.92,3.5,5.18,7.83,5.71,8.2.06.04.13.08.22.12,0,.04-.05.07-.08.1-1.09,1.09-2.11,1.42-2.92,1.42-3.26,0-3.85-4.2-3.34-10.62l.08-.13c.13.18.41.59.72.59,1.98,0,5.51-5.36,5.51-6.97-2.67,0-9.72,11.06-11.6,13.88-2.28,0-2.8-1.2-2.8-2.56,0-3.44,3.06-6.75,5.94-10.62.37-.5.82-1.33.12-1.97h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M31.95,47.88c2.72,0,4.05,1.04,4.05,2.2,0,1.45-1.86,3.09-3.23,3.09-.35,0-1.05-.52-1.3-1.18l.05-.05c.13.18.33.42.64.42.81,0,2.62-2.6,2.62-3.28,0-.27-.08-.42-.23-.42-1.07,0-4.66,4.17-4.66,6.74,0,.21,0,.85.7.85,1.75,0,4.51-1.36,6.83-4.49.1-.11.34.09.25.2-.87,1.28-3.95,4.7-7.52,4.7-1.1,0-4.01-.35-4.01-2.91s2.68-5.9,5.82-5.9h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M39.17,47.38s.1-.02.14.01c1.63,1.04,3.36,1.35,3.36,2.22,0,.6-.53,1.3-1.17,2.18-.53.72-1.81,2.69-1.79,4.03,1.38-1.98,4.36-6.08,6.89-7.55.14-.24.24-.32.54-.32.94,0,3.19,1.35,3.19,2.08,0,.31-.2.56-.33.7-1.5,1.67-3.22,3.84-3.22,4.95,0,.44.2.61.56.61,1.5,0,4.16-3.4,5.02-4.52.1-.11.34.09.25.2-1.73,2.23-3.87,4.7-5.59,4.7-1.48,0-3.09-1.08-3.09-3.02,0-1.39,1.36-3.37,2.1-4.47-2.44,1.75-5.11,5.41-6.25,7.09-1.24,0-2.8-.18-2.8-2.65,0-1.62.94-3.55,2.06-5.28.19-.29.36-.64.12-.97h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M57.37,47.88c.87,0,2.04.35,2.82,1.2l-.03.06c-.17-.14-.31-.17-.47-.17-1.32,0-4.57,5.64-4.69,6.99,2.03-.97,4.7-5.95,5.94-7.68,1.21,1.09,3.16,1.16,3.16,2.36-.01,1.42-2.19,4.14-2.19,5.16,0,.37.25.5.48.5.98,0,2.82-1.95,4.46-4.51.1-.11.34.09.25.2-.93,1.29-3.02,4.7-5.18,4.7-1.7,0-2.95-.81-2.95-2.45,0-1.38.85-3.44,2.13-5.47l-.05-.05c-1.38,2.07-4.69,7.97-6.72,7.97-.8,0-2.6-.49-2.6-2.54,0-2.51,2.52-6.26,5.65-6.26h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M72.53,42.73s.1-.02.15.01c1.71,1.04,2.64,1.02,2.7,2.06.03.55-.07.93-.55,1.62h2.06c.17,0,.01.29-.17.29h-2.11c-2.05,2.8-5.37,7.06-5.37,9.05,0,.41.34.53.55.53,1.46,0,4.18-3.32,5.04-4.52.1-.11.34.09.25.2-1.73,2.23-3.89,4.7-5.61,4.7-1.48,0-3.09-1.17-3.09-3.02s1.57-4.35,3.19-6.64c.08-.21-.46-.3-1.27-.3h-.97c-.15,0,0-.29.17-.29h2.5c.92-1.28,1.82-2.43,2.42-3.26.04-.06.17-.25.11-.43h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M79.83,47.88c.87,0,2.04.35,2.82,1.2l-.03.06c-.17-.14-.31-.17-.47-.17-1.32,0-4.57,5.64-4.69,6.99,2.03-.97,4.7-5.95,5.94-7.68,1.21,1.09,3.16,1.16,3.16,2.36-.01,1.42-2.19,4.14-2.19,5.16,0,.37.25.5.48.5.98,0,2.82-1.95,4.46-4.51.1-.11.34.09.25.2-.93,1.29-3.02,4.7-5.18,4.7-1.7,0-2.95-.81-2.95-2.45,0-1.38.85-3.44,2.13-5.47l-.05-.05c-1.38,2.07-4.69,7.97-6.72,7.97-.8,0-2.6-.49-2.6-2.54,0-2.51,2.52-6.26,5.65-6.26h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>

                        <path
                            d="M31.54,72.28c-1.84,2.46-3.05,4.89-3.05,5.7,0,.31.08.5.24.6-1.14.28-1.84.04-1.84-.96,0-1.05,1.07-2.73,2.23-4.08l.07-.07c-.58.31-1.23.62-1.8.81-.06.02-.1-.1-.04-.12.7-.24,1.53-.66,2.19-1.03.59-.5,1.3-.78,2-.85h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M33.78,72.07c.4,0,.97.15,1.39.61v.03c-.09-.06-.26-.15-.34-.15-.54,0-2.09,1.87-2.09,3.03,0,.18.12.32.35.24,1.13-.34,2.07-2.39,2.29-3.47l.12.02c.07.2.17.79.14,1.32-.12,2.5-2.47,5.05-4.46,5.06-.41,0-.73-.32-.78-.66,2.68.27,4.92-2.1,5.09-4.41.03-.36,0-.8-.04-1.06-.3,1.26-1.34,3.32-2.77,3.48-.77.08-1.47-.26-1.47-1.19,0-1.14,1.15-2.84,2.57-2.84h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M39.15,74.41s.02,0,.03,0c.33,0,1.25.38,1.21.82-.02.26-.47.98-.96.98-.41,0-.82-.47-.8-.71.02-.25.19-.48.42-.82.07-.1.1-.16.1-.27h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M47.4,72.14c.22,0,.8.15.97.58l-.02.03c-.04-.06-.09-.07-.15-.07-1.96,0-4.52,5.87-2.98,5.87,1.43,0,2.99-2.72,3.08-4.47.03-.61-.12-.93-.6-.94l.06-.05c.37,0,.77.12,1,.49.63,1.01-1.23,5.15-3.77,5.15-3.21,0-.95-6.58,2.4-6.58h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M53.44,72.14c.06.07.12.26.06.45-.4,1.25-3.22,3.01-4.41,3.61.04.21.64.46,1.78.3l.33-.05c.32-.69.79-1.33,1.1-1.68.66-.77,1.54-1.18,2.41-1.26-.68,1-1.23,1.89-1.6,2.63.66-.06,1.26-.05,1.13.28-.14-.15-.59-.19-1.21-.12-.35.72-.54,1.29-.54,1.68,0,.31.08.57.24.67-1.06.26-1.99-.07-1.83-1.24.03-.23.1-.48.2-.72l-.47.07c-1.08.15-1.68.17-1.73-.21-.02-.14.04-.34.13-.45,1.3-.62,3.52-2.5,4.41-3.95h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M58.1,74.41s.02,0,.03,0c.33,0,1.25.38,1.21.82-.02.26-.47.98-.96.98-.41,0-.82-.47-.8-.71.02-.25.19-.48.42-.82.07-.1.1-.16.1-.27h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M65.53,72.09c1.26,0,2.09.65,2.09,1.57,0,1.8-3.15,3.04-5.18,3.67,1.1.21,4.17-.36,4.35-.84,0-.02.05-.03.08-.03-.06.44-.86,2.03-1.85,2.2-.28.05-.55.07-.8.07-.96,0-1.87-.32-2.29-.6-.12-.19.17-.73.34-.84,2.34-.79,3.83-2.18,3.83-4.08,0-.5-.1-.96-.76-.96-1.36,0-1.47,1.94-1.22,2.2-.58,0-.75-.47-.75-.69,0-1.04.94-1.66,2.17-1.66h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                        <path
                            d="M72.2,72.14c.06.07.12.26.06.45-.4,1.25-3.22,3.01-4.41,3.61.04.21.64.46,1.78.3l.33-.05c.32-.69.79-1.33,1.1-1.68.66-.77,1.54-1.18,2.41-1.26-.68,1-1.23,1.89-1.6,2.63.66-.06,1.26-.05,1.13.28-.14-.15-.59-.19-1.21-.12-.35.72-.54,1.29-.54,1.68,0,.31.08.57.24.67-1.06.26-1.99-.07-1.83-1.24.03-.23.1-.48.2-.72l-.47.07c-1.08.15-1.68.17-1.73-.21-.02-.14.04-.34.13-.45,1.3-.62,3.52-2.5,4.41-3.95h0Z"
                            style="fill: #fda4af; stroke-width: 0;"/>
                    </g>
                </svg>
            </div>
            <img src="{{asset('/img/cover-bottom.webp')}}" alt="bg-bottom" class="w-full absolute bottom-4">
        </div>
    </section>
    <!--</editor-fold>-->

    <!--<editor-fold desc="Welcome">-->
    <section class="pb-12">
        <div class="flex justify-center py-6">
            <img src="{{asset('/img/butterfly-02.webp')}}" alt="" class="w-16 move">
        </div>
        <h2 class="font-display text-2xl leading-snug font-bold mb-16">
            Hay instantes en la vida <br>que imaginamos, anhelamos <br>y esperamos, uno de esos <br>momentos esta por
            llegar
            <br>y lo quiero compartir <br>contigo.
        </h2>

        <div class="w-full text-xl font-display font-bold mb-12">
            <h3 class="text-xl mb-3 font-sans font-extralight uppercase">
                Mis padres
            </h3>

            <p>Mónica Martín del Campo Romo</p>
            <p>Carlos Antonio Gaona Armijo</p>
        </div>

        <div class="w-full text-xl font-display font-bold mb-12">
            <h3 class="mb-3 font-sans font-extralight uppercase">
                Mis padrinos
            </h3>

            <p>Claudia Noemi Licea Silva</p>
            <p>Martín Alejandro Gómez Guerrero</p>
        </div>

        <hr class="border-rose-400 border-dashed w-2/3 mx-auto my-6">

        <div class="w-full text-lg font-display p-4">
            <p>Quiero agradecer de manera muy especial a mi abuelito</p>
            <p class="font-bold my-6 text-xl">Rosendo Martín del Campo <br>De La Torre</p>
            <p>por su amor incondicional, <br>sus sabios consejos y su presencia <br>constante en mi vida.</p>
        </div>
    </section>
    <!--</editor-fold>-->

    <div>
        <img src="{{asset('/img/divider-01.webp')}}" alt="divider" class="px-2"/>
    </div>

    <!--<editor-fold desc="Counter">-->
    <section class="flex flex-col justify-center items-center py-24">
        <h3 class="text-5xl font-thin mb-8">Faltan</h3>

        <div class="grid grid-cols-4 w-full font-display font-bold px-4"
             x-data="{
            targetDate: new Date('2024-04-19T18:00:00'),
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
        }" x-init="init()" x-on:unload.window="if (intervalId !== null) clearInterval(intervalId)">
            <div class="flex flex-col items-center">
                <div class="text-4xl" x-text="timeLeft.days"></div>
                <div class="font-extralight text-sm">días</div>
            </div>
            <div class="flex flex-col items-center">
                <div class="text-4xl" x-text="timeLeft.hours"></div>
                <div class="font-extralight text-sm">horas</div>
            </div>
            <div class="flex flex-col items-center">
                <div class="text-4xl" x-text="timeLeft.minutes"></div>
                <div class="font-extralight text-sm">minutos</div>
            </div>
            <div class="flex flex-col items-center">
                <div class="text-4xl" x-text="timeLeft.seconds"></div>
                <div class="font-extralight text-sm">segundos</div>
            </div>
        </div>
    </section>
    <!--</editor-fold>-->

    <div>
        <img src="{{asset('/img/divider-02.webp')}}" alt="divider" class="px-2"/>
    </div>

    <!--<editor-fold desc="Places">-->
    <section class="py-16">
        <div>
            <h3 class="text-3xl font-extralight">
                Ceremonia
            </h3>

            <h2 class="font-display text-3xl my-8 font-bold text-rose-400">
                Iglesia de Nuestra <br>Señora del Rosario
            </h2>

            <p class="font-display text-2xl font-extrabold">
                6:00 pm
            </p>
            <p class="text-xl leading-snug">
                Santo Domingo #1518, <br> Lomas del bosque, C.P. 45140, <br> Zapopan, Jalisco
            </p>

            <x-filament::button
                outlined="true"
                icon="heroicon-o-map"
                href="https://maps.app.goo.gl/WJqSWarZEi7xQ6NP8"
                tag="a"
                size="xl"
                target="_blank"
                class="py-4 px-6 mt-6 text-rose-400 !border-rose-400"
                color="danger"
            >
                Como llegar
            </x-filament::button>
        </div>

        <hr class="border-rose-300 border-dashed w-3/4 mx-auto my-12">


        <div>
            <h3 class="text-3xl font-extralight">
                Recepción
            </h3>

            <h2 class="font-display text-3xl my-8 font-bold text-rose-400">
                Real de Toledo <br>Salón de Eventos
            </h2>

            <p class="font-display text-2xl font-extrabold">
                8:00 pm
            </p>
            <p class="text-xl leading-snug font-light">
                Av. Guadalupe Quinceava #3239, <br> Zona Militar, C.P. 45138, <br> Zapopan, Jalisco
            </p>

            <x-filament::button
                outlined="true"
                icon="heroicon-o-map"
                href="https://maps.app.goo.gl/Gx47JTp2G6fHu5Dw6"
                tag="a"
                size="xl"
                target="_blank"
                class="py-4 px-6 mt-6 text-rose-400"
                color="danger"
            >
                Como llegar
            </x-filament::button>
        </div>
    </section>
    <!--</editor-fold>-->

    <div>
        <img src="{{asset('/img/divider-03.webp')}}" alt="divider" class="px-2"/>
    </div>

    <!--<editor-fold desc="Dress code">-->
    <section class="py-16">
        <h4 class="text-3xl font-extralight">
            Código de vestimenta
        </h4>

        <h3 class="text-3xl font-display font-extrabold mt-12 mb-4 text-rose-400">
            Etiqueta
        </h3>

        <div class="w-full text-center">
            <div class="flex justify-center space-x-6 w-full text-2xl font-extralight text-rose-400">
                <div class="flex flex-col items-center p-4">
                    <img src="{{asset('/icons/icon-suit.svg')}}" alt="icon suit" class="h-60">
                    <div>Hombres</div>
                    <div class="text-lg">Traje</div>
                </div>
                <div class="flex flex-col items-center p-4">
                    <img src="{{asset('/icons/icon-dress.svg')}}" alt="icon suit" class="h-60">
                    <div>Mujeres</div>
                    <div class="text-lg">Vestido largo</div>
                </div>
            </div>
        </div>

        <div class="mt-16 text-center space-y-2 px-8 leading-snug text-lg">
            <p>Los colores <b>rosa</b> y <b>verde oscuro</b> están reservados para la quinceañera y su mamá
                respectivamente.
            </p>
        </div>
    </section>
    <!--</editor-fold>-->

    <div>
        <img src="{{asset('/img/divider-04.webp')}}" alt="divider" class="px-2 -scale-x-100"/>
    </div>

    <!--<editor-fold desc="Instagram">-->
    <section class="py-24 px-8">
        <h3 class="text-3xl font-display font-extrabold mb-8 text-rose-400">
            Sigue el evento en Instagram
        </h3>

        <x-filament::button
            outlined="true"
            href="https://www.instagram.com/mis_xv_renata/?igsh=MW0wMWt5Y3I3MXNvcA%3D%3D"
            tag="a"
            size="xl"
            target="_blank"
            class="py-4 px-6 mt-8"
            color="danger"
        >
            @mis_vx_renata
        </x-filament::button>
    </section>
    <!--</editor-fold>-->

    <div>
        <img src="{{asset('/img/divider-03.webp')}}" alt="divider" class="px-2"/>
    </div>

    <!--<editor-fold desc="Timeline">-->
    <section class="py-16">
        <h4 class="text-4xl font-display font-extrabold text-rose-400">
            El gran día
        </h4>

        <div class="mt-16 grid grid-cols-9 gap-y-8 text-2xl font-light">
            <div class="border-r-2 border-rose-300 border-dotted row-span-7 translate-x-10 mt-4"></div>

            <div class="col-start-2 col-span-7 flex items-center space-x-2 z-10">
                <div>
                    <img src="{{asset('/icons/icon-church.svg')}}" alt="" class="w-20">
                </div>
                <div class="text-left">
                    <div class="flex items-center space-x-1">
                        <span class="i-mdi-clock-time-six-outline size-5"></span>
                        <p class="text-lg">6:00 pm</p>
                    </div>
                    <p>Ceremonia</p>
                </div>
            </div>

            <div class="col-start-2 col-span-7 flex items-center space-x-2 z-10">
                <div>
                    <img src="{{asset('/icons/icon-photos.svg')}}" alt="" class="w-20">
                </div>
                <div class="text-left">
                    <div class="flex items-center space-x-1">
                        <span class="i-mdi-clock-time-seven-outline size-5"></span>
                        <p class="text-lg">7:00 pm</p>
                    </div>
                    <p>Fotos</p>
                </div>
            </div>

            <div class="col-start-2 col-span-7 flex items-center space-x-2 z-10">
                <div>
                    <img src="{{('/icons/icon-cocktail.svg')}}" alt="" class="w-20">
                </div>
                <div class="text-left">
                    <div class="flex items-center space-x-1">
                        <span class="i-mdi-clock-time-eight-outline size-5"></span>
                        <p class="text-lg">8:00 pm</p>
                    </div>
                    <p>Cocktail</p>
                </div>
            </div>

            <div class="col-start-2 col-span-7 flex items-center space-x-2 z-10">
                <div>
                    <img src="{{asset('/icons/icon-dinner.svg')}}" alt="" class="w-20">
                </div>
                <div class="text-left">
                    <div class="flex items-center space-x-1">
                        <span class="i-mdi-clock-time-nine-outline size-5"></span>
                        <p class="text-lg">9:00 pm</p>
                    </div>
                    <p>Cena</p>
                </div>
            </div>

            <div class="col-start-2 col-span-7 flex items-center space-x-2 z-10">
                <div>
                    <img src="{{asset('/icons/icon-dance.svg')}}" alt="" class="w-20">
                </div>
                <div class="text-left">
                    <div class="flex items-center space-x-1">
                        <span class="i-mdi-clock-time-ten-outline size-5"></span>
                        <p class="text-lg">10:00 pm</p>
                    </div>
                    <p>Baile</p>
                </div>
            </div>

            <div class="col-start-2 col-span-7 flex items-center space-x-2 z-10">
                <div>
                    <img src="{{asset('/icons/icon-cake.svg')}}" alt="" class="w-20">
                </div>
                <div class="text-left">
                    <div class="flex items-center space-x-1">
                        <span class="i-mdi-clock-time-ten-outline size-5"></span>
                        <p class="text-lg">12:00 am</p>
                    </div>
                    <p>Pastel</p>
                </div>
            </div>

            <div class="col-start-2 col-span-7 flex items-center space-x-2 z-10">
                <div class="w-20">
                    <img src="{{asset('/icons/icon-bye.svg')}}" alt="" class="w-20">
                </div>
                <div class="text-left">
                    <div class="flex items-center space-x-1">
                        <span class="i-mdi-clock-time-two-outline size-5"></span>
                        <p class="text-lg">2:00 am</p>
                    </div>
                    <p class="fle">Nos despedimos</p>
                </div>
            </div>
        </div>
    </section>
    <!--</editor-fold>-->

    <div>
        <img src="{{asset('/img/divider-03.webp')}}" alt="divider" class="px-2 -scale-x-100"/>
    </div>

    <!--<editor-fold desc="Gifts">-->
    <section class="py-16 px-6">
        <h4 class="text-3xl font-display font-extrabold mb-8 text-rose-400">
            Mesa de regalos
        </h4>

        <div>
            <p class="mb-12 text-xl leading-snug">
                Tu presencia es mi mayor regalo, pero si deseas tener un detalle conmigo te comparto mi lista de
                regalos.
            </p>

            <div class="space-y-6">
                <x-filament::button
                    outlined="true"
                    icon="heroicon-o-gift"
                    href="https://mesaderegalos.liverpool.com.mx/milistaderegalos/51243369"
                    tag="a"
                    size="xl"
                    target="_blank"
                    class="py-4 mt-6 text-rose-400 w-full"
                    color="danger"
                >
                    Liverpool
                </x-filament::button>

                <x-filament::button
                    outlined="true"
                    icon="heroicon-o-gift"
                    href="https://www.amazon.com.mx/registries/gl/guest-view/1AZ384FTUTKYE"
                    tag="a"
                    size="xl"
                    target="_blank"
                    class="py-4 mt-6 text-rose-400 w-full"
                    color="danger"
                >
                    Amazon
                </x-filament::button>
            </div>
        </div>
    </section>
    <!--</editor-fold>-->

    <div>
        <img src="{{asset('/img/divider-02.webp')}}" alt="divider" class="px-2"/>
    </div>

    <!--<editor-fold desc="Gallery">-->
    <section class="py-8 px-6">
        <h3 class="text-3xl font-display font-extrabold mb-8 text-rose-400">
            Galería
        </h3>
        <div class="grid gap-y-4">
            @foreach([1,2,3,4,5] as $i)
                <img
                    src="{{'/img/xv-renata-'.$i.'.webp'}}"
                    alt="Imagen de la galería"
                    class="rounded-md shadow-md"
                    loading="lazy"
                />
            @endforeach
        </div>
    </section>
    <!--</editor-fold>-->

    <div>
        <img src="{{asset('/img/divider-01.webp')}}" alt="divider" class="px-2"/>
    </div>

    <!--<editor-fold desc="RSVP">-->
    @if($invitation)
        <section class="py-24 px-8">
            @if($invitation->status->value == 'pending')
                <h3 class="text-3xl font-display font-extrabold mb-8 text-rose-400">
                    Confirmar asistencia
                </h3>

                <p class="text-lg">
                    Es muy importante para mí contar con tu confirmación lo antes posible.
                </p>

                @livewire('confirm-invitation', ['invitation' => $invitation])
            @endif

            @if($invitation->status->value == 'confirmed')
                <h3 class="text-3xl font-display font-extrabold mb-8 text-rose-400">
                    Asistencia confirmada
                </h3>

                <p class="font-medium text-rose-400">
                    ¡Gracias por confirmar tu asistencia!
                </p>

                <p v-if="!allowDownload" class="mt-4 text-rose-400">
                    No olvides descargar tus boletos<br>
                    a <b>partir del 5 de abril de 2024</b><br>
                    y presentarlos en la entrada el día <br>del evento.
                </p>

                <p v-else class="mt-4 text-rose-400">
                    No olvides descargar tus boletos<br>
                    y presentarlos en la entrada el día<br>
                    del evento.
                </p>
                @livewire('show-qr-code', ['invitation' => $invitation])
            @endif
        </section>
    @else
        <section class="py-24 px-8">
            <h3 class="text-3xl font-display font-extrabold mb-8 text-rose-400">
                Confirmar asistencia
            </h3>

            <p class="text-lg">
                Es muy importante para mí contar con tu confirmación lo antes posible.
            </p>

            <x-filament::button
                outlined="true"
                icon="heroicon-o-user-group"
                size="xl"
                target="_blank"
                class="py-4 px-6 mt-6 text-rose-400 !border-rose-400"
                color="danger"
            >
                Confirmar asistencia
            </x-filament::button>
        </section>
    @endif
    <!--</editor-fold>-->

    <div>
        <img src="{{asset('/img/divider-02.webp')}}" alt="divider" class="px-2"/>
    </div>

    <!--<editor-fold desc="Accommodations">-->
    <section class="py-16 px-6">
        <h3 class="text-3xl font-display font-extrabold mb-8 text-rose-400">
            Hoteles cercanos
        </h3>

        <p class="mb-12">
            Te compartimos éstas sugerencias de hospedaje muy cercanas al lugar de la celebración.
        </p>

        <div>
            <h4 class="text-2xl  mb-2">
                Hotel Intercity
            </h4>

            <p class="text-lg leading-snug font-light">
                Periférico Norte Manuel <br>Gómez Morín #5400, <br>San Juan de Ocotán, 45019 <br>Zapopan, Jalisco.
            </p>
            <x-filament::button
                outlined="true"
                icon="heroicon-o-map"
                href="https://maps.app.goo.gl/YtUqivB2kussSYbh6"
                tag="a"
                size="xl"
                target="_blank"
                class="py-4 px-6 mt-6 text-rose-400"
                color="danger"
            >
                Como llegar
            </x-filament::button>
        </div>

        <div class="mt-12">
            <h4 class="text-2xl mb-2">
                Hotel Holiday Inn Express
            </h4>

            <p class="text-lg leading-snug font-light">
                Carretera Guadalajara-Nogales #440 <br>Frac. San Juan de Ocotán, 45019 <br>Guadalajara, Jalisco.
            </p>

            <x-filament::button
                outlined="true"
                icon="heroicon-o-map"
                href="https://maps.app.goo.gl/W7F8CA899dYtmr1C6"
                tag="a"
                size="xl"
                target="_blank"
                class="py-4 px-6 mt-6 text-rose-400"
                color="danger"
            >
                Como llegar
            </x-filament::button>
        </div>
    </section>
    <!--</editor-fold>-->

    <div>
        <img src="{{asset('/img/divider-03.webp')}}" alt="divider" class="px-2"/>
    </div>

    <!--<editor-fold desc="Thanks">-->
    <section class="min-h-80 flex items-center justify-center px-6">
        <h2 class="font-display text-2xl leading-snug font-bold my-16">
            Gracias anticipadas por acompañarme en este día tan especial.
        </h2>
    </section>
    <!--</editor-fold>-->

    <div>
        <img src="{{asset('/img/divider-04.webp')}}" alt="divider" class="px-2"/>
    </div>
</main>
