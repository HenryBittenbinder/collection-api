<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $news = [
            [
                'title' => 'Coleção de clássicos ganha capas de tecido em tiragem limitada',
                'summary' => 'A Editora Neblina anunciou uma nova série de romances clássicos com capas de tecido e detalhes em baixo-relevo. Cada volume terá uma arte exclusiva criada para esta coleção.',
                'body' => 'A série Biblioteca das Brumas reúne romances clássicos em edições de capa dura revestida de tecido. A primeira leva terá quatro títulos, marcadores costurados e ilustrações de abertura inéditas. A Editora Neblina informou que a tiragem será limitada e que cada exemplar receberá um número impresso na página de créditos. A coleção foi pensada para leitura e exposição, com lombadas que formam uma ilustração quando organizadas lado a lado.',
                'publisher' => 'Editora Neblina',
                'category' => 'Livros',
                'image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=1200&q=80',
                'days_ago' => 2,
            ],
            [
                'title' => 'Miniaturas de criaturas fantásticas chegam em escala de bolso',
                'summary' => 'A oficina imaginária Forja Miúda apresentou uma linha de criaturas articuladas com pintura manual. O primeiro conjunto inclui seis personagens e uma base de cenário modular.',
                'body' => 'A linha Guardiões do Vale traz seis miniaturas de criaturas fantásticas em escala compacta, com articulações nos braços e na cabeça. Cada figura acompanha uma base que pode ser conectada às demais para compor um pequeno cenário. Segundo a Forja Miúda, as peças serão produzidas em lotes numerados e terão variações sutis de pintura feitas à mão. A empresa fictícia também planeja publicar guias de conservação e montagem junto aos conjuntos.',
                'publisher' => 'Forja Miúda',
                'category' => 'Miniaturas',
                'image' => 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?auto=format&fit=crop&w=1200&q=80',
                'days_ago' => 5,
            ],
            [
                'title' => 'Série de cards ilustrados explora lendas inventadas',
                'summary' => 'O estúdio fictício Baralho Lunar revelou um conjunto de cards colecionáveis inspirado em um universo próprio. A coleção terá cartas comuns, brilhantes e algumas artes panorâmicas.',
                'body' => 'A coleção Cartógrafos da Lua apresenta personagens, locais e objetos de um mundo de fantasia criado pelo Baralho Lunar. O conjunto inicial terá 90 cards, incluindo versões com acabamento metalizado e seis ilustrações panorâmicas que se completam quando alinhadas. Os pacotes serão distribuídos em envelopes de papel com uma lista impressa de todas as cartas. O estúdio afirma que não haverá cartas exclusivas de evento, para que a coleção possa ser completada por meio dos pacotes regulares e de trocas entre colecionadores.',
                'publisher' => 'Baralho Lunar',
                'category' => 'Cards',
                'image' => 'https://images.unsplash.com/photo-1606503153255-59d8b8b821e2?auto=format&fit=crop&w=1200&q=80',
                'days_ago' => 8,
            ],
            [
                'title' => 'Quadrinho de aventura recebe edição com extras de bastidores',
                'summary' => 'A Casa do Traço vai publicar uma versão de colecionador de A Cidade Debaixo do Lago. O volume inclui estudos de personagens e comentários da equipe criativa.',
                'body' => 'A nova edição de A Cidade Debaixo do Lago reúne a aventura completa em um único volume de capa dura. O material extra apresenta esboços, páginas alternativas e notas sobre o processo de criação do cenário submerso. A Casa do Traço informa que a edição terá papel de maior gramatura e uma sobrecapa ilustrada que pode ser removida sem danificar o livro. A história acompanha uma equipe de exploradores em busca de uma cidade fictícia escondida sob as águas.',
                'publisher' => 'Casa do Traço',
                'category' => 'Quadrinhos',
                'image' => 'https://images.unsplash.com/photo-1612036782180-6f0b6cd846fe?auto=format&fit=crop&w=1200&q=80',
                'days_ago' => 11,
            ],
            [
                'title' => 'Jogo de tabuleiro ganha conjunto de peças de madeira numeradas',
                'summary' => 'A Mesa de Âmbar anunciou componentes especiais para o jogo autoral Arquipélago Errante. As peças terão cores novas e uma caixa própria para exposição.',
                'body' => 'O conjunto de expansão visual de Arquipélago Errante substitui os marcadores originais por peças de madeira torneada em cinco cores. A edição inclui uma caixa de armazenamento com divisórias, certificado numerado e um livreto com sugestões para organizar as partidas. O conteúdo não altera as regras do jogo e foi desenvolvido como complemento para quem já possui o título. A Mesa de Âmbar prevê uma tiragem curta, com reposição sujeita à disponibilidade de madeira certificada.',
                'publisher' => 'Mesa de Âmbar',
                'category' => 'Games',
                'image' => 'https://images.unsplash.com/photo-1610890716171-6b1bb98ffd09?auto=format&fit=crop&w=1200&q=80',
                'days_ago' => 14,
            ],
            [
                'title' => 'Cartuchos decorativos celebram consoles de uma era fictícia',
                'summary' => 'A Pixel de Papel criou réplicas de cartuchos para uma coleção de jogos imaginários. As peças incluem etiquetas intercambiáveis e uma estante compacta.',
                'body' => 'A coleção Memórias de 8 Bits reúne cartuchos decorativos inspirados em jogos que existem apenas no universo criado pela Pixel de Papel. Cada réplica tem uma etiqueta ilustrada, caixa protetora e ficha com uma breve descrição do jogo fictício. O primeiro lote apresenta oito modelos e uma pequena estante de papel rígido para exposição. As peças não contêm componentes eletrônicos e foram pensadas como objetos de coleção e decoração.',
                'publisher' => 'Pixel de Papel',
                'category' => 'Games',
                'image' => 'https://images.unsplash.com/photo-1592840496694-26d035b52b48?auto=format&fit=crop&w=1200&q=80',
                'days_ago' => 18,
            ],
            [
                'title' => 'Coleção de marcadores transforma mapas em pequenas gravuras',
                'summary' => 'A Oficina Ponto Norte lançou marcadores metálicos com mapas de regiões imaginárias. Cada peça acompanha um cartão contando a origem daquele lugar.',
                'body' => 'Os marcadores da série Atlas de Lugares Impossíveis trazem recortes vazados de mapas ficcionais gravados em metal leve. A coleção inaugural apresenta oito regiões, cada uma acompanhada por um cartão com nomes de rios, montanhas e cidades inventadas. A Oficina Ponto Norte recomenda guardar as peças em seus envelopes individuais para evitar riscos. O conjunto foi lançado em estojo ilustrado e também pode ser adquirido em unidades avulsas.',
                'publisher' => 'Oficina Ponto Norte',
                'category' => 'Colecionáveis',
                'image' => 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=1200&q=80',
                'days_ago' => 23,
            ],
            [
                'title' => 'Miniaturas de veículos fantásticos chegam em série numerada',
                'summary' => 'A Garagem das Nuvens apresentou veículos de uma saga original em escala reduzida. Os modelos vêm com suportes transparentes e cartões de identificação.',
                'body' => 'A série Máquinas do Horizonte inclui quatro veículos imaginários: um dirigível postal, um trem de montanha, um barco voador e uma carruagem mecânica. As miniaturas são produzidas em resina e recebem pintura em pequenas etapas, com diferenças entre unidades. Cada caixa contém suporte transparente, cartão com o nome da máquina e um número de série. A Garagem das Nuvens prevê novas peças para completar a frota ao longo dos próximos meses.',
                'publisher' => 'Garagem das Nuvens',
                'category' => 'Miniaturas',
                'image' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1200&q=80',
                'days_ago' => 29,
            ],
        ];

        foreach ($news as $article) {
            $daysAgo = $article['days_ago'];
            unset($article['days_ago']);

            News::updateOrCreate(
                ['title' => $article['title']],
                [...$article, 'published_at' => now()->subDays($daysAgo)->setTime(12, 0)]
            );
        }
    }
}
