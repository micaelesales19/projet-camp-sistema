<?php
$usuario = $_GET['id_lider'];
$id_modulo = $_GET['id_modulo'];

$pdo = new PDO("mysql:host=localhost;dbname=u301957058_campbrasil", "u301957058_camp_brasil", "campBr202@");

require_once '../../../fpdf/fpdf.php';

//require_once 'import/sistema/fpdf/fpdf.php';

$pdf = new FPDF("P", "pt", "A4");

// Dados Líder
$consultalider_sql = "SELECT * FROM lider WHERE id_lider LIKE :ID_USU";
$consultalider = $pdo->prepare($consultalider_sql);
$consultalider->bindValue(":ID_USU", $usuario);
$consultalider->execute();
$xL = $consultalider->rowCount();
$dadoslider = $consultalider->fetch(PDO::FETCH_ASSOC);

// Dados Coordenador
$consultacoordenador_sql = "SELECT * FROM coordenador WHERE id_coordenador LIKE :ID_USU";
$consultacoordenador = $pdo->prepare($consultacoordenador_sql);
$consultacoordenador->bindValue(":ID_USU", $usuario);
$consultacoordenador->execute();
$xC = $consultacoordenador->rowCount();
$dadoscoordenador = $consultacoordenador->fetch(PDO::FETCH_ASSOC);

// Dados SR
$consultasr_sql = "SELECT * FROM supervisor_local WHERE id_supervisorR LIKE :ID_USU";
$consultasr = $pdo->prepare($consultasr_sql);
$consultasr->bindValue(":ID_USU", $usuario);
$consultasr->execute();
$xSR = $consultasr->rowCount();
$dadossr = $consultasr->fetch(PDO::FETCH_ASSOC);

// Dados SE
$consultase_sql = "SELECT * FROM supervisor_regional WHERE id_supervisorEs LIKE :ID_USU";
$consultase = $pdo->prepare($consultase_sql);
$consultase->bindValue(":ID_USU", $usuario);
$consultase->execute();
$xSE = $consultase->rowCount();
$dadosse = $consultase->fetch(PDO::FETCH_ASSOC);

// Dados Direção
$consultadirecao_sql = "SELECT * FROM direcao WHERE id_direcao LIKE :ID_USU";
$consultadirecao = $pdo->prepare($consultadirecao_sql);
$consultadirecao->bindValue(":ID_USU", $usuario);
$consultadirecao->execute();
$xD = $consultadirecao->rowCount();
$dadosdirecao = $consultadirecao->fetch(PDO::FETCH_ASSOC);

$nome_usuario = "";

if ($xL == 0) {
} else {
    $nome_usuario .= $dadoslider['nome_lider'];
}

if ($xC == 0) {
} else {
    $nome_usuario .= $dadoscoordenador['nome_coordenador'];
}

if ($xSR == 0) {
} else {
    $nome_usuario .= $dadossr['nome_supervisorR'];
}

if ($xSE == 0) {
} else {
    $nome_usuario .= $dadosse['nome_supervisorE'];
}

if ($xD == 0) {
} else {
    $nome_usuario .= $dadosdirecao['nome_direcao'];
}

$consultarM_sql = "SELECT * FROM modulo WHERE id_modulo LIKE :ID";
$consultarM = $pdo->prepare($consultarM_sql);
$consultarM->bindValue(":ID", $id_modulo);
$consultarM->execute();
$modulo = $consultarM->fetch(PDO::FETCH_ASSOC);


$pdf->AddPage();

$pdf->Ln(8);
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 5, $pdf->textoUTF8("CAMP BRASIL"), 0, 1, 'C');

$pdf->Ln(8);
$pdf->Cell(0, 5, "", "B", 1, 'C');
$pdf->Ln(8);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->Cell(80, 20, $pdf->textoUTF8("Módulo:"), 0, 0, 'J');
$pdf->Cell(0, 20, $pdf->textoUTF8($modulo['nome_modulo']), 0, 1, 'J');
$pdf->Ln(8);

$pdf->Ln(300);
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 5, $pdf->textoUTF8("Máterial " . $pdf->textoUTF8($modulo['nome_modulo'])), 0, 1, 'C');
$pdf->Ln(8);
$pdf->Cell(0, 5, "", "B", 1, 'C');

// Página 2

$pdf->AddPage();

// Lição 01
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 01"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../fundo.jpg', 0, 0, 595, 842);

//Título da Lição
$pdf->Ln(2);
$pdf->SetXY(70, 30);
$pdf->SetFont('arial', 'B', 12);
$pdf->SetTextColor(168, 168, 168);
//$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(50, 20, $pdf->textoUTF8("L² - Projeto Organelas - Encontro 1"), 0, 1, 'L');
$pdf->Image('../../../dist/img/icone.png', 30, 13, -100);

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Plaqueando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("No nosso projeto organelas vamos conhecer um pouco sobre a célula humana e descobrir como ela se assemelha ao nosso grupo pequeno e à igreja que frequentamos. Vamos utilizar e conhecer alguns termos usados na Biologia celular. Quando o biólogo se prepara para analisar o sangue ou um componente, ele o coloca em uma Placa de Petri (entre 2 pedaços de vidro) essa placa é colocada no Microscópio para que seus olhos se concentrem no alvo de seu estudo."), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8("Então..., vamos plaquear! Hora de concentrar! Vamos usar umas cartas de nosso jogo e vocês vão conhecer as organelas que compõem uma célula e tentar adivinhar suas funções. Nem eu sei kkkk (brinque como se fosse jogo da memória misturado com forca. Divida em 2 times (2 forcas) ou individualmente, a cada erro 2 partes do corpo são colocadas na forca. (Vide resposta do jogo Pg.)"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Microscopiando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Ok! Já sabemos que nossas células são compostas por organelas. Cada organela tem uma função na célula e, por consequência, no nosso corpo. Agora me respondam, E os membros de nosso corpo? Será que existem membros em nosso corpo sem uma função? A Bíblia fala sobre o Corpo humano, vamos abrir em Romanos 12 3-5:"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Pois pela graça que me foi dada digo a todos vocês: ninguém tenha de si mesmo um conceito mais elevado do que deve ter; mas, pelo contrário, tenha um conceito equilibrado, de acordo com a medida da fé que Deus lhe concedeu. Assim como cada um de nós tem um corpo com muitos membros e esses membros não exercem todos a mesma função, assim também em Cristo nós, que somos muitos, formamos um corpo, e cada membro está ligado a todos os outros."), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("E então? Todos os membros tem função? A ciência dizia que o apêndice não servia para nada, era um órgão vestigial que, segundo o evolucionismo, um dia tinha servido para algo, mas perdeu sua função. Hoje cientistas descobriram a função do apêndice, programada pelo Criador - Cientistas da Universidade Duke, nos EUA, em 2007, informaram que a função do apêndice é fabricar e servir como depósito de bactérias que ajudam na digestão. Ele também possui células linfoides, que produzem anticorpos que ajudam nas defesas do organismo. Cada Membro é importante!"), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8("Agora vamos colocar a Palavra de Deus no microscópio! Vamos abrir na carta de Paulo aos Efésios que foi escrita na prisão em Roma, provavelmente no ano 62DC. Vamos ver o que as organelas tem a ver com a igreja. Vamos ler!"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->Cell(90, 10, $pdf->textoUTF8("Como prisioneiro no Senhor..."), 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Aonde estava Paulo? Como você se sentiria se fosse preso por falar de Jesus?"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->Cell(90, 10, $pdf->textoUTF8("...rogo-lhes que vivam de maneira digna da vocação que receberam."), 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Qual a nossa vocação? Para quê fomos chamados? Para discipular e ser benção para os irmãos."), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Sejam completamente humildes e dóceis, e sejam pacientes, suportando uns aos outros com amor."), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('. O que significa a palavra "SUPORTAR"? Dar suporte, sustentar, manter. (releia a passagem de uma vez) O que Paulo está querendo com a carta? Qual o foco dele? Por que? Pense, não responda! Qual o seu foco hoje? Você acha que está quente, morno ou frio em fazer o que Deus quer que você faça? Continuando...'), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Façam todo o esforço para conservar a unidade do Espírito pelo vínculo da paz. Há um só corpo e um só Espírito...'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Paulo compara a igreja em Éfeso com quê? E como deve ser esse corpo? Quando cremos, recebemos o Espírito Santo, mas cada um recebe 1 Espirito Santo diferente? São vários Espíritos? Então, estamos ligados pelo mesmo Espírito?"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('...assim como a esperança para a qual vocês foram chamados é uma só; há um só Senhor, uma só fé, um só batismo, um só Deus e Pai de todos, que é sobre todos, por meio de todos e em todos.'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Há pessoas mais especiais do que outras no corpo de Cristo? E todos pensam do mesmo jeito? Algumas vezes existem divisões por causa de doutrinas contrárias à Palavra, mas muitas vezes, são só opiniões diferentes a respeito de pontos onde a Bíblia não é muito clara ou existem preferências pessoais e algumas vezes interesses próprios. Isso é triste, mas quem é que realmente conhece os corações para julgar? Há coisas que merecem nosso foco, mais do que as diferenças? O que você acha? Como deve ser a nossa atitude diante desse versículo? Separar-se do corpo? Causar mais divisões? Ou focar na unidade e na missão do corpo? Vamos continuar... Última parte no microscópio..."), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('E a cada um de nós foi concedida a graça, conforme a medida repartida por Cristo. Por isso é que foi dito: "Quando ele subiu em triunfo às alturas, levou cativo muitos prisioneiros, e deu dons aos homens" Ef 4:1-8'), 0, 'J');


$pdf->AddPage();

$pdf->Image('../../fundo.jpg', 0, 0, 595, 842);

$pdf->Ln(13);
$pdf->SetXY(70, 30);
$pdf->SetFont('arial', 'B', 12);
$pdf->SetTextColor(168, 168, 168);
//$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(50, 20, $pdf->textoUTF8("L² - Projeto Organelas - Encontro 1"), 0, 1, 'L');
$pdf->Image('../../../dist/img/icone.png', 30, 13, -100);

$pdf->Ln(15);

$pdf->SetFont('arial', '', 9);

$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('O que nos foi concedida? O que é "graça"? O que é graça? Um favor que não merecemos! Quem reparte essa graça? O que é dado aos homens como favor não merecido? O que é um dom? Dom é uma capacidade sobrenatural, concedida por Deus, aos que creem na salvação através de Cristo, para servi-lO e ajudar os irmãos a crescerem espiritualmente.'), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8("Lembra da célula e de suas organelas?  Cada organela tem uma tarefa (Dom) na célula em prol do corpo e essa tarefa (Dom) foi programada por quem? Se uma organela parar de cumprir a sua tarefa o que acontece com o corpo todo? Então cada organela é importante?"), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8("Deus lhe deu um dom? Você tem uma tarefa no corpo de Cristo? Você sabe qual é? Vamos descobrir no próximo encontro! Vamos fazer um teste de dons! Por enquanto..."), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Estufa 1: Vai para a Estufa!'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Durante essa semana, processe os textos da Estufa, pense, faça perguntas, estude e se encha da Palavra!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Oração:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Senhor por me escolher para fazer parte do Seu corpo! Obrigado pela oportunidade de participar nos Teus planos! Me ajude a descobrir os potenciais dados pelo Senhor, para abençoar as pessoas ao meu redor!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Memo 1:'), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('"Cada um exerça o dom que recebeu para servir aos outros, administrando fielmente a graça de Deus em suas múltiplas formas." 1 Pedro 4:10'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Maker 1:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Ler o livro de Efésios todo!'), 0, 'J');


$pdf->ln(30);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Impresso por $nome_usuario", 0, 1, 'J');


// LIÇÃO 02
$pdf->AddPage();
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 02"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../fundo.jpg', 0, 0, 595, 842);

//Título da Lição
$pdf->Ln(2);
$pdf->SetXY(70, 30);
$pdf->SetFont('arial', 'B', 12);
$pdf->SetTextColor(168, 168, 168);
//$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(50, 20, $pdf->textoUTF8("L² - Projeto Organelas - Encontro 2"), 0, 1, 'L');
$pdf->Image('../../../dist/img/icone.png', 30, 13, -100);

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Plaqueando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("(Faça uma cópia das 3 folhas para cada um ou só da folha de respostas se quiser ler as perguntas para eles.)"), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8("Quem leu Efésios? Hoje vai ter prova!!! Vamos fazer um teste sobre tudo que aprendemos nos ciclos 1 e 2!!! Vou distribuir algumas folhas e vocês não podem virar até eu falar. Preparados? Brincadeira! Hoje vamos fazer um teste, mas será um teste de dons! Vamos ver que tipo de organela, tecido ou membro você é no corpo de Cristo! Na semana passada deu para ter uma ideia de que a menor das organelas é tão importante quanto todas as partes do corpo! Agora vamos descobrir o que ganhou do Senhor!!!! Vamos lá!"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Microscopiando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Hoje vocês vão para o microscópio!"), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8("Nas folhas que vocês receberam há um teste."), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8("Coloque nos quadrinhos, uma nota seguindo a regra:"), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8("3 - Se a afirmação lhe descreve de forma completa"), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8("2 - Se a afirmação descreve parte de seu comportamento"), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8("1 - Se a afirmação descreve uma pequena tendência sua"), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8("0 - Se não tem nada a ver com você"), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8("Depois faça a soma embaixo da página de teste e me diga a letra de seus 2 maiores resultados."), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8("Baixem a cabeça e vamos pedir ao Senhor que sejamos sinceros em nossas respostas e que Ele nos mostre como podemos servi-lo melhor!"), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8("(Quando todos tiverem terminado peça os resultados e revele o que significam as letras.)"), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8("P - Profecia	S - Serviço	En - Ensino	Ex - Exortação"), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8("C - Contribuição	G - Governo	M - Misericórdia"), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8("No próximo encontro vamos começar a descobrir a definição de cada dom, o que mais gosta, dificuldades, perigos e textos que falam de seu dom."), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Estufa 2:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Não esqueça seu cartão com os códigos da Estufa!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Oração:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Senhor obrigado pelos dons que o teu Espírito nos concedeu! Nos ajude a aprender como usá-los para tua glória!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Memo 1:'), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('"Cada um exerça o dom que recebeu para servir aos outros, administrando fielmente a graça de Deus em suas múltiplas formas." 1 Pedro 4:10'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Maker 1:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Efésios 1-3 vai fazer parte do jogo na semana que vem! E quem focar na leitura vai sair na frente, no jogo e na descoberta e entendimento de seu dom. Teremos perguntas sobre  Efésios e sobre a estufa das 2 semanas!'), 0, 'J');


$pdf->ln(30);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Impresso por $nome_usuario", 0, 1, 'J');

// LIÇÃO 02

// LIÇÃO 03
$pdf->AddPage();
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 03"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../fundo.jpg', 0, 0, 595, 842);

//Título da Lição
$pdf->Ln(2);
$pdf->SetXY(70, 30);
$pdf->SetFont('arial', 'B', 12);
$pdf->SetTextColor(168, 168, 168);
//$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(50, 20, $pdf->textoUTF8("L² - Projeto Organelas - Encontro 3"), 0, 1, 'L');
$pdf->Image('../../../dist/img/icone.png', 30, 13, -100);

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Plaqueando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Como cada Organela é capacitada para exercer uma função, cada um de nós é capacitado também e tem uma função no corpo. Hoje vamos começar a conhecer essas funções. (Apresentar as cartas dos dons e as das definições dos dons. Só leiam. Depois disso, brinque de jogo da memória com a forca, usando todas as cartas) Vocês querem saber o que cada dom significa? Vamos começar a colocar os dons no microscópio."), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Microscopiando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Quem fez o teste e deu Profecia? Que definição a carta deu? (Se não lembrarem, deixem que leiam a carta da profecia) Abram a Bíblia em Romanos 12:6"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("De modo que, tendo diferentes dons, segundo a graça que nos é dada, se é profecia, seja ela segundo a medida da fé."), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Todos aqui receberam dons iguais? Vocês sabiam que no hebraico a palavra "dons" deveria ser traduzida por "graças", porque ela é derivada de "Graça". O que significa graça? Então esses dons são o quê? Segundo o texto, se você tem o dom de profecia, como é esse dom?'), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Segundo a medida da fé."), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Temos todos a mesma quantidade de fé? Já viu alguém fazendo bolo? A pessoa usa medidas. Ela usa a mesma medida para todos os bolos? E ela usa a mesma medida para todos os ingredientes? Por que não? Exatamente, a pessoa que faz o bolo conhece a receita para cada bolo e conhece cada ingrediente. Deus nos conhece? Somos todos como Abraão?"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("O qual, em esperança, creu contra a esperança, tanto que ele tornou-se pai de muitas nações, conforme o que lhe fora dito: Assim será a tua descendência. Rm 4:18"), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Ou somos todos iguais a Tomé?"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Se eu não vir o sinal dos cravos em suas mãos, e não puser o meu dedo no lugar dos cravos, e não puser a minha mão no seu lado, de maneira nenhuma o crerei. Jo 20:25"), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Mas podemos crescer em fé? Sim! Como? Conhecendo a Deus, orando, crendo nos momentos difíceis! E para que o profeta precisa de fé? Para pregar a Palavra de maneira fiel e verdadeira e amorosa, sem agradar homens, nem a si mesmo, mas a Deus!"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("O profeta que tem um sonho conte o sonho; e aquele que tem a minha palavra, fale a minha palavra com verdade. Que tem a palha com o trigo? diz o Senhor. Porventura a minha palavra não é como o fogo, diz o Senhor, e como um martelo que esmiúça a pedra? Portanto, eis que eu sou contra os profetas, diz o Senhor, que furtam as minhas palavras, cada um ao seu próximo. Jr 23:28-30"), 0, 'J');

$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('arial', '', 9);
$pdf->Ln(10);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Agora vamos conhecer mais o dom da Profecia!"), 0, 'J');

$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Tem facilidade em; gosta de fazer:"), 0, 'J');

$pdf->Ln(10);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("1. Proclamar a mensagem"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Usa sua boca, sua voz para transmitir, através da Palavra de Deus, a vontade divina para as pessoas."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- É convincente no falar."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Sabe do seu poder de persuasão, e de sua capacidade de convencimento."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Sente a necessidade de transmitir a mensagem aos outros."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Tem facilidade de levar os outros a agirem."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Apela para a consciência das pessoas."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('- Sempre pergunta "por que?" quando recebe uma resposta contrária ao que deseja...'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Deve sempre ser orientado pela Bíblia e não deve exceder o que diz a Bíblia."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Sabe que serve a Deus através da pregação."), 0, 'J');

$pdf->Ln(10);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("2. Tem percepção do que se passa no coração das pessoas"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('-Tem facilidade em enxergar as coisas como certo ou errado, "branco ou preto", pecado ou não, e tem dificuldade em aceitar o meio termo.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Acredita que existe uma lógica para tudo."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Tem a capacidade de perceber o pecado de alguém em seu rosto, porque gosta de olhar bem nos olhos (investigando / inquirindo)."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Além de discernir o pecado na vida dos outros, fala claramente a respeito deles, e é usado pelo Espírito Santo para convencer as pessoas da culpa."), 0, 'J');

$pdf->Ln(10);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("3. Pioneiro: iniciador / desbravador."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("B. Seu maior prazer:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('1. Raciocinar de maneira lógica em meio a qualquer circunstância.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('2. Persuadir ou convencer os outros da verdade.'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("C. Dificuldades:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('1. Não tem tempo para se certificar / verificar detalhes.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('2. Em ser chefiado / comandado, pois trabalha e realiza melhor quando está no controle ou liderando determinada tarefa ou projeto.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('3. Não dá importância para conversas de menor importância.'), 0, 'J');

$pdf->AddPage();

$pdf->Image('../../fundo.jpg', 0, 0, 595, 842);

$pdf->Ln(13);
$pdf->SetXY(70, 30);
$pdf->SetFont('arial', 'B', 12);
$pdf->SetTextColor(168, 168, 168);
//$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(50, 20, $pdf->textoUTF8("L² - Projeto Organelas - Encontro 3"), 0, 1, 'L');
$pdf->Image('../../../dist/img/icone.png', 30, 13, -100);

$pdf->Ln(15);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("D. Perigos:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('1. Depender de seu raciocínio lógico.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('2. Depender de sua capacidade de comunicação.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('3. Depender mais de si mesmo do que do Espírito Santo.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('4. Deixar de lado os indivíduos por causa do grupo de pessoas.'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("E. Sua primeira reação diante de situações difíceis:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('1. Franqueza.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('2. Ser Brusco.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('3. Ser Firme.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('4. Às vezes precipitado .'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Tem tendência a exercer a função de pregador, evangelista, pioneiro...'), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(360, 10, $pdf->textoUTF8('Apresente o tabuleiro do jogo, se houver tempo comece a jogar, escreva em um papel onde cada um parou para continuar na próxima semana. Ef 4-6 vai fazer parte do jogo semana que vem.'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Estufa 3 e 4!'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Durante as 2 próximas semanas, ore sobre seu dom, faça perguntas, estude na Estufa 3 e se encha da Palavra!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Oração:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Senhor, ajude cada um que tem essa capacidade dada por ti a ser fiel à Tua Palavra e a transmiti-la com amor, dependendo do Senhor! Em nome de Jesus!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Memo 2:'), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('"E ele designou alguns para apóstolos, outros para profetas, outros para evangelistas, e outros para pastores e mestres, com o fim de preparar os santos para a obra do ministério, para que o corpo de Cristo seja edificado." Ef 4:11,12'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Maker 2:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Você já sabe a definição de seu dom, então seu desafio é tentar exercer seu dom de maneira prática essa semana. Registre em forma de vídeo ou texto sua experiência e traga para compartilhar!!!'), 0, 'J');

$pdf->ln(30);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Impresso por $nome_usuario", 0, 1, 'J');

// LIÇÃO 03

// LIÇÃO 04
$pdf->AddPage();
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 04"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../fundo.jpg', 0, 0, 595, 842);

//Título da Lição
$pdf->Ln(2);
$pdf->SetXY(70, 30);
$pdf->SetFont('arial', 'B', 12);
$pdf->SetTextColor(168, 168, 168);
//$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(50, 20, $pdf->textoUTF8("L² - Projeto Organelas - Encontro 4"), 0, 1, 'L');
$pdf->Image('../../../dist/img/icone.png', 30, 13, -100);

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Plaqueando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Como está seu projeto de leitura? E o Projeto Maker da prática de seu dom? (Inicie dando seu testemunho) Este é o tempo de compartilhar (Pergunte a cada um, depois ore agradecendo pelas vitórias e ore também para que aproveitem cada oportunidade de mostrar Jesus na prática através do exercício do dom.) Vamos conhecer a função de mais 1 organela do corpo de Cristo!"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Microscopiando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Nós falamos das organelas que compõe uma célula. Mas, o que são células? Como uma célula se transforma em uma mão? Ou um pulmão? Células, assim como organelas, exercem funções diferentes e compõem as estruturas dos seres vivos. Seria como a infraestrutura de nossa cidade. Me dê exemplo de coisas que são necessárias na infraestrutura de uma cidade. (Hospitais, serviço de luz, água e esgoto, escolas, policia ...) Pois é, células humanas com a mesma função, se unem, multiplicam e formam os tecidos. Vamos pegar os cards dos tipos de células e aprender? (Mostre os cards e deixe que tentem fazer os pares, se não conseguirem, revele-os). Uau! Começam a entender como funcionamos? Então, como é no corpo de Cristo? Há necessidade nos unirmos para executarmos nossas funções? Vamos conhecer mais um dom. Quem tem o dom de Serviço? Atenção agora'), 0, 'J');

$pdf->Ln(10);

$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("A. Definição:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Tem facilidade em; gosta de fazer"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("1. Atender as necessidades práticas dos outros..."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("2. Atender as necessidades materiais da Igreja e dos seus membros..."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Quando descobre alguma necessidade a ser suprida ou realizada, a pessoa com o dom de serviço usa as suas mãos para prestar socorro com o seu serviço..."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Exemplos: auxiliar na cozinha, colocar algo em ordem, consertar coisas..."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Gosta de saber os detalhes de como uma tarefa precisa ser feita."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Quase sempre trabalha às escondidas / discretamente..."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('- É sempre voluntário e ignora incômodos pessoais para ajudar...'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Realiza melhor quando enxerga o fim da tarefa..."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Normalmente usa lista de tarefas (pelo menos tem em mente uma)"), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("B. Seu maior prazer:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Agradar as pessoas procurando fazer o trabalho ou a tarefa que realmente precisa ser feita...'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("C. Dificuldades:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('1. Desanima ao perceber que está sendo "usado" por alguém insincero.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('2. Só se preocupar com tarefas e esquecer-se de outras atividades espirituais importantes...'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("D. Perigos:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Orgulhar-se das suas obras, tarefas e realizações...'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("E. Sua primeira reação diante de situações difíceis:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Desanimar...'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Agora vamos ver o que a Bíblia diz sobre a prática desse dom. Abra em Rm 12:7a:"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Se o seu dom é servir, sirva"), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Alguém tem dúvida sobre o significado do que está escrito? Tem alguma condição para servir? Está dizendo que: "Olha só coisas leves!" ou "só quando marcarem o dia do mutirão?" O que está escrito? Ok, vamos microscopiar mais, porque nós não ficamos só no que todos estão vendo, não é? Nós vamos mais fundo na Palavra! A palavra aqui é "Diaconia", que aparece em outros versículos. Por exemplo, II Tm 4:11, diz que Marcos era bom de serviço! Segundo o projeto Memo, o que precisamos para exercer um bom serviço? Abram em At 6:1-7 para ver o serviço em ação na Igreja e o resultado.'), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('"Naqueles dias, crescendo o número de discípulos, os judeus de fala grega entre eles, queixaram-se dos judeus de fala hebraica, porque suas viúvas estavam sendo esquecidas na distribuição diária de alimento.'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Que tipo de serviço era necessário nesse caso?"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Por isso, os Doze reuniram todos os discípulos e disseram: "Não é certo negligenciarmos o ministério da palavra de Deus, a fim de servir às mesas.'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Na prática, o que precisava ser feito?"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Irmãos, escolham entre vocês sete homens de bom testemunho, cheios do Espírito e de sabedoria."), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Qual foi o currículo necessário aqui? Por que precisava desse currículo para servir as mesas?"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Passaremos a eles essa tarefa e nos dedicaremos à oração e ao ministério da palavra".'), 0, 'J');

$pdf->AddPage();

$pdf->Image('../../fundo.jpg', 0, 0, 595, 842);

$pdf->Ln(13);
$pdf->SetXY(70, 30);
$pdf->SetFont('arial', 'B', 12);
$pdf->SetTextColor(168, 168, 168);
//$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(50, 20, $pdf->textoUTF8("L² - Projeto Organelas - Encontro 4"), 0, 1, 'L');
$pdf->Image('../../../dist/img/icone.png', 30, 13, -100);

$pdf->Ln(15);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Servir mesas era uma tarefa humilhante ou importante?"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Tal proposta agradou a todos. Então escolheram Estêvão, homem cheio de fé e do Espírito Santo, além de Filipe, Prócoro, Nicanor, Timom, Pármenas e Nicolau, um convertido ao judaísmo, proveniente de Antioquia. Apresentaram esses homens aos apóstolos, os quais oraram e lhes impuseram as mãos. Assim, a palavra de Deus se espalhava."), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Deu certo a decisão que eles tomaram? E se não houvesse ninguém para servir, limpando, servindo a ceia, na portaria...? Qual foi o resultado para eles?"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Crescia rapidamente o número de discípulos em Jerusalém; também um grande número de sacerdotes obedecia à fé."'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Por que até os sacerdotes se convertiam? Porque viam que a verdadeira fé é servir e não ser servido, como muitos faziam. Eles viram a Palavra na vida daqueles homens que eram conhecedores e cheios do Espírito, servindo, trabalhando duro! E fora da igreja, será que temos exemplo de serviço? Lembra da história de Marta e Maria?
"), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Marta reclamou que estava fazendo o quê sozinha? Em sua casa você pode usar seu dom? E na escola? E com amigos? Você tem usado seus dons? As vezes sente vontade de ajudar e fica com vergonha ou não quer ser diferente? (Ore, comente sobre o projeto Maker da semana, passe as regras do jogo e comece a jogar. Se não terminar, tire foto do tabuleiro e das cartas de cada um para continuarem na próxima semana.)
"), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Vai para a Estufa 3 e 4'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Receba seus códigos e faça a estufa 4!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Oração:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Senhor, nos ajude a entender nosso propósito nesse mundo a quebrar nossa timidez, e a olhar as pessoas com os teus olhos, elas precisam do Senhor como nós precisamos, queremos usar nossos dons para trazê-las até o Senhor. Em nome de Jesus!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Memo 2:'), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('"E ele designou alguns para apóstolos, outros para profetas, outros para evangelistas, e outros para pastores e mestres, com o fim de preparar os santos para a obra do ministério, para que o corpo de Cristo seja edificado." Ef 4:11,12'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Maker 2:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Para lhe ajudar com seu projeto, coloque num caderno, ideias para exercer seu dom. Divida as ideias em 4 focos: família, amigos, escola e igreja. Escolha 2 ambientes e uma ideia influenciadora para cada um e coloque em prática essa semana. Lembre de orar, e traga seu compartilhamento para o grupo! GO MAKERS!!! '), 0, 'J');

$pdf->ln(30);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Impresso por $nome_usuario", 0, 1, 'J');
// LIÇÃO 04

// LIÇÃO 05
$pdf->AddPage();
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 05"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../fundo.jpg', 0, 0, 595, 842);

//Título da Lição
$pdf->Ln(2);
$pdf->SetXY(70, 30);
$pdf->SetFont('arial', 'B', 12);
$pdf->SetTextColor(168, 168, 168);
//$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(50, 20, $pdf->textoUTF8("L² - Projeto Organelas - Encontro 5"), 0, 1, 'L');
$pdf->Image('../../../dist/img/icone.png', 30, 13, -100);

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Plaqueando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('(Peça que compartilhem como foi o projeto da semana, orem agradecendo.)  Vocês estão sendo bons Makers! Excelente! Vamos para nosso corpo humano! Cada célula tem sua função, não é? Mas quem as programou? Quem deu as ordens? Lembram qual a função e o que existe dentro do núcleo?'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Ele armazena nosso material genético, que são todas as informações que devem ser passadas adiante para que tudo funcione bem na reprodução da célula. Esse material é o DNA. É como o cérebro da célula! Mas, quem colocou as informações no DNA de cada célula para que ela cumpra seu propósito? Deus, o criador do Universo! Vamos microscopiar essa informação!'), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Microscopiando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Abram em Ef 4:15-16'), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Antes, seguindo a verdade em amor, cresçamos em tudo naquele que é a cabeça, Cristo.  Dele todo o corpo, ajustado e unido pelo auxílio de todas as juntas, cresce e edifica-se a si mesmo em amor, na medida em que cada parte realiza a sua função.'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Quem é o cabeça na igreja? Lembra que Jesus disse que Ele era o Verbo, a Palavra Viva, e sem Ele nada do que foi feito se fez? Ele é a nossa informação, nosso DNA. Depois que Ele foi para o pai, o que Ele deixou? A Palavra, escrita, e o Espírito santo que nos ajuda a entende-la.'), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8('Conforme a informação da Palavra, o DNA, vai dirigindo a minha vida e a sua. A semelhança de quem vai se formando em nós? Mas esse DNA deve ficar só conosco? Esse DNA pode ser passado adiante como na célula? Como?'), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8('O DNA deve ser passado adiante na multiplicação. UAU! Somos UM corpo! Com um cabeça! Um DNA, e nosso alvo é reproduzir a vida de Cristo nas pessoas ao nosso redor e passar o DNA de Cristo, a Palavra, adiante! Você já tinha pensado nisso antes? Você e eu temos tudo para dar certo! Você e eu somos parte de algo sobrenatural, pura ciência! Pura genialidade! Somos um corpo em constante movimento. E é por isso que você está no ciclo 3, alguém está lhe passando o DNA de Cristo, alguém cumpriu seu papel reprodutor e agora? Qual a sua missão? E o seu dom? Como usá-lo? Vamos ver mais 1 dom? Qual será? Quem obteve mais pontos no dom de Ensino?'), 0, 'J');

$pdf->Ln(10);

$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("A. Definição:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Tem facilidade em; gosta de fazer"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("1. Procura obter e armazenar informações e conhecimento para esclarecer a Verdade..."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- é capaz de passar horas e horas só estudando um determinado assunto, principalmente se for do seu interesse;"), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- é um estudioso; “um Nerd”, mas por causa do estudo tem dificuldade em investir tempo com pessoas."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("2. Compreende as verdades bíblicas, confirma a verdade através do estudo, questiona ideias e conceitos novos, organiza seus estudos em ordem, gosta de explicar um assunto detalhadamente..."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("3. Gosta de ensinar, transmitir seus conhecimentos, ajuda outros a aprenderem e até se esforça para isto."), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("B. Seu maior prazer:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Pesquisar, acumular informações e transmitir com muito esforço e detalhes para que outros aprendam.'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("C. Dificuldades:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('1. Pode se tornar muito teórico; grande ênfase na pesquisa e falta de aplicação prática.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('2. Desprezar as pessoas quando estas não conhecem ou não tem interesse pelos seus detalhes.'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("D. Perigos:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('1. Orgulhar-se do acúmulo de informações e conhecimento'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('2. Ter uma atitude de "quem sabe tudo"!'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("E. Sua primeira reação diante de situações difíceis:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('1. Intimidar-se quando o seu conhecimento for desafiado.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('2. Fechar-se e até ficar irado quando o que sabe é recusado.'), 0, 'J');

$pdf->Ln(10);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Agora vamos ver o que a Bíblia diz sobre a prática desse dom. Romanos 12:7b"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("o que ensina, dedique-se ao ensino;"), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Bom, no versículo temos um verbo, que verbo é esse? O que significa dedicar-se? É só ler a revista da EBD ou o livro da escola para dar aula? Decorar o conteúdo? Qual a capacidade que o Espírito deu a quem tem o dom de ensino? A Nerdisse! Ir fundo, fazer perguntas ao texto, pesquisar o que quer dizer no hebraico e no grego. Hj temos uma Biblioteca na Internet. Sites como Apologeta.com, Bibliaplus.org e Biblehub, que podem ajudar!'), 0, 'J');

$pdf->AddPage();

$pdf->Image('../../fundo.jpg', 0, 0, 595, 842);

$pdf->Ln(13);
$pdf->SetXY(70, 30);
$pdf->SetFont('arial', 'B', 12);
$pdf->SetTextColor(168, 168, 168);
//$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(50, 20, $pdf->textoUTF8("L² - Projeto Organelas - Encontro 5"), 0, 1, 'L');
$pdf->Image('../../../dist/img/icone.png', 30, 13, -100);

$pdf->Ln(15);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Depois, no versículo, temos um nome, Ensino. Esse nome, no grego está ligado ao verbo no sentido de ser o propósito do verbo. Então, quem ensina, deve, de fato, fazer o quê? Ensinar da melhor maneira possível. Você não pode dizer que ensinou algo se a pessoa a quem ensinou não aprendeu, certo? "), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8('Você só ensina quando há aprendizado, senão você só transmitiu, só falou! Você sabia que muitas pessoas passam a vida aprendendo a Bíblia e nunca ensinam? Elas estão praticando seu dom? E quem não estuda para ensinar? Está se dedicando? E quem ensina só uma parte do que aprendeu, só para ser sempre o sabe-tudo, e se exibir?'), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8("Está de fato ensinando? Eita Nerds! O que Deus nos dá, deve ser passado adiante! O dom de ensino é útil para ministrar aulas, dar estudos, fazer discipulado, responder questões bíblicas, etc. Você pode utilizá-lo fora da igreja também? Como? (deixe que deem ideias e usem o jogo para aprenderem com as cartas de estratégia)"), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Vai para a Estufa 5 e 6'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Não esqueça os códigos das estufas 5 e 6,  lá você aprende a estudar a Palavra sozinho tirando o máximo dela!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Oração:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Senhor, ajude aos que tem essa capacidade sobrenatural a dedicarem-se, a seus estudos na escola, e ao estudo da Palavra! Ajude-os também a serem benção para quem tem mais dificuldade em seus estudos e no estudo da Palavra. Em nome de Jesus, Amém!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Memo 2:'), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('"Por isso, pela graça que me foi dada digo a todos vocês: Ninguém tenha de si mesmo um conceito mais elevado do que deve ter; mas, ao contrário, tenha um conceito equilibrado, de acordo com a medida da fé que Deus lhe concedeu. Assim como cada um de nós tem um corpo com muitos membros e esses membros não exercem todos a mesma função" Rm 12:3-4'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Maker 2:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Continue a influenciar nos 2 ambientes que já estava e acrescente mais um ambiente nessa semana. Busque estratégias e escreva suas ideias. Estude a Estufa também, você tem o Espírito Santo para lhe ajudar a entender a Palavra. Traga para compartilhar na próxima semana! GO MAKERS!!!'), 0, 'J');


$pdf->ln(30);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Impresso por $nome_usuario", 0, 1, 'J');

// LIÇÃO 05

// LIÇÃO 06
$pdf->AddPage();
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 06"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../fundo.jpg', 0, 0, 595, 842);

//Título da Lição
$pdf->Ln(2);
$pdf->SetXY(70, 30);
$pdf->SetFont('arial', 'B', 12);
$pdf->SetTextColor(168, 168, 168);
//$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(50, 20, $pdf->textoUTF8("L² - Projeto Organelas - Encontro 6"), 0, 1, 'L');
$pdf->Image('../../../dist/img/icone.png', 30, 13, -100);

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Plaqueando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Nos encontros anteriores falamos sobre como as células formam os tecidos. Cada um na sua especialidade. Vamos aprender brincando novamente com a Memória na Forca? Temos cartas de tipos de tecido e sua função. (Brincar)"), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Pronto! Nos localizamos sobre tecidos e funções. Qual a parte do corpo mais importante para o seu perfeito funcionamento?  Todas! Na Palavra, que partes são essas? "), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Microscopiando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Vamos microscopiar o texto de I Co 12:12-25. Neste texto vamos ver também o significado de diversidade e igualdade para Deus!'), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Ora, assim como o corpo é uma unidade, embora tenha muitos membros, e todos os membros, mesmo sendo muitos, formam um só corpo, assim também com respeito a Cristo.'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Que corpo é esse? Quem é a cabeça?'), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Pois em um só corpo todos nós fomos batizados em um único Espírito: quer judeus, quer gregos, quer escravos, quer livres.'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Há diferença entre cristãos de nacionalidades diferentes? Ele vê diferenças sociais ou legais? (Naquela época os povos entravam em guerra e o povo que perdia se tornava escravo do vencedor por lei.) Gl3:28 nos diz que não há diferença entre homens e mulheres diante de Deus. Há diversidade no corpo? Há desigualdade? Há união?'), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('E a todos nós foi dado beber de um único Espírito.'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Você percebe que hoje as pessoas estão cada vez mais divididas? Essa é a vontade de Deus para os membros de Seu corpo? Onde deve estar baseada essa união? Que informações são as verdadeiras? As do nosso DNA – A Palavra! Você se acha superior ou inferior? Por que? De onde você tirou essa ideia? Você quer parar agora e orar sobre isso?'), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(360, 10, $pdf->textoUTF8('Ok! Unidos como tecidos, formamos membros que agem! Cada um na sua função! Vamos para o próximo dom - Exortação!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("A. Definição:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Tem facilidade em; gosta de fazer"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("1. Estimular a fé dos outros, levando-os a crescer espiritualmente. A maior preocupação é o crescimento espiritual. Tem sensibilidade, consegue enxergar no rosto e nas atitudes como uma pessoa mais próxima está."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("2. Tem a capacidade de chamar à atenção de alguém que esteja com problema ou em pecado, e prefere fazê-lo no privado (chamar de lado)"), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("3. É bom conselheiro em casos difíceis, orienta e exorta as pessoas a agirem corretamente."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("4. Gosta de desenvolver amizades com as pessoas; tem facilidade de perdoar."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("5. Tem ótimo controle de qualidade, gosta de fazer as tarefas dos outros dons com capricho."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("6. Não gosta de liderar, mas quando o faz, sempre faz com capricho, e com senso crítico."), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("B. Seu maior prazer:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('1. Ver o crescimento espiritual na vida das outras pessoas.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('2. Gosta de ver as tarefas e os projetos executados por outros terem sucesso.'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("C. Dificuldades:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('1. De usar as pessoas para obter resultados, manipular.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('2. Investir tempo demais com quem não quer ajuda permanente ou de verdade.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('3. Projetar-se como líder de uma situação.'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("D. Perigos:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('1. Orgulhar-se dos resultados como um mérito seu.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('2. De querer "aparecer".'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("E. Sua primeira reação diante de situações difíceis:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('1. Ficar desanimado ou frustrado quando os resultados não aparecem.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('2. Deixar de lado a pessoa que não quer crescer ou acertar.'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Vamos ver sobre a prática desse dom! Leiam II Tm 4.1-2 e respondam: Quem está falando? Com quem estão falando? Para fazer o quê? E como?"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Na presença de Deus e de Cristo Jesus, que há de julgar os vivos e os mortos por sua manifestação e por seu Reino, eu o exorto solenemente: Pregue a palavra, esteja preparado a tempo e fora de tempo, repreenda, corrija, exorte com toda a paciência e doutrina."), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Quem escreveu? Paulo; para quem? Timóteo; para que fizesse o quê? Exortasse; Como? Com paciência e doutrina (baseado na Palavra) Você já foi exortado? Como reagiu? Como geralmente as pessoas reagem quando são confrontadas? Pense: se você não sabe ser exortado, vai conseguir exortar da maneira certa?'), 0, 'J');

$pdf->AddPage();

$pdf->Image('../../fundo.jpg', 0, 0, 595, 842);

$pdf->Ln(13);
$pdf->SetXY(70, 30);
$pdf->SetFont('arial', 'B', 12);
$pdf->SetTextColor(168, 168, 168);
//$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(50, 20, $pdf->textoUTF8("L² - Projeto Organelas - Encontro 6"), 0, 1, 'L');
$pdf->Image('../../../dist/img/icone.png', 30, 13, -100);

$pdf->Ln(15);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Cuidado com o orgulho! O dom de exortação é útil para aconselhar, orientar, confrontar pecado, dar estudos bíblicos estimulando a fé, dirigir programas espirituais.'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Vai para a Estufa'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Na Estufa vamos aprender mais sobre como podemos ter humildade para exortar e ser exortado e como abençoar outros e levá-los a crescer, em amor!+'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Oração:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Senhor, tire de nosso coração todo orgulho, que pensemos de nós o que o Senhor pensa. Que somos parte do corpo e que nosso papel é cooperar para que o corpo de Cristo aja dentro de Sua vontade, mostrando Seu amor!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Memo 3:'), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('"Por isso, pela graça que me foi dada digo a todos vocês: Ninguém tenha de si mesmo um conceito mais elevado do que deve ter; mas, ao contrário, tenha um conceito equilibrado, de acordo com a medida da fé que Deus lhe concedeu. Assim como cada um de nós tem um corpo com muitos membros e esses membros não exercem todos a mesma função." Rm 12:3-4'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Maker 3:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Anote seus pedidos de oração perto de seus ambientes e preste atenção para ver as respostas de Deus e anote-as também. Esteja pronto para compartilhar, no grupo, suas estratégias para alcançar seus 3 ambientes. Por quem você tem orado e como tem sido a prática da estratégia, escolha 1 de seus irmãos de grupo para orar pelo projeto Maker dele. Go Makers!!!'), 0, 'J');


$pdf->ln(30);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Impresso por $nome_usuario", 0, 1, 'J');

// LIÇÃO 06

// LIÇÃO 07
$pdf->AddPage();
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 07"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../fundo.jpg', 0, 0, 595, 842);

//Título da Lição
$pdf->Ln(2);
$pdf->SetXY(70, 30);
$pdf->SetFont('arial', 'B', 12);
$pdf->SetTextColor(168, 168, 168);
//$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(50, 20, $pdf->textoUTF8("L² - Projeto Organelas - Encontro 7"), 0, 1, 'L');
$pdf->Image('../../../dist/img/icone.png', 30, 13, -100);

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Plaqueando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Iniciem o PG compartilhando como estão as escolhas dos ambientes, pedidos e respostas de oração e estratégias usadas para cada ambiente. Orem em duplas! Hoje vamos ver 2 dons! Quem sabe o resultado dessas contas? Junte os resultados e descubra os dons! 1=A - (4²:4) (0+1) (2.9)=(4+3) (3.5) (44:2) (10:2) (2.9) (21-7) (0+1) (2.9)="), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("O tecido muscular me lembra o primeiro dom de hoje. Esse tecido é responsável pela contração e pela distensão. Quando você está relaxado, seus músculos estão parados. Quando você fica com medo ou frio, eles se contraem. Quando se mexe eles se distendem para permitir o movimento. Assim também, para que a igreja faça determinadas obras o pessoal da contribuição tem que se mexer, se eles estão sempre parados, a obra não anda. Ou se ficarem com medo ou estiverem frios em sua fé eles não vão ajudar o corpo, só paralisar o próprio corpo. Vamos aprender!"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Microscopiando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Ok, CONTRIBUIÇÃO! Esse dom é de abrir o bolso!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("A. Definição:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Tem facilidade em; gosta de fazer"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("1. Distribuir os seus bens materiais ou suas ideias com os outros, a fim de cooperar com seus ministérios."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Reparte com simplicidade e de uma forma discreta (não gosta de aparecer)"), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Sente que há muitas coisas que não pode fazer só, mas pode ajudar outros a fazerem."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("2. Tem uma boa visão das coisas, sempre pensa em termos absolutos, pois não gosta de meio-termo. Em outras palavras, é tudo ou nada."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("3. Não gosta de detalhes, quer saber dos objetivos e resultados."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("4. Gosta dar ideias e criar conceitos, põe em prática ideias criativas."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("5. Tem sabedoria em administrar seus bens, aplicar e repartir seus recursos, dando o necessário, mas não tudo."), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("B. Seu maior prazer:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Perceber que a sua contribuição está ajudando a realizar um objetivo espiritual verdadeiro.'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("C. Dificuldades:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('1. Em se expressar e em perdoar.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('2. Pode usar as contribuições para controlar as pessoas.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('3. Dar sem sabedoria, sem ser discreto, para "aparecer".'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('4. Usar o dom para lucro pessoal ou motivos duvidosos.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('5. Medir a sua espiritualidade pelas realizações materiais.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('6. Achar que as suas ideias são sempre as melhores ou corretas.'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("D. Perigos:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('1. Orgulhar-se dos seus bens pessoais, materiais...'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('2. Pensar que seu sucesso se baseia em seus bens materiais.'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("E. Sua primeira reação diante de situações difíceis:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Fechar-se; desligar-se das pessoas.'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Romanos 12:8b"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("se é contribuir, que contribua generosamente..."), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('A melhor tradução seria'), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("contribua com simplicidade"), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Que significa isso? Como você costuma dar algo a alguém? Mostre com sua mão. (Geralmente as pessoas dão com a mão aberta para cima) Ok, agora experimente dar, com a mão virada para baixo. Qual a diferença? O que sentiu? Não dá para segurar quando você abre a mão! É difícil dar assim? UAU! Por isso Deus deu esse dom a alguns. É preciso Dar com a mão e com o coração, sem reservas e sem esperar algo em troca (2 Co 8:2) O dom de contribuição é útil para auxiliar na expansão da obra e coordenar projetos financeiros.'), 0, 'J');

$pdf->Ln(10);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Próximo dom? Governo! Os bosses! Na realidade, os direcionadores.'), 0, 'J');

$pdf->Ln(10);

$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("A. Definição:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Tem facilidade em; gosta de fazer"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("1. Orientar e coordenar as diversas fases de uma tarefa, programa, ou projeto com sucesso."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Tem visão total da tarefa a ser realizada, por isso, tem facilidade em liderar e gerenciar"), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('- É detalhista, enxerga os pontos falhos de um trabalho ou pessoas, e faz isto por "instinto".'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('- Parece ser exigente, por gostar de qualidade, mas lidera com justiça.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("2. Vive no futuro, sendo que sempre pensa bastante antes de agir."), 0, 'J');

$pdf->AddPage();

$pdf->Image('../../fundo.jpg', 0, 0, 595, 842);

$pdf->Ln(13);
$pdf->SetXY(70, 30);
$pdf->SetFont('arial', 'B', 12);
$pdf->SetTextColor(168, 168, 168);
//$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(50, 20, $pdf->textoUTF8("L² - Projeto Organelas - Encontro 7"), 0, 1, 'L');
$pdf->Image('../../../dist/img/icone.png', 30, 13, -100);

$pdf->Ln(15);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("3. Gosta de levar outros a enxergarem 1 objetivo ou ampliar a visão..."), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("B. Seu maior prazer:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Planejar, idealizar, organizar, reunir conceitos e idéias de um determinado projeto e dar-lhe uma visão geral (global).'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("C. Dificuldades:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('1. Dar ordens em vez de ir à frente.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('2. Ser manso.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('3. Falta tempo para fazer tudo o que quer fazer.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('4. Tem expectativas altas.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('5. Ignorar a importância das pessoas, conquanto que a tarefa seja feita; aproveitar-se das pessoas para alcançar objetivos; usar as pessoas como "peças".'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("D. Perigos:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Orgulhar-se da capacidade de liderança, da sua autoridade.'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("E. Sua primeira reação diante de situações difíceis:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Ficar indignado, irado...'), 0, 'J');

$pdf->Ln(10);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Romanos 12:8c'), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("se é exercer liderança, que a exerça com zelo;"), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Nos lembra o tecido nervoso. Ele processa informações e reage com direcionamentos que são distribuídos pelo corpo. Se você se corta, quem sente? Os nervos, e o que eles fazem? Levam a mensagem para o cérebro que logo distribui ordens direcionando o que o corpo precisa fazer naquela situação para se recuperar.'), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8('O que governa é o que preside. Como? (1 Ts 5:12) Com cuidado, com presteza, esforço, entusiasmo, sem parar, ...  É útil para liderar departamentos, ministérios, projetos; coordenar diversas fases de um programa; elaborar orçamentos / calendários... Agora pense, como isso pode ser usado para ganhar os de fora da igreja? Ideias? Lembram do Jogo? Vamos brincar na semana que vem!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Vai para a Estufa'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Estufas 7 vai ajudar a entender os 2 últimos dons! Não esqueçam dos códigos!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Oração:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Senhor, que aqueles que contribuem e governam o façam de acordo com a Tua vontade, seguindo Teu DNA. Que nosso testemunho dentro e fora da igreja ajude outros a serem e fazerem discípulos!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Memo 4:'), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('"Temos diferentes dons, de acordo com a graça que nos foi dada. Se alguém tem o dom de profetizar, use-o na proporção da sua fé.  Se o seu dom é servir, sirva; se é ensinar, ensine; se é dar ânimo, que assim faça; se é contribuir, que contribua generosamente; se é exercer liderança, que a exerça com zelo; se é mostrar misericórdia, que o faça com alegria." Rm 12.6-8'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Maker 4:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Ok, vocês já sabem seus dons! Mandem ver no ultimo ambiente. Criem estratégias, orem sobre elas e coloquem em prática a que o Senhor indicar! Anotem tudo! Semana que vem tem jogo! Vai ajudar em sua criatividade! Revisem o livro de efésios também! GO MAKERS!'), 0, 'J');


$pdf->ln(30);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Impresso por $nome_usuario", 0, 1, 'J');

// LIÇÃO 07

// LIÇÃO 08
$pdf->AddPage();
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 08"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../fundo.jpg', 0, 0, 595, 842);

//Título da Lição
$pdf->Ln(2);
$pdf->SetXY(70, 30);
$pdf->SetFont('arial', 'B', 12);
$pdf->SetTextColor(168, 168, 168);
//$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(50, 20, $pdf->textoUTF8("L² - Projeto Organelas - Encontro 8"), 0, 1, 'L');
$pdf->Image('../../../dist/img/icone.png', 30, 13, -100);

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Plaqueando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("(Leve alguns objetos como lápis, borracha, copo, garfo, esponja, pente) Eu trouxe aqui alguns objetos e eu quero que vocês me respondam. Qual é o melhor entre esses objetos? E qual o mais útil? Por que? (deixe que falem) Mas e se eu quiser escrever, qual o melhor? Posso escrever com o pente? Ou apagar com o lápis? E então? (repitas as primeiras perguntas) Não há melhor. Vai depender da necessidade. Todos somos diferentes, a cada um Deus deu dons diferentes, mas qual de nós é melhor? E aqueles que se sentem piores? O que deve acontecer com eles? Vamos Microscopiar!"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Microscopiando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Rm 12.8c'), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'BI', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('se é mostrar misericórdia, que o faça com alegria.'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Estes devem ser ajudados especialmente pelos que tem o dom de misericórdia! O que é misericórdia? É ter compaixão, ter o coração bom, acudir quem precisa, mesmo que seja alguém que não merece. Vamos ver esse último dom mais de perto:'), 0, 'J');

$pdf->Ln(10);

$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("A. Definição:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Tem facilidade em; gosta de fazer"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("1. Atender as necessidades emocionais e mentais dos outros, sentindo e compreendendo tais pessoas."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Tem interesse pelos sentimentos dos outros, pois procura descobrir seus problemas emocionais, passando a compreendê-los e a confortar os que estão abalados"), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Possui grande compaixão, mas ao mesmo tempo é capaz de agir com uma disposição alegre – compaixão animadora."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("2. Criar uma atmosfera de amor ao seu redor e com isto confortar e orientar com maior facilidade."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Sensível às necessidades dos outros, sendo que tem facilidade em criar empatia, mas às vezes dificuldade em fazer algo prático."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("3. Observar o caráter com precisão, preocupando-se com o ambiente emocional."), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("- Nem sempre é o primeiro a falar."), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("B. Seu maior prazer:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('- Atender e suprir de alguma forma as necessidades emocionais dos outros.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('- Saber que os problemas emocionais das pessoas foram resolvidos.'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("C. Dificuldades:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('1. Torna-se indiferente àqueles que são indiferentes às outras pessoas.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('2. Confiar muito em suas emoções e deixar de lado a razão. Dirigir a sua vida e seus conselhos só pelas emoções.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('3. Ressentir-se muito com as pessoas falsas, hipócritas.'), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8('4. Confrontar pecado.'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("D. Perigos:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Orgulhar-se da sua capacidade de compreender os outros, da sua empatia pelo próximo, de sentir com as outras pessoas.'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("E. Sua primeira reação diante de situações difíceis:"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('É ceder, entregar, abrir mão, inclusive de suas ideias e conceitos, apesar de ressentir-se com o ocorrido.'), 0, 'J');

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Aplicação: Romanos 12:8d – exercite misericórdia + com alegria. Aquele que mostra misericórdia, piedade, que pratica atos misericordiosos (Filipenses 2:27) Faça com graciosidade, alegria, sem tristeza, sem relutância (2 Coríntios 9:7) O dom de misericórdia é útil para consolar os enfermos, enlutados, idosos, pessoas excepcionais; atuar em Capelania, aconselhamento sentimental"), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Vai para a Estufa'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Continue examinando a estufa para que esteja pronto contra as falsas ideias!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Oração:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Senhor, nos ajude a usarmos os dons que nos confiou para abençoar e ganhar pessoas para o teu reino, nos faz olhar para o Teu propósito. Em nome de Jesus!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Memo 4:'), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('"Temos diferentes dons, de acordo com a graça que nos foi dada. Se alguém tem o dom de profetizar, use-o na proporção da sua fé.  Se o seu dom é servir, sirva; se é ensinar, ensine; se é dar ânimo, que assim faça; se é contribuir, que contribua generosamente; se é exercer liderança, que a exerça com zelo; se é mostrar misericórdia, que o faça com alegria." Rm 12.6-8'), 0, 'J');

$pdf->AddPage();

$pdf->Image('../../fundo.jpg', 0, 0, 595, 842);

$pdf->Ln(13);
$pdf->SetXY(70, 30);
$pdf->SetFont('arial', 'B', 12);
$pdf->SetTextColor(168, 168, 168);
//$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(50, 20, $pdf->textoUTF8("L² - Projeto Organelas - Encontro 8"), 0, 1, 'L');
$pdf->Image('../../../dist/img/icone.png', 30, 13, -100);

$pdf->Ln(15);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Maker 4:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('O projeto dessa semana é deixar o Espírito Santo agir e colocar tudo o que foi feito até aqui em oração. Fazer uma avaliação das pessoas abordadas ou por quem vocês têm orado, escolha 5 pessoas para focar em oração, podem ser de ambientes diferentes. Anote seus nomes em seu caderno e traga suas conclusões, pedidos de oração e os nomes para serem compartilhados no próximo encontro! GO MAKERS!'), 0, 'J');


$pdf->ln(30);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Impresso por $nome_usuario", 0, 1, 'J');

// LIÇÃO 08

// LIÇÃO 09
$pdf->AddPage();
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 09"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../fundo.jpg', 0, 0, 595, 842);

//Título da Lição
$pdf->Ln(2);
$pdf->SetXY(70, 30);
$pdf->SetFont('arial', 'B', 12);
$pdf->SetTextColor(168, 168, 168);
//$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(50, 20, $pdf->textoUTF8("L² - Projeto Organelas - Encontro 9"), 0, 1, 'L');
$pdf->Image('../../../dist/img/icone.png', 30, 13, -100);

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Plaqueando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Compartilhem e orem em duplas sobre o Projeto “MAKER”. Nosso DNA é carregado de características que vem de nossos pais, vocês podem compartilhar características físicas que vocês têm, que herdaram de seus pais ou avós?   (Deixe que compartilhem) Algumas pessoas também herdam talentos. Outras, tem talentos sem herdar. Podem dar um palpite do que seja um talento? Isso, algo que Deus lhe deu, próprio de você. Música, desenho, canto, gastronomia, idiomas, escrita, ... são tendências naturais. Você já descobriu algum talento seu? (Compartilhe sobre seus talentos)"), 0, 'J');
$pdf->MultiCell(360, 10, $pdf->textoUTF8("E habilidade? É diferente de talento? O que acham? Habilidades nós aprendemos. Ex: alguns tem o talento para música e tocam de ouvido, outros tocam porque aprenderam com alguém, pelo esforço. Vamos microscopiar a Palavra sobre talento em I Sm 16:15 e sobre habilidade em At 9:16-32."), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Microscopiando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('O verso 13, relata a cena do profeta Samuel ungindo a Davi como futuro Rei de Israel. Saul havia sido rejeitado por haver desobedecido a Deus, várias vezes sem mostrar arrependimento.'), 0, 'J');

$pdf->SetFont('arial', 'BI', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('E o Espírito do Senhor se retirou de Saul, e atormentava-o um espírito mau da parte do Senhor.'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Como assim? Deus enviou um demônio para atormentar Saul? A Palavra hebraica para espírito aqui pode ser traduzida como vento, sopro, influência ou mensageiro. Isso começou quando? Quando o Espírito Santo se retirou. Por que? A quem Saul havia dado ouvidos e espaço até aquele momento? O que vocês acham que ainda tinha protegido Saul? É como se Deus tivesse saído da vida de Saul e houvesse dado passagem livre para aquela influencia demoníaca. Vamos ler Tg 1:13 e 14. O espírito maligno que veio sobre ele por permissão do Senhor foi o espírito maligno de tédio, ciúme, suspeita, ódio, inveja, malícia e crueldade, que o governou durante parte de sua vida; e ao qual ele se entregou e sacrificou toda a honra a Deus, por ele.'), 0, 'J');

$pdf->SetFont('arial', 'BI', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Então os criados de Saul lhe disseram: Eis que agora o espírito mau da parte de Deus te atormenta; Diga, pois, nosso senhor a seus servos, que estão na tua presença, que busquem um homem que saiba tocar harpa, e será que, quando o espírito mau da parte de Deus vier sobre ti, então ele tocará com a sua mão, e te acharás melhor. Então Saul mandou buscar Davi. E sucedia que, quando o espírito mau da parte de Deus vinha sobre Saul, Davi tomava a harpa, e a tocava com a sua mão; então Saul sentia alívio, e se achava melhor, e o espírito mau se retirava dele.'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Davi tinha talento para tocar? Qual a sua profissão? Aprendeu de quem? Então o que seu pai fazia? Seu pai era um pastor de ovelhas, assim como seus irmãos e Davi era ainda um adolescente que estava aprendendo a habilidade de seu pai. A harpa era algo a parte, e ele era conhecido por tocar bem. Mas, nós vimos que os talentos podem ser herdados ou não, mas como isso é escolhido, ao acaso? Deus tinha um propósito para o talento de Davi? Como seria possível um menino irrelevante que nem o próprio pai valorizava ter um encontro e se tornar necessário para um rei? '), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8('Você já descobriu seus talentos? Pode pensar em como Deus quer que você o sirva usando-os? Como pode fazer discípulos com eles? Agora vamos abrir no texto de At 9:36-41'), 0, 'J');

$pdf->SetFont('arial', 'BI', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('E havia em Jope uma discípula chamada Tabita, que traduzido se diz Dorcas. Esta estava cheia de boas obras e esmolas que fazia. E aconteceu naqueles dias que, enfermando ela, morreu; e, tendo-a lavado, a depositaram num quarto alto. E, como Lida era perto de Jope, ouvindo os discípulos que Pedro estava ali, lhe mandaram dois homens, rogando-lhe que não se demorasse em vir ter com eles. E, levantando-se Pedro, foi com eles; e quando chegou o levaram ao quarto alto, e todas as viúvas o rodearam, chorando e mostrando as túnicas e roupas que Dorcas fizera quando estava com elas. Mas Pedro, fazendo sair a todos, pôs-se de joelhos e orou: e, voltando-se para o corpo, disse: Tabita, levanta-te. E ela abriu os olhos, e, vendo a Pedro, assentou-se. E ele, dando-lhe a mão, a levantou e, chamando os santos e as viúvas, apresentou-lha viva.'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Agora pensem, qual o dom de Dorcas? Por que você acha que ela tem esse dom? Que habilidade ela havia adquirido? Como ela usava a habilidade de costurar? Ela impactou pessoas com essa habilidade? Você já aprendeu alguma habilidade? Quais são as suas habilidades? Como você as tem usado? Como poderia usá-las para abençoar pessoas?'), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8('Compartilhem sobre habilidades que gostariam de aprender. (Compartilhe também) Você pode pedir dons e habilidades para Deus! E como as usaria?'), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8('Vamos ter um tempo de compartilhar sobre os nossos projetos “MAKER” e orar pelas 5 pessoas que você tem em mente!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Vai para a Estufa'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Fique sempre firme na estufa, lembre-se que a Palavra é vida, é seu alimento, sua direção! E você vai aprender muito mais sobre seus talentos e habilidades!'), 0, 'J');

$pdf->AddPage();

$pdf->Image('../../fundo.jpg', 0, 0, 595, 842);

$pdf->Ln(13);
$pdf->SetXY(70, 30);
$pdf->SetFont('arial', 'B', 12);
$pdf->SetTextColor(168, 168, 168);
//$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(50, 20, $pdf->textoUTF8("L² - Projeto Organelas - Encontro 9"), 0, 1, 'L');
$pdf->Image('../../../dist/img/icone.png', 30, 13, -100);

$pdf->Ln(15);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Oração:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Obrigada Senhor pelos dons, talentos e habilidades que o Senhor nos deu e ainda quer dar. Que possamos usá-los de maneira que o Senhor seja reconhecido e glorificado através de nossas vidas! Em nome de Jesus! Amém!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Memo 5:'), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('"Tudo o que fizerem, façam de todo o coração, como para o Senhor e não para as pessoas, sabendo que receberão do Senhor a recompensa da herança. É a Cristo, o Senhor, que vocês estão servindo." Cl 3:23 e 24'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Maker 5:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Vocês vão receber agora um plano de ação. Um planejamento estratégico. Preencha esse plano com o que já fez em seu projeto e quais os seus próximos passos. Coloque datas e ore em cima desse plano. Vamos entrar no projeto "High five",no jogo teremos cartas assim e vocês vão para o jogo e orar pelas pessoas que estão alcançando. Cada vez que vocês se encontrarem façam o High Five e compartilhem sobre seus projetos! Traga seu plano e entregue uma cópia para seu líder! GO MAKERS!'), 0, 'J');


$pdf->ln(30);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Impresso por $nome_usuario", 0, 1, 'J');

// LIÇÃO 09

// LIÇÃO 10
$pdf->AddPage();
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 10"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../fundo.jpg', 0, 0, 595, 842);

//Título da Lição
$pdf->Ln(2);
$pdf->SetXY(70, 30);
$pdf->SetFont('arial', 'B', 12);
$pdf->SetTextColor(168, 168, 168);
//$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(50, 20, $pdf->textoUTF8("L² - Projeto Organelas - Encontro 10"), 0, 1, 'L');
$pdf->Image('../../../dist/img/icone.png', 30, 13, -100);

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Plaqueando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8("Bem vindos ao último encontro desse módulo! Quanta coisa aprendemos juntos sobre o corpo humano e sobre a Igreja, corpo de Cristo. Aprendemos que somos parte desse Corpo, que temos um DNA, direção para nossa vida e para atuarmos no Corpo. Conhecemos nossos dons, talentos e habilidades e iniciamos nosso Projeto MAKER. O que mais falta? Continuar conhecendo os dons? Usar nossos dons? Saber mais sobre nossas potencialidades? Vamos lá para fora e vamos começar a ter a resposta. (Leve-os ao ar livre) Vocês sentem o vento? Não? Sim? De que lado vem? Para que lado está indo? Vocês sentiram quando chegaram? Perceberam? Por que não? Por que nós estávamos distraídos. Vocês estavam pensando ou fazendo o que quando chegaram? É, esse vento não é muito importante para nós, mas há um vento que não podemos perder de vista. Vamos voltar e microscopiar Jo 5:17, 19 e 20!"), 0, 'J');

$pdf->SetTextColor(168, 168, 168);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 15, "Microscopiando:", 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Jesus havia curado um paralítico no sábado e os judeus estavam zangados por ele haver desobedecido a lei, então ele começa a falar sobre a sua missão.'), 0, 'J');

$pdf->SetFont('arial', 'BI', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Meu Pai trabalha até agora, e eu trabalho também...'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Por que Ele falou isso logo depois de ter sido criticado pelos doutores da lei? Eles estavam pensando no paralítico? Ou no que Deus queria para ele? Eles pensaram em quem era Jesus? O que estava atrapalhando esses homens de ver e perceber o amor e o agir de Deus através de Jesus?  Jesus então ensina algo importante!'), 0, 'J');

$pdf->SetFont('arial', 'BI', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Então, lhes falou Jesus: Em verdade, em verdade vos digo que o Filho nada pode fazer de si mesmo, senão somente aquilo que vir fazer o Pai;'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Podemos fazer algo pelas nossas forças ou sabedoria humana? O que Deus estava fazendo, quando moveu Jesus a curar um homem no sábado? Deus estava apontando para um novo tempo, o tempo da salvação pela fé em Cristo. Continuando...'), 0, 'J');

$pdf->SetFont('arial', 'BI', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('porque tudo o que este fizer, o Filho também semelhantemente o faz. Porque o Pai ama ao Filho, e lhe mostra tudo o que faz, e maiores obras do que estas lhe mostrará, para que vos maravilheis.'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Jesus reconhecia o amor de Deus? Como Jesus podia perceber esse amor? Como podemos perceber o amor e o que Deus estão fazendo para que façamos também, como Jesus fez? Guardem essas perguntas! Vamos para o segundo texto – At 10:1 – 42 pulando alguns versos.'), 0, 'J');

$pdf->SetFont('arial', 'BI', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Morava em Cesareia um homem de nome Cornélio, centurião da corte chamada Italiana, piedoso e temente a Deus com toda a sua casa e que fazia muitas esmolas ao povo e, de contínuo, orava a Deus.'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Qual o dom de Cornélio? O que ele fazia continuamente? Para quê oramos? Será que podemos conhecer alguém e o que ela quer ou não, sem nos relacionarmos com ela? Cornélio estava atento ao vento! E o anjo apareceu em uma visão e lhe disse:'), 0, 'J');

$pdf->SetFont('arial', 'BI', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Cornélio! Este, fixando nele os olhos e possuído de temor, perguntou: Que é, Senhor? E o anjo lhe disse: As tuas orações e as tuas esmolas subiram para memória diante de Deus. Agora, envia mensageiros a Jope e manda chamar Simão, que tem por sobrenome Pedro. Logo que se retirou o anjo que lhe falava, chamou dois dos seus domésticos e um soldado piedoso dos que estavam a seu serviço e, havendo-lhes contado tudo, enviou-os a Jope'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Cornélio não era judeu e Deus o mandou para falar com Pedro. Com certeza Pedro não iria querer falar com ele, pois judeus não falavam com gentios sobre seu Deus. Mas o que Cornélio fez? Ele se deixou levar pelo vento! Verso 9'), 0, 'J');

$pdf->SetFont('arial', 'BI', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('No dia seguinte, indo eles de caminho e estando já perto da cidade, subiu Pedro ao eirado, por volta da hora sexta, a fim de orar.'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Pedro estava atento ao vento do Espírito? Cuidava de seu relacionamento com Deus? Deus então lhe deu uma visão e fez descer do céu um lençol com todos os animais que Deus, na lei, havia proibido de comer.'), 0, 'J');

$pdf->SetFont('arial', 'BI', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('E ouviu-se uma voz que se dirigia a ele: Levanta-te, Pedro! Mata e come. Mas Pedro replicou: De modo nenhum, Senhor! Porque jamais comi coisa alguma comum e imunda.'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Pedro foi contra o vento! Não entendeu a mudança e não obedeceu! '), 0, 'J');

$pdf->SetFont('arial', 'BI', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Segunda vez, a voz lhe falou: Ao que Deus purificou não consideres comum. Sucedeu isto por três vezes, e, logo, aquele objeto foi recolhido ao céu.'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Eita! E agora? Pedro era uma nova criatura, mas as coisas que havia aprendido no passado? O que Deus estava fazendo? Então...'), 0, 'J');

$pdf->SetFont('arial', 'BI', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Os enviados de Cornélio chegam a Jope.'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Então os homens disseram a Pedro que Cornélio o esperava em sua casa. Será que Pedro iria na direção do vento de Deus e iria participar do que Deus estava fazendo? Pedro foi com o vento.'), 0, 'J');

$pdf->SetFont('arial', 'BI', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Aconteceu que, indo Pedro a entrar, lhe saiu Cornélio ao encontro e, prostrando-se-lhe aos pés, o adorou. Mas Pedro o levantou, dizendo: Ergue-te, que eu também sou homem. Falando com ele, entrou, encontrando muitos reunidos ali, a quem se dirigiu, dizendo: Vós bem sabeis que é proibido a um judeu ajuntar-se ou mesmo aproximar-se a alguém de outra raça; mas Deus me demonstrou que a nenhum homem considerasse comum ou imundo; por isso, uma vez chamado, vim sem vacilar.'), 0, 'J');

$pdf->AddPage();

$pdf->Image('../../fundo.jpg', 0, 0, 595, 842);

$pdf->Ln(13);
$pdf->SetXY(70, 30);
$pdf->SetFont('arial', 'B', 12);
$pdf->SetTextColor(168, 168, 168);
//$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(50, 20, $pdf->textoUTF8("L² - Projeto Organelas - Encontro 10"), 0, 1, 'L');
$pdf->Image('../../../dist/img/icone.png', 30, 13, -100);

$pdf->Ln(15);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Pedro perguntou por que ele o havia chamado e Cornélio lhe disse:'), 0, 'J');

$pdf->SetFont('arial', 'BI', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Agora, pois, estamos todos aqui, na presença de Deus, prontos para ouvir tudo o que te foi ordenado da parte do Senhor. Então, falou Pedro, dizendo: Reconheço, por verdade, que Deus não faz acepção de pessoas; pelo contrário, em qualquer nação, aquele que o teme e faz o que é justo lhe é aceitável.'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Pedro pregou aos gentios e os gentios se converteram!'), 0, 'J');

$pdf->SetFont('arial', 'BI', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Ainda Pedro falava estas coisas quando caiu o Espírito Santo sobre todos os que ouviam a palavra. E os fiéis que eram da circuncisão, que vieram com Pedro, admiraram-se, porque também sobre os gentios foi derramado o dom do Espírito Santo;'), 0, 'J');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('E aqui estamos nós! Gentios que creem! Seu líder e amigo, assim como Pedro, percebeu o que Deus está fazendo, amando e trabalhando para trazer o máximo de crianças possível de volta a um relacionamento com Ele. Deus trouxe cada um de vocês. Deus está sempre trabalhando, em todo tempo, ao nosso redor. Você tem visto o que Deus está fazendo? Você tem provado do Seu amor?'), 0, 'J');

$pdf->MultiCell(360, 10, $pdf->textoUTF8('O vento sopra onde quer, ouves a sua voz, mas não sabes de onde vem, nem para onde vai, assim é todo o que é nascido do Espírito. Como você pode saber o que Deus está fazendo ao seu redor? E qual parte da missão ele tem para você? Como Pedro e Cornélio souberam? '), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Vai para a Estufa'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Essa estufa vai realmente lhe ajudar a perceber o vento e a ir com Ele mesmo não sabendo onde vai lhe levar! Se prepare para a ventania! Esteja pronto para as coordenadas do DNA de Deus!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Oração:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Senhor obrigada porque o Senhor nos escolheu, o Senhor nos ama e o Senhor está sempre trabalhando, todo o tempo, ao redor de nós! Nos ajude a estarmos livres para amar as pessoas e a fazer o que o Senhor está fazendo. Em nome de Jesus!'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Memo 5:'), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('"Tudo o que fizerem, façam de todo o coração, como para o Senhor e não para as pessoas, sabendo que receberão do Senhor a recompensa da herança. É a Cristo, o Senhor, que vocês estão servindo." Cl 3:23 e 24'), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->SetTextColor(168, 168, 168);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Projeto Maker 5:'), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(360, 10, $pdf->textoUTF8('Identifique quais os maiores desafios de seu plano estratégico. Tempo? Recursos? Oposições? Alguma estratégia precisa ser mudada? Essa semana, compartilhe seu projeto com pessoas que possam assumir o compromisso de orar por você durante o restante do ano. Se começou ou vai começar seu grupo, você já tem um CO (Co Líder)? Não é bom estar só! GO MAKERS!'), 0, 'J');


$pdf->ln(30);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Impresso por $nome_usuario", 0, 1, 'J');

// LIÇÃO 10

$nome_relatorio = $pdf->textoUTF8("Projeto Organelas");
$pdf->Output("$nome_relatorio.pdf", "I");
