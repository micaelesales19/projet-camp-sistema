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
$pdf->Cell(0, 5, utf8_decode("Máterial Ação Terrários- Exploradores do Subsolo"), 0, 1, 'C');
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
$pdf->Cell(50, 20, utf8_decode("1. A Semeadura - Parábola do semeador."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Montagem:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Qual a melhor maneira de proteger sua saúde? (Faça mímica dos seguintes itens para as crianças adivinharem e uma criança toma nota) Construir cercas ao redor de você. Colocar câmeras. Ter armas. Vestir roupas. Passar cremes. Tomar remédios. Exercitar. Tomar muita água. Tomar sol. Consultar um médico. "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Quais coisas ajudam a proteger a saúde? E está faltando alguma coisa? (Peça para as crianças fazerem mímicas do que está faltando e que pode proteger a saúde, se não conseguirem faça você a mímica - Comer frutas e verduras, comer o suficiente) Qual o principal? Comer de maneira saudável! Nós devemos nos alimentar bem com coisas que a terra produz. "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Mas e a terra? Será que precisa ser protegida também? Será que a Bíblia nos fala da terra. Será que ela fala de plantação? Que plantação será essa? O que vocês acham? Vamos ler Mateus, capítulo 13 e coletar dados para nossa exploração do subsolo: "), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Coleta de Dados"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Jesus, provavelmente estava na casa de Pedro em uma cidade chamada Cafarnaum. Ele havia curado um homem no sábado, dia de descanso, e por isso, alguns fariseus estavam muito zangados com ele..."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Naquele mesmo dia Jesus saiu de casa e assentou-se à beira-mar. Reuniu-se ao seu redor uma multidão tão grande que ele teve que entrar num barco e assentar-se nele, enquanto todo o povo ficou na praia. Então lhes falou muitas coisas por parábolas, dizendo: (Fig.1.1) 'O semeador saiu a semear. Enquanto lançava a semente, parte dela caiu à beira do caminho, e as aves vieram e a comeram. Parte dela caiu em terreno pedregoso, onde não havia muita terra; e logo brotou, porque a terra não era profunda. Mas quando saiu o sol, as plantas se queimaram e secaram, porque não tinham raiz. Outra parte caiu entre espinhos, que cresceram e sufocaram as plantas. Outra ainda caiu em boa terra, deu boa colheita, a cem, sessenta e trinta por um. Aquele que tem ouvidos para ouvir, ouça!'' Mateus 13:1-9 "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Para que semeamos plantas? Você acha que só devemos semear em terra boa? O semeador da parábola fez isso? Ele só semeou em solo bom? Onde ele semeou? Em todo lugar! Antigamente as pessoas semeavam assim como ele. Jogando a semente no vento e ela caia em qualquer lugar! Hoje só se semeia no lugar que se quer e na profundidade que se quer. Hoje máquinas semeiam e colhem. A terra fica cansada e pobre de nutrientes e precisa de fertilizantes. Mas será que sempre existiu fertilizante? Qual era o fertilizante de antigamente? Você sabe? porque as pessoas semeavam em todo lugar?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Como a terra se alimenta? Como fica rica em nutrientes? Com folhas, galhos e frutos que caem, apodrecem e se transformam em adubo, fertilizante natural para as plantas. Então, quem já descobriu porque a terra fica cansada e precisa de fertilizantes artificiais? Porque se planta só o que se colhe! Não espalham as sementes ao redor para que nasçam plantas onde não vão colher. Você acha que as pessoas ganham ou perdem plantando só o que vão comer? Elas perdem por não espalharem suas sementes. Quando espalham suas sementes, elas vão gerar plantas que protegerão e alimentarão a terra. A terra protegida e alimentada é mais produtiva? "), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Mas será que Jesus queria ensinar só essas coisas? Os judeus já faziam isso! Semeavam generosamente e davam até 1 ano de descanso a cada 7 anos para a terra, deixando crescer qualquer coisa nela. Creio que Ele queria ensinar mais. Jesus explicou a Parábola, vamos ver: (Fig.1.2) "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("'Portanto, ouçam o que significa a parábola do semeador: Quando alguém ouve a mensagem do Reino e não a entende, o Maligno vem e lhe arranca o que foi semeado em seu coração. Este é o que foi semeado à beira do caminho. (Fig.1.3) Quanto ao que foi semeado em terreno pedregoso, este é aquele que ouve a palavra e logo a recebe com alegria. Todavia, visto que não tem raiz em si mesmo, permanece por pouco tempo. Quando surge alguma tribulação ou perseguição por causa da palavra, logo a abandona. Quanto ao que foi semeado entre os espinhos, este é aquele que ouve a palavra, mas a preocupação desta vida e o engano das riquezas a sufocam, tornando-a infrutífera. (Fig.1.4) E, finalmente, o que foi semeado em boa terra: este é aquele que ouve a palavra e a entende, e dá uma colheita de cem, sessenta e trinta por um'. Mateus 13:18-23"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Jesus estava falando só de plantas? Sobre o quê ele também estava falando? Sobre os corações e como a semente da Palavra é semeada nos corações. Será que a Palavra pode proteger os corações? Contra quê ela protege? Dê a figurinha 113 e revise o plano da salvação. .Devemos semear a Palavra em todo lugar? A Palavra pode proteger as pessoas? Pode pensar em alguns corações onde você pode semear a Palavra? Vamos começar a orar por essas pessoas para que Deus mostre, como e quando? Vamos dizendo os nomes e orando!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Explorando"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Senhor, a tua Palavra nos ensina a viver e guia nossos passos. Obrigada! Ajude-nos a semear essa Palavra nos corações de ... (Ore pelos nomes que as crianças disserem!)"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 1"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Por sua decisão ele nos gerou pela palavra da verdade, para que sejamos como que os primeiros frutos de tudo o que ele criou. Tiago 1:18"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 1 - Policia Verde 2"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Quem é a policia verde 2?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como ela protege o solo?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem é a policia verde de nosso coração?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como ela protege o solo do meu coração?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Que cuidado devo tomar?"), 0, 'J');

$pdf->ln(300);
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
$pdf->Cell(50, 20, utf8_decode("2. A semente - A palavra - João 1."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Montagem:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Quem sabe o que é um Terrário? Ou BioDomo? Terrário é um espaço fechado, controlado, onde tentamos reproduzir o ambiente natural. O que temos no ambiente natural? Vamos fazer nosso terrário? (Você pode utilizar este encontro só para fazer o terrário. Faça diferentes terrários, se possível, com os 4 tipos de solo da parábola. Fica a critério do grupo. No próximo encontro você pode seguir com este diálogo.) "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Vamos colocar sementes em copos com algodão e água para fazer mudas que serão colocadas no terrário? Que sementes vamos escolher para plantar? (Leve algumas sementes como feijão e coentro, mas leve sementes quebradas e imprestáveis também) Como se escolhe uma semente? Depende do que você quer plantar, certo? Jesus fala de uma semente na parábola do semeador, a qual semente Jesus estava se referindo? Vamos aprender um pouco mais sobre sementes, antes de plantarmos?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Coleta de Dados"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Na parábola, o que Jesus queria ensinar quando falou de plantação? Será que queria ensinar as pessoas a plantarem feijão? O que devemos plantar na nossa vida e na vida de outros? "), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Ele falou que a semente é a Palavra, que Palavra é essa? Como a Bíblia pode ser plantada? Ela, por acaso, é viva? Vamos ler João, capítulo 1 para descobrirmos esse mistério: (Fig 2.1) "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("No princípio era aquele que é a Palavra. Ele estava com Deus, e era Deus. Ela estava com Deus no princípio. Todas as coisas foram feitas por intermédio dele; sem ele, nada do que existe teria sido feito. Nele estava a vida, e esta era a luz dos homens. A luz brilha nas trevas, e as trevas não a derrotaram. João 1:1-5"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Que Palavra era essa, que no princípio estava com Deus e que fez todas as coisas? Que Palavra é essa que é o próprio Deus? Que vida é esta que estava nEle? Que vida é esta que é a luz dos homens? O que são as trevas? O que as trevas fizeram contra a luz no inicio? ( Não responda, só ouça as crianças) Vamos continuar lendo porque o mistério está grande...(Fig.2.2)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Surgiu um homem enviado por Deus, chamado João. Ele veio como testemunha, para testificar acerca da luz, a fim de que por meio dele todos os homens cressem. Ele próprio não era a luz, mas veio como testemunha da luz. Estava chegando ao mundo a verdadeira luz, que ilumina todos os homens. ( Fig.2.3) Aquele que é a Palavra estava no mundo, e o mundo foi feito por intermédio dele, mas o mundo não o reconheceu. Veio para o que era seu, mas os seus não o receberam. Contudo, aos que o receberam, aos que creram em seu nome, deu-lhes o direito de se tornarem filhos de Deus, os quais não nasceram por descendência natural, nem pela vontade da carne nem pela vontade de algum homem, mas nasceram de Deus. Aquele que é a Palavra tornou-se carne e viveu entre nós. Vimos a sua glória, glória como do Unigênito vindo do Pai, cheio de graça e de verdade... João 1:6-13"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Quem é a Palavra que veio ao mundo? O que Jesus veio nos mostrar? Ele veio nos mostrar como Deus é através de Sua vida! O que a Bíblia nos revela? Como Deus é! Quem é Jesus?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("João dá testemunho dele. Ele exclama: 'Este é aquele de quem eu falei: Aquele que vem depois de mim é superior a mim, porque já existia antes de mim' João 1:15 "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Quem é esse João? Esse foi o João Batista. Sobrinho de Maria, mãe de Jesus. Sua mãe, Isabel, era prima de Maria e ficou grávida 6 meses antes de Maria engravidar. Um dia Maria foi visitar Isabel e o bebê João pulou de alegria dentro da barriga de Isabel quando ela viu Maria. Ela então cantou louvando a Deus pela criança que estava na barriga de Maria. João nasceu, cresceu, passou a morar no deserto e vinha às cidades só pregar o arrependimento e a vinda daquele que perdoaria e resgataria o homem escravo do pecado. As pessoas se arrependiam e eram batizadas por esse João. Ele disse que Jesus existia antes dele? Quem ficou grávida primeiro? E porque João disse que Jesus existia antes dele? Vamos continuar..."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("... Ninguém jamais viu a Deus, mas o Deus Unigênito, que está junto do Pai, o tornou conhecido. João 1:18 "), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Descobriu Por que João Batista disse aquilo? Quem é Jesus? Jesus é Deus em ação sendo conhecido pelos homens! Você já ouviu alguém falar para você fazer coisas boas? Mas você já viu essa pessoa em ação, fazendo coisas boas? Jesus é o próprio Deus, sendo o que falou que era e fazendo o que falou que ia fazer. Jesus é a Palavra, é o verbo, é Deus em ação! Mas esperem! Na explicação da parábola do semeador, Jesus disse que a semente era o que? Lembra?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Quando alguém ouve a mensagem do Reino e não a entende, o Maligno vem e lhe arranca o que foi semeado em seu coração. Este é o que foi semeado à beira do caminho. Quanto ao que foi semeado em terreno pedregoso, este é aquele que ouve a palavra e logo a recebe com alegria. Mateus 13:19,20 "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que é a semente? A Palavra, a mensagem do Reino. Que mensagem é essa? Que Palavra é essa? A Palavra e a mensagem é Jesus e o que Ele fez. Não pode ser outra mensagem, nem mensagem falsificada ou estragada senão é fake News, mensagem falsa! Estão vendo esses feijões? Tem sementes estragadas aqui? Se plantarmos sementes de feijão estragadas, o que acontece? Se plantarmos sementes de coentro, vai nascer feijão? (Fig.2.4) Muitas pessoas que ouviam João Batista pensavam que ele era o salvador prometido. O que será que João fez com essas pessoas?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("E este é o testemunho de João, quando os judeus mandaram de Jerusalém sacerdotes e levitas para que lhe perguntassem: Quem és tu? E confessou, e não negou; confessou: Eu não sou o Cristo. E perguntaram-lhe: Então quê? És tu Elias? E disse: Não sou. És tu profeta? E respondeu: Não. Disseram-lhe pois: Quem és? para que demos resposta àqueles que nos enviaram; que dizes de ti mesmo? Disse: Eu sou a voz do que clama no deserto: Endireitai o caminho do Senhor, como disse o profeta Isaías. João 1:19-23 No dia seguinte João viu Jesus aproximando-se e disse: 'Vejam! É o Cordeiro de Deus, que tira o pecado do mundo! Este é aquele a quem eu me referi, quando disse: Vem depois de mim um homem que é superior a mim, porque já existia antes de mim.' João 1:1-34 "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("João acabou com as Fake News na hora! João poderia ter aproveitado para dizer que era o Cristo e ganhar umas curtidas? Mas seria um Cristo falso! A semente precisa ser a verdadeira. Quem é a semente verdadeira? Sabe como podemos reconhecer as sementes falsas que algumas pessoas apresentam como se fosse Jesus? O que vocês acham? Conhecendo muito bem a verdadeira! E como você pode conhecer melhor Jesus? O que você pode fazer a partir de agora para conhecê-lo melhor? Vamos orar para seguirmos com a exploração durante a semana. "), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Explorando"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Senhor nos ajude a conhecer melhor o Senhor para nunca semearmos, nem deixarmos crescer dentro de nós mensagens falsas!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 1"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Por sua decisão ele nos gerou pela palavra da verdade, para que sejamos como que os primeiros frutos de tudo o que ele criou. Tiago 1:18"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 1 - Policia Verde 2"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Quem é a policia verde 2?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como ela protege o solo?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem é a policia verde de nosso coração?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como ela protege o solo do meu coração?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Que cuidado devo tomar?"), 0, 'J');


$pdf->ln(5);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo " . $nome_usuario, 0, 1, 'J');
// F - Lição 02

$pdf->AddPage();

// I - Lição 03
//Capa
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, utf8_decode("Lição 03"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(50, 20, utf8_decode("3. . O Semeador - Jesus e os 12."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Montagem:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Você precisará das sementes do algodão e dos terrários. Prepare também um prato com brigadeiro ou balinhas) Como estão nossas sementes do algodão? Podemos passar elas para os terrários? Vamos fazer isso? Vamos pegar algumas folhinhas, quebra-las e misturar com a terra antes de plantá-las? Hoje vocês vão levar seus terrários para casa. "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Vamos fazer agora uma prova. (Pegue o prato com as balinhas ou brigadeiro e coloque no centro da roda, dê uma colher para cada um dos presentes e diga que todos poderão comer desde que só usem um braço e é proibido dobrar o cotovelo. Com isso, eles serão forçados a inventar uma forma. É esperado que descubram sozinhos uma forma e combinem com outra criança de levar o brigadeiro até a boca dela e vice versa No vídeo abaixo é possível entender melhor a dinâmica. Mostre o vídeo no final da dinâmica. https://www.youtube.com/watch?time_continue=1&v=-NQIcS4_KBo"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Como as pessoas do vídeo estavam quando tentavam comer sozinhas? E como ficaram depois? O que fez elas ficarem alegres?"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("O que isso tem a ver com a nossa Expedição Terrários - Exploradores do subsolo? Já falamos sobre A semeadura (a plantação), sobre a semente e hoje vamos explorar o semeador. Quem será o semeador? O que tem a ver com o vídeo?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Coleta de Dados"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Hoje, nas grandes plantações, não existe uma pessoa semeando, olhem essa figura, (Mostre a figurinha do trator) quem semeia? O trator! Como ele deve se sentir semeando? E aqui nessa figura, quem está semeando? (Mostre a figurinha do semeador) O que ele deve sentir? E quando as plantas crescem e dão frutos, como ele se sente? Nós aprendemos que Jesus é o quê na plantação de Deus? A semente! E quem foi o semeador? Quem enviou Jesus? "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Porque Deus mandou Jesus? Jesus é a mensagem do amor de Deus para nós! É a Palavra de Deus que andou nessa terra! Mas aonde e como foi que o semeador lançou a semente Jesus? Vamos coletar nossos dados para a nossa exploração!"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Quando Jesus tinha 30 anos ele começou seu ministério. Ele se preparou para isso toda a sua vida, estudando e praticando a Palavra de Deus e passou 40 dias no deserto, lembra? Então ele começou a espalhar sua vida. (Fig.3.1)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Andando à beira do mar da Galiléia, Jesus viu dois irmãos: Simão, chamado Pedro, e seu irmão André. Eles estavam lançando redes ao mar, pois eram pescadores. E disse Jesus: 'Sigam-me, e eu os farei pescadores de homens'. No mesmo instante eles deixaram as suas redes e o seguiram. Indo adiante, viu outros dois irmãos: Tiago, filho de Zebedeu, e João, seu irmão. Eles estavam num barco com seu pai, Zebedeu, preparando as suas redes. Jesus os chamou, e eles, deixando imediatamente o barco e seu pai, o seguiram. Mateus 4:13-22"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O quê ele fez? Porque Ele estava chamando esses homens? Será que chamou mais gente?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Passando por ali, Jesus viu um homem chamado Mateus, sentado na coletoria, e disse-lhe: 'Siga-me'. Mateus levantou-se e o seguiu. Mateus 9:9"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Jesus ainda chamou mais discípulos e alguns discípulos de João Batista também o seguiram. Em Lucas 10:17 Jesus manda 70 discípulos para discipularem outros. (Fig.3.2) Porém de todos estes Jesus escolheu 12 para estarem mais perto dele e para caminharem com ele"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Escolheu doze, designando-os como apóstolos, para que estivessem com ele, os enviasse a pregar e tivessem autoridade para expulsar demônios. Estes são os doze que ele escolheu: Simão, a quem deu o nome de Pedro; Tiago, filho de Zebedeu, e João, seu irmão, aos quais deu o nome de Boanerges, que significa filhos do trovão; André; Filipe; Bartolomeu; Mateus; Tomé; Tiago, filho de Alfeu; Tadeu; Simão, o zelote, e Judas Iscariotes, que o traiu. Marcos 3:14-19"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que vocês acham que Jesus fazia junto com eles? Comia, viajava, conversava, ensinava, pescava... (Fig.3.3) Jesus ficou com seus discípulos até depois da ressurreição, quando subiu aos céus e deu uma ordem a seus discípulos. "), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Portanto ide, fazei discípulos de todas as nações, batizandoos em nome do Pai, e do Filho, e do Espírito Santo; Mateus 28:19"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("E assim eles fizeram, multiplicando os discípulos de Jesus por todo o mundo! (Fig.3.4)"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Jesus semeou sua vida no coração deles. No coração do PG dele. E no nosso PG o que seu líder semeia? A vida dele ou a de Jesus? De Jesus! O semeador sempre vai semear a vida de Jesus nos corações! Se ele semear a sua vida somente, ou falar de algo que não está na Palavra, ele está semeando uma semente falsa. "), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("O Primeiro Semeador foi Deus que nos deu a semente verdadeira que era Jesus. A vida de Jesus entrou nos corações e começou a crescer no coração dos seus discípulos! "), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("A Vida de Jesus está crescendo em seu coração? Será que Jesus se alegrava quando observava sua vida crescendo nos corações? O que você acha? Será que Deus, o grande semeador, se alegra quando vê a semente de Jesus crescendo em seu coração? "), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Jesus viveu para ajudar os outros ou para viver Sua vida para Ele mesmo? Lembra do vídeo que assistimos? Como você acha que deve viver? O que você pode fazer pelos seus amigos? Você acha que um dia pode ter seu próprio PG? Vamos orar..."), 0, 'J');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Explorando"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Deus obrigado por ter semeado Jesus em nossos corações, nos use para semear Jesus no coração de nossos amigos. Nos ajude a nos prepararmos para ter o nosso próprio PG!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 2"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Aqueles que semeiam com lágrimas, com cantos de alegria colherão. Aquele que sai chorando enquanto lança a semente, voltará com cantos de alegria, trazendo os seus feixes. Salmos 126:5-6"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 2 - O segredo da Alegria"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Qual o segredo da alegria?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Dar o que?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* A quem?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quando?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem foi o maior semeador?"), 0, 'J');

$pdf->ln(200);
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
$pdf->Cell(50, 20, utf8_decode("4. Solo beira do caminho - Arenoso - Beira do caminho - Fariseu e publicano."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Montagem:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Você sabia que existem tipos de solos diferentes? A ciência nos diz que existem 4 tipos de solo. Arenoso, argiloso, calcário e humoso! m.escolakids.uol.com.br"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("O solo arenoso não retém água pois ela escorre entre os grãos de areia indo para uma profundidade maior. O solo argiloso é um solo bom para plantio, é bem húmido, O solo calcário não é bom para o cultivo de plantas, é muito rochoso. O solo humoso é muito bom para plantação e tem bastante material orgânico! Vamos ver que tipo de solo vamos explorar hoje? "), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Coleta de Dados"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Fig.4.1) O semeador saiu a semear a sua semente e, quando semeava, caiu alguma junto do caminho e foi pisada, e as aves do céu a comeram. Lucas 8:5. "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode(". O que acontece com o solo de um caminho onde passam pessoas ou animais? Beira do caminho? Que tipo de solo é esse? É um solo duro ou mole? Tem nutrientes? Caem folhas nele? Geralmente onde as pessoas e animais passam o solo se torna duro e árido, mesmo que um dia tenha sido bom um dia ele se torna duro por ser pisado. Geralmente fica um pouco arenoso. O solo duro e arenoso é bom para plantio? As pessoas interferiram nesse solo e ele se tornou árido e a parábola nos diz que a semente ainda foi pisada por pessoas. Então vieram os pássaros e a comeram. O que Jesus quis dizer com isso? Ele mesmo nos revela! "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode(" Quando alguém ouve a mensagem do Reino e não a entende, o Maligno vem e lhe arranca o que foi semeado em seu coração. Este é o que foi semeado à beira do caminho."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que significa não entender algo? Qual a mensagem do Reino? Quem é o maligno? Vamos ver uma história da Bíblia que vai nos ajudar a entender essa parábola. A Bíblia é muito boa porque a própria Bíblia nos ajuda a entende-la. Vejam esta passagem em Lucas: (Fig. 4.2"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode(" Dois homens subiram ao templo, para orar; um, fariseu, e o outro, publicano"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Um fariseu era um estudioso do Velho Testamento. Os fariseus seguiam a lei ao pé da letra e eram muito exigentes. Publicanos eram pessoas que trabalhavam para o governo Romano cobrando impostos dos judeus, muitas vezes injustos. (Fig.4.3) "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("O fariseu, estando em pé, orava consigo desta maneira: Ó Deus, graças te dou porque não sou como os demais homens, roubadores, injustos e adúlteros; nem ainda como este publicano. Jejuo duas vezes na semana, e dou os dízimos de tudo quanto possuo."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("(Fig.4.4) O publicano, porém, estando em pé, de longe, nem ainda queria levantar os olhos ao céu, mas batia no peito, dizendo: Ó Deus, tem misericórdia de mim, pecador!"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Digo-vos que este desceu justificado para sua casa, e não aquele; porque qualquer que a si mesmo se exalta será humilhado, e qualquer que a si mesmo se humilha será exaltado. Lucas 18:10-14"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Os 2 eram judeus, conheciam as escrituras, qual a diferença entre as atitudes do fariseu e do publicano? Qual dos dois entendeu melhor a Palavra de Deus? Jesus disse que o publicano foi justificado, perdoado e o fariseu não. Como foi isso? Será que o Fariseu não cumpria a Palavra? Ele cumpria com seus atos, mas seu coração era orgulhoso, vaidoso e arrogante, ele se achava melhor do que os outros e não tinha misericórdia. Passava o dia na igreja, mas não entendia a Palavra de verdade. Julgava o outro quando deveria ama-lo e se achava justo, tanto que batia no peito e se orgulhava. "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Quem lembra do versículo de Provérbios 16:18?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode(" O orgulho vem antes da destruição e o espírito altivo antes da queda. "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Algumas pessoas tem o coração assim ela deixam que ensinos de homens e seus próprios estejam acima do que diz a palavra, a mensagem é pisada por ensinos de homens até que a verdadeira mensagem seja tirada de seus corações pelo inimigo. "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Como está seu coração? Com o quê você deve tomar cuidado? Sempre consulte a Bíblia para ver se os ensinos e as coisas que você acha estão de acordo com a Palavra. Sempre seja humilde diante de Deus e ouça somente a Ele!"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("(Conte sobre algo que lhe ensinaram na escola ou mesmo em casa e que depois você viu que não estava de acordo com a Palavra e como você se arrependeu e mudou)"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Como são os corações das pessoas que estão ao seu redor? Alguém que você conhece tem o coração assim que acredita no que pessoas dizem, ou em sí mesmo, mais do que na Palavra de Deus? Você acha que pode transformar os corações delas? Quem pode? Então qual é a sua tarefa? Julgar essas pessoas? Ou falar de Deus, a todos, sem preconceitos e a todo momento? Você pode orar por elas também! Vamos orar? (Peça nomes de pessoas que as crianças querem que entendam e recebam a Palavra de Deus)"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Explorando"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Deus me ajude a ser humilde e a sempre pedir ajuda de Deus para fazer o que é certo. Me ajude também a amar e testemunhar com alegria a todos crendo que o Senhor é quem muda os corações! (Orem pelas pessoas citadas acima)"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 2"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Aqueles que semeiam com lágrimas, com cantos de alegria colherão. Aquele que sai chorando enquanto lança a semente, voltará com cantos de alegria, trazendo os seus feixes. Salmos 126:5-6"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 2 - O segredo da Alegria"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Qual o segredo da alegria?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Dar o que?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* A quem?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quando?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem foi o maior semeador?"), 0, 'J');

$pdf->ln(300);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo " . $nome_usuario, 0, 1, 'J');
// F - Lição 04

$pdf->AddPage();

// I - Lição 05
//Capa
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, utf8_decode("Lição 05"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(50, 20, utf8_decode("5. Solo pedras - Jovem Rico."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Montagem:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Como estão os seus ternários? Como tem sido seus resultados? O que você tem feito para sua semente germinar? Quais as dificuldades? Você acha que tem algo a ver com seu tipo de solo? Nós já percebemos que o solo arenoso não e muito bom para plantio, mas você deve jogar a semente nele? Na verdade, quem faz com que a planta cresça?"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Hoje vamos conhecer mais um tipo de solo. Mas antes vamos brincar de pedra, papel e tesoura, quem conhece? (De 2 em 2 de mãos para trás vão escolher colocar pedra - mão fechada, papel - mão aberta ou tesoura - 2 dedos abertos) A regra é: pedra quebra tesoura, tesoura corta papel e papel envolve pedra. Os ganhadores vão competindo entre si até o final. "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Reflexão: Qual parece ser mais o frágil dos 3? O que parece ser o mais duro ou forte? A pedra. Porém a pedra é facilmente envolvida pelo papel. A dureza assusta, mas não pode nada contra algo que a envolve. É como a água. Água mole em pedra dura, tanto bate até que fura. Podem me explicar esse ditado? Outra coisa que destrói a dureza é a persistência. Nunca parar! Mas o que isso tem a ver com nosso solo rochoso e com a Bíblia? Vamos coletar os dados:"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Coleta de Dados"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Lembram da parábola do semeador? A primeira parte das sementes caiu na beira do caminho em terreno arenoso, foi pisado e vieram as aves e comeram as sementes. Lembram do que Jesus queria dizer com isso? Quem são os que tem coração arenoso? Como o coração deles ficou assim? Devemos semear a Palavra nesses corações? Mas há um segundo tipo de solo, vejamos: (Fig.5.1)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode(" Parte dela caiu em terreno pedregoso, onde não havia muita terra; e logo brotou, porque a terra não era profunda. Mas quando saiu o sol, as plantas se queimaram e secaram, porque não tinham raiz. Mateus 13:5,6 "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que é um terreno pedregoso? Vocês já viram plantas em rochas? Como é a raiz delas? Fácil arrancar? Será que existem pessoas com o coração duro como a rocha? Como Jesus explicou a parábola?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Quanto ao que foi semeado em terreno pedregoso, este é aquele que ouve a palavra e logo a recebe com alegria. Todavia, visto que não tem raiz em si mesmo, permanece por pouco tempo. Quando surge alguma tribulação ou perseguição por causa da palavra, logo a abandona. Mateus 13:20,21"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Quando a semente da Palavra cai no coração de alguém que tem o coração duro, é possível que ela germine? Sim, mas para desenvolver-se a planta precisa de nutrientes que vem do solo. Se há pouco solo e poucos nutrientes, o que acontece com a planta? Se há pouco envolvimento com a Palavra, se não há um coração realmente desejoso de deixar Jesus crescer dentro dele o que acontece quando vem os problemas? (Fig.5.2) Jesus, uma vez atendeu um jovem que queria ter a vida eterna. Vamos ver o que aconteceu com ele e que tipo de solo era seu coração. "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("E eis que, aproximando-se dele um jovem, disse-lhe: Bom Mestre, que bem farei para conseguir a vida eterna?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("E ele disse-lhe: Por que me chamas bom? Não há bom senão um só, que é Deus. Se queres, porém, entrar na vida, guarda os mandamentos"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Disse-lhe ele: Quais? E Jesus disse: Não matarás, não cometerás adultério, não furtarás, não dirás falso testemunho;"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Honra teu pai e tua mãe, e amarás o teu próximo como a ti mesmo. Disse-lhe o jovem: Tudo isso tenho guardado desde a minha mocidade; que me falta ainda?"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Ué, se aquele jovem estava fazendo o que os mandamentos diziam, como ele não sabia a que mandamentos Jesus estava se referindo? Ele estava guardando os mandamentos mesmo? Ele conhecia os mandamentos? Os mandamentos eram só 10. Como ele não sabia? Vocês acham que Jesus conhecia o coração daquele jovem? Ele parecia alguém bom que queria seguir com alegria? Mas e se isso custasse algo? E se isso desse algum problema para sua vida de conforto e dinheiro? Vamos ver o que Jesus respondeu a ele:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Disse-lhe Jesus: Se queres ser perfeito, vai, vende tudo o que tens e dá-o aos pobres, e terás um tesouro no céu; e vem, e segue-me."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Se ele estava cumprindo o amar ao próximo como a si mesmo, seria difícil dividir suas coisas com as pessoas necessitadas ao redor? Ele ia ficar perto de Jesus! Ia aprender mais dEle! Que privilegio! Que chance! O que você faria? (Fig.5.3) "), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("E o jovem, ouvindo esta palavra, retirou-se triste, porque possuía muitas propriedades. Mateus 19:16-27"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode(" Ele desistiu? Porque? Ele não estava tão animado para seguir a Jesus? O que houve? O que a parábola diz? Não tinha raiz na Palavra! Não tinha apego, não amava de verdade! Tinha o coração duro, não deixou a semente crescer e tomar conta de sua vida e quando veio o problema. Que problema foi? Abrir mão de suas riquezas, de seu conforto, das coisas que ele gostava, o que ele fez? Desistiu! Você ama a Deus? O que lhe separaria de Deus? O que faria você desistir? Porque? Acha que precisa mudar algo em seu coração? "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Você conhece pessoas que tem o coração duro para a Palavra? O que você pode fazer por elas? Será que deve desistir? (Fig.5.4) O que Jesus fez por elas? Deus desisti de você ou de mim? Você vai aprender o que pode fazer no seu semanário. Vamos orar por nós e por nossos amigos e parentes?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Explorando"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Senhor, me ajude a deixar que suas raízes creçam em meu coração, que Jesus possa viver em minha vida. Me ajuda a ajudar aqueles que tem o coração duro e tem desistido da fé. Em nome de Jesus. Amém!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 3"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("- Não amem o mundo nem o que nele há. Se alguém amar o mundo, o amor do Pai não está nele. 1 João 2:15"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 3 - O Terrário do Troll"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* O que é um Troll?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que o Troll faz com as pessoas?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que é o terrário?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como livrar nosso terrário do Troll?"), 0, 'J');

$pdf->ln(200);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo " . $nome_usuario, 0, 1, 'J');
// F - Lição 05

$pdf->AddPage();

// I - Lição 06
//Capa
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, utf8_decode("Lição 06"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(50, 20, utf8_decode("6. Solo com espinhos - Ananias e Safira."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Montagem:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Como estão seus terrários? As plantas de alguém morreram? O que você pode fazer? Pode melhorar o solo e plantar novamente? Como tem sido a experiência? Você tem observado quais as pessoas que parecem ter os corações como os solos que conhecemos?"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Nós já vimos 2 tipos de solo! Hoje vamos conhecer o terceiro tipo de solo e tipo de coração. "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Vamos fazer uma experiência! (Pegue um vidro ou caixa e separe para colocar dentro, umas 3 batatas, umas bolinhas menores que podem ser bolas de gude e arroz.) Pode ser feito com pedras, pedrinhas e areia. Pedrômetro https://www.youtube.com/watch?v=WTKqn4VG_N8 "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Eu trouxe aqui para mostrar para vocês um batatômetro. Ele vai nos testar, em nossas vidas com Deus! Quais são as coisas sem muita importância que você faz durante o dia? Vamos citar: assistir tv, jogar, facebook. ... Vamos pensar que essas coisas sem muita importância sejam o arroz. Vamos colocando no vidro. Agora, que coisas são importantes, mas não são necessárias para você viver feliz: merendar, arrumar quarto, fazer tarefas, exercícios... Essas são as bolinhas de gude, vamos colocar. E agora vamos pensar nas 3 coisas mais importantes de sua vida - as batatas - Deus, sua família e amigos e estudos. Não coube! Então as coisas importantes nunca cabem na nossa vida? Porque não couberam? Acham que tem um jeito de fazer com que elas caibam? Essas coisas são importantes? Então elas devem vir primeiro ou por último? Vamos colocá-las primeiro assim que acordamos, agora o que vamos colocar? E depois? Coube? "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Na passagem bíblica de hoje vamos falar do terceiro tipo de solo e porque não deu certo, assim como nosso primeiro teste no batatômetro! Fiquem atentos!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Coleta de Dados"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Lembra que o semeador, semeou e uma parte caiu na beira do caminho e outra parte caiu na rocha? Vamos ler mais um pedacinho da parábola do semeador e conversar sobre ela: (Fig.6.1) "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Outra parte caiu entre espinhos, que cresceram com ela e sufocaram as plantas. Lucas 8:7 As que caíram entre espinhos são os que ouvem, mas, ao seguirem seu caminho, são sufocados pelas preocupações, pelas riquezas e pelos prazeres desta vida, e não amadurecem. Lucas 8:14"), 0, 'J');

$pdf->SetFont('arial', '', 12);

$pdf->MultiCell(0, 15, utf8_decode("Mas o que são esses espinhos? O que o texto diz? O que são preocupações? É você ocupar sua mente com algo antes do tempo. Pré ocupar. Como a Palavra no coração pode ser sufocada pelas preocupações? O que é fé? É o contrário de preocupação. O que vai acontecer com a fé se não paro de me preocupar?"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("E as riquezas desta vida? Como podem sufocar a Palavra? Vocês lembram do jovem rico? Talvez achasse que seu sucesso estava ligado à riqueza, à fama, e em quantos likes e curtidas ele tinha... Essas coisas tem a ver com Deus e o céu onde vamos morar? Se fico ligado nessas coisa o que acontece com a Palavra em meu coração? E os prazeres da vida? "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("O que lhe dá prazer? Que atividades dão prazer e as pessoas querem sempre fazer? Esse prazer dura? Esse prazer aproxima de Deus e da sua palavra, ou afasta? Vamos ver um exemplo de como as riquezas podem detonar a fé de alguém! Está no Livro de Atos, capítulo 4."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Assim era a igreja no seu começo:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("E era um o coração e a alma da multidão dos que criam, e ninguém dizia que coisa alguma do que possuía era sua própria, mas todas as coisas lhes eram comuns. E os apóstolos davam, com grande poder, testemunho da ressurreição do Senhor Jesus, e em todos eles havia abundante graça. Não havia, pois, entre eles necessitado algum; porque todos os que possuíam herdades ou casas, vendendo-as, traziam o preço do que fora vendido, e o depositavam aos pés dos apóstolos."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("E repartia-se a cada um, segundo a necessidade que cada um tinha"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Então José, cognominado pelos apóstolos Barnabé(que, traduzido, é Filho da consolação), levita, natural de Chipre, Possuindo uma herdade, vendeu-a, e trouxe o preço, e o depositou aos pés dos apóstolos. Atos 4:32-37"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("A Palavra estava crescendo no coração deles? E qual era o resultado? Dividiam suas riquezas com outros! Mas um casal se viu entre os espinhos... Como foi isso? (Fig.6.2) "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Um homem chamado Ananias, juntamente com Safira, sua mulher, também vendeu uma propriedade"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->MultiCell(0, 15, utf8_decode("Ele reteve parte do dinheiro para si, sabendo disso também sua mulher; e o restante levou e colocou aos pés dos apóstolos."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Então perguntou Pedro: (Fig.6.3) 'Ananias, como você permitiu que Satanás enchesse o seu coração, a ponto de você mentir ao Espírito Santo e guardar para si uma parte do dinheiro que recebeu pela propriedade? Ela não lhe pertencia? E, depois de vendida, o dinheiro não estava em seu poder? O que o levou a pensar em fazer tal coisa? Você não mentiu aos homens, mas sim a Deus'."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Ouvindo isso, Ananias caiu e morreu. Grande temor apoderou-se de todos os que ouviram o que tinha acontecido. Cerca de três horas mais tarde, entrou sua mulher, sem saber o que havia acontecido. Pedro lhe perguntou: (Fig.6.4) 'Diga-me, foi esse o preço que vocês conseguiram pela propriedade? ' Respondeu ela: 'Sim, foi esse mesmo'"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Pedro lhe disse: 'Por que vocês entraram em acordo para tentar o Espírito do Senhor? Veja! Estão à porta os pés dos que sepultaram seu marido, e eles a levarão também'. Atos 5:1-10"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("0 Sabem o que aconteceu com a mulher? Morreu também! Talvez só queriam ostentar que tinham dinheiro, não queriam realmente dar. O amor ao dinheiro sufocou seu amor pela verdade da Palavra."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Que prazeres ou preocupações você tem que gostaria de deixar de lado para que Jesus, que é a Palavra, cresça em você? Como fazer para que o enganador, o grande troll não engane o nosso coração, nos convencendo que os prazeres e as riquezas são o mais importante? Você quer orar agora para que Deus o ajude a crescer e a ajudar outras colegas e familiares a se afastarem dos espinhos, amor as riquezas e aos prazeres? Vocês lembram do batatômetro? Coloque sempre as coisas de Deus em primeiro lugar para que espinhos não venham sufocar sua fé! "), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Explorando"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Deus me ajude a pensar nas coisas do Senhor, me ajude também a ajudar outros a fazerem isso. Em nome de Jesus!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 3"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("- Não amem o mundo nem o que nele há. Se alguém amar o mundo, o amor do Pai não está nele. 1 João 2:15"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 3 - O Terrário do Troll"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* O que é um Troll?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que o Troll faz com as pessoas?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que é o terrário?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como livrar nosso terrário do Troll?"), 0, 'J');

$pdf->ln(100);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo " . $nome_usuario, 0, 1, 'J');
// F - Lição 06

$pdf->AddPage();

// I - Lição 07
//Capa
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, utf8_decode("Lição 07"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(50, 20, utf8_decode("7. Solo Fértil - Barnabé - A Terra Roxa."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Montagem:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Como está seu terrário? Tem se mostrado um bom solo? Sua plantinha nasceu? Como você a tratou? Se sua planta não nasceu, não desanime! Espere um pouco mais! Se já esperou muito, adube o solo e plante novamente! "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Você já percebeu que há várias cores de solo? Você já viu areias coloridas? No litoral do Ceará tem uma praia que tem areias coloridas. (Se você tiver exemplos ou tiver fotos da internet, mostre às crianças) Será que conseguimos fazer areia colorida? Com quê? Corante! Mas... areia é boa para plantar? Já vimos que não, areia não é uma boa terra. Mas o nosso mistério dessa semana nos fala de uma terra boa e ela é roxa. Que terra será essa? (Fig. 7.1) Você já viu terra roxa? Que cores de terra você já viu? Eu já vi.... Puxa! Existem várias cores de terra! "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Mas, vamos voltar aos nossos tipos de solo! Quem lembra os 3 tipos de solo que já conhecemos? Que tipos de corações são esses? Hoje vamos ver o último tipo de solo, qual você acha que é? Vamos ler... "), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Coleta de Dados"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mateus 13:8 nos diz"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("”Outra ainda caiu em boa terra, deu boa colheita, a cem, sessenta e trinta por um.” "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Depois da beira do caminho, da rocha e dos espinhos, o que temos aqui? Boa terra! A que Jesus compara os solos? Aos corações! E como é um coração boa terra? O que vocês acham? A Bíblia não diz que todos são pecadores? Vamos ver como é isso: "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("'E, finalmente, o que foi semeado em boa terra: este é aquele que ouve a palavra e a entende, e dá uma colheita de cem, sessenta e trinta por um'. Mateus 13:23"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que é necessário para ser um bom solo? Ouvir, entender e frutificar! Mas será que só ouvir, não é suficiente? Lembram da semente que caiu na beira do caminho? Se a pessoa só ouve, mas não entende o que quer dizer, não se esforça para pensar sobre aquilo, é como o fariseu que ouviu muito a Palavra, mas não entendia, ou não queria entender. "), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Às vezes quando alguém lhe dá uma ordem ou proíbe de você fazer, ou manda você fazer algo, você finge que não entende ou não se incomoda de fazer o que mandaram? Sabe porque você faz isso? Porque você realmente não queria fazer! Existem pessoas assim! Elas não querem, nem se esforçam. Mas existem também aquelas que ouvem, entendem como o jovem rico, mas não estão dispostas a ir até o fim. Chega uma hora que elas desistem porque não querem abrir mão dos amigos, das festas, do dinheiro fácil, do namorado. O que você acha disso? Então não é só ouvir e entender. É também frutificar. O que quer dizer frutificar? Dar frutos! Isso! Mas o que é necessário para uma árvore dar frutos? Que haja boa terra! "), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("O que é uma boa terra? No campo, uma boa terra é rica em material orgânico. As folhas caem e se decompõem, esse material é alimento para as plantas e para as minhocas, elas o comem e produzem um material ainda melhor que vai adubar a terra e deixar ela soltinha para que a água penetre! O nome é húmus!"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("A terra de nosso coração também precisa ser como o húmus, o qual é produzido quando nos alimentamos da Palavra de Deus. O Espírito santo então usa essa Palavra para deixar nosso coração como terra roxa! Você quer ser Terra roxa? Então o que precisa fazer? A terra roxa é a que produz fruto!"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("A Bíblia nos diz que os discípulos saíram frutificando em todos os lugares quando Jesus subiu aos céus. Eles se tornaram terra roxa quando perceberam que não eram eles que deveriam viver, mas eles deveriam deixar Cristo crescer e tomar conta de suas vidas!"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("Em atos 1:8 a Bíblia diz que antes de Jesus subir aos céus, Ele falou:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("'Mas receberão poder quando o Espírito Santo descer sobre vocês, e serão minhas testemunhas em Jerusalém, em toda a Judéia e Samaria, e até os confins da terra'."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O Espírito Santo foi nos dado para, junto com a Palavra, ajudar que sejamos que tipo de terra? Para quê? (Fig.7.2) Paulo, um ex perseguidor da igreja, convertido foi chamado por Deus para ir aos confins da terra! Paulo foi um dos que foi terra roxa! Vamos ler:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Saulo passou vários dias com os discípulos em Damasco. Logo começou a pregar nas sinagogas que Jesus é o Filho de Deus. Atos 9:19 e 20"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Paulo logo deixou o Espírito santo e a palavra trabalharem na vida dele, mas vieram as perseguições. Será que ele desistiu? O que vocês acham? Paulo continuou a pregar e testemunhar através de sua vida. Olhem nesse mapa, todos os lugares onde Paulo foi. (Fig.7.3) Vamos contar? Será que foi fácil? Paulo passou 10 anos em Tarso fazendo discípulos e depois ele fez 3 viagens missionárias e percorreu 24.780 km em 663 dias por terra e por mar! Milhares de pessoas creram, mas será que ele teve problemas também? Vamos ver como foi, Paulo mesmo descreve: (Fig. 7.4) "), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("trabalhei muito mais, fui encarcerado mais vezes, fui açoitado mais severamente e exposto à morte repetidas vezes. Cinco vezes recebi dos judeus trinta e nove açoites. Três vezes fui golpeado com varas, uma vez apedrejado, três vezes sofri naufrágio, passei uma noite e um dia exposto à fúria do mar"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Estive continuamente viajando de uma parte a outra, enfrentei perigos nos rios, perigos de assaltantes, perigos dos meus compatriotas, perigos dos gentios; perigos na cidade, perigos no deserto, perigos no mar, e perigos dos falsos irmãos. Trabalhei arduamente; muitas vezes fiquei sem dormir, passei fome e sede, e muitas vezes fiquei em jejum; suportei frio e nudez. Além disso, enfrento diariamente uma pressão interior, a saber, a minha preocupação com todas as igrejas. 2 Coríntios 11:23-28"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que vocês acham? Como Paulo não desistiu? Porque não desistiu? Porque Deus o ajudou a ser boa terra. Ele buscou, orou, chorou, estudou a Palavra, e o Senhor Jesus tomou conta de toda a sua vida! Paulo morreu decapitado mas antes de morrer ele escreveu a um de seus discípulos, Timóteo:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode(" Está próximo o tempo da minha partida. Combati o bom combate, terminei a corrida, guardei a fé. Agora me está reservada a coroa da justiça, que o Senhor, justo Juiz, me dará naquele dia; e não somente a mim, mas também a todos os que amam a sua vinda. 2 Timóteo 4:6-8"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Vocês fazem parte desse PG porque são boa terra. Têm buscado a Palavra de Deus e procurado obedecê-lo. Deus vai usar vocês para Sua glória! Vamos orar para que Deus ajude a cada um aqui a encontrar outras terras roxas e a fazer discípulos para o Senhor!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Explorando"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Deus nos ensine como ser uma terra roxa e dar lugar para Cristo crescer em nossas vidas. Ajude para que nós possamos começar a frutificar também na vida das pessoas ao nosso redor. Nos ajude também a reconhecer os amigos que são terra roxa e estão dispostos a fazer o que a sua Palavra diz!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 4"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("- Digo-lhes verdadeiramente que, se o grão de trigo não cair na terra e não morrer, continuará ele só. Mas se morrer, dará muito fruto. João 12:24"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 4 - A Terra Roxa"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que terra é essa? "), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Por que ela é diferente?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que fazer quando achamos essa terra?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como a semente se desenvolve?"), 0, 'J');

$pdf->ln(10);
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
$pdf->Cell(50, 20, utf8_decode("8. A germinação - Morte da semente - Paulo e Silas."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Montagem:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Vamos desenhar uma árvore? Quais são as partes da árvore? Raiz, Caule, Folha, flor e fruto. Mas e a semente? Onde ela fica? Muito bem! No fruto ou algumas vezes na base da flor. De qualquer maneira é preciso perder as flores para que haja frutos. Depois o que acontece, se for da flor a semente cai na terra. E se a semente estiver dentro do fruto? O fruto apodrece ou o fruto é colhido e retirada a semente que é jogada ou cai na terra! Mas como a semente germina? (Fig.8.1) Em contato com a boa terra ela se rompe e deixa a nova planta sair de dentro dela. "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Lembra que Jesus se comparou à semente? (Fig.8.2) Para poder gerar vida em nós ele precisou morrer para si mesmo. Precisou nascer como homem, estudar, ir ao templo, ser batizado, tentado e morrer como homem. Jesus fazia o que queria? Ou fazia o que era da vontade de Seu pai? Como é o nosso versículo? E se Jesus tivesse saído da cruz? Poderia ter perdoado nosso pecado e nos dado a vida eterna? "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Ele precisou morrer para gerar vida em nós. E seus discípulos? E nós? Quando nos entregamos a Jesus, Ele vem habitar em nós, Ele é plantado em nosso coração! E como Ele crescerá em nossas vidas? A própria semente transforma a terra onde é plantada, ela reorienta os minerais e a energia para o processo que dá vida. Ela transforma a terra e a terra lhe dá espaço. Conosco é pra ser assim, Jesus transforma nosso coração e nós damos cada vez mais espaço para Ele. Paulo, uma vez falou: "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Fui crucificado com Cristo. Assim, já não sou eu quem vive, mas Cristo vive em mim. Gálatas 2:20"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Paulo sofreu perseguições, espancamentos e até prisão, vamos ver um exemplo de sua vida na Bíblia?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Coleta de Dados"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Fig.8.3) Paulo, Lucas, Silas e alguns outros discípulos estavam na macedônia na cidade de Tiatira por um tempo e conta Lucas que ... "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Certo dia, indo nós para o lugar de oração, encontramos uma escrava que tinha um espírito pelo qual predizia o futuro. Ela ganhava muito dinheiro para os seus senhores com adivinhações. Essa moça seguia a Paulo e a nós, gritando: 'Estes homens são servos do Deus Altíssimo e lhes anunciam o caminho da salvação'. "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Você já escutou de pessoas que dizem que adivinham o futuro? O que vocês acham disso? Vamos ver o que Paulo fez? "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Ela continuou fazendo isso por muitos dias. Finalmente, Paulo ficou indignado, voltou-se e disse ao espírito: 'Em nome de Jesus Cristo eu lhe ordeno que saia dela! ' No mesmo instante o espírito a deixou."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Então o que aquela moça estava fazendo não era de Deus? Era um espírito do inimigo que estava chamando atenção das pessoas para Paulo. É preciso ter muito cuidado com coisas que “parecem de Deus”. Ninguém sabe o futuro, só Deus. Porque? Vamos continuar..."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Percebendo que a sua esperança de lucro tinha se acabado, os donos da escrava agarraram Paulo e Silas e os arrastaram para a praça principal, diante das autoridades. E, levando-os aos magistrados, disseram: 'Estes homens são judeus e estão perturbando a nossa cidade, propagando costumes que a nós, romanos, não é permitido aceitar nem praticar'."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode(" Eles inventaram fake News sobre Paulo porque perderam o dinheiro que ganhavam com a moça. Acusaram ele injustamente! "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("A multidão ajuntou-se contra Paulo e Silas, e os magistrados ordenaram que se lhes tirassem as roupas e fossem açoitados. Depois de serem severamente açoitados, foram lançados na prisão. O carcereiro recebeu instrução para vigiá-los com cuidado. Tendo recebido tais ordens, ele os lançou no cárcere interior e lhes prendeu os pés no tronco."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Que difícil não acham?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Por volta da meia-noite, Paulo e Silas estavam orando e cantando hinos a Deus; os outros presos os ouviam. De repente, houve um terremoto tão violento que os alicerces da prisão foram abalados. Imediatamente todas as portas se abriram, e as correntes de todos se soltaram."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("(Fig.8.3) O carcereiro acordou e, vendo abertas as portas da prisão, desembainhou sua espada para se matar, porque pensava que os presos tivessem fugido. Mas Paulo gritou: 'Não faça isso! Estamos todos aqui!'"), 0, 'J');
$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Como assim? As portas se abriram, as correntes se soltaram e eles não fugiram? O que você faria? Porque eles não fugiram? Porque não aproveitaram? O que aconteceria se eles se tornassem fugitivos. E com o carcereiro? Seria essa a vontade de Deus? Vocês acham que eles tiveram vontade de fugir? Com certeza, mas eles não prejudicariam aquele homem para se salvarem. Jesus faria isso? Eles precisavam ficar mesmo sabendo que seria pior para eles! E sabe o que aconteceu? "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("O carcereiro pediu luz, entrou correndo e, trêmulo, prostrou-se diante de Paulo e Silas. Então levou-os para fora e perguntou: (Fig.8.4) 'Senhores, que devo fazer para ser salvo? ' Eles responderam: 'Creia no Senhor Jesus, e serão salvos, você e os de sua casa'. E pregaram a palavra de Deus, a ele e a todos os de sua casa. Naquela mesma hora da noite o carcereiro lavou as feridas deles; em seguida, ele e todos os seus foram batizados. Então os levou para a sua casa, serviu-lhes uma refeição e com todos os de sua casa alegrou-se muito por haver crido em Deus"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Qual foi o resultado deles deixarem Jesus viver no lugar deles naquele momento? A semente foi plantada na vida daquela família. E sabem o que mais?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Quando amanheceu, os magistrados mandaram os seus soldados ao carcereiro com esta ordem: 'Solte estes homens'. O carcereiro disse a Paulo: 'Os magistrados deram ordens para que você e Silas sejam libertados. Agora podem sair. Vão em paz'. "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Uau! Eles foram libertos! A Bíblia ainda nos diz, que Paulo só concordou em sair depois que os juízes se desculpassem por terem prendido eles injustamente. Paulo era um homem justo! Como ele se tornou assim? O segredo está em imitar Jesus, nosso mestre! Morrer para si mesmo e deixar Jesus viver em seu lugar! Você quer decidir fazer o mesmo? Ore agora e fale o que você quer que aconteça em sua vida! (Dê um tempo para oração) Paulo e todos s outros discípulos verdadeiros de Jesus descobriram o segredo de ser terra roxa - deixar Jesus viver em seu lugar e FRUTIFICAR, espalhar a semente da Palavra a todas as pessoas! Vocês estão prontos para isso? Vamos orar"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Explorando"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Senhor Deus ajude a cada um de nós a ser terra roxa, que dá espaço para Jesus e Sua vontade em nossas vidas, Ele morreu para nos salvar e queremos morrer para nossas vontades para levar a Tua Palavra a outros! Nos ajude a germinar! Em nome de Jesus!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 4"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("- Digo-lhes verdadeiramente que, se o grão de trigo não cair na terra e não morrer, continuará ele só. Mas se morrer, dará muito fruto. João 12:24"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 4 - A Terra Roxa"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que terra é essa? "), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Por que ela é diferente?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que fazer quando achamos essa terra?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como a semente se desenvolve?"), 0, 'J');

$pdf->ln(50);
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
$pdf->MultiCell(0, 15, utf8_decode("Respostas de Mistérios - Ação Terrários- Exploradores do Subsolo"), 0, 'C');
$pdf->Ln(8);
$pdf->Cell(0, 5, "", "B", 1, 'C');
$pdf->Ln(400);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 1 - Policia Verde 2"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Quem é a policia verde 2? - A semente"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como ela protege o solo? - Gerando plantas que vão proteger e enriquecer o solo"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem é a policia verde de nosso coração? - A Palavra Viva"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como ela protege o solo do meu coração? - Gerando a vida de Jesus em mim que me transforma para melhor"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Que cuidado devo tomar? - Verificar se semeio a semente certa, o evangelho certo."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 2 - O segredo da Alegria"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Qual o segredo da alegria? - Dar"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Dar o que? -  A semente da Vida - Jesus"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* A quem? - A todos, sem preconceito"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quando? - A todo momento"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem foi o maior semeador? - Deus"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 3 - O Terrário do Troll"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* O que é um Troll? - Um enganador, pessoa que gosta de criar brigas."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que o Troll faz com as pessoas? - Deixa seus corações duros"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que é o terrário? - O mundo que queremos melhorar"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como livrar nosso terrário do Troll? - Com a semente da verdade"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 4 - A Terra Roxa"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que terra é essa? - É a terra fértil, os corações abertos"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Por que ela é diferente? - Por que estão prontas para ouvir a Palavra e aceita-la."), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que fazer quando achamos essa terra? - Todos que tem Jesus, a Palavra crescendo no coração "), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como a semente se desenvolve? -  Ela precisa cada vez mais fazer a vontade de Deus e não a sua, deixando Jesus crescer em sua vida "), 0, 'J');

$pdf->ln(300);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo " . $nome_usuario, 0, 1, 'J');
// F - Resposta do Mistério

$nome_relatorio = utf8_decode("Ação Terrários - Exploradores do Subsolo");
$pdf->Output("$nome_relatorio.pdf", "I");
