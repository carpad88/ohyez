<?php

namespace Database\Seeders;

use App\Actions\Stripe\SyncProducts;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Carlos Padilla',
            'email' => 'carpad88@gmail.com',
            'password' => config('ohyez.admin_password'),
        ]);

        User::factory()->create([
            'name' => 'Customer test',
            'email' => 'customer@example.com',
        ]);

        //        \App\Models\Event::factory()
        //            ->has(
        //                \App\Models\Invitation::factory(5)
        //                    ->hasGuests(2, ['confirmed' => false])
        //                    ->state(function (array $attributes) {
        //                        return ['status' => 'pending'];
        //                    })
        //            )
        //            ->create(['user_id' => 2]);

        collect(['b&w', 'mariposa', 'rapunzel'])
            ->each(function ($template) {
                \App\Models\Template::factory()->create(['name' => $template]);
            });

        \App\Models\Message::factory()
            ->create([
                'content' => 'Hay instantes en la vida que imaginamos, anhelamos y esperamos, uno de esos momentos esta por llegar y lo quiero compartir contigo. ',
            ]);

        (new SyncProducts)->handle();

        collect([
            ['Agregar logotipo', 'LOG'],
            ['Agregar música', 'MUS'],
            ['Mensaje de bienvenida del catálogo', 'MES'],
            ['Mensaje de bienvenida personalizado', 'MEP'],
            ['Ocultar cuenta regresiva', 'COU'],
            ['Menciones especiales', 'MEN'],
            ['Ubicaciones del evento con links', 'PLA'],
            ['Código de vestimenta', 'DRE'],
            ['Programa del evento', 'PRO'],
            ['Redes sociales (1)', 'SO1', 1],
            ['Redes sociales (2)', 'SO2', 2],
            ['Redes sociales (3)', 'SO3', 3],
            ['Mesa de regalos (1)', 'GI1', 1],
            ['Mesa de regalos (2)', 'GI2', 2],
            ['Mesa de regalos (3)', 'GI3', 3],
            ['Datos para depósito bancario', 'BAN'],
            ['Mensaje para sobre o regalo', 'ENV'],
            ['Galería de fotos (3)', 'GA3', 3],
            ['Galería de fotos (5)', 'GA5', 5],
            ['Galería de fotos (10)', 'GAL', 10],
            ['Recomendaciones (1)', 'RE1', 1],
            ['Recomendaciones (2)', 'RE2', 2],
            ['Recomendaciones (3)', 'REC', 3],
            ['Preguntas frecuentes (2)', 'FA2', 2],
            ['Preguntas frecuentes (4)', 'FA4', 4],
            ['Preguntas frecuentes (U)', 'FAQ', 15],
            ['Máximo de invitaciones (25/100)', 'I25', 25],
            ['Máximo de invitaciones (50/200)', 'I50', 50],
            ['Máximo de invitaciones (100/400)', 'INV', 100],
            ['Compartir invitación por email', 'EMA'],
            ['Confirmación de asistencia manual', 'COM'],
            ['Confirmación de asistencia automática', 'COA'],
            ['Lista de asistencia descargable en PDF', 'LIS'],
            ['Administración de mesas', 'TAB'],
            ['Descarga de pase con código personalizado', 'PAS'],
            ['Check-in de invitados con escaneo de código QR', 'CHE'],
        ])->each(function ($feature) {
            \App\Models\Feature::factory()
                ->create([
                    'name' => $feature[0],
                    'description' => $feature[0],
                    'code' => $feature[1],
                    'limit' => $feature[2] ?? null,
                ]);
        });

        $features = \App\Models\Feature::all();

        \App\Models\Product::where('name', 'Premium')
            ->first()
            ->features()
            ->attach(
                $features->whereIn('code', ['LOG', 'MUS', 'MES', 'MEP', 'COU', 'MEN', 'PLA', 'DRE', 'PRO', 'SO3',
                    'GI3', 'BAN', 'ENV', 'GAL', 'REC', 'FAQ', 'COA', 'EMA', 'INV', 'LIS', 'TAB', 'PAS', 'CHE'])
            );

        \App\Models\Product::where('name', 'Medium')
            ->first()
            ->features()
            ->attach(
                $features->whereIn('code', ['LOG', 'MES', 'MEP', 'COU', 'MEN', 'PLA', 'DRE', 'PRO', 'SO2', 'GI2',
                    'GA5', 'RE2', 'FA4', 'COM', 'I50', 'LIS'])
            );

        \App\Models\Product::where('name', 'Basic')
            ->first()
            ->features()
            ->attach(
                $features->whereIn('code', ['MES', 'SO1', 'GI1', 'GA3', 'RE1', 'FA2', 'I25'])
            );
    }
}
