<?php

$usuario = $_GET['id_lider'] ?? 0;
$id_modulo = $_GET['id_modulo'] ?? "2";

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

$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(60, 10, $pdf->textoUTF8("Módulo:"), 0, 0, 'J');
$pdf->Cell(0, 10, $pdf->textoUTF8($modulo['nome_modulo']), 0, 1, 'J');
$pdf->Ln(8);

$pdf->Ln(300);
$pdf->SetFont('arial', 'B', 18);
$pdf->Cell(0, 5, $pdf->textoUTF8("Máterial Mergulho"), 0, 1, 'C');
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
$pdf->Cell(50, 10, $pdf->textoUTF8("1. A QUEDA DE LÚCIFER."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Embarcando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Deus nos diz para amar a todos, certo? Mas tem alguém de quem Deus quer que sejamos inimigos. Deus quer que fiquemos longe dele, e nunca façamos o que ele quer. Ele é o inimigo de Deus. Quem é esse? De onde ele veio?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Carta Náutica:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz sobre ele:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Você era o modelo de perfeição, cheio de sabedoria e de perfeita beleza. Ezequiel 28:12 (fig.1.1)"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Lúcifer morava com Deus no céu e era um querubim guardião. Qual você acha que era a tarefa de um querubim guardião? Era um tipo de anjo que guardava a santidade de Deus. Parece uma tarefa importante? Mas Lúcifer não ficou satisfeito com essa tarefa tão especial que ele tinha. Olha o que a Bíblia diz:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Seu coração tornou-se orgulhoso por causa da sua beleza, e você corrompeu a sua sabedoria por causa do seu esplendor. Ezequiel 28:17 "), 0, 'J');

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Você que dizia no seu coração: Subirei aos céus; erguerei o meu trono acima das estrelas de Deus; eu me assentarei no monte da assembléia, no ponto mais elevado do monte santo. Subirei mais alto que as mais altas nuvens; serei como o Altíssimo. Isaías 14:13-14"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Lúcifer tornou-se orgulhoso e queria ser como Deus, não queria servir ao Senhor criador. Ele convenceu outros anjos a se rebelarem contra Deus. (fig.1.2) O Senhor Deus expulsou Lúcifer e esses anjos do céu. E disse o que aconteceria com ele: Mas às profundezas do Sheol você será levado, irá ao fundo do abismo! Isaías 14:15"), 0, 'J');

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Lúcifer passou a ser conhecido como Satanás ou Diabo, o inimigo de Deus. "), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Mergulhando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Vamos agradecer porque Deus é mais poderoso do que Satanás e um dia vai derrotá-lo completamente."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 1"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O orgulho vem antes da destruição; o espírito altivo, antes da queda. Provérbios 16:18"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 1 - O segredo das profundezas."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que segredo é esse?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que profundezas são essas?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que esse segredo faz?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Para onde ele nos leva?"), 0, 'J');

$pdf->ln(10);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number		    
$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');


// Lição 02
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 02"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("2. O PECADO ENTRA NO MUNDO."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Embarcando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Você sabe o que é uma regra? Pode dar exemplos de regras? Deus deu uma única regra para Adão e Eva quando estavam no jardim: (fig.2.1)Coma livremente de qualquer árvore do jardim, mas não coma da árvore do conhecimento do bem e do mal, porque no dia em que dela comer, certamente você morrerá. Gênesis 2:16,17. Mas existia alguém no jardim que não queria que Adão e Eva obedecessem a Deus."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Carta Náutica:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver quem era?"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.2.2) Ora, a serpente era o mais astuto de todos os animais selvagens que o Senhor Deus tinha feito. E ela perguntou à mulher: Foi isto mesmo que Deus disse: ‘Não comam de nenhum fruto das árvores do jardim’?. Respondeu a mulher à serpente: Podemos comer do fruto das árvores do jardim, mas Deus disse: ‘Não comam do fruto da árvore que está no meio do jardim, nem toquem nele; do contrário vocês morrerão’. Disse a serpente à mulher: Certamente não morrerão! Deus sabe que, no dia em que dele comerem, seus olhos se abrirão, e vocês serão como Deus, conhecedores do bem e do mal. Gênesis 3:1-5 "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Quem era essa serpente? Ele é a antiga serpente chamada diabo ou Satanás, que engana o mundo todo. Ele e os seus anjos foram lançados à terra. Apocalipse 12:9"), 0, 'J');

$pdf->MultiCell(0, 10, $pdf->textoUTF8("O que a serpente disse que ia acontecer se Eva comesse o fruto? Foi o mesmo que Deus disse? Quem você acha que estava falando a verdade? Vamos ver o que Eva fez? (fig.2.3)"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Quando a mulher viu que a árvore parecia agradável ao paladar, era atraente aos olhos e, além disso, desejável para dela se obter discernimento, tomou do seu fruto, comeu-o e o (fig.2.4) deu a seu marido, que comeu também. Gênesis 3:6"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Eva preferiu acreditar em quem, em Deus ou em Satanás? Por que você acha que ela fez isso? O que ela queria? Isso se parece com o pecado de Lúcifer (Satanás)? Como?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Mergulhando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus, muitas vezes Satanás quer nos enganar, como fez com Eva, nos ajude a sempre te obedecermos e acreditarmos na tua Palavra"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 1"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O orgulho vem antes da destruição; o espírito altivo, antes da queda. Provérbios 16:18"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 1 - O segredo das profundezas."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que segredo é esse?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que profundezas são essas?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que esse segredo faz?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Para onde ele nos leva?"), 0, 'J');

$pdf->ln(10);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number

$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');


// Lição 02
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 03"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("3. CONSEQUÊNCIAS DO PECADO"), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Embarcando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Como você se sente quando faz algo que você sabe que está errado? O que você acha que Adão e Eva sentiram depois que desobedeceram a Deus? Será que eles já tinham sentido isso antes? Será que eles morreram?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Carta Náutica:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver na Bíblia como tudo aconteceu:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.3.1) Ouvindo o homem e sua mulher os passos do Senhor Deus que andava pelo jardim quando soprava a brisa do dia, esconderam-se da presença do Senhor Deus entre as árvores do jardim. Mas o Senhor Deus chamou o homem, perguntando: Onde está você?. (fig.3.2) E ele respondeu: Ouvi teus passos no jardim e fiquei com medo, porque estava nu; por isso me escondi. Gênesis 3:8-10"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8(" Por que eles se esconderam de Deus? De que eles tinham vergonha? Agora eles conheciam o mal, eles haviam experimentado o mal. O pecado tem consequências: (fig.3.3)"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("À mulher, Deus declarou: Multiplicarei grandemente o seu sofrimento na gravidez; com sofrimento você dará à luz filhos."), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.3.4) E ao homem declarou:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("maldita é a terra por sua causa; com sofrimento você se alimentará dela todos os dias da sua vida. Ela lhe dará espinhos e ervas daninhas, e você terá que alimentar-se das plantas do campo. Com o suor do seu rosto você comerá o seu pão, até que volte à terra, visto que dela foi tirado; porque você é pó e ao pó voltará. Gênesis 3:16-19"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("A terra toda sofreu as consequências. Lembra o que Deus havia dito que aconteceria com Adão e Eva se eles se comessem aquele fruto? E isso aconteceu mesmo? Que tipo de morte eles tiveram? A morte espiritual é a separação de Deus. Sentimentos de medo, vergonha e culpa começaram a surgir. Você pode pensar em algo que tem feito de errado? Pense: o que acontecerá se você continuar fazendo? Vai continuar?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Mergulhando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração – Deus, ajuda-me a não pecar contra o Senhor."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 2"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Portanto, da mesma forma como o pecado entrou no mundo por um homem, e pelo pecado a morte, assim também a morte veio a todos os homens, porque todos pecaram; Romanos 5:12"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 2 - Um mergulho para o alto"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que mergulho é esse?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* E se não houver mergulho?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que é o alto?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Por que nos leva para o alto?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem me ajuda a mergulhar para o alto?"), 0, 'J');

$pdf->ln(10);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number

$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');


// Lição 04
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 04"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("4. A PROMESSA DE UM SALVADOR."), 0, 1, 'L');


//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Embarcando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Brincando de solução. Dê a solução ou maneira de resolver para cada uma das palavras a seguir: SONO, FOME, CANSAÇO, ESCURO, SEDE, SUJEIRA, DOENÇA, PECADO. Essa última é mais difícil porque cada pessoa pensa diferente na solução para o pecado e alguns até pensam que não tem pecado. Mas o quê a Bíblia diz sobre isso:"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Carta Náutica:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Adão e Eva sofreram consequências muito sérias quanto ao seu pecado. Mas Deus fez a eles uma promessa especial enquanto falava com a serpente: "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Porei inimizade entre você e a mulher, entre a sua descendência e o descendente dela; este lhe ferirá a cabeça, e você lhe ferirá o calcanhar. Gênesis 3:15"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.4.1) Deus prometeu que enviaria um descendente da mulher para ferir a cabeça da serpente. Quem era a serpente? O que acontece quando você fere a cabeça de uma serpente? Deus estava prometendo destruir Satanás através de um descendente especial de uma mulher. Muitos anos depois dessa promessa, quando muitos já achavam que Deus havia se esquecido, Deus enviou seu Filho Perfeito, Jesus Cristo, para ser o Salvador do mundo. (fig.4.2) Jesus escolheumorrer no lugar dos pecadores. Ele sofreu uma morte terrível, na cruz. Mas Jesus não ficou morto, (fig.4.3) Ele voltou a viver. E por causa do que Ele fez nós podemos ser salvos dos nossos pecados. (fig.4.4) Você já aprendeu que foi criado por um Deus todo poderoso e que você é pecador porque desobedece a Deus. Mas através de Jesus seus pecados podem ser perdoados. Você gostaria de pedir para Jesus ser o seu Salvador? Ele quer ser o Senhor da sua vida. Jesus morreu por você porque Ele te ama."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Mergulhando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Senhor, obrigada pela promessa maravilhosa de um Salvador."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 2"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Portanto, da mesma forma como o pecado entrou no mundo por um homem, e pelo pecado a morte, assim também a morte veio a todos os homens, porque todos pecaram; Romanos 5:12"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 2 - Um mergulho para o alto."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que mergulho é esse?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* E se não houver mergulho?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que é o alto?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Por que nos leva para o alto?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem me ajuda a mergulhar para o alto?"), 0, 'J');

$pdf->ln(10);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number

$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');

// Lição 05
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 05"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("5. A PROVISÃO DE DEUS."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Embarcando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Como você acha que Deus se sente em relação ao pecado? Mas e como Deus agiu em relação a Adão e Eva? Será que Deus continuou a amá-los?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Carta Náutica:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Por causa do seu pecado, a desobediência, Adão e Eva sofreram consequências sérias. Assim que pecaram, veja o que a Bíblia diz que eles perceberam: "), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Os olhos dos dois se abriram, e perceberam que estavam nus; então juntaram folhas de figueira para cobrir-se. Gênesis 3:7. "), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Por que só agora perceberam que estavam nus? Porque antes de pecarem não tinham maldade em seus corações. O que você acha das roupas que eles fizeram? Aquelas roupas de folhas não resolviam seu problema. Roupas de folhas iriam se rasgar logo, não iriam durar muito. Deus sabia do que eles precisavam, Ele amava Adão e Eva e não os abandonou. Veja o que Deus providenciou para eles: O Senhor Deus fez roupas de pele e com elas vestiu Adão e sua mulher. Gênesis 3:21. As roupas que Deus fez eram melhores? Por quê? Para fazer a roupa o que ele precisou fazer? (fig.5.2) Deus providenciou uma roupa que era resistente, mas, para isso, Ele precisou sacrificar, ou seja, matar um animal que não tinha nenhuma culpa. Aquele animal morreu para que as roupas de Adão e Eva fossem feitas. Um inocente precisou morrer para cobrir a nudez de Adão e Eva, por causa do pecado deles. Você sabe de alguém que era inocente e morreu para perdoar o pecado de pessoas culpados? Jesus. Ele tinha pecado? Não Ele era o Filho perfeito de Deus que nunca fez nada errado e morreu para nos salvar do pecado. Você sabia que Jesus nunca pecou? Ele era diferente de você?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Mergulhando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus, obrigada porque o Senhor nos ama e mandou seu filho Jesus, sem pecado para morrer em nosso lugar."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 3"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Deus tornou pecado por nós aquele que não tinha pecado, para que nele nos tornássemos justiça de Deus. 2 Coríntios 5:21"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 3 - A cor secreta do amor"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que cor é essa?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Porque ela é a cor do amor?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que amor foi esse?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que este amor fez?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como ter este amor?"), 0, 'J');

$pdf->ln(10);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number

$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');

// Lição 06
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 06"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("6. EXPULSÃO DO JARDIM"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Embarcando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Você sabe para quê serve o cartão vermelho? (fig.6.1) Em um jogo, quando é que o juiz dá o cartão vermelho? Você sabe quando foi dado o primeiro cartão vermelho da história do mundo? Sabe quem recebeu?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Carta Náutica:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Vamos ver o que a Bíblia diz:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Então disse o Senhor Deus: Agora o homem se tornou como um de nós, conhecendo o bem e o mal. Não se deve, pois, permitir que ele também tome do fruto da árvore da vida e o coma, e viva para sempre. (fig.6.2) Por isso o Senhor Deus o mandou embora do jardim do Éden para cultivar o solo do qual fora tirado. Depois de expulsar o homem, colocou a leste do jardim do Éden querubins e uma espada flamejante que se movia, guar- dando o caminho para a árvore da vida. Gênesis 3:22-24"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Adão e Eva agora conheciam o mal. Eles tinham pecado contra o Senhor. Eles agora teriam do- enças em seus corpos. (fig.6.3) Se eles ficassem no jardim e comessem do fruto da árvore da vida, o que aconteceria com eles? Você já imaginou viver para sempre separado de Deus por causa do pecado e com doenças? Ao expulsar Adão e Eva do jardim do Éden, você acha que Deus foi justo? Você acha que Ele foi também misericordioso? Por quê? Ele queria que Adão e Eva fossem salvos do pecado, através da- quela promessa especial que Ele tinha feito, de um dia enviar um descendente. Depois, eles poderiam viver eternamente. Você entende que o seu pecado separa você de Deus? Deus quer ser seu amigo especial, você está pronto a aceitar essa amizade de Deus?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Mergulhando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Senhor, obrigada por ser justo e misericordioso. Eu quero que o Senhor seja meu me- lhor amigo."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 3"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Deus tornou pecado por nós aquele que não tinha pecado, para que nele nos tornássemos justiça de Deus. 2 Coríntios 5:21"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 3 - A cor secreta do amor"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que cor é essa?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Porque ela é a cor do amor?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que amor foi esse?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que este amor fez?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como ter este amor?"), 0, 'J');

$pdf->ln(10);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number

$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');

// Lição 07
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 07"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("7. O DILÚVIO."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Embarcando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Pegue um lápis e papel e desenhe um jardim, mas faça do seu jeito, pode inventar a vontade. Você gosta de ter escolhas? Você sabia que na Bíblia tem a história de um homem que fez tudo do jeito de Deus! Vamos ver quem é!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Carta Náutica:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Muitos anos se passarem desde que Adão e Eva foram expulsos do Éden. Você acha que o pecado cresceu ou diminuiu? (fig.7.1) Ele foi aumentando cada vez mais. Deus ficou contente? Por que não? Deus não suportava ver tanta coisa errada nos seres que Ele havia criado. O que será que Ele fez? A Bíblia diz:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O Senhor viu que a perversidade do homem tinha aumentado na terra e que toda a inclinação dos pensa- mentos do seu coração era sempre e somente para o mal. Então o Senhor arrependeu-se de ter feito o homem sobre a terra; e isso cortou-lhe o coração. Disse o Senhor: Farei desaparecer da face da terra o homem que criei, os homens e também os animais grandes, os animais pequenos e as aves do céu. Arrependo-me de havê-los feito. Gênesis 6:5-7"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("A maldade estava por toda parte. Mas e nos dias de hoje? Quando Deus observa os homens,     as mulheres, as crianças, o que você acha que Ele sente? Você acha que Ele está contente? O homem quer fazer do jeito de Deus? Cada um quer fazer somente a sua vontade, como era naquele tempo. Mas Deus viu que havia alguém diferente: (fig.7.2)"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("¨A Noé, porém, o Senhor mostrou benevolência. Esta é a história da família de Noé: Noé era homem justo, íntegro entre o povo da sua época; ele andava com Deus. Gênesis 6:8-9"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("No meio de todas as pessoas que estavam longe de Deus, havia um homem diferente! Ele an- dava com Deus! Deus então o escolheu para uma grande missão. O que você acha que é andar com Deus? (fig.7.3) Noé foi o responsável por construir a arca, um grande barco. Deus iria enviar um dilúvio, uma chuva enorme, para destruir toda a terra. (fig.7.4) Noé obedeceu à ordem de Deus, construiu a arca e antes do dilúvio, (fig.7.5) Deus colocou um casal de cada espécie de animal na arca, junto com  a família de Noé, para que eles fossem salvos. (fig.7.6) O dilúvio veio! Depois de muitos dias dentro da arca, a família de Noé finalmente pode sair, porque já tinha terra seca. (fig.7.7) Eles adoraram ao Senhor, fizeram um altar e ofereceram um sacrifício a Deus. (fig.7.8) Deus colocou um arco no céu como lembrança da promessa de que Ele nunca mais iria destruir a terra com um dilúvio. Noé foi usado por Deus, por ser um homem obediente. Deus quer usar você, como Ele fez com Noé! Você está pronto a dizer, vou fazer do Seu jeito Deus?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Mergulhando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus ajuda-me a viver do Teu jeito. Eu quero andar contigo, como Noé andava. Quero estar pronto para fazer aqui na terra o que o Senhor mandar."), 0, 'J');
$pdf->Ln(5);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 4"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Há caminho que parece certo ao homem, mas no final conduz à morte. Provérbios 14:12"), 0, 'J');
$pdf->Ln(5);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 4 - Os construtores de faróis"), 0, 'J');
$pdf->Ln(5);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem são os construtores?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que são os faróis?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é o verdadeiro dono dos faróis?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como o farol deve ser feito?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que acontece se for feito do jeito errado?"), 0, 'J');

$pdf->ln(10);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number

$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');

// Lição 08
$pdf->AddPage();

//Capa
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 0, $pdf->textoUTF8("Lição 08"), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 10, $pdf->textoUTF8("8. BABEL."), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Embarcando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Que idioma você fala? Você sabe falar inglês? E francês? E alemão? Você sabe outros nomes de idiomas? Você sabe como todas as línguas surgiram? Vamos ver o que a Bíblia diz:"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Carta Náutica:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Muitos anos depois do dilúvio havia muitos novos moradores na terra. A família de Noé havia se multiplicado. Então o Senhor ordenou novamente: Mas vocês, sejam férteis e multipliquem-se; espalhem- se pela terra e proliferem nela. Gênesis 9:7 (fig.8.1) Mas não foi isso o que aconteceu. Vamos ver o que a Bíblia diz:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("No mundo todo havia apenas uma língua, um só modo de falar. Saindo os homens do Oriente, encon- traram uma planície em Sinear e ali se fixaram. Disseram uns aos outros: ´Vamos fazer tijolos e queimá-los bem’. Usavam tijolos em lugar de pedras, e piche em vez de argamassa. (fig.8.2) Depois disseram: ‘Vamos construir uma cidade, com uma torre que alcance os céus. Assim nosso nome será famoso e não seremos espalhados pela face da terra’. Gênesis 11:1-4"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("(fig.8.3) Apesar da ordem de Deus de que eles deveriam se espalhar pela terra, os homens deci- diram se fixar em um só lugar, desobedecendo ao Senhor. Escolheram fazer sua própria vontade. Eles queriam ficar famosos, estavam com seu coração cheio de vaidade e orgulho. Vamos ver o que Deus fez: O Senhor desceu para ver a cidade e a torre que os homens estavam construindo. E disse o Senhor:"), 0, 'J');

$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Eles são um só povo e falam uma só língua, e começaram a construir isso. Em breve nada poderá impedir o que planejam fazer. Venham, desçamos e confundamos a língua que falam, para que não entendam mais uns aos outros. (fig.8.4) Assim o Senhor os dispersou dali por toda a terra, e pararam de construir a cidade. Por isso foi chamada Babel, porque ali o Senhor confundiu a língua de todo o mundo. Dali o Senhor os espalhou por toda a terra. Gênesis 11:5-9"), 0, 'J');

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("O que aconteceu quando Deus confundiu a língua que eles falavam? Por que Deus fez isso? No final, o propósito de Deus foi cumprido? E na sua vida, algumas vezes você também quer fazer as coisas do seu jeito e não do jeito de Deus, obedecendo a Palavra de Deus? Você acha que vale a pena fazer as coisas contra a vontade de Deus? Por quê?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(90, 10, $pdf->textoUTF8("Mergulhando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Oração - Deus nos ajude a fazer sempre as coisas de Seu jeito porque o Senhor nos ama e só quer o melhor para nós."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("Versículo para memorizar 4"), 0, 'J');
$pdf->SetFont('arial', 'I', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Há caminho que parece certo ao homem, mas no final conduz à morte. Provérbios 14:12"), 0, 'J');
$pdf->Ln(10);

$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 4 - Os construtores de faróis"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem são os construtores?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que são os faróis?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é o verdadeiro dono dos faróis?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como o farol deve ser feito?"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que acontece se for feito do jeito errado?"), 0, 'J');

$pdf->ln(10);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number

$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');

// Respostas dos mistérios
$pdf->AddPage();

$pdf->Ln(8);
$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(0, 5, $pdf->textoUTF8("Respostas de Mistérios - Mergulho"), 0, 1, 'C');
$pdf->Ln(8);
$pdf->Cell(0, 5, "", "B", 1, 'C');
$pdf->Ln(8);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

// 01
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 1 - O segredo das profundezas."), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que segredo é esse? - O Pecado"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que profundezas são essas? - As pronfudezas do nosso coração"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que esse segredo faz? - Destrói nossa vida"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Para onde ele nos leva? - Para longe de Deus"), 0, 'J');

// 02
$pdf->Ln(10);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 2 - Um mergulho para o alto"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que mergulho é esse? - Procurar os pecados no coração e arrepender-se"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* E se não houver mergulho? - Ficamos longe de Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que é o alto? - Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Por que nos leva para o alto? - Porque perdoa nosso pecado, nos faz santos"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem me ajuda a mergulhar para o alto? - Deus"), 0, 'J');

// 03
$pdf->Ln(10);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 3 - A cor secreta do amor"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que cor é essa? - Vermelho"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Porque ela é a cor do amor? - Porque é a cor do sangue de Jesus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Que amor foi esse? - Amor de Jesus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que este amor fez? - Morreu pelos meus pecados"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como ter este amor? - Arrependendo dos pecados e acreditando em Jesus"), 0, 'J');

// 04
$pdf->Ln(10);
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(0, 10, $pdf->textoUTF8("Mistério 4 - Os construtores de Faróis"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem são os construtores? - Nós"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que são os faróis? - Nossas vidas"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Quem é o verdadeiro dono dos faróis? - Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* Como o farol deve ser feito? - Do jeito de Deus"), 0, 'J');
$pdf->MultiCell(0, 10, $pdf->textoUTF8("* O que acontece se for feito do jeito errado? - Vamos ser inputeis, não vai dar certo"), 0, 'J');

$pdf->ln(10);
// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number

$pdf->Cell(0, 10, "Este material foi impresso por: " . $pdf->textoUTF8($nome_usuario), 0, 1, 'J');


$nome_relatorio = $pdf->textoUTF8("Mergulho");
$pdf->Output("$nome_relatorio.pdf", "I");