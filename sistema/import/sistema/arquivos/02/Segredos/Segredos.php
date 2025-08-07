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

$nivel = "";
$nome_usuario = "";

if ($xL == 0) {
} else {
	$nivel .= "Líder";
	$nome_usuario .= $dadoslider['nome_lider'];
}

if ($xC == 0) {
} else {
	$nivel .= "Coordenador";
	$nome_usuario .= $dadoscoordenador['nome_coordenador'];
}

if ($xSR == 0) {
} else {
	$nivel .= "Supervisor Regional";
	$nome_usuario .= $dadossr['nome_supervisorR'];
}

if ($xSE == 0) {
} else {
	$nivel .= "Supervisor Estadual";
	$nome_usuario .= $dadosse['nome_supervisorE'];
}

if ($xD == 0) {
} else {
	$nivel .= "Direção";
	$nome_usuario .= $dadosdirecao['nome_direcao'];
}

$consultarM_sql = "SELECT * FROM modulo WHERE id_modulo LIKE :ID";
$consultarM = $pdo->prepare($consultarM_sql);
$consultarM->bindValue(":ID", $id_modulo);
$consultarM->execute();

$modulo = $consultarM->fetch(PDO::FETCH_ASSOC);

$pdf->AddPage();
//$pdf->Image('logog8.jpg');
$pdf->Ln(8);
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 5, utf8_decode("CAMP BRASIL"), 0, 1, 'C');
$pdf->Ln(8);
$pdf->Cell(0, 5, "", "B", 1, 'C');
$pdf->Ln(8);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', 'B', 14);

if ($xL != 0 or $xD != 0) {
	$pdf->Cell(150, 20, utf8_decode("$nivel:"), 0, 0, 'J');
} else {
	$pdf->Cell(150, 20, utf8_decode("$nivel:"), 0, 0, 'J');
}

$pdf->Cell(0, 20, utf8_decode($nome_usuario), 0, 1, 'J');
$pdf->Ln(8);

$pdf->Cell(60, 20, utf8_decode("Módulo:"), 0, 0, 'J');
$pdf->Cell(0, 20, utf8_decode($modulo['nome_modulo']), 0, 1, 'J');
$pdf->Ln(8);

$pdf->Ln(300);
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 5, utf8_decode("Máterial Expedição Animal 1 - Os Segredos"), 0, 1, 'C');
$pdf->Ln(8);
$pdf->Cell(0, 5, "", "B", 1, 'C');

// Página 2

$pdf->AddPage();

// I - Lição 01
//Capa
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, utf8_decode("Lição 01"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(50, 20, utf8_decode("1. Borboleta - Pecados – Reconhecimento e confissão."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Preparação da área:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Você sabe de onde vêm as borboletas? Você já viu um filhote de borboleta? Como elas nascem? Você sabe para que servem as borboletas? As borboletas nascem como lagartas. Você já viu lagartas? Para quê elas servem? (fig.1.1) A lagarta só se torna útil quando se transforma em borboleta. A Borboleta é útil porque leva o pólen de uma planta para outra, ajudando a reprodução das plantas. A Borboleta é muito bonita e útil, a lagarta é feia e prejudicial às plantas. Você acha que uma borboleta volta a rastejar como uma lagarta? Não. Crianças, nós somos parecidos com as borboletas! Antes, você e eu só fazíamos coisas erradas, era nossa velha natureza, éramos como lagartas. Então pedimos a Deus que nos transformasse em criaturas novas, com uma nova natureza e agora nossa vida faz o bem para outras pessoas e para nós mesmos. Mas temos uma diferença das borboletas. Qual é a diferença? É que temos algo dentro de nós que nos empurra para agirmos como lagartas novamente, fazendo coisas erradas. Você sabe o que é? Você já ouviu falar de um personagem bíblico chamado Jonas? Como foi a história de Jonas? Será que ele era lagarta ou borboleta? Querem saber os detalhes?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Acampando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(fig.1.2) Jonas era um profeta de Deus. Lembra o que é um profeta? Alguém que recebe a palavra de Deus e fala aos homens. Vamos ver que palavra Deus deu a Jonas: "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("A palavra do Senhor veio a Jonas, filho de Amitai com esta ordem: 'Vá depressa à grande cidade de Nínive e pregue contra ela, porque a sua maldade subiu até a minha presença'"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O povo de Nínive estava fazendo maldades? Sim! Aqui na nossa cidade que tipo de maldades as pessoas fazem? Você pode fazer alguma coisa em relação a isso? Jonas tinha sido mandado para falar ao povo que eles estavam errados. Mas os ninivitas eram maus e inimigos do povo de Israel. Será que ele foi? Vamos ver:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mas Jonas fugiu da presença do Senhor, dirigindo-se para Társis. Desceu à cidade de Jope, onde encontrou um navio que se destinava àquele porto. Depois de pagar a passagem, embarcou para Társis, para fugir do Senhor."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Por que será que Jonas não queria dizer àquele povo que eles estavam errados? O que Jonas estava fazendo? Você acha que essa desobediência teve consequências? Vamos ver:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("O Senhor, porém, fez soprar um forte vento sobre o mar, e caiu uma tempestade tão violenta que o barco ameaçava arrebentar-se. Todos os marinheiros ficaram com medo e cada um clamava ao seu próprio deus. E atiraram as cargas ao mar para tornar mais leve o navio. Enquanto isso, Jonas, que tinha descido para o porão e se deitado, dormia profundamente. O capitão dirigiu-se a ele e disse: 'Como você pode ficar aí dormindo? Levante-se e clame ao seu deus! Talvez ele tenha piedade de nós e não morramos'. "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que vocês acham da atitude de Jonas em não se importar com o desespero dos marinheiros?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Então os marinheiros combinaram entre si: 'Vamos tirar sortes para descobrir quem é o responsável por esta desgraça que se abateu sobre nós'. Tiraram sortes, e a sorte caiu sobre Jonas. Por isso lhe perguntaram: 'Diga-nos, quem é o responsável por esta calamidade? Qual é a sua profissão? De onde você vem? Qual é a sua terra? A que povo você pertence?'"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Jonas respondeu as perguntas. Mas o que Jonas estava fazendo? Ele não era amigo de Deus? Por que ele estava fazendo isso? Você já recebeu a Jesus como salvador? Mas ainda faz coisas que desagradam a Deus? Quando você faz o que desagrada a Deus, você está se comportando como lagarta ou borboleta? Você está seguindo as vontades da nova natureza que Deus lhe deu ou da velha natureza do pecado? Borboleta ou lagarta como Jonas? Então os marinheiros disseram ao Jonas lagarta:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("'O que devemos fazer com você, para que o mar se acalme?' Respondeu ele: 'Peguem-me e joguem-me ao mar, e ele se acalmará.... Ao invés disso, os homens se esforçaram ao máximo para remar de volta à terra. Mas não conseguiram, porque o mar tinha ficado ainda mais violento. Então eles clamaram ao Senhor: 'Senhor, nós suplicamos, não nos deixes morrer por tirarmos a vida deste homem. Não caia sobre nós a culpa de matar um inocente, porque tu, ó Senhor, fizeste o que desejavas'. (fig.1.3) Então, pegaram Jonas e o lançaram ao mar enfurecido, e este se aquietou. ... Então o Senhor fez com que um grande peixe engolisse Jonas, e ele ficou dentro do peixe três dias e três noites. "), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("A tempestade não mudou a teimosia de Jonas. O que tinha provocado essa teimosia tão grande? Agora Jonas estava debaixo d’água e dentro de um peixe. Será que ele vai continuar pecando? Ouçam:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Lá de dentro do peixe, Jonas orou ao Senhor, ao seu Deus. Ele disse: 'Em meu desespero clamei ao Senhor, e ele me respondeu. ... Eu disse: Fui expulso da tua presença; contudo, olharei de novo para o teu santo templo. As águas agitadas me envolveram, o abismo me cercou, as algas marinhas se enrolaram em minha cabeça. Afundei até os fundamentos dos montes; ... Mas tu trouxeste a minha vida de volta da cova, ó Senhor meu Deus! 'Quando a minha vida já se apagava, eu me lembrei de ti, Senhor, e a minha oração subiu a ti, ao teu santo templo. ..."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Sabe o que pode impedir sua oração de chegar até Deus? O pecado. Enquanto Jonas estava pecando, com teimosia, as orações dele não chegavam até Deus. Suas orações estão chegando? O que será que fez a oração de Jonas ser ouvida? Jonas se arrependeu de ter desobedecido. Ele falou:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mas eu, com um cântico de gratidão, oferecerei sacrifício a ti. O que eu prometi cumprirei totalmente. A salvação vem do Senhor."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("As pessoas só ofereciam sacrifícios quando se arrependiam. Jonas se arrependeu de seu pecado. O que Deus fará?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("(fig. 1.4) E o Senhor deu ordens ao peixe, e ele vomitou Jonas em terra firme."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Jonas 1-2) A lagarta em Jonas quis tomar conta, mas ele se arrependeu e voltou a ser borboleta. Deus quer que vivamos como lagartas ou borboletas? (fig.1.4) Você quer viver como? Tem algo errado em sua vida para confessar a Deus?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Levantando Acampamento:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Deus, obrigada porque o Senhor nos quer ver livres do pecado, nos ajude a sempre nos arrependermos e confessarmos os nossos pecados ao Senhor."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 1"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Se confessarmos os nossos pecados, Ele é fiel e justo para perdoar os nossos pecados e nos purificar de toda injustiça. (1 João 1:9)"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 1 - As Borboletas de 2 Pupas"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Qual o segredo das pupas?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quando começamos nossa mertamorfose?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* E a 2ª pupa para que serve?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que acontece na nossa 2ª pupa?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* E se não entrar na pupa?"), 0, 'J');

$pdf->ln(100);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo " . $nome_usuario, 0, 1, 'J');
// F - Lição 01

$pdf->AddPage();

// I - Lição 02
//Capa
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, utf8_decode("Lição 02"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(50, 20, utf8_decode("2. Borboleta - Pecados enraizados - Arrependimento e confissão."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Preparação da área:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Vamos brincar de 'geleca' hoje? Use um desses vídeos e escolha ou o detergente amarelo ou o corante amarelo: https://www.youtube.com/watch?v=dhI4ql6r2nY ou  https://www.youtube.com/watch?v=Atp2BHczNMk"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Sabe com que se parece essa gosma amarela e sem forma? Com o que fica dentro da pupa quando está acontecendo a transformação da lagarta em borboleta. (fig.2.1) Deve ser bem difícil para a lagarta passar por esse processo, mas é necessário se ela vai ser uma nova criatura. A nossa transformação também não é fácil, tem coisas que são difíceis de mudar. Nossa velha natureza quer nos dominar como aconteceu com Jonas. Vamos continuar conhecendo a vida dele!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Acampando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("A palavra do Senhor veio a Jonas pela segunda vez com esta ordem: 'Vá à grande cidade de Nínive e pregue contra ela a mensagem que eu vou dar a você'. E Jonas obedeceu à palavra do Senhor e foi para Nínive."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(fig.2.2) Jonas pregou por 3 dias e todos os ninivitas se arrependeram, as crianças e os adultos. Até o rei se arrependeu e se vestiu com trapos e sentou-se no meio das cinzas. Isso mostrava o quanto ele estava arrependido. Será que ele estava se sentindo como a lagarta se sente dentro da pupa? Totalmente sem forma, porque a forma velha era errada e agora tem que surgir outra. Eu já me senti assim! (Conte sobre como se sentiu quando percebeu o quanto era pecador/a) Mas depois de se entregar a Deus, escutem o que o rei fez:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Então fez uma proclamação em Nínive: 'Por decreto do rei e de seus nobres: Não é permitido a nenhum homem ou animal, bois ou ovelhas provar coisa alguma; não comam nem bebam! Cubram-se de pano de saco, homens e animais. E todos clamem a Deus com todas as suas forças. Deixem os maus caminhos e a violência. Talvez Deus se arrependa e abandone a sua ira, e não sejamos destruídos'."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O próprio rei chamou o povo para o arrependimento. Já imaginou se isso acontecesse no Brasil? Ou na nossa cidade? E sabem o que Deus fez? Ele desistiu de destruir Nínive e teve misericórdia daquela cidade. Mas aconteceu uma coisa muito estranha com Jonas!"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("(fig.2.3) ...Jonas ficou profundamente descontente com isso e enfureceu-se. Ele orou ao Senhor: 'Senhor, não foi isso que eu disse quando ainda estava em casa? Foi por isso que me apressei em fugir para Társis. Eu sabia que tu és Deus misericordioso e compassivo, muito paciente, cheio de amor e que promete castigar, mas depois se arrepende. Agora, Senhor, tira a minha vida, eu imploro, porque para mim é melhor morrer do que viver'."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que é isso? O que deu em Jonas? Ele queria que as pessoas morressem. Por que vocês acham que Jonas ficou assim de novo? (deixe que as crianças respondam)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("O Senhor lhe respondeu: 'Você tem alguma razão para essa fúria?'Jonas saiu e sentou-se num lugar a leste da cidade. Ali, construiu para si um abrigo, sentou-se à sua sombra e esperou para ver o que aconteceria com a cidade."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Talvez Jonas esperasse que Deus ainda a iria destruir! Então Deus resolveu salvar Jonas de seu pecado mais profundo. A Desobediência tinha sido só um pedaço de um pecado maior e mais profundo no coração de Jonas. Você já sabe qual é? Vamos ver o que Deus fez:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("(fig.2.4) Então o Senhor Deus fez crescer uma planta sobre Jonas, para dar sombra à sua cabeça e livrá-lo do calor, e Jonas ficou muito alegre. Mas na madrugada do dia seguinte, Deus mandou uma lagarta atacar a planta de modo que ela secou. Ao nascer do sol, Deus trouxe um vento muito quente, e o sol bateu na cabeça de Jonas, a ponto de ele quase desmaiar. Com isso ele desejou morrer, e disse: 'Para mim seria melhor morrer do que viver'."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Jonas ficou muito triste, desanimado e raivoso com Deus ao ver a planta morta pela lagarta. "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mas Deus disse a Jonas: 'Você tem alguma razão para estar tão furioso por causa da planta?' Respondeu ele: 'Sim, tenho! E estou furioso a ponto de querer morrer'."), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mas o Senhor lhe disse: 'Você tem pena dessa planta, embora não a tenha podado nem a tenha feito crescer. Ela nasceu numa noite e numa noite morreu.Contudo, Nínive tem mais de cento e vinte mil pessoas que não sabem nem distinguir a mão direita da esquerda, além de muitos animais. Não deveria eu ter pena dessa grande cidade?'"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Jonas 3-4) Jonas tinha pena da planta e não tinha pena das 120 mil crianças em Nínive? Só porque eram inimigos de seu povo antes? Qual era o pecado profundo de Jonas crianças? Egoísmo! Lembra que ele estava dormindo e nem aí para os marinheiros? Aqueles marinheiros não importavam muito para Jonas e nem os ninivitas, mas o povo de Israel sim porque era SEU povo e a planta sim porque LHE fez bem. Jonas pensou que Deus era injusto por não fazer SUA vontade. Será que você já se sentiu com raiva de alguém mau que foi tratado bem? Ou ficou com raiva de Deus por ele não fazer o que você quer? Você quer se arrepender? Quer ir para sua pupa, falar com Deus e pedir que Ele transforme esse sentimento em você? Pedir que Ele o ajude a ser santo?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Levantando Acampamento:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Deus nos ajude a reconhecermos e pedirmos perdão dos pecados mais escondidos de nosso coração, aqueles que as pessoas não podem ver mas nos fazem tão mal e nos afastam de Deus!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 1"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Se confessarmos os nossos pecados, Ele é fiel e justo para perdoar os nossos pecados e nos purificar de toda injustiça. (1 João 1:9)"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 1- As Borboletas de 2 Pupas"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Qual o segredo das pupas?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quando começamos nossa mertamorfose?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* E a 2ª pupa para que serve?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que acontece na nossa 2ª pupa?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* E se não entrar na pupa?"), 0, 'J');

$pdf->ln(290);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo " . $nome_usuario, 0, 1, 'J');
// I - Lição 02

$pdf->AddPage();

// I - Lição 03
//Capa
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, utf8_decode("Lição 03"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(50, 20, utf8_decode("3. Lagartixa - Apegar-se às promessas da Palavra - Neemias."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Preparação da área:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Fazer cola caseira (grude) com as crianças. Toda cola ou adesivo cola bem? Uns colam mais, outros menos, e existem uns que nunca descolam. Mas existe um adesivo que se for espalhado em uma superfície do tamanho de uma moeda pode segurar o peso de um bebê. E ainda mais, ele pode colar e soltar a hora que quiser. Você já viu isso? Sabe onde tem este adesivo? Em um animal! A ciência até tenta fazer algo parecido, mas não consegue. Sabe que animal é este? Vou dar algumas dicas: pequeno, frio, anda pelas paredes e no teto. Anda em casas simples e em palácios. Bem ligeiro, solta o rabo se for pego. Vocês já sabem o que é? (fig.3.1) A lagartixa!!! A Bíblia nos conta a história de um homem chamado Neemias, ele usava um adesivo como a lagartixa em sua vida."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Acampando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("fig.3.2) Há muito tempo atrás o povo de Deus foi escravizado e depois que foram libertos foram espalhados em vários locais. (Você pode se vestir como Neemias e contar a história na primeira pessoa, como está escrita na Bíblia)"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Eu morava em Susã, servindo ao rei. No mês de Casleu do ano 20 (dezembro/janeiro), Hanani, um dos meus irmãos, veio de Judá e eu perguntei a ele sobre os judeus sobreviventes e sobre a cidade de Jerusalém e eles disseram:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("'Aqueles que sobreviveram ao cativeiro e estão lá na província, passam por grande sofrimento e humilhação. O muro de Jerusalém foi derrubado, e suas portas foram destruídas pelo fogo'. Quando ouvi essas coisas, sentei-me e chorei. Passei dias lamentando, jejuando e orando ao Deus dos céus. Então eu disse: Senhor, Deus dos céus, Deus grande e temível, fiel à aliança e misericordioso com os que o amam e obedecem aos seus mandamentos, que os teus ouvidos estejam atentos e os teus olhos estejam abertos para ouvir a oração que o teu servo está fazendo dia e noite diante de ti em favor de teus servos, o povo de Israel. Confesso os pecados que nós, os israelitas, temos cometido contra ti. Sim, eu e o meu povo temos pecado contra ti. Agimos de forma corrupta e vergonhosa contra ti. Não temos obedecido aos mandamentos, aos decretos e às leis que deste ao teu servo Moisés. Lembra-te agora do que disseste a Moisés, teu servo: 'Se vocês forem infiéis, eu os espalharei entre as nações, mas, se voltarem para mim, e obedecerem aos meus mandamentos e os puserem em prática, mesmo que vocês estejam espalhados pelos lugares mais distantes debaixo do céu, de lá eu os reunirei e os trarei para o lugar que escolhi para estabelecer o meu nome'. Estes são os teus servos, o teu povo. Tu os resgataste com o teu grande poder e com o teu braço forte. Senhor, que os teus ouvidos estejam atentos à oração deste teu servo e à oração dos teus servos que têm prazer em temer o teu nome. Ajuda-me a conseguir a bondade do rei e que eu possa conseguir o que meu coração deseja."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(você pode ter essas frases e perguntas em placas feitas de papel) O que será que Neemias queria fazer? Neemias amava seu povo? Ele amava a Deus? Ele conhecia as promessas da palavra de Deus? Como você percebe isso? Quando ele citou as promessas de Deus a Moisés ele mostrou que se apegava a essas promessas."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("(fig.3.3) No mês de nisã (abril/ maio)..., na hora de servir-lhe o vinho, levei-o ao rei. Nunca antes eu tinha estado triste na presença dele; Por isso o rei me perguntou: 'Por que o seu rosto parece tão triste, se você não está doente? Essa tristeza só pode ser do coração!' Com muito medo, eu disse ao rei: 'Que o rei viva para sempre! Como não estaria triste o meu rosto, se a cidade em que estão sepultados os meus pais está em ruínas, e as suas portas foram destruídas pelo fogo?'"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(placas) Neemias foi corajoso? O rei poderia ter ficado zangado? Por que? É difícil ter coragem? De onde vinha a coragem de Neemias? Vinha do apego que ele tinha às promessas da Bíblia. Sabem o que o rei fez?"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O rei me disse: 'O que você gostaria de pedir?' Então orei ao Deus dos céus, e respondi ao rei: 'Se for do agrado do rei e se o seu servo puder contar com a benevolência do rei, que ele me deixe ir à cidade de Judá onde meus pais estão enterrados, para que eu possa reconstruí-la'. Então o rei, com a rainha sentada ao seu lado, perguntou-me: 'Quanto tempo levará a viagem? Quando você voltará?' Marquei um prazo com o rei, e ele concordou que eu fosse. E ainda falei: Se for do agrado do rei, que me dê cartas aos governadores ... para que me deixem passar até chegar a Judá. (fig.3.4) Que me dê também uma carta para Asafe, guarda da floresta do rei, para que ele me forneça madeira para as vigas das portas ...e do muro da cidade e da residência que irei ocupar. Visto que a bondosa mão de Deus estava sobre mim, o rei atendeu os meus pedidos"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Tire as roupas de Neemias e continue perguntando) Neemias pediu muito ou pouco? O rei deu tudo o que ele pediu? Por que? Neemias se apegava a que? Será que ele colava na palavra? Igual lagartixa na parede? A lagartixa consegue segurar um peso impossível, grudada, sem cair. E nós? Será que Deus pode fazer o impossível se nos agarrarmos nas promessas dEle? Veja uma promessa para você: Pois estou convencido de que nem morte nem vida, nem anjos nem demônios, nem o presente nem o futuro, nem quaisquer poderes, nem altura nem profundidade, nem qualquer outra coisa na criação será capaz de nos separar do amor de Deus que está em Cristo Jesus, nosso Senhor. (Romanos 8:38,39) O que diz esta promessa? Vamos fazer um caderno devocional para nos ajudar a ler a Palavra e buscar direções nela todos os dias. Vai ser o nosso 'Caderno Lagartixa'!!!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Levantando Acampamento:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Senhor Deus, muito obrigado porque podemos nos grudar nas Tuas promessas para nossas vidas porque elas não falham."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 2"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("A tua palavra é lâmpada que ilumina os meus passos e luz que clareia o meu caminho. (Salmos 119:105)"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 2 - O Adesivo Secreto"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que adesivo é este?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Que segurança ele dá?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Qual o nosso adesivo secreto?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Que segurança temos?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quando ele funciona?"), 0, 'J');

$pdf->ln(220);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo " . $nome_usuario, 0, 1, 'J');
// F - Lição 03

$pdf->AddPage();

// I - Lição 04
//Capa
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, utf8_decode("Lição 04"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(50, 20, utf8_decode("4. Lagartixa- Apegar-se às direções da Palavra - Neemias."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Preparação da área:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Brincar de quente, morno e frio. Peça para uma criança sair e esconda algo, as outras crianças devem ver onde o objeto foi escondido. Elas devem ser instruídas a dar direções erradas, todas de uma vez conforme a criança se aproximar ou se afastar do objeto. Depois de algum tempo o líder deve perguntar à criança se ela está conseguindo achar o objeto, o porquê desse problema, e se ela quer escolher alguém para lhe dar as direções. A pessoa escolhida, então, deve dar as direções certas.) O que aprendemos com essa brincadeira? Será que conseguimos saber a direção certa de nossas vidas se ficarmos ouvindo muitas pessoas dando direções diferentes? (fig.4.1) Como a lagartixa age quando vai caçar? Será que faz o que quer na hora que quer? E nós, como tomamos decisões? O que fazer? Neemias tomou a decisão certa quando queria saber que direção tomar em sua vida. Vamos ver:"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Acampando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Vista-se de Neemias para o monólogo)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("(fig.4.2) Eu estava disposto a reconstruir os muros de Jerusalém, mas logo comecei a enfrentar obstáculos. Sambalate, o horonita, e Tobias, o oficial amonita, ficaram muito irritados quando souberam que alguém estava interessado no bem dos israelitas. (placas) Eles eram parentes de Neemias, mas não eram do povo de Israel. O que Neemias deveria fazer? Será que queriam atrapalhar? Será que Neemias devia contar seus planos?. Cheguei a Jerusalém e, depois de três dias de permanência ali, saí de noite com alguns dos meus amigos. Eu não havia contado a ninguém o que o meu Deus havia posto em meu coração que eu fizesse por Jerusalém... De noite saí... examinando o muro de Jerusalém que havia sido derrubado, e suas portas, que haviam sido destruídas pelo fogo. Arrodeei todo o muro destruído, Os oficiais não sabiam aonde eu tinha ido ou o que eu estava fazendo, pois até então eu não tinha dito nada aos judeus, aos sacerdotes, aos nobres, aos oficiais e aos outros que iriam realizar a obra"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Achei que era melhor ficar quieto, olhar o trabalho a ser feito e esperar a direção de Deus. (placas) Neemias poderia ter anunciado tudo que iria fazer? O que Sambalate e Tobias iriam dizer e fazer? É certo esperar a direção de Deus?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("(fig.4.3) Vocês estão vendo a situação terrível em que estamos: Jerusalém está em ruínas, .... Venham, vamos reconstruir o muro de Jerusalém, para que não fiquemos mais nesta situação humilhante. Também lhes contei como Deus tinha sido bondoso comigo e o que o rei me tinha dito. Eles responderam: 'Sim, vamos começar a reconstrução'. E se encorajaram para esse bom projeto."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("(fig.4.4) Quando, porém, Sambalate, o horonita, Tobias, o oficial amonita, e Gesém, o árabe, souberam disso, zombaram de nós, desprezaram-nos e perguntaram: 'O que é isso que vocês estão fazendo? Estão se rebelando contra o rei? ' Eu lhes respondi: O Deus dos céus fará que sejamos bem sucedidos. Nós, os seus servos, começaremos a reconstrução, mas, quanto a vocês, não têm parte nem direito legal sobre Jerusalém..."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Neemias 2:10-20) (Tire a roupa de Neemias) Neemias estava sendo rebelde? O rei iria ficar com raiva? Aqueles homens estavam querendo afastar Neemias da direção que Deus havia lhe dado, colocando medo em seu coração. Mas Neemias acreditou na direção que eles queriam dar? Neemias esperou a hora certa e Deus lhe deu o momento e a direção certa."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("(fig.4.1) Você sabe como a lagartixa faz para encontrar e caçar suas presas, as moscas e outros insetos que são tão rápidos? Ela fica imóvel, parada, às vezes por um dia inteiro olhando para sua presa até chegar o momento certo de atacar e raramente ela dá o bote errado. A hora certa e a decisão certa, só conhecemos quando paramos, pensamos no que vamos fazer e ouvimos a direção de Deus. E onde está essa direção? "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Em quem você vai acreditar para dar direções a sua vida? (compartilhe como Deus lhe direcionou em algo na sua vida) Vamos aprender a usar nosso 'Caderno Lagartixa'! (Se preferir pode separar um encontro só para ensinar a fazer um devocional)! "), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Levantando Acampamento:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Deus, obrigado porque o Senhor nos deu o sol para nos aquecer e a lua tão bonita para iluminar nossas noites."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 2"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("A tua palavra é lâmpada que ilumina os meus passos e luz que clareia o meu caminho. (Salmos 119:105)"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 2 - O Adesivo Secreto"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que adesivo é este?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Que segurança ele dá?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Qual o nosso adesivo secreto?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Que segurança temos?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quando ele funciona?"), 0, 'J');

$pdf->ln(450);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo " . $nome_usuario, 0, 1, 'J');
// I - Lição 04

$pdf->AddPage();

// I - Lição 05
//Capa
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, utf8_decode("Lição 05"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(50, 20, utf8_decode("5. Gafanhoto - União do grupo - Neemias."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Preparação da área:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Construa algo com seus discípulos, de maneira que cada um possa contribuir com uma parte para totalizar o projeto. Pode ser: Uma estrada na areia com pedrinhas, uma cidade com caixas velhas, Um bolo, com cada um acrescentando os ingredientes... Ao terminar pergunte: Como conseguimos fazer isso? Se alguém deixasse de contribuir, o que aconteceria? Será que a união é importante? Por quê? Será que podemos fazer coisas grandes, mesmo sendo poucos e sendo crianças? O que podemos fazer? Vamos ver o que Neemias e o povo que restou, depois que Jerusalém foi destruída, conseguiu fazer:"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Acampando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(fig.5.1) Com as autorizações do Rei nas mãos e os planos que, em oração, Neemias fez para a reconstrução dos muros e das portas da cidade ao redor dela, ele começou a liderar o povo. Você sabe o tamanho do muro e quantas portas existiam para entrar na cidade? O muro devia ter us 4000 metros com a altura aproximada de 8 mts e 20 cm e era bem grosso, não era como nossos muros fininhos, tinha que ser grosso para resistir a uma guerra. Talvez mais de 2 metros de espessura. Muito trabalho? Como nós conseguimos fazer o nosso projeto? Como eles conseguiriam fazer? (fig.5.2) Da mesma maneira que nós fizemos e como uma nuvem de lagostas faz. Você já viu uma nuvem de lagostas? Se você ler o seu semanário, vai descobrir que nuvem é essa! Como uma nuvem de lagostas, sob o comando de Neemias, o povo de Jerusalém começou a reconstruir o muro e as portas. Vamos ver como fizeram:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("(fig.5.3) O sumo sacerdote Eliasibe e os seus colegas sacerdotes começaram o seu trabalho e reconstruíram a porta das Ovelhas.... Depois construíram o muro até a torre dos Cem... e até a torre de Hananeel.  "), 0, 'J');

$pdf->SetFont('arial', 'B', 12);
$pdf->MultiCell(0, 15, utf8_decode("Os homens de Jericó - construíram o trecho seguinte."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Zacur - construiu logo adiante. "), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Hassenaá - construiu a porta do Peixe."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Meremote, Mesulão e Zadoque - construíram mais um trecho do muro."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Tecoa - mais um trecho, mas os nobres dessa cidade não quiseram se juntar ao serviço."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Joiada e Mesulão - A porta Velha."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Melatias e Jadom, Uziel e Hananias - Reconstruíram mais 2 etapas do muro. "), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Refaías - fez os reparos do trecho seguinte. "), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("(fig.5.4) Jedaías e Hatus, Malquias e Hassube - reconstruíram mais 2 etapas e a torre dos fornos."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Salum e suas filhas - repararam o trecho seguinte."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Hanum  - A porta do Vale  e quatrocentos e cinqüenta metros do muro, até a porta do Esterco."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Malquias - A porta do Esterco. "), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Salum - A porta da Fonte e fez os reparos do muro do tanque de Siloé. "), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Neemias, os levitas e Hasbias - Mais etapas do muro. "), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Binui, Ezer, Baruque e Meremote - Mais muro."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Os demais reparos foram feitos pelos sacerdotes das redondezas. E cada um também reparou o muro em frente à suas casas. (Neemias 3:1-32)   Uau!!! Como eles conseguiram? Como foi conosco aqui? Quem fez o quê? Vocês observaram se alguém não quis trabalhar? E os outros pararam por causa disso? O que acontece quando vemos todos trabalhando e um folgado? Às vezes falamos, se ele está folgado também não vou trabalhar. Se eles pensassem assim o que aconteceria? Se pensarmos assim, nunca poderemos ser como um exército de lagostas! Nunca teremos uma boa união. Vou mostrar para vocês a figura de uma lagosta para dar uma pista do mistério."), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Levantando Acampamento:"), 0, 1, 'L');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Senhor nos ensina e ajuda a sermos unidos, ajudando uns aos outros sempre!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 3"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Como é bom e agradável quando os irmãos convivem em união! (Salmos 133:1)"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 3 - O Exército de Lagostas"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que exército é esse?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Onde está a força dele?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O quê ele pode fazer?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como fazer parte dele?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Porque não sair dele?"), 0, 'J');

$pdf->ln(500);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo " . $nome_usuario, 0, 1, 'J');
// I - Lição 05

$pdf->AddPage();

// I - Lição 06
//Capa
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, utf8_decode("Lição 06"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(50, 20, utf8_decode("6. Gafanhoto  - União no grupo - Neemias."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Preparação da área:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Você sabia que o gafanhoto é um animal solitário? Normalmente eles não vivem em bandos. Mas quando acontece uma seca, uma situação difícil, e depois chove, eles começam a procriar muito rápido e começam a se juntar como se estivessem preparando um exército. E para que se juntam? Para comerem as plantas que nascem depois da chuva. De repente, eles ficam mais espertos e rápidos. Quando estão juntos eles se tornam poderosos. Voam como se fossem uma nuvem, descem sobre as plantas, comem tudo em minutos e seguem adiante. Assim eles conseguem sobreviver. O que aconteceria se ficassem sempre solitários? Talvez não houvesse mais gafanhotos no mundo!!! Talvez já teriam sido destruídos por outros animais. (fig.6.1) A mosca é um dos principais predadores dos gafanhotos, os filhotes delas comem os ovos dos gafanhotos.  Vocês acham que quando somos unidos, somos mais fortes? Vamos continuar vendo a história de Neemias tentando reconstruir os muros de Jerusalém."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Acampando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Monólogo) (fig.6.2) Quando Sambalate soube que estávamos reconstruindo o muro, ficou furioso. Sambalate, Tobias e Gesém eram de outros povos e não queriam que o muro fosse reconstruído. Sambalate ridicularizou os judeus ... disse: 'O que aqueles frágeis judeus estão fazendo? Será que vão restaurar o seu muro? Irão oferecer sacrifícios? Irão terminar a obra num só dia? Será que vão conseguir ressuscitar pedras de construção daqueles montes de entulho e de pedras queimadas? ' Tobias, o amonita, que estava ao seu lado, completou: 'Pois que construam! Basta que uma raposa suba lá, para que esse muro de pedras desabe!'"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Eu então orei a Deus: "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Ouve-nos, ó Deus, pois estamos sendo desprezados. ...sejam eles levados prisioneiros para outra terra. Não perdoes os seus pecados nem apagues as suas maldades, pois provocaram a tua ira diante dos construtores. (placas)"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("A quem Neemias pediu ajuda? Quem é que pode nos proteger todo o tempo? Eles desistiram? "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Nesse meio tempo fomos reconstruindo o muro, até que em toda a sua extensão chegamos à metade da sua altura, pois o povo estava totalmente dedicado ao trabalho. "), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Quando, porém, Sambalate, Tobias, os árabes, os amonitas e os homens de Asdode souberam que os reparos nos muros de Jerusalém tinham avançado e que as brechas estavam sendo fechadas, ficaram furiosos."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Todos juntos planejaram atacar Jerusalém e causar confusão. Mas nós oramos ao nosso Deus e colocamos guardas de dia e de noite para proteger-nos deles. "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(placas) Eles pediram ajuda a Deus? Mas por que colocaram guardas? Será que precisamos fazer nossa parte também? Se cada um fizer sua parte, fica mais fácil ou mais difícil vencer os problemas?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Enquanto isso, o povo de Judá começou a dizer: 'Os trabalhadores já não têm mais forças e ainda há muito entulho. Por nós mesmos não conseguiremos reconstruir o muro'."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Alguns começaram a desanimar e falar coisas que desanimavam os outros. Que difícil!"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("E os nossos inimigos diziam: 'Antes que descubram qualquer coisa ou nos vejam, estaremos bem ali no meio deles; vamos matá-los e acabar com o trabalho deles'."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Que situação difícil, todos estavam com medo e desanimados! Mas continuei tentando unir o povo para fazermos o nosso melhor na reconstrução dos muros e na defesa do trabalho. "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Os judeus que moravam perto deles dez vezes nos preveniram: 'Para onde quer que vocês se virarem, saibam que seremos atacados de todos os lados'. Deus usou esses judeus para nos avisarem! Por isso posicionei alguns do povo atrás dos pontos mais baixos do muro, nos lugares abertos, divididos por famílias, armados de espadas, lanças e arcos."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Fiz uma rápida inspeção e imediatamente disse aos nobres, aos oficiais e ao restante do povo: 'Não tenham medo deles. Lembrem-se de que o Senhor é grande e temível, e lutem por seus irmãos, por seus filhos e por suas filhas, por suas mulheres e por suas casas'. Todos se uniram e fizeram isso, confiando mais uma vez em Deus."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Quando os nossos inimigos descobriram que sabíamos de tudo e que Deus tinha frustrado a sua trama, todos nós voltamos para o muro, cada um para o seu trabalho."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("(fig.6.3) Daquele dia em diante, enquanto a metade dos meus homens fazia o trabalho, a outra metade permanecia armada de lanças, escudos, arcos e couraças. Os oficiais davam apoio a todo o povo de Judá que estava construindo o muro. Aqueles que transportavam material faziam o trabalho com uma mão e com a outra seguravam uma arma, e cada um dos construtores trazia na cintura uma espada enquanto trabalhava; e comigo ficava um homem pronto para tocar a trombeta."), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->MultiCell(0, 15, utf8_decode("Então eu disse aos nobres, aos oficiais e ao restante do povo: 'A obra é grande e extensa, e estamos separados, distantes uns dos outros, ao longo do muro. Do lugar de onde ouvirem o som da trombeta, juntem-se a nós ali. Nosso Deus lutará por nós!' Dessa maneira prosseguimos o trabalho com metade dos homens empunhando espadas, desde o raiar da alvorada até o cair da tarde."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Naquela ocasião eu também disse ao povo: 'Cada um de vocês e o seu ajudante devem ficar à noite em Jerusalém, para que possam servir de guarda à noite e trabalhar durante o dia'. Eu, os meus irmãos, os meus homens de confiança e os guardas que estavam comigo nem tirávamos a roupa, e cada um permanecia de arma na mão. (Neemias 4:1-23)"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(fig.6.4) Finalmente conseguimos completar todo o muro e todas as portas e agora Jerusalém está protegida novamente para começarmos a reconstruí-la. (término do monólogo)"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Vocês acham que eles teriam conseguido vencer os inimigos e trabalharem na reconstrução do muro se não tivessem confiado em Deus e ficado unidos? Estar junto é o mesmo que estar unido? Qual a diferença? No nosso grupo temos estado juntos ou unidos? O que pode nos ajudar a vencer as coisas difíceis da vida, problemas em casa, pecados? Você tem vontade de vir ao grupo quando está chateado? (Testemunhe sobre como é difícil ir a igreja quando há problemas e como estar com o povo de Deus nesses momentos ajuda a vencermos os problemas.)"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Levantando Acampamento:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Senhor nos ensina a viver juntos sem brigarmos uns com os outros e assim sermos mais fortes!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 3"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Como é bom e agradável quando os irmãos convivem em união! (Salmos 133:1)"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 3 - O Exército de Lagostas"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que exército é esse?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Onde está a força dele?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O quê ele pode fazer?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como fazer parte dele?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Porque não sair dele?"), 0, 'J');

$pdf->ln(100);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo " . $nome_usuario, 0, 1, 'J');
// F - Lição 06

$pdf->AddPage();

// I - Lução 07
//Capa
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, utf8_decode("Lição 07"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(50, 20, utf8_decode("7. Águia - Vigilância - Davi."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Preparação da área:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Como pegamos um rato? Colocamos algo que ele goste na armadilha ou misturamos com veneno. Vou mostrar a vocês um animal, uma ave, que é uma das mais difíceis de capturar. (fig.7.1) Que ave é essa? Uns a chamam de gavião de penacho. É a águia brasileira, no semanário vocês vão descobrir o nome dela. Quem já viu uma dessas? Às vezes podemos vê-la voando, mas é muuuito difícil se aproximar dela. Ela não se deixa enganar! Sabe como se caça uma ave dessas? (mostre o vídeo, se possível) Você precisa ir onde ela mora, nas florestas, colocar comida, objeto de desejo, para ela durante dias e dias. Ela não vai descer para comer nos primeiros dias, depois ela vai se aproximando dia após dia. Quando ela estiver confiante comendo todos os dias, você monta a armadilha. Você vai precisar esperar mais dias até que ela caia. É muito difícil! Você sabia que a Bíblia diz que somos como águias? Devíamos ser difíceis de cair em armadilhas, mas às vezes nos comportamos como ratos. Vamos ler sobre uma águia que caiu numa armadilha como um ratinho bobo."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Acampando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Seu nome era Davi e nós já conhecemos um pouco de sua história quando estávamos construindo o santuário. Lembram do jovem pastor que se tornou rei? Durante toda a sua vida ele foi um homem com o coração em Deus, mas um dia ele caiu numa armadilha de sua velha natureza. Prestem atenção! "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Davi era rei de Israel e sempre estava conquistando novas terras para Israel e defendendo-as dos inimigos. Davi não era um rei folgado, ele era um verdadeiro líder, ele não só mandava seu exército ir para a guerra, ele ia junto! E Deus sempre os abençoava com vitória! Mas, um dia, Davi mandou seu exército para a guerra e resolveu ficar em seu palácio. Por que vocês acham que ele tomou essa decisão? (Deixe que as crianças argumentem, ajude questionando, ex: cansado. Mas seus homens também não estavam cansados? Etc.) Vocês acham que ele tomou essa decisão de uma hora pra outra? Ou planejou e deu razões a si mesmo de que merecia ficar em casa? Bom, vamos ver o que aconteceu:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("(fig.7.2) E aconteceu que numa tarde Davi se levantou do seu leito, e andava passeando no terraço da casa real, e viu do terraço a uma mulher que se estava lavando; e era esta mulher mui formosa à vista. E mandou Davi indagar quem era aquela mulher; e disseram: Porventura não é esta Bate-Seba, filha de Eliã, mulher de Urias, o heteu?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Então enviou Davi mensageiros, e mandou trazê-la; e ela veio, e ele se deitou com ela; então voltou ela para sua casa. E a mulher concebeu; e mandou dizer a Davi: Estou grávida. "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que vocês acham dessa situação em que Davi se colocou? Mas Davi não tinha seu coração em Deus? Pensem, o que pode ter acontecido na cabeça e no coração de Davi? Primeiro ele achou que tinha mais direito que os outros de ficar em casa, depois achou que tinha direito de deitar com a mulher de um de seus fiéis soldados? (fig.7.3) Davi mandou chamar Urias e mandou-o para casa para descansar com sua mulher. O que Davi estava planejando? Que Urias pensasse que o filho era dele e ninguém soubesse de nada. Mas sabe o quê? Urias era tão fiel que se recusou a ir para casa. Ele disse a Davi:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("A arca, e Israel, e Judá ficaram em tendas; e Joabe, meu senhor, e os servos de meu senhor estão acampados no campo; e hei de eu entrar na minha casa, para comer e beber, e para me deitar com minha mulher? Pela tua vida, e pela vida da tua alma, não farei tal coisa.... E Davi o convidou, e comeu e bebeu diante dele, e o embebedou; e à tarde saiu a deitar-se na sua cama com os servos de seu senhor; porém não desceu à sua casa. E sucedeu que pela manhã Davi escreveu uma carta a Joabe; e mandou-lha por mão de Urias."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Escreveu na carta, dizendo: Ponde a Urias na frente da maior força da peleja; e retirai-vos de detrás dele, para que seja ferido e morra. Está acontecendo aqui a mesma coisa que acontece com a águia, Davi se deixou atrair pelo pecado e foi caindo na armadilha cada vez mais e pecando cada vez mais. Davi estava preso ou solto?"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->MultiCell(0, 15, utf8_decode("(fig.7.4) E, saindo os homens da cidade, e pelejando com Joabe, caíram alguns do povo, dos servos de Davi; e morreu também Urias, o heteu. Joabe mandou um mensageiro avisar a Davi: "), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("E disse o mensageiro a Davi: Na verdade que mais poderosos foram aqueles homens do que nós, e saíram a nós ao campo; porém nós fomos contra eles, até à entrada da porta."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Então os flecheiros atiraram contra os teus servos desde o alto do muro, e morreram alguns dos servos do rei; e também morreu o teu servo Urias, o heteu. E disse Davi ao mensageiro: Assim dirás a Joabe: Não te pareça isto mal aos teus olhos; pois a espada tanto consome este como aquele; esforça a tua peleja contra a cidade, e a derrota; esforça-o tu assim. Ouvindo, pois, a mulher de Urias que seu marido era morto, lamentou a seu senhor. E, passado o luto, enviou Davi, e a recolheu em sua casa, e lhe foi por mulher, e deu-lhe à luz um filho. Porém esta coisa que Davi fez pareceu mal aos olhos do Senhor. (2 Samuel 11:1-27) "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que você aprendeu com esta história? Você tem algum desejo ou pensamento que não agrada a Deus? O que você pode fazer para não cair nas armadilhas da velha natureza e de satanás? Vamos orar?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Levantando Acampamento:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Deus me ajude nas minhas fraquezas, me ajude a pedir perdão por cada pensamento errado, cada desejo errado para que eu não caia em nenhuma armadilha. Ajude-me a ficar vigiando meus pensamentos e desejos. Em nome de Jesus!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 4"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Vigiai e orai, para que não entreis em tentação; o espírito, na verdade, está pronto, mas a carne é fraca. (Marcos 14:38)"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 4 - A Armadilha da Harpia"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* O que é uma Harpia?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem são as Harpias?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como é a visão da Harpia?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem coloca a armadilha?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como escapar da armadilha?"), 0, 'J');

$pdf->ln(200);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo " . $nome_usuario, 0, 1, 'J');
// F - Lição 07

$pdf->AddPage();

// I - Lição 08
//Capa
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, utf8_decode("Lição 08"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(50, 20, utf8_decode("8. Águia - Liberdade da armadilha - Davi."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Preparação da área:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Trace 5 linhas, a do meio dividirá os 2 times. As 2 próximas, 1 de cada lado, mais afastadas, serão zona de guerra. Atrás delas, será a zona de segurança. E as últimas 2, 1 de cada lado, no fundo, serão prisões. Cada grupo escolhe alguém para ser o prisioneiro. O objetivo é livrar os prisioneiros tocando em suas mãos. As zonas de segurança podem ser usadas por ambos os grupos. Quem for tocado irá para a zona de prisão. Marque um tempo. Quem estiver com menos presos no final, ganha. Foi difícil a brincadeira? Perder a liberdade, muitas vezes é bem fácil, mas e ganhá-la de volta? Também é fácil? Davi perdeu sua liberdade pecando. Ele não vigiou e ficou preso pelos seus pecados. (fig.8.1) Seu filho com Bateseba nasceu, mas Ele ainda não havia pedido perdão por seus pecados. Vamos ver se ele conseguiu se libertar."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Acampando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(fig.8.2) Existia um profeta muito amigo de Davi. Seu nome era Natã."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("E o SENHOR enviou Natã a Davi; e, apresentando-se ele a Davi, disse-lhe: Havia numa cidade dois homens, um rico e outro pobre. O rico possuía muitíssimas ovelhas e vacas. Mas o pobre não tinha coisa nenhuma, senão uma pequena cordeira que comprara e criara; e ela tinha crescido com ele e com seus filhos; do seu bocado comia, e do seu copo bebia, e dormia em seu colo, e a tinha como filha. E, vindo um viajante ao homem rico, deixou este de tomar das suas ovelhas e das suas vacas para assar para o viajante que viera a ele; e tomou a cordeira do homem pobre, e a preparou para o homem que viera a ele."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que vocês acham dessa história? Foi justo o que o rico fez, tirando a única ovelha do pobre em vez de pegar uma das suas? O que você faria com o rico? Vamos ver como Davi reagiu a essa história do de Natã."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Então o furor de Davi se acendeu em grande maneira contra aquele homem, e disse a Natã: Vive o Senhor, que digno de morte é o homem que fez isso. E pela cordeira tornará a dar 4 vezes mais, porque fez tal coisa, e porque não se compadeceu. Então disse Natã a Davi: Tu és este homem. Assim diz o Senhor Deus de Israel: Eu te ungi rei sobre Israel, e eu te livrei das mãos de Saul; E te dei a casa de teu senhor, e as mulheres de teu senhor em teu seio, e também te dei a casa de Israel e de Judá, e, se isto é pouco, mais te acrescentaria tais e tais coisas. Por que, pois, desprezaste a palavra do Senhor, fazendo o mal diante de seus olhos? A Urias, o heteu, feriste à espada, e a sua mulher tomaste por tua mulher; e a ele mataste com a espada dos filhos de Amom. Agora, pois, não se apartará a espada jamais da tua casa, porquanto me desprezaste, e tomaste a mulher de Urias, o heteu, para ser tua mulher. Assim diz o Senhor: Eis que suscitarei da tua própria casa o mal sobre ti, e tomarei tuas mulheres perante os teus olhos, e as darei a teu próximo, o qual se deitará com tuas mulheres perante este sol. (2 Samuel 12:1-11)"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Quem será que contou tudo o que Davi fez para Natã? Deus sabe todas as coisas, Vocês acham que Deus conhece nossos pensamentos e as coisas escondidas que fazemos? Ele sabe tudo, Deus não queria que Davi continuasse escravo de seu pecado, ele e todo o povo de Israel iriam sofrer com um rei pecador. Pessoas em nosso país sofrem por causa de governantes que pecam? E o que Deus falou que iria acontecer com Davi? Deus disciplina seus filhos para que sejam libertos de seus pecados. O que será que Davi fez? (fig.8.3) Davi reconheceu seu pecado, e chorou muito. Pediu perdão a Deus. Infelizmente precisou sofrer as consequências do que havia feito. Seu filhinho morreu e um de seus filhos maiores seguiu o exemplo do pai e começou a pecar contra Deus e contra seu próprio pai. Você acha que precisa se arrepender de algo em sua vida? (fig.8.4) Você tem vigiado como a harpia, para não cair em armadilhas? (Conte um testemunho de arrependimento em sua vida). Vamos orar!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Levantando Acampamento:"), 0, 1, 'L');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Deus, nos ajude a vigiarmos nossos corações todos os dias para que não se encham de pecado e nos levem a sofrer!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 4"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Vigiai e orai, para que não entreis em tentação; o espírito, na verdade, está pronto, mas a carne é fraca. (Marcos 14:38)"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 4 - A Armadilha da Harpia"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* O que é uma Harpia?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem são as Harpias?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como é a visão da Harpia?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem coloca a armadilha?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como escapar da armadilha?"), 0, 'J');

$pdf->ln(500);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo " . $nome_usuario, 0, 1, 'J');
// F - Lição 08

$pdf->AddPage();

// I - Resposta do Mistério
//$pdf->Image('logog8.jpg');
$pdf->Ln(8);
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 5, utf8_decode("CAMP BRASIL"), 0, 1, 'C');
$pdf->Ln(8);
$pdf->Cell(0, 5, "", "B", 1, 'C');
$pdf->Ln(8);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', 'B', 14);

if ($xL != 0 or $xD != 0) {
	$pdf->Cell(150, 20, utf8_decode("$nivel:"), 0, 0, 'J');
} else {
	$pdf->Cell(150, 20, utf8_decode("$nivel:"), 0, 0, 'J');
}

$pdf->Cell(0, 20, utf8_decode($nome_usuario), 0, 1, 'J');
$pdf->Ln(8);

$pdf->Cell(60, 20, utf8_decode("Módulo:"), 0, 0, 'J');
$pdf->Cell(0, 20, utf8_decode($modulo['nome_modulo']), 0, 1, 'J');
$pdf->Ln(8);

$pdf->Ln(300);
$pdf->SetFont('arial', 'B', 18);
$pdf->MultiCell(0, 15, utf8_decode("Respostas de Mistérios - Expedição Animal 1 - Os Segredos"), 0, 'C');
$pdf->Ln(8);
$pdf->Cell(0, 5, "", "B", 1, 'C');
$pdf->Ln(400);

// 01

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 1 - As Borboletas de 2 Pupas"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Qual o segredo das pupas? - A Metamorfose."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quando começamos nossa mertamorfose? - Na 1ª pupa com a conversão."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* E a 2ª pupa para que serve? - A santificação no dia a dia."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que acontece na nossa 2ª pupa? - Arrependimento e confissão."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* E se não entrar na pupa? - Vou perdendo a liberdade."), 0, 'J');

// 02

$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 2 - O Adesivo Secreto"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que adesivo é este? - O da pata da lagartixa."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Que segurança ele dá? - De que ela não vai cair."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Qual o nosso adesivo secreto? - Apegar-se a Palavra de Deus."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Que segurança temos? - De que vamos estar seguros."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quando ele funciona? - Sempre."), 0, 'J');

// 03
$pdf->Ln(10);
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 3 - O Exército de Lagostas"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que exército é esse? - O corpo de Jesus, a igreja."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Onde está a força dele? - Na união com Deus e com os irmãos."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O quê ele pode fazer? - Evangelizar."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como fazer parte dele? - Crendo em Jesus e estando com o grupo."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Porque não sair dele? - Para não ficar fraco."), 0, 'J');

// 04
$pdf->Ln(10);
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 4 - A Armadilha da Harpia"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* O que é uma Harpia? - Uma águia brasileira."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem são as Harpias? - Somos nós."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como é a visão da Harpia? - Do alto, a visão de Deus."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem coloca a armadilha? - Os nossos desejos descontrolados e o inimigo de Deus."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como escapar da armadilha? - Sendo vigilante com desejos e pensamentos."), 0, 'J');

$pdf->ln(300);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo " . $nome_usuario, 0, 1, 'J');
// F - Resposta do Mistério

$nome_relatorio = utf8_decode("Expedição Animal 1 - Os Segredos");
$pdf->Output("$nome_relatorio.pdf", "I");
