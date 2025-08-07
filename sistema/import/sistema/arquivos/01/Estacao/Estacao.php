<?php

$usuario = $_GET['id_lider'] ?? 0;
$id_modulo = $_GET['id_modulo'] ?? "5";

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

$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(60, 10, $pdf->textoUTF8("Módulo:"), 0, 0, 'J');
$pdf->Cell(0, 10, $pdf->textoUTF8($modulo['nome_modulo']), 0, 1, 'J');
$pdf->Ln(8);

$pdf->Ln(300);
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 5, $pdf->textoUTF8("Máterial Estação Final"), 0, 1, 'C');
$pdf->Ln(8);
$pdf->Cell(0, 5, "", "B", 1, 'C');
$pdf->Ln(400);

// Página 2

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 01"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("1. ESTAÇÃO 1 - O ESPÍRITO SANTO"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Bilheteria:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O que é uma igreja? Lembram a lição do santuário? Uma igreja é um santuário, então o que é igreja? Isso! Igreja somos nós, cada um de nós é um pequeno santuário e juntos formamos uma igreja maior a quem Deus chama de corpo de Cristo! Um corpo tem muitos membros, não é só cabeça, cada membro é um santuário e faz parte do santuário maior, o corpo de Cristo. Agora imaginem esse corpo em movimento, esses vários santuários como trens. Imagine a vida de cada cristão como um trem! Se sua vida fosse um trem, de que tamanho ele seria? O que levaria? Será que andaria no trilho certo? Ou descarrilaria num acidente? A partir de hoje vamos ver como os cristãos se movimentaram na história do mundo. Em que estações eles passaram e quais estações estão por vir. O futuro? Isso mesmo! Você sabia que a Bíblia fala sobre nosso futuro e o que vai acontecer? Hoje vamos para a primeira estação! Nessa estação os trens (os que criam em Deus), foram abastecidos com uma pessoa. Existe combustível vivo? Vamos ver! (Líder): grave no celular um barulho de trem com apito e use em todas as suas introduções."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Plataforma:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.1.1) Depois que Jesus subiu aos céus, os discípulos ficaram em Jerusalém orando. Escolheram Matias para ficar no lugar de Judas. No sétimo dia depois que Jesus tinha subido aconteceu algo maravilhoso. Olhem o que diz a Palavra: "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Chegando o dia de Pentecoste, estavam todos reunidos num só lugar. De repente veio do céu um som, como de um vento muito forte, e encheu toda a casa na qual estavam assentados. (fig.1.2) E viram o que parecia línguas de fogo, que se separaram e pousaram sobre cada um deles. Todos ficaram cheios do Espírito Santo e começaram a falar noutras línguas, conforme o Espírito os capacitava."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Quem havia prometido que o Espírito Santo viria? Jesus. E para quê Ele viria? Vamos ver:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Havia em Jerusalém judeus, tementes a Deus, vindos de todas as nações do mundo. Ouvindo-se este som, ajuntou-se uma multidão que ficou perplexa, (fig.1.3) pois cada um os ouvia falar em sua própria língua. Atônitos e maravilhados, eles perguntavam: Acaso não são galileus todos estes homens que estão falando? Então, como os ouvimos, cada um de nós, em nossa própria língua materna?"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("A cidade estava cheia de pessoas de diferentes lugares e países, porque era época da festa da colheita. Os discípulos começaram a falar em línguas e, milagrosamente, cada pessoa ouvia em sua própria língua. Eles diziam:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Nós os ouvimos declarar as maravilhas de Deus em nossa própria língua! Atônitos e perplexos, todos perguntavam uns aos outros: ‘Que significa isto?’ Alguns, todavia, zombavam deles e diziam: ‘Eles beberam vinho demais’. Eles pensavam que os discípulos estavam bêbados! (fig.1.4) Então Pedro levantou-se com os onze e, em alta voz, dirigiu-se à multidão: Homens da Judéia e todos os que vivem em Jerusalém, deixem-me explicar-lhes isto! Ouçam com atenção: estes homens não estão bêbados, como vocês supõem. Ainda são nove horas da manhã! Pelo contrário, isto é o que foi predito pelo profeta Joel: Nos últimos dias, diz Deus, derramarei do meu Espírito sobre todos os povos. Os seus filhos e as suas filhas profetizarão, os jovens terão visões, os velhos terão sonhos. Sobre os meus servos e as minhas servas derramarei do meu Espírito naqueles dias, e eles profetizarão. Mostrarei maravilhas em cima no céu e sinais em baixo, na terra, sangue, fogo e nuvens de fumaça. O sol se tornará em trevas e a lua em sangue, antes que venha o grande e glorioso dia do Senhor. E todo aquele que invocar o nome do Senhor será salvo!"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Naquele dia, com a pregação de Pedro, sabe quantas pessoas aceitaram Jesus como senhor de suas vidas? Três mil pessoas! Só porque Pedro falou? Não. O que aconteceu? Um milagre! O Espírito Santo nos dá poder para falar e Ele mesmo convence os corações! Você acha que tem esse poder? Se você tem a Jesus como Senhor, você tem esse poder. Porém o poder só se manifesta quando somos dominados pelo Espírito de Deus. Quando fazemos o que Ele quer e obedecemos a Deus! Você quer ser usado pelo Espírito Santo de Deus?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Embarque:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus, obrigado por haver enviado o Espírito Santo, nos ajude a sermos dominados por Ele, obedecendo a Tua Palavra."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 1"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mas receberão poder quando o Espírito Santo descer sobre vocês, e serão minhas testemunhas em Jerusalém, em toda a Judéia e Samaria, e até os confins da terra. Atos 1:8"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 1 - O Combustível Vivo"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que combustível é esse?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Por que Ele é vivo?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Por que Ele nos foi dado"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quando ganhamos esse combustível?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que o Espírito Santo faz?"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');

// Página 3
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 02"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("2. ESTAÇÃO 2 - OS CRISTÃOS SÃO PERSEGUIDOS."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Bilheteria:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos brincar de esconder? (Peça que metade se esconda e a outra metade deve procurar) O que vocês sentiram antes de serem encontrados? Friozinho na barriga, empolgação? Mas se precisássemos nos esconder de um perigo de verdade, como se sentiriam? Se alguém quisesse matar vocês? E se alguém quisesse lhe matar por que você acredita em Jesus? Essa foi a Estação 2 do povo de Deus! A Estação da Perseguição! Foi muito difícil, escutem:"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Plataforma:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O quê Jesus mandou que os discípulos fizessem quando recebessem o Espírito Santo? Qual o nosso versículo? Então vamos ver se eles obedeceram! (fig.2.1)"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Assim, a palavra de Deus se espalhava. Crescia rapidamente o número de discípulos em Jerusalém; Aonde crescia o número de discípulos? ... também um grande número de sacerdotes obedecia à fé. Estêvão, homem cheio da graça e do poder de Deus, realizava grandes maravilhas e sinais entre o povo. Contudo, levantou-se oposição dos membros da chamada Sinagoga dos Libertos, dos judeus de Cirene e de Alexandria, bem como das províncias da Cilícia e da Ásia. Esses homens começaram a discutir com Estêvão, mas não podiam resistir à sabedoria e ao Espírito com que ele falava."), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig2.2) Então subornaram (pagaram) alguns homens para dizerem: Ouvimos Estêvão falar palavras blasfemas contra Moisés e contra Deus. Blasfêmia é falar algo sério que ofende a Deus. Com isso agitaram o povo, os líderes religiosos e os mestres da lei. E, prendendo Estêvão, levaram-no ao Sinédrio. (fig.2.3) Ali apresentaram falsas testemunhas que diziam: Este homem não para de falar contra este lugar santo e contra a lei. Pois o ouvimos dizer que esse Jesus, o Nazareno, destruirá este lugar e mudará os costumes que Moisés nos legou. Olhando para ele, todos os que estavam sentados no Sinédrio viram que o seu rosto parecia o rosto de um anjo. Atos 6:7-15 Estevão estava cheio do Espírito Santo e começou a falar tudo o que Deus tinha feito pelo povo de Israel e como eles desobedeciam a Deus, matando Seus profetas. Eles ficaram com muito ódio, escutem o que eles fizeram: Ouvindo isso, ficavam furiosos e rangiam os dentes contra ele. Mas Estêvão, cheio do Espírito Santo, levantou os olhos para o céu e viu a glória de Deus, e Jesus de pé, à direita de Deus, e disse: Vejo o céu aberto e o Filho do homem de pé, à direita de Deus. (fig.2.4) Mas eles taparam os ouvidos e, gritando bem alto, lançaram-se todos juntos contra ele, arrastaram-no para fora da cidade e começaram a apedrejá-lo. As testemunhas deixaram seus mantos aos pés de um jovem chamado Saulo. Atos 7:54-58"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mas eles não eram pessoas que conheciam a Palavra? Infelizmente existem muitas pessoas que conhecem a Palavra e continuam fazendo sua vontade e não a de Deus. O que vocês acham disso? Mas não foi só Estevão que sofreu perseguição!"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Enquanto Pedro e João falavam ao povo, chegaram os sacerdotes, o capitão da guarda do templo e os saduceus. Eles estavam muito perturbados porque os apóstolos estavam ensinando o povo e proclamando em Jesus a ressurreição dos mortos. Agarraram Pedro e João e, como já estava anoitecendo, os colocaram na prisão até o dia seguinte. Naquela ocasião desencadeou-se grande perseguição contra a igreja em Jerusalém. Todos, exceto os apóstolos, foram dispersos pelas regiões da Judéia e de Samaria. Atos 8:1"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Por que estava acontecendo a perseguição? Certo, porque eles estavam falando de Jesus, mas não foi só por causa disso! O que Jesus tinha dito a eles para fazerem? Qual o versículo? E eles permaneceram aonde? Em Jerusalém. E quando foram perseguidos espalharam-se por onde? (Leia novamente At 8:1) Será que obediência pela metade é obediência? Se eles não tivessem se espalhado você e eu teríamos conhecido Jesus? "), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Embarque:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Obrigado porque o Senhor nos ajuda a fazermos a Tua vontade de maneira completa, nos ajude a falarmos de Jesus, com a força do Teu Espírito, a todas as pessoas que conhecemos."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 1"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mas receberão poder quando o Espírito Santo descer sobre vocês, e serão minhas testemunhas em Jerusalém, em toda a Judéia e Samaria, e até os confins da terra. Atos 1:8"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 1 - O Combustível Vivo"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que combustível é esse?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Por que Ele é vivo?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Por que Ele nos foi dado"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quando ganhamos esse combustível?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que o Espírito Santo faz?"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');

// Página 4
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 03"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("3. ESTAÇÃO 3 - CHAMADO DE PAULO AOS GENTIOS"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Bilheteria:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Você sabe o que é uma sigla? É a representação de palavras através das letras iniciais. Por exemplo, quando você manda uma carta tem que colocar o número do CEP – Código de Endereçamento Postal. MEC significa Ministério da Educação e Cultura, BB – Banco do Brasil. Quando falamos em ferrovias, onde os trens circulam, existe um mecanismo de mudança de trilhos ou mudança de via, cuja sigla é AMV. Vamos ver quem descobre o que essas letras querem dizer? (Deixe que as crianças sugiram, após algum tempo se elas não descobrirem, fale.) AMV significa Aparelho de Mudança de Via, ele é como uma bifurcação nos trilhos.	 (https://www.youtube.com/watch?v=w25CHJwo924) (Primeiro teste de via e acionador de AMV na modular Sorocaba – mostre esse vídeo no celular para as crianças)"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Lembram de Saulo, o homem que assistiu a morte de Estevão? No caminho dele, Deus colocou um AMV, Saulo era um religioso, conhecedor da Palavra de Deus, mas ele não acreditava em Jesus, mesmo vendo que as profecias estavam se cumprindo em Sua vida. Saulo, além de não acreditar em Jesus, queria destruir os cristãos. Escutem o que a Bíblia diz:"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Plataforma:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.3.1)"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Enquanto isso, Saulo ainda respirava ameaças de morte contra os discípulos do Senhor. Dirigindo-se ao sumo sacerdote, pediu-lhe cartas para as sinagogas de Damasco, de maneira que, caso encontrasse ali homens ou mulheres que pertencessem ao Caminho, pudesse levá-los presos para Jerusalém."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O que ele queria fazer com os cristãos? Saulo estava no trilho certo?"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Em sua viagem, quando se aproximava de Damasco, de repente brilhou ao seu redor uma luz vinda do céu. (fig.3.2) Ele caiu por terra e ouviu uma voz que lhe dizia: Saulo, Saulo, por que você me persegue? Saulo perguntou: Quem és tu, Senhor? Ele respondeu: Eu sou Jesus, a quem você persegue. Levante-se, entre na cidade; alguém lhe dirá o que você deve fazer. "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Os homens que viajavam com Saulo pararam emudecidos; ouviam a voz, mas não viam ninguém. Saulo levantou-se do chão e, abrindo os olhos, não conseguia ver nada. E eles o levaram pela mão até Damasco. Por três dias ele esteve cego, não comeu nem bebeu."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O que será que Saulo estava pensando, o que você pensaria, no lugar dele? (Anote as opiniões das crianças)"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Em Damasco havia um discípulo chamado Ananias. O Senhor o chamou numa visão: Ananias! Eis-me aqui, Senhor, respondeu ele. O Senhor lhe disse: Vá à casa de Judas, na rua chamada Direita, e pergunte por um homem de Tarso chamado Saulo. Ele está orando; numa visão viu um homem chamado Ananias chegar e impor-lhe as mãos para que voltasse a ver. Respondeu Ananias: Senhor, tenho ouvido muita coisa a respeito desse homem e de todo o mal que ele tem feito aos teus santos em Jerusalém. Ele chegou aqui com autorização dos chefes dos sacerdotes para prender todos os que invocam o teu nome. Ananias estava com medo? Mas o Senhor disse a Ananias: Vá! Este homem é meu instrumento escolhido para levar o meu nome perante os gentios e seus reis, e perante o povo de Israel. Mostrarei a ele o quanto deve sofrer pelo meu nome."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.3.3)"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Então Ananias foi, entrou na casa, impôs as mãos sobre Saulo e disse: Irmão Saulo, o Senhor Jesus, que lhe apareceu no caminho por onde você vinha, enviou-me para que você volte a ver e seja cheio do Espírito Santo. Imediatamente, algo como escamas caiu dos olhos de Saulo e ele passou a ver novamente. Levantando-se, foi batizado e, depois de comer, recuperou as forças."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.3.4)"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Saulo passou vários dias com os discípulos em Damasco. Logo começou a pregar nas sinagogas que Jesus é o Filho de Deus. Todos os que o ouviam ficavam perplexos e perguntavam: Não é ele o homem que procurava destruir em Jerusalém aqueles que invocam este nome? E não veio para cá justamente para levá-los presos aos chefes dos sacerdotes? Todavia, Saulo se fortalecia cada vez mais e confundia os judeus que viviam em Damasco, demonstrando que Jesus é o Cristo. Atos 9:1-43"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Em que momento Deus colocou um AMV na vida de Saulo? E ele mudou o trilho da vida dele? Você tem escutado sobre Jesus aqui no PG, se você ainda não tomou uma decisão de crer em Jesus. Deus está chamando seu nome hoje, como chamou o nome de Saulo e você pode estar pensando todas essas coisas (leia algumas opiniões das crianças). Você quer hoje pedir perdão a Deus e mudar o trilho de sua vida para seguir a Jesus como seu Senhor? Não vai ser fácil, mas você estará no trilho certo! Você quer?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Embarque:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus muito obrigado porque o Senhor tem colocado um AMV em nossas vidas para que andemos nos trilhos certos em direção ao Senhor!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 2"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Porque todos os que são guiados pelo Espírito de Deus esses são filhos de Deus. Romanos 8:14"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 2 - O Trem Perfeito"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é o maquinista?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que são os trilhos?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que deve vir primeiro lugar nos nossos vagões?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que deve vir em último lugar?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Para quem serve nosso trem?"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');

// Página 5
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 04"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("4. ESTAÇÃO 4 - A IGREJA."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Bilheteria:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(Dê a cada criança alguns palitos de fósforo de maneira que o total seja 30, peça a uma criança que pegue um de seus palitos e tente quebrar) Conseguiu quebrar o palito? Foi fácil ou difícil? Por quê? (Agora pegue todos os palitos e amarre-os e passe um insulfilm ou plástico para não machucar as crianças. Peça para outra criança tentar quebrá-los) Está fácil quebra-los agora? Por que não? Você sabia que a mesma coisa acontece conosco? Se estamos sozinhos é fácil alguém nos deixar tristes e com vontade de fazer coisas erradas que irão nos destruir mas estamos juntos, como temos estado em nossos grupos, somos mais fortes? Por quê? Porque nos ajudamos e oramos uns pelos outros, assim vamos aprender na estação 4 com os primeiros cristãos. Como eles viviam no trilho e com que eles carregavam seus trens. Vamos ler como eles viviam:"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Plataforma:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.4.1)"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Eles se dedicavam ao ensino dos apóstolos e à comunhão, ao partir do pão e às orações. Todos estavam cheios de temor, e muitas maravilhas e sinais eram feitos pelos apóstolos. Todos os que criam mantinham-se unidos e tinham tudo em comum. Vendendo suas propriedades e bens, distribuíam a cada um conforme a sua necessidade. Todos os dias, continuavam a reunir-se no pátio do templo. (fig.4.2) Partiam o pão em suas casas, e juntos participavam das refeições, com alegria e sinceridade de coração, louvando a Deus e tendo a simpatia de todo o povo. E o Senhor lhes acrescentava todos os dias os que iam sendo salvos. Atos 2.42-47"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O que você acha mais legal na maneira de viver desse povo? Eles estavam no trilho certo? Como você sabe disso?"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E era um o coração e a alma da multidão dos que criam, e ninguém dizia que coisa alguma do que possuía era sua própria, mas todas as coisas lhes eram comuns."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8(" Isto é, o que era de um, era de todos! Mas dar as coisas que tem? Não é melhor encher nossa vida, carregar nosso trem, com muitas coisas? O que vocês acham?"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E os apóstolos davam, com grande poder, testemunho da ressurreição do Senhor Jesus, e em todos eles havia abundante graça. Não havia, pois, entre eles necessitado algum; porque todos os que possuíam propriedades ou casas, vendendo-as, traziam o preço do que fora vendido, e o depositavam aos pés dos apóstolos. E repartia-se a cada um, segundo a necessidade que cada um tinha. Atos 4:32-35"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Então eles não enchiam seus vagões com riquezas? Então com que enchiam? Sabem crianças, que em um trem, as cargas mais pesadas têm que ficar nos vagões da frente? Porque se o trem precisar frear a resistência vai estar na frente e o peso de trás não vai empurrar tudo pra frente causando um acidente. Na vida também é assim! O que tem mais peso de valor, dinheiro ou amor ao próximo, o que é mais resistente e nos ajuda a passar por problemas? Joias ou paciência? Joias e dinheiro não tem peso nenhum para Deus. Amor e paciência sim e são essas coisas que devem vir na frente de nosso trem, coisas de menor peso, de menor importância devem vir atrás. Assim nunca teremos acidentes."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Algumas coisas nem precisam entrar em nosso trem porque se o enchermos de carga não sobrará lugar para as pessoas, o que vocês acham? Mas vamos continuar lendo:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Todos os dias, no templo e de casa em casa, não deixavam de ensinar e proclamar que Jesus é o Cristo. Atos 5.42. (fig.4.3) Assim, pois, as igrejas em toda a Judéia, e Galiléia e Samaria tinham paz, e eram edificadas; e se multiplicavam, andando no temor do Senhor e consolação do Espírito Santo. Atos 9:31"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E os que foram dispersos pela perseguição que sucedeu por causa de Estêvão caminharam até à Fenícia, Chipre e Antioquia, não anunciando a ninguém a palavra, senão somente aos judeus. (fig.4.4) E havia entre eles alguns homens chíprios e cirenenses, os quais entrando em Antioquia falaram aos gregos, anunciando o Senhor Jesus. E a mão do Senhor era com eles; e grande número creu e se converteu ao Senhor. Atos 11:19-21"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Também muitos dos que seguiam artes mágicas trouxeram os seus livros, e os queimaram na presença de todos e, feita a conta do seu preço, acharam que montava a cinquenta mil peças de prata. Assim a palavra do Senhor crescia poderosamente e prevalecia. Atos 19:17-20"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8(" Olha só, eles se livraram de peso desnecessário mesmo que valia muito dinheiro. Mas se não agradava a Deus caia fora! Do que você acha que precisa se livrar? O que você acha que precisa colocar em seus primeiros vagões? Existem pessoas que você quer ganhar para Jesus? Vamos orar por elas?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Embarque:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Senhor nos ajude a encher nossas vidas com aquilo que te agrada e nos ajude a conquistar pessoas para o Senhor através de nossas vidas!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 2"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Porque todos os que são guiados pelo Espírito de Deus esses são filhos de Deus. Romanos 8:14"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 2 - O Trem Perfeito."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é o maquinista?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que são os trilhos?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que deve vir primeiro lugar nos nossos vagões?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que deve vir em último lugar?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Para quem serve nosso trem?"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');

// Página 6
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 05"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("5. ESTAÇÃO 5 - A VOLTA DE CRISTO."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Bilheteria:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(Consiga 2 mochilas ou sacolas do mesmo tamanho, 2 montes de roupas iguais, elas devem arrumar as roupas nas sacolas. Escolha 2 crianças para arrumá-las. Marque 5 segundos e mande parar). Foi possível arrumar tudo? Impossível? Será que você estaria pronto para uma viagem em menos tempo do que isso? E se a viagem aparecer em um piscar de olhos? De repente? Qual seria então a solução? Crianças nós estamos vivendo entre as estações 4 e 5 do povo de Deus, ou seja, a igreja. Cada um com seu trem em movimento, cada um com sua vida, cada um com sua carga e cada um tentando encher seu trem com mais pessoas ensinando-as para que possam entrar no trilho certo. Mas a estação 5 virá, com uma mudança muito rápida de trilhos, um AMV que surgirá de repente. Que mudança será esta e o que podemos fazer para estar preparados?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Plataforma:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.5.1) João, um dos discípulos de Jesus escreveu o que Jesus disse e fez aqui na terra e umas das coisas foi seu aviso aos discípulos que um dia iria voltar para buscar a sua igreja, todos o que creram, creem e crerão, Ele falou: "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Não se perturbe o coração de vocês. Creiam em Deus; creiam também em mim. Na casa de meu Pai há muitos aposentos; se não fosse assim, eu lhes teria dito. Vou preparar-lhes lugar. E se eu for e lhes preparar lugar, voltarei e os levarei para mim, para que vocês estejam onde eu estiver. Vocês conhecem o caminho para onde vou. João 14.1-4"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Para onde Jesus vai nos levar? O que vocês acham que devemos fazer para estar preparados? Quando Ele virá? (deixe que as crianças expressem suas opiniões e discutam). O próprio Jesus falou quando viria e como deveríamos nos preparar, escutem o que Lucas escreveu:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Ele respondeu: Cuidado para não serem enganados. Pois muitos virão em meu nome, dizendo: Sou eu! e o tempo está próximo. Não os sigam. Quando ouvirem falar de guerras e rebeliões, não tenham medo. É necessário que primeiro aconteçam essas coisas, mas o fim não virá imediatamente. Então lhes disse: Nação se levantará contra nação, e reino contra reino. Haverá grandes terremotos, fomes e pestes em vários lugares, e acontecimentos terríveis e grandes sinais provenientes do céu. Mas antes de tudo isso, prenderão e perseguirão vocês..... Será para vocês uma oportunidade de dar testemunho. Mas convençam-se de uma vez de que não devem preocupar-se com o que dirão para se defender. Pois eu lhes darei palavras e sabedoria a que nenhum dos seus adversários será capaz de resistir ou contradize... Todos odiarão vocês por causa do meu nome. Contudo, nenhum fio de cabelo da cabeça de vocês se perderá.  É perseverando que vocês obterão a vida."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Puxa, vai ser difícil! O que vocês acham? Mas Jesus vai nos deixar sozinhos? Quem está sempre conosco? O Espírito Santo nos dando poder para testemunhar! E Ele diz mais:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Haverá sinais no sol, na lua e nas estrelas. Haverá muito sofrimento na terra. Então se verá o Filho do homem vindo numa nuvem com poder e grande glória. Quando começarem a acontecer estas coisas, levantem-se e ergam a cabeça, porque estará próxima a redenção de vocês. Tenham cuidado, para que os seus corações não fiquem carregados de libertinagem, bebedeira e ansiedades da vida, e aquele dia venha sobre vocês inesperadamente. Estejam sempre atentos e orem para que vocês possam escapar de tudo o que está para acontecer, e estar de pé diante do Filho do homem. Lucas 21:8-36"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mas e os cristãos que não estiverem mais vivos? Será que vão ficar? Vamos ver: (fig.5.2)"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Pois, dada a ordem, com a voz do arcanjo e o ressoar da trombeta de Deus, (fig.5.3) o próprio Senhor descerá do céu, e os mortos em Cristo ressuscitarão primeiro. Depois disso, os que estivermos vivos seremos arrebatados juntamente com eles nas nuvens, para o encontro com o Senhor nos ares. (fig.5.4) E assim estaremos com o Senhor para sempre. 1 Tessalonissences 4.16-18"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Eu quero estar um dia com o Senhor nas nuvens. Ele vai voltar! Será que você está preparado? Ninguém sabe o dia nem a hora, mas ele virá! O que você precisa para estar preparado? Só precisamos ter Deus no controle de nossas vidas! Vamos orar!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Embarque:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Senhor obrigado porque o Senhor vem nos buscar um dia, nos ajude a darmos o controle de nossas vidas para o Senhor, só assim estaremos firmes quando vierem os problemas."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 3"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Não se perturbe o coração de vocês. Creiam em Deus; creiam também em mim. Na casa de meu Pai há muitos aposentos; se não fosse assim, eu lhes teria dito. Vou preparar-lhes lugar. João 14:1"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 3 - O CCO da Vida"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("*	O que é um CCO??"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é o nosso CCO?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que ele faz?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como saber suas direções?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como ter este contato?"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');

// Página 7
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 06"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("6. ESTAÇÃO 6 - O DESTINO DO INIMIGO DE DEUS."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Bilheteria:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vocês gostam de filmes de super-heróis? Qual a parte do filme que vocês gostam mais? É legal quando o inimigo é derrotado não é? Mas o que acontece até ele ser derrotado? O que ele tenta fazer? Ele tenta destruir o herói. Usa engano, usa pessoas, tenta fazer o herói fazer coisas erradas. Vocês sabiam crianças, que Satanás, o inimigo de Deus age exatamente assim. Ele já está derrotado porque Jesus já derrotou a ele na cruz, então ele fica querendo afastar as pessoas de Deus. Fazer com que os cristãos façam coisas erradas, briguem... Você já viu isso acontecer? Algumas pessoas não ficam espertas, às vezes em suas vidas, em seus trens, perdem o contato com quem está no comando da ferrovia, que é Deus. E terminam se envolvendo em acidentes por causa de seus pecados. Mas será que Satanás nunca vai parar de tentar que façamos coisas erradas? Vamos ver o que a Bíblia nos conta, na estação 6, uma das estações do futuro."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Plataforma:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.1.1) Em suas visões, João viu que nós subiremos para nos encontrar com Jesus. Mas e aqueles cristãos que já estavam mortos quando Jesus voltou? Será que não vão também? A Bíblia diz que eles serão ressuscitados para se juntar àqueles que estarão vivos e juntos subiram com Cristo nas nuvens. E os que ficarão na terra e não subirão com Jesus? Os que ficarão na terra e não subirão com Jesus continuarão deixando-se enganar por Satanás. Só alguns crerão. E sabe o que acontecerá?  Vamos ler o que João escreveu: "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E vi tronos; e assentaram-se sobre eles, e foi-lhes dado o poder de julgar; e vi as almas daqueles que foram mortos pelo testemunho de Jesus, e pela palavra de Deus, e que não adoraram a besta, nem a sua imagem, e não receberam o sinal em suas testas nem em suas mãos; e viveram,(fig2.2)  e reinaram com Cristo durante mil anos. Apocalipse 20:4."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Nós vamos reinar com Jesus durante mil anos. E naqueles mil anos vamos examinar os livros dos céus, julgaremos e veremos que Deus foi justo com cada pessoa. Porém, quando começar os mil anos de reinado, vai acontecer algo com o inimigo de Deus. João escreveu:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E vi descer do céu um anjo, que tinha a chave do abismo, e uma grande cadeia na sua mão. Ele prendeu o dragão, a antiga serpente, que é o Diabo e Satanás, e amarrou-o por mil anos. E lançou-o no abismo, e ali o encerrou, e pôs selo sobre ele, para que não mais engane as nações, até que os mil anos se acabem. E depois importa que seja solto por um pouco de tempo. Apocalipse 20:1-3."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Satanás será preso durante esses mil anos. Escutem:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Quando terminarem os mil anos, Satanás será solto da sua prisão e sairá para enganar as nações que estão nos quatro cantos da terra, Gogue e Magogue, a fim de reuni-las para a batalha. Seu número é como a areia do mar. (fig.6.3) As nações marcharam por toda a superfície da terra e cercaram o acampamento dos santos, a cidade amada; mas um fogo desceu do céu e as devorou. (fig.6.4) O diabo, que as enganava, foi lançado no lago de fogo que arde com enxofre, onde já haviam sido lançados a besta e o falso profeta. Eles serão atormentados dia e noite, para todo o sempre. Apocalipse 20.7-10."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Satanás será lançado no inferno. Será a vitória final! Porém nós, que temos a Jesus como salvador, estaremos em paz e seguros com Cristo! Mas vamos lembrar porque Satanás, que era um anjo de Deus, começou a fazer o mal. Quem ele preferiu que estivesse no comando em sua vida? Deus ou Ele mesmo? (Tome 5 minutos para compartilhar como você tem procurado se colocar sob o comando de Deus!)"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Embarque:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus, obrigado porque o Senhor nos salvou. Nos ajude a estarmos sempre sob o Teu comando e obrigado porque um dia estaremos livres de Satanás para sempre, em nome de Jesus!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 3"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Não se perturbe o coração de vocês. Creiam em Deus; creiam também em mim. Na casa de meu Pai há muitos aposentos; se não fosse assim, eu lhes teria dito. Vou preparar-lhes lugar. João 14:1"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 3 - O CCO da Vida"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("*	O que é um CCO??"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é o nosso CCO?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que ele faz?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como saber suas direções?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como ter este contato?"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');

// Página 8
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 07"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("7. ESTAÇÃO 7 – OS JULGAMENTOS."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Bilheteria:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(Leve várias listas com os nomes de suas crianças, sempre faltando um nome. Leia a primeira lista e pergunte, Eu me esqueci de chamar alguém?, eles dirão que sim. Pegue outra lista dizendo que essa deve ser a certa e proceda da mesma forma, leia todas as listas) Como vocês se sentiram com seu nome faltando na lista? É ruim este sentimento? Eu não gosto de ser deixada de fora! Mas a Bíblia nos fala de um livro no céu onde estão escritos todos os nomes de quem já aceitou Jesus e na Chegamos à estação 7, a penúltima estação existirá um acontecimento no qual não estaremos presentes. E onde o livro da vida será aberto junto com os livros das obras das pessoas que não tem Jesus. Será o grande julgamento de Deus!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Plataforma:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.7.1) Escute o que João viu em suas visões sobre esse julgamento: "), 0, 'J');


$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Depois vi um grande trono branco (fig.7.2) e aquele que nele estava assentado. A terra e o céu fugiram da sua presença, e não se encontrou lugar para eles. Apocalipse 20:11."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Quem, vocês acham que estará assentado neste trono? A Palavra diz que Jesus Cristo será aquele que vai julgar a todos. Mas como a terra e o céu vão fugir de sua presença? Escutem o que diz 2 Pedro 3:10,"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("o dia do Senhor, porém, virá como ladrão. Os céus desaparecerão com um grande estrondo, os elementos serão desfeitos pelo calor, e a terra, e tudo o que nela há, será desnudada."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O céu e a terra vão ser destruídos naquele momento e então todos os que morrerão sem ter a Cristo como salvador ficarão diante de Deus."), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vi também os mortos, grandes e pequenos, de pé diante do trono, e livros foram abertos. Outro livro foi aberto, o livro da vida. Os mortos foram julgados de acordo com o que tinham feito, segundo o que estava registrado nos livros. O mar entregou os mortos que nele havia, e a morte e o Hades entregaram os mortos que neles havia; e cada um foi julgado de acordo com o que tinha feito. (fig.7.3) Então a morte e o Hades foram lançados no lago de fogo. O lago de fogo é a segunda morte. Se o nome de alguém não foi encontrado no livro da vida, este foi lançado no lago de fogo. Apocalipse 20.12-15. "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Que horrível deverá ser não ter o nome no livro de Deus e essas pessoas são aquelas que tiveram a oportunidade de aceitar a Jesus como Senhor e salvador de suas vidas e disseram NÃO. Como Satanás, quiseram fazer a sua vontade e ser o seu próprio Deus. Para elas, infelizmente, naquele dia, não haverá mais chance. Deus nos dá a chance hoje,"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Eu lhes asseguro: Quem ouve a minha palavra e crê naquele que me enviou, tem a vida eterna e não será condenado, mas já passou da morte para a vida. João 5:24."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8(" Você que sabe que tem pecado e que o pecado lhe afasta de Deus, você sabe que Jesus morreu no seu lugar, para que você não seja condenado, você quer crer hoje em Jesus e recebe-lo como seu Senhor, para ser o seu centro de controle, ser o controlador de sua vida?  (fig.7.4) E você que já tem a Jesus como salvador, sua vida tem estado no trilho certo? A Bíblia nos diz que Deus tem presentes preparados para aqueles que forem fiéis e o servirem de todo coração."), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Chegou o tempo de julgares os mortos e de recompensares os teus servos, os profetas, os teus santos e os que temem o teu nome, tanto pequenos como grandes, e de destruir os que destroem a terra"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Embarque:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Senhor obrigado por ter pagado a condenação em nosso lugar, nos ajuda a testemunhar através de nossas àqueles que não te conhecem."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 4"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Ele enxugará dos seus olhos toda lágrima. Não haverá mais morte, nem tristeza, nem choro, nem dor, pois a antiga ordem já passou. Apocalipse 21:4"), 0, 'J');
$pdf->Ln(10);


$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 4 - A Estação Final"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que estação é essa?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quando ela vai acontecer?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como chegar até ela?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que devemos fazer até chegarmos lá?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Ela é o fim ou o começo?"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');

// Página 9
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 08"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("8. ESTAÇÃO 8 - NOVO CÉU E NOVA TERRA."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Bilheteria:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Finalmente chegamos na última estação. Que longo caminho! Desde o começo da igreja, até o fim que Deus tem preparado para seu povo. Um novo céu e uma nova terra. Como você acha que vai ser? Eu tenho aqui algumas coisas comigo e você vai me dizer se estarão no lugar que Deus tem preparado para nós. (Mostre caixas de remédio, de preferência vazias, band-aid, ...) Você acham que estas coisas estarão no céu? Por que vocês acham isso? Vamos ver como vai ser o céu?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Plataforma:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.8.1) Na visão que Deus deu a João ele lhe mostrou o lugar que Deus tem preparado para nós:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Então vi um novo céu e uma nova terra, pois o primeiro céu e a primeira terra tinham passado; e o mar já não existia. (fig.8.2) Vi a cidade santa, a nova Jerusalém, que descia do céu, da parte de Deus,... Ouvi uma forte voz que vinha do trono e dizia: (fig.8.3) Agora o tabernáculo de Deus está com os homens, com os quais ele viverá. Eles serão os seus povos; o próprio Deus estará com eles e será o seu Deus. Vamos falar nosso versículo, ele está escrito aqui. Ele enxugará dos seus olhos toda lágrima. Não haverá mais morte, nem tristeza, nem choro, nem dor, pois a antiga ordem já passou."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Então não vamos ter lágrimas? Nem sofrimento? Então, vamos ter doenças?"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Aquele que estava assentado no trono disse: Estou fazendo novas todas as coisas! E acrescentou: Escreva isto, pois estas palavras são verdadeiras e dignas de confiança. Disse-me ainda: Está feito. (fig.8.4) Eu sou o Alfa e o Ômega, o Princípio e o Fim. A quem tiver sede, darei de beber gratuitamente da fonte da água da vida. O vencedor herdará tudo isto, e eu serei seu Deus e ele será meu filho."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Quem é o vencedor? Cada um de nós que temos a Jesus como salvador! Agora feche seus olhos, escute e tente imaginar o que está escutando porque João continua descrevendo a cidade."), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Ela resplandecia com a glória de Deus, e o seu brilho era como o de uma joia muito preciosa... clara como cristal. Tinha uma grande e alta muralha com doze portas e doze anjos junto às portas. Nas portas estavam escritos os nomes das doze tribos de Israel. A cidade era quadrangular, de comprimento e largura iguais. Ele mediu a cidade com a vara; tinha dois mil e duzentos quilômetros de comprimento; a largura e a altura eram iguais ao comprimento."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Em formato de quadrado, bloco!"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Ele mediu a muralha, e deu sessenta e cinco metros de espessura, segundo a medida humana que o anjo estava usando."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Já imaginou um muro com a largura de 65 metros?"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("A muralha era feita de jaspe e a cidade de ouro puro, semelhante ao vidro puro. Os fundamentos dos muros da cidade eram ornamentados com toda sorte de pedras preciosas...	As doze portas eram doze pérolas, cada porta feita de uma única pérola. A rua principal da cidade era de ouro puro, como vidro transparente. Não vi templo algum na cidade, pois o Senhor Deus todo-poderoso e o Cordeiro são o seu templo. A cidade não precisa de sol nem de lua para brilhar sobre ela, pois a glória de Deus a ilumina, e o Cordeiro é a sua candeia. As nações andarão em sua luz, e os reis da terra lhe trarão a sua glória. Suas portas jamais se fecharão de dia, pois ali não haverá noite. A glória e a honra das nações lhe serão trazidas. Nela jamais entrará algo impuro, nem ninguém que pratique o que é vergonhoso ou enganoso, mas unicamente aqueles cujos nomes estão escritos no livro da vida do Cordeiro.  Apocalipse 21:1-27"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E João fala mais:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Então o anjo me mostrou o rio da água da vida que, claro como cristal, fluía do trono de Deus e do Cordeiro, no meio da rua principal da cidade. De cada lado do rio estava a árvore da vida, que dá doze colheitas, dando fruto todos os meses. As folhas da árvore servem para a cura das nações."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("As folhas são para continuarem em perfeita saúde não para restaurar a saúde porque doença não vai existir."), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Já não haverá maldição nenhuma. O trono de Deus e do Cordeiro estará na cidade, e os seus servos o servirão. Eles verão a sua face, e o seu nome estará em suas testas. Não haverá mais noite. Eles não precisarão de luz de candeia nem da luz do sol, pois o Senhor Deus os iluminará; e eles reinarão para todo o sempre. Apocalipse 22:1-5."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Você pode imaginar como vai ser tudo lindo? E nós não teremos mais estes corpos, mas teremos um corpo como o de Cristo, perfeito! (Fale sobre seu desejo de um dia encontrar Deus nesta cidade e viver com Ele eternamente, deixe que as crianças falem também!)"), 0, 'J');
//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Embarque:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus nós te agradecemos porque o Senhor nos dá a esperança de um dia estarmos para sempre com o Senhor, nos ajude a levar esta esperança para outros!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 4"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Ele enxugará dos seus olhos toda lágrima. Não haverá mais morte, nem tristeza, nem choro, nem dor, pois a antiga ordem já passou. Apocalipse 21:4"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 4 - A Estação Final"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que estação é essa?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quando ela vai acontecer?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como chegar até ela?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que devemos fazer até chegarmos lá?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Ela é o fim ou o começo?"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');

$pdf->AddPage();

$pdf->Ln(8);
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 5, $pdf->textoUTF8("Respostas de Mistérios - Estação Final"), 0, 1, 'C');
$pdf->Ln(8);
$pdf->Cell(0, 5, "", "B", 1, 'C');
$pdf->Ln(8);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

// 01
$pdf->Ln(10);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 1 - O Combustível Vivo"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que combustível é esse? - O Espirito Santo"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Por que Ele é vivo? - Porque é uma pessoa, Ele é Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Por que Ele nos foi dado? - Para ser nosso combustível, nos dar poder para testemunhar"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quando ganhamos esse combustível? - Quando recebemos a Jesus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que o Espírito Santo faz? - Dá poder, purifica e nos une"), 0, 'J');


// 02
$pdf->Ln(10);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 2 - O Trem Perfeito"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é o maquinista? - Eu"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que são os trilhos? - A Palavra de Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que deve vir primeiro lugar nos nossos vagões? - O que tem mais  peso para Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que deve vir em último lugar? - Coisas que tem mais peso para Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Para quem serve nosso trem? - Para levar pessoas até Jesus"), 0, 'J');

// 03
$pdf->Ln(10);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 3 - O CCO da Vida"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("*	O que é um CCO? - Centro de Controle Operacional"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é o nosso CCO? - Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que ele faz? - Nos dereciona em tudo"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como saber suas direções? - Devemos ter contato contante com Ele"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como ter este contato? - Através da oração"), 0, 'J');


// 04
$pdf->Ln(10);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 4 - A Estação Final"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que estação é essa? - A eternidade com Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quando ela vai acontecer? - Depois que Jesus nos levar"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como chegar até ela? - Crendo em Jesus como salvador"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que devemos fazer até chegarmos lá? - Conseguir mais pessoas para Jesus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Ela é o fim ou o começo? - O começo da eternidade"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);

$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');

$nome_relatorio = $pdf->textoUTF8("Estação Final");
$pdf->Output("$nome_relatorio.pdf", "I");
