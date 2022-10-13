<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Quality;
use App\Models\Store;
use App\Models\User;
use App\Models\Variation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DatabasePeSeeder extends Seeder
{
    public function run(): void
    {
        $locale = config('app.locale');
        $country = config('app.country');
        config(['app.locale' => 'es']);
        config(['app.country' => 'pe']);

        $this->call([
            UserPeSeeder::class,
        ]);

        $items = [
            [
                'email' => 'paola@ambitohome.com',
                'first_name' => 'Paola',
                'last_name' => 'Fenandez',
                'phone' => '999963705',
                'store' => 'Ambito Home',
                'website' => 'https://www.ambitohome.com',
                'story' => 'Ambito Perú  empezó hacer 30 años con productos para exterior, con productos para el hogar, hoteles y restaurantes, pero además grandes coberturas como minas y fábricas. Desde el 2019 ampliamos nuestra oferta, con productos como alfombras, cojinería y mantas, tanto para terraza como para interior. Además tenemos una línea de muebles importados y una línea de muebles hechos por nosotros',
                'logo' => '',
                'cover' => '',
                'qualities' => [5],
                'products' => [
                    [
                        'name' => 'alfombra de fibra natural para terraza',
                        'categories' => [18],
                        'price' => 6380,
                        'properties' => [
                            'dimensions' => [
                                'width' => 300,
                                'height' => 10,
                                'depth' => 200,
                            ],
                        ],
                    ],
                    [
                        'name' => 'mueble maia gris',
                        'categories' => [2],
                        'price' => 3115,
                        'properties' => [
                            'dimensions' => [
                                'width' => 90,
                                'depth' => 90,
                                'height' => 75,
                            ],
                        ],
                    ],
                    [
                        'name' => 'cojin de oveja',
                        'categories' => [19],
                        'price' => 315,
                        'properties' => [
                            'dimensions' => [
                                'width' => 50,
                                'height' => 15,
                                'depth' => 50,
                            ],
                        ],
                    ],
                ],
            ],
            [
                'email' => 'atemporaldyh@gmail.com',
                'first_name' => 'vielka',
                'last_name' => 'perez martínez',
                'phone' => '982003149',
                'store' => 'ATEMPORAL DECO&HOME',
                'website' => 'https://www.atemporaldyh.com/',
                'story' => '"Con gran esfuerzo, dedicación y pasión presentamos en Lima la más grande galería multimarca de diseño. Donde lo más importante eres tú, tu autenticidad y tu realidad. Para esto hemos reunido las más prestigiosas marcas internacionales referentes en diseño, calidad, confort, gran estética y lujo. Entre ellas podrás descubrir marcas como  Ligne Roset, Timothy Oulton, Eichholtz, Talenti Outdoor Living.

En Atemporal D&H podrás encontrar todo lo que necesites para tu hogar en un ambiente agradable y cómodo, donde serás atendido por un amigo, un experto, que te guiará y volverá esta experiencia en un momento para disfrutar."',
                'logo' => '',
                'cover' => '',
                'qualities' => [3],
                'products' => [
                    [
                        'name' => 'Nest Sofá - Old L M Abyss',
                        'categories' => [13],
                        'price' => 7500,
                        'properties' => [
                            'dimensions' => [
                                'width' => 225,
                                'height' => 85,
                                'depth' => 114,
                            ],
                        ],
                        'qualities' => [3],
                    ],
                    [
                        'name' => 'Sofa York',
                        'categories' => [13],
                        'price' => 6100,
                        'properties' => [
                            'dimensions' => [
                                'width' => 230,
                                'depth' => 72,
                                'height' => 95,
                            ],
                        ],
                        'qualities' => [3],
                    ],
                    [
                        'name' => 'Westminster Btn. Sofa 3S - V.C',
                        'categories' => [13],
                        'price' => 6960,
                        'properties' => [
                            'dimensions' => [
                                'width' => 242,
                                'height' => 73,
                                'depth' => 97,
                            ],
                        ],
                        'qualities' => [3],
                    ],
                ],
            ],
            [
                'email' => 'mirella@kanchastudio.com',
                'first_name' => 'Mirella',
                'last_name' => 'Solari',
                'phone' => '991661327',
                'store' => 'MOLI',
                'website' => null,
                'story' => '"MOLI aparece como una consecuencia de nuestro estudio de arquitectura (Kancha Studio) y de la idea de ofrecer piezas de menor tamaño a las que usualmente diseñamos como estudio en los proyectos de diseño que realizamos y que sirvan para complementar los trabajos que ya hacíamos y seguir experimentando a esta nueva escala.
Decidimos desde el inicio que todas las piezas fueran diseñadas y elaboradas de manera artesanal y ""lenta"" yendo un poco a contracorriente de lo que podemos encontrar normalmente disponible en otros lugares. También decidimos buscar pequeñas empresas y personas que trabajen de esta manera para hacer algunas colaboraciones y tener la certeza de que los materiales que se usaban y el proceso de fabricación iban en la misma línea de lo que planteábamos como marca; es así que empezamos a hacer pruebas con un pequeño taller de piezas metálicas, en las que cada detalle se hace a mano y pieza por pieza, buscamos colaborar con artistas de barro para la realización de las vasijas y vajilla y fuimos parte del proceso completo, pruebas de color y el largo proceso de secado; y por último, para nuestras piezas textiles, decidimos trabajar con la comunidad de Chacas en Ancash, en donde hay una larga tradición textil artesanal y un proyecto con una asociación italiana para no perder esta tradición.
Por último, también decidimos incluir piezas de artes plásticas y fotografías de artistas peruanos que admiramos y que poco a poco queremos ayudar a exponer a nuestros clientes."',
                'logo' => '',
                'cover' => '',
                'qualities' => [1],
                'products' => [
                    [
                        'name' => 'Jarrón M',
                        'categories' => [19],
                        'price' => 149,
                        'properties' => [
                            'dimensions' => [
                                'width' => 14,
                                'height' => 15,
                                'depth' => 14,
                            ],
                        ],
                        'qualities' => [1],
                    ],
                    [
                        'name' => 'Mesa O',
                        'categories' => [12],
                        'price' => 439,
                        'properties' => [
                            'dimensions' => [
                                'width' => 36,
                                'height' => 50,
                                'depth' => 36,
                            ],
                        ],
                        'qualities' => [1],
                    ],
                    [
                        'name' => 'Colgador L',
                        'categories' => [20],
                        'price' => 69,
                        'properties' => [
                            'dimensions' => [
                                'width' => 3,
                                'height' => 15,
                                'depth' => 8,
                            ],
                        ],
                        'qualities' => [1],
                    ],
                ],
            ],
            [
                'email' => 'mauricio@pratelli.com',
                'first_name' => 'Mauricio',
                'last_name' => 'Cardenal',
                'phone' => '997560010',
                'store' => 'Pratelli',
                'website' => 'https://pratelli.com/',
                'story' => '"Somos una empresa con más de 26 años de en el mercado peruano, líder en importación de artículos decorativos para el hogar. Nos hemos posicionado como una de las empresas más sólidas, de gran prestigio y credibilidad dentro del mercado nacional.

Nos dedicamos a satisfacer las demandas de nuestros clientes y además crear un vínculo de por vida, de tal manera que un cliente termina convirtiéndose en un amigo, alguien que siempre recurre a nosotros a lo largo de su vida para darle forma a su espacio. En la actualidad ofrecemos una amplia variedad de productos seleccionados con buen gusto y conocimiento de las tendencias, para atender las necesidades de todos nuestros clientes. Nuestro principal objetivo es brindar un servicio personalizado a nuestros clientes, es así que siempre encontrarán la asesoría profesional de nuestro staff de Diseñadoras de Interiores.

Jorge Cardenal fundo esta empresa en el año 1996 comenzando vendiendo solo alfombras persas pero con el pasar de los años vio un potencial en mercado decorativo y comenzó a compra artículos decorativos como esculturas de resina, cristalería y muebles. Siempre estuvo a la moda en aspectos decorativos y fue innovando sus productos en los años posteriores posesionándose como una empresa reconocida en el sector decoración.

Actualmente contamos con una gran variedad de productos que traemos de alrededor del mundo enfocándonos mayormente en el mercado brasileño el cual a sido nuestro mayor proveedor en los últimos años. Tenemos una nueva categoría de productos: cuadros decorativos."',
                'logo' => '',
                'cover' => '',
                'qualities' => [],
                'products' => [
                    [
                        'name' => 'Cuadro Al Óleo Sunrise',
                        'categories' => [19],
                        'price' => 1331,
                        'properties' => [
                            'dimensions' => [
                                'width' => 100,
                                'height' => 100,
                                'depth' => 5,
                            ],
                        ],
                        'qualities' => [],
                    ],
                    [
                        'name' => 'Cuadro Remo Gris',
                        'categories' => [19],
                        'price' => 2490,
                        'properties' => [
                            'dimensions' => [
                                'width' => 131,
                                'height' => 131,
                                'depth' => 5,
                            ],
                        ],
                        'qualities' => [],
                    ],
                    [
                        'name' => 'Cuadro Fiesta En El Puerto Costero',
                        'categories' => [19],
                        'price' => 2390,
                        'properties' => [
                            'dimensions' => [
                                'width' => 102,
                                'height' => 102,
                                'depth' => 5,
                            ],
                        ],
                        'qualities' => [],
                    ],
                ],
            ],
            [
                'email' => 'ubeoutis@casaviva.com.pe',
                'first_name' => 'ursula',
                'last_name' => 'Beoutis',
                'phone' => '942492880',
                'store' => 'International Furniture SAC ',
                'website' => 'http://www.casaviva.com.pe',
                'story' => 'somos una empresa familiar que empezó el negocio de la importación de muebles y decoración en el 2011, buscando surtir de cosas utilitarias, funcionales y de buen gusto a nuestros clientes, para el arreglo de sus hogares. Abrimos las puertas a marcas peruanas y de emprendimiento local en el 2018, ofreciendo productos hechos a mano o baja escala.',
                'logo' => '',
                'cover' => '',
                'qualities' => [3],
                'products' => [
                    [
                        'name' => 'BASE LINE SOFA',
                        'categories' => [13],
                        'price' => 2661,
                        'properties' => [
                            'dimensions' => [
                                'width' => 230,
                                'height' => 81,
                                'depth' => 98,
                            ],
                        ],
                    ],
                    [
                        'name' => 'Reflect Chair',
                        'categories' => [2],
                        'price' => 2071,
                        'properties' => [
                            'dimensions' => [
                                'width' => 66,
                                'height' => 79,
                                'depth' => 85,
                            ],
                        ],
                    ],
                    [
                        'name' => 'Remix Bunching Cocktail Table',
                        'categories' => [3],
                        'price' => 701,
                        'properties' => [
                            'dimensions' => [
                                'width' => 76,
                                'height' => 43,
                                'depth' => 76,
                            ],
                        ],
                    ],
                ],
            ],
            [
                'email' => 'romina.cooper@casadesign.com.pe',
                'first_name' => 'Romina',
                'last_name' => 'Cooper',
                'phone' => '987254181',
                'store' => 'Casa Design',
                'website' => 'https://www.casadesign.com.pe',
                'story' => 'Casa Design empieza hace 15 años como showroom para sus cliente. Para suplir los proyectos que MAri Cooper desarrollaba.  No encontraba el nivel de muebles que ella necesitaba para sus proyectos y asi decide crear su propia linea.',
                'logo' => '',
                'cover' => '',
                'qualities' => [],
                'products' => [
                    [
                        'name' => 'Banqueta Alessia',
                        'categories' => [20],
                        'price' => 2400,
                        'properties' => [
                            'dimensions' => [
                                'width' => 160,
                                'height' => 42,
                                'depth' => 50,
                            ],
                        ],
                    ],
                    [
                        'name' => 'Mesa Serbia',
                        'categories' => [3],
                        'price' => 9400,
                        'properties' => [
                            'dimensions' => [
                                'width' => 110,
                                'depth' => 42,
                                'height' => 110,
                            ],
                        ],
                    ],
                    [
                        'name' => 'Silla 0414',
                        'categories' => [2],
                        'price' => 5890,
                        'properties' => [
                            'dimensions' => [
                                'width' => 57,
                                'height' => 75,
                                'depth' => 52,
                            ],
                        ],
                        'qualities' => [6],
                    ],
                ],
            ],
            [
                'email' => 'gloriamarco@avperu.com.pe',
                'first_name' => 'Gloria',
                'last_name' => 'Marco del pont',
                'phone' => '998326907',
                'store' => 'DECORACION IDEAS Y ESTILOS SAC',
                'website' => 'https://www.dyo.com.pe',
                'story' => 'Somos una tienda de decoración, muebles acesorios decorativos y ademas de regalos que ya tiene 10 años en el mercado, hacemos una curaduría muy cuidadosa en escoger productos de todas partes del mundo, viajamos anualmente a ferias donde hacemos la búsqueda de productos.',
                'logo' => '',
                'cover' => '',
                'qualities' => [],
                'products' => [
                    [
                        'name' => 'Cojin kora',
                        'categories' => [20],
                        'price' => 605,
                        'properties' => [
                            'dimensions' => [
                                'width' => 55,
                                'height' => 55,
                                'depth' => 55,
                            ],
                        ],
                    ],
                    [
                        'name' => 'Sofa beige',
                        'categories' => [13],
                        'price' => 11269,
                        'properties' => [
                            'dimensions' => [
                                'width' => 225,
                                'depth' => 90,
                                'height' => 85,
                            ],
                        ],
                    ],
                    [
                        'name' => 'escultura Gimnasta',
                        'categories' => [19],
                        'price' => 659,
                        'properties' => [
                            'dimensions' => [
                                'width' => 35,
                                'height' => 35,
                                'depth' => 35,
                            ],
                        ],
                    ],
                ],
            ],
            [
                'email' => 'gerencia@aemaison.com',
                'first_name' => 'Jorge',
                'last_name' => 'Ferrand',
                'phone' => '962770818',
                'store' => 'aeMAISON',
                'website' => 'https://www.aemaison.pe',
                'story' => 'Somos una empresa dedicada a transformar espacios en hogares soñados. Ofrecemos la gama mas amplía de muebles y objetos decorativos de tendencia contemporánea a precios muy competitivos. Complementamos el valor de nuestra oferta ofreciendo a nuestros clientes asesoría integral y completa de manera gratuita.',
                'logo' => '',
                'cover' => '',
                'qualities' => [5],
                'products' => [
                    [
                        'name' => 'Butaca Florian',
                        'categories' => [20],
                        'price' => 1299,
                        'properties' => [
                            'dimensions' => [
                                'width' => 85,
                                'height' => 40,
                                'depth' => 55,
                            ],
                        ],
                    ],
                    [
                        'name' => 'sofa Tour',
                        'categories' => [13],
                        'price' => 2999,
                        'properties' => [
                            'dimensions' => [
                                'width' => 190,
                                'depth' => 85,
                                'height' => 40,
                            ],
                        ],
                        'qualities' => [5],
                    ],
                    [
                        'name' => 'Mesa de Centro Puy',
                        'categories' => [3],
                        'price' => 1299,
                        'properties' => [
                            'dimensions' => [
                                'width' => 80,
                                'height' => 40,
                                'depth' => 120,
                            ],
                        ],
                        'qualities' => [5],
                    ],
                ],
            ],
            [
                'email' => 'info@piezabybaum.com',
                'first_name' => 'Andrea',
                'last_name' => 'Ulloa Flores',
                'phone' => '993897079',
                'store' => 'PIEZA BY BAUM SAC',
                'website' => 'https://piezabybaum.com/',
                'story' => '"Una marca creada por nuestro estudio de arquitectura y diseño interior. Esta idea nació a raíz de no encontrar elementos funcionales de diseño en el mercado peruano.

 ¡Es así, como decidimos tomar acción! Esta es nuestra tienda virtual donde encontrarás objetos importados y otros diseñados por nosotros.
 ¡Aquí te ayudaremos a complementar y darle detalle a tus espacios con PIEZAS únicas!"',
                'logo' => '',
                'cover' => '',
                'qualities' => [5],
                'products' => [
                    [
                        'name' => 'Lego dorado',
                        'categories' => [20],
                        'price' => 75,
                        'properties' => [
                            'dimensions' => [
                                'width' => 20,
                                'height' => 2,
                                'depth' => 2,
                            ],
                        ],
                        'qualities' => [5],
                    ],
                    [
                        'name' => 'Elipse dorado',
                        'categories' => [20],
                        'price' => 54,
                        'properties' => [
                            'dimensions' => [
                                'width' => 4,
                                'depth' => 3,
                                'height' => 4,
                            ],
                        ],
                        'qualities' => [5],
                    ],
                    [
                        'name' => 'Shell',
                        'categories' => [20],
                        'price' => 60,
                        'properties' => [
                            'dimensions' => [
                                'width' => 8,
                                'height' => 4,
                                'depth' => 4,
                            ],
                        ],
                        'qualities' => [5],
                    ],
                ],
            ],
        ];

        foreach ($items as $item) {
            $user = User::updateOrCreate([
                'email' => $item['email'],
            ], [
                'country' => 'pe',
                'first_name' => Str::title($item['first_name']),
                'last_name' => Str::title($item['last_name']),
                'phone' => Str::title($item['phone']),
                'password' => $item['email'],
            ]);
            $store = Store::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'country' => 'pe',
                'name' => $item['store'],
                'story' => Arr::get($item, 'story'),
                'website' => Arr::get($item, 'website'),
                'logo' => Arr::get($item, 'logo'),
                'cover' => Arr::get($item, 'cover'),
            ]);
            $store->qualities()->sync(Quality::whereIn('id', Arr::get($item, 'qualities'))->get());

            foreach ($item['products'] as $product) {
                $prod = Product::updateOrCreate([
                    'store_id' => $store->id,
                    'title' => Str::title($product['name']),
                ], [
                    'title' => Str::title($product['name']),
                    'price' => $product['price'],
                    'properties' => $product['properties'],
                ]);
                Variation::updateOrCreate([
                    'name' => $prod->title,
                    'product_id' => $prod->id,
                    'is_duplicated' => true,
                ], [
                    'name' => $prod->title,
                ]);
                $prod->categories()->sync(Arr::get($product, 'categories'));
                $prod->qualities()->sync(Arr::get($product, 'qualities'));
            }
        }

        config(['app.locale' => $locale]);
        config(['app.country' => $country]);
    }
}
