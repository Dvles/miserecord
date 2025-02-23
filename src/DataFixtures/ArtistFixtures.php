<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use DateTime;

class ArtistFixtures extends Fixture

{
    public function load(ObjectManager $manager): void
    {
        // Array of artist data
        $artists = [
            [
                'artistName' => 'Rudimental',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'Rudimental is a British drum and bass band known for blending electronic, soul, and jazz influences into their music. Their breakthrough came with the hit "Feel the Love," showcasing their energetic and uplifting style. The group has since become a staple in the UK dance music scene.',
                'isBand' => true
            ],
            [
                'artistName' => 'Kraftwerk',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'Kraftwerk is a German electronic band widely considered pioneers of electronic music. Their innovative sound and robotic aesthetic influenced countless genres, including synth-pop and techno. Albums like "Autobahn" and "The Man-Machine" remain groundbreaking.',
                'isBand' => true
            ],
            [
                'artistName' => 'Tommy Guerrero',
                'firstName' => 'Tommy',
                'lastName' => 'Guerrero',
                'birthDate' => new DateTime('1966-09-09'),
                'bio' => 'Tommy Guerrero is an American skateboarder and musician, blending instrumental hip-hop with laid-back, soulful guitar melodies. His music often evokes a sense of nostalgia and urban cool, making him a favorite in chillout and downtempo scenes. He first gained fame as a member of the legendary Bones Brigade skate team.',
                'isBand' => false
            ],
            [
                'artistName' => 'Flow Dan',
                'firstName' => 'Daniel',
                'lastName' => 'Lowe',
                'birthDate' => new DateTime('1987-07-03'),
                'bio' => 'Flow Dan is a British grime artist and a founding member of the influential collective Roll Deep. Known for his deep, commanding voice, he has worked with artists like The Bug and Chase & Status. His raw energy and powerful delivery make him a key figure in UK grime culture.',
                'isBand' => false
            ],
            [
                'artistName' => 'Azealia Banks',
                'firstName' => 'Azealia',
                'lastName' => 'Banks',
                'birthDate' => new DateTime('1991-05-31'),
                'bio' => 'Azealia Banks is an American rapper, singer, and songwriter known for her genre-blending music and unapologetic persona. Rising to fame with "212," she quickly made a name for herself with rapid-fire flows and bold lyricism. Her influence spans hip-hop, electronic, and house music.',
                'isBand' => false
            ],
            [
                'artistName' => 'Dam Swindle',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'Dam Swindle is a Dutch electronic duo known for their deep house, disco, and soulful house productions. Their groove-heavy sound draws inspiration from classic funk and jazz, making them a staple in the underground dance scene. They have released music on labels like Heist Recordings and Aus Music.',
                'isBand' => true
            ],
            [
                'artistName' => 'Reinel Bakole',
                'firstName' => 'Reinel',
                'lastName' => 'Bakole',
                'birthDate' => new DateTime('1994-12-14'),
                'bio' => 'Reinel Bakole is an African singer-songwriter blending afrobeats, soul, and contemporary electronic elements. Her music is deeply expressive, often exploring themes of identity and heritage. With her distinctive voice and genre-fusing approach, she is an emerging force in global music.',
                'isBand' => false
            ],
            [
                'artistName' => 'Geotheory',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'Geotheory is an electronic music producer known for his atmospheric, cinematic soundscapes. His work incorporates elements of ambient, future beats, and organic sound design, creating immersive and emotional listening experiences. His experimental approach has earned him a dedicated following in underground electronic music.',
                'isBand' => true
            ],
            [
                'artistName' => 'Little Dragon',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'Little Dragon is a Swedish electronic band blending synth-pop, R&B, and jazz influences. Fronted by the soulful vocals of Yukimi Nagano, their music is known for its dreamy production and eclectic rhythms. Over the years, they have collaborated with artists like Gorillaz, SBTRKT, and ODESZA.',
                'isBand' => true
            ],
            [
                'artistName' => 'Elias Moreno',
                'firstName' => 'Elias',
                'lastName' => 'Moreno',
                'birthDate' => new DateTime('1985-03-15'),
                'bio' => 'Elias Moreno is a Spanish guitarist and singer known for blending Latin rhythms with modern folk influences. His music combines intricate guitar work with heartfelt storytelling, drawing inspiration from traditional flamenco and contemporary indie sounds. He has captivated audiences with his dynamic live performances.',
                'isBand' => false
            ],
            
            
            [
                'artistName' => 'The Velvet Growl',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'The Velvet Growl is a dream-pop and shoegaze band known for their ethereal soundscapes and haunting melodies. Their music blends lush reverb-drenched guitars with introspective lyrics, creating a hypnotic and immersive listening experience. Their live shows are known for their atmospheric visuals and emotionally charged performances.',
                'isBand' => true
            ],
            [
                'artistName' => 'Akari Tanakii',
                'firstName' => 'Akari',
                'lastName' => 'Tanaka',
                'birthDate' => new DateTime('1998-11-30'),
                'bio' => 'Akari Tanaka is a Japanese rapper known for her fearless lyricism and unapologetic delivery. She blends sharp storytelling with hard-hitting beats, tackling themes of identity and resilience. Her sound is a fusion of old-school hip-hop and modern trap influences.',
                'isBand' => false
            ],
            [
                'artistName' => 'Zephyr Collective',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'Zephyr Collective is a progressive dub jazz ensemble pushing the boundaries of improvisation and electronic fusion. Their genre-defying sound combines deep grooves, intricate instrumentation, and hypnotic textures. Known for their experimental live sets, they create an ever-evolving sonic experience.',
                'isBand' => true
            ],
            [
                'artistName' => 'Lerato Ndlovu',
                'firstName' => 'Lerato Maya',
                'lastName' => 'Ndlovu',
                'birthDate' => new DateTime('1999-01-05'),
                'bio' => 'Lerato Ndlovu is a South African jazz and soul singer known for her rich vocals and fusion of Afro-jazz and contemporary R&B. Her music blends traditional African rhythms with modern production, creating a soulful and uplifting sound. She has quickly become a rising star in the global jazz scene.',
                'isBand' => false
            ], 
            [
                'artistName' => 'DA SHO',
                'firstName' => 'Daniella Kim',
                'lastName' => 'Shimuya',
                'birthDate' => new DateTime('2000-04-09'),
                'bio' => 'DA SHO is a Chinese indie pop artist combining lo-fi beats with heartfelt lyrics and minimalist production. Her music evokes nostalgia with dreamy melodies and introspective songwriting. With a dedicated online following, she continues to push the boundaries of bedroom pop.',
                'isBand' => false
            ],
            [
                'artistName' => 'Sophia Reyes',
                'firstName' => 'Sophia',
                'lastName' => 'Reyes',
                'birthDate' => new DateTime('1997-03-14'),
                'bio' => 'Sophia Reyes is a Mexican-American indie singer-songwriter known for her heartfelt ballads and ethereal vocal style. Her music blends folk, pop, and Latin influences, creating deeply personal and emotionally resonant songs. She has gained recognition for her poetic lyrics and delicate yet powerful voice.',
                'isBand' => false
            ],
            [
                'artistName' => 'Night Pulse',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'Night Pulse is an electronic music duo blending chillwave and downtempo with soulful vocal samples and atmospheric production. Their signature sound is cinematic and moody, drawing listeners into a world of deep, hypnotic beats. They have built a reputation for crafting late-night anthems perfect for introspective moments.',
                'isBand' => true
            ],
            
            [
                'artistName' => 'Yung KiXX',
                'firstName' => "George Junior",
                'lastName' => "Krayon",
                'birthDate' => new DateTime('2003-08-10'),
                'bio' => 'Yung KiXX, the latest winner of *Rhythm & Flow*, is a rapper known for his slick wordplay and unique ability to flip classical music samples into hard-hitting beats. His music fuses old-school lyricism with modern trap production, making him a standout voice in the new wave of hip-hop. His rapid rise has solidified him as a fresh talent to watch.',
                'isBand' => false
            ], 
            [
                'artistName' => 'Luna Jadis',
                'firstName' => "Isabelle",
                'lastName' => "Mercier",
                'birthDate' => new DateTime('1995-04-22'),
                'bio' => 'Luna Jadis is a French electro-pop sensation blending dreamy vocals with deep house and ambient textures. Her music creates a hypnotic, cinematic atmosphere, often exploring themes of love, longing, and self-discovery. With a dedicated European following, she continues to push the boundaries of electronic music.',
                'isBand' => false
            ],
            [
                'artistName' => 'The Hollow Pines',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'The Hollow Pines is a folk-rock band weaving haunting stories through melancholic melodies and raw harmonies. Their sound is steeped in nostalgia, evoking imagery of misty forests and lost love. With a deep connection to nature and storytelling, their music resonates with fans of introspective and acoustic-driven soundscapes.',
                'isBand' => true
            ],
            [
                'artistName' => 'Dante Flux',
                'firstName' => "Dante",
                'lastName' => "Ramirez",
                'birthDate' => new DateTime('1991-06-15'),
                'bio' => 'Dante Flux is a neo-soul artist whose smooth vocals and poetic lyrics bridge the gap between R&B and alternative jazz. His music is a fusion of sultry grooves, introspective storytelling, and timeless soul influences. With a sound reminiscent of D’Angelo and Frank Ocean, he’s carving his own lane in modern soul music.',
                'isBand' => false
            ],
            [
                'artistName' => 'Eclipse District',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'Eclipse District is an experimental synthwave collective known for their retro-futuristic soundscapes and neon-drenched visuals. Their music fuses cinematic synths, pulsating basslines, and nostalgic 80s influences. Their aesthetic pays homage to classic sci-fi while delivering a fresh take on electronic music.',
                'isBand' => true
            ],
            [
                'artistName' => 'Juno Starlight',
                'firstName' => "Juniper",
                'lastName' => "Hart",
                'birthDate' => new DateTime('1998-11-02'),
                'bio' => 'Juno Starlight is an indie pop artist with a cosmic aesthetic, crafting dreamy ballads about love and space travel. Her ethereal voice and lush synth-driven production create an otherworldly listening experience. Inspired by the stars, she brings a celestial touch to modern pop music.',
                'isBand' => false
            ],
            [
                'artistName' => 'Ghost Circuit',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'Ghost Circuit is a cyberpunk-inspired DJ duo blending dark techno, industrial beats, and glitchcore influences. Their music is a pulsating, high-energy mix of distorted synths and eerie vocal samples, creating an immersive club experience. With a soundscape straight out of a dystopian future, they dominate underground electronic scenes worldwide.',
                'isBand' => true
            ],
            
            [
                'artistName' => 'Malachai Blade',
                'firstName' => "Malachai",
                'lastName' => "Brooks",
                'birthDate' => new DateTime('1989-02-28'),
                'bio' => 'Malachai Blade is a powerhouse metal guitarist and vocalist known for his aggressive riffs and dystopian themes. His music fuses thrash, doom, and industrial influences, creating a dark, cinematic experience. With raw intensity and intricate compositions, he continues to push the boundaries of modern metal.',
                'isBand' => false
            ],
            
            [
                'artistName' => 'Echoes of Orion',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'Echoes of Orion is an instrumental post-rock group crafting atmospheric soundscapes inspired by astronomy and mythology. Their cinematic compositions blend soaring guitar melodies with ambient textures, creating an immersive sonic journey. Their music evokes a sense of wonder, transporting listeners to celestial realms.',
                'isBand' => true
            ],
            
            [
                'artistName' => 'Velvet Hush',
                'firstName' => "Mariana",
                'lastName' => "Santos",
                'birthDate' => new DateTime('1994-07-19'),
                'bio' => 'Velvet Hush is a Brazilian singer-songwriter blending bossa nova rhythms with contemporary alternative R&B. Her sultry vocals and hypnotic melodies create an intimate, soulful sound. Drawing from her Latin roots, she seamlessly merges classic Brazilian music with modern production.',
                'isBand' => false
            ],
            
            [
                'artistName' => 'Solar Flux',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'Solar Flux is an Afro-futurist electronic band merging deep house, jazz, and cosmic funk into an interstellar groove. Their music features pulsating basslines, hypnotic rhythms, and spacey synth textures. Inspired by sci-fi and Afrofuturism, they create a sound that feels both ancient and futuristic.',
                'isBand' => true
            ],
            
                [
                    'artistName' => 'Neon Mirage',
                    'firstName' => 'Jaxon',
                    'lastName' => 'Rayne',
                    'birthDate' =>  new DateTime('1991-06-15'),
                    'bio' => "Neon Mirage is the latest winner of Ru Paul's Drag rage and blends hyperpop and alternative R&B, creating a shimmering sonic landscape reminiscent of late-night city drives. With nostalgic 80s-inspired melodies and lush, atmospheric production, they transport listeners to a world of neon lights and emotional depth.",
                    'isBand' => false
                ],
                [
                    'artistName' => 'The Obsidian Owls',
                    'firstName' => null,
                    'lastName' => null,
                    'birthDate' => null,
                    'bio' => 'The Obsidian Owls are a gothic afro folk duo whose haunting melodies and poetic lyrics weave tales of mysticism, love, and tragedy. With ethereal harmonies and acoustic soundscapes, they create a moody and cinematic experience reminiscent of an old-world fairytale.',
                    'isBand' => true
                ],
                [
                    'artistName' => 'Cece',
                    'firstName' => 'Celeste',
                    'lastName' => 'Moore',
                    'birthDate' => new DateTime('1988-12-03'),
                    'bio' => 'Cece is an enigmatic alternative indie artist whose haunting voice and poetic lyricism blend. Her music delves into themes of loss, resilience, and transformation, creating a mesmerizing and emotional journey for her listeners.',
                    'isBand' => false
                ],
                [
                    'artistName' => 'T-Droplets',
                    'firstName' => null,
                    'lastName' => null,
                    'birthDate' => new DateTime('1994-09-22'),
                    'bio' => 'T-Droplets fuses global sounds with electronic production, combining tribal percussion, ambient textures, and hypnotic beats. Their music explores the intersection of ancient traditions and futuristic soundscapes, creating an immersive and meditative listening experience.',
                    'isBand' => true
                ],
                [
                    'artistName' => 'N.D.R.P',
                    'firstName' => null,
                    'lastName' => null,
                    'birthDate' => null,
                    'bio' => 'N.D.R.P is a genre-defying collective blending neo-soul, psychedelic rock, and orchestral elements into a lush, dreamlike sound. With rich instrumentation and evocative vocals, they craft sonic journeys that feel like stepping into a surreal, cinematic world.',
                    'isBand' => true
                ]
            
            
            
        ];

        // Loop through each artist and persist them
        foreach ($artists as $artistData) {
            $artist = new Artist();
            $artist->setArtistName($artistData['artistName']);
            $artist->setFirstName($artistData['firstName']);
            $artist->setLastName($artistData['lastName']);
            $artist->setBirthdate($artistData['birthDate']);
            $artist->setBio($artistData['bio']);
            $artist->setIsBand($artistData['isBand']);
            $manager->persist($artist);
        }

        // Flush to save to database
        $manager->flush();
    }
}
