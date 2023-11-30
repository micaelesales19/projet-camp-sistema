<?php

$usuario = $_GET['id_lider'] ?? 0;
$id_modulo = $_GET['id_modulo'] ?? "1";

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
$consulta_pais_sql = "SELECT * FROM pais WHERE id LIKE :ID_USU";
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
//$pdf->Image('import/sistema/arquivos/capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(60, 10, $pdf->textoUTF8("Módulo:"), 0, 0, 'J');
$pdf->Cell(0, 10, $pdf->textoUTF8($modulo['nome_modulo']), 0, 1, 'J');
$pdf->Ln(8);

$pdf->Ln(300);
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 5, $pdf->textoUTF8("Máterial Trilha"), 0, 1, 'C');
$pdf->Ln(8);
$pdf->Cell(0, 5, "", "B", 1, 'C');

// Lição 1
$pdf->AddPage();
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 01"), 0, 0, 'C');
$pdf->Ln(10);
$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("1. DEUS EXISTE."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Aquecimento:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Você sabia que quando eu tinha a sua idade os celulares eram diferentes? (fig 1.1) A cada dia objetos novos são inventados, e você sabe quem os inventa? O que é um inventor? É uma pessoa que inventa coisas que nunca foram vistas antes. Pode me dizer o nome de algumas invenções? Como será que uma invenção é feita? Como esse celular foi feito? O que acham? Eu acho que precisa de um plano, um desenho, experiências, colocar as peças juntas. Você acha que precisa de alguém inteligente? E o que você acha do céu? Alguém fez? E a terra? Será que foi alguém? Como podemos saber?"), 0, 'J');
//Tópico

$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Mapa da trilha:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("No princípio Deus criou os céus e a terra. Gênesis 1:1 (fig.1.2)"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("A Bíblia começa dizendo que existe Deus. Mas quando ele foi criado? A Bíblia também nos diz:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Antes de nascerem os montes e de criares a terra e o mundo, de eternidade a eternidade tu és Deus. Salmos 90:2"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O que quer dizer de eternidade a eternidade? O que significa eterno? Algo que não tem princípio nem fim. Então, Deus sempre existiu! Muitas pessoas acham que Deus não existe, o que você acha? Como você acha que Deus é? Sem principio nem fim, como essa aliança. (fig 1.3) Ele é o princípio e o fim de todas as coisas! (fig. 1.4) (Diga às crianças quem é Deus para você)."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Fazendo as malas:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Vamos agradecer porque Deus existe e ele é mais poderoso do que qualquer coisa ou qualquer pessoa"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 1"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Antes de nascerem os montes e de criares a terra e o mundo, de eternidade a eternidade tu és Deus. Salmos 90:2 "), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 1 - A voz misteriosa."), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Na nossa trilha existe uma voz misteriosa, uma voz que sempre foi ouvida e ainda hoje é ouvida."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* De quem é a voz?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que ela diz?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Onde ela é ouvida?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem a obedece?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como ela é ouvida hoje?"), 0, 'J');
$pdf->ln(10);

$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');
// Lição 1

// Lição 2

$pdf->AddPage();

$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 02"), 0, 0, 'C');
$pdf->Ln(10);
$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("2. DEUS CRIOU OS CÉUS E A TERRA - O PRIMEIRO DIA ."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Aquecimento:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Se você fosse o criador de todas as coisas o quê você criaria primeiro? (Deixe que as crianças troquem ideias, dê as suas também.) Imagine que você vai criar um planeta, o que é mais importante? Vocês querem saber o que é mais importante? Querem saber o que Deus fez primeiro?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Mapa da trilha:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("No princípio Deus criou os céus e a terra. Gênesis 1:1"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Os céus! Vamos olhar lá fora. O que estão vendo? O céu é grande? Será que vemos tudo? Não. E eu acho que quando Deus criou o céu não se podia para enxergar nada. (fig. 2.1) Ele fez o nosso planeta, mas ainda não se podia enxergar. Sabe como eu sei disso? Fechem os olhos como se estivéssemos lá e escutem. (Leia bem pausadamente) (fig.2.2)"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Era a terra sem forma e vazia; trevas cobriam a face do abismo, e o Espírito de Deus se movia sobre a face das águas. (fig. 2.3) Disse Deus: “Haja luz”, e houve luz. Deus viu que a luz era boa, e separou a luz das trevas. Deus chamou à luz dia, e às trevas chamou noite. Passaram-se a tarde e a manhã; esse foi o primeiro dia. Gênesis 1:2-5 (fig. 2.4)"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Tudo era escuro, como alguém poderia enxergar? Você consegue enxergar no escuro? E Deus pode enxergar no escuro? Se Ele criou no escuro, então Ele pode! "), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E então,... Deus fez a luz! Como Ele fez a luz? Só falou? Será que dá para acender a luz falando? Algumas casas já tem controle remoto de voz, mas naquela época isso não existia. Era só o controle de Deus. Ele é o máximo! Depois de haver criado a terra Ele fez a luz. Porque a luz é tão importante assim? (Deixe que falem.) Então vamos agradecer pela luz!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Fazendo as malas:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração -  Deus nós te agradecemos por ter feito os céus, a terra e a luz para que todas as outras coisas pudessem existir e para podermos enxergar tudo que está ao nosso redor. "), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 1"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Antes de nascerem os montes e de criares a terra e o mundo, de eternidade a eternidade tu és Deus. Salmos 90:2"), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 1- A voz misteriosa - Alguém descobriu o mistério da voz?"), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* De quem é a voz?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que ela diz?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Onde ela é ouvida?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem a obedece?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como ela é ouvida hoje?"), 0, 'J');

$pdf->ln(10);

$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');
// Lição 2

// Lição 3

$pdf->AddPage();

$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 03"), 0, 0, 'C');

$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("3. O SEGUNDO E O TERCEIRO DIA "), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Aquecimento:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Você sabe como a chuva fica na nuvem sem cair? É a atmosfera. A pressão do ar evita que ela caia."), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(Encha uma vasilha com água. Pique uma folha de papel. Pegue um copo. Empurre todo o papel no fundo do copo. Coloque o copo de cabeça para baixo na tigela bem rápido até que a água o cubra.) "), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O que acontece com o papel? Continua no fundo do copo, mas não cai na água. Isso é a pressão da atmosfera. Ela segura o papel assim como ela segura a água no céu. A água não consegue chegar ao papel porque o ar está comprimido entre ela e o papel. Mas quem fez a atmosfera?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Mapa da trilha:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz: (fig. 3.1)"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8(" “Haja entre as águas um firmamento que separe águas de águas”. Então Deus fez o firmamento e separou as águas que estavam embaixo do firmamento das que estavam por cima. E assim foi. Ao firmamento Deus chamou céu. Passaram-se a tarde e a manhã; esse foi o segundo dia. (fig.3.2) E disse Deus: “Ajuntem-se num só lugar as águas que estão debaixo do céu, e apareça a parte seca”. E assim foi. À parte seca Deus chamou terra, e chamou mares ao conjunto das águas. E Deus viu que ficou bom. Gênesis 1:6-10 Um vapor, porém, subia da terra, e regava toda a face da terra. Gênesis 2:6 (fig.3.3) Então disse Deus: “Cubra-se a terra de vegetação: plantas que dêem sementes e árvores cujos frutos produzam sementes de acordo com as suas espécies”. (fig.3.4) E assim foi. A terra fez brotar a vegetação: plantas que dão sementes de acordo com as suas espécies, e árvores cujos frutos produzem sementes de acordo com as suas espécies. E Deus viu que ficou bom. Passaram-se a tarde e a manhã; esse foi o terceiro dia. Gênesis 1:6-13"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Deus fez nossa atmosfera, que é formada de um pouco de oxigênio, que respiramos, bastante nitrogênio, que é necessário à vida, e um pouco de dióxido de carbono que as plantas respiram. Depois de preparar o ambiente, Deus separou a terra das aguas e então fez as plantas. Podem dizer o nome de algumas plantas? Deus é o maior gênio que existe! O que você acha? "), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Fazendo as malas:"), 0, 1, 'L');

//Texto

$pdf->SetFont('arial', '', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus muito obrigado porque o Senhor fez tudo tão perfeito, não existe outro Deus como o Senhor! O Senhor é poderoso."), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 2"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Como é feliz aquele cujo auxílio é o Deus de Jacó, cuja esperança está no Senhor, no seu Deus, que fez os céus e a terra, o mar e tudo o que neles há, e que mantém a sua fidelidade para sempre! Salmos 146:5,6"), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 2 - A Capa Invisível"), 0, 'J');

$pdf->Ln(10);


$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que capa é essa?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que ela protege?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* De quê ela protege?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual é a nossa capa?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como ficar protegido?"), 0, 'J');

$pdf->ln(10);

$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');
// Lição 3

// Lição 4		

$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 04"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("4. O QUARTO DIA."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Aquecimento:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vocês sabem de que são feitos o sol e as estrelas? Eles são feitos de gases. Vou mostrar para vocês um tipo de gás. (Pegue meio copo de vinagre e coloque uma colher de chá de bicarbonato de sódio e deixe que as crianças observem.) Esse gás não queima, mas alguns tipos de gases queimam. O sol e as estrelas são bolas feitas de vários gases que estão queimando. Você sabe quem fez o sol, a lua e as estrelas?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Mapa da trilha:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Minhas próprias mãos estenderam os céus; eu dispus o seu exército de estrelas. Isaías 45:9"), 0, 'J');

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Disse Deus: (fig.4.1) “Haja luminares no firmamento do céu para separar o dia da noite. Sirvam eles de sinais para marcar estações, dias e anos, e sirvam de luminares no firmamento do céu para iluminar a terra”. E assim foi. O nosso calendário é solar, tudo é marcado pela posição do sol! (fig.4.2e 3) Deus fez os dois grandes luminares: o maior para governar o dia e o menor para governar a noite; fez também as estrelas. Deus os colocou no firmamento do céu para iluminar a terra, governar o dia e a noite, e separar a luz das trevas. E Deus viu que ficou bom. Passaram-se a tarde e a manhã; esse foi o quarto dia. Gênesis 1:14-19"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Quem fez o sol, a lua e as estrelas? Para que serve o sol? Só para iluminar? (Deixe que as crianças falem) O que fazemos quando é dia? E à noite? O sol nos ajuda a contar nossos dias e anos também. (fig.4.4) (Coloque um papel com um palito de churrasco enterrado bem no meio da folha, marque onde está a sombra.) Diga às crianças para fazerem isso em casa e marcarem todos os dias na mesma hora. Peça que observem as diferenças, é a terra se movendo. Que bom que Deus nos deu o Sol!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Fazendo as malas:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus, obrigado porque o Senhor nos deu o sol para nos aquecer e a lua tão bonita para iluminar nossas noites."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 2"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Como é feliz aquele cujo auxílio é o Deus de Jacó, cuja esperança está no Senhor, no seu Deus, que fez os céus e a terra, o mar e tudo o que neles há, e que mantém a sua fidelidade para sempre! Salmos 146:5,6"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 2 - A Capa Invisível"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Você já descobriu que capa é essa que tem na terra? Para que serve uma capa? Que capa nós temos?"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que capa é essa?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que ela protege?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* De quê ela protege?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual é a nossa capa?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como ficar protegido?"), 0, 'J');

$pdf->ln(10);

$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');
// Lição 4

// Lição 5
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 05"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("5. QUINTO E SEXTO DIAS."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Aquecimento:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Brinque de quem lembra mais nomes de animais e aves de A – Z. Tente preencher todas as letras. Você sabe quantas espécies de animais existem? Mais de 1 milhão de espécies de animais, aves e insetos. Mas, como surgiram?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Mapa da trilha:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz: "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E disse Deus: Produzam as águas abundantemente répteis de alma vivente; e voem as aves sobre a face da expansão dos céus. (fig.5.1) E Deus criou as grandes baleias, e todo o réptil de alma vivente que as águas abundantemente produziram conforme as suas espécies; e toda a ave de asas conforme a sua espécie; e viu Deus que era bom. E Deus os abençoou, dizendo: Frutificai e multiplicai-vos, e enchei as águas nos mares; e as aves se multipliquem na terra. E foi a tarde e a manhã, o dia quinto. E disse Deus: (fig.5.2,3) Produza a terra alma vivente conforme a sua espécie; gado, e répteis e feras da terra conforme a sua espécie; e assim foi. E fez Deus as feras da terra conforme a sua espécie, e o gado conforme a sua espécie, e todo o réptil da terra conforme a sua espécie; e viu Deus que era bom. Gênesis 1:20-25"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O que Deus fez no quinto dia? E no sexto? Deus fez todos os animais, do jeito que eles são. (fig.5.4) Deus fez peixes que tem sua própria lanterna, cangurus que tem sua própria bolsa, peixes que voam, aves que mergulham, répteis que mudam de cor, animais enormes e minúsculos. A natureza estava quase completa! Um paraíso! Deus fez também a natureza de maneira que uma espécie depende da outra para viver. Se matarmos uma espécie, estamos bagunçando o que Deus fez tão perfeito! O que você acha disto? Vamos agradecer por Deus ter feito tudo tão perfeito."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Fazendo as malas:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - – Senhor, te agradecemos pelos animais e pelas aves que deixam a natureza tão bonita e nos alimentam, nos ajude a cuidarmos bem de todas as tuas criaturas!"), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 3"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Criou Deus o homem à sua imagem, à imagem de Deus o criou; homem e mulher os criou. Gênesis 1:27"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 3 - A Polícia Verde"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é a polícia verde?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual o seu lema?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Para quem ela trabalha?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que ela faz?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como posso ser uma polícia verde?"), 0, 'J');

$pdf->ln(10);

$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');
// Lição 5

// Lição 6

$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 06"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("6. CRIAÇÃO DO HOMEM E DO JARDIM"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Aquecimento:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Você já viu os robôs que estão inventando? Eles andam, obedecem a comandos, dançam, jogam coisas, eles são uma obra-prima! Você sabe o que é uma obra prima? É a melhor obra de alguém. Você sabe qual foi a obra-prima de Deus?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Mapa da trilha:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz: "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.6.1) E disse Deus: Façamos o homem à nossa imagem, conforme a nossa semelhança; e domine sobre os peixes do mar, e sobre as aves dos céus, e sobre o gado, e sobre toda a terra, e sobre todo o réptil que se move sobre a terra. Gênesis 1:26"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("E formou o Senhor Deus o homem do pó da terra, e soprou em suas narinas o fôlego da vida; e o homem foi feito alma vivente. Gênesis 2:7 E criou Deus o homem à sua imagem; à imagem de Deus o criou; Gênesis 1:26"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.6.2) E plantou o Senhor Deus um jardim no Éden, do lado oriental; e pôs ali o homem que tinha formado. E o Senhor Deus fez brotar da terra toda a árvore agradável à vista, e boa para comida; (fig.6.3) e a árvore da vida no meio do jardim, e a árvore do conhecimento do bem e do mal. E saía um rio do Éden para regar o jardim; ... E tomou o Senhor Deus o homem, e o pôs no jardim do Éden para o lavrar e o guardar. Gênesis 2:8-15 (fig.6.4)"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("A obra-prima de Deus é o homem. Ele o fez com suas próprias mãos e soprou nele Sua vida. O homem é igual aos animais? No que eles são diferentes? Deus fez o homem de maneira especial. Deus fez você também? Vamos agradecer?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Fazendo as malas:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Senhor obrigado por ter nos feito de maneira tão especial, nos ajude a sermos, de novo, parecidos com o Senhor."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 3"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Criou Deus o homem à sua imagem, à imagem de Deus o criou; homem e mulher os criou. Gênesis 1:27"), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 3 - A Polícia Verde"), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é a polícia verde?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual o seu lema?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Para quem ela trabalha?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que ela faz?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como posso ser uma polícia verde?"), 0, 'J');

$pdf->ln(10);

$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');
// Lição 6

// Lição 7

$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 07"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("7. CRIAÇÃO DA MULHER."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Aquecimento:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(Recapitule tudo o que Deus fez). Deus fez tudo e todo dia Ele dizia que o que tinha feito era bom, mas depois que Deus criou o homem, Deus disse que algo não estava bom, o que será?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Mapa da trilha:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz: "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.7.1) E disse o Senhor Deus: Não é bom que o homem esteja só; far-lhe-ei uma ajudadora idônea (que combine, que seja boa para ele) para ele. Havendo, pois, o Senhor Deus formado da terra todo o animal do campo, e toda a ave dos céus, os trouxe a Adão, para este ver como lhes chamaria; e tudo o que Adão chamou a toda a alma vivente, isso foi o seu nome. E Adão pôs os nomes a todo o gado, e às aves dos céus, e a todo o animal do campo; mas para o homem não se achava ajudadora idônea. Então o Senhor Deus fez cair um sono pesado sobre Adão, e este adormeceu; e tomou uma das suas costelas, e cerrou a carne em seu lugar; (fig.7.2) E da costela que o Senhor Deus tomou do homem, formou uma mulher, e trouxe-a a Adão. (fig.7.3) E disse Adão: Esta é agora osso dos meus ossos, e carne da minha carne; esta será chamada mulher, porquanto do homem foi tomada. Portanto deixará o homem o seu pai e a sua mãe, e apegar-se-á à sua mulher, e serão ambos uma carne. E ambos estavam nus, o homem e a sua mulher; e não se envergonhavam. Gênesis 2:18-25"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.7.4) E Deus os abençoou, e Deus lhes disse: Frutificai e multiplicai-vos, e enchei a terra, e sujeitai-a; e dominai sobre os peixes do mar e sobre as aves dos céus, e sobre todo o animal que se move sobre a terra. E disse Deus: Eis que vos tenho dado toda a erva que dê semente, que está sobre a face de toda a terra; e toda a árvore, em que há fruto que dê semente, ser-vos-á para mantimento. E a todo o animal da terra, e a toda a ave dos céus, e a todo o réptil da terra, em que há alma vivente, toda a erva verde será para mantimento; e assim foi. E viu Deus tudo quanto tinha feito, e eis que era muito bom; e foi a tarde e a manhã, o dia sexto. Gênesis 1:28-31"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Deus percebeu que não seria bom para o homem ficar só. Ele fez a mulher imediatamente? O que ele esperou? Que Adão sentisse a necessidade. Deus conhece nossas verdadeiras necessidades? Ele pode supri-las? Quando? O que realmente estamos precisando? Vamos orar sobre isso?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Fazendo as malas:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus obrigado porque o Senhor sabe o que precisamos e o Senhor nos ajuda a perceber o que realmente precisamos. Ajude-nos também a esperar pelo tempo do Senhor, sabendo que vais suprir cada uma de nossas necessidades"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 4"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8(" Tudo tem o seu tempo determinado, e há tempo para todo o propósito debaixo do céu. Eclesiastes 3:1"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 4 - O relógio de Deus"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem tem esse relógio?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O tempo é igual ao nosso?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como ele funciona?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como sabemos a hora certa das coisas?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Podemos adiantar as horas nesse relógio?"), 0, 'J');

$pdf->ln(10);

$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');
// Lição 7

// Lição 8

$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 08"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("8. O SÉTIMO DIA."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Aquecimento:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.8.1) Vamos fazer uma agenda? Cada um faz uma lista de coisas que quer fazer durante o dia e, ao lado, quantas horas quer passar fazendo aquilo. O que vocês acharem que deve ser feito deve ser colocado na lista. Agora vamos dividir nas 24 horas do dia e observar se dá para fazer tudo. Está faltando algo? Não deu? Precisamos de tempo para dormir? Comer? Fazer tarefas? (Fale levando em consideração o que cada um gostaria de fazer, inclusive você). Será que conseguimos organizar melhor? Como Deus se organizou?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Mapa da trilha:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz: (fig.8.2,3)"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.8.2,3) E havendo Deus acabado no dia sétimo a obra que fizera, descansou no sétimo dia de toda a sua obra, que tinha feito. E abençoou Deus o dia sétimo, e o santificou; porque nele descansou de toda a sua obra que Deus criara e fizera. Gênesis 2:2-3 Porque em seis dias fez o Senhor os céus e a terra, o mar e tudo que neles há, e ao sétimo dia descansou; portanto abençoou o Senhor o dia do sábado, e o santificou. Êxodo 20:11"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Quantos dias Deus trabalhou? E no final da semana? Precisamos tempo de descanso? Em que outro tempo devemos descansar? Noites, férias, ... Devemos descansar de brincar? Para que serve o descanso? A Palavra diz que há tempo para tudo. Vamos ler: "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.8.4) Tudo tem o seu tempo determinado, e há tempo para todo o propósito debaixo do céu. Há tempo de nascer, e tempo de morrer; tempo de plantar, e tempo de arrancar o que se plantou; Tempo de matar, e tempo de curar; tempo de derrubar, e tempo de edificar; Tempo de chorar, e tempo de rir; tempo de prantear, e tempo de dançar; Tempo de espalhar pedras, e tempo de ajuntar pedras; tempo de abraçar, e tempo de afastar-se de abraçar; Tempo de buscar, e tempo de perder; tempo de guardar, e tempo de lançar fora; Tempo de rasgar, e tempo de coser; tempo de estar calado, e tempo de falar; Tempo de amar, e tempo de odiar; tempo de guerra, e tempo de paz. Eclesiastes 3:2-8"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Cada coisa tem seu tempo. Existem coisas mais importantes que outras? Que tal colocarmos na agenda o que é mais importante primeiro. Depois vamos colocando as outras e fazendo a seleção. Não esqueça o tempo com Deus! (Arrumem as agendas) Vamos falar com Deus!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Fazendo as malas:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Obrigado Deus por ter nos dado 24 horas por dia. Nos ajuda a sabermos usar bem o tempo que temos para fazermos o que é mais importante."), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 4"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Tudo tem o seu tempo determinado, e há tempo para todo o propósito debaixo do céu. Eclesiastes 3:1"), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 4 - O relógio de Deus"), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem tem esse relógio?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O tempo é igual ao nosso?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como ele funciona?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como sabemos a hora certa das coisas?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Podemos adiantar as horas nesse relógio?"), 0, 'J');

$pdf->ln(10);

$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');
// Lição 8

// Respostas dos mistérios

$pdf->AddPage();

$pdf->Ln(8);

$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 5, $pdf->textoUTF8("Respostas de Mistérios - Trilha"), 0, 1, 'C');
$pdf->Ln(8);

$pdf->Cell(0, 5, "", "B", 1, 'C');
$pdf->Ln(8);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

// 01
$pdf->Ln(10);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 1- A voz misteriosa"), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* De quem é a voz? - A voz de Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que ela diz? - A vontade de Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Onde ela é ouvida? - Em todo lugar"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem a obedece? - Quem ama a Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como ela é ouvida hoje? - A Palavra escrita, a Bíblia"), 0, 'J');

// 02

$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 2 - A Capa Invisível"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que capa é essa? - A atmosfera"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que ela protege? - O planeta terra, onde vivemos"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* De quê ela protege? - Do sol, dos asteroides, qualquer coisa"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual é a nossa capa? - A Palavra de Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como ficar protegido? - Memorizando a Palavra"), 0, 'J');

// 03

$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 3 - A Polícia Verde"), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é a polícia verde? - Nós somos a polícia verde"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Qual o seu lema? - Servir e proteger"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Para quem ela trabalha - Para Deus?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que ela faz? - Cuida da Tera que Deus criou"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como posso ser uma polícia verde? - "), 0, 'J');

// 04

$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 4 - O relógio de Deus"), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem tem esse relógio? - Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O tempo é igual ao nosso? - Não"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como ele funciona? - No tempo de Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como sabemos a hora certa das coisas? - Pela palavra"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Podemos adiantar as horas nesse relógio? - Não"), 0, 'J');

$pdf->ln(10);

$pdf->SetFont('arial', 'I', 8);
$pdf->Cell(0, 10, "Este material foi impresso pelo " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');

$nome_relatorio = $pdf->textoUTF8("Trilha");
$pdf->Output("$nome_relatorio.pdf", "I");