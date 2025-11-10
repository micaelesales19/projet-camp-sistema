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
$pdf->Cell(0, 5, utf8_decode("Máterial Expedição Animal 2- Os Sobreviventes"), 0, 1, 'C');
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
$pdf->Cell(50, 20, utf8_decode("1. Ester é coroada - Galinha - Dependência de Deus  Arrumando a mochila."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Arrumando a mochila:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Bem vindos à 'Expedição animal 2 – Os sobreviventes!' Nesta expedição vamos conhecer alguns animais que são comuns na caatinga. O nosso primeiro animal é a galinha!(fig.1.1) Agora escutem este versículo: 'Jerusalém, Jerusalém, você, que mata os profetas e apedreja os que lhe são enviados! Quantas vezes eu quis reunir os seus filhos, como a galinha reúne os seus pintinhos debaixo das suas asas, mas vocês não quiseram.' Mateus 23:27"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Quem está falando? A que animal Deus está se comparando? Como assim? Por quê? Como a galinha se comporta quando está com filhotes?(fig.1.2) https://www.youtube.com/watch?v=bPSpzju-Xnw"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Eles sabem fazer tudo sozinhos? Eles precisam da galinha? Eles dependem dela e ela os ensina e os protege! A Bíblia nos conta a história de reis e rainhas, alguns deles eram como pintinhos rebeldes e outros eram como pintinhos que dependiam de Deus em tudo! Escutem:"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Configurando o GPS:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Há muito tempo atrás, por volta do ano 483 a.C o maior rei que existia no mundo se chamava Xerxes ou Assuero. Seu reino ia da Índia até a Etiópia, imagine toda a Europa, India e metade da África pertencer a um só Rei. Ele devia ser vaidoso e se achar um deus! No terceiro ano de seu reinado Ele resolveu comemorar, escutem o que a Palavra nos diz sobre a comemoração:(Fig.1.3) ...Durante cento e oitenta dias ele mostrou a enorme riqueza de seu reino e o esplendor e a glória de sua majestade. Terminados esses dias, no jardim interno do palácio, o rei deu um banquete de sete dias para todo o povo que estava na cidadela de Susã, do mais rico ao mais pobre. Ester 1:4-5 Na Bíblia descreve as riquezas dele e vocês poderão ler em casa."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Enquanto isso, a rainha Vasti(sua esposa) também oferecia um banquete às mulheres, no palácio do rei Xerxes. Ao sétimo dia, quando o rei Xerxes já estava alegre por causa do vinho, ordenou aos sete oficiais que o serviam que trouxessem à sua presença a rainha Vasti,... esta se recusou a ir, de modo que o rei ficou furioso e indignado. Ester 1:9-12"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Um rei deve ser obedecido? Imaginem se hoje um presidente pedisse a sua esposa que viesse para uma festa para apresentá-la a seus convidados e ela se recusasse. O que as pessoas pensariam? Ficaria chato? Agora imaginem Xerxes, ele era vaidoso e se achava um Deus, vocês acham que ele acreditava no Deus verdadeiro? O que ele deve ter pensado? E Vasti? Talvez ela pensasse que por ser rainha poderia fazer o que quisesse, não dependeria de ninguém. O quê você acha, se eles conhecessem a Deus o que teriam feito algo diferente? Mas vamos ver o que Xerxes fez com sua esposa desobediente:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Fig. 1.3) Como era costume o rei consultar especialistas em questões de direito e justiça, ele mandou chamar os sábios que entendiam das leis. E o rei lhes perguntou: 'De acordo com a lei, o que se deve fazer à rainha Vasti? Ela não obedeceu à ordem do rei Xerxes transmitida pelos oficiais'. Ester 1:15"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Os sábios disseram que Vasti deveria deixar de ser rainha e assim foi feito. Algum tempo depois o rei sentiu falta de Vasti e tornou a consultar os sábios."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Então os conselheiros do rei sugeriram que se procurassem virgens lindas para o rei. Ester 2:2"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("As virgens começaram a ser procuradas em cada província do império e trazidas ao harém do rei para receberem um tratamento de beleza, depois disto, o rei faria sua escolha."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Ora, na cidadela de Susã havia um judeu chamado Mardoqueu, ... ele tinha uma prima chamada Hadassa(Ester), que havia sido criada por ele, por não ter pai nem mãe. ... Ester 2:25,7"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Deve ser difícil ser criada por outras pessoas, o que vocês acham? Mas se não fosse o tio, será que a situação de Ester seria melhor ou pior? Com certeza pior!!! Que será que Ester pensava? Será que ela vivia se queixando ou agradecendo a Deus porque alguém a protegia e cuidava? Se fosse você o que faria? Mas sabe o que aconteceu com ela?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Ester também foi trazida ao palácio do rei e confiada a Hegai, encarregado do harém. Ester não tinha revelado a que povo pertencia nem a origem da sua família, ... Ester 2:10"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Durante o tempo de preparo das moças, antes de serem mostradas ao rei, Ester fez o melhor que pôde. E um dia..."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Ela foi levada ao rei Xerxes, à residência real, ...(Fig.1.4) Ora, o rei gostou mais de Ester do que de qualquer outra mulher, e ela foi favorecida por ele e ganhou sua aprovação mais do que qualquer das outras virgens. Então ele lhe colocou uma coroa real e tornou-a rainha no lugar de Vasti.... Ester 2:16,17"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Já imaginou se tornar poderoso/a da noite para o dia? Será que Ester iria se esquecer de que sempre devia depender de Deus e que Ele é que a protegia? Agora teria um rei para protegê-la, o que vocês acham? Ou talvez ela poderia pensar que não precisava da proteção de mais ninguém! Vamos continuar:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Um dia, quando Mardoqueu estava sentado junto à porta do palácio real, Bigtã e Teres, dois dos oficiais do rei que guardavam a entrada, estavam indignados e conspiravam para assassinar o rei Xerxes. Mardoqueu, porém, descobriu o plano e contou-o à rainha Ester, que, por sua vez, passou a informação ao rei, em nome de Mardoqueu. Depois de investigada a informação e descobrindo-se que era verdadeira, os dois funcionários foram enforcados. Tudo isso foi escrito nos registros históricos, na presença do rei. Ester 2:21-23"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Depois disso, um homem chamado Hamã foi promovido pelo rei e todos os oficiais e o povo deveriam se curvar quando ele passasse. Mardoqueu não fazia isso. Por que será que ele não se curvava? O que significa se curvar para alguém? Para quem você deve se curvar? A mesma coisa respondia Mardoqueu quando questionavam sua atitude. Hamã ficou sabendo e ficou furioso. Ele decidiu matar, não somente Mardoqueu mas todo o judeu!"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Hamã então tirou na sorte, quando esse plano deveria ser colocado em prática. A sorte deu 11, dali a 11 meses todos os judeus deveriam ser mortos! E eis o plano de Hamã: Naquele mesmo mês Hamã disse ao rei ..."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Existe certo povo disperso e espalhado entre os povos de todas as províncias de teu império, cujos costumes são diferentes dos de todos os outros povos e que não obedecem às leis do rei; não convém ao rei tolerá-los. Se for do agrado do rei, que se decrete a destruição deles. Ester 3:8,9"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O rei concordou e no mesmo mês Hamã enviou cartas com o selo do rei para todas as províncias para que dali a 11 meses todos os judeus fossem mortos. Era lei! E agora? Será que Deus iria conseguir protegê-los? Será que Ester morreria também? Como você acha que Deus poderia protegê-los? Os judeus eram poucos e os persas eram milhares! (compartilhe com as crianças uma situação em que você buscou refúgio e dependeu de Deus).  Você gostaria de orar pedindo a proteção de Deus para algo que esteja acontecendo com você?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Partiu Mochilar:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração -Deus nos ajude a confiar na tua proteção e sermos como pintinhos obedientes que  	correm para o Senhor e dependem do Senhor sempre."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 1"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Ele o cobrirá com as suas penas, e sob as suas asas você encontrará refúgio; a fidelidade dele será o seu escudo protetor. Salmos 91:4"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 1 - O Refúgio secreto"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Quem pode entrar nesse refúgio?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como entrar no refúgio secreto?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que essa qualidade significa?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que encontramos no refúgio secreto?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que acontece se saímos do refúgio?"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->ln(700);
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
$pdf->Cell(50, 20, utf8_decode("2. Ester se arrisca – Galinha - Dependência de Deus nas dificuldades."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Arrumando a mochila:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Dê uma folha de papel velho para cada um e coloque uma tesoura no meio da roda. Peça que todos dividam a folha ao meio continuamente, até que seja impossível. Se perguntarem se podem rasgar com as mãos, diga que eles devem decidir!)"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Muitas vezes olhamos as coisas que parecem fáceis de serem feitas e não  pedimos a ajuda de Deus, pois podemos fazer sozinhos. Assim foi com a tesoura quando estava fácil a tarefa poucos se lembraram da tesoura, porém quando a tarefa começou a se tornar difícil, todos pensaram nela. Agora me responda: As pessoas buscam Deus, quando a vida está fácil? Quando é que elas buscam a Deus? Quando devemos buscar a Deus e depender dEle? Será que alguém na história procurou depender de Deus. Vamos ver..."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Configurando o GPS:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("A lei para que os judeus fossem mortos tinha percorrido todos os reinos. (Fig. 2.1)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mardoqueu soube de tudo o que tinha acontecido, rasgou as vestes, vestiu-se de pano de saco e cinza, e saiu pela cidade, chorando amargamente em alta voz. Você sabe porque Mardoqueu se vestiu com um saco e jogou cinza sobre si? Isto representava sua grande tristeza e aflição pelo que estava acontecendo. Foi até a porta do palácio real, mas não entrou, porque ninguém vestido de pano de saco tinha permissão de entrar."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Em cada província onde chegou o decreto com a ordem do rei, houve grande pranto entre os judeus, com jejum, choro e lamento. Muitos se deitavam em pano de saco e em cinza. Quando as criadas de Ester e os oficiais responsáveis pelo harém lhe contaram sobre Mardoqueu, ela ficou muito aflita e mandou-lhe roupas para que ele as vestisse e tirasse o pano de saco; mas ele não quis aceitá-las. Então Ester convocou Hatá, um dos oficiais do rei, nomeado para ajudá-la, e deu-lhe ordens para descobrir o que estava perturbando Mardoqueu e porque ele estava agindo assim. Ester 4:1-5"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Hatá foi até Mardoqueu e este lhe contou o que havia acontecido, lhe deu cópia do decreto do rei e mandou dizer a Ester que ela deveria ir ao Rei e pedir por seu povo. Ester mandou um recado de volta dizendo:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("'Todos os oficiais do rei e o povo das províncias do império sabem que existe somente uma lei para qualquer homem ou mulher que se aproxime do rei no pátio interno sem por ele ser chamado: será morto, a não ser que o rei estenda o cetro de ouro para a pessoa e lhe poupe a vida. E eu não sou chamada à presença do rei há mais de trinta dias'."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Como Ester estava se sentindo? Será que ela estava se lembrando de buscar refúgio em Deus? E Mardoqueu? O que acontece quando algo muito difícil acontece conosco? Como ficamos? Por que? Assim ficaram Mardoqueu e Ester. Esta foi a resposta de Mardoqueu para Ester: ..."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("'Não pense que pelo fato de estar no palácio do rei, de todos os judeus só você escapará, pois, se você ficar calada nesta hora, socorro e livramento surgirão de outra parte para os judeus, mas você e a família de seu pai morrerão. Quem sabe se não foi para um momento como este que você chegou à posição de rainha?'"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Parece que Mardoqueu pensou em algo importante. Talvez Ester estivesse se sentindo segura como Rainha, estivesse pensando que o Rei iria protegê-la ou que ele nunca saberia que ela era judia. Qual você acha que foi a reação de Ester quando pensou sobre as palavras de Mardoqueu? Você acha que ela ficou com medo? O que você acha que acontece quando saímos da proteção de Deus e buscamos proteção em pessoas? Em quem as pessoas buscam proteção? De quem elas muitas vezes escolhem depender? Ester deve ter pensado bem e colocado na balança. O que é melhor? Depender da proteção de Deus ou da proteção do rei? Prestem atenção em sua resposta e veja o que ela resolveu:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Então Ester mandou esta resposta a Mardoqueu: 'Vá reunir todos os judeus que estão em Susã, e jejuem em meu favor. Não comam nem bebam durante três dias e três noites. Eu e minhas criadas jejuaremos como vocês. Depois disso irei ao rei, ainda que seja contra a lei. Se eu tiver que morrer, morrerei'. Ester 4:11-16"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Três dias depois, Ester vestiu seus trajes de rainha e colocou-se no pátio interno do palácio, em frente ao salão do rei. (Fig.2.3) O rei estava no trono, de frente para a entrada."), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->MultiCell(0, 15, utf8_decode("Quando viu a rainha Ester ali no pátio, teve misericórdia dela e estendeu-lhe o cetro de ouro que tinha na mão. Ester aproximou-se e tocou a ponta do cetro. E o rei lhe perguntou: 'Que há, rainha Ester? Qual é o seu pedido? Mesmo que seja a metade do reino, lhe será dado'. Respondeu Ester: 'Se for do agrado do rei, venha com Hamã a um banquete que lhe preparei'. Ester 5:1-4"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O rei e Hamã foram ao banquete de Ester e na saída Hamã viu Mordecai, ao chegar em casa ele e sua mulher planejaram construir uma forca para Mardoqueu. No dia seguinte Ele foi até o rei para pedir que Mardoqueu fosse enforcado. Porém o rei tinha ficado acordado à noite e resolveu ler o livro das crônicas, lembrou de Mardoqueu e quando Hamã chegou perguntou-lhe o que deveria ser feito ao homem a quem o rei quisesse honrar. Hamã pensou que as honras seriam para ele e falou ao rei. O rei mandou que fosse feito aquilo com Mardoqueu. Hamã, enfurecido teve que levar seu inimigo vestido com a capa e o brasão do rei pela cidade para que fosse honrado. À noite foi à outro banquete de Ester e o rei lhe perguntou novamente o que poderia fazer por ela."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Então a rainha Ester respondeu (Fig.2.4) 'Se posso contar com o favor do rei, e se isto lhe agrada, poupe a minha vida e a vida do meu povo; este é o meu pedido e o meu desejo. Pois eu e meu povo fomos vendidos para destruição, morte e aniquilação. Se apenas tivéssemos sido vendidos como escravos e escravas, eu teria ficado em silêncio, porque nenhuma aflição como essa justificaria perturbar o rei'."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("O rei Xerxes perguntou à rainha Ester: 'Quem se atreveu a uma coisa dessas? Onde está ele? ' Respondeu Ester: 'O adversário e inimigo é Hamã, esse perverso'. ... Furioso, o rei levantou-se, deixou o vinho, saiu dali e foi para o jardim do palácio. E percebendo Hamã que o rei já tinha decidido condená-lo, ficou ali para implorar por sua vida à rainha Ester. Ester 7:1-8"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O rei pensou que Hamã estava atacando Ester e mandou enforca-lo na mesma forca que estava preparada para Mardoqueu."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Depois disso o rei, a pedido de Ester, escreveu outro decreto permitindo aos judeus se defendessem no dia que fossem atacados e concedeu a Mardoqueu o lugar de Hamã. Será que foi fácil para Ester depender da proteção de Deus? O que Deus fez por ela e seu povo? O que Ele pode fazer por você se você buscar a proteção e a ajuda dEle sempre? Você quer orar agora e entregar tudo a Deus? "), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Partiu Mochilar:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Deus obrigado porque o Senhor nos protege e ajuda mesmo nos momentos mais  difíceis, me ajuda a sempre depender do senhor e nunca de pessoas."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 1"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Ele o cobrirá com as suas penas, e sob as suas asas você encontrará refúgio; a fidelidade dele será o seu escudo protetor. Salmos 91:4"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 1 - O Refúgio secreto"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Quem pode entrar nesse refúgio?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como entrar no refúgio secreto?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que essa qualidade significa?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que encontramos no refúgio secreto?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que acontece se saímos do refúgio?"), 0, 'J');

$pdf->ln(5);
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
$pdf->Cell(50, 20, utf8_decode("3. Saul é coroado - Morcego – Direção do Espírito   "), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Arrumando a mochila:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Na nossa expedição de hoje vamos conhecer um animal que se move e caça no escuro. E ele não enxerga no escuro. Então como ele faz isso? Você sabe que animal é esse? O morcego (Fig.3.1). Você já viu um morcego? Sabia que ele possui um ecolocalizador? Mas o que é isso? O que é um eco? Ele acontece quando um som é emitido e reflete em alguma superfície e volta para você. O som viaja em ondas e volta também em ondas. O morcego emite sons e esse som vai até os objetos ou animais em volta dele e volta mostrando o tamanho e a distância entre o morcego e o animal ou objeto. https://www.youtube.com/watch?v=49izG4eVoVM"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Será que humanos podem fazer isso?(Veja este vídeo e selecione uma parte dele para mostrar as crianças como a ecolocalização funciona.) https://www.youtube.com/watch?v=vTDlveYlcEM  Vocês viram como funciona? O que aconteceria com o morcego se ele não tivesse um ecolocalizador? Então ela protege e ajuda o morcego a se alimentar? Você sabia que aqueles que já foram feitos filhos de Deus também possuem algo que os protege e direciona? Lembram-se do Espírito Santo que passa a morar no santuário, que é nossa vida, quando nos entregamos ao Senhor?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Não sabeis vós que sois o templo de Deus e que o Espírito de Deus habita em vós? I Coríntios 3:16"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Pois é, o Espírito Santo habita na vida dos filhos de Deus, antes de Jesus, Deus o mandava para algumas pessoas específicas e às vezes somente em momentos específicos. Você quer ouvir sobre a história de um homem que tinha esse ecolocalizador de Deus?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Configurando o GPS:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O povo de Israel não tinha rei, por muito tempo tinha sido guiado por profetas. Você sabe o que é um profeta? Alguém que fala da parte de Deus. Deus falava com eles e eles falavam ao povo. O que vocês acham dessa situação? As pessoas de Israel não estavam satisfeitas. Elas não queriam um profeta, queriam um rei que pudessem ver e pegar, então começaram a reclamar com Deus pedindo um rei. Veja o que Deus fez: (Fig3.2)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Havia um homem de Benjamim, rico e influente, chamado Quis, .... Ele tinha um filho chamado Saul, jovem de boa aparência, sem igual entre os israelitas; os mais altos batiam nos seus ombros. 1 Samuel 9:1,2"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Um dia, algumas jumentas se perderam e Quis mandou que Saul e alguns servos fossem procurá-las.  Eles atravessaram os montes de Efraim e a região de Salisa, mas não as encontraram. Prosseguindo, entraram no distrito de Saalim, mas as jumentas não estavam lá. Então atravessaram o território de Benjamim, e mesmo assim não as encontrou. Chegando ao distrito de Zufe, disse Saul ao seu servo: 'Vamos voltar, ou meu pai deixará de pensar nas jumentas para começar a preocupar-se conosco'. 1 Samuel 9:4,5"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mas um de seus servos disse que, naquela cidade, havia um homem de Deus e que ele poderia ajudá-los. Eles perguntaram onde ele estava e se dirigiram para lá. Seu nome era Samuel. Será que Saul iria querer conversar com o profeta? Ouvir o homem de Deus?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("No dia anterior à chegada de Saul, o Senhor havia revelado isto a Samuel: 'Amanhã, por volta desta hora, enviarei a você um homem da terra de Benjamim. Unja-o como líder sobre meu povo Israel; ele libertará o meu povo das mãos dos filisteus. Atentei para o meu povo, pois seu clamor chegou a mim'. Quando Samuel viu Saul, o Senhor lhe disse: 'Este é o homem de quem lhe falei; ele governará o meu povo'. 1 Samuel 9:15-17 Samuel, então, falou para Saul que tinha algo da parte de Deus para lhe falar. Mais tarde naquele dia ...enquanto desciam para a saída da cidade, Samuel disse a Saul: 'Diga ao servo que vá na frente'. O servo foi. Samuel prosseguiu: 'Fique você aqui um instante, para que eu lhe dê uma mensagem da parte de Deus'. 1 Samuel 9:27 (Fig.3.3) Então Samuel apanhou um jarro de óleo, derramou-o sobre a cabeça de Saul e o beijou, dizendo: 'O Senhor o tem ungido como líder da herança dele. 1 Samuel 10:1'"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Ao chegar à cidade, você encontrará um grupo de profetas descendo do altar no monte tocando liras, tamborins, flautas e harpas; e eles estarão profetizando. O Espírito do Senhor se apossará de você, e com eles você profetizará em transe, e será um novo homem. Assim que esses sinais tiverem se cumprido, faça o que achar melhor, pois Deus está com você. 1 Samuel 10:5-7"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode(" Quem iria estar com Saul? E como seria Saul depois que o Espírito estivesse com ele? Qual a última frase de Samuel? Saul recebeu de Deus o Espírito e não precisava de mais nada? Não precisaria mais de Deus? Quem é o Espírito do Senhor, Espírito Santo? Então Deus, através do Espírito, habitaria nele? Lembram do santuário? O Espírito habita em você? Desde quando? Ainda precisamos buscar a Deus? Por quê? Como buscamos a Deus? Será que Saul continuou buscando a Deus? Vamos ver:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Samuel, convocou todo o povo de Israel e falou da arte de Deus ao povo. Assim diz o Senhor, o Deus de Israel: 'Eu tirei Israel do Egito, e libertei vocês do poder do Egito e de todos os reinos que os oprimiam'. Mas vocês agora rejeitaram o Deus que os salva de todas as suas desgraças e angústias. E disseram: 'Não! Escolhe um rei para nós'. Por isso, agora, apresentem-se perante o Senhor, de acordo com as suas tribos e clãs. Tendo Samuel feito todas as tribos de Israel se aproximarem, a de Benjamim foi escolhida. Então fez ir à frente a tribo de Benjamim, clã por clã, e o clã de Matri foi escolhido. Finalmente foi escolhido Saul, filho de Quis. Quando, porém, o procuraram, ele não foi encontrado. Então consultaram novamente o Senhor: 'Ele já chegou?' E o Senhor disse: 'Sim, ele está escondido no meio da bagagem'. Então correram e o tiraram de lá. (Fig.3.4) Quando ficou de pé no meio do povo; os mais altos do povo batiam-lhe nos ombros. E Samuel disse a todos: 'Vocês vêem o homem que o Senhor escolheu? Não há ninguém como ele entre todo o povo'. Então todos gritaram:'Viva o rei!' 1 Samuel 10:18-24"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Saul, mesmo com medo, a ponto de se esconder no começo, assumiu a tarefa que Deus lhe deu.  Começou a reinar tentando obedecer a Palavra de Deus. Mas um dia, se viu numa situação difícil, ele estava em guerra contra os Amonitas e começou a perder. Samuel, o profeta estava indo ao seu encontro para oferecer sacrifício a Deus e pedir a sua ajuda, o profeta devia fazer isso. Mas o medo de Saul fez ele se desesperar e em vez de esperar em Deus, ele mesmo fez um sacrifício. Quando Samuel chegou, perguntou:"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("'O que você fez?' Saul respondeu: 'Quando vi que os soldados estavam se dispersando e que você não tinha chegado no prazo estabelecido...' pensei: 'Agora, os filisteus me atacarão em Gilgal, e eu não busquei o Senhor'. Por isso senti-me obrigado a oferecer o holocausto.  Disse Samuel: 'Você agiu como tolo, desobedecendo ao mandamento que o Senhor seu Deus lhe deu; se você tivesse obedecido, ele teria estabelecido para sempre o seu reinado sobre Israel. Mas agora seu reinado não permanecerá...' 1 Samuel 13:11-14"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Ele havia obedecido a palavra? Mas ele não tinha o Espírito? Cuidado! A direção do Espírito Santo nunca vai ser diferente do que diz a Palavra. Então quem tomou a decisão errada? Saul ou o Espírito? Então mesmo tendo o Espírito Santo podemos errar? Como evitar a direção errada? Como evitar bater de frente com a vontade de Deus? Israel não enfrentou os Amonitas naquele dia, e Saul deve ter ficado muito triste com o castigo do Senhor. Ele não havia obedecido a direção de Deus e errou. Vamos orar e agradecer a Deus pelo seu Espírito santo que habita em nós para nos ajudar a termos a direção certa em nossas decisões e evitarmos desastres em nossas vidas."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Partiu Mochilar:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Deus obrigado porque o Senhor nos deu o Espírito Santo, nos ajude a obedecermos a  	tua Palavra e seguirmos na direção que o Espírito apontar."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 2"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mas o Conselheiro, o Espírito Santo, que o Pai enviará em meu nome, lhes ensinará todas as coisas e lhes fará lembrar tudo o que eu lhes disse. João 14:26"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 2 - O Super Ecolocalizador"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que Ecolocalizador é esse?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem o possui?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que ele faz?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Através de quê ele faz isto?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Que acontece se o desprezamos?"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->ln(650);
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
$pdf->Cell(50, 20, utf8_decode("4. Queda de Saul - Morcego - Obediência a voz do Espírito."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Arrumando a mochila:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Ligue um rádio, vá mudando as estações e pergunte às crianças: Quantas vozes diferentes vocês puderam ouvir nesse rádio? Quantas coisas diferentes elas falavam? (Fig.4.1) Agora vamos lembrar do morcego, quantos sons ele ouve todos os dias? Como ele diferencia o som de sua presa no seu ecolocalizador? Ele o conhece! Como saber se o que ouvimos é o Espírito Santo ou algo de nossa própria cabeça? Sabe como? Vamos pesquisar o nosso GPS, a Bíblia, na história de Saul, se ele reconheceu e seguiu seu ecolocalizador e o que aconteceu. "), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Configurando o GPS:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Saul havia desobedecido a Deus. Ele, então, mandou que Samuel fosse até Saul, talvez Deus quisesse dar a Saul outra chance para obedecê-lo."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Samuel disse a Saul:'Eu sou aquele a quem o Senhor enviou para ungi-lo como rei de Israel, o povo dele; por isso escute agora a mensagem do Senhor. Assim diz o Senhor dos Exércitos: 'Castigarei os amalequitas pelo que fizeram a Israel, atacando-os quando saíam do Egito. Agora vão, ataquem os amalequitas e consagrem ao SENHOR para destruição tudo o que lhes pertence. ...'. 1 Samuel 15:1-3"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que Saul deveria fazer? Deveria sobrar algo vivo? Vamos ver o que ele fez... (Fig. 4.2)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Saul atacou os amalequitas ... Mas Saul e o exército pouparam Agague (Rei dos Amalequitas) e o melhor das ovelhas e dos bois, os bezerros gordos e os cordeiros. Pouparam tudo que era bom, mas a tudo que era desprezível e inútil destruíram por completo. Saul obedeceu a Deus? Por que será que ele fez isso? Então o Senhor falou a Samuel: 'Arrependo-me de ter constituído a Saul rei, pois ele me abandonou e não seguiu as minhas instruções'. Samuel ficou irado e clamou ao Senhor toda aquela noite."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("De madrugada Samuel foi ao encontro de Saul, ... Quando Samuel o encontrou, Saul disse: 'O Senhor o abençoe! Segui as instruções do Senhor'. Samuel, porém, perguntou: 'Então que balido de ovelhas é esse que ouço com meus próprios ouvidos? Que mugido de bois é esse que estou ouvindo? ' Respondeu Saul: 'Os soldados os trouxeram dos amalequitas; eles pouparam o melhor das ovelhas e dos bois para o sacrificarem ao Senhor seu Deus, mas destruímos totalmente o restante'."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Samuel disse a Saul: 'Fique quieto! Eu lhe direi o que o Senhor me falou esta noite'. Respondeu Saul: 'Diga-me'."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("E Samuel disse: 'Embora pequeno aos seus próprios olhos, você não se tornou o líder das tribos de Israel? O Senhor o ungiu como rei sobre Israel e o enviou numa missão, ordenando: 'Vá e destrua completamente aquele povo ímpio, os amalequitas; guerreie contra eles, até que os tenha eliminado'. Por que você não obedeceu ao Senhor? Por que se lançou sobre os despojos e fez o que o Senhor reprova?'(Fig. 4.3) Disse Saul: 'Mas eu obedeci ao Senhor! Cumpri a missão que o Senhor me designou. Trouxe Agague, o rei dos amalequitas, mas exterminei os amalequitas. Os soldados tomaram ovelhas e bois do despojo, o melhor do que estava consagrado a Deus para destruição, a fim de os sacrificarem ao Senhor seu Deus, em Gilgal'. "), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Samuel, porém, respondeu: 'Acaso tem o Senhor tanto prazer em holocaustos e em sacrifícios quanto em que se obedeça à sua palavra? A obediência é melhor do que o sacrifício, e a submissão é melhor do que a gordura de carneiros. Pois a rebeldia é como o pecado da feitiçaria, e a arrogância como o mal da idolatria. Assim como você rejeitou a palavra do Senhor, ele o rejeitou como rei'. 'Pequei', disse Saul. 'Violei a ordem do Senhor e as instruções que você me deu. Tive medo dos soldados e lhes atendi.' 1 Samuel 15:7-26"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Por que Saul não obedeceu a voz de Deus? Porque teve medo e atendeu a voz dos soldados! Ele ouviu seu próprio medo e aos soldados! Você já ouviu pessoas falarem contra Deus e contra a Bíblia? Você já teve medo de bagunçarem com você ou lhe fazerem mal porque você é cristão ou tem vindo para o PG? Muitas pessoas vão falar muitas coisas diferentes sobre a palavra de Deus e a quem você vai escutar? Como saber se as pessoas estão falando a verdade? É só conferir na Bíblia. Ore e peça a Deus que o Espírito Santo lhe ajude a entender a Palavra. Pergunte a pessoas que amem a Deus. Mas muita atenção para ouvir sempre a voz de seu ecolocalizador e saiba que Ele nunca vai falar nada contrário a Palavra de Deus. E o fim de Saul, o que aconteceu? Nunca mais Samuel viu a Saul, até o dia de sua morte, embora se entristecesse por causa dele porque o Senhor arrependeu-se de ter estabelecido Saul como rei de Israel. Depois disso Saul foi cada vez mais se distanciando de Deus, Davi foi ungido rei e assumiria quando Saul morresse. Saul ficou com inveja de Saul e começou a persegui-lo, ficou com tanta inveja da maneira como Deus abençoava Davi que o mal tomou conta dele e o Espírito de deus não estava mais com ele. Naquela época o Espírito Santo era concedido e retirado das pessoas. Hoje é assim? Quando recebemos a Jesus ele nos concede o Espírito santo que nunca nos deixará.  Saul ficou sem o Espírito e escutem o que ele fez."), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Samuel já havia morrido, e todo o Israel o havia pranteado e sepultado em Ramá, sua cidade natal. Saul havia expulsado do país os médiuns e os espíritas. Depois que os filisteus se reuniram, vieram e acamparam em Suném, enquanto Saul reunia todos os israelitas e acampava em Gilboa."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Quando Saul viu o acampamento filisteu, teve medo; ficou apavorado. Ele consultou o Senhor, mas este não lhe respondeu nem por sonhos nem por Urim nem por profetas."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Então Saul disse aos seus auxiliares: 'Procurem uma mulher que invoca espíritos, para que eu a consulte'. Eles disseram: 'Existe uma em En-Dor'.(Fig.4.4) Saul então se disfarçou, vestindo outras roupas, e foi à noite, com dois homens, até a casa da mulher 1 Samuel 28:3-8"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Que voz Saul queria ouvir agora? A de uma feiticeira. O pecado foi crescendo ou diminuindo na vida de Saul? Por quê? Assim acontece com as pessoas que preferem ouvir sua própria voz ou a voz de pessoas e não a voz e a direção de Deus. Saul afastou-se cada vez mais de Deus e morreu louco. E você? Quem você vai escutar. Se você já se entregou a Jesus você tem o Espírito Santo, seu ecolocalizador, que, com a Bíblia lhe direcionará em sua vida. Você vai ouví-lo? E você que ainda não entregou sua vida a Cristo. Por que você ainda não tomou essa decisão? Que vozes você tem preferido escutar? Se você que tomar a decisão de escutar e obedecer a Deus entregando-se a Jesus você pode conversar comigo no final do grupo. Vamos falar com Deus?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Partiu Mochilar:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Deus obrigado porque o Senhor nos deu o Espírito Santo, nos ajude a sempre  	obedecermos a direção que o Espírito apontar em nossas vidas."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 2"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mas o Conselheiro, o Espírito Santo, que o Pai enviará em meu nome, lhes ensinará todas as coisas e lhes fará lembrar tudo o que eu lhes disse. João 14:26"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 2 - O Super Ecolocalizador"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que Ecolocalizador é esse?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem o possui?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que ele faz?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Através de quê ele faz isto?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Que acontece se o desprezamos?"), 0, 'J');

$pdf->ln(50);
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
$pdf->Cell(50, 20, utf8_decode("5. Daniel e seus amigos - Formiga - Tomada de decisões."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Arrumando a mochila:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que é, o que é? Ela é bem pequenininha, tem o cérebro 40 mil vezes menor que o do ser humano"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("'Ela não tem nem chefe, nem supervisor, nem governante, e ainda assim armazena o que precisa no verão e na época da colheita ajunta o seu alimento.' Provérbios 6:7-8"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Que bicho é esse? (podem brincar de forca até descobrirem). A formiga! (Fig.5.1) Isso mesmo! Mas se o cérebro dela é tão pequenino, como ela consegue ser exemplo de organização e unidade? Como elas sabem o que fazer? Como elas sabem que devem juntar comida no verão? O que você acha?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Você sabia que algumas pessoas conseguem ser como as formigas? Sempre tomam decisões certas na hora certa. A Bíblia nos conta a história de um homem chamado Daniel. Ele fazia isso! Como será que ele conseguia? Vamos ver...."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Configurando o GPS:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("No terceiro ano do reinado de Jeoaquim, rei de Judá, Nabucodonosor, rei da Babilônia, veio a  Jerusalém e a sitiou. E o Senhor entregou Jeoaquim, rei de Judá, nas suas mãos, ... (Fig.5.2) Então o rei (Nabucodonosor) ordenou que Aspenaz, o chefe dos oficiais da sua corte, trouxesse alguns dos israelitas da família real e da nobreza; jovens sem defeito físico, de boa aparência, cultos, inteligentes, que dominassem os vários campos do conhecimento e fossem capacitados para servir no palácio do rei. Ele devia ensinar-lhes a língua e a literatura dos babilônios"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("De onde eram os jovens? Judá. Mas quem é o povo de Judá? Lembram-se de Saul, e que Davi depois foi rei sobre Israel, em seu lugar? Davi teve um filho chamado Roboão. Roboão era muito duro com o povo e 10 das 12 tribos de Israel decidiram se separar das outras 2. As duas que ficaram com Roboão foram as tribos de benjamim e Judá. E agora Judá foi derrotada pela Babilônia que era um império enorme!  Então, esses jovens eram judeus que conheciam a Deus e foram levados como prisioneiros para a corte do rei Nabucodonosor."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("O rei designou-lhes uma porção diária de comida e de vinho da própria mesa do rei. Eles receberiam um treinamento durante três anos, e depois disso passariam a servir o rei. Entre esses estavam alguns que vieram de Judá: Daniel, Hananias, Misael e Azarias."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Os nomes deles significavam: 'Deus é meu juiz', 'A graça de Deus', 'Deus forte' e 'O Senhor é nossa ajuda'. O chefe dos oficiais deu-lhes novos nomes: a Daniel deu o nome de Beltessazar; a Hananias, Sadraque; a Misael, Mesaque; e a Azarias, Abede-Nego. Esses nomes significavam: 'Guardião do tesouro escondido de Bel', 'Inspiração do sol', 'Pertencente a deusa Shack' e 'O servo do fogo brilhante'."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Por que eles mudaram o nome dos rapazes? O que é um nome para uma pessoa? É a identidade dela, é quem ela é. Será que eles queriam que aqueles rapazes esquecessem quem eles eram e esquecessem de seu Deus? Quem você é? Em quê você acredita? Será que hoje as pessoas que não acreditam em Deus tem tentado fazer com que você fique confuso sobre sua identidade? Sobre quem você é e em quem você acredita? Como isso tem acontecido? Como será que os rapazes reagiram? Eles estavam mais confortáveis na Babilônia do que em israel? Vamos ver..."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("(Fig.5.3) Daniel, contudo, decidiu não se tornar impuro com a comida e com o vinho do rei, e pediu ao chefe dos oficiais permissão para se abster deles. Será que a comida do rei Nabucodonosor era suja? O que havia de errado na comida?  Com certeza os babilônios comiam muitas coisas que Deus havia recomendado que o povo de Deus não comesse. Mas será que havia alguém vigiando Daniel para que ele tomasse essa decisão? Já imaginou que banquetes eles iriam perder?  O que você faria? Bom, Daniel sabia quem ele era e em quem ele acreditava e tomou a decisão de não contaminar seu corpo. Que será que vai acontecer?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("...E Deus fez com que o homem (responsável por alimentá-los) fosse bondoso para com Daniel e tivesse simpatia por ele. Apesar disso, ele disse a Daniel: 'Tenho medo do rei, o meu senhor, que determinou a comida e a bebida de vocês. E se ele os achar menos saudáveis que os outros jovens da mesma idade? O rei poderia pedir a minha cabeça por causa de vocês'."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Daniel disse então ao homem que o chefe dos oficiais tinha encarregado de cuidar de Daniel, Hananias, Misael e Azarias: 'Peço-lhe que faça uma experiência com os seus servos durante dez dias: Não nos dê nada além de vegetais para comer e água para beber. Depois compare a nossa aparência com a dos jovens que comem a comida do rei, e trate os seus servos de acordo com o que você concluir'."), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->MultiCell(0, 15, utf8_decode("Ele concordou e fez a experiência com eles durante dez dias. Passados os dez dias eles pareciam mais saudáveis e mais fortes do que todos os jovens que comiam a comida da mesa do rei. Assim o encarregado tirou a comida especial e o vinho que haviam sido designados e em lugar disso, lhes dava vegetais. O que vocês acham disso? Havia alguém os vigiando, ou tinham seus pais por perto para mandar que eles comessem coisas saudáveis? Então, por que eles fizeram isso? Durante 3 anos? O que vocês acham? E o que aconteceu no final?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("A esses quatro jovens Deus deu sabedoria e inteligência para conhecerem todos os aspectos da cultura e da ciência. E Daniel, além disso, sabia interpretar todo tipo de visões e sonhos. (Fig.5.4) Ao final do tempo estabelecido pelo rei para que os jovens fossem trazidos à sua presença, o chefe dos oficiais os apresentou a Nabucodonosor. O rei conversou com eles, e não encontrou ninguém comparável a Daniel, Hananias, Misael e Azarias; de modo que eles passaram a servir o rei. O rei lhes fez perguntas sobre todos os assuntos nos quais se exigia sabedoria e conhecimento, e descobriu que eram dez vezes mais sábios do que todos os magos e encantadores de todo o seu reino. E Daniel permaneceu ali até o primeiro ano do rei Ciro. Daniel 1:1-21"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mas quem ficava no pé deles cobrando que eles estudassem, se alimentassem bem e continuassem sendo fiéis a Deus? Ninguém. Será que eles tinham a Bíblia como nós temos para ler todos os dias? Com certeza não. O que fazia a diferença? O que leva a formiga a cumprir sua tarefa? Ela nasceu para ser formiga e segue sua natureza de formiga. Ela tenta ser uma abelha? Ela para de trabalhar e vai descansar a hora que quer? Ela é uma formiga e segue a vida de formiga conforme Deus determinou. É como se algo estivesse escrito dentro delas. E você? Quem é você? O quê seu criador diz sobre você? O que Ele quer que você faça? Você tem feito o que já sabe que deve fazer? Que decisões você acha que precisa tomar em sua vida? Vamos orar para que Deus nos ajude a vivermos e sermos como Ele quer e que nunca nos afastemos daquilo que Ele nos criou para sermos."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Partiu Mochilar:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Deus obrigado porque o Senhor nos diz em sua Palavra quem nós somos. Obrigado  	porque somos teus filhos, nos ajude a sempre tomarmos decisões certas em nossas vidas nos  	lembrando de quem nós somos."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 3"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Ame o Senhor, o seu Deus, de todo o seu coração, de toda a sua alma e de todas as suas forças. Que todas estas palavras que hoje lhe ordeno estejam em seu coração. Deuteronômio 6:5,6"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 3 - Coração de Formiga"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Quem são as formigas?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que há de diferente nesse coração?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem escreveu no coração?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quando é escrito?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem tem o coração de formiga faz o quê?"), 0, 'J');

$pdf->ln(0);
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
$pdf->Cell(50, 20, utf8_decode("6. Amigos de Daniel na fornalha - Formiga - Permanência nas decisões."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Arrumando a mochila:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Peça a 1 criança que lhe ajude, dê instruções a ela: 1- Tudo que lhe perguntarem você vai responder com sim ou não alternadamente. 2 -Tudo que pedirem para fazer, ela vai fazer o contrário. Ela vai ser apresentada como um robô, e as crianças vão tentar descobrir quais as 2 regras da programação do robô.) Pergunte depois: Como robôs e jogos e programas de computador funcionam? Quem os programa? Como são programados? As programações são escritas! É possível mudar a programação? É possível programar uma pessoa? (Fig.6.1) Será que as formigas foram programadas, alguém escreveu no coração delas para fazerem seus formigueiros, alimentá-lo, cuidar e defende-lo como elas fazem? É possível alguém programar seu coração? Como? Vamos ler mais sobre Daniel e seus amigos e observar se é possível e como fazer isso."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Configurando o GPS:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Fig.6.2) O rei Nabucodonosor fez uma imagem de ouro de vinte e sete metros de altura e dois metros e setenta centímetros de largura, e a ergueu na planície de Dura, na província da Babilônia. Depois convocou os sátrapas (Vice reis), os prefeitos, os governadores, os conselheiros, os tesoureiros, os juízes, os magistrados e todas as autoridades provinciais para assistirem à dedicação da imagem que mandara erguer. Daniel 3:1-2"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Eles se reuniram de pé diante da imagem."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Então o arauto (Mensageiro) proclamou em alta voz: 'Esta é a ordem que lhes é dada, ó homens de todas nações, povos e línguas: Quando ouvirem o som da trombeta, do pífaro (flauta transversal), da cítara (tipo de xilofone), da harpa, do saltério (tipo de xilofone), da flauta dupla e de toda espécie de música, prostrem-se em terra e adorem a imagem de ouro que o rei Nabucodonosor ergueu.' Daniel 3:4-5"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Como o rei estava tentando programar as pessoas? O que o rei queria que todos fizessem? Porque? É certo adorar imagens? Porque? Mas será que as pessoas fariam isso? O rei sabia que elas não fariam se não houvesse uma razão. Escutem o restante da ordem:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("'Quem não se prostrar em terra e não adorá-la será imediatamente atirado numa fornalha em chamas'. Daniel 3:6"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que é uma fornalha? Vocês já viram um forno de assar pizza? É assim, só que muito maior e não tem a pedra de colocar as pizzas, só o fogo. O que aquela voz fez com que as pessoas sentissem? Hoje as pessoas o presidente sai gritando por ai, tentando programar seu coração para fazer coisas erradas? Como é feita a programação das pessoas hoje? Será que pelo celular? Tv? Por onde? Será que existem pessoas que usam até a Palavra de Deus para programarem nossos corações de maneira errada? Será que temos feito coisas só porque todos estão fazendo?  Você já teve medo de dizer não ao que os outros querem que você faça? O que será que o povo fez? Será que o medo funcionou com eles? Vamos ver..."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Fig.6.3) Por isso, logo que ouviram o som da trombeta, do pífaro, da cítara, da harpa, do saltério e de toda espécie de música, os homens de todas as nações, povos e línguas prostraram-se em terra e adoraram a imagem de ouro que o rei Nabucodonosor mandara erguer. O medo funcionou! Nesse momento alguns Caldeus se aproximaram e denunciaram os judeus, dizendo ao rei Nabucodonosor: 'Ó rei, vive para sempre! Tu emitiste um decreto, ó rei, ordenando que todo o que ouvisse o som da trombeta..., e de toda espécie de música se prostrasse em terra e adorasse a imagem de ouro, e que todo o que não se prostrasse em terra e não a adorasse seria atirado numa fornalha em chamas. Mas há alguns judeus que nomeaste para administrar a província da Babilônia, Sadraque, Mesaque e AbedeNego, que não te dão ouvidos, ó rei. Não prestam culto aos teus deuses nem adoram a imagem de ouro que mandaste erguer'. Daniel 3:7-12"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Quem foi que se recusou a ouvir a ordem do rei? Já fazia anos que eles moravam com esse povo, porque não agiram igual a eles? Imagine você passar 10 anos sem ouvir a Palavra de Deus, morando com pessoas que fazem o contrário do que Deus quer. Será que você ainda faria o que é certo? Qual o segredo deles? O que você acha? Vou ler o versículo que vocês vão memorizar:"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Ame o Senhor, o seu Deus, de todo o seu coração, de toda a sua alma e de todas as suas forças. Que todas estas palavras que hoje lhe ordeno estejam em seu coração. Deuteronômio 6:5,6"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O segredo está nesse versículo! O que será?  Será que Daniel e seus amigos ainda continuavam programados pela Palavra de Deus? Será que eles iriam ser jogados no fogo por causa disso? Vamos ver... O rei ficou furioso e perguntou a eles se haviam desobedecido e disse:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Agora, porém, quando vocês ouvirem o som da trombeta, ... e de toda espécie de música, se vocês se dispuserem a prostrar-se em terra e a adorar a imagem que eu fiz, será melhor para vocês. Mas, se não a adorarem, serão imediatamente atirados numa fornalha em chamas. E que deus poderá livrá-los das minhas mãos? Sadraque, Mesaque e Abede-Nego responderam ao rei: 'Ó Nabucodonosor, não precisamos defender-nos diante de ti. Se formos atirados na fornalha em chamas, o Deus a quem prestamos culto pode livrar-nos, e ele nos livrará das suas mãos, ó rei. Mas, se ele não nos livrar, saiba, ó rei, que não prestaremos culto aos seus deuses nem adoraremos a imagem de ouro que mandaste erguer'."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("(Fig.6.4) Nabucodonosor ficou tão furioso com Sadraque, Mesaque e Abede-Nego, que o seu semblante mudou. Deu ordens para que a fornalha fosse aquecida sete vezes mais do que de costume e ordenou que alguns dos soldados mais fortes do seu exército amarrassem Sadraque, Mesaque e Abede-Nego e os atirassem na fornalha em chamas.... A ordem do rei era tão urgente e a fornalha estava tão quente que as chamas mataram os soldados que levaram Sadraque, Mesaque e Abede-Nego, os quais caíram amarrados dentro da fornalha em chamas. Daniel 3:13-23 "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Gente! Qual o segredo do coração desses homens? Preferiram arriscar suas vidas a fazer algo que era pecado! Como é que a programação de tantos anos não havia contaminado a eles? Será que eles morreram? O que você acha?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mas, logo depois o rei Nabucodonosor, alarmado, levantou-se e perguntou aos seus conselheiros: 'Não foram três homens amarrados que nós atiramos no fogo?' Eles responderam: 'Sim, ó rei'. E o rei exclamou: 'Olhem! Estou vendo quatro homens, desamarrados e ilesos, andando pelo fogo, e o quarto se parece com um filho dos deuses'. Então Nabucodonosor aproximou-se da entrada da fornalha em chamas e gritou: 'Sadraque, Mesaque e Abede-Nego, servos do Deus Altíssimo, saiam! Venham aqui!' E Sadraque, Mesaque e Abede-Nego saíram do fogo. Os sátrapas, os prefeitos, os governadores e os conselheiros do rei se ajuntaram em torno deles e comprovaram que o fogo não tinha ferido o corpo deles. Nem um só fio do cabelo tinha sido chamuscado, os seus mantos não estavam queimados, e não havia cheiro de fogo neles."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Disse então Nabucodonosor: 'Louvado seja o Deus de Sadraque, Mesaque e Abede-Nego, que enviou o seu anjo e livrou os seus servos! Eles confiaram nele, desafiaram a ordem do rei, preferindo abrir mão de suas vidas a que prestar culto e adorar a outro deus, que não fosse o seu próprio Deus. Por isso eu decreto que todo homem de qualquer povo, nação e língua que disser alguma coisa contra o Deus de Sadraque, Mesaque e Abede-Nego seja despedaçado e sua casa seja transformada em montes de entulho, pois nenhum outro deus é capaz de livrar ninguém dessa maneira'. Então o rei promoveu Sadraque, Mesaque e Abede-Nego a melhores posições na província da Babilônia. Daniel 3: 24-30"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Você quer ter seu coração programado para fazer as coisas certas e agradar a Deus? Façam a 'Expedição Sobreviventes' que vocês irão descobrir!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Partiu Mochilar:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Deus obrigado porque o Senhor nos deu a Sua. Ajude-nos a te amar para que nossos  	corações sejam programados para ficarmos firmes nas decisões certas em nossa vida."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 3"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Ame o Senhor, o seu Deus, de todo o seu coração, de toda a sua alma e de todas as suas forças. Que todas estas palavras que hoje lhe ordeno estejam em seu coração. Deuteronômio 6:5,6"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 3 - Coração de Formiga"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Quem são as formigas?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que há de diferente nesse coração?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem escreveu no coração?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quando é escrito?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem tem o coração de formiga faz o quê?"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->ln(500);
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
$pdf->Cell(50, 20, utf8_decode("7. Daniel ora - Coruja – Falar e escutar a Deus nas tristezas."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Arrumando a mochila:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Vamos brincar de telefone sem fio? (Faça um telefone sem fio com copos descartáveis ou latinhas.) Como o som chega de um local ao outro? Ele vai através de ondas que se movem no ar ou sobre algum material."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode(" Lembram-se do morcego e os sons que ele emite e voltam pra ele através do ecolocalizador? Pois é o nosso animal de hoje é a coruja, ela não tem um ecolocalizador mas ela tem super ouvidos, e sabe o que é interessante? As orelhas da coruja! (Fig. 7.1) Uma é virada para cima e outra para baixo. Porque você acha que elas são assim? Porque um ouvido capta os sons que vem do alto, e o outro capta os sons que vem de baixo. Assim ela pode escapar de predadores e caçar, pelos sons que ouve. Mas tem muitas coisas interessantes a respeito da coruja! Você sabe qual o local preferido das corujas? Elas gostam de viver em ruínas, geralmente vivem em casas e igrejas antigas. Parece triste, não é? Ficar a noite toda acordada no meio de casas quebradas? As corujas passam o dia dormindo e à noite ficam acordadas."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("erá que a Bíblia fala sobre corujas? Vocês lembram da história de Davi, que pecou com a mulher de um de seus soldados? Quando ele se arrependeu e seu filho ficou doente ele escreveu isso: Sou como a coruja do deserto, como uma coruja entre as ruínas. Salmos 102:6"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Vocês acham que ele estava triste? O que vocês acham que ele estava sentindo? Você já ficou triste? Será que mais pessoas se sentiram tristes e aflitas assim? Vamos ver o que diz em Daniel 6: 1- 13:"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Configurando o GPS:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Daniel serviu a um total de sete reis. A Nabucodonosor, Belsazar e Dario, Daniel serviu como primeiro ministro. Ele era muito importante! A Bíblia nos conta como foi na época do Rei Dario:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Dario achou por bem nomear cento e vinte sátrapas para governarem todo o reino; e colocou três supervisores sobre eles, um dos quais era Daniel. (Fig.7.2) Os sátrapas tinham que prestar contas a eles para que o rei não sofresse nenhuma perda."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Ora, Daniel se destacou tanto entre os supervisores e os sátrapas por suas grandes qualidades, que o rei planejava colocá-lo à frente do governo de todo o império."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Diante disso, os supervisores e os sátrapas procuraram motivos para acusar Daniel em sua administração governamental, mas nada conseguiram. Não puderam achar falta alguma nele, pois ele era fiel; não era desonesto nem negligente."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Porque vocês acham que aqueles homens não gostavam de Daniel? Aqueles homens eram os políticos da época. Na política existe corrupção? Mas Daniel era corrupto? Ele tinha o coração de formiga lembra? Ele era fiel a Deus e talvez aqueles homens quisessem ser desonestos e eram supervisionados por Daniel. O que vocês acham? Será que era fácil para Daniel trabalhar com pessoas que o odiavam, e que não tinham um coração de formiga? É difícil pra você na escola? Com outras crianças que batem nas outras e lhe chamam para fazer coisas erradas? E até riem de você porque não faz o que elas fazem? E em casa? Há coisas que lhe deixam triste em sua casa? Brigas, gritos... O que você faz?  Algumas vezes nos entristecemos diante de situações difíceis. Daniel devia ficar triste também. Vamos continuar para ver se aqueles homens continuaram a perseguir Daniel ou desistiram."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Finalmente esses homens disseram: 'Jamais encontraremos algum motivo para acusar Daniel, a menos que seja algo relacionado com a lei do Deus dele'. E assim os supervisores e os sátrapas de comum acordo foram falar com o rei: (Fig.7.3) 'Ó rei Dario, vive para sempre!'"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Todos os supervisores reais, os prefeitos, os sátrapas, os conselheiros e os governadores concordaram em que o rei deve emitir um decreto ordenando que todo aquele que orar a qualquer deus ou a qualquer homem nos próximos trinta dias, exceto a ti, ó rei, seja atirado na cova dos leões. Agora, ó rei, emite o decreto e assina-o para que não seja alterado, conforme a lei dos medos e dos persas, que não pode ser revogada (mudada)."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Gente! E agora? Daniel orava sempre! Será que a vida dele ia ficar em risco? O que vocês faria se estivessem no lugar dele? Ele deve ter ficado muito triste, será que ele se desesperou? Vamos ver o que Daniel fez."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("E o rei Dario assinou o decreto. Quando Daniel soube que o decreto tinha sido publicado, foi para casa, para o seu quarto, no andar de cima, onde as janelas davam para Jerusalém. (Fig.7.4) Três vezes por dia ele se ajoelhava e orava, agradecendo ao seu Deus, como costumava fazer."), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que Daniel fez? Vocês acham que ele estava se sentindo alegre? Daniel devia estar angustiado, mas o que ele fez? Ele ficou ouvindo só as notícias tristes e de perigo? Ele foi ao eu quarto ouvir a quem? Falar com quem? Daniel entrou em outra frequência, fechou o ouvido para o que estava acontecendo ao seu redor e abriu os ouvidos para o céu! Como a coruja nas ruínas! O mundo estava caindo ao seu redor mas ele fez o que? E como foi a oração de Daniel? Foi se queixando e se lamentando? Daniel agradeceu como fazia todos os dias. Porque ele agradeceu? Porque Deus não fica pequeno quando os problemas crescem! Ele continua maior que tudo. Ele deve ter falado e chorado diante de Deus depois mas ele primeiro agradeceu porque Ele tinha Deus para socorrê-lo e com certeza tudo aquilo tinha uma razão. Ele entrou na onda de Deus, na frequência DEUS e isso também nos sustenta quando estamos tristes. Mas o que será que vai acontecer com Daniel? A janela estava aberta, todos iam ver ele orando..."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Então aqueles homens foram ver e encontraram Daniel orando, pedindo ajuda a Deus. Assim foram falar com o rei acerca do decreto real: 'Tu não publicaste um decreto ordenando que nos próximos trinta dias todo aquele que fizesse algum pedido a qualquer deus ou a qualquer homem, exceto a ti, ó rei, seria lançado na cova dos leões? 'O rei respondeu: 'O decreto está em vigor, conforme a lei dos medos e dos persas, que não pode ser revogada'. Então disseram ao rei: 'Daniel, um dos exilados de Judá, não te dá ouvidos, ó rei, nem ao decreto que assinaste. Ele continua orando três vezes por dia'."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Daniel estava condenado. Aonde ele iria ser jogado? Eu nunca fui condenado à cova dos leões, mas já passei por uma situação muito triste. (Compartilhe seu testemunho ou de alguém que conhece que buscou a Deus)"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("E você? O que faz quando esta triste? O que você acha que seria melhor fazer quando tudo vai mal? Vamos orar!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Partiu Mochilar:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Deus nós agradecemos porque o Senhor é o nosso Deus e é maior do que todos os  	nossos problemas. Nos ajude a fecharmos os nossos ouvidos para coisas ruins e abrirmos nossos  	ouvido para o Senhor e a para Sua Palavra!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 4"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Não andem ansiosos por coisa alguma, mas em tudo, pela oração e súplicas, e com ação de graças, apresentem seus pedidos a Deus. Filipenses 4:6"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 4 - A Frequência dos céus"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* O que é frequência?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como entrar na frequência dos céus?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que devemos fazer quando entramos nesta frequência?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O quê a frequência sempre repete?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que acontece quando perdemos a frequência?"), 0, 'J');

$pdf->ln(20);
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
$pdf->Cell(50, 20, utf8_decode("8. Daniel na cova dos leões – Coruja - Confiança em Deus nas aflições."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Arrumando a mochila:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Pegue 2 cordóes. Com um faça curvas pequenas e apertadas, uma após a outra, com o outro faça curvas grandes e espaçadas) Você já viu um rádio? Você sabe como os rádios funcionam? Uma emissora, manda o sinal em forma de ondas (aponte para os cordões) para a antena que emite as ondas para a próxima antena e assim por diante. Essas ondas variam em suas frequências. Algumas ondas são curtas e sua frequência é maior(Aponte para as ondas que estão juntas – a cada segundo são muitas ondas). Elas tem um alcance pequeno, são como rádios de bairro. Já outras ondas são imensas e sua frequência é menor (aponte para o cordão com ondas grandes), essas alcançam até outros países. Nos celulares é parecido, só que o sinal da operadora vai para um satélite, depois volta para as antenas distribuírem. Em alguns locais, você tem que subir nos morros para ter sinal. O rádio ainda e o melhor meio de comunicação para locais que são muito afastados e algumas estações alcançam quase o mundo todo, elas estão em baixa frequência e suas ondas tem uma amplitude muito grande. Você sabe que a Bíblia nos fala de uma frequência que não é de rádio, mas que alcança o mundo inteiro e nunca sai do ar? Você pode usá-la para se comunicar e ela funciona perfeitamente. Não precisa subir em morros porque ela está em todo lugar. Você pode confiar que ela não falha. Sabe que frequência é essa? É uma frequência que Daniel sempre se ligava a ela. Lembra da aflição de Daniel e como ele estava com um enorme problema por causa de seu acesso a Deus?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Configurando o GPS:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Fig.8.1) Os inimigos de Daniel quando viram que ele continuava orando, mesmo sendo proibido, foram ao rei e contaram que Daniel estava desobedecendo."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Quando o rei ouviu isso, ficou muito contrariado, e como estava decidido a salvar Daniel, até o pôr-do-sol fez todo o esforço que pôde para livrá-lo."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mas porque o Rei queria salvar Daniel? Porque Daniel era diferente?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mas os homens lhe disseram: 'Lembra-te, ó rei, que, conforme a lei dos medos e dos persas, nenhum decreto ou edito do rei pode ser modificado'. Então o rei deu ordens, e eles trouxeram Daniel e o jogaram na cova dos leões. O rei, porém, disse a Daniel: 'Que o seu Deus, a quem você serve continuamente, o livre!'"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("E agora? O que acontecerá com Daniel? Ele tinha o coração de formiga e estava sempre na frequência de Deus. Mas Daniel não sentia medo? O que vocês acham? Claro que sentia. E tristeza também. Mas ele cuidava de algo em sua vida que era maior do que seu medo, todos os dias ele alimentava sua confiança em Deus através da oração e de pensar na Palavra de Deus e de lembrar do que Deus já havia feito por ele. Deus já tinha livrado ele e seus amigos de que? Do fogo! Será que livraria dos leões? Vamos ver... (Fig.8.2) Jogaram Daniel na cova dos leões!"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Taparam a cova com uma pedra, e o rei a selou com o seu próprio anel-selo e com os anéis dos seus nobres, para que a situação de Daniel não se modificasse. Tendo voltado ao palácio, o rei passou a noite sem comer e não aceitou nenhum divertimento em sua presença. Além disso, não conseguiu dormir."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Logo ao alvorecer, o rei se levantou e correu para a cova dos leões. Quando ia se aproximando da cova, chamou Daniel com voz aflita: 'Daniel, servo do Deus vivo, será que o seu Deus, a quem você serve continuamente, pôde livrá-lo dos leões? (Fig.8.3)' Daniel respondeu: 'Ó rei, vive para sempre! O meu Deus enviou o seu anjo, que fechou a boca dos leões. Eles não me fizeram mal algum, pois fui considerado inocente à vista de Deus. Também contra ti não cometi mal algum, ó rei'."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("O rei muito se alegrou e ordenou que tirassem Daniel da cova. Quando o tiraram da cova, viram que não havia nele nenhum ferimento, pois ele tinha confiado no seu Deus. E por ordem do rei, os homens que tinham acusado Daniel foram atirados na cova dos leões, juntamente com as suas mulheres e os seus filhos. E, antes de chegarem ao fundo, os leões os atacaram e despedaçaram todos os seus ossos.  Então o rei Dario escreveu aos homens de todas as nações, povos e línguas de toda a terra: 'Paz e prosperidade!' Estou editando um decreto para que nos domínios do império os homens temam e reverenciem o Deus de Daniel. 'Pois ele é o Deus vivo e permanece para sempre; o seu reino não será destruído, o seu domínio jamais acabará.Ele livra e salva; faz sinais e maravilhas nos céus e na terra. Ele livrou Daniel do poder dos leões'. Assim Daniel prosperou durante os reinados de Dario e de Ciro, o persa. Daniel 6:1-28"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que Deus fez por Daniel? Mas agora respondam. E se Deus não tivesse fechado a boca dos leões? Daniel morreria e iria para onde? (Fig.8.4) Deus nem sempre responde sim, às vezes Ele diz espere e às vezes nos diz não. Mas se estamos na frequência de Deus devemos lembrar sempre que"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("'Sabemos que Deus age em todas as coisas para o bem daqueles que o amam' Romanos 8:28"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Você vai aprender com a coruja e nos momentos mais difíceis de tristeza vai abrir seus ouvidos só para Deus, agradecer e chorar para Ele? Vai estar sempre na frequência dEle? Quer compartilhar algo que tem sido difícil em sua vida para orarmos uns pelos outros? (Compartilhe também com as crianças)"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Partiu Mochilar:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Senhor muito obrigado porque o Senhor está conosco mesmo quando nos sentimos  	como a coruja nas ruínas, nos ajuda a sermos gratos por aquilo que o Senhor já fez e pelo que fará. Em nome de Jesus!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 4"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Não andem ansiosos por coisa alguma, mas em tudo, pela oração e súplicas, e com ação de graças, apresentem seus pedidos a Deus. Filipenses 4:6"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 4 - A Frequência dos céus"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* O que é frequência?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como entrar na frequência dos céus?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que devemos fazer quando entramos nesta frequência?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O quê a frequência sempre repete?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que acontece quando perdemos a frequência?"), 0, 'J');

$pdf->ln(200);
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
$pdf->MultiCell(0, 15, utf8_decode("Respostas de Mistérios - Expedição Animal 2- Os sobreviventes (Cenário Caatinga)"), 0, 'C');
$pdf->Ln(8);
$pdf->Cell(0, 5, "", "B", 1, 'C');
$pdf->Ln(400);

// 01

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 1 - O Refúgio secreto"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Quem pode entrar nesse refúgio? - Qualquer pessoa."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como entrar no refúgio secreto? - Sendo hulmides, dependentes."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que essa qualidade significa? - Reconhecer que sou fraco e que preciso de Deus."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que encontramos no refúgio secreto? - Paz, consolo e forças."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que acontece se saímos do refúgio? - Preocupação, medo e desespero."), 0, 'J');

// 02

$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 2 - O Super Ecolocalizador"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que Ecolocalizador é esse? - O Espírito Santo."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem o possui? - Quem já entregou sua vida a Jesus."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que ele faz? - Aconselha, convence do pecado, consola, ensina."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Através de quê ele faz isto? - Ele mesmo fala conosco, usa a Palavra e outras pessoas."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Que acontece se o desprezamos? - Podemos pecar ou ficar sem direção."), 0, 'J');

// 03
$pdf->Ln(10);
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 3 - Coração de Formiga"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Quem são as formigas? - As pessoas que amam a Deus."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que há de diferente nesse coração? - Ele tem a Palavra de Deus escrita nele."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem escreveu no coração? - O Espírito Santo."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quando é escrito? - Quando amamos, lemos e desejamos fazer a vontade de Deus."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem tem o coração de formiga faz o quê? - A vontada de Deus sem ninguém mandar."), 0, 'J');

// 04
$pdf->Ln(10);
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 4 - A Frequência dos céus"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* O que é frequência? - É como se fosse uma estação em um rádio ou um canal de TV"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como entrar na frequência dos céus? - Orando"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que devemos fazer quando entramos nesta frequência? - Agradecer, falar e ouvir"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O quê a frequência sempre repete? - Que nunca estaremos sós"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que acontece quando perdemos a frequência? - Os problemas ficam maiores"), 0, 'J');

$pdf->ln(300);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo " . $nome_usuario, 0, 1, 'J');
// F - Resposta do Mistério

$nome_relatorio = utf8_decode("Expedição Animal 2 - Os Sobreviventes");
$pdf->Output("$nome_relatorio.pdf", "I");
