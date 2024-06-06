<x-filament-panels::page>
    <div
        x-data="{
            tables: $wire.tables,
            addTable() {
                this.tables.push([]);
            },
            deleteTable(tableIndex) {
                if (tableIndex < this.tables.length) {
                    this.tables[0] = [...this.tables[0], ...this.tables[tableIndex]];
                    this.tables.splice(tableIndex, 1);
                }
            },
            handle(guestId, table) {
                const currentTable = Object.keys(this.tables).filter(key => this.tables[key].some(g => g.id === guestId))[0];
                const guest = this.tables[currentTable].filter(g => g.id === guestId)[0];

                // remove the guest from the current table
                this.tables[currentTable] = this.tables[currentTable].filter(g => g.id !== guestId);

                // move the guest to another table
                this.tables[table].push(guest);
            }
        }"
        x-on:tables-updated.window="tables = $wire.tables"
        x-load-js="[@js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('alpine-sort'))]"
        class="space-y-6"
    >
        <div class="flex justify-between gap-x-4">
            <x-filament::button x-on:click="addTable" outlined>
                Agregar mesa
            </x-filament::button>
            <x-filament::button x-on:click="$wire.saveTables(tables)">
                Guardar
            </x-filament::button>
        </div>
        <div class="grid grid-cols-5 gap-4">
            <div
                class="sticky top-20 self-start p-4 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 min-h-24">
                <h2 class="font-bold">
                    Sin mesa asignada
                </h2>
                <p x-text="tables[0].length + ' Personas'" class="text-gray-500 text-sm  mb-4"></p>
                <ul x-sort="handle($item, 0)" x-sort:group="groups" class="h-[46rem] w-full space-y-3 overflow-auto">
                    <template x-if="tables[0] !== undefined">
                        <template x-for="guest in tables[0]" :key="guest.id">
                            <li
                                x-sort:item="guest.id"
                                class="flex items-center space-x-1.5 border px-2 py-1 rounded hover:bg-gray-50 cursor-move"
                            >
                                <span
                                    class="i-solar-user-rounded-line-duotone !size-4.5 text-gray-500 dark:text-gray-400"></span>
                                <p x-text="`${guest.name} ${guest.family}` " class="text-sm"></p>
                            </li>
                        </template>
                    </template>
                </ul>
            </div>

            <div class="col-span-4 grid grid-cols-3 self-start gap-6">
                <template x-for="(table, index) in tables">
                    <template x-if="index > 0">
                        <x-filament::section>
                            <div class="flex items-end pb-4">
                                <div class="flex-grow">
                                    <h2 x-text="`Mesa ${index}`" class="font-bold text-xl"></h2>
                                    <p x-text="table.length + ' Personas'" class="text-gray-500 text-sm"></p>
                                </div>

                                <button
                                    x-on:click="deleteTable(index)"
                                    class="p-2 border rounded-lg flex items-center hover:bg-red-100"
                                >
                                    <span class="i-solar:trash-bin-minimalistic-line-duotone !size-5"></span>
                                </button>
                            </div>


                            <ul x-sort="handle($item, index)" x-sort:group="groups" class="min-h-28 space-y-3">
                                <template x-for="guest in table" :key="guest.id">
                                    <li
                                        x-sort:item="guest.id"
                                        class="flex items-center space-x-1.5 border px-2 py-1 rounded hover:bg-gray-50 cursor-move"
                                    >
                                        <span
                                            class="i-solar-user-bold-duotone !size-4 text-gray-500 dark:text-gray-400"></span>
                                        <p x-text="`${guest.name} ${guest.family}` " class="text-sm"></p>
                                    </li>
                                </template>
                            </ul>
                        </x-filament::section>
                    </template>
                </template>
            </div>
        </div>
    </div>
</x-filament-panels::page>
