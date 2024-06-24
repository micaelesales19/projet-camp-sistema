<?php

$usuario = $_GET['id_lider'] ?? 0;
$id_modulo = $_GET['id_modulo'] ?? "3";

$pdo = new PDO("mysql:host=localhost;dbname=u301957058_camp_brasil", "u301957058_administrador", "campBr202@");

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
$consultasr_sql = "SELECT * FROM supervisorr WHERE id_supervisorR LIKE :ID_USU";
$consultasr = $pdo->prepare($consultasr_sql);
$consultasr->bindValue(":ID_USU", $usuario);
$consultasr->execute();
$xSR = $consultasr->rowCount();
$dadossr = $consultasr->fetch(PDO::FETCH_ASSOC);

// Dados SE
$consultase_sql = "SELECT * FROM supervisore WHERE id_supervisorEs LIKE :ID_USU";
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

// Dados Pais
$consulta_pais_sql = "SELECT * FROM pais WHERE id_pais LIKE :ID_USU";
$consulta_pais = $pdo->prepare($consulta_pais_sql);
$consulta_pais->bindValue(":ID_USU", $usuario);
$consulta_pais->execute();
$xPais = $consulta_pais->rowCount();
$dados_pais = $consulta_pais->fetch(PDO::FETCH_ASSOC);

$nome_usuario = "";

if ($xPais == 0) {
} else {
	$nome_usuario .= $dados_pais['nome'];
}

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
$pdf->Cell(0, 5, $pdf->textoUTF8("Máterial Santuário"), 0, 1, 'C');
$pdf->Ln(8);
$pdf->Cell(0, 5, "", "B", 1, 'C');

// Página 2	
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 01"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("1. O CHAMADO DE ABRAÃO"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Ponte:"), 0, 1, 'L');


$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Peça à criança que fique de costas para você, feche os olhos, junte as pernas, abra os braços e caia para trás. Segure-o. Após fazer a brincadeira pergunte: É fácil brincar assim comigo? E com uma pessoa estranha? Você confiaria? É mais fácil acreditar em quem conhecemos! Olha o que Abraão foi capaz de fazer por causa de sua fé em Deus!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Planta do Santuário:"), 0, 1, 'L');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz em Gênesis 12:1-7"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.1.1) Então o Senhor disse a Abrão: Saia da sua terra, do meio dos seus parentes e da casa de seu pai, e vá para a terra que eu lhe mostrarei. Farei de você um grande povo, e o abençoarei. Tornarei famoso o seu nome, e você será uma bênção. Abençoarei os que o abençoarem, e amaldiçoarei os que o amaldiçoarem; e por meio de você todos os povos da terra serão abençoados."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Que difícil! Deixar toda a família e sair sem saber para  onde ir, você faria?"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.1.2) Partiu Abrão, como lhe ordenara o Senhor, e Ló foi com ele. Abrão tinha setenta e cinco anos quando saiu de Harã. Levou sua mulher Sarai, seu sobrinho Ló, todos os bens que haviam acumulado e os seus servos, comprados em Harã; partiram para a terra de Canaã e lá chegaram. (fig.1.3) Abrão atravessou a terra até o lugar do Carvalho de Moré, em Siquém. Naquela época os cananeus habitavam essa terra."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O Senhor apareceu a Abrão e disse: À sua descendência darei esta terra. (fig.1.4) Abrão construiu ali um altar dedicado ao Senhor, que lhe havia aparecido. Será que foi fácil para Abraão deixar amigos, família, casa? Por que ele fez isso? Você acha que eu faria isso se Deus me pedisse? E você? Se falta coragem é porque não conhecemos bem a Deus. Você acha que podemos confiar em Deus? Porque? O que é fé? Sem fé é possível fazer o que Abrão fez?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Portal:"), 0, 1, 'L');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus nos ajude a te conhecermos e a confiar totalmente no Senhor, no Teu amor e cuidado para com nossas vidas!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 1"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Sem fé é impossível agradar a Deus, pois quem dele se aproxima precisa crer que ele existe e que recompensa aqueles que o buscam.  Hebreus 11:6"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 1 - Mais resistente que o aço."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que é?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como é produzida?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que ela pode fazer?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que você pode construir com ela?"), 0, 'J');

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
$pdf->Cell(50, 10, $pdf->textoUTF8("2. O SACRIFÍCIO DE ISAQUE"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Ponte:"), 0, 1, 'L');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Recorte uma figura em pedaços de maneira que seja difícil adivinhar de que se trata. Depois mostre os pedaços as criança dizendo que aquilo é uma figura bonita. Peça que digam que figura é. Nossa vida é como esse quebra cabeças, difícil de dizer onde vai dar. Mas Deus nos diz que tudo que acontece é para nosso bem. É uma promessa dEle! Mas, às vezes quando as coisas dão errado ou demoram, será que é fácil ter fé? Na vida de Abraão foi assim."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Planta do Santuário:"), 0, 1, 'L');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Então Deus respondeu: Na verdade Sara, sua mulher, lhe dará um filho, e você lhe chamará Isaque. Com ele estabelecerei a minha aliança, que será aliança eterna para os seus futuros descendentes. Abraão prostrou-se, rosto em terra; riu-se e disse a si mesmo: Poderá um homem de cem anos de idade gerar filhos? Poderá Sara dar à luz aos noventa anos? Gênesis 17:16-17"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O que você acha? A idade deles era como um quebra cabeças, difícil! Será que isso seria possível? Para Deus existe algo impossível? (fig.2.1) Deus cumpriu Sua promessa, mas então aconteceu outro quebra cabeças! Passado algum tempo, Deus pôs Abraão à prova, dizendo-lhe:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Abraão! Ele respondeu: Eis-me aqui. Então disse Deus: Tome seu filho, seu único filho, Isaque, a quem você ama, e vá para a região de Moriá. Sacrifique-o ali como holocausto num dos montes que lhe indicarei. Que quebra cabeças! Você obedeceria a Deus? (fig.2.2) Na manhã seguinte, Abraão levantou-se e preparou o seu jumento. Levou consigo dois de seus servos e Isaque seu filho. Depois de cortar lenha para o holocausto, partiu em direção ao lugar que Deus lhe havia indicado. No terceiro dia de viagem, Abraão olhou e viu o lugar ao longe. Disse ele a seus servos: Fiquem aqui com o jumento enquanto eu e o rapaz vamos até lá. Depois de adorarmos, voltaremos. Abraão pegou a lenha para o holocausto e a colocou nos ombros de seu filho Isaque, e ele mesmo levou as brasas para o fogo, e a faca. (fig.2.3) E caminhando os dois juntos, Isaque disse a seu pai Abraão: Meu pai! Sim, meu filho, respondeu Abraão. Isaque perguntou: As brasas e a lenha estão aqui, mas onde está o cordeiro para o holocausto? Respondeu Abraão: Deus mesmo há de prover o cordeiro para o holocausto, meu filho. E os dois continuaram a caminhar juntos. (fig.2.4) Quando chegaram ao lugar que Deus lhe havia indicado, Abraão construiu um altar e sobre ele arrumou a lenha. Amarrou seu filho Isaque e o colocou sobre o altar, em cima da lenha. Então estendeu a mão e pegou a faca para sacrificar seu filho. Mas o Anjo do Senhor o chamou do céu: Abraão! Abraão! Eis-me aqui, respondeu ele. Não toque no rapaz, disse o Anjo. Não lhe faça nada. Agora sei que você teme a Deus, porque não me negou seu filho, o seu único filho. Abraão ergueu os olhos e viu um carneiro preso pelos chifres num arbusto. Foi lá, pegou-o e sacrificou-o como holocausto em lugar de seu filho. Abraão deu àquele lugar o nome de O Senhor proverá. Por isso até hoje se diz: No monte do Senhor se proverá. Gênesis 22:1-14"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Abraão confiou, mesmo estando tudo como em um quebra cabeças. Ele só tinha a promessa de que iria dar certo ou tinha algo mais? Será que é fácil ter fé? Será que foi fácil entregar o filho para Deus? Você entregaria? Por quê? Mas sabe, O próprio Deus entregou Seu filho por nós, para ser morto em sacrifício pelos nossos pecados. (compartilhe sua fé nesse Deus, com as crianças)."), 0, 'J');

//Tópico
$pdf->Ln(20);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Portal:"), 0, 1, 'L');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus nos ajude a te conhecermos e a confiar totalmente no Senhor, no Teu amor e cuidado e nas tuas promessas para com nossas vidas!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 1"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Sem fé é impossível agradar a Deus, pois quem dele se aproxima precisa crer que ele existe e que recompensa aqueles que o buscam.  Hebreus 11:6"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 1 - Mais resistente que o aço."), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que é?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como é produzida?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que ela pode fazer?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que você pode construir sobre ela?"), 0, 'J');

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
$pdf->Cell(50, 10, $pdf->textoUTF8("3. O NASCIMENTO DE MOISÉS"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Ponte:"), 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Você sabia que existem plantas de papel? Sabia que essas plantas não são vivas? Sabe que plantas são essas? São plantas de construção! Você sabe o que são? (mostre uma planta) Plantas são planos de como será a construção. Quem faz as plantas de construção? O arquiteto! Os pedreiros geralmente não conhecem a planta, mas seguem as ordens acreditando que vai dar certo! Será que um arquiteto pode errar? A Bíblia nos fala de alguém que fez planos para o povo de Deus. Vamos ver..."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Planta do Santuário:"), 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Lembram o que Deus tinha prometido a Abraão? Que ele seria um povo, e eles teriam uma terra? Mas eles se tornaram escravos no Egito por causa da desobediência e como estavam crescendo muito, os egípcios começaram a ficar com medo deles. Faraó, por medo, tomou uma decisão horrível. Ouça o que a Bíblia diz:"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Por isso o faraó ordenou a todo o seu povo: Lancem ao Nilo todo menino recém-nascido, mas deixem viver as meninas. Êxodo 1:22"), 0, 'J');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O que vocês acham dessa ordem? Será que o povo de Deus vai ser destruído? (fig.3.1) A Bíblia nos conta a história de um desses meninos. Por que será que Deus escolheu contar a história só de um menino? Ouçam... Uma mulher chamada Joquebede (Ex 6) deu a luz a um menino. E agora? Será que ela devia jogar o menino no rio? O que vocês fariam? Vamos ver o quê essa mãe fez..."), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vendo que era bonito, ela o escondeu por três meses. (fig.3.2)"), 0, 'J');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Quando já não podia mais escondê-lo, pegou um cesto feito de junco e o vedou com piche e betume. Colocou nele o menino e deixou o cesto entre os juncos, à margem do Nilo. O que será que vai acontecer? (fig.3.3) A irmã do menino ficou observando de longe para ver o que lhe aconteceria. A filha do faraó descera ao Nilo para tomar banho. Enquanto isso as suas servas andavam pela margem do rio. Nisso viu o cesto entre os juncos e mandou sua criada apanhá-lo. Ao abri-lo viu um bebê chorando. Ficou com pena dele e disse"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Este menino é dos hebreus. Então a irmã do menino aproximou-se e perguntou à filha do faraó: A senhora quer que eu vá chamar uma mulher dos hebreus para amamentar e criar o menino? Quero, respondeu ela. E a moça foi chamar a mãe do menino. (fig.3.4) Então a filha do faraó disse à mulher: Leve este menino e amamente-o para mim, e eu lhe pagarei por isso. A mulher levou o menino e o amamentou. Tendo o menino crescido, ela o levou à filha do faraó, que o adotou e lhe deu o nome de Moisés, dizendo: Porque eu o tirei das águas. Êxodo 2:2-10"), 0, 'J');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O menino parecia ser especial mas estava agora nas mãos dos egípcios e o povo ainda era escravo. Parecia que o plano de Deus não estava dando certo! Mas o que foi que aconteceu com Moisés? Será que Deus sabe e governa tudo o que acontece? Será que os Seus planos sempre se cumprem? O que você acha?"), 0, 'J');

//Tópico

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Portal:"), 0, 1, 'L');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus nos ajude a ter fé de que o Senhor tem um plano para nossas vidas e que tudo no final vai ser como o Senhor quer!"), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 2"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Porque sou eu que conheço os planos que tenho para vocês, diz o Senhor, planos de fazê-los prosperar e não de lhes causar dano, planos de dar-lhes esperança e um futuro. Jeremias 29:11"), 0, 'J');

$pdf->Ln(10);
$pdf->SetFont('arial', '', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 2 - O arquiteto da vida"), 0, 'J');
$pdf->Ln(10);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que é um arquiteto?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é o arquiteto de nossa vida?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como é o projeto de nossa vida?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual nossa parte no projeto?"), 0, 'J');


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
$pdf->Cell(50, 10, $pdf->textoUTF8("4. AS PRAGAS"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Ponte:"), 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Você já viu um desenho escondido? É um desenho com linhas misturadas e números ou letras e você só descobre o que está desenhado quando pinta as partes indicadas. Você pintaria para descobrir? E se pintarmos o que queremos em vez de pintar as partes indicadas, dará certo? Por quê? A planta de um edifício é como um desenho escondido! Você só sabe como vai ficar quando termina! A vida de Moisés e do povo de Deus continuou, mas parecia um desenho escondido."), 0, 'J');

//Tópico
$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);

$pdf->Cell(90, 10, $pdf->textoUTF8("Planta do Santuário:"), 0, 1, 'L');

$pdf->SetFont('arial', '', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Lembram de Moisés, que foi criado pela filha de Faraó? (fig.4.1)"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Um dia... apascentava Moisés o rebanho de Jetro, seu sogro, sacerdote em Midiã; e levou o rebanho atrás do deserto, e chegou ao monte de Deus, a Horebe. E apareceu-lhe o anjo do Senhor em uma chama de fogo do meio duma sarça; e olhou, e eis que a sarça ardia no fogo, e a sarça não se consumia. Êxodo 3:1,2"), 0, 'J');

$pdf->SetFont('arial', '', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Uma planta pegando fogo e não queimava. Será que alguém pode fazer isso? Deus então disse a Moisés:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vem agora, pois, e eu te enviarei a Faraó para que tires o meu povo (os filhos de Israel) do Egito. Êxodo 3:10"), 0, 'J');

$pdf->SetFont('arial', '', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("O que será que Moisés pensou? O que você pensaria? Faraó iria ficar contente com ele? O que você faria? Moisés estava confiando no plano de Deus? Moisés então deu desculpas para não ir, Deus ficou triste e mandou Arão, seu irmão, com ele (fig.4.2) "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("... foram Moisés e Arão e disseram a Faraó: Assim diz o SENHOR Deus de Israel: Deixa ir o meu povo, para que me celebre uma festa no deserto.Mas Faraó disse: Quem é o Senhor, cuja voz eu ouvirei, para deixar ir Israel? Não conheço o Senhor, nem tampouco deixarei ir Israel. Êxodo 5:1,2"), 0, 'J');

$pdf->SetFont('arial', '', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Faraó não reconhecia o Deus de Israel como o verdadeiro Deus. Será que o plano de Deus vai falhar? (fig.4.3) Deus então mandou 9 pragas ao Egito, transformou água em sangue, mandou rãs, mosquito, moscas, peste nos animais, feridas, chuva de pedras, gafanhotos e trevas. E a cada vez Faraó dizia que não deixaria o povo ir. Parecia o nosso desenho escondido, parece que o plano de Deus não estava dando certo. É fácil confiar em Deus quando as coisas não estão bem? Você confiaria? Por quê? Moisés continuou a obedecer a Deus e anunciou a décima praga."), 0, 'J');

$pdf->SetFont('arial', 'I', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Disse mais Moisés: Assim o Senhor tem dito: À meia-noite eu sairei pelo meio do Egito; E todo o primogênito na terra do Egito morrerá, desde o primogênito de Faraó, que haveria de assentar-se sobre o seu trono, até ao primogênito da serva que está detrás da mó, e todo o primogênito dos animais. E haverá grande clamor em toda a terra do Egito, como nunca houve semelhante e nunca haverá; Êxodo 11:4-6 "), 0, 'J');

$pdf->SetFont('arial', '', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Você sabe o que é um primogênito? E agora será que o plano de Deus vai dar certo? Mas será que os filhos do povo de Israel não iriam morrer também? Vamos ver..."), 0, 'J');

$pdf->SetFont('arial', 'I', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Falai a toda a congregação de Israel, dizendo: Aos dez deste mês tome cada um para si um cordeiro, segundo as casas dos pais, um cordeiro para cada família. Êxodo 12:3 (fig.4.4) E tomarão do sangue, e pô-lo-ão em ambas as ombreiras, e na verga da porta, nas casas em que o comerem. E eu passarei pela terra do Egito esta noite, e ferirei todo o primogênito na terra do Egito, desde os homens até aos animais; e em todos os deuses do Egito farei juízos. Eu sou o Senhor. E aquele sangue vos será por sinal nas casas em que estiverdes; vendo eu sangue, passarei por cima de vós, e não haverá entre vós praga de mortandade, quando eu ferir a terra do Egito Êxodo 12:7,12,13"), 0, 'J');

$pdf->SetFont('arial', '', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Puxa! Parece que Deus tem sempre tudo bem planejado! O que vocês acham? Será que finalmente esse plano vai dar certo? Por que você acha isso? Você acha que Deus tem um plano para sua vida?"), 0, 'J');
//Tópico

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Portal:"), 0, 1, 'L');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus nos ajude a confiar que o Senhor tem um projeto com nossas vidas e que todas as coisas estão sob o controle do Senhor porque o Senhor é muito poderoso."), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 2"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Porque sou eu que conheço os planos que tenho para vocês, diz o Senhor, planos de fazê-los prosperar e não de lhes causar dano, planos de dar-lhes esperança e um futuro. Jeremias 29:11"), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 2 - O arquiteto da vida."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que é um arquiteto?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é o arquiteto de nossa vida?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como é o projeto de nossa vida?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual nossa parte no projeto?"), 0, 'J');

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
$pdf->Cell(50, 10, $pdf->textoUTF8("5. LIBERTAÇÃO DOS ISRAELITAS"), 0, 1, 'L');

//Tópico

$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Ponte:"), 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Lembram da nossa história? O quê Deus mandou colocar nas portas? Por quê? Será que funcionou? Você acreditaria que simplesmente sujar sua porta com o sangue do cordeiro iria afastar a morte de sua casa? Estava escuro. E se o anjo da morte não visse? E se chovesse e tirasse o sangue? O povo obedeceu e vamos ver o resultado..."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Planta do Santuário:"), 0, 1, 'L');

$pdf->SetFont('arial', 'I', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.5.1) E aconteceu, à meia-noite, que o Senhor feriu a todos os primogênitos na terra do Egito, desde o primogênito de Faraó, que se sentava em seu trono, até ao primogênito do cativo que estava no cárcere, e todos os primogênitos dos animais. E Faraó levantou-se de noite, ele e todos os seus servos, e todos os egípcios; e havia grande clamor no Egito, porque não havia casa em que não houvesse um morto. Êxodo 12:29,30"), 0, 'J');

$pdf->SetFont('arial', '', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("O que aconteceu? A Promessa de Deus em sua Palavra se cumpriu! O anjo passou, os filhos dos egípcios morreram e os de Israel ficaram vivos! Temos promessas de Deus hoje? Onde elas estão escritas? Você acha que elas se cumprem? Deus falou que o sangue os salvaria e salvou!  Vamos ver o que aconteceu..."), 0, 'J');

$pdf->SetFont('arial', 'I', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.5.2) Então chamou a Moisés e a Arão de noite, e disse: Levantai-vos, saí do meio do meu povo, tanto vós como os filhos de Israel; e ide, servi ao Senhor, como tendes dito. Levai também convosco vossas ovelhas e vossas vacas, como tendes dito; e ide, e abençoai-me também a mim. E os egípcios apertavam ao povo, apressando-se para lançá-los da terra; porque diziam: Todos seremos mortos...Fizeram, pois, os filhos de Israel conforme à palavra de Moisés, e pediram aos egípcios joias de prata, e joias de ouro, e roupas. E o Senhor deu ao povo graça aos olhos dos egípcios, e estes lhe davam o que pediam; e despojaram aos egípcios. (fig.5.3) Assim partiram os filhos de Israel de Ramessés para Sucote, cerca de seiscentos mil a pé, somente de homens, sem contar os meninos. Êxodo 12:31-37"), 0, 'J');

$pdf->SetFont('arial', '', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Deus havia falado que ia libertar o povo. Ele libertou? Quando Deus fala algo Ele cumpre? Como eles foram libertos? Deus mandou pragas que só atingiam o povo do Egito. E a última praga? Atingiria a todos! O que salvou a vida deles na última praga? A fé! Acreditar que o sangue poderia salvá-los. Pela fé obedeceram! No mergulho conhecemos o pecado que está dentro de nós. O que é pecado? O que o pecado faz conosco? Ele nos deixa escravos! Como podemos ser livres do pecado? (fig.5.4) O quê a Bíblia diz?"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("... sem derramamento de sangue não há perdão. Hebreus 9:22 e que ...vendo passar a Jesus, disse: Eis aqui o Cordeiro de Deus. João 1:36 "), 0, 'J');

$pdf->SetFont('arial', '', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Então Jesus é como aquele cordeiro que foi morto e foi passado o sangue na porta? A Bíblia diz "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Crê no Senhor Jesus Cristo e serás salvo, tu e a tua casa. Atos 16:31 "), 0, 'J');

$pdf->SetFont('arial', '', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Você já colocou sua fé em Jesus para que seu pecado seja perdoado? Creia na Palavra de Deus e fale com Jesus sobre seus pecados!  O que acha que deveria falar?"), 0, 'J');

//Tópico
$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);

$pdf->Cell(90, 10, $pdf->textoUTF8("Portal:"), 0, 1, 'L');

$pdf->SetFont('arial', '', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Jesus obrigado porque podemos confiar na Tua Palavra e pela morte de Jesus para perdoar nossos pecados."), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 3"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("E o sangue de Jesus Cristo, seu Filho, nos purifica de todo o pecado. 1 João 1:7"), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 3 - Hoje falamos sobre algo que nunca falha, é O Oráculo do Santuário. Vamos desvendar mais este mistério e progredir em nossa construção?"), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que é um oráculo?"), 0, 'J');

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual o oráculo verdadeiro?"), 0, 'J');

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como consultar esse oráculo?"), 0, 'J');

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Para quê devemos consultar esse oráculo?"), 0, 'J');

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
$pdf->Cell(50, 10, $pdf->textoUTF8("6. A SERPENTE DE BRONZE"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Ponte:"), 0, 1, 'L');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Que materiais são utilizados para se construir uma casa? Vamos fazer uma lista! Deixe que as crianças falem e anote: cimento, madeira, prego, martelo. Leia alista e diga que acha que pode mudar alguns materiais para ficar melhor. Vamos substituir o cimento por farinha de trigo, ela é branca, ficará mais bonito. Também os pregos por fita crepe, é mais fácil colar! Será que vai dar certo se eu confiar nos materiais errados e não nos certos? Vamos ver essa história da Bíblia..."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Planta do Santuário:"), 0, 1, 'L');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.6.1) O povo estava andando no deserto indo em direção à terra que Deus lhes tinha prometido e ... Ouvindo o cananeu, rei de Arade, que habitava para o lado sul, que Israel vinha pelo caminho dos espias, pelejou contra Israel, e dele levou alguns prisioneiros. Então Israel fez um voto ao Senhor, dizendo: Se de fato entregares este povo na minha mão, destruirei totalmente as suas cidades. O Senhor, pois, ouviu a voz de Israel, e lhe entregou os cananeus; e os israelitas destruíram totalmente, a eles e às suas cidades; e o nome daquele lugar chamou Hormá. Então partiram do monte Hor, pelo caminho do Mar Vermelho, a rodear a terra de Edom; porém a alma do povo angustiou-se naquele caminho. Você sabe o que é angustiar-se? Se entristecer e ficar ansioso! E o povo falou contra Deus e contra Moisés: Por que nos fizestes subir do Egito para que morrêssemos neste deserto? Pois aqui nem pão nem água há; e a nossa alma tem fastio deste pão tão vil. O que o povo está fazendo? Por quê? Você acha que Deus tem poder para alimentá-los? Será que não aprenderam a ter fé? Eles estão confiando na Palavra de Deus? (fig.6.2) Então o Senhor mandou entre o povo serpentes ardentes, que picaram o povo; e morreu muita gente em Israel. Por isso o povo veio a Moisés, e disse: Havemos pecado, porquanto temos falado contra o Senhor e contra ti; ora ao Senhor que tire de nós estas serpentes. Então Moisés orou pelo povo. O povo reconheceu que estava pecando? O que será que Deus vai fazer?"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.6.3) E disse o Senhor a Moisés: Faze-te uma serpente ardente, e põe-na sobre uma haste; e será que viverá todo o que, tendo sido picado, olhar para ela. E Moisés fez uma serpente de metal, e pô-la sobre uma haste; e sucedia que, picando alguma serpente a alguém, quando esse olhava para a serpente de metal, vivia. Números 21:1-9"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Deus mandou as serpentes para picarem. Por quê? Eles estavam sempre voltando ao mesmo erro e não confiando em Deus. Deus então coloca uma outra serpente. Qual a diferença da serpente de bronze pendurada na madeira e as outras? (fig.6.4) A de bronze era para a salvação. Eles mereciam? Mas Deus nos ama tanto que nos dá escolha de nos arrependermos das coisas erradas e confiar e obedecer a Sua Palavra. Deus nos deu Sua Palavra para nosso bem, ela revela a vontade de Deus que é sempre boa. O que você precisa fazer para saber da vontade de Deus que está na Bíblia? Qual a vontade dEle com relação a Jesus? Você já confiou em Jesus e Sua salvação? Ele foi como aquela serpente que foi levantada e que salvava o povo!"), 0, 'J');

//Tópico

$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Portal:"), 0, 1, 'L');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Querido Deus nos ajude a olharmos sempre para Jesus para nossa salvação e para Tua Palavra, nos ajude a ter fé e nunca duvidarmos!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 3"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E o sangue de Jesus Cristo, seu Filho, nos purifica de todo o pecado. 1 João 1:7"), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 3 - Já descobriram o que é O Oráculo do Santuário?"), 0, 'J');

$pdf->Ln(10);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que é um oráculo?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual o oráculo verdadeiro?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como consultar esse oráculo?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Para quê devemos consultar esse oráculo?"), 0, 'J');

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
$pdf->Cell(50, 10, $pdf->textoUTF8("7. TABERNÁCULO"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Ponte:"), 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos desenhar uma casa não desenhem portas nem janelas! Agora no lugar das portas e janelas desenhem boca e olhos. Agora coloquem mãos e pés! O que acham? É possível uma casa andar e falar? Para que serve uma casa? Para abrigar, dar descanso... Vamos fingir que somos casas, o que diríamos?  Vamos andar e falar como se fossemos uma casa. A Bíblia nos conta a história da casa de Deus que andava, vamos ver!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Planta do Santuário:"), 0, 1, 'L');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.7.1) Disse o Senhor a Moisés:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Diga aos israelitas que me tragam uma oferta. Receba-a de todo aquele cujo coração o compelir a dar. Êxodo 25:1,2 E farão um santuário para mim, e eu habitarei no meio deles."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Olhem Deus está pedindo que façam um Santuário. Para quê? E Ele diz algo muito importante! "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Façam tudo como eu lhe mostrar, conforme o modelo do tabernáculo e de cada utensílio. Êxodo 25:8,9  "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.7.2) Gente, Deus deu uma lista de coisas que deveriam estar no Tabernáculo ou Santuário, tudo com material, tamanho e cor específicos, tudo cheio de detalhes. Até as roupas que as pessoas usariam. Vocês acham que Moisés fez o que Deus mandou certinho? Pela primeira vez Moisés fez tudo certinho sem questionar e Deus disse:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Chame seu irmão Arão e separe-o dentre os israelitas, e também os seus filhos Nadabe e Abiú, Eleazar e Itamar, para que me sirvam como sacerdotes. Para o seu irmão Arão, faça vestes sagradas que lhe confiram dignidade e honra. Êxodo 28:1,2"), 0, 'J');

$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.7.3) Assim consagrarei a Tenda do Encontro e o altar, e consagrarei também Arão e seus filhos para me servirem como sacerdotes. E habitarei no meio dos israelitas e lhes serei o seu Deus. Saberão que eu sou o Senhor, o seu Deus, que os tirou do Egito para habitar no meio deles. Eu sou o Senhor, o seu Deus. Êxodo 29:44-46"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.7.4) Quem iria habitar nesse lugar? O próprio Deus! Existia um lugar lá dentro que ninguém podia entrar, só o sacerdote e tinha que pedir perdão de seus pecados senão morria na hora. Você teria coragem de entrar? Deus ficou morando com seu povo, eles desmontavam tudo, andavam no deserto e quando Deus mandava, eles paravam e montavam tudo. Então, pediam perdão pelos seus pecados e adoravam a Deus. Era um santuário com pernas! Andava com as pernas de quem? Do povo. Vocês sabem de quando Deus andou aqui na terra com suas próprias pernas? Isso! Jesus era o próprio Deus e ele andou aqui na terra. Sua vida era um santuário. Tudo o que Ele fazia era para adorar a Deus! E para quê Jesus veio? Para quê Ele morreu? Para perdoar nossos pecados! E Ele está morto agora? E onde Ele habita? E aonde mais?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Portal:"), 0, 1, 'L');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Jesus muito obrigado porque o Senhor sendo Deus veio morar conosco e morreu numa cruz para perdoar os nossos pecados!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 4"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vocês não sabem que são santuário de Deus e que o Espírito de Deus habita em vocês? 1 Coríntios 3:16"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 4 - Os Santuários vivos"), 0, 'J');
$pdf->Ln(10);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que Santuários são esses?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual o alicerce?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é o arquiteto?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual é o material de construção?"), 0, 'J');

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
$pdf->Cell(50, 10, $pdf->textoUTF8("8. RAABE"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Ponte:"), 0, 1, 'L');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Como algo velho e imprestável pode se tornar útil? Podem pensar em coisas que podemos fazer com lixo? Como se faz reciclagem? Você tem que desmanchar algo e fazer de novo. (Mostre um fantoche de caixa de leite) Quais foram os passos? Cortamos a caixa, mudamos a forma, fizemos algo novo. Você sabia que Deus pode fazer isso com uma pessoa?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Planta do Santuário:"), 0, 1, 'L');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Essa é a história de uma mulher prostituta que morava em Jericó. O que é uma prostituta? Elas são felizes? A vida delas é horrível e elas devem se sentir muito mau, são como uma casa toda quebrada e suja. Mas com a mulher de nossa história, Deus mudou isso! Escutem: Josué, que ficou liderando o povo no lugar de Moisés quando ele morreu, queria dominar a cidade de Jericó que Deus lhe havia prometido. Então Josué, filho de Num, enviou secretamente de Sitim dois espiões e lhes disse:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vão examinar a terra, especialmente Jericó. "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Eles foram e entraram na casa de uma prostituta chamada Raabe, e ali passaram a noite. (fig.8.1) Todavia o rei de Jericó foi avisado:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Alguns israelitas vieram aqui esta noite para espionar a terra. Diante disso, o rei de Jericó enviou esta mensagem a Raabe: Mande embora os homens que entraram em sua casa, pois vieram espionar a terra toda. Josué 2:1-3 "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Josué estava em perigo! Será que Raabe vai entregar Josué para os soldados? (fig.8.2) Mas a mulher que tinha escondido os dois homens respondeu: "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("É verdade que os homens vieram a mim, mas eu não sabia de onde tinham vindo. (fig.8.3) Ao anoitecer, na hora de fechar a porta da cidade, eles partiram. Não sei por onde foram. Corram atrás deles. Talvez os alcancem. Ela, porém, os tinha levado para o terraço e os tinha escondido sob os talos de linho que havia arrumado lá. Josué 2:4-6"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Ela os escondeu! E até mentiu, arriscando sua própria vida! Por que Raabe fez isso? O que acham? Ela explicou o porquê: Pois temos ouvido como o Senhor secou as águas do mar Vermelho perante vocês quando saíram do Egito, e o que vocês fizeram a leste do Jordão com Seom e Ogue, os dois reis amorreus que aniquilaram. Quando soubemos disso, o povo desanimou-se completamente, e por causa de vocês todos perderam a coragem, pois o Senhor, o seu Deus, é Deus em cima nos céus e embaixo na terra. Josué 2:10,11 Raabe tinha ouvido do poder de Deus! Ela acreditou em Deus! Ela então pediu que eles se lembrassem dela e de sua família se fossem destruir a terra, eles prometeram que a ajudariam e ela continuou a ajudá-los: Então Raabe os ajudou a descer pela janela com uma corda, pois a casa em que morava fazia parte do muro da cidade, e lhes disse:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vão para aquela montanha, para que os perseguidores não os encontrem. Escondam-se lá por três dias, até que eles voltem; depois poderão seguir o seu caminho. Josué 2:10,16"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.8.4) Então os homens disseram a Raabe: "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Estaremos livres do juramento que você nos levou a fazer se, quando entrarmos na terra, você não tiver amarrado este cordão vermelho na janela pela qual nos ajudou a descer, e se não tiver trazido para a sua casa o seu pai e a sua mãe, os seus irmãos e toda a sua família. Qualquer pessoa que sair da casa será responsável por sua própria morte; nós seremos inocentes. Mas, seremos responsáveis pela morte de quem estiver na casa com você, caso alguém toque nessa pessoa. Josué 2:17-19"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Lembram do sangue na porta? Ela não tinha sangue e Josué lhe deu um fio vermelho que representava sua salvação. Se ela obedecesse ficariam vivos, se não, morreriam. Será que Raabe teve fé? Será que ela pendurou o fio? Sim, ela pendurou e foi salva! Josué disse aos dois homens que tinham espionado a terra:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Entrem na casa da prostituta e tirem-na de lá com todos os seus parentes, conforme o juramento que fizeram a ela. Então os jovens que tinham espionado a terra entraram e trouxeram Raabe, seu pai, sua mãe, seus irmãos e todos os seus parentes. Josué 6:22,23"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Raabe colocou sua fé em quem? Sua vida foi salva? Como vocês acham que Raabe passou a viver? Deus mudou a vida dela, ela era como uma casa suja e quebrada e Deus a transformou num lugar de esconderijo para seu povo, um lugar de benção e fé! Você quer que Deus mude sua vida também? "), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Portal:"), 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus nos ajude a colocar nossa fé no Senhor para sermos benção e abençoados"), 0, 'J');
$pdf->Ln(10);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 4 -"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vocês não sabem que são santuário de Deus e que o Espírito de Deus habita em vocês? 1 Coríntios 3:16"), 0, 'J');

$pdf->Ln(10);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 4 - O Santuário vivo"), 0, 'J');
$pdf->Ln(10);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que Santuário é esse?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual o alicerce?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é o arquiteto?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual é o material de construção"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');


// Página 9
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 09"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("9. O REI DAVI E O REI JESUS"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Ponte:"), 0, 1, 'L');
$pdf->SetFont('arial', '', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Você conhece as placas de trânsito? Pode lembrar de algumas? As placas são importantes? Por quê? O quê essa placa significa? Ela tem uma seta, uma indicação e para onde ela aponta? Essa placa é como a Bíblia. Desde gênesis até o último livro, ela aponta numa direção só! Que direção será essa? Querem ver um exemplo?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Planta do Santuário:"), 0, 1, 'L');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.9.1) Existiu um jovem chamado Davi, ele era o menor em sua família, ele era pastor de ovelhas enquanto seus irmãos eram bravos guerreiros, por isso era desprezado por seus irmãos. A Bíblia nos diz que Jesus foi como Davi, escutem:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Ele não tinha qualquer beleza ou majestade que nos atraísse, nada em sua aparência para que o desejássemos. Foi desprezado e rejeitado pelos homens 	Isaías 53:2,3"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Jesus também foi desprezado? Davi era pastor! Ele estava disposto a dar sua vida pelas ovelhas, ele lutou com um leão e um urso para proteger suas ovelhas. Quem Jesus disse que era? Eu sou o bom pastor, o bom pastor dá a sua vida pelas ovelhas João 10:14. Era parecido? O que vocês acham? Porém, Davi, aquele menino desprezado foi o escolhido de Deus para ser rei em Israel, não seus irmãos! Por que será? Davi tinha o coração em Deus e estava disposto a morrer para obedecer a Deus. Vocês lembram de alguém que fez isso?"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("ele tomou sobre si as nossas enfermidades e sobre si levou as nossas doenças, contudo nós o consideramos castigado por Deus, por ele atingido e afligido. Isaías 53:4."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Jesus deu a sua vida por nós na cruz, ele não tinha pecado e estava dando a sua vida para nos perdoar os pecados porque sem morte não pode haver perdão de pecados."), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O salário do pecado é a morte Romanos 6:23"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E a Bíblia diz:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mas ele foi transpassado por causa das nossas transgressões, foi esmagado por causa de nossas iniquidades; o castigo que nos trouxe paz estava sobre ele, e pelas suas feridas fomos curados. Todos nós, tal qual ovelhas, nos desviamos, cada um de nós se voltou para o seu próprio caminho; e o Senhor fez cair sobre ele a iniquidade de todos nós. Isaías 53:4-6 "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Como Jesus amava a Deus e a nós! Ele amava tanto que morreu numa cruz, enfrentou a morte e ficou morto 3 dias antes de ressuscitar e vencer a morte. Jesus está vivo! Ele venceu a morte. Ele fez o impossível! E Davi? (fig.9.2) Davi, um dia foi levar alimento para seus irmãos e viu um gigante de mais de 4 metros de altura falando mal de Deus e desafiando seu povo. Davi era só um pastor, não tinha força própria, mas tinha o desejo de agradar a Deus. Vejam o que ele disse ao rei:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Teu servo toma conta das ovelhas de seu pai. Quando aparece um leão ou um urso e leva uma ovelha do rebanho, eu vou atrás dele, atinjo-o com golpes e livro a ovelha de sua boca. Teu servo é capaz de matar tanto um leão quanto um urso; esse filisteu incircunciso será como um deles, pois desafiou os exércitos do Deus vivo. O Senhor que me livrou das garras do leão e das garras do urso me livrará das mãos desse filisteu."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Como Davi pretendia vencer Golias? O que vocês acham? Davi vestiu uma armadura, mas era muito pesada.  Assim tirou tudo aquilo, e em seguida pegou seu cajado, escolheu no riacho cinco pedras lisas, colocou-as na bolsa, isto é, no seu alforje de pastor e, com sua atiradeira na mão, aproximou-se do filisteu. Como ele iria vencer um gigante com 5 pedras? O que você acha que vai acontecer? Davi disse ao filisteu: Você vem contra mim com espada, com lança e com dardo, mas eu vou contra você em nome do Senhor dos Exércitos, o Deus dos exércitos de Israel, a quem você desafiou."), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.9.3) Quando o filisteu começou a vir na direção de Davi, este correu depressa na direção da linha de batalha para enfrentá-lo. Retirando uma pedra de seu alforje ele a arremessou com a atiradeira e atingiu o filisteu na testa, de tal modo que ela ficou encravada, e ele caiu com o rosto no chão.. 1 Samuel 17:20-50"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Como ele conseguiu?  Deus estava com ele! O maior Golias que existe é o pecado em nossas vidas! E esse golias chamado pecado, Jesus venceu sem nada em suas mãos. (fig.9.4) A vida de Davi apontava para quem? Para Jesus! A Bíblia inteira aponta para Jesus! A Bíblia deve estar em sua vida, no seu coração, no seu santuário, para que você seja como Davi, para que você seja como Jesus! Davi foi feito rei de Israel, e Jesus? Olhem a promessa que Deus fez a Davi: "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Quando a sua vida chegar ao fim e você descansar com os seus antepassados, escolherei um dos seus filhos para sucedê-lo, um fruto do seu próprio corpo, e eu estabelecerei o reino dele. Será ele quem construirá um templo em honra do meu nome, e eu firmarei o trono dele para sempre. Eu serei seu pai, e ele será meu filho. 2 Samuel 7:12-14"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Quem é o descendente de Davi? Jesus, Ele era conhecido como Filho de Davi! Ele é o rei do santuário de nossas vidas!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Portal:"), 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Obrigado Senhor porque a Bíblia nos mostra o caminho para Jesus, nos ajude a andar nesse caminho!"), 0, 'J');
$pdf->Ln(10);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 5 -"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Se vivemos, vivemos para o Senhor; e, se morremos, morremos para o Senhor. Assim, quer vivamos, quer morramos, pertencemos ao Senhor. Romanos 14:8"), 0, 'J');
$pdf->Ln(10);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 5 - O Livro seta"), 0, 'J');
$pdf->Ln(10);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que é uma seta"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que livro é esse?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Para onde ele aponta?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Por que ele aponta para esse local?"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');

// Página 9

$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 10"), 0, 0, 'C');
$pdf->Ln(10);
$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("10. AS PROFECIAS SOBRE JESUS"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Ponte:"), 0, 1, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Você lembra de nossa última conversa? De como a Bíblia, nosso material de construção de nossas vidas, aponta para Jesus? Você sabia que mais 400 anos antes de Jesus nascer a Bíblia já dizia de quem ele seria filho, onde ele nasceria, quem o batizaria, como ele morreria e que ele ressuscitaria? Você dúvida? Mas como as pessoas que escreveram poderiam saber? Essa é uma das razões porque eu creio na Bíblia, é porque Deus guiou os homens que a escreveram. Não tinha como eles saberem esses detalhes se o próprio Deus não tivesse revelado. Escutem:"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Planta do Santuário:"), 0, 1, 'L');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.10.1) O profeta Isaías disse que o salvador seria da família de Davi"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Dias virão, declara o Senhor, em que levantarei para Davi um Renovo justo, um rei que reinará com sabedoria e fará o que é justo e certo na terra. O Messias seria descendente de Davi. Isaías 7:13-14"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E aconteceu! Escutem o que Lucas falou sobre Jesus: "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Ele será grande e será chamado Filho do Altíssimo. O Senhor Deus lhe dará o trono de seu pai Davi Lucas 1:32"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O profeta Miquéias falou sobre o lugar onde Jesus iria nascer "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8(" E tu, Belém Efrata, posto que pequena entre os milhares de Judá, de ti me sairá o que governará em Israel, e cujas saídas são desde os tempos antigos, desde os dias da eternidade. Miquéias 5:2"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E olhem o que Lucas conta:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Assim, José também foi da cidade de Nazaré da Galiléia para a Judéia, para Belém, cidade de Davi, porque pertencia à casa e à linhagem de Davi. Lucas 2:4  "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8(" José foi para Belém porque precisava se apresentar na contagem das pessoas e lá Jesus nasceu! Isaías também disse que ele nasceria de uma virgem, uma mulher que nunca tinha dormido com nenhum homem"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Portanto o Senhor mesmo vos dará um sinal: eis que uma virgem conceberá, e dará à luz um filho, e será o seu nome Emanuel. Isaías 7:14"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E isso se cumpriu! Um anjo do Senhor falou com José:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("José, filho de Davi, não tema receber Maria como sua esposa, pois o que nela foi gerado procede do Espírito Santo.  Mateus 1:20 "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E ai? As profecias se cumpriram? A Bíblia fala a verdade então? Agora vocês vão checar se a Bíblia fala a verdade! O que diz este versículo? (fig.10.2)"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Eis que eu envio o meu mensageiro, que preparará o caminho diante de mim; Malaquias 3:1"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("e esses, o que dizem? E, naqueles dias, apareceu João o Batista pregando no deserto da Judéia, E dizendo:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Arrependei-vos, porque é chegado o reino dos céus. Porque este é o anunciado pelo profeta Isaías, que disse: Voz do que clama no deserto: Preparai o caminho do Senhor, Endireitai as suas veredas. Mateus 3:1-3"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Quem foi o mensageiro que anunciou Jesus? (fig.10.3) E esta outra promessa?"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mas ele foi transpassado por causa das nossas transgressões, foi esmagado por causa de nossas iniquidades; o castigo que nos trouxe paz estava sobre ele, e pelas suas feridas fomos curados. Isaías 53:5 "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Jesus fez isso? Escutem:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Pois também Cristo sofreu pelos pecados uma vez por todas, o justo pelos injustos, para conduzir-nos a Deus. 1 Pedro 3:18. "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.10.4) Mas Jesus ficou morto? Escutem o que Oséias falou 800 anos antes:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Depois de dois dias ele nos dará vida novamente; ao terceiro dia nos restaurará, para que vivamos em sua presença. Oséias 6:2"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E o que aconteceu? Por seu poder, Deus ressuscitou o Senhor e também nos ressuscitará. 1 Coríntios 6:14 Você acha que a Bíblia fala a verdade? Podemos construir nossa vida fazendo o que a Bíblia diz? Você quer decidir agora entregar sua vida a Jesus que morreu pelos seus pecados? Você quer ser um santuário vivo e agradar a Deus com sua vida?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Portal:"), 0, 1, 'L');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus te agradecemos porque podemos ter fé na Tua Palavra porque ela é verdadeira e nunca falha!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 5 -"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Se vivemos, vivemos para o Senhor; e, se morremos, morremos para o Senhor. Assim, quer vivamos, quer morramos, pertencemos ao Senhor.Romanos 14:8"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 5 - O livro seta  - Já descobriu o mistério?"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que é uma seta?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que livro é esse?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Para onde ele aponta?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Por que ele aponta para esse local?"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');

$pdf->AddPage();

$pdf->Ln(8);
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 5, $pdf->textoUTF8("Respostas de Mistérios - Santuário"), 0, 1, 'C');
$pdf->Ln(8);
$pdf->Cell(0, 5, "", "B", 1, 'C');


$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

// 01	
$pdf->Ln(10);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 1 - Mais resistente que o aço."), 0, 'J');
$pdf->Ln(10);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que é? - A fé"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como é produzida? - É dada por Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que ela pode fazer? - Nos proteger"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que você pode construir com ela? - Minha vida"), 0, 'J');

// 02
$pdf->Ln(10);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 2 - O arquiteto da vida."), 0, 'J');
$pdf->Ln(10);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que é um arquiteto? - Uma pessoa que planeja uma construção"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é o arquiteto de nossa vida? - Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como é o projeto de nossa vida? - Só Deus sabe"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual nossa parte no projeto? - Obedecer e confiar"), 0, 'J');

// 03
$pdf->Ln(10);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 3 - O Oráculo do Santuário"), 0, 'J');
$pdf->Ln(10);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que é um oráculo? - É a vontade de um Deus para nós"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual é o oráculo verdadeiro? - A Palavra de Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como consultar esse oráculo? - Lendo todos os dias"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Para quê devemos consultar esse oráculo? - Para saber a vontade de Deus para nossas vidas"), 0, 'J');

// 04				
$pdf->Ln(10);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 4 - O Santuário vivo"), 0, 'J');
$pdf->Ln(10);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que Santuário é esse? - Minha vida"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual o alicerce? - Fé"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é o arquiteto? - Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual é o material de construção? - A Palavra"), 0, 'J');

// 05
$pdf->Ln(10);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 5 - O Livro seta"), 0, 'J');
$pdf->Ln(10);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que é uma seta? - Algo que indica o caminho"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que livro é esse? - A Bíblia"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Para onde ele aponta? - Para Jesus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Por que ele aponta para esse local? - Porque Jesus é o salvador"), 0, 'J');

$pdf->ln(200);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');


$nome_relatorio = $pdf->textoUTF8("Santuário");

$pdf->Output("$nome_relatorio.pdf", "I");
