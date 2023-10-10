<?php

$usuario = $_GET['id_lider'] ?? 0;
$id_modulo = $_GET['id_modulo'] ?? "4";

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
	$nome_usuario .= $dados_pais['nome_pais'];
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
$pdf->Ln(8);
$pdf->Cell(60, 10, $pdf->textoUTF8("Módulo:"), 0, 0, 'J');
$pdf->Cell(0, 10, $pdf->textoUTF8($modulo['nome_modulo']), 0, 1, 'J');
$pdf->Ln(8);

$pdf->Ln(300);
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 5, $pdf->textoUTF8("Máterial Arco"), 0, 1, 'C');
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
$pdf->Cell(50, 10, $pdf->textoUTF8("1. O NASCIMENTO DE JESUS."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Preparação:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Você já viu um navio dentro de uma garrafa? (fig 1.1) Como você acha que foi feito? O que preci-sou acontecer com o navio para ele entrar lá? Será que tem a mesma capacidade de um navio grande? Ele precisou diminuir, ele ainda pode navegar, mas teve que diminuir para entrar lá. No caso do navio ele foi construído dentro da garrafa. Sabe quem este navio me lembra? Jesus. Sabe por quê?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Plano de Voo:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz sobre seu nascimento:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(Fig. 1.2) E, no sexto mês, foi o anjo Gabriel enviado por Deus a uma cidade da Galileia, chamada Nazaré, a uma virgem desposada com um homem, cujo nome era José, da casa de Davi; e o nome da virgem era Maria."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O que é uma pessoa virgem? O que significa desposada? Alguém que foi pedida em casamento. Seria a noiva de hoje. Maria era noiva e nunca tinha entregado seu corpo a nenhum homem. Quem foi falar com ela? Um anjo!"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E, entrando o anjo aonde ela estava, disse: Salve, agraciada; o Senhor é contigo; bendita és tu entre as mulheres. E, vendo-o ela, perturbou-se muito com aquelas palavras, e considerava que saudação seria esta."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Você sabe o que quer dizer agraciada? Alguém que recebe um favor que não merece. Maria era pecadora e Deus estava dizendo que iria lhe dar algo bom que ela não merecia, o que será?"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Disse-lhe, então, o anjo: Maria, não temas, porque achaste graça diante de Deus. E eis que em teu ventre conceberás e darás à luz um filho, e colocarás o nome de Jesus. E disse Maria ao anjo: Como se fará isto, visto que não conheço homem algum? E, respondendo o anjo, disse-lhe: Descerá sobre ti o Espírito Santo ... por isso também o Santo, que de ti há de nascer, será chamado Filho de Deus."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O que o anjo disse? Jesus é filho de quem? Mas Deus é como um homem? Lembram a garrafa? Jesus é o filho de Deus, enorme e poderoso, mas ele se fez homem como nós. Deus o colocou na barriga daquela virgem como milagre. É possível uma virgem ter um filho, so-zinha, sem homem e sem médicos que abram a barriga dela e coloquem o bebê lá? É possível? Você acha que Deus pode fazer o impossível? E vocês sabiam que esse não foi o único milagre na família de Maria? O anjo contou a Maria so-bre outro milagre. (fig. 1.2)"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E eis que também Isabel, tua prima, concebeu um filho em sua velhice; e é este o sexto mês para aquela que era chamada estéril; Porque para Deus nada é impossível. Lucas 1:26,34-37 "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Uau! Isabel era idosa. Pessoas velhinhas podem ter filhos? E ela nunca pôde ter filhos. O que você acha disso? Mas, e no caso de Maria, o que seu noivo iria dizer? Ele iria ficar zangado de ver sua noiva grávi-da? Será que ele iria abandoná-la? Vamos ver (fig. 1.3):"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Então José, seu marido, como era justo, e a não queria difamar, quis deixá-la secretamente. E planejando ele isto, eis que em sonho lhe apareceu um anjo do Senhor, dizendo: José, filho de Davi, não temas receber a Maria, tua mulher, porque o que nela está gerado é do Espírito Santo; E dará à luz um filho e chamarás o seu nome JESUS; porque ele salvará o seu povo dos seus pecados. Mateus 1:18-21 "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vocês acham que José a deixou? Por-que não? Porque ele amava a Deus e acreditava no amor de Deus. E você? (fig.1.4) Jesus nasceu para cumprir as promessas dos profetas! E tinha que ser tudo do jeitinho que foi!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Soltando as cordas:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Obrigado Jesus porque o Senhor é filho de Deus, mesmo sendo Deus se tornou homem e nasceu nesse mundo para mostrar Seu amor por nós."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 1"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Porque Deus tanto amou o mundo que deu o seu Filho Unigênito, para que todo o que nele crer não pereça, mas tenha a vida eterna. João 3:16"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 1 - O Dono do Azul"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que representa  a cor azul?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é o dono do azul?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que Ele sente por nós?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Nós merecemos?"), 0, 'J');


$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);	    
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $nome_usuario, 0, 1, 'J');

// Página 3		
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 02"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("2. O BATISMO DE JESUS"), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Preparação:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos brincar de quem consegue fazer 1 minuto de silêncio? É difícil ficar em silêncio? Imagine uma pessoa que você ama ficar em silêncio sem falar com você por um dia? Deve ser horrível! Imagine 400 anos de silêncio! A Bíblia nos diz que Deus passou 400 anos sem falar com seu povo através de profetas. O que é um profeta? Aquele que fala as palavras de Deus! Só que as pessoas começaram a não gostar dos profetas de Deus então Ele passou 400 anos sem mandar profetas, porque eles esta-vam matando os profetas. Deve ter sido muito triste ficar sem ninguém para falar as palavras de Deus. Mas então, Deus mandou um profeta e nós falamos do nascimento dele, você sabe quem é? Ele estava na barriga de Isabel!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Plano de Voo:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz dele:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Fará retornar muitos dentre o povo de Israel ao Senhor, o seu Deus. E irá adiante do Senhor, no espírito ..., para fazer voltar o coração dos pais a seus filhos e os desobedientes à sabedoria dos justos, para deixar um povo preparado para o Senhor. Lucas 1:16,17"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("João Batista era o nome do menino, e ele cresceu (fig. 2.1) para preparar o caminho de quem? O que significa preparar o caminho? Preparar as pessoas para receber alguém. E foi assim! Apareceu João batizando no deserto, e pregando o batismo de arrependimento, para perdão dos pecados. E toda a província da Judéia e os de Jerusalém iam ter com ele; e todos eram batizados por ele no rio Jordão, confessando os seus pecados. E João andava vestido de pêlos de camelo, e com um cinto de couro em redor de seus ombros, e comia gafanhotos e mel silvestre. E pregava, dizendo: Após mim vem aquele que é mais forte do que eu, do qual não sou digno de, abaixando-me, desatar a correia das suas sandálias. (fig. 2.2) Eu, em verdade, tenho-vos batizado com água; ele, porém, vos batizará com o Espírito Santo. Quem será que viria depois de João e que seria mais importante que ele?"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("( fig. 2.3) E aconteceu naqueles dias que Jesus, tendo ido de Nazaré da Galiléia, foi batizado por João, no Jordão. E, logo que saiu da água, viu os céus abertos, e o Espírito, que como pomba descia sobre ele. (fig. 2.4) E ouviu-se uma voz dos céus, que dizia: Tu és o meu Filho amado em quem me comprazo. Marcos 1:4-11 "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Jesus era filho de quem? De onde veio aquela voz? O quê se abriu? Então de onde veio o Espírito Santo? Lembra que aprendemos que Deus são 3 em um só? Deus Pai, Deus filho e Deus Espírito Santo. Quantos então ficaram andando por este mundo? Que tamanho você acha que é o amor de Deus? Para vir aqui pessoalmente para ensinar as pessoas e mostrar seu amor por elas?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Soltando as cordas:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus muito obrigado pelo seu amor e por ter enviado Jesus e o Espírito Santo para nos ensinar e mostrar o amor de Deus por nós."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 1"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Porque Deus tanto amou o mundo que deu o seu Filho Unigênito, para que todo o que nele crer não pereça, mas tenha a vida eterna. João 3:16"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 1 - O Dono do Azul"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que representa a cor azul?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é o dono do azul?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que Ele sente por nós?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Nós merecemos?"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $nome_usuario, 0, 1, 'J');

// Página 4	
$pdf->AddPage();
//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 03"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("3. A TENTAÇÃO"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Preparação:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos pensar que você é dono de 1 fazenda bem grande! (Mostre o papel inteiro). Então chega alguém e diz que quer comprar 1 pedacinho pequeno bem no meio de sua fazenda e lhe paga bem pelo pedacinho bem no meio. Você topa (desenhe um ponto no meio e mostre). Vocês acham que vai fazer grande diferença só este pontinho? Parece que não. Mas como é que essa pessoa vai chegar à terrinha dela? A lei diz que todos tem que ter acesso a suas casas. Então você tem que construir uma estrada que vai cortar toda a sua fazenda bem no meio (trace a linha), e ai seus animais não podem andar perto da estrada e então você não pode mais plantar ali e todas as pessoas que querem visitar o homem da terrinha vão passar lá também. Fez diferença agora? Muita! O pecado é assim na nossa vida, só quer tomar espaço!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Plano de Voo:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que Jesus fez diante do pecado: Lembram do batismo de Jesus? Logo depois que saiu da água, (fig. 3.1) ...foi conduzido Jesus pelo Espírito ao deserto, para ser tentado pelo diabo."), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E, tendo jejuado quarenta dias e quarenta noites, depois teve fome; (fig. 3.2) E, chegando-se a ele o tentador, disse: Se tu és o Filho de Deus, manda que estas pedras se tornem em pães."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E, chegando-se a ele o tentador, disse: Se tu és o Filho de Deus, manda que estas pedras se tornem em pães. O que o diabo estava querendo? Jesus podia transformar pedras em pães? Mas Ele foi para o deserto para comer? Ele estava jejuando? O que é Jejum? Jejum é quando você não quer fazer algo que você gosta para se dedicar mais a Deus e pedir ou agradecer algo a Ele. Você mostra a Deus o quanto você quer aquilo. O que vocês acham que Jesus queria? O que Jesus ia passar? Será que Ele ia precisar de ajuda? Ele era Deus, mas Ele era homem também.  Ia ser difícil se humilhar e ir para a cruz? Jesus estava se preparando para não usar seus superpoderes, para ir para a cruz. O Diabo estava propondo que Ele usasse seus superpoderes. Queria atrapalhar Jesus. Vamos ver o que Ele disse? O que o diabo estava querendo? Jesus podia transformar pedras em pães? Mas Ele foi para o deserto para comer? Ele estava jejuando? O que é Jejum? Jejum é quando você não quer fazer algo que você gosta para se dedicar mais a Deus e pedir ou agradecer algo a Ele. Você mostra a Deus o quanto você quer aquilo. O que vocês acham que Jesus queria? O que Jesus ia passar? Será que Ele ia precisar de ajuda? Ele era Deus, mas Ele era homem também. Ia ser difícil se humilhar e ir para a cruz? Jesus estava se preparando para não usar seus superpoderes, para ir para a cruz. O Diabo estava propondo que Ele usasse seus superpoderes. Queria atrapalhar Jesus. Vamos ver o que Ele disse? Ele, porém, respondendo, disse: Está escrito: Nem só de pão viverá o homem, mas de toda a palavra que sai da boca de Deus. (fig. 3.3) Então o diabo o transportou à cidade santa, e colocou-o sobre o ponto mais alto do templo."), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E disse-lhe: Se tu és o Filho de Deus, lança-te de aqui abaixo; porque está escrito: Que aos seus anjos dará ordens a teu respeito, E tomar-te-ão nas mãos, Para que nunca tropeces com o teu pé em alguma pedra. "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O diabo falou até o que estava escrito na Bíblia para fazer Jesus usar seus poderes de Deus. Mas, devemos pular de uma árvore só porque Deus fala que vai cuidar de nós? Deus faz o que não podemos fazer! Você pode evitar pular de uma árvore? Se você quer pular mesmo assim, então Ele vai te pegar? Não, você pulou porque quis. O diabo queria fazer Jesus pecar! Disse-lhe Jesus: Também está escrito: Não tentarás o Senhor teu Deus.(fig. 3.4)"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Novamente o transportou o diabo a um monte muito alto; e mostrou-lhe todos os reinos do mundo, e a glória deles. E disse-lhe: Tudo isto te darei se, prostrado, me adorares. Quem é o dono de tudo? O diabo quis enganar Jesus como enganou Eva. Então disse-lhe Jesus: Vai-te, Satanás, porque está escrito: Ao Senhor teu Deus adorarás, e só a ele servirás. Então o diabo o deixou; (fig.3.5) e, eis que chegaram os anjos, e o serviam. Mateus 4:1-11"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Ao contrário de Adão e Eva, Jesus não pecou. O que Ele fez para não errar? Será que é importante memorizarmos a Palavra de Deus? E para quê Jesus veio a esse mundo? Para nos livrar da condenação do pecado. Ele veio para pagar o salário de nosso pecado. Foi castigado pelo nosso pecado. Vamos agradecer a Deus por isso?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Soltando as cordas:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Obrigado Deus porque o Senhor nos ama tanto que mandou Seu filho para morrer por nós e nos livrar da condenação do pecado."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 2"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Pois o salário do pecado é a morte, mas o dom gratuito de Deus é a vida eterna em Cristo Jesus, nosso Senhor. Romanos 6:23"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 2 - O Arco Colorido e a Flecha invisível"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que arco é esse?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem fez o arco?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que ele representa?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que flecha é essa?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual a cor da flecha?"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $nome_usuario, 0, 1, 'J');

// Página 5
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 04"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("4. NICODEMOS."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Preparação:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Quando você nasceu? Quem sabe a data? Você sabia que todas as pessoas precisam nascer de novo? Nascer uma segunda vez? Mas como é isso? O que vocês acham?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Plano de Voo:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.4.1) Havia um fariseu chamado Nicodemos, uma autoridade entre os judeus. Ele veio a Jesus, à noite, e disse: Mestre, sabemos que ensinas da parte de Deus, pois ninguém pode realizar os sinais miraculosos que estás fazendo, se Deus não estiver com ele. Em resposta, Jesus declarou: Digo-lhe a verdade: Ninguém pode ver o Reino de Deus, se não nascer de novo. "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Olhem ai, Jesus está dizendo que todos devem nascer de novo, como é isso? E por quê? A mesma pergunta Nicodemos fez! Perguntou Nicodemos:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Como alguém pode nascer, sendo velho? É claro que não pode entrar pela segunda vez na barriga de sua mãe e renascer!  Respondeu Jesus: Digo-lhe a verdade: Ninguém pode entrar no Reino de Deus, se não nascer da água e do Espírito. O que nasce da carne é carne, mas o que nasce do Espírito é espírito. Não se surpreenda pelo fato de eu ter dito: É necessário que vocês nasçam de novo. "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Então existem 2 nascimentos? 1 da carne e outro de quê? Do Espírito. Mas nosso espírito está morto? A Bíblia diz:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vocês estavam mortos em suas transgressões e pecados, Efésios 2:1 "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O que diz esse versículo? Para Deus estamos mortos e quando essa vida acabar se não temos Jesus, seremos mortos eternamente."), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig. 4.2) ...Perguntou Nicodemos: Como pode ser isso? Disse Jesus: Você é mestre em Israel e não entende essas coisas? ...Eu lhes falei de coisas terrenas e vocês não creram; como crerão se lhes falar de coisas celestiais? Ninguém jamais subiu ao céu, a não ser aquele que veio do céu: o Filho do homem. Jesus é o filho do homem, ele estava falando dele mesmo. Ele veio do céu. Da mesma forma como Moisés levantou a serpente no deserto, assim também é necessário que o Filho do homem seja levantado, para que todo o que nele crer tenha a vida eterna. João 3:1-15 "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Então, se cremos em Jesus, continuamos mortos ou temos a vida? Ele pagou o preço da condenação. Ele comprou nossa vida!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Soltando as cordas:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Obrigado Deus por ter mandado Jesus, nos ajude a reconhecermos que estamos condenados por causa das coisas erradas que fazemos e a pedir perdão a Jesus e crer que Ele morreu em nosso lugar para termos a vida eterna."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 2"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Pois o salário do pecado é a morte, mas o dom gratuito de Deus é a vida eterna em Cristo Jesus, nosso Senhor. Romanos 6:23"), 0, 'J');
$pdf->Ln(200);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 2 - O Arco Colorido e a Flecha invisível"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que arco é esse?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem fez o arco?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que ele representa?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que flecha é essa?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual a cor da flecha?"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $nome_usuario, 0, 1, 'J');

// Página 6	
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 05"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("5. A MULHER SAMARITANA"), 0, 1, 'L');

$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Preparação:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Quem sabe o que é um cartão de crédito? Onde você consegue? Como é usado? Se você pagar algo com cartão de crédito, quem está pagando na hora? E depois, quem paga? E se você não tiver dinheiro? Você fica com uma dívida! E ela vai diminuir ou crescer? E o que acontece com pessoas que não pagam suas dívidas? O banco toma todas as suas coisas e se não der para pagar, elas são condenadas e presas! Você sabia que todos nós temos uma dívida? Só que não é com cartão de crédito, é uma dívida que ninguém aqui na terra consegue pagar!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Plano de Voo:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig. 5.1) Um dia Jesus estava cansado e sentou-se perto de um poço. Nisso veio uma mulher samaritana tirar água. Disse-lhe Jesus: Dê-me um pouco de água. (fig. 5.2) A mulher samaritana lhe perguntou: Como o senhor, sendo judeu, pede a mim, uma samaritana, água para beber? "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("( Pois os judeus não se dão bem com os samaritanos. ) Os Judeus se achavam melhor que os Samaritanos. Isso é pecado, achar-se melhor do que os outros? Os Samaritanos não acreditavam no Deus verdadeiro. Isso é	pecado? Então todos tinham pecado? Tanto os judeus como a mulher? Vamos continuar:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Jesus lhe respondeu: Se você conhecesse o dom de Deus e quem lhe está pedindo água, você lhe teria pedido e ele lhe teria dado água viva. Disse a mulher: O senhor não tem com que tirar a água, e o poço é fundo. Onde pode conseguir essa água viva? Que água é essa? ...Jesus respondeu: Quem beber desta água terá sede outra vez, mas quem beber da água que eu lhe der nunca mais terá sede. Pelo contrário, a água que eu lhe der se tornará nele uma fonte de água a jorrar para a vida eterna. (fig. 5.3) A mulher lhe disse: Senhor, dê-me dessa água, para que eu não tenha mais sede, nem precise voltar aqui para tirar água."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("A Mulher pensava que Jesus estava falando da água do poço, mas Jesus falava de algo que podia preencher sua vida não seu estômago. Jesus então perguntou sobre o marido da mulher e a mulher disse que não tinha. Jesus disse que ela vivia com um homem que não era seu marido. A mulher então reconheceu que Jesus era diferente porque ele sabia de seus pecados escondidos. A Mulher já tinha tido vários homens porque ela nunca estava satisfeita. O pecado faz o homem ficar assim, insatisfeito, querendo sempre mais."), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Disse a mulher: Eu sei que o Messias ( chamado Cristo ) está para vir. Quando ele vier, explicará tudo para nós. Então Jesus declarou: Eu sou o Messias! Eu, que estou falando com você. Naquele momento os seus discípulos voltaram e ficaram surpresos ao encontrá-lo conversando com uma mulher. Mas ninguém perguntou: Que queres saber? ou: Por que estás conversando com ela? (fig. 5.4) Então, deixando o seu cântaro, a mulher voltou à cidade e disse ao povo: Venham ver um homem que me disse tudo o que tenho feito. Será que ele não é o Cristo? João 4:7-29 "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("A Samaritana havia finalmente encontrado aquele que pode nos deixar satisfeitos e felizes, Jesus. Porque Ele é o único que pode nos dar a vida eterna. Ele nos deu sua própria vida, morreu em nosso lugar para termos Deus novamente preenchendo nossos corações!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Soltando as cordas:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Obrigado Deus porque Jesus deu a sua vida para que nós tivéssemos os nossos pecados perdoados. Ele morreu em nosso lugar!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 3"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Pois também Cristo sofreu pelos pecados uma vez por todas, o justo pelos injustos, para conduzir-nos a Deus. 1 Pedro 3:18"), 0, 'J');
$pdf->Ln(100);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 3 - O alvo do Mundo"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que alvo é esse?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem deveria ser o alvo?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Porque ele tinha que ser acertado?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que representa a cor vermelha?"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);		    
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $nome_usuario, 0, 1, 'J');

// Página 7
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 06"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("6. JESUS É TRAÍDO"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Preparação:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Quem gostaria de ser meu fantoche? (Pegue no braço de uma criança e diga que cada vez que você apertar o braço, ela deve abrir a boca. Fale algumas coisas engraçadas como Gente, eu me esqueci de escovar os dentes hoje! Meu pé está com chulé! Eu gosto de falar muito! Depois pergunte a criança se ela gostou de ser manipulada por outra pessoa? Como ela se sentiu) E ai crianças será que é bom ser manipulado, fazer somente o que outra pessoa quer, mesmo que isso seja errado? (Agora, pergunte à criança que estava sendo manipulada se ela poderia não abrir a boca e parar a brincadeira). Vocês acham que ela poderia parar? Sim, ela estava me deixando fazer o que quisesse com ela. A Bíblia nos conta de alguém que, ao contrário de Jesus, se deixou manipular pelo inimigo de Deus."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Plano de Voo:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz: (fig. 6.1) (fig. 6.1) Jesus tinha 9 discípulos. Um dos 9 se chamava Judas e ele é quem cuidava do dinheiro do grupo, para que pudessem comer, pagar hospedagem... Um dia uma mulher derramou sobre os pés de Jesus um perfume muito caro. Ele reclamou e Jesus o repreendeu dizendo que ela estava fazendo seu melhor para Deus. Talvez Judas começou a achar que Jesus estava desperdiçando dinheiro. Talvez ficou chateado com Jesus. O que vocês acham? Se Ele acreditasse mesmo que Jesus era Deus, teria ficado chateado? Mas ele não só ficou chateado, escutem o que ele fez: Então, um dos Doze, chamado Judas Iscariotes, dirigiu-se aos chefes dos sacerdotes e lhes perguntou: "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O que me darão se eu o entregar a vocês? E eles lhe fixaram o preço: trinta moedas de prata. Desse momento em diante Judas passou a procurar uma oportunidade para entregá-lo. Mateus 26:14-16"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O que estava acontecendo com Judas? Parece que ele gostava demais de dinheiro! E sabe crianças, quando satanás sabe que gostamos demais de uma coisa é ai que ele nos ataca e nos tenta a fazer a vontade dele. Talvez ele pensou que iria ficar rico seguindo a Jesus. O que vocês acham? E ai agora ele vende Jesus! Quem estava no comando na vida de Judas? Ele? Deus ou o amor ao dinheiro que é pecado?"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig. 6.1) Ao anoitecer, Jesus estava reclinado à mesa com os Doze. E, enquanto estavam comendo, ele disse: Digo-lhes que certamente um de vocês me trairá. Eles ficaram muito tristes e começaram a dizer-lhe, um após outro: Com certeza não sou eu, Senhor! Afirmou Jesus: Aquele que comeu comigo do mesmo prato há de me trair. O Filho do homem vai, como está escrito a seu respeito. Mas ai daquele que trai o Filho do homem! Melhor lhe seria não haver nascido. Então, Judas, que haveria de traí-lo, disse: Com certeza não sou eu, Mestre!  Jesus afirmou: Sim, é você. Mateus 26:20-25 E Judas se retirou."), 0, 'J');

$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.6.2) Então Jesus foi com seus discípulos para um lugar chamado Getsêmani e disse-lhes: Sentem-se aqui enquanto vou ali orar. Levando consigo Pedro e os dois filhos de Zebedeu, começou a entristecer-se e a angustiar-se. Disse-lhes então: A minha alma está profundamente triste, numa tristeza mortal. Fiquem aqui e vigiem comigo. (fig. 6.3) Indo um pouco mais adiante, prostrou-se com o rosto em terra e orou: Meu Pai, se for possível, afasta de mim este cálice; contudo, não seja como eu quero, mas sim como tu queres. Mateus 26:36-39"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Jesus estava sofrendo porque sabia que iria morrer mas o pecado não tinha domínio sobre ele. Por 3 vezes Jesus acordou os discípulos para que orassem com ele. Mas eles amavam mais o sono e eles deixaram que o sono os dominasse, até que... Jesus fala:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Levantem-se e vamos! Aí vem aquele que me trai!Enquanto ele ainda falava, chegou Judas, um dos Doze. Com ele estava uma grande multidão armada de espadas e varas, enviada pelos chefes dos sacerdotes e líderes religiosos do povo. (fig. 6.4) O traidor havia combinado um sinal com eles, dizendo-lhes: Aquele a quem eu saudar com um beijo, é ele; prendam-no. Dirigindo-se imediatamente a Jesus, Judas disse: Salve, Mestre! , e o beijou. Jesus perguntou: Amigo, que é que o traz?  Então os homens se aproximaram, agarraram Jesus e o prenderam. Mateus 26:46-50"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("A Bíblia diz que, depois Judas viu o que havia feito e que havia deixado se manipular pelo pecado, ele ficou tão desesperado que desistiu de sua própria vida. É isso que o pecado faz crianças, ele só quer nos destruir. Se você ama o dinheiro, satanás vai mandar alguém para lhe propor fazer algo errado. Se você ama sua aparência demais, talvez vai aparecer alguém que vai lhe pagar para você tirar sua roupa e ser admirado por todos. Satanás só quer destruir você. Mas Jesus veio para quê? Por que Ele derramou Seu sangue na cruz?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Soltando as cordas:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus nos ajude a entregarmos nossas vidas a Deus pedindo perdão de nossos pecados e tendo uma vida nova com Cristo."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 3"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Pois também Cristo sofreu pelos pecados uma vez por todas, o justo pelos injustos, para conduzir-nos a Deus. 1 Pedro 3:18"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 3 - O alvo do Mundo"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que alvo é esse?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem deveria ser o alvo?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Porque ele tinha que ser acertado?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que representa a cor vermelha?"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $nome_usuario, 0, 1, 'J');

// Página 8
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 07"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("7. JESUS É JULGADO"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Preparação:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(Leve um ovo para a classe) Quem gosta de comer ovos? De onde eles vêm? Você sabe imitar uma galinha? Agora vamos imitar um galo! Você sabia que a Bíblia fala de um galo que ensinou uma grande lição?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Plano de Voo:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz: Antes de Jesus ser preso ele havia dito que os discípulos o abandonariam e Pedro disse que nunca faria tal coisa. Pedro deixou que seu orgulho fosse contra o que Jesus estava dizendo e Jesus lhe disse que naquela noite ele o negaria 3 vezes antes do galo cantar. Jesus foi ao jardim orar e lá foi preso, como já vimos no último encontro. Ok crianças, se você ouvir algo sobre Pedro negar Jesus você vai levantar seus dedos mostrando quantas vezes isso acontece. A Bíblia conta então que: (fig. 7.1)"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Pedro o seguiu de longe até o pátio do sumo sacerdote, entrou e sentou-se com os guardas, para ver o que aconteceria. Pedro estava sentado no pátio, e uma criada, aproximando-se dele, disse: Você também estava com Jesus, o galileu. Mas ele o negou diante de todos, dizendo: Não sei do que você está falando. Depois, saiu em direção à porta, onde outra criada o viu e disse aos que estavam ali: Este homem estava com Jesus, o Nazareno. E ele, jurando, o negou outra vez: Não conheço esse homem!  Pouco tempo depois, os que estavam por ali chegaram a Pedro e disseram: Certamente você é um deles! O seu modo de falar o denuncia. Aí ele começou a se amaldiçoar e a jurar: Não conheço esse homem! Imediatamente um galo cantou. (fig. 7.2) Então Pedro se lembrou da palavra que Jesus tinha dito: Antes que o galo cante, você me negará três vezes. E, saindo dali, chorou amargamente. Mateus 26:58, 69-75"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Quantas vezes Pedro negou a Jesus? E porque ele fez isso? Medo! Seu orgulho tinha feito ele ignorar a aviso de Jesus e ele não se preparou para não ter medo. Jesus orou se preparando, Pedro dormiu. Jesus já sabia e avisou, mas ele não quis ouvir. Quando damos lugar ao pecado ele nos faz surdos e cegos para ver o que Deus quer. Você tem pecado? O que o pecado tem feito em sua vida? Olha o que o pecado fez na vida dos religiosos que diziam conhecer a palavra."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Os que prenderam Jesus o levaram a Caifás, o sumo sacerdote, em cuja casa se haviam reunido os mestres da lei e os líderes religiosos.... Os chefes dos sacerdotes e todo o Sinédrio estavam procurando um depoimento falso contra Jesus, para que pudessem condená-lo à morte. Mas nada encontraram Mateus 26:57-60 Procuravam o que? O coração deles estava cheio de que? Inveja, orgulho porque as pessoas acreditavam em Jesus! Jesus disse a eles que era o filho de Deus e eles ficaram com mais raiva e disseram que estava mentindo. (fig. 7.4) De manhã cedo, todos os chefes dos sacerdotes e líderes religiosos do povo tomaram a decisão de condenar Jesus à morte. E, amarrando-o, levaram-no e o entregaram a Pilatos, o governador. Mateus 27:1,2 Pilatos conversou com Jesus e não viu nenhuma culpa nele mas a multidão que os religiosos tinham convocado gritava pedindo que o condenassem. Porém, a esposa de Pilatos avisou que ele não se metesse com Jesus pois ele era inocente. Então, depois de pensar, Pilatos tomou uma decisão."), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig. 7.3) Por ocasião da festa era costume do governador soltar um prisioneiro escolhido pela multidão. Eles tinham, naquela ocasião, um prisioneiro muito conhecido, chamado Barrabás. Pilatos perguntou à multidão que ali se havia reunido: Qual destes vocês querem que lhes solte: Barrabás ou Jesus, chamado Cristo? Mateus 27:15-17 ... Responderam eles: Barrabás!  Perguntou Pilatos: Que farei então com Jesus, chamado Cristo?  Todos responderam: Crucifica-o!  Por quê? Que crime ele cometeu?, perguntou Pilatos. Mas eles gritavam ainda mais: Crucifica-o! Quando Pilatos percebeu que não estava obtendo nenhum resultado, mas, pelo contrário, es-tava se iniciando um tumulto, mandou trazer água, lavou as mãos diante da multidão e disse: Estou inocente do sangue deste homem; a responsabilidade é de vocês. Todo o povo respondeu: Que o sangue dele caia sobre nós e sobre nossos filhos! Então Pilatos soltou-lhes Barrabás, mandou açoitar Jesus e o entregou para ser crucificado. Mateus 27:21-26 "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O que havia no coração daquelas pessoas? O que você tem em seu coração? Que coisas você tem feito que sabe que não agradam a Deus? E o que você e eu merecemos por causa de nosso pecado. Quando desobedecemos a mãe, nosso pecado é de rebeldia contra Deus que nos deu nossa mãe para cuidar de nós, quando agarramos as meninas, nosso pecado é contra elas e contra Deus que as criou e contra nossos corpos. Nosso pecado vai ser sempre rebeldia contra Deus. Mas Jesus veio fazer o que? Ele veio para por um fim no domínio que o pecado tem nas nossas vidas. Quando ele morreu ele venceu o pecado porque foi obediente até o fim. Ele pagou o preço por você para que você pudesse ter seu coração limpo? Você acredita nisso?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Soltando as cordas:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus eu te agradeço porque Jesus pagou o preço do meu pecado diante de Deus, Ele foi obediente até o fim, nos ajude a sermos obedientes e a amá-lo como Ele nos amou."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 4 -"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Fui crucificado com Cristo. Assim, já não sou eu quem vive, mas Cristo vive em mim. Gálatas 2:20"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 4 - O Fim é o Começo"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que fim é esse?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Porque o fim foi o começo?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Começo de quê?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem pode ter esse começo?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que cor é o começo?"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $nome_usuario, 0, 1, 'J');

// Página 9
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 08"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("8. JESUS É CRUCIFICADO."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Preparação:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(Leve feijões e copinhos com algodão e agua) Hoje nós vamos plantar! Vamos plantar feijão! Quem sabe plantar feijão? Você pode colocá-lo na terra ou assim, como vamos fazer. Vamos pegar o copo, colocar o feijão no meio do algodão, colocar no copo e molhar aos poucos. Vamos fazer? (ajude as crianças a plantar) Você sabe o que vai acontecer com o feijão? Ele vai quebrar e abrir e de dentro vai sair uma plantinha, se ele não quebrar e abrir ele vai estragar sozinho, se ele abrir vai produzir. A Bíblia nos fala de alguém que foi ferido para que a vida pudesse acontecer. (guarde os copos e cuide deles com sol e agua se necessário, para o próximo encontro)"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Plano de Voo:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz:"), 0, 'J');

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Lembram que Jesus foi julgado e condenado? (fig.8.1) Cuspiram nele e, tirando-lhe a vara, batiam-lhe com ela na cabeça. Depois de terem zombado dele, tiraram-lhe o manto e vestiram-lhe suas próprias roupas. Então o levaram para crucificá-lo. Ao saírem, encontraram um homem de Cirene, chamado Simão, e o forçaram a carregar a cruz. Chegaram a um lugar chamado Gólgota, que quer dizer Lugar da Caveira... . Depois de o crucificarem, dividiram as roupas dele, tirando sortes. E, sentando-se, vigiavam-no ali. Por cima de sua cabeça colocaram por escrito a acusação feita contra ele: ESTE É JESUS, O REI DOS JUDEUS. Dois ladrões foram crucificados com ele, um à sua direita e outro à sua esquerda. Os que passavam lançavam-lhe insultos, balançando a cabeça e dizendo: Você que destrói o templo e o reedifica em três dias, salve-se! Desça da cruz, se é Filho de Deus! Da mesma forma, os chefes dos sacerdotes, os mestres da lei e os líderes religiosos zombavam dele, dizendo:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Salvou os outros, mas não é capaz de salvar a si mesmo! E é o rei de Israel! Desça agora da cruz, e creremos nele. Ele confiou em Deus. Que Deus o salve agora, se dele tem compaixão, pois disse: ‘Sou o Filho de Deus! Mateus 27:27-42 (fig.8.2) Um dos criminosos que ali estavam dependurados o insultava: Você não é o Cristo? Salve-se a si mesmo e a nós!  Mas o outro criminoso o repreendeu, dizendo: Você não teme a Deus, nem estando sob a mesma sentença? Nós estamos sendo punidos com justiça, porque estamos recebendo o que os nossos atos me-recem. Mas este homem não cometeu nenhum mal. Então ele disse: Jesus, lembra-te de mim quando entrares no teu Reino. Jesus lhe respondeu: Eu lhe garanto: Hoje você estará comigo no paraíso. Lucas 23:39-43 (fig.8.3) E houve escuridão sobre toda a terra, do meio dia às três horas da tarde. Por volta das três horas da tarde, Jesus bradou em alta voz: ... Meu Deus! Meu Deus! Por que me abandonaste? Mateus 27:46"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mais tarde, sabendo então que tudo estava concluído, para que a Escritura se cumprisse, Je-sus disse: Tenho sede. Estava ali uma vasilha cheia de vinagre. Então molharam uma esponja nela, colocaram a esponja na ponta de uma vara e a ergueram até os lábios de Jesus. Tendo-o provado, Jesus disse: Está consumado! Com isso, curvou a cabeça e entregou o espírito. João 19:28-30 Jesus morreu! Como a semente, Ele precisou morrer! Seu corpo foi furado, nas mãos e nos pés para que pudéssemos ter vida! Naquele momento, o véu do santuário rasgou-se em duas partes, de alto a baixo. A terra tremeu, e as rochas se partiram.... (fig.8.4) Quando o centurião e os que com ele vigiavam Jesus viram o terremoto e tudo o que havia acontecido, ficaram aterrorizados e exclamaram: Verdadeiramente este era o Filho de Deus! Mateus 27:51-54. Você crê que Jesus é o filho de Deus? E que Ele morreu por você, para pagar seus pecados? Então você pode ter uma vida nova! Limpa diante de Deus. Um novo começo!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Soltando as cordas:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Obrigado Deus porque o Senhor pode fazer o nosso coração mais branco do que qualquer coisa."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 4 -"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Fui crucificado com Cristo. Assim, já não sou eu quem vive, mas Cristo vive em mim. Gálatas 2:20"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 4 - O Fim é o Começo"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que fim é esse?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Porque o fim foi o começo?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Começo de quê?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem pode ter esse começo?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que cor é o começo?"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $nome_usuario, 0, 1, 'J');

// Página 9
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 09"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("9. JESUS RESSUSCITA"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Preparação:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(Traga os copos de volta e analise com as crianças) Vamos ver se todos abriram? (Pegue um aberto e tente mostrar como ele abriu) Olhem como ele quebrou e abriu, se ele não tivesse quebrado, tivesse ficado duro, não iria prestar, ia ficar podre. Mas ele morreu e quebrou e dele saiu uma nova vida. Jesus também foi assim! Ele morreu para nos dar vida! Mas ele ficou morto?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Plano de Voo:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz: (fig. 9.1)"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("fig. 9.1) Depois que Jesus morreu, alguns amigos de Jesus pediram seu corpo a Pilatos. José tomou o corpo, envolveu-o num limpo lençol de linho e o colocou num sepulcro novo, que ele havia mandado cavar na rocha. E, fazendo rolar uma grande pedra sobre a entrada do sepulcro, retirou-se."), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("...No outro dia, ...os chefes dos sacerdotes e os fariseus dirigiram-se a Pilatos e disseram: Senhor, lembramos que, enquanto ainda estava vivo, aquele impostor disse: ‘Depois de três dias ressuscitarei’. Ordena, pois, que o sepulcro dele seja guardado até o terceiro dia, para que não venham seus discípulos e, roubando o corpo, digam ao povo que ele ressuscitou dentre os mortos. ... Levem um grupo de guardas, respondeu Pilatos. Podem ir, e mantenham o sepulcro em segurança como acharem melhor. Eles foram e armaram um esquema de segurança no sepulcro; e além de deixarem um grupo de guardas montando guarda, lacraram a pedra. Mateus 27:58-66"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Será que Jesus vai ressuscitar? Mas quem poderia tirar a pedra? (fig.9.2) Depois do sábado, tendo começado o primeiro dia da semana, Maria Madalena e a outra Maria foram ver o sepulcro. E eis que aconteceu um grande terremoto, pois um anjo do Senhor desceu do céu e, chegando ao sepulcro, rolou a pedra da entrada e assentou-se sobre ela. Sua aparência era como um relâmpago, e suas roupas eram brancas como a neve. Os guardas tremeram de medo e ficaram como mortos. (fig.9.3) O anjo disse às mulheres: "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Não tenham medo! Sei que vocês estão procurando Jesus, que foi crucificado. Ele não está aqui; ressuscitou, como tinha dito. Venham ver o lugar onde ele estava. Elas entraram e viram o túmulo vazio. Vão depressa e digam aos discípulos dele: ‘Ele ressuscitou dentre os mortos e está indo adiante de vocês para a Galiléia. Lá vocês o verão’. Notem que eu já os avisei. As mulheres saíram depressa do sepulcro, amedrontadas e cheias de alegria, e foram correndo anunciá-lo aos discípulos de Jesus. (fig.9.4) De repente, Jesus as encontrou e disse: Salve!  Elas se aproximaram dele, abraçaram-lhe os pés e o adoraram. Então Jesus lhes disse: Não tenham medo. Vão dizer a meus irmãos que se dirijam para a Galiléia; lá eles me verão. Mateus 28:1-10"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Quando voltaram do sepulcro, elas contaram todas estas coisas aos Onze e a todos os outros. As que contaram estas coisas aos apóstolos foram Maria Madalena, Joana e Maria, mãe de Tiago, e as outras que estavam com elas. Mas eles não acreditaram nas mulheres; as palavras delas pareciam loucura."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Pedro, todavia, levantou-se e correu ao sepulcro. Abaixando-se, viu as faixas de linho e mais nada; afastou-se, e voltou admirado com o que acontecera. Lucas 24:9-9 Jesus ressuscitou? Mas como pode alguém ressuscitar da morte? Lembram que Jesus não tinha pecado? Na hora que ele estava na cruz a condenação de nosso pecado estava sobre ele e ele morreu. Mas ele venceu a morte porque ficou sem pecado até o fim, Ele é Deus! Sofreu só porque ama a você! Como o feijão que se quebrou para dar uma nova vida. E porque Ele ressuscitou nós podemos ter a vida que ele tem, a vida eterna junto com Deus. Vocês acreditam que quando creem em Jesus Deus lhes dá uma vida nova? Que coisas você quer mudar nessa nova vida? Você está disposto a ser como o feijão e falar não para quem você era e ter uma vida nova?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Soltando as cordas:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Obrigado Jesus porque o Senhor ressuscitou para me dar uma nova vida!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 5 -"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Portanto, se alguém está em Cristo, é nova criação. As coisas antigas já passaram; eis que surgiram coisas novas! 2 Coríntios 5:17"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 5 - O começo sem fim"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que representa o verde?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Porque o começo é sem fim?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como vai ser o sem fim e que cor terá?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como começar bem?"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $nome_usuario, 0, 1, 'J');

// Página 9
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 10"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("10. JESUS SOBE AOS CÉUS"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Preparação:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Hoje é nossa última lição do módulo do Arco. Depois de aprender sobre a vida de Jesus, o que você diria as pessoas ao seu redor? Que conselhos ou recados? Vamos fazer cartazes com frases, cada um faz o seu! Jesus também deixou algo para fazermos. O que será que Ele disse?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Plano de Voo:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz: Jesus ressuscitou, que alegria! Mas onde Ele estava? (fig.10.1) Um dia ... dois deles estavam indo para um povoado chamado Emaús, a onze quilômetros de Jerusalém. No caminho, conversavam a respeito de tudo o que havia acontecido. Enquanto conversavam e discutiam, o próprio Jesus se aproximou e começou a caminhar com eles; mas os olhos deles foram impedidos de reconhecê-lo. Ele lhes perguntou: Sobre o que vocês estão discutindo enquanto caminham?  Eles pararam, com os rostos entristecidos. Um deles, chamado Cleopas, perguntou-lhe: Você é o único visitante em Jerusalém que não sabe das coisas que ali aconteceram nestes dias?  Que coisas? , perguntou ele. O que aconteceu com Jesus de Nazaré, responderam eles. Ele era um profeta, poderoso em palavras e em obras diante de Deus e de todo o povo."), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Os chefes dos sacerdotes e as nossas autoridades o entregaram para ser condenado à morte, e o cruci-ficaram; e nós esperávamos que era ele que ia trazer a redenção a Israel. E hoje é o terceiro dia desde que tudo isso aconteceu."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Algumas das mulheres entre nós nos deram um susto hoje. Foram de manhã bem cedo ao sepulcro e não acharam o corpo dele. Voltaram e nos contaram que tinham tido uma visão de anjos, que disseram que ele está vivo. Alguns dos nossos companheiros foram ao sepulcro e encontraram tudo exatamente como as mulheres tinham dito, mas não o viram."), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Ele lhes disse: Como vocês custam a entender e como demoram a crer em tudo o que os profetas falaram! Não devia o Cristo sofrer estas coisas, para entrar na sua glória?  E começando por Moisés e todos os profetas, explicou-lhes o que constava a respeito dele em todas as Escrituras."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vocês lembram as promessas a respeito de Jesus que conhecemos no Mergulho, Jesus falou para seus discípulos dessas promes-sas e que elas haviam se cumprido. Eles convidaram Jesus para ir comer com eles. Quando estava à mesa com eles, tomou o pão, deu graças, partiu-o e o deu a eles. Então os olhos deles foram abertos e o reconheceram, e ele desapareceu da vista deles. Uau! Jesus apareceu e desapareceu, quem pode fazer? Só Deus pode! ...Levantaram-se, voltaram imediatamente para Jerusalém. Ali encontraram os Onze e os que estavam com eles reunidos, que diziam: É verdade! O Senhor ressuscitou e apareceu a Simão! Lucas 24:13-34 (fig.10.2) Enquanto falavam sobre isso, o próprio Jesus apresentou-se e	ntre eles e lhes disse: Paz seja com vocês!"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Eles ficaram assustados e com medo, pensando que estavam vendo um espírito. Ele lhes disse: Por que vocês estão perturbados e por que se levantam dúvidas em seus corações? Vejam as minhas mãos e os meus pés. Sou eu mesmo! Toquem-me e vejam; um espírito não tem carne nem ossos, como vocês estão vendo que eu tenho. Tendo dito isso, mostrou-lhes as mãos e os pés. E por não crerem ainda, tão cheios estavam de alegria e de espanto, ele lhes perguntou: Vocês têm aqui algo para comer?  Deram-lhe um pedaço de peixe assado, e ele o comeu na presença deles. Lucas 24:36-48"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Tomé, um dos discípulos, pediu para colocar o dedo nas feridas de Jesus e Ele deixou, mas disse Bem aventurados os que não viram e creram Lembra o que é fé? Fé é crer sem ver, é confiar totalmente! Você tem fé que Jesus veio derramar Seu sangue para que seus pecados sejam perdoados? Você quer agora pedir perdão a Jesus e entregar sua vida a Ele, para que Ele lhe dê a vida eterna? Você pode orar e falar isso agora para Deus! Jesus levou os discípulos perto de uma cidade chamada Betânia e disse: Mas receberão poder quando o Espírito Santo descer sobre vocês, e serão minhas testemunhas em Jerusalém, em toda a Judéia e Samaria, e até os confins da terra."), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.10.3) Tendo dito isso, foi elevado às alturas enquanto eles olhavam, e uma nuvem o encobriu da vista deles. E eles ficaram com os olhos fixos no céu enquanto ele subia. De repente surgiram diante deles dois homens vestidos de branco, que lhes disseram: Galileus, por que vocês estão olhando para o céu? Este mesmo Jesus, que dentre vocês foi elevado ao céu, voltará da mesma forma como o viram subir. Atos 1:3-11 (fig.10.4) A partir daquele dia os discípulos começaram a falar do amor de Jesus para outros."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Para onde Jesus foi? A Bíblia nos diz que Ele está sentado ao lado de Deus e está nos preparando uma cidade onde as ruas são de ouro onde viveremos com ele para sempre, mas enquanto não vamos o que Deus quer que sejamos? Testemunhas. De que? Testemunhas de que existe um Deus vivo e que ele pode dar um novo começo em nossas vidas quando nascemos na família de Deus."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Soltando as cordas:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus nos ajude a sermos testemunhas do amor de Deus e do que Cristo fez por nós!"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 5 -"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Portanto, se alguém está em Cristo, é nova criação. As coisas antigas já passaram; eis que surgiram coisas novas! 2 Coríntios 5:17"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 5 - O começo sem fim"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que representa o verde?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Porque o começo é sem fim?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como vai ser o sem fim e que cor terá?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como começar bem?"), 0, 'J');

$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $nome_usuario, 0, 1, 'J');

$pdf->AddPage();

$pdf->Ln(8);
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 5, $pdf->textoUTF8("Respostas de Mistérios - Arco"), 0, 1, 'C');
$pdf->Ln(8);
$pdf->Cell(0, 5, "", "B", 1, 'C');
$pdf->Ln(8);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

// 01
$pdf->Ln(10);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 1 - O Dono do Azul"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que reporesenta a cor azul? - O céu que Deus fez"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é o dono do azul? - Deus, o criador"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que Ele sente por nós? - Ele nos ama"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Nós merecemos? - Não, somos pecadores"), 0, 'J');

// 02
$pdf->Ln(10);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 2 - O Arco Colorido e a Flecha invisível"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que arco é esse? - O arco colorido que vemos no céu"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem fez o arco? - Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que ele representa? - Deus não destruiria a terra por causa do pecado"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que flecha é essa? - A condenação do pecado"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual a cor da flecha? - Escura"), 0, 'J');

// 03
$pdf->Ln(10);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 3 - O alvo do Mundo"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que alvo é esse? - Jesus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem deveria ser o alvo? - Nós"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Porque ele tinha que ser acertado? - Para que pagasse nossa condenação"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que representa a cor vermelha? - O sangue de Jesus"), 0, 'J');

// 04
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 4 - Os Fim é o Começo"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que fim é esse? - A morte de Jesus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Porque o fim fio o começo? - Porque Ele tinha que morrer para nos perdoar"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Começo de quê? - De uma vida nova livertos do pecado"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem pode ter esse começo? - Os que creem em Jesus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que cor é o começo? - Branca"), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 5 - O começo sem fim"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que representa o verde? - A nova vida em Jesus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Porque o começo é sem fim? - Porque ganhamos a vida eterna"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como vai ser o sem fim e que cor terá? - Ao lado de Deus, cor de ouro"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como começar bem? - Fazendo a vontade de Deus"), 0, 'J');

//Tópico
$pdf->ln(10);
$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $nome_usuario, 0, 1, 'J');

$nome_relatorio = $pdf->textoUTF8("Arco");
$pdf->Output("$nome_relatorio.pdf", "I");
