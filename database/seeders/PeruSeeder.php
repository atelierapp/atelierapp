<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Product;
use App\Models\Quality;
use App\Models\Role;
use App\Models\Store;
use App\Models\User;
use App\Models\Variation;
use Bouncer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PeruSeeder extends Seeder
{
    public function run()
    {
        config(['app.country' => 'pe']);

        $items = [
            [
                'email' => 'paola@ambitohome.com',
                'first_name' => 'Paola',
                'last_name' => 'Fenandez',
                'phone' => '999963705',
                'store' => 'Ambito Home',
                'website' => 'https://www.ambitohome.com',
                'story' => 'Ambito Perú  empezó hacer 30 años con productos para exterior, con productos para el hogar, hoteles y restaurantes, pero además grandes coberturas como minas y fábricas. Desde el 2019 ampliamos nuestra oferta, con productos como alfombras, cojinería y mantas, tanto para terraza como para interior. Además tenemos una línea de muebles importados y una línea de muebles hechos por nosotros',
                'avatar' => 'stores/ambito_profile.jpg',
                'logo' => 'stores/ambito_logo.png',
                'cover' => 'stores/ambito_cover.jpg',
                'qualities' => [5],
                'products' => [
                    [
                        'id' => 1001,
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/ambito_prod1_front.jpg',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/ambito_prod1_side.jpg',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/ambito_prod1_perspective.png',
                            ],
                        ],
                    ],
                    [
                        'id' => 1002,
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/ambito_prod2_front.jpg',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/ambito_prod2_side.jpg',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/ambito_prod2_perspective.jpg',
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/ambito_prod3_front.jpg',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/ambito_prod3_side.jpg',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/ambito_prod3_perspective.jpg',
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
                'logo' => 'stores/atemporal_logo.jpg',
                'cover' => 'stores/atemporal_cover.jpg',
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/atemporal_prod1_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/atemporal_prod1_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/atemporal_prod1_perspective.png',
                            ],
                        ],
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/atemporal_prod2_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/atemporal_prod2_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/atemporal_prod2_perspective.png',
                            ],
                        ],
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/atemporal_prod3_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/atemporal_prod3_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/atemporal_prod3_perspective.png',
                            ],
                        ],
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
                'logo' => 'stores/moli_logo.jpg',
                'cover' => 'stores/moli_cover.jpg',
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/moli_prod1_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/moli_prod1_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/moli_prod1_perspective.png',
                            ],
                        ],
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/moli_prod2_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/moli_prod2_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/moli_prod2_perspective.png',
                            ],
                        ],
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/moli_prod3_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/moli_prod3_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/moli_prod3_perspective.png',
                            ],
                        ],
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
                'avatar' => 'stores/pratelli-avatar.png',
                'logo' => 'stores/pratelli-logo.png',
                'cover' => 'stores/pratelli-cover.png',
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/pratelli_prod1_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/pratelli_prod1_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/pratelli_prod1_perspective.png',
                            ],
                        ],
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/pratelli_prod2_front.jpg',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/pratelli_prod2_side.jpg',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/pratelli_prod2_perspective.jpg',
                            ],
                        ],
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/pratelli_prod3_front.jpg',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/pratelli_prod3_side.jpg',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/pratelli_prod3_perspective.jpg',
                            ],
                        ],
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
                'avatar' => 'stores/furniture_avatar.jpeg',
                'logo' => 'stores/furniture_logo.jpg',
                'cover' => 'stores/furniture_cover.jpg',
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/furniture_prod1_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/furniture_prod1_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/furniture_prod1_perspective.png',
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/furniture_prod2_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/furniture_prod2_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/furniture_prod2_perspective.png',
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/furniture_prod3_front.jpeg',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/furniture_prod3_side.jpeg',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/furniture_prod3_perspective.jpeg',
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
                'avatar' => 'stores/casa_avatar.jpg',
                'logo' => 'stores/casa_logo.jpeg',
                'cover' => 'stores/casa_cover.jpg',
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/casa_prod1_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/casa_prod1_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/casa_prod1_perspective.png',
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/casa_prod2_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/casa_prod2_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/casa_prod2_perspective.png',
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/casa_prod3_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/casa_prod3_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/casa_prod3_perspective.png',
                            ],
                        ],
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
                'avatar' => 'stores/ideas_avatar.jpg',
                'logo' => 'stores/ideas_logo.png',
                'cover' => 'stores/ideas_cover.jpg',
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/ideas_prod1_front.jpg',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/ideas_prod1_side.jpg',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/ideas_prod1_perspective.jpg',
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/ideas_prod2_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/ideas_prod2_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/ideas_prod2_perspective.png',
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/ideas_prod3_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/ideas_prod3_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/ideas_prod3_perspective.png',
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
                'avatar' => 'stores/maison_avatar.jpg',
                'logo' => null,
                'cover' => 'stores/maison_cover.jpg',
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/maison_prod1_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/maison_prod1_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/maison_prod1_perspective.png',
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/maison_prod2_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/maison_prod2_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/maison_prod2_perspective.png',
                            ],
                        ],
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/maison_prod3_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/maison_prod3_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/maison_prod3_perspective.png',
                            ],
                        ],
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
                'avatar' => null,
                'logo' => null,
                'cover' => 'stores/pieza_cover.jpeg',
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/pieza_prod1_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/pieza_prod1_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/pieza_prod1_perspective.png',
                            ],
                        ],
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/pieza_prod2_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/pieza_prod2_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/pieza_prod2_perspective.png',
                            ],
                        ],
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
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/pieza_prod3_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/pieza_prod3_side.jpg',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/pieza_prod3_perspective.jpg',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'email' => 'lizette@ventanasyestilos.com',
                'first_name' => 'Lizette',
                'last_name' => 'Goytizolo',
                'phone' => '943566497',
                'store' => 'VYE',
                'website' => 'http://www.ventanasyestilos.com',
                'story' => 'Somos una empresa con más de 12 años liderando el mercado peruano, Ventanas y Estilos pone a tu disposicion lo mas avanzado en ventaneria hermetica, sistemas de proteccion solar y soluciones innovadoraspara edificios, viviendas y oficinas.',
            ],
            [
                'email' => 'dcaceres@rollux.pe',
                'first_name' => 'Diego',
                'last_name' => 'Caceres',
                'phone' => '981481584',
                'store' => 'ROLLUX',
                'website' => 'www.rollux.pe',
                'story' => 'Con más de 15 años en el mercado internacional, Rollux® se ha consolidado como un referente en la fabricación y comercialización de cortinas, toldos arquitectónicos y persianas, gracias a una visión de excelencia en servicio y una apuesta al desarrollo de productos funcionales, innovadores y vanguardistas que marcan tendencia con los más altos estándares de calidad. Rollux® es un gran equipo humano. Un equipo experimentado y comprometido con el desarrollo de productos que entreguen múltiples propuestas de estilo, diseño y funcionalidad que cumplan con las expectativas y necesidades tanto del mercado residencial como el de oficinas. Nuestros clientes son nuestra prioridad, por lo que estamos en constante búsqueda de nuevos desafíos que nos lleven a ser aún mejores tanto en servicio como en nuestra oferta de productos y soluciones.',
            ],
            [
                'email' => 'Andre@numi.pe',
                'first_name' => 'Andre',
                'last_name' => 'Ballon',
                'phone' => '992738210',
                'store' => 'NUMI',
                'website' => 'https://numi.pe',
                'story' => null,
            ],
            [
                'email' => 'mcotillo@rivelsa.com.pe',
                'first_name' => 'Milagros',
                'last_name' => 'Cotillo',
                'phone' => '981009061',
                'store' => 'RIVELSA',
                'website' => 'https://www.rivelsa.com.pe',
                'story' => 'Rivelsa es una empresa que ofrece marcas de acabados de prestigio mundial como la marca Kohler',
            ],
            [
                'email' => 'j_ugaz@arqtelier.com',
                'first_name' => 'Jardena',
                'last_name' => 'Ugaz',
                'phone' => '930159392',
                'store' => 'ARQTELIER',
            ],
            [
                'email' => 'jruiz@nathanalfombras.com',
                'first_name' => 'Julio',
                'last_name' => 'Ruiz',
                'phone' => '934954251',
                'store' => 'NATHAN',
                'website' => 'https://www.nathanalfombras.com',
            ],
            [
                'email' => 'msantaya@meglio.com.pe',
                'first_name' => 'Mariana',
                'last_name' => 'Santaya',
                'phone' => '955438200',
                'store' => 'Euro Estilo S.A.C.',
                'website' => 'https://meglio.com.pe',
                'story' => '¿Quiénes somos? Somos una empresa que se
especializa en ofrecer los
mejores acabados.
Contamos con un staff de
profesionales expertos en el
asesoramiento al cliente.
¿Qué nos caracteriza? Nos caracterizamos por tener las últimas tendencias en los materiales que comercializamos y por brindar una asesoría personalizada al cliente desde el inicio hasta el final del proyecto.
¿Cómo lo hacemos? Reunimos las necesidades del cliente y las atendemos para hacer de cada uno de sus proyectos espacios únicos.
Brindamos un acompañamiento integral en la asesoría de materiales, formatos y diseños.',
                'avatar' => 'stores/euro_avatar.jpg',
                'logo' => 'stores/euro_logo.png',
                'cover' => 'stores/euro_cover.jpg',
                'qualities' => [5],
                'products' => [
                    [
                        'name' => 'INALCO - TOUCHÉ SUPER BLANCO GRIS (SUPERFICIE COMPACTA)',
                        'categories' => [19],
                        'price' => 203,
                        'properties' => [
                            'dimensions' => [
                                'width' => 150,
                                'height' => 320,
                                'depth' => 0,
                            ],
                        ],
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/euro_prod1_front.jpg',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/euro_prod1_side.jpg',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/euro_prod1_perspective.jpg',
                            ],
                        ],
                        'qualities' => [5],
                    ],
                    [
                        'name' => 'WOW DESIGN - STRIPES STONE GRAPHITE (CERÁMICO DE PASTA BLANCA)',
                        'categories' => [19],
                        'price' => 96,
                        'properties' => [
                            'dimensions' => [
                                'width' => 7,
                                'depth' => 2,
                                'height' => 30,
                            ],
                        ],
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/euro_prod2_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/euro_prod2_side.jpg',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/euro_prod2_perspective.jpg',
                            ],
                        ],
                    ],
                    [
                        'name' => 'PACIFIC - PREMIUM OAK (MADERA ESTRUCTURADA ACABADO LAQUEADO)',
                        'categories' => [19],
                        'price' => 123,
                        'properties' => [
                            'dimensions' => [
                                'width' => 19,
                                'height' => 190,
                                'depth' => 1,
                            ],
                        ],
                        'qualities' => [6],
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/euro_prod3_front.jpg',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/euro_prod3_side.jpg',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/euro_prod3_perspective.jpg',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'email' => 'rattanpe@gmail.com',
                'first_name' => 'Luis',
                'last_name' => 'Pais',
                'phone' => '992249464',
                'store' => 'Jaime Roberto de Rivero de la Jara SRL',
                'website' => 'https://www.robertoderivero.com.pe',
                'story' => 'Inició su taller hace 40 años y Hoy es uno de los mejores artistas en diseño y fabricación de muebles de rattan. Roberto de Rivero es una mezcla de curiosidad e inquietud. La necesidad imperiosa por mantenerse ocupado apareció en él apenas tuvo uso de razón. Dibujaba, pintaba, intervenía, creaba. Siempre se sintió el rey de las manualidades. Por ejemplo, una tarde en los setenta, cuando apenas sobrepasaba los 10 años, cayó en la cuenta de que en su jardín crecían pequeñas cañitas. Las arrancó entonces para darles forma y ponerle cargas de tinta. Al cabo de un rato ya tenía un lapicero listo para llevar al colegio. Otra tarde cogió un palo de escoba y comenzó a tallar con un cuchillo una serie de figuras en la madera. Uno, dos, diez. Sin proponérselo comenzó a vender varios de ellos. Tiempo después, recién conocería que lo que estaba fabricando ya existía y tenía el nombre de tikis, como las estatuas con gran tamaño de la Polinesia.

Ahora, ya con 65 años, Roberto no ha perdido ni una pizca de esa curiosidad, menos la vitalidad. Sus manos tampoco han dejado de crear y, al contrario, han evolucionado. El hombre de la sonrisa grande y cabellos desgobernados ha logrado formar y consolidar Rattan, un estudio-taller dedicado al arte de diseñar muebles con fibras naturales, como el propio rattan, un material noble traído de Asia. Han sido cuatro décadas de esfuerzos y pasos firmes que lo han llevado desde las lejanías de la selva peruana hasta recónditos pueblos de las Filipinas. Todo por la búsqueda de las mejores fibras naturales, siempre tratando de mejorar.',
                'logo' => 'stores/roberto_logo.jpg',
                'cover' => 'stores/roberto_cover.jpeg',
                'qualities' => [5],
                'products' => [
                    [
                        'name' => 'Sofa BORNEO',
                        'categories' => [13],
                        'price' => 4900,
                        'properties' => [
                            'dimensions' => [
                                'width' => 190,
                                'height' => 80,
                                'depth' => 80,
                            ],
                        ],
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/roberto_prod1_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/roberto_prod1_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/roberto_prod1_perspective.png',
                            ],
                        ],
                        'qualities' => [5],
                    ],
                    [
                        'name' => 'Silla Batik',
                        'categories' => [2],
                        'price' => 990,
                        'properties' => [
                            'dimensions' => [
                                'width' => 56,
                                'depth' => 65,
                                'height' => 85,
                            ],
                        ],
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/roberto_prod2_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/roberto_prod2_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/roberto_prod2_perspective.png',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Mesa Batur',
                        'categories' => [7],
                        'price' => 5900,
                        'properties' => [
                            'dimensions' => [
                                'width' => 210,
                                'height' => 75,
                                'depth' => 100,
                            ],
                        ],
                        'qualities' => [6],
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/roberto_prod3_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/roberto_prod3_side.jpg',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/roberto_prod3_perspective.png',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'email' => 'acrocce@sierramuebles.pe',
                'first_name' => 'Anahi',
                'last_name' => 'Crocce',
                'phone' => '954103990',
                'store' => 'C&P DESIGN GROUP',
                'website' => 'https://www.sierramuebles.pe',
                'story' => 'Sierra Moveis nace hace más de 30 años en Gramado, Brasil. Hace 7 años, Sierra muebles Perú tiene la representación de la marca en Lima. Importamos sus muebles y también elementos decorativos de diferentes partes del mundo. La marca tiene gran variedad de productos los cuales pueden personalizarse según tonos de madera, tipos de tela y medidas. Comenzamos en el 2015 con un pequeño showroom en una casa en san isidro y al año se abrió una segunda tienda en la av. Primavera con mucho éxito. Y al ver la necesidad de seguir creciendo (convencionalmente) nos mudamos de la casa a una tienda de poco más de 800 metros en san isidro. Nuestro producto es súper versátil, ya que pueden encontrar muebles que se ven súper elegantes (mesas de vidrio), así como muebles súper rústicos (mesas de madera, que parecen “un árbol cortado en dos”).',
                'logo' => 'stores/cp_logo.jpg',
                'cover' => 'stores/cp_cover.jpg',
                'qualities' => [5],
                'products' => [
                    [
                        'name' => 'Mesa de comedor Elo',
                        'categories' => [7],
                        'price' => 3940,
                        'properties' => [
                            'dimensions' => [
                                'width' => 260,
                                'height' => 76,
                                'depth' => 125,
                            ],
                        ],
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/cp_prod1_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/cp_prod1_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/cp_prod1_perspective.png',
                            ],
                        ],
                        'qualities' => [3],
                    ],
                    [
                        'name' => 'Sofa Lounge',
                        'categories' => [13],
                        'price' => 4240,
                        'properties' => [
                            'dimensions' => [
                                'width' => 315,
                                'depth' => 100,
                                'height' => 80,
                            ],
                        ],
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/cp_prod2_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/cp_prod2_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/cp_prod2_perspective.png',
                            ],
                        ],
                        'qualities' => [3],
                    ],
                    [
                        'name' => 'Poltrona Cleo',
                        'categories' => [2],
                        'price' => 1280,
                        'properties' => [
                            'dimensions' => [
                                'width' => 73,
                                'height' => 72,
                                'depth' => 73,
                            ],
                        ],
                        'qualities' => [6],
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/cp_prod3_front.png',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/cp_prod3_side.png',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/cp_prod3_perspective.png',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'email' => 'cdiaz@luxuryfurnitureperu.com',
                'first_name' => 'Claudia',
                'last_name' => 'Diaz',
                'phone' => '974994844',
                'store' => 'CASA100',
                'website' => 'https://www.casa100.pe',
                'story' => 'Tienda Multimarca internacional de muebles : Adriana Hoyos y Saccaro',
                'avatar' => 'stores/casa100_avatar.jpg',
                'logo' => 'stores/casa100_logo.png',
                'cover' => 'stores/casa100_cover.jpeg',
                'qualities' => [5],
                'products' => [
                    [
                        'name' => 'Carro Bar Saccaro',
                        'categories' => [3],
                        'price' => 8250,
                        'properties' => [
                            'dimensions' => [
                                'width' => 134,
                                'height' => 65,
                                'depth' => 64,
                            ],
                        ],
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/casa100_prod1_front.jpg',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/casa100_prod1_side.jpg',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/casa100_prod1_perspective.jpg',
                            ],
                        ],
                        'qualities' => [5],
                    ],
                    [
                        'name' => 'MESA ORBITA',
                        'categories' => [7],
                        'price' => 4300,
                        'properties' => [
                            'dimensions' => [
                                'width' => 90,
                                'depth' => 90,
                                'height' => 75,
                            ],
                        ],
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/casa100_prod2_front.jpg',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/casa100_prod2_side.jpg',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/casa100_prod2_perspective.jpg',
                            ],
                        ],
                        'qualities' => [5],
                    ],
                    [
                        'name' => 'MESA LATERAL SOIE',
                        'categories' => [12],
                        'price' => 3395,
                        'properties' => [
                            'dimensions' => [
                                'width' => 80,
                                'height' => 45,
                                'depth' => 25,
                            ],
                        ],
                        'qualities' => [5],
                        'images' => [
                            [
                                'orientation' => 'front',
                                'path' => 'stores/casa100_prod3_front.jpg',
                            ],
                            [
                                'orientation' => 'side',
                                'path' => 'stores/casa100_prod3_side.jpg',
                            ],
                            [
                                'orientation' => 'perspective',
                                'path' => 'stores/casa100_prod3_perspective.jpg',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($items as $item) {
            $user = $this->processUser($item);
            $store = $this->processStore($user, $item);
            $store->qualities()->sync(Quality::whereIn('id', Arr::get($item, 'qualities', []))->get());

            foreach (Arr::get($item, 'products', []) as $product) {
                $prod = $this->processProduct($store, $product);
                $variation = $this->processVariation($prod);
                foreach ($product['images'] as $image) {
                    $this->processMedia($prod, $image);
                    $this->processMedia($variation, $image);
                }
                $prod->categories()->sync(Arr::get($product, 'categories'));
                $prod->qualities()->sync(Arr::get($product, 'qualities'));
            }
        }
    }

    public function processUser(array $item): User
    {
        $user = User::updateOrCreate([
            'email' => $item['email'],
        ], [
            'country' => 'pe',
            'first_name' => Str::title($item['first_name']),
            'last_name' => Str::title($item['last_name']),
            'phone' => Str::title($item['phone']),
            'password' => $item['email'],
            'avatar' => Arr::get($item, 'avatar'),
        ]);
        Bouncer::assign(Role::SELLER)->to($user);

        return $user;
    }

    public function processStore(User $user, array $item): Store
    {
        return Store::updateOrCreate([
            'user_id' => $user->id,
        ], [
            'country' => 'pe',
            'name' => $item['store'],
            'story' => Arr::get($item, 'story'),
            'website' => Arr::get($item, 'website'),
            'logo' => Arr::get($item, 'logo'),
            'cover' => Arr::get($item, 'cover'),
        ]);
    }

    public function processProduct(Store $store, array $product): Product
    {
        return Product::updateOrCreate([
            'store_id' => $store->id,
            'title' => Str::title($product['name']),
        ], [
            'title' => Str::title($product['name']),
            'price' => $product['price'],
            'properties' => $product['properties'],
        ]);
    }

    public function processVariation(Product $product): Variation
    {
        return Variation::updateOrCreate([
            'name' => $product->title,
            'product_id' => $product->id,
            'is_duplicated' => true,
        ], [
            'name' => $product->title,
        ]);
    }

    public function processMedia(Product|Variation $model, array $image)
    {
        Media::updateOrCreate([
            'mediable_type' => get_class($model),
            'mediable_id' => $model->id,
            'orientation' => $image['orientation'],
        ], [
            'url' => Storage::url($image['path']),
            'path' => $image['path'],
            'type_id' => 1,
            'featured' => $image['orientation'] == 'front',
        ]);
    }
}
