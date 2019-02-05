<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\Product::class,30)->create();
        /*
        Product::create([
            'cover' => 'https://http2.mlstatic.com/memoria-kingston-micro-sd-32gb-clase-10-full-hd-original-D_NQ_NP_22776-MLA20235319073_012015-F.jpg',
            'description' => 'La tarjeta SD Canvas Select ™ de Kingston está diseñada para ser confiable, por lo que es ideal para filmar en HD y tomar fotos de alta resolución. <br> Puedes estar seguro que sus recuerdos estarán seguros al documentar las aventuras de la vida en su apuntar y disparar la cámara.  Brinda mucho espacio para capturar un viaje completo.',
            'short_description' => 'Full HD: la interfaz UHS-I avanzada hace que la tarjeta sea ideal para calidad cinematográfica Full HD (1080p) y video 3D.',
            'name' => 'Memoria SD Kingston 32GB Canvas Selet 80R UHS-I - Negro',
            'price' => 69,
            'stock' => 10,
            'url' => 'Memoria-SD-Kingston-32GB',
            'category_id' => 7
        ]);
        Product::create([
            'cover' => 'http://halion.com.pe/wp-content/uploads/2017/03/KB-STEEL-HA-K938.jpg',
            'description' => 'sumergirte mejor en la partida o para no molestar a tu compañero de habitación, Su colores tipo arcoiris (rainbow ), su material es de metal. Cuenta con orificios de drenado en áreas designadas en el teclado para ayudar a evitar los accidentes que ocurren por derrame de líquidos. Estos teclados están diseñados para resistir horas y horas de presión, por lo que su vida útil se multiplica comparándolo con un teclado común.',
            'name' => 'TECLADO GAMER HALION STEEL HA-K938 METAL',
            'short_description' => 'Sensación de teclado mecánicoStandar',
            'price' => 120,
            'stock' => 15,
            'url' => 'TECLADO-GAMER HALION-STEEL',
            'category_id' => 1
        ]);
        Product::create([
            'cover' => 'https://www.bhphotovideo.com/images/images2500x2500/intel_bx80662i56500_i5_6500_3_60ghz_6m_processor_1178717.jpg',
            'description' => 'FAMILIA: CORE     LINEA: Procesador Core i5 S1151 7XXX - Septima Generacion     SOCKET: LGA1151 INTEL     VELOCIDAD BASE: 3.00 GHZ     VELOCIDAD DE BUS: 8 GT/S     MEMORIA CACHE: CACHE L3     6 MB     NUMERO DE NUCLEOS: 4     TDP: 65 W     CONTROLADOR DE GRAFICOS INTEGRADO: SI     TECNOLOGIA:     14 NM (NANOMETROS)     INTEL 64     INTEL AES NEW INSTRUCTIONS     INTEL ENHANCED SPEEDSTEP     INTEL IDLE STATES     INTEL SOFTWARE GUARD EXTENSIONS (INTEL SGX)     INTEL TURBO BOOST 2.0     INTEL VIRTUALIZATION (VT-X)     INTEL VIRTUALIZATION FOR DIRECTED I/O (VT-D)     INTEL VT-X WITH EXTENDED PAGE TABLES (EPT)     OS GUARD     SECURE KEY     THERMAL MONITORING     PRESENTACION: CAJA     CONTENIDO:     ETIQUETA CON LOGO     FAN - COOLER     MANUAL DE INSTALACION     COMENTARIO: INTEGRA INTEL HD GRAPHICS 630',
            'short_description' => 'FAMILIA: CORE  LINEA: Procesador Core i5 S1151 7XXX',
            'name' => 'Procesador Intel Core I5-7400, 3.00 GHz, 6 MB Caché L3, LGA1151, 65W',
            'price' => 950,
            'stock' => 15,
            'url' => 'Procesador-Intel-Core-I5',
            'category_id' => 8
        ]);
        Product::create([
            'cover' => 'http://decoraciondormitorios.net/wp-content/uploads/2012/08/Accesorios-para-laptop.jpg',
            'description' => 'todo los tipos ',
            'short_description' => 'todo los tipos ',
            'name' => 'accesorios para laptops',
            'price' => 100,
            'stock' => 10,
            'url' => 'accesorios-para-laptops-I5',
            'category_id' => 5
        ]);
        Product::create([
            'cover' => 'http://i.linio.com/p/5aa5d460424c4e69b37015b4a5c77bf2-product.jpg',
            'short_description' => 'Traemos para ti, la Laptop Lenovo V330-14IKB Intel Core i5 1 TB 4GB RAM - Free DOS  equipado con un procesador Intel Core i5, para todos los programas.',
            'description' => 'Este dispositivo cuenta con una pantalla de 14 pulgadas para que disfrutes los mejores videos y aplicaciones en tu equipo con Free DOS .<br>Esta portatil cuenta con una memoria de 1 TB GB y una memoria RAM de 4 GB para tus juegos y programas.<br> Este equipo esta optimizado para la eficiencia, fiabilidad y resistencia, este atractivo computador se encuentra disenado para adaptarse a sus necesidades, ofreciendo la versatilidad, funciones y eficacia que se necesitan para lograr realizar las diversas actividades que se puedan presentar en la vida diaria.<br>La Laptop Lenovo V330-14IKB Intel Core i5 1 TB 4GB RAM - Free DOS llega para sorprender a todos los usuarios y seguidores de la marca con la innovacion y tecnologia, que los caracteriza.',
            'name' => 'Laptop Lenovo V330-14IKB Intel Core i5 1TB 4GB RAM - FreeDos',
            'price' => 1499,
            'stock' => 5,
            'url' => 'laptop-lenovo-v330-14ikb-intel-core-i5-1tb-4gb-ram-freedos-wytxf9',
            'category_id' => 6
        ]);

        Product::create([
            'cover' => 'https://www.lenovo.com/medias/lenovo-laptop-v330-14-hero.png?context=bWFzdGVyfHJvb3R8NjAyMDZ8aW1hZ2UvcG5nfGg0MS9oZjcvOTU2NTQ0NjExMTI2Mi5wbmd8YTY2ZjEyNzI0MWMzOWQzYzE1N2M2YzNjODc0MjUyMWEwMzI1OGMyNWI0OTkxZDczMDJhYzEyYjkwZjM0MzU3MA',
            'short_description' => 'Con una gran relación calidad-precio sin sacrificar el rendimiento, el elegante y fiable portátil Lenovo V330 de 15.6"',
            'description' => 'Simplicidad útil para realizar tareas Con una gran relación calidad-precio sin sacrificar el rendimiento, el elegante y fiable portátil Lenovo V330 de 15.6" te ayudará a concentrarte en tu negocio. Gracias a su potente tecnología Intel®, podrás trabajar productivamente. Optimizado para la seguridad, la flexibilidad y la fiabilidad, reducirá la carga de trabajo de tu equipo de IT. Con este portátil para profesionales de los negocios, tu trabajo seguro que impresionará.',
            'name' => 'Lenovo Notebook V330-14ISK, 14", Intel Core i3-6006U 2.0GHz, 4GB DDR4, 1TB - 81AY0018LM',
            'price' => 2254,
            'stock' => 3,
            'url' => 'laptop-lenovo-v330-15ikb-156-intel-core-i5-8250u-2gb-video-8gb-ddr4-1tb-tnrigi',
            'category_id' => 6
        ]);

        Product::create([
            'cover' => 'http://i.linio.com/p/28d43e8f843ce5aebb053ef97d6f0785-product.jpg',
            'description' => 'El diseño elegante complementa sus dispositivos HP favoritos y se adapta cómodamente a cualquier lugar.<br>La conexión inalámbrica de 2,4 GHz lo mantiene conectado de forma confiable.<br>Con hasta 16 meses de uso con una sola batería AA, este mouse está diseñado para superar los límites.',
            'short_description' => 'Era hora de que sus accesorios se adaptaran a su individualidad. Le presentamos su nuevo mouse inalámbrico1, diseñado cuidadosamente para aportar su exclusivo estilo delgado a su trabajo. Es funcional. Es portátil. Es moderno. Es suyo.',
            'name' => 'Mouse Inalámbrico HP Z3700-Plata',
            'price' => 59,
            'stock' => 15,
            'url' => 'mouse-inala-mbrico-hp-z3700-plata-os4u0n',
            'category_id' => 4
        ]);

        Product::create([
            'cover' => 'http://i.linio.com/p/bde108af70b1bc3d6df45812f59d3df0-product.jpg',
            'description' => 'MOUSE Microsoft ARC Touch Wireless Negro (RVF-00052).
            Tecnología Touch completamente portátil y galardonada Llamativo y con estilo, Arc™ Touch Mouse es más que un dispositivo bonito. Con la libertad de una conexión inalámbrica y la tecnología táctil de Microsoft, podrá trabajar en los desplazamientos con total seguridad. Cúrvelo para usarlo y aplánelo para guardarlo Su diseño innovador hace de Arc Touch Mouse un mouse fácil de usar y almacenar. Cúrvelo cómodamente para empezar a utilizarlo. A continuación, deslice suavemente el dedo hacia arriba o hacia abajo en la franja táctil. Desplazamiento vertical preciso a través de sensaciones y no de una rueda La franja táctil del Arc Touch Mouse responderá con precisión a la velocidad de su movimiento. La retroalimentación de tecnología táctil le permite moverse entre documentos o páginas web tan rápido como necesite, con solo sentirlo. Información oficial https://www.microsoft.com/accessories/es-es/products/mice/arc-touch-mouse/rvf-00002#devkit-highlights',
            'short_description' => 'Tecnología Touch completamente portátil y galardonada Llamativo y con estilo, Arc™ Touch Mouse es más que un dispositivo bonito. Con la libertad de una conexión inalámbrica y la tecnología táctil de Microsoft, podrá trabajar en los desplazamientos con total seguridad. Cúrvelo para usarlo y aplánelo para guardarlo Su diseño innovador hace de Arc Touch Mouse un mouse fácil de usar y almacenar.',
            'name' => 'ARC Touch Mouse',
            'price' => 239,
            'stock' => 15,
            'url' => 'arc-touch-mouse-rzmh3m',
            'category_id' => 4
        ]);
        Product::create([
            'cover' => 'http://i.linio.com/p/509ee7cb8f2946f3be8235f8d42b8a83-product.jpg',
            'description' => 'SAMSUNG 27" LED MONITOR CON DISEÑO CURVO - LC27F591FDLXPEPanel delantero y trasero de curvatura esculpida para un diseño moderno y elegante
            Parlantes integrados y múltiples puertos para satisfacer todas tus necesidades de entretenimiento• Parlantes estéreo dobles integrados: Los parlantes dobles de 5 vatios integrados en la pantalla te permiten disfrutar de películas, juegos y contenido en línea sin necesidad de abarrotar el escritorio con cables o parlantes adicionales.• Interfaz de conexión triple: Los puertos HDMI, DP y D-sub proporcionan una interfaz de conexión múltiple de alto rendimiento que te permite conectar PC, consolas de juego, monitores adicionales y otros dispositivos con facilidad.',
            'short_description' => ' Parlantes integrados y múltiples puertos para satisfacer todas tus necesidades de entretenimiento',
            'name' => 'SAMSUNG MONITOR LED 27" CURVO HDMI VGA DISPLAY PORT - LC27F591FDLXPE',
            'price' => 1119,
            'stock' => 8,
            'url' => 'samsung-monitor-led-27-curvo-hdmi-vga-display-port-lc27f591fdlxpe-s1glic',
            'category_id' => 3
        ]);
        Product::create([
            'cover' => 'http://i.linio.com/p/e12f2f708e296f27c3a5bcd38167c532-product.jpg',
            'description' => 'El diseño elegante complementa sus dispositivos HP favoritos y se adapta cómodamente a cualquier lugar.<br>La conexión inalámbrica de 2,4 GHz lo mantiene conectado de forma confiable.<br>Con hasta 16 meses de uso con una sola batería AA, este mouse está diseñado para superar los límites.',
            'short_description' => 'Era hora de que sus accesorios se adaptaran a su individualidad. Le presentamos su nuevo mouse inalámbrico1, diseñado cuidadosamente para aportar su exclusivo estilo delgado a su trabajo. Es funcional. Es portátil. Es moderno. Es suyo.',
            'name' => 'MICROSOFT Wireless Mbl Mouse 1850 Pink Rosado - U7Z-00021',
            'price' => 69,
            'stock' => 5,
            'url' => 'microsoft-wireless-mbl-mouse-1850-pink-rosado-u7z-00021-jqlt60',
            'category_id' => 4
        ]);*/
    }
}
