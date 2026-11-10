<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Conversation;
use App\Models\Item;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ItemSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $henry = User::updateOrCreate(
            ['username' => 'henry'],
            [
                'name' => 'Henry',
                'username' => 'henry',
                'bio' => 'Colecionador de figuras e cards.',
                'avatar' => null,
                'email' => 'henry@collection.test',
                'password' => Hash::make('12345678'),
            ]
        );

        $collectors = collect([
            ['name' => 'Ana Souza', 'username' => 'ana_souza', 'email' => 'ana@collection.test', 'avatar' => 'https://i.pravatar.cc/150?img=5'],
            ['name' => 'Bruno Lima', 'username' => 'bruno_lima', 'email' => 'bruno@collection.test', 'avatar' => 'https://i.pravatar.cc/150?img=12'],
            ['name' => 'Camila Rocha', 'username' => 'camila_rocha', 'email' => 'camila@collection.test', 'avatar' => 'https://i.pravatar.cc/150?img=32'],
            ['name' => 'Diego Martins', 'username' => 'diego_martins', 'email' => 'diego@collection.test', 'avatar' => 'https://i.pravatar.cc/150?img=68'],
        ])->map(function (array $collector): User {
            return User::updateOrCreate(
                ['username' => $collector['username']],
                [
                    ...$collector,
                    'password' => Hash::make('12345678'),
                ]
            );
        })->values();

        $items = [
            [
                'name' => 'Funko Pop Goku Ultra Instinct', 'category' => 'Figuras', 'brand' => 'Funko',
                'description' => 'Figura colecionável do Goku em sua forma Ultra Instinct, com acabamento detalhado.',
                'condition' => 'excelente', 'estimated_value' => '280.00', 'asking_price' => '230.00',
                'availability' => 'venda', 'photo' => 'https://images.unsplash.com/photo-1578301978693-85fa9c0320b9?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Miniatura de Ducati', 'category' => 'Miniaturas', 'brand' => 'Ducati',
                'description' => 'Miniatura de motocicleta Ducati com pintura esportiva e detalhes bem preservados.',
                'condition' => 'bom', 'estimated_value' => '190.00', 'asking_price' => '160.00',
                'availability' => 'troca', 'photo' => 'https://images.unsplash.com/photo-1558980664-10e7170b5df9?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Baralho Pokémon 1999', 'category' => 'Cards', 'brand' => 'Pokémon',
                'description' => 'Baralho Pokémon de 1999, uma peça nostálgica para colecionadores de cartas.',
                'condition' => 'excelente', 'estimated_value' => '420.00', 'asking_price' => null,
                'availability' => 'exibicao', 'photo' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Action Figure Batman', 'category' => 'Figuras', 'brand' => 'DC Comics',
                'description' => 'Figura de ação do Batman com acessórios e detalhes inspirados no traje clássico.',
                'condition' => 'bom', 'estimated_value' => '240.00', 'asking_price' => '210.00',
                'availability' => 'venda', 'photo' => 'https://images.unsplash.com/photo-1608889825103-eb5ed706fc64?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Game Boy Advance SP', 'category' => 'Games', 'brand' => 'Nintendo',
                'description' => 'Console portátil clássico da Nintendo, com design dobrável e tela iluminada.',
                'condition' => 'excelente', 'estimated_value' => '620.00', 'asking_price' => '540.00',
                'availability' => 'venda', 'photo' => 'https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Miniatura de Castelo Medieval', 'category' => 'Miniaturas', 'brand' => 'Dungeons & Dragons',
                'description' => 'Miniatura decorativa de castelo medieval com aparência de pedra e torreões.',
                'condition' => 'novo', 'estimated_value' => '210.00', 'asking_price' => null,
                'availability' => 'exibicao', 'photo' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Set de Cards Magic', 'category' => 'Cards', 'brand' => 'Magic: The Gathering',
                'description' => 'Conjunto de cards de Magic para completar uma coleção de jogos de estratégia.',
                'condition' => 'regular', 'estimated_value' => '500.00', 'asking_price' => '430.00',
                'availability' => 'troca', 'photo' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&w=900&q=80',
            ],
        ];

        $savedItems = [];

        foreach ($items as $index => $itemData) {
            $item = Item::updateOrCreate(
                ['name' => $itemData['name']],
                [...$itemData, 'user_id' => $collectors[$index % $collectors->count()]->id]
            );
            $savedItems[] = $item;
        }

        $usersByUsername = $collectors->keyBy('username');
        $usersByUsername->put('henry', $henry);

        $likeExamples = [
            [0, 'henry'],
            [1, 'henry'],
            [2, 'ana_souza'],
            [0, 'bruno_lima'],
            [1, 'diego_martins'],
            [2, 'bruno_lima'],
            [3, 'camila_rocha'],
            [4, 'ana_souza'],
            [5, 'bruno_lima'],
            [6, 'diego_martins'],
        ];

        foreach ($likeExamples as [$itemIndex, $username]) {
            $savedItems[$itemIndex]->likes()->syncWithoutDetaching([$usersByUsername->get($username)->id]);
        }

        $savedItems[0]->saves()->syncWithoutDetaching([$henry->id]);
        $savedItems[2]->saves()->syncWithoutDetaching([$henry->id]);

        $conversationExamples = [
            [0, 'ana_souza', [
                ['ana_souza', 'Oi, você aceita troca por uma miniatura?'],
                ['henry', 'Oi! Aceito. O que você tem?'],
                ['ana_souza', 'Tenho uma miniatura de carro em ótimo estado.'],
                ['henry', 'Legal, pode me mandar uma foto?'],
            ]],
            [1, 'bruno_lima', [
                ['henry', 'Oi, ainda está disponível? Aceita Pix?'],
                ['bruno_lima', 'Está sim. Aceito Pix.'],
                ['henry', 'Consegue fazer por R$ 150?'],
                ['bruno_lima', 'Fechado por R$ 150.'],
                ['henry', 'Posso pagar hoje.'],
                ['bruno_lima', 'Combinado, te passo a chave.'],
            ]],
            [2, 'camila_rocha', [
                ['camila_rocha', 'Oi! Tenho interesse no baralho.'],
                ['henry', 'Oi! Podemos combinar a entrega.'],
                ['camila_rocha', 'Pode ser perto do metrô no sábado?'],
                ['henry', 'Pode. Te encontro na entrada às 10h.'],
                ['camila_rocha', 'Combinado, até lá!'],
            ]],
        ];

        foreach ($conversationExamples as [$itemIndex, $username, $messages]) {
            $conversation = Conversation::query()->firstOrCreate([
                'item_id' => $savedItems[$itemIndex]->id,
                'user_id' => $usersByUsername->get($username)->id,
                'buyer_id' => $henry->id,
            ]);

            foreach ($messages as [$senderUsername, $body]) {
                Message::query()->firstOrCreate([
                    'conversation_id' => $conversation->id,
                    'sender_id' => $usersByUsername->get($senderUsername)->id,
                    'body' => $body,
                ]);
            }
        }

        $examples = [
            [0, 'bruno_lima', 'A pintura ficou muito bonita nessa edição!'],
            [0, 'camila_rocha', 'Você ainda tem a caixa original?'],
            [1, 'camila_rocha', 'Essa miniatura está bem conservada.'],
            [2, 'diego_martins', 'Tenho interesse nesse baralho, principalmente pelas cartas clássicas.'],
            [3, 'ana_souza', 'Os acessórios estão inclusos?'],
            [4, 'bruno_lima', 'Esse modelo marcou minha infância.'],
            [5, 'diego_martins', 'A montagem parece muito caprichada.'],
            [6, 'ana_souza', 'Quais cartas raras acompanham o conjunto?'],
        ];

        foreach ($examples as [$itemIndex, $authorUsername, $body]) {
            Comment::firstOrCreate([
                'item_id' => $savedItems[$itemIndex]->id,
                'user_id' => $collectors->firstWhere('username', $authorUsername)->id,
                'body' => $body,
            ]);
        }
    }
}
