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
                'name' => 'Miniatura Porsche 911 Carrera escala 1:18', 'category' => 'Miniaturas', 'brand' => 'Maisto',
                'description' => 'Miniatura em escala 1:18 do Porsche 911 Carrera, com linhas esportivas bem definidas. Peça indicada para exposição em coleção automotiva.',
                'condition' => 'excelente', 'estimated_value' => '380.00', 'asking_price' => '320.00',
                'availability' => 'venda', 'photo' => 'https://images.unsplash.com/photo-1544976494-f02017dac3ca?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Console 16 bits retrô com 2 controles', 'category' => 'Games', 'brand' => 'Nintendo',
                'description' => 'Console clássico de 16 bits acompanhado de dois controles para partidas em dupla. Um conjunto retrô para quem aprecia videogames de gerações anteriores.',
                'condition' => 'bom', 'estimated_value' => '750.00', 'asking_price' => '650.00',
                'availability' => 'troca', 'photo' => 'https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Moeda comemorativa de prata, edição limitada', 'category' => 'Moedas', 'brand' => 'Casa da Moeda',
                'description' => 'Moeda comemorativa de prata produzida em edição limitada. Uma peça numismática para ser apreciada em exposição.',
                'condition' => 'novo', 'estimated_value' => '450.00', 'asking_price' => null,
                'availability' => 'exibicao', 'photo' => 'https://images.unsplash.com/photo-1718140245037-8d02a29e425e?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Disco de vinil de jazz, edição limitada numerada', 'category' => 'Discos', 'brand' => 'Blue Note',
                'description' => 'Disco de jazz em edição limitada e numerada, voltado a quem aprecia o formato analógico. A capa e o vinil compõem uma peça especial para a coleção.',
                'condition' => 'excelente', 'estimated_value' => '520.00', 'asking_price' => '480.00',
                'availability' => 'venda', 'photo' => 'https://images.unsplash.com/photo-1598113571597-3a3d9c70b8c8?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Relógio de bolso antigo', 'category' => 'Relógios', 'brand' => 'Elgin',
                'description' => 'Relógio de bolso antigo da Elgin, com mostrador clássico e corrente. Uma peça de época para colecionadores de relojoaria.',
                'condition' => 'regular', 'estimated_value' => '900.00', 'asking_price' => '800.00',
                'availability' => 'troca', 'photo' => 'https://images.unsplash.com/photo-1644822007087-2ecf70faa15e?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Dom Casmurro, edição de colecionador capa dura', 'category' => 'Livros', 'brand' => 'Machado de Assis',
                'description' => 'Edição de colecionador de Dom Casmurro, de Machado de Assis, em capa dura. Um clássico da literatura brasileira preparado para leitura e exposição.',
                'condition' => 'excelente', 'estimated_value' => '260.00', 'asking_price' => null,
                'availability' => 'exibicao', 'photo' => 'https://images.unsplash.com/photo-1473755504818-b72b6dfdc226?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Box Sherlock Holmes, edição comemorativa', 'category' => 'Livros', 'brand' => 'Arthur Conan Doyle',
                'description' => 'Box comemorativo com obras clássicas de Sherlock Holmes, criadas por Arthur Conan Doyle. Uma edição para leitores e colecionadores de literatura policial.',
                'condition' => 'novo', 'estimated_value' => '340.00', 'asking_price' => '290.00',
                'availability' => 'venda', 'photo' => 'https://images.unsplash.com/photo-1473755504818-b72b6dfdc226?auto=format&fit=crop&w=900&q=80',
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
                ['ana_souza', 'Oi! Você aceita trocar a miniatura por um item da minha coleção?'],
                ['henry', 'Oi! Posso considerar a troca. Qual item você oferece?'],
                ['ana_souza', 'Tenho uma miniatura de moto em ótimo estado.'],
                ['henry', 'Interessante. Você pode mandar fotos e os detalhes da escala?'],
                ['ana_souza', 'Claro, envio as fotos ainda hoje.'],
            ]],
            [1, 'bruno_lima', [
                ['henry', 'Oi, o console ainda está disponível? Aceita Pix?'],
                ['bruno_lima', 'Está sim, aceito Pix. O preço pedido é R$ 650.'],
                ['henry', 'Podemos combinar em R$ 620?'],
                ['bruno_lima', 'Fechado em R$ 620. Posso enviar a chave quando combinar a retirada.'],
                ['henry', 'Perfeito, faço o Pix na hora da entrega.'],
                ['bruno_lima', 'Combinado, aviso quando estiver a caminho.'],
            ]],
            [2, 'camila_rocha', [
                ['camila_rocha', 'Oi! Tenho interesse na moeda comemorativa.'],
                ['henry', 'Olá! Podemos combinar a entrega em um local público.'],
                ['camila_rocha', 'Pode ser na praça central no sábado?'],
                ['henry', 'Pode. Te encontro perto da entrada às 10h.'],
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
            [0, 'bruno_lima', 'O nível de detalhes da miniatura em escala 1:18 ficou ótimo.'],
            [0, 'camila_rocha', 'Você sabe informar se as rodas giram livremente?'],
            [1, 'camila_rocha', 'Os dois controles acompanham o console?'],
            [2, 'diego_martins', 'A moeda tem certificado ou estojo de apresentação?'],
            [3, 'ana_souza', 'Qual é a numeração desta edição limitada?'],
            [4, 'bruno_lima', 'O mecanismo do relógio está funcionando?'],
            [5, 'diego_martins', 'A edição de Dom Casmurro tem ilustrações ou notas especiais?'],
            [6, 'ana_souza', 'Quantos volumes vêm neste box comemorativo?'],
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
