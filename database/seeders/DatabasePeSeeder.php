<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabasePeSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserPeSeeder::class,
        ]);

        $user = User::updateOrCreate([
            'country' => 'pe',
            'email' => 'paola@ambitohome.com',
        ], [
            'first_name' => 'Paola',
            'last_name' => 'Fenandez',
            'phone' => '999963705',
        ]);
        $store = Store::updateOrCreate([
            'country' => 'pe',
            'user_id' => $user->id,
        ], [
            'name' => 'Ambito Home',
            'story' => 'Ambito Perú  empezó hacer 30 años con productos para exterior, con productos para el hogar, hoteles y restaurantes, pero además grandes coberturas como minas y fábricas. Desde el 2019 ampliamos nuestra oferta, con productos como alfombras, cojinería y mantas, tanto para terraza como para interior. Además tenemos una línea de muebles importados y una línea de muebles hechos por nosotros.',
            'logo' => 'https://api.typeform.com/responses/files/1a810ec817ae8f78ab0420302964a0607f8a2b73f8e27a2587ed1d5916fbc2dc/Logotipo_2022.ai',
            'banner' => 'https://api.typeform.com/responses/files/fc4faef9fad1b8b09628d00b57bec7829f7cfd6fa001e06e06100ae540081d93/atelier_1.JPG'
        ]);
    }
}
