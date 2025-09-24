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

$pdf->Cell(0, 5, utf8_decode("Máterial Expedição Verde 2 - A Evolução"), 0, 1, 'C');
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

$pdf->Cell(50, 20, utf8_decode("1. Carvalhos de Justiça"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Germinando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Nós conversamos sobre a variedade do fruto da terra e a variedade do fruto do espírito e como nos ajudam a melhorar nossa saúde física e espiritual e a ser benção para outros. Agora, em nossa Operação Verde II - A evolução, iremos investigar algumas árvores citadas na Palavra de Deus. Como seus ensinos nos ajudarão a evoluir como pessoas. A primeira é o Carvalho. Vocês conhecem? Vamos conhecer melhor os Carvalhos (Distribua pedaços de papel com cada uma dessas características abaixo) Vamos cada um ler o que tem em seu papel!"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("(Fig.1.1) O Carvalho tem uma longevidade que ultrapassa 300 anos. Seus frutos são as bolotas e durante sua vida um Carvalho pode produzir 50 mil bolotas. O Carvalho é símbolo de honra, nobreza, integridade e sabedoria. Os vikings usavam madeira de Carvalho para construírem seus navios. Durante o furacão Katrina, 700 árvores caíram, só 4 carvalhos. Sua raízes se entrelaçam com as árvores ao redor, sua folhas se enrolam. Os ventos não lutam contra uma árvore mas contra uma comunidade de árvores. Os Carvalhos podem chegar a 45 metros. Sua madeira é dura mas fácil de ser trabalhada. Uau! Vamos agora ler o texto da Palavra que fala sobre o Carvalho!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Energizando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Vamos começar nossa Operação ouvindo Isaías 61:1-4, Jesus leu esse texto diante dos sacerdotes (Lc 4:18-19): (Fig.1.2)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("O Espírito do Soberano Senhor está sobre mim porque o Senhor ungiu-me para levar boas notícias aos pobres. Enviou-me para cuidar dos que estão com o coração quebrantado, anunciar liberdade aos cativos e libertação das trevas aos prisioneiros, para proclamar o ano da bondade do Senhor e o dia da vingança do nosso Deus; para consolar todos os que andam tristes, e dar a todos os que choram em Sião uma bela coroa em vez de cinzas, o óleo da alegria em vez de pranto, e um manto de louvor em vez de espírito deprimido. Eles serão chamados carvalhos de justiça, plantio do Senhor, para manifestação da sua glória. Eles reconstruirão as velhas ruínas e restaurarão os antigos escombros; renovarão as cidades arruinadas que têm sido devastadas de geração em geração. (Fig.1.3)"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Isaias estava falando sobre quem? Sobre ele mesmo? Sobre Jesus? E como ele nos chama No verso 3? Você e eu somos Carvalhos? Como assim? (Deixe que deem suas opiniões, dê a sua!) Os Carvalhos são fortes e resistentes!"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("E não somos apenas carvalhos, somos Carvalhos de justiça! O que é justiça? (deixe que falem) No dicionário, significa manter o que é justo, correto, certo, dando recompensas e punições para que isso aconteça."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("E na Bíblia? Deuteronômio 32:4 ralaciona justiça como o quê? Com as obras e os caminhos de Deus.É manter a ordem que Ele criou! Lembra que era tudo muito bom? Tudo era certo! E o que aconteceu de errado? Por causa do pecado tudo o que foi criado saiu de ordem. O pecado deixa as pessoas tristes, raivosas, ansiosas e com muito medo. As pessoas ficaram fracas e erradas em vez de resistentes e corretas. Podem dizer coisas que saíram da ordem em que foram criadas? Como fazer tudo isso voltar a ordem? Como obter justiça novamente?"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Como Jesus livra as pessoas do pecado? Como ele as ajuda a serem pessoas resistentes ao pecado? A serem justas? Estou curiosa! Vamos agora analisar o texto: (Fig.1.4)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("O Espírito do Soberano Senhor está sobre mim porque o Senhor ungiu-me para levar boas notícias aos pobres."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Os pobres deixam de ser pobres quando aceitam a boa nova de Jesus? O que acontece com eles? Jesus traz o quê para eles? Boas notícias! Como você se sente com boas notícias? Como você se sentiu quando soube da salvação em Cristo? Como você se sente quando sabe que existe um remédio eficaz para uma doença que todos estão com medo? Com alegria, esperança! Quando a pessoa é pobre, as vezes, ela pensa que nunca vai ter nada, nem uma casa na vida, então ela começa a desanimar, reclamar, fala mal dos ricos, tem inveja e acha que tudo é ruim e difícil para ela. E qual a boa notícia que Jesus traz aos pobres? Que Ele está com os pobres, que as riquezas não valem nada e  que a verdadeira alegria está nEle e que todos vamos ter uma morada no céu! Como vc acha que as pessoas que não tem muitas coisas se sentem sabendo disso? Vamos continuar!"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Enviou-me para cuidar dos que estão com o coração quebrantado."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Você sabe o que é um coração quebrantado? É alguém que está muito triste por causa das coisas erradas que já fez! E o que Jesus faz por essas pessoas? Ele condena? Ele faz uma mágica para as coisas erradas que ela fez desapareçam? Não, Ele cuida! Como se cuida de alguém que está triste? Jesus faz isso!"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Anunciar liberdade aos cativos."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("E para as pessoas que são escravas, cativas em seus pecados? Os viciados e os que se sentem presos nos seus corpos? Ele anuncia que elas podem ser livres. Elas não precisam se sentir presas, podem sentir a liberdade que Cristo oferece, e no céu, terão seus corpos livres de doenças e mazelas também. Jo 8:32 e 36"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Libertação das trevas aos prisioneiros."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("E as pessoas que estão presas porque fizeram algo errado? Jesus vai tirá-las da prisão? Seria justo? - Não! Ele as liberta das trevas do seu pecado.Elas se sentem livres, mesmo estando presas porque são livres de toda raiva e maldade de seus corações. "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Para consolar todos os que andam tristes, e dar a todos os que choram em Sião uma bela coroa em vez de cinzas, o óleo da alegria em vez de pranto, e um manto de louvor em vez de espírito deprimido."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("E os tristes? Os que choram e os deprimidos porque perderam alguma coisa ou alguém? - Ele consola, honra, dá alegria e coloca um louvor na boca deles! Como nosso Deus é bom! Vamos ler todos juntos algo muito importante?"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("A JUSTIÇA DE DEUS NÃO LIVRA DA OPRESSÃO, DA FOME, DAS GUERRAS, DA DOENÇA... ELA NOS LIVRA DO PECADO QUE PRODUZ TODAS ESSAS COISAS."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Sem Jesus, as pessoas são resistentes e justas? são corretas? Elas até tentam, tentam tirar a opressão, a fome, a guerra mas fazem isso sem Deus e não funciona, porque o homem tem uma natureza de .............! E começa tudo errado de novo! Como fazer?"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Vamos ler o final do texto, porque o final vai falar agora, da minha e da sua parte! Eles serão chamados carvalhos de justiça, plantio do Senhor, para manifestação da sua glória. O que entenderam? Fomos plantados para que? Como mostramos a glória de Deus?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Eles reconstruirão as velhas ruínas e restaurarão os antigos escombros; renovarão as cidades arruinadas que têm sido devastadas de geração em geração."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que nós vamos fazer? Olha como estão as coisas hoje! Eu e vocês podemos reconstruir as coisas! Como? Falando de Jesus, discipulando pessoas, sendo resistentes ao pecado, justos e corretos."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Vamos escrever palavras que nos lembram situações onde podemos ser justos e corretos. Escola - estudando, ....pode ser também não colando,... Pense em um amigo que você pode discipular!"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Quem aqui é Carvalho de justiça? Você quer ser resistente e justo? E que não se abala com problemas? E é consolado pelo Senhor! É como ter um tesouro e que você vai descobrir qual é se for correto com Deus e fizer seu semanário! Vamos orar:"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Evoluindo:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Senhor nos ajude a realmente fazer a justiça que o Senhor Jesus fez nesse mundo. Falando dEle e ajudando outros a crerem que só Jesus põe ordem em todas as coisas, principalmente em nossa vida!  e ensinando as pessoas a te obedecerem! Me ajude a ser correto. Não roubar, não enganar, mas ajudar e espalhar o Teu amor! Em nome de Jesus!"), 0, 'J');

$pdf->Ln(10);
$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 1"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Os justos florescerão como a palmeira, crescerão como o cedro do Líbano; plantados na casa do Senhor, florescerão nos átrios do nosso Deus. Mesmo na velhice darão fruto, permanecerão viçosos e verdejantes, para proclamar que o Senhor é justo. Ele é a minha rocha; nele não há injustiça. Salmos 92:12-15"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);

$pdf->MultiCell(0, 15, utf8_decode("Mistério 1 - O Segredo da Evolução"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que segredo é esse?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como obter esse segredo?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como saber se descobriu o segredo?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que esse segredo produz?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que acontece com quem não encontra o segredo?"), 0, 'J');

$pdf->ln(10);

// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo(a) - " . $nome_usuario, 0, 1, 'J');
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
$pdf->Cell(50, 20, utf8_decode("2. A Árvore do Sucesso - Palmeira"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Germinando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Providencie uma cartolina e canetas ou lápis) Nessa Operação Verde II estamos analisando algumas árvores e plantas! No último encontro, vimos que quando cremos em Cristo ele nos faz justos diante de Deus e nos ajuda a ser carvalhos de justiça nesse mundo! O que é ser Justo, lembram? É agir de acordo com a ordem que Deus criou! Ele fez tudo bom! A justiça é algo valioso que ajuda a nós e as pessoas que estão ao nosso redor! Porém, quando, em nosso dia a dia, ouvimos o Espírito Santo e escolhemos ser justos, somos também comparados à Palmeira! Uau! Vamos ver quem já memorizou o versículo?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Os justos florescerão como a palmeira, crescerão como o cedro do Líbano; plantados na casa do Senhor, florescerão nos átrios do nosso Deus. Mesmo na velhice darão fruto, permanecerão viçosos e verdejantes, para proclamar que o Senhor é justo. Ele é a minha rocha; nele não há injustiça. Salmos 92:12-15"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Esse verso nos diz que os justos terão outra coisa que todo mundo procura. É uma palavra que tem som de S em todas as suas sílabas! Quem sabe? SUCESSO - O que é ter sucesso? Vamos escrever nesse papel tudo que representa “ter sucesso” para as pessoas! (Peça que escrevam e leiam suas respostas) Parece que todas essas palavras tem a ver com melhorar em algo, com evoluir! Para evoluir a planta precisa de energia e nós também! Qual a fonte de energia para o nosso espírito? Então vamos lá!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Energizando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Vamos lá! Vamos energizar na Palavra para aprendermos a evoluir a verdadeira evolução! A ter o verdadeiro sucesso! Vamos analisar esta passagem!"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Fig.2.1) Os justos florescerão como a palmeira, crescerão como o cedro do Líbano; plantados na casa do Senhor, florescerão nos átrios do nosso Deus. Mesmo na velhice darão fruto, permanecerão viçosos e verdejantes, para proclamar que o Senhor é justo. Ele é a minha rocha; nele não há injustiça. Salmos 92:12-15"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Fig.2.2) Ok, o texto fala de todas as fases da planta. Vocês já devem ter aprendido na escola! (Coloque essas palavras escritas em tiras de papel e misture-as - Plantados, Casa do Senhor, crescerão, florescerão, darão fruto, viçosos e verdejantes, germinação, crescimento (fotossíntese e respiração) ,floração e frutificação!) Voces conseguem fazer a relação do versículo com as fases?"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("(Coloque os textos abaixo em papeis e entregue a diferentes duplas ou individualmente) Ok! Agora vamos ler essa narrativa dos textos que estão na sua mão, depois vocês vão ter a missão de me recontar a história e depois, responder as perguntas que eu vou fazer!"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("A Bíblia nos conta a hisória de Ana, esposa de Elcana que não tinha filhos e pediu a Deus que lhe desse um filho, Deus atendeu! (Fig 2.3) Ana dedicou seu filho a Deus e o levou para ser criado pelo sacerdote Eli! (Seu papel)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Era este menino que eu pedia, e o Senhor concedeu-me o pedido. Por isso, agora, eu o dedico ao Senhor. Por toda a sua vida será dedicado ao Senhor. E ali adorou o Senhor. 1 Samuel 1:27,28"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Suas perguntas) Ela alcançou sucesso em ser mãe? Como? E o que ela fez? Por que? (Dupla 1)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Fig.2.4) Os filhos de Eli eram ímpios; não se importavam com o Senhor nem cumpriam os deveres de sacerdotes para com o povo. 2:12,13 O pecado desses jovens era muito grande à vista do Senhor, pois eles estavam tratando com desprezo a oferta do Senhor. Samuel, contudo, ainda menino, ministrava perante o Senhor, vestindo uma túnica de linho. 2:17,18"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Recontar) Perguntas para eles - O que é sucesso para um jovem que não se importa com Deus? Como procedem com relação a Deus? O que as atitudes de Samuel demonstravam? O que os filhos de Eli deviam pensar de Samuel? O que seus colegas pensam de você? Como você se sente? (Dupla 2)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Eli, já bem idoso, ficou sabendo de tudo que seus filhos faziam a todo o Israel e que eles se deitavam com as mulheres que serviam na entrada da Tenda do Encontro. Por isso lhes perguntou: Por que vocês fazem estas coisas? De todo o povo ouço a respeito do mal que vocês fazem. Não, meus filhos; não é bom o que escuto se espalhando entre o povo do Senhor. Se um homem pecar contra outro homem, os juízes poderão intervir em seu favor; mas, se pecar contra o Senhor, quem intercederá por ele? Seus filhos, contudo, não deram atenção à repreensão de seu pai, pois o Senhor queria matá-los. E o menino Samuel continuava a crescer, sendo cada vez mais estimado pelo Senhor e pelo povo.  2:22-26"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Recontar) Perguntas  - Hoje, os jovens sem Deus são diferentes?O que é sucesso para eles? Eles escutam os pais? Podem comparar Samuel e os filhos de Eli? Por que Samuel agia diferente? Qual o resultado diante das pessoas? Que resultados você tem visto ao seu redor? (Dupla 3)"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Portanto, o Senhor, o Deus de Israel, declara (A Eli): Prometi à sua família e à linhagem de seu pai, que ministrariam diante de mim para sempre. Mas agora o Senhor declara: 'Longe de mim tal coisa! Honrarei aqueles que me honram, mas aqueles que me desprezam serão tratados com desprezo."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("É chegada a hora em que eliminarei a sua força e a força da família de seu pai, e não haverá mais nenhum idoso na sua família, e você verá aflição na minha habitação. Embora Israel prospere, na sua família ninguém alcançará idade avançada. E todo descendente seu que eu não eliminar de meu altar será poupado apenas para lhe consumir os olhos com lágrimas e para lhe entristecer o coração, e todos os seus descendentes morrerão no vigor da vida. E o que acontecer a seus dois filhos, Hofni e Finéias, será um sinal para você: os dois morrerão no mesmo dia.  2:30-34"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Recontar) Qual o resultado diante de Deus? Qual o castigo de Eli por não ter prestado atenção em seus filhos? E dos filhos? (Dupla 4)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Fig.2.5) O menino Samuel ministrava perante o Senhor, sob a direção de Eli; naqueles dias raramente o Senhor falava, e as visões não eram freqüentes. Certa noite, Eli, cujos olhos estavam ficando tão fracos que já não conseguia mais enxergar, estava deitado em seu lugar de costume. ...Samuel estava deitado no santuário do Senhor, onde se encontrava a arca de Deus. Então o Senhor chamou Samuel. Samuel respondeu: Estou aqui. E correu até Eli e disse: Estou aqui; o senhor me chamou?  Eli, porém, disse: Não o chamei; volte e deite-se. Então, ele foi e se deitou. De novo o Senhor chamou: Samuel!  E Samuel se levantou e foi até Eli e disse: Estou aqui; o senhor me chamou? Disse Eli: Meu filho, não o chamei; volte e deite-se. Ora, Samuel ainda não conhecia o Senhor. A palavra do Senhor ainda não lhe havia sido revelada."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("(Fig.2.6) O Senhor chamou Samuel pela terceira vez. Ele se levantou, foi até Eli e disse: Estou aqui; o senhor me chamou?  Então Eli percebeu que o Senhor estava chamando o menino e lhe disse: Vá e deite-se; se ele chamá-lo, diga: Fala, Senhor, pois o teu servo está ouvindo . Então Samuel foi se deitar. O Senhor voltou a chamá-lo como nas outras vezes: Samuel, Samuel!  Então Samuel disse: Fala, pois o teu servo está ouvindo. 3:1-10"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("O Senhor estava com Samuel enquanto este crescia, e fazia com que todas as suas palavras se cumprissem. 3:19"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Recontar) Samuel enquanto crescia, estudava e ministrava a Palavra e qual foi o resultado? Ele alcançou sucesso? Que tipo de sucesso?"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("(Para todos) Em que tipo de sucesso você tem acreditado? Qual o resultado? Que sucesso você quer ter? Como obter sucesso diante de Deus? O sucesso da planta é dar frutos. O que a planta precisa para crescer, florescer e frutificar? 2 processos: Fotossintese e respiração. Valendo ____figurinhas, pesquisar como é o processo da fotossintese, e relacionar com o crescimento espiritual! O que seriam o sol e água?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Evoluindo :"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Senhor nos ajude a sermos justos e a dar frutos de justiça nesse mundo, mas não com a sabedoria do mundo, mas com a sabedoria da Tua Palavra, não com as nossas forças, mas com o poder do Espírito Santo! Nos ajude a permanecer firmes e resistentes, a evoluirmos como filhos teus, e a abençoarmos os que estão ao nosso redor! Em nome de Jesus!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 1"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Os justos florescerão como a palmeira, crescerão como o cedro do Líbano; plantados na casa do Senhor, florescerão nos átrios do nosso Deus. Mesmo na velhice darão fruto, permanecerão viçosos e verdejantes, para proclamar que o Senhor é justo. Ele é a minha rocha; nele não há injustiça. Salmos 92:12-15"), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 1- O Segredo da Evolução"), 0, 'J');
$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->MultiCell(0, 15, utf8_decode("* Que segredo é esse?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como obter esse segredo?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como saber se descobriu o segredo?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que esse segredo produz?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que acontece com quem não encontra o segredo?"), 0, 'J');
$pdf->ln(10);

// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo(a) - " . $nome_usuario, 0, 1, 'J');
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
$pdf->Cell(50, 20, utf8_decode("3. A Árvore de Pedra - Cedro - Força"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Germinando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Faça cartões com as palavras - Salomão, Templo, Palácio, Lepra, Poder, Justos, Homem, Casa e Altura e com os versículos : 1 Reis 10:26-27, 1 Reis 6;18, (2 Samuel 5:11, 1 Reis 7:2-3), Levitico 14:1-7, Ezequiel 31:2-3, Salmo 92:12, (Cantares 5:15, Ezequiel 17:22-23), Cantares 1:17 e Amós 2:9). Qual a idade de vocês? Quantos anos tem a pessoa mais velha que você conhece? Agora me diga, quantos anos vive uma árvore? Você sabia que algumas árvores vivem milhares de anos?"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Como sabemos a idade de uma árvore? Pelos anéis formados dentro do tronco. Cada par de anéis corresponde a 1 ano porque há mudança no tronco cada vez que chega o verão e cada vez que chega o inverno. Pelos anéis, dá até para saber se houve mudança no clima do local. (Fig.3.1) A árvore que vamos conhecer hoje se chama Cedro, o famoso Cedro do Líbano! Ela está desenhada na bandeira do Líbano! E você sabia que existem cedros com mais de 3000 anos? Outra característica do cedro é que a madeira é dura, mas moldável. Vamos ver alguns versos que falam sobre o Cedro.(Distribua os versos e coloque os cartões de palavras na mesa) Em duplas (ou individual) vamos ler os versos e pegar o cartão com a palavra mencionada! "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("O Cedro tinha valor? O cedro é símbolo de força, poder, majestade e riqueza! Mas porque Deus compara os justos com o Cedro? Que poder e força são esses?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Energizando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Em nossa expedição verde 2, já utilizamos 2 árvores para analisarmos o conceito de Justiça e o de Sucesso. E agora o Cedro nos ensinará sobre FORÇA e PODER. Salmo 92 diz que vamos crescer como os Cedros. Como será que eles desenvolvem? Quem aqui tem vontade de crescer, ter força, ser um homem ou uma mulher poderosa? E, o que é ter poder e força verdadeiros? Vamos analisar a vida de Salomão, ele foi filho de Davi e foi o homem mais poderoso da Bíblia. (Fig.3.2)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Quando se aproximava o dia de sua morte, Davi deu instruções ao seu filho Salomão: Estou para seguir o caminho de toda a terra. Por isso, seja forte e seja homem."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que é ser um homem? O que é ser uma mulher? Como ser forte? Davi nos responde:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Obedeça ao que o Senhor, o seu Deus, exige: Ande nos seus caminhos e obedeça aos seus decretos, aos seus mandamentos, às suas ordenanças e aos seus testemunhos, conforme se acham escritos na Lei de Moisés; assim você prosperará em tudo o que fizer e por onde quer que for, e o Senhor manterá a promessa que me fez: Se os seus descendentes cuidarem de sua conduta, e se me seguirem fielmente de todo o coração e de toda a alma, você jamais ficará sem descendente no trono de Israel. 1 Reis 2:1-4"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que Salomão precisava fazer para prosperar e ser um rei poderoso e forte? Que força e poder são esses? É mandar em outros? Controlar? Fazer com que tenham medo? Na escola há aqueles que querem mandar em todos? Mas, eles tiram boas notas? Tem a simpatia dos outros? São exemplos? Você quer ter esse tipo de força? Pessoas fortes fazem bem aos outros, abençoam e seguem em seu crescimento com Deus! Os Cedros, tem ramos grandes que servem de ninho para os pássaros e sombra para animais e pessoas. Como você poderia fazer o bem?"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Creio que Salomão tentou seguir os mandamentos, controlar os problemas de seu reinado mas depois de várias mortes no seu povo, decidiu falar com Deus. Ofereceu sacrifícios, e Deus lhe falou em sonho e disse: (Fig.3.3)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Peça-me o que quiser, e eu lhe darei."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Uau! O que você teria pedido? Vamos ver o que ele pediu:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Agora, Senhor meu Deus, fizeste o teu servo reinar em lugar de meu pai Davi. Mas eu não passo de um jovem e não sei o que fazer. Teu servo está aqui entre o povo que escolheste, um povo tão grande que nem se pode contar. Dá, pois, ao teu servo um coração cheio de discernimento para governar o teu povo e capaz de distinguir entre o bem e o mal. Pois, quem pode governar este teu grande povo? 1 Reis 3:6-9"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Não era só para seguir os mandamentos? Ele tentou! Mas conseguiu? Conseguimos sabedoria sozinhos? Por que ele pediu Sabedoria? Sabedoria nos ajuda a saber o certo e o errado! A tomar decisões acertadas! Quando fazemos isso, baseados na Palavra, ficamos seguros e isso nos fortalece, aconteça o que acontecer sabemos que está certo e que é a vontade de Deus! (Dê aqui, um testemunho quando seguiu a vontade de Deus na sua vida)"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Mas, podemos encontrar sabedoria para vender na esquina? Tem black Friday de sabedoria em algum lugar? Onde podemos encontrar sabedoria free? Vamos encontrar na humildade de pedir a Deus, reconhecendo que não sabe o que fazer! Você já fez isso? Já reconheceu diante de Deus que é apenas um jovem e não sabe o que fazer nesse mundo louco? Sabedoria é a força que você precisa! Agora, vamos continuar com a resposta de Deus a Salomão! (Fig.3.4)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("O pedido que Salomão fez agradou ao Senhor. Por isso Deus lhe disse: Já que você pediu isto e não uma vida longa nem riqueza, nem pediu a morte dos seus inimigos, mas discernimento para ministrar a justiça, farei o que você pediu. Eu lhe darei um coração sábio e capaz de discernir, de modo que nunca houve nem haverá ninguém como você. Também lhe darei o que você não pediu: riquezas e fama; de forma que não haverá rei igual a você durante toda a sua vida. E, se você andar nos meus caminhos e obedecer aos meus decretos e aos meus mandamentos, como o seu pai Davi, eu prolongarei a sua vida. 1 Reis 3:10-14"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Olhem só! Sabedoria! E ainda deu uma Vida longa, força, poder, dignidade e honra. Essas coisas, na realidade são fruto de um viver sábio! A sabedoria lhe ajudará a cuidar melho de seu corpo? De seu caráter? Lhe transformará em alguém sempre melhor? Você será como o Cedro!"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Deus deu a Salomão sabedoria, discernimento extraordinário e uma abrangência de conhecimento tão imensurável quanto a areia do mar. 1 Reis 4:29"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Ele compôs três mil provérbios, e os seus cânticos chegaram a mil e cinco. Descreveu as plantas, desde o cedro do Líbano até o hissopo que brota nos muros. Também discorreu sobre os quadrúpedes, as aves, os animais que se movem rente ao chão e os peixes."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Salomão virou cientista! Você acha que uma pessoa sábia gosta de estudar? Será que só irá estudar na hora da prova? Como o sábio trata seus pais? O que entra pelos seus olhos? O que sai de sua boca? Prestem atenção!"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Homens de todas as nações vinham ouvir a sabedoria de Salomão. Eram enviados por todos os reis que tinham ouvido falar de sua sabedoria. 1 Reis 4:32-34"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Salomão era poderoso e crescia como um Cedro! Você quer crescer como um Cedro? Reconheça que precisa de sabedoria, peça a Deus e busque na Bíblia, ela tem um livro que ensina a ser sábio! Deus inspirou o próprio Salomão a escrever! Provérbios! Olhem o objetivo desse livro:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Estes são os provérbios de Salomão, filho de Davi, rei de Israel. Eles ajudarão a experimentar a sabedoria e a disciplina; a compreender as palavras que dão entendimento; a viver com disciplina e sensatez, fazendo o que é justo, direito e correto; ajudarão a dar prudência aos inexperientes e conhecimento e bom senso aos jovens. Provérbios 1:1-4"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("E então? Salomão foi o homem mais poderoso do mundo, mas, como conseguiu? Ele pediu força e poder? O que ele pediu a Deus? Porque pediu isso? Sua intenção era abençoar e cuidar de seu povo, não pediu para sí mesmo! E você, o que pedirá ao Senhor? E temos uma outra missão. Há segredos para a verdadeira evolução, um dos segredos é se livrar do Ouro dos tolos. Muitos acreditam nele! Se fizerem o semanário vocês vão evoluir no conhecimento e descobrir que ouro é esse, e sobre as mentiras que podem fazer de você um simples capim, em vez de um Cedro! Prontos para executar as missões?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Evoluindo:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Senhor nos ajude a crescer como os cedros do Líbano, a ser fortes no Senhor diante desse mundo tão difícil!!!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 2"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("A riqueza e a honra vêm de ti; tu dominas sobre todas as coisas. Nas tuas mãos estão a força e o poder para exaltar e dar força a todos. 1 Crônicas 29:12"), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Missão Extra"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Ler os primeiros 5 capítulos de Provérbios! Vamos dividir em 2 grupos, a cada encontro, o grupo que descobrir mais ensinamentos de cada capítulo de provérbios, ganhará um prêmio extra! Semana que vem temos o capítulo 1. Cada grupo trará os ensinos e de quais versículos foram tirados! Com certeza isso vai aprofundar nossas raízes! E vamos crescendo como os Cedros!"), 0, 'J');

$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 2- O Ouro dos Tolos"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* O que é o Ouro dos Tolos?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quais são as 3 Piritas da Vida?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como surgem esses Piritas?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como evitar a Pirita da força e do poder?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como evitar a Pirita da riqueza?"), 0, 'J');
$pdf->ln(10);

// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo(a) - " . $nome_usuario, 0, 1, 'J');
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
$pdf->Cell(50, 20, utf8_decode("4. A Árvore Preciosa - Figueira - Riqueza"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Germinando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Providencie papel e caneta) Olhe para essas 2 figuras e diga qual a maior? Agora olhe para essas palavras e diga qual a cor de cada palavra. Foi difícil? Seu cérebro quis lhe enganar? Vocês sabem o que é uma ilusão? É um erro de percepção ou de entendimento; engano dos sentidos ou da mente; interpretação errada! Você já foi enganado? Pensou que algo era de um jeito e não era? Por exemplo, nós aprendemos com o Cedro sobre os enganos no conceito da força e do poder."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Hoje temos algo mais fácil de definir! Me respondam: O que é prosperidade? Que significa ser próspero? Ok! Vamos ver o que diz o dicionário! Alguns dicionários definem como possessão de bens, riqueza e fartura e outros acrescentam “ser bem sucedido, feliz, afortunado”. Não é interessante como vcs mencionaram só o primeiro significado? Por que será? Em nossa expedição verde II, vamos descobrir o significado verdadeiro de prosperidade, na Palavra de Deus, e mais uma árvore irá nos ajudar."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Energizando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Fig.4.1) Quem já comeu figo? Que árvore produz figos? A Figueira! Esta árvore é mencionada mais de 50 vezes na Bíblia! Você sabia que o figo não é um fruto? Parece, mas não é! O figo é uma flor! Uma flor virada para dentro, e os frutos são os pequenos pontos pretos dentro dela. Para o povo de Deus, a figueira tem um significado. Prestem atenção nesse versículo:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Durante a vida de Salomão, Judá e Israel viveram em segurança, cada homem debaixo da sua videira e da sua figueira, desde Dã até Berseba. 1 Reis 4:25"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que a Videira e a Fiqueira representam? Segurança! Quando alguém se sente seguro? Quando ela tem tudo que é necessário e está em paz! Salomão foi um Rei que temia a Deus, era sábio justo e honesto, o resultado foi um povo feliz, próspero materialmente e espiritualmente  que podia se sentar debaixo da figueira e comer de seu fruto com paz e tranquilidade."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("É assim que as pessoas vivem hoje? Como é o dia a dia da sua família? Hoje as pessoas têm medo do que pode acontecer com elas e passam dia e noite trabalhando ou, tirando dinheiro dos outros,  porque acreditam que ser próspero é ter muito dinheiro e o que ele pode comprar e isso poderia trazer segurança. Elas só conhecem um significado da palavra próspero (Ter riquezas), mas não conhecem os outros - Ser bem sucedido (Ter resultados no que faz), feliz (Ter paz e tranquilidade), afortunado(Abençoado)."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Como alcançar a prosperidade e a riqueza verdadeira? O que é ser rico de verdade? Jesus contou uma parábola para uma multidão para ensinar sobre as riquezas! Vamos ver! A multidão estava ao redor de Jesus e..."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Alguém da multidão lhe disse: Mestre, dize a meu irmão que divida a herança comigo."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que é uma herança? Como é dividida uma herança? Um casal morre, seus bens são divididos igualmente entre seus filhos. Em Israel a lei era outra. A herança era dividida assim: O mais velho ganhava o dobro do que ganhavam os outros filhos.  Aquela pessoa queria que Jesus atuasse como juiz. Vamos ver a resposta de Jesus:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("E os Respondeu Jesus: Homem, quem me designou juiz ou árbitro entre vocês? Então lhes disse: Cuidado! Fiquem de sobreaviso contra todo tipo de ganância; a vida de um homem não consiste na quantidade dos seus bens."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que significa ficar de sobreaviso? Médicos muitas vezes ficam de sobreaviso, isto é, eles podem ser chamados para trabalhar, mesmo estando de folga. Ele precisa estar vigiando, alerta para estar pronto, caso seja chamado. Jesus disse para ficarem de atentos com o quê? Com a ganância! O que é ganância? Vejam essa explicação de Jesus na parábola! (Fig.4.2)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Então lhes contou esta parábola: A terra de certo homem rico produziu muito bem. Ele pensou consigo mesmo: O que vou fazer? Não tenho onde armazenar minha colheita."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Ele ficou preocupado! Preocupado por quê? Porque tinha demais e não tinha onde guardar! Será que existem pessoas que tem esse tipo de preocupação? Sim, e muitas! Muitas pessoas se preocupam em acumular cada vez mais riquezas. Agora me respondam, elas são prósperas? Com relação as riquezas sim! Mas o que falta na vida delas? Agora pense se você estivesse no lugar desse homem, o que você faria?"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Vejamos o que o homem fez: (Fig.4.3)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Então disse: Já sei o que vou fazer. Vou derrubar os meus celeiros e construir outros maiores, e ali guardarei toda a minha safra e todos os meus bens. E direi a mim mesmo: Você tem grande quantidade de bens, armazenados para muitos anos. Descanse, coma, beba e alegre-se."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que você acha disso? Você faria isso? Por quê? Por quê não? Olhem o que Deus disse sobre isso:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Fig.4.4) Contudo, Deus lhe disse: Insensato! Esta mesma noite a sua vida lhe será exigida. Então, quem ficará com o que você preparou?"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Parece que nem filhos esse homem tinha, talvez não era importante para ele casar e ter filhos. O que era a coisa mais importante para ele? Sua produção, seu dinheiro! Talvez, para ele, prosperidade, seria ter cada vez mais e não dividir! Mas o que diz a Palavra? Olhem a conclusão de Deus:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Assim acontece com quem guarda para si riquezas, mas não é rico para com Deus. Lucas 12:13-21"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que Deus quis dizer? Que existe outro tipo de riqueza que não tem nada a ver com bens? O que quer dizer ser rico para com Deus? Que tipo de prosperidade é essa? Exatamente, é o segundo signicado, ser feliz, afortunado, bem sucedido. Se sentir seguro e em paz com Deus! O que você quer para sua vida? Ser rico de bens ou ser rico para com Deus, sendo alegre, aprendendo, obedecendo, e agradecendo pelo muito ou pelo pouco. Quando somos ricos para com Deus, estamos sempre bem! E se for da vontade de Deus, você pode ser os dois! Tenho 2 versículos aqui. Escrevam nesse papel, com suas palavras, o que cada versículo está dizendo: (Peça que abram suas bíblias em Habacuque 3:17-19 e I Timóteo 6:6-8.)"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que estes versículos dizem? (Compartilhem) Agora me respondam o que a Tv, a internet e os amigos dizem? Que significado de prosperidade é ensinado? Para você, agora, o que é ser próspero?"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Vejam que notícia boa escrita nesta profecia:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Ele julgará entre muitos povos e resolverá contendas entre nações poderosas e distantes. Das suas espadas, farão arados, e das suas lanças, foices. Nenhuma nação erguerá a espada contra outra, e não aprenderão mais a guerra. Todo homem poderá sentar-se debaixo da sua videira e debaixo da sua figueira, e ninguém os incomodará, pois assim falou o Senhor dos Exércitos. Miquéias 4:1-4"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Deus promete aos que creem uma situação melhor do que a do povo na época de Salomão por que Ele promete  que ninguém nos incomodará! Estaremos prósperos em Deus! Não mais injustiça, não mais doenças, não mais tristeza...Eternamente! Glória a Deus!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Evoluindo:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Senhor muito obrigado pelo que temos, nos ajude a ser gratos em todo o tempo e que possamos sempre buscar ser ricos para com Deus, buscando conhecer ao Senhor mais e mais! para que vivamos felizes e em paz!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 2"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("A riqueza e a honra vêm de ti; tu dominas sobre todas as coisas. Nas tuas mãos  estão a força e o poder para exaltar e dar força a todos. 1 Crônicas 29:12"), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Missão Extra"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Vamos compartilhar os ensinos de provérbios 1. Cada um lê o que aprendeu e o versículo onde aprendeu, eu irei anotar e o grupo que conseguiu perceber mais ensinamentos ganha!"), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 2- O Ouro dos Tolos"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* O que é o Ouro dos Tolos?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quais são as 3 Piritas da Vida?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como surgem esses Piritas?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como evitar a Pirita da força e do poder?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como evitar a Pirita da riqueza?"), 0, 'J');
$pdf->ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo(a) - " . $nome_usuario, 0, 1, 'J');
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
$pdf->Cell(50, 20, utf8_decode("5. Lírio x Narciso – Beleza"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Germinando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Hoje, vamos conversar sobre mais um valor, a beleza. O que é beleza para as pessoas em geral? Que coisas vocês acham bonitas? Que pessoas vocês acham bonitas? O que as pessoas levam mais em conta quando vão avaliar se uma coisa é bonita ou não? E Uma pessoa? O que é levado em conta? Geralmente coisas são avaliadas pelas cores, harmonia, se são bem feitas, se fazem nos sentir bem, alegres, se nos inspiram a sermos melhores..."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("(Fig.5.1) As pessoas são avaliadas da mesma maneira? Ou só olhamos a aparência? A forma? O que é avaliado nos rapazes? Cabelo, pele, roupa, sapatos,físico? E nas meninas? Cabelo, unhas, pele, roupas, maquiagem... As pessoas se preocupam sempre com a aparência. As vezes agem como se a aparência fosse tudo. Esse comportamento lembra o do Narciso. Segundo o mito Grego, Narciso era um jovem tão belo e tão vaidoso que, após desprezar inúmeras pretendentes, acabou se apaixonando pelo próprio reflexo. Morreu de fome e sede à beira da fonte de água onde via sua imagem refletida. Existe uma flor com o nome do Mito. E a Bíblia? Será que ela nos fala de beleza? Vamos nos energizar na Palavra para cumprirmos nossas penúltimas missões."), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Energizando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Vamos dar uma olhada na família de Davi. Davi teve 17 filhos homens e muitas filhas mulheres com várias esposas e suas servas. Amnom foi seu primogênito, Absalão foi seu terceiro filho e sua irmã se chamava Tamar. Olhem como Absalão é descrito na bíblia:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Em todo o Israel não havia homem tão elogiado por sua beleza como Absalão. Da cabeça aos pés não havia nele nenhum defeito. 2 Sm 14:25"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Conseguem imaginar uma pessoa sem defeito e linda? (Fig 5.1) Seus cabelos eram compridos e pesavam 2 kilos. Mas o que a Palavra nos diz sobre a beleza? Só existe beleza física? I Cr 16:29 - Beleza que emana da Santidade; Ez 27:10 – Beleza que emana da Grandeza (Majestade); Gn 1:31 – Beleza que emana do bom. A quem podemos atribuir esses atributos com perfeição? Só à Deus! Mas podemos buscar a santidade e a bondade? Vamos ver mais versos sobre beleza (Peça que cada um leia uma passagem):"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Et 1:11 – Beleza que emana da forma ou aparência; Pv 20:29 – Beleza da força; Pv 31:30 – Beleza do temor; I Pe 3:3-4 – Beleza da Pureza; Is 61:10 - Beleza da salvação, Beleza da retidão; Pv 15:13a - Beleza da alegria; Ec 8:1b – Beleza da sabedoria e Is 52:7 – Beleza do testemunho da Paz. Essas belezas podemos ter? Com qual delas podemos nascer? As outras, posso desenvolver? Qual as únicas que são passageiras? Leiam Pv 31:30 e Sl 71:9 - Quantos anos vão durar sua aparência e sua força física? Que tipo de beleza tinha Absalão? Vamos continuar a conhecê-lo?"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Amnom, fez algo muito errado contra sua meia irmã Tamar, irmã de Absalão. Ele abusou dela, isso está relatado em II Sm 13. Ela contou a Absalão e ele deveria ter comunicado ao seu pai, o Rei Davi, para que Amnom fosse obrigado a reparar o que tinha feito. Segundo a lei, Amnom seria obrigado a casar-se com ela ou morrer, nesse caso, ela não conseguiria mais casar. Porém, vejamos o que aconteceu:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Absalão, seu irmão, lhe perguntou: 'Seu irmão, Amnom, lhe fez algum mal? Agora, acalme-se, minha irmã; ele é seu irmão! Não se deixe dominar pela angústia'. E Tamar, muito triste, ficou na casa de seu irmão Absalão. 2 Sm 13:20"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Tamar foi ignorada e Absalão escondeu o que havia acontecido de Davi."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Ao saber de tudo isso, o rei Davi ficou furioso. E Absalão não falou nada com Amnom, nem bem, nem mal, embora o odiasse por ter violentado sua irmã Tamar. 2 Sm 13:21,22"), 0, 'J');

//$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Dois anos depois, Absalão armou uma cilada para Amnom e mandou matar seu irmão pelo que ele fizera com Tamar. Será que ele pensou em sua irmã? Ele seguiu a lei que Deus havia dado para proteger as mulheres em caso de abuso? Ele agiu com a verdade? Lembra das belezas? Que belezas sobraram para Absalão? Vamos voltar à história: (Fig.5.2)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Assim os homens de Absalão mataram Amnom, obedecendo às suas ordens. Então todos os filhos do rei montaram em suas mulas e fugiram. Estando eles ainda a caminho, chegou a seguinte notícia ao rei: 'Absalão matou todos os teus filhos; nenhum deles escapou'. O rei levantou-se, rasgou as suas vestes, prostrou-se, e todos os conselheiros que estavam com ele também rasgaram as vestes. Mas, Jonadabe, filho de Siméia, irmão de Davi, disse: 'Não pense o meu senhor que mataram todos os teus filhos. Somente Amnom foi morto. Essa era a intenção de Absalão desde o dia em que Amnom violentou Tamar, irmã dele.' 2 Sm 13:29-32"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Absalão fugiu para seu avô que era rei de Gesur, pois, pela lei, Absalão deveria ser morto por ter matado seu irmão. Davi ficou muito irado e chorou a morte de seu filho. 3 anos depois Davi perdoou a Absalão mas não queria trazê-lo de volta. Um dia, Joabe, usou uma mulher para convencer Davi que ele estava errado em não querer que Absalão voltasse. Davi permitiu sua volta mas não permitiu que o visse senão estaria dando mal exemplo para o povo."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Absalão constituiu família, mas queria ver seu pai, o rei. Então tentou convencer Joabe mas ele se negou a ir até o rei"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Então Absalão disse a seus servos: 'Vejam, a propriedade de Joabe é vizinha da minha, e ele tem uma plantação de cevada. Tratem de incendiá-la'. E os servos de Absalão puseram fogo na plantação. 2 Sm 14:30 "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que essa atitude de Absalão demonstra? Ele estava arrependido? Ele havia mudado? Como ele queria que fossem as coisas?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Então Joabe foi contar tudo ao rei. Este mandou chamar Absalão, que entrou e prostrou-se, rosto em terra, perante o rei. E o rei saudou-o com um beijo. 2 Sm 14:33 (Fig.5.3)"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Um tempo depois, Absalão adquiriu uma carruagem, cavalos e uma escolta de cinqüenta homens. Ele se levantava cedo e ficava junto ao caminho que levava à porta da cidade. Sempre que alguém trazia uma causa para ser decidida pelo rei, Absalão o chamava e perguntava de que cidade vinha. A pessoa respondia que era de uma das tribos de Israel, e Absalão dizia: 'A sua causa é válida e legítima, mas não há nenhum representante do rei para ouvi-lo'. E Absalão acrescentava: 'Quem me dera ser designado juiz desta terra! Todos os que tivessem uma causa ou uma questão legal viriam a mim, e eu lhe faria justiça'. 2 Sm 15:1-4"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que Absalão estava pretendendo? Tomar o lugar de seu pai? 4 anos depois ele juntou um exercito contra seu pai. Davi precisou fugir, mas o Senhor lhe deu sabedoria e estratégia e o abençoou e seu exercito ganhou a batalha contra Absalão. (Fig.5.4)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Durante a batalha, Absalão, montado em sua mula, encontrou-se com os soldados de Davi. Passando a mula debaixo dos galhos de uma grande árvore, Absalão ficou preso pela cabeça nos galhos. Ele ficou pendurado entre o céu e a terra, e a mula prosseguiu. 2 Sm 18:9"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Um soldado foi avisar a Joabe e ele foi até Absalão e o matou. Vocês lembram do Narciso? Como Absalão foi morto? Por sua beleza! Ele poderia ter cortado seus cabelos com a espada enquanto Joabe não vinha. Admirar a beleza de sua aparência em excesso pode lhe destruir, pois tira o seu foco de Deus!"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Olhem o que Jesus falou  em Lucas 12:27 -"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Observem como crescem os lírios. Eles não trabalham nem  tecem. Contudo, eu lhes digo que nem Salomão, em todo o seu esplendor, vestiu-se como um deles. Se Deus veste assim a erva do campo, que hoje existe e amanhã é lançada ao fogo, quanto mais vestirá vocês, homens de pequena fé! Lc 12:27 e 28"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Por quê Jesus usou o lírio? Lírios são flores bonitas, mas simples. Havia lírios em todo lugar, em Israel. Algo interessante sobre os lírios - Suas flores vem direto das raízes, não das folhas e caules. De onde vem a verdadeira beleza? E a beleza da aparência, o que acontece com ela, dura para sempre? Para onde você começará a olhar? A beleza verdadeira glorifica a Deus pois reflete Seus atributos! Evolua em beleza!"), 0, 'J');

//$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Evoluindo:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Senhor nos ajude a escaparmos da armadilha de buscarmos a única beleza que se acaba e coloque em nosso coração o desejo de evoluirmos e de buscar a beleza que levaremos para a eternidade!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 3"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Assim, eu lhes digo, e no Senhor insisto, que não vivam mais como os gentios, que vivem na futilidade dos seus pensamentos. Eles estão obscurecidos no entendimento e separados da vida de Deus por causa da ignorância em que estão, devido ao endurecimento dos seus corações. Ef 4:17,18"), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 3- O Espelho da Morte x Espelho da Vida"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que significa olhar para o Espelho da Morte?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Que significa olhar para o Espelho da Vida?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Qual espelho conduz ao medo? Qual conduz à segurança?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O quê o Medo produz? E a segurança?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Qual a chave do Espelho da Vida?"), 0, 'J');
$pdf->ln(10);

// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo(a) - " . $nome_usuario, 0, 1, 'J');
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
$pdf->Cell(50, 20, utf8_decode("6. Oliveira – Saúde"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Germinando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Vocês já descobriram qual o Espelho da vida? E o da morte? Hoje vamos dar mais algumas dicas, e o valor sobre o qual vamos conversar é a saúde. A nossa árvore de hoje produz um fruto que, tanto dá sabor quanto saúde. Para dar sabor, ele se come inteiro ou espremido, para conceder saúde, ele deve ser espremido e o óleo que sai dele, cura tanto o corpo quanto a alma. O que é? É a Oliva (Fig 6.1.) Nós a conhecemos como azeitona. Mas cuidado para não confundir a azeitona com o jambolão que é doce e parece uma azeitona preta. Vamos ver o que podemos conhecer sobre a Oliveira."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Oliveiras são árvores milenares, O que significa isso? Que elas vivem mais de 1000 anos. - Cada arvore adulta dá em media 10 kilos de azeitona a cada florada e é o necessário para fazer 1 litro de azeite. (entendeu porque o azeite é caro?) -  A azeitona é colhida dentro de uma janela de 3 dias, depois disso, elas começam a fermentar e a pureza é afetada. Mas, o que a Bíblia nos ensina a respeito da Oliveira?"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Energizando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Providenciar um limão e um espremedor manual ou use a mão) (Fig. 6.2) Quem sabe o que foi o Tabernáculo? Foi a morada de Deus na terra, construído pelos israelitas e conforme as ordens de Deus. Ele tinha 3 partes: O pátio, onde eram feitos os sacrifícios no altar e onde havia uma pia; (Fig. 6.3) O local chamado Santo, onde havia  um candelabro com azeite, uma mesa com 12 pães e vinho e um altar onde se queimava incenso; e o Santo dos Santos, onde ficava a Arca da Aliança com as tábuas da lei, a vara de Arão e um vaso com um pouco do maná."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Vamos focar no lugar Santo. O Candelabro era uma peça chave e deveria estar aceso 24 horas por dia, sem apagar, pois ele iluminava as outras peças. Em Ex 27:20, Deus ordenou o povo para trazer do primeiro e mais puro óleo de oliva para colocar no Candelabro. "), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Cada peça do tabernáculo representa algo referente ao plano de Deus. Os pães e o vinho representam quem? Corpo e sangue de Cristo. Ok e o pão pode ser relacionado a quê também? A Palavra! O incenso está relacionando com as nossas orações que sobem até Deus. Pensando nisso, me digam o quê ou quem o Candelabro representa. Quem ilumina a compreensão da Palavra e nos auxilia em nossas orações? O Espírito Santo!"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Ok, Mas o que ele tem a ver com óleo? O processo para fazer o óleo era o seguinte. As azeitonas deveriam ser batidas, como no pilão, e colocadas numa cesta para o primeiro óleo escorrer. Esse era o azeite ou óleo do candelabro. Depois as olivas eram prensadas por uma pedra enorme e mais óleo saia e este era usado para ungir pessoas doentes e reis. Depois, pressionavam os restos, ainda mais, e o que saia era usado para manter o fogo para cozinhar. A pressão, como dizem algumas pessoas, “era até o talo”. Quem aqui gostaria de tomar o lugar de uma azeitona? Mas a pressão só pode ser física?"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Vamos pensar no nosso dia a dia. Você já sentiu momentos de pressão? Gostaria de compartilhar?  Geralmente, quando você é pressionado e passa por momentos difíceis na sua vida o que sai de você? Raiva, tristeza, desespero? Esses sentimentos são bons para sua alma e seu corpo? Vamos olhar o que Davi sentiu quando estava pressionado por seus próprios pecados. Davi, no seu momento azeitona. Vamos ler o Sl 38:1-14 e cada um lê um versículo e a cada sintoma físico ou emocional, quem leu, deve espremer um pouco o limão e depois passar o espremedor adiante. (Faça a dinâmica)"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Essa foi a lista: Dor, peso, corpo enfermo, feridas, abatimento, choro, febre, desânimo, gemidos, coração acelerado, olhos sem brilho, solidão, abandono, apatia. Como ficou o nosso limão? Ficou só o bagaço! Assim ficam as azeitonas! O que devemos fazer para retirar a pressão dos pecados? Mas será que só nos sentimos pressionados quando pecamos? O que mais pode nos pressionar? As pessoas, o padrão do mundo, o pecado de outros... Quem foi pressionado até a morte por causa de nossos pecados?"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("(Fig. 6.4) O quê Jesus sentiu? Medo, dor, ele suou sangue. Mas Ele sentiu também paz e glorificou a Deus quando estava na cruz. Podemos nos sentir assim também em nossos momentos azeitona? De onde vem o  poder para se sentir em paz? E, o que será que acontece com a saúde emocional e física de quem vive em paz e alegria? Será que conseguimos essa saúde indo para academia? Será que conseguimos essa paz e alegria fazendo dieta? Que milagre é esse? Esse milagre, essa saúde, vem com a ajuda de quem Jesus derrama sobre nós quando cremos.  Lembra? Para que o Espírito Santo viesse sobre os que crêem Ele precisou ser a oliva, pressionado até a morte. Por mim e por você! Você já creu? Tem ouvido o E.S.?"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->MultiCell(0, 15, utf8_decode("Agora vamos ler o Salmo 23 e vocês vão descobrir como Ele nos dá a verdadeira saúde. Foi o segredo de Davi. Eu não vou falar, vocês vão ouvir a leitura e depois de cada versículo eu vou dar 15 segundos para vocês colocarem no papel verdades sobre o Espírito Santo e nossa saúde espiritual, emocional e física. Vai ser como a brincadeira do STOP. (Leia dando intervalos de 15 segundos e no final diga STOP)"), 0, 'J');

$pdf->SetFont('arial', 'BI', 12);
$pdf->MultiCell(0, 15, utf8_decode("Vs 1- O Senhor é o meu pastor e nada me faltará"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O E.S. me dirige, Deus supre o que preciso"), 0, 'J');

$pdf->SetFont('arial', 'BI', 12);
$pdf->MultiCell(0, 15, utf8_decode("Vs 2 - Ele me faz repousar em pastos verdejantes"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O E.S. me tranquiliza, e alimenta com a Palavra"), 0, 'J');

$pdf->SetFont('arial', 'BI', 12);
$pdf->MultiCell(0, 15, utf8_decode("Leva-me para junto das águas tranquilas"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O E.S. me ajuda a beber da Palavra"), 0, 'J');

$pdf->SetFont('arial', 'BI', 12);
$pdf->MultiCell(0, 15, utf8_decode("Vs 3 – Refrigera a minha alma"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Me dá alivio"), 0, 'J');

$pdf->SetFont('arial', 'BI', 12);
$pdf->MultiCell(0, 15, utf8_decode("Guia-me pela vereda da justiça por amor do Seu nome"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Me ajuda a ser justo"), 0, 'J');

$pdf->SetFont('arial', 'BI', 12);
$pdf->MultiCell(0, 15, utf8_decode("Vs 4 - Ainda que eu ande pelo vale da sombra da morte"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mesmo quando tenho medo e sou pressionado"), 0, 'J');

$pdf->SetFont('arial', 'BI', 12);
$pdf->MultiCell(0, 15, utf8_decode("Não temerei mal nenhum porque Tú estás comigo"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Não devo temer porque o E.S. está comigo"), 0, 'J');

$pdf->SetFont('arial', 'BI', 12);
$pdf->MultiCell(0, 15, utf8_decode("A Tua vara e o Teu cajado me consolam"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Ele me guia e me afasta do que é mal"), 0, 'J');

$pdf->SetFont('arial', 'BI', 12);
$pdf->MultiCell(0, 15, utf8_decode("Vs 5 - Preparas uma mesa na presença dos meus inimigos"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O E.S. me fortalece diante de inimigos"), 0, 'J');

$pdf->SetFont('arial', 'BI', 12);
$pdf->MultiCell(0, 15, utf8_decode("Unges minha cabeça com óleo e o meu cálice transborda"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Ele cuida de minhas feridas e me supre"), 0, 'J');

$pdf->SetFont('arial', 'BI', 12);
$pdf->MultiCell(0, 15, utf8_decode("Vs 6 - Bondade e misericórdia me seguirão todos os dias da minha vida"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Sua presença é eterna"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Sabe o que acontece se você sempre se lembrar dessas verdades? Você estará ungindo a sua cabeça com o óleo do Espírito Santo, enchendo a sua mente de paz, segurança e alegria. Lembram do Candelabro? Sem ele como alguém poderia enxergar as outras coisas? Sem o Espírito Santo alguém pode entender a Palavra? Alguém pode orar da maneira certa? Vem de nós a verdadeira saúde? De quem dependemos? E qual a melhor maneira de demonstrar nossa dependência de Deus? O quê que sai de nós e sobe até Deus?  Nossas orações! Se eu chorar diante de Deus quando me sinto pressionado ou triste o que acontece? E se eu não orar, se eu não colocar para Deus as minhas dores? Ele vai ungir minhas feridas com óleo do E.S.? Vou ter a verdadeira saúde? Você está se sentindo pressionado? O que lhe pressiona? As vezes tentamos fugir da pressão, simplesmente fingindo que está tudo bem ou reagindo com raiva e desespero. Ore agora e diga a Deus como está se sentindo, peça que o Senhor coloque o consolo, a paz e a alegria do seu Espírito em seu coração! Peça a Deus também que você possa ser oliveira produzindo cura na vida de outros, apresentando Jesus, aquele que pode curar os corações dos pecados e seja forte e saudável no Senhor! (Peça às crianças que orem em silêncio e depois ore!)
				"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Evoluindo:"), 0, 1, 'L');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Senhor me ajude a ser como Jesus, que quando pressionado transbordou paz. Me ajude a buscar auxílio na Palavra confiando que o Espírito Santo de Deus me ilumina, me alimenta e nutre meu espírito e minhas emoções. Me ajude a ter um coração saldável!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 3"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Assim, eu lhes digo, e no Senhor insisto, que não vivam mais como os gentios, que vivem na futilidade dos seus pensamentos. Eles estão obscurecidos no entendimento e separados da vida de Deus por causa da ignorância em que estão, devido ao endurecimento dos seus corações. Ef 4:17,18"), 0, 'J');

$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 3- O Espelho da Morte x Espelho da Vida"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que significa olhar para o Espelho da Morte?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Que significa olhar para o Espelho da Vida?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Qual espelho conduz ao medo? Qual conduz à segurança?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O quê o Medo produz? E a segurança?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Qual a chave do Espelho da Vida?"), 0, 'J');
$pdf->ln(10);

// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo(a) - " . $nome_usuario, 0, 1, 'J');
// I - Lição 05

$pdf->AddPage();

// I - Lição 07
//Capa

$pdf->SetFont('arial', 'B', 18);

$pdf->Cell(0, 0, utf8_decode("Lição 07"), 0, 0, 'C');

$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(50, 20, utf8_decode("7. Árvore do Conhecimento do Bem e do Mal - Liberdade"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Germinando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Prepare 2 caixas de sapato ou maior, em uma aberta, vocé pode colocar coisas como chocolate, chips, bolo.... A outra deve ter uma abertura em forma de circulo onde só uma mão pode entrar. Dentro da caixa coloque uma fruta ou outra coisa grande, de modo que se a pessoa colocar a mão ela vai pegar, mas não conseguirá tirar o objeto. Receba a todos e diga que tem algo para eles, mostre as caixas e diga que eles podem pegar o que quiserem da caixa aberta, mas da outra não devem pegar. Conversem enquanto eles comem da caixa aberta. Diga que precisa pegar sua Bíblia e os deixe sós com a caixa)"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("E então? Voces gostaram das coisas que estavam na caixa aberta? Alguém ficou curioso com a caixa prtoibida? Alguém tentou olhar dentro? Pegar o que está dentro? Alguém gostaria de tentar? (No caso de alguém querer, deixe que coloque a mão e tente tirar o que está na caixa). Você pegou o que está ai? Consegue tirar? Está satisfeito? Por que não? O que aconteceu? Como você vai tirar sua mão? (Para retirar a mão a criança precisa largar o que pegou) Vamos pensar sobre essa experiência enquanto conversamos sobre a nossa penúltima árvore!!! "), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Energizando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Fig.7.1) Essa árvore estava plantada no meio do jardim do Éden. Lembram do nome? Árvore do Conhecimento do Bem e do Mal. Nós já conversamos sobre essa árvore no mergulho, lembram? O que foi que Deus disse com relação a ela? Vamos ler Gênesis 2:16,17? "), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("E o Senhor Deus ordenou ao homem: 'Coma livremente de qualquer árvore do jardim, mas não coma da árvore do conhecimento do bem e do mal, porque no dia em que dela comer, certamente você morrerá.'"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que Deus está dizendo na primeira parte do verso? Eles tinham liberdade para comer de tudo?  O que é Liberdade? Vou colocar algumas definições aqui:"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("- Ser livre para fazer o que quiser na hora que quiser"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("- Ser livre de controle ao fazer escolhas"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("- Ser livre de qualquer controle do mal"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("- Direito de agir segundo a sua própria vontade desde que não prejudique outros"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Escolha o que você acha que é a verdadeira definição. Vamos falar dela e da caixa depois de conhecermos a história de 2 jovens. Abram em II Reis 5 (Fig.7.2)"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Naamã, comandante do exército do rei da Síria, era muito respeitado e honrado pelo seu senhor, pois por meio dele o Senhor dera vitória à Síria. Mas esse grande guerreiro ficou leproso. Ora, tropas da Síria haviam atacado Israel e levado cativa uma menina, que passou a servir à mulher de Naamã."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Já imaginou a situação dessa mocinha? Ela foi tirada de sua família para ser o quê? Vocês acham que ela se sentia livre? Escutem..."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Um dia ela disse à sua senhora: 'Se o meu senhor procurasse o profeta que está em Samaria, ele o curaria da lepra'. "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que vocês acham da atitude dela? O que você faria se estivesse no lugar dela. Teria ajudado? Sabem o que aconteceu? Naamã foi contar ao rei da Síria  e ele lhe deu uma carta para o rei de Israel. Então Naamã partiu, levando um tesouro e a carta que pedia ao rei para ele curar Naamã. O Rei ficou bravo quando leua a carta, porque ele não era Deus para curar. Então o profeta Eliseu disse ao Rei que enviasse Naamã até ele. Vamos ler..."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Eliseu enviou um mensageiro para lhe dizer: Vá e lave-se sete vezes no rio Jordão; sua pele será restaurada e você ficará purificado. Mas Naamã ficou indignado e saiu dizendo: Eu estava certo de que ele sairia para receber-me, invocaria de pé o nome do Senhor seu Deus, moveria a mão sobre o lugar afetado e me curaria da lepra."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Não são os rios Abana e Farfar, em Damasco, melhores do que todas as águas de Israel? Será que não poderia lavar-me neles e ser purificado? Então, foi embora dali furioso. Mas os seus servos lhe disseram: Meu pai, se o profeta lhe tivesse pedido alguma coisa difícil, o senhor não faria? Quanto mais, quando ele apenas lhe diz para que se lave e seja purificado! (Fig.7.3)"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Assim ele desceu ao Jordão e mergulhou sete vezes conforme a ordem do homem de Deus; ele foi purificado e sua pele tornou-se como a de uma criança! "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Quem ajudou Naamã a ficar curado? Alguém mandou ela ajudar Naamã? De quem foi a escolha? Então ela estava livre para escolher? Por que vocês acham que ela escolheu ajudar? E se ela escolhesse ficar com raiva e não falar? Vamos continuar, porque mais alguém na história vai fazer uma escolha. Naamã foi a casa de Eliseu e lhe ofereceu muitos presentes.  Naamã insistiu mas Eliseu não quis o tesouro."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Quando Naamã já estava a certa distância, Geazi, servo de Eliseu, o homem de Deus, pensou: Meu senhor foi bom demais para Naamã, aquele arameu, não aceitando o que ele lhe ofereceu. Juro pelo nome do Senhor que correrei atrás dele para ver se ganho alguma coisa."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Então Geazi correu para alcançar Naamã, que, vendo-o se aproximar, desceu da carruagem para encontrá-lo e perguntou: Está tudo bem?  Geazi respondeu: Sim, tudo bem. Mas o meu senhor enviou-me para dizer que dois jovens, discípulos dos profetas, acabaram de chegar, vindos dos montes de Efraim. Por favor, dê-lhes trinta e cinco quilos de prata e duas mudas de roupas finas."), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Isso era verdade? Parece que Geazi enfiou a mão na caixa, ele comeu da árvore que não era para comer! Naamã deu a Geazi 70 kilos de tesouro e roupas e ainda mandou pessoas ajudarem ele a levar. Quando Geazi chegou à colina onde morava, pegou as sacolas dos servos e guardou-as em casa. Mandou os homens de volta, e eles partiram. Geazi era escravo como a menina? Não, ele era servo, com certeza tinha um salário. Ele era livre para fazer suas escolhas e o que ele escolheu? Vamos ver o resultado:"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Então entrou e apresentou-se ao seu senhor Eliseu. E este perguntou: Onde você esteve, Geazi?  Geazi respondeu: Teu servo não foi a lugar algum. Mas Eliseu lhe disse: Você acha que eu não estava com você em espírito quando o homem desceu da carruagem para encontrar-se com você? (Fig.7.4)"), 0, 'J');

$pdf->SetFont('arial', 'IB', 12);
$pdf->MultiCell(0, 15, utf8_decode("Este não era o momento de aceitar prata nem roupas, nem de cobiçar olivais, vinhas, ovelhas, bois, servos e servas. Por isso a lepra de Naamã atingirá você e os seus descendentes para sempre. Então Geazi saiu da presença de Eliseu já leproso, parecido com neve. 2 Reis 5:1-27"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Geazi conhecia Deus? Ele morava com o profeta já devia ter ouvido falar de Deus várias vezes e visto muitos milagres. Mas ele realmente conhecia Deus? E a mocinha?  Lembram das caixas? Que caixa Geazi escolheu? O que essa caixa representa? A desobediência, o pecado. Quando você escolhe pecar o que acontece? O que aconteceu com sua mão na caixa? Você fica preso a ele! E quando você se liberta? Agora pense na resposta sobre a definição de liberdade e me digam quem tinha mais liberdade? A escrava ou o “livre”? Porque? Vamos fechar os olhos."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Como você estã agora? Está preso em alguma caixa? Você conhece a Deus? Deus lhe quer livre? Lembre, a escolha é sua! A escolha foi de Eva. Ela era livre para escolher e escolheu comer da árvore do conhecimento do bem e do mal. Mas depois que pecou, como ela ficou? Abaixe a sua cabeça e responda em seu coração. "), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que liberta? Conhecer drogas? Conhecer o sexo? Conhecer o proibido? Conhecer a mentira? A inveja? A pornografia? Conhecer o mal? Você reconhece que Deus é o bem? Para que você quer conhecer o mal? Conhecer o que vai te te aprisionar vai ter trazer liberdade? Você quer orar agora e se livrar do pecado? Quer se afastar dessa árvore maldita? Quer parar de ouvir a serpente colocando dúvidas sobre o amor de Deus? Vamos orar!"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Evoluindo:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Senhor me perdoe por tantas vezes virar as costas para o bem e para o Teu amor e querer conhecer o mal. Senhor me perdoe, eu quero agora tirar minha mão, meus ouvidos, minha boca, meu corpo, minha mente de tudo que me aprisiona e me destrói. Eu quero conhecer o Senhor, quero conhecer mais e mais a tua Palavra para que mais e mais eu seja livre do pecado. Em nome de Jesus!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 4"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Disse Jesus aos judeus que haviam crido nele: Se vocês permanecerem firmes na minha palavra, verdadeiramente serão meus discípulos. E conhecerão a verdade, e a verdade os libertará. João 8:31,32"), 0, 'J');

$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 4 - A Chave da Evolução"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que chave é essa?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem possui essa chave?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Para onde essa evolução leva?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como evoluímos?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quando essa evolução irá terminar?"), 0, 'J');
$pdf->ln(10);

// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo(a) - " . $nome_usuario, 0, 1, 'J');
// I - Lição 07

$pdf->AddPage();

// I - Lição 08
//Capa
$pdf->SetFont('arial', 'B', 18);

$pdf->Cell(0, 0, utf8_decode("Lição 08"), 0, 0, 'C');

$pdf->Ln(10);

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

//Título da Lição
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(50, 20, utf8_decode("8. Árvore da Vida – Vida"), 0, 1, 'L');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Germinando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("(Distribua 5 pedaços de papel) O que vem à sua cabeça quando você pensa na palavra VIDA? Escreva nesses 4 pedaços de papel palavras que definam VIDA para você. Agora ouçam essas perguntas e respondam no ultimo pedaço de papel o número da pergunta e a letra que escolheu. (Fig.8.1)"), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("1 - O que é VIDA FÍSICA?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("a. Característica daquele que respira"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("b. Característica dos organismos que evoluem do nascimento até a morte"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("c. Tempo que vai do nascimento até a morte"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("d. Dom dado por Deus"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("e. Todas as alternativas acima (x)"), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("2 - O que é VIDA ETERNA? Baseie sua resposta em Jo 3:36"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("a. Tempo que vai do nascimento até a morte"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("b. Tempo que inicia no novo nascimento e continua depois da morte física"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("c. Dom dado por Deus"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("d. Vida sem fim"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("e. Só a letra “a” está errada (x)"), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("3 - O que é MODO DE VIVER?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("a. É o estilo de vida de uma pessoa"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("b. É o que coloco na minha agenda"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("c. São as regras que coloco para mim mesmo"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("d. É o comportamento que adoto baseado em minhas crenças e convicções"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("e. Todas as alternativas acima (x)"), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("4 - O que é VIDA EM ABUNDÂNCIA?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("a. Estar cheio do Espírito Santo"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("b. Viver de acordo com a eternidade e não de acordo com o momento"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("c. Usar o dom de Deus para Sua glória"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("d. Fazer o que nos deixa feliz"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("e. Todas exceto a D. (x)"), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Agora eu vou colocar as quatro definições citadas e vocês vão colocar seus papeis debaixo do termo que corresponde as suas respostas nos papéis. (Coloque sobre a mesa os termos em maiúsculo acima) Observem onde se encaixam a maioria dos papéis. (Podem discutir a razão)"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Energizando:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Nossa árvore é a Árvore da Vida, não vamos falar sobre ela, mas sim do seu fruto, a VIDA. O que é a VIDA? Vocês viram 4 definições, mas a maioria das pessoas só vive dentro de 2 delas, tempo de vida e modo de vida. Elas pensam na eternidade e na vida com Deus? Fazem quantos anos que sua vida física começou? Hoje vamos falar de uma adolescente, provavelmente 14 anos e um jovem entre 18 e 25. (Fig. 8.2) Como vive quem tem 14 anos hj? Estudo, amizades, namoro, .... E quem tem 18 a 25? Faculdade, profissão, amizades, casamento... Agora me diga, o seu modo de vida e pensamentos são diferentes dos outros adolescentes ou crianças? O que pensava uma adolescente na época de Jesus? Sobre com quem se casaria e como seria o casamento! Isso mesmo as meninas em Israel se casavam com 14 anos com rapazes mais velhos escolhidos pelos seus pais. A menina de quem vamos falar estava noiva! Já sabia com quem iria casar e que seu noivo fazia móveis. Bom nós não sabemos os detalhes, mas sabemos que o futuro casal acreditava em Deus e nas suas promessas. Que diferença isso faz na vida de alguém? Como deveria ser o modo de vida dela? O que acham meninas? E a vida dele? O que acham rapazes?"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Esses 2 jovens tinham algo diferente. Sabe como eu sei disso? Eles receberam uma mensagem direta de Deus. E não foi via e-mail, nem twitter e nem WhatsApp. Foi via mensageiro e não Messenger. Direto do céu! Como bons checadores de fatos, vamos checar essa informação. Abram suas Bíblias em Lc 1.26-38.' (Fig. 8.3)"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("No sexto mês Deus enviou o anjo Gabriel a Nazaré, cidade da Galiléia, a uma virgem prometida em casamento a certo homem chamado José, descendente de Davi. O nome da virgem era Maria. O anjo, aproximando-se dela, disse: 'Alegre-se, agraciada! O Senhor está com você!' Maria ficou perturbada com essas palavras, pensando no que poderia significar esta saudação."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Já imaginou um anjo na sua frente? O que quer dizer “Agraciada”? Cheia da graça? Graça quer dizer favor imerecido. Então Maria era especial porque era um ser mais santo ou diferente? Você ficaria perturbada? Com medo?"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mas o anjo lhe disse: 'Não tenha medo, Maria; você foi agraciada por Deus! Você ficará grávida e dará à luz um filho, e lhe porá o nome de Jesus. Ele será grande e será chamado Filho do Altíssimo. O Senhor Deus lhe dará o trono de seu pai Davi, e ele reinará para sempre sobre o povo de Jacó; seu Reino jamais terá fim'. Perguntou Maria ao anjo: 'Como acontecerá isso, se sou virgem?' O anjo respondeu: 'O Espírito Santo virá sobre você, e o poder do Altíssimo a cobrirá com a sua sombra. Assim, aquele que há de nascer será chamado santo, Filho de Deus. Também Isabel, sua parenta, terá um filho na velhice; aquela que diziam ser estéril já está em seu sexto mês de gestação. Pois nada é impossível para Deus'."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Como será que aquela notícia chegou para a adolescente Maria? Uma bomba! Que problemas poderia trazer para ela? Naquela época em Israel se uma moça tivesse relações com um rapaz antes de casar ela seria apedrejada até morrer. O que mudaria em seu modo de viver? Que riscos ela correria? Como você reagiria? Vamos ver o que Maria respondeu: Respondeu Maria: 'Sou serva do Senhor; que aconteça comigo conforme a tua palavra.' Como Maria definiu a si mesmo? Maria teve dúvidas? Qual? Como você vê a resposta dela? Ela era convicta de sua fé e de que sua vida estava nas mãos de Deus? Ela se dispôs a gerar dentro de sí quem tem poder para dar a VIDA ETERNA? Vamos falar agora com os rapazes. Abram em Mt. 1.18-25"), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("'Foi assim o nascimento de Jesus Cristo: Maria, sua mãe, estava prometida em casamento a José, mas, antes que se unissem, achou-se grávida pelo Espírito Santo. Por ser José, seu marido, um homem justo, e não querendo expô-la à desonra pública, pretendia anular o casamento secretamente.'"), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Maria contou a José, mas ele acreditou? O quê ele poderia ter feito? Segundo a lei ele teria o direito de expor ela, por que ele não fez isso? Em que baseou sua decisão? Foi difícil para ele? E se fosse você? Seguindo..."), 0, 'J');

$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mas, depois de ter pensado nisso, apareceu-lhe um anjo do Senhor em sonho e disse: 'José, filho de Davi, não tema receber Maria como sua esposa, pois o que nela foi gerado procede do Espírito Santo. Ela dará à luz um filho, e você deverá dar-lhe o nome de Jesus, porque ele salvará o seu povo dos seus pecados'."), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Tudo isso aconteceu para que se cumprisse o que o Senhor dissera pelo profeta: 'A virgem ficará grávida e dará à luz um filho, e lhe chamarão Emanuel' que significa 'Deus conosco'. Ao acordar, José fez o que o anjo do Senhor lhe tinha ordenado e recebeu Maria como sua esposa. Mas não teve relações com ela enquanto ela não deu à luz um filho. E ele lhe pôs o nome de Jesus."), 0, 'J');

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("O que vocês acham desse rapaz? Quais as convicções que ele tinha na vida dele? O que ele cria afetava suas decisões e comportamento?"), 0, 'J');

$pdf->MultiCell(0, 15, utf8_decode("Quantos anos você quer viver? O que você quer fazer com a sua vida? Já escolheu qual será o seu modo de viver? (Fig. 8.4) José e Maria eram diferentes de vocês? Acham que foi fácil para eles? Já imaginou casar e não tocarem um no outro? E a viagem grávida de 9 meses? E ter que fugir para não matarem seu filho? E a responsabilidade de criar o filho de Deus? E vê-lo morrer na cruz? Eles tiveram uma vida em abundância? A VIDA em submissão a Deus é que nos dá a VIDA abundante, o resto é só existência. Você quer Se submeter a Deus para ser usado por Ele e fazer parte de Seu plano? Assim acontece a verdadeira evolução, quando já não sou eu quem vive, mas Cristo vive em mim. Você quer isso? (Separe o próximo encontro para compartilhar seu testemunho de vida e desafiar seus discípulos a compartilharem também)"), 0, 'J');

//Tópico
$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(90, 20, utf8_decode("Evoluindo:"), 0, 1, 'L');

//Texto
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Oração - Senhor nos ajude a vivermos a Tua vida, de maneira abundante e para a glória do Teu nome!"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("Versículo para memorizar 4"), 0, 'J');
$pdf->SetFont('arial', 'I', 12);
$pdf->MultiCell(0, 15, utf8_decode("Disse Jesus aos judeus que haviam crido nele: Se vocês permanecerem firmes na minha palavra, verdadeiramente serão meus discípulos. E conhecerão a verdade, e a verdade os libertará. João 8:31,32"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->Ln(10);

$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 4 - A Chave da Evolução"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que chave é essa?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem possui essa chave?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Para onde essa evolução leva?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como evoluímos?"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quando essa evolução irá terminar?"), 0, 'J');
$pdf->ln(10);

// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo(a) - " . $nome_usuario, 0, 1, 'J');
// I - Lição 08

$pdf->AddPage();

// I - Resposta do Mistério

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
$pdf->MultiCell(0, 15, utf8_decode("Respostas de Mistérios - Expedição Verde 2 - A Evolução"), 0, 'C');

$pdf->Ln(8);
$pdf->Cell(0, 5, "", "B", 1, 'C');
$pdf->Ln(400);

// 01
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 1 - O Segredo da Evolução"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que segredo é esse? - Ler a Palavra, orar e confessar pecados"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como obter esse segredo? - Lendo a Palavra e se deixando transformar pelo Espírito"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como saber se descobriu o segredo? - Pelas atitudes"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que esse segredo produz? - Frutos de justiça a vida inteira"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O que acontece com quem não encontra o segredo? - Murcharão em sua vida com Deus"), 0, 'J');

$pdf->Image('../../capa.jpg', 50, 300, 500, 300);

$pdf->ln(10);

// 02
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 2- O Ouro dos Tolos"), 0, 'J');
$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* O que é o Ouro dos Tolos? - As piritas"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quais são as 3 Piritas da Vida? - Força, poder e riqueza"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como surgem esses Piritas? - No coração enganoso"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como evitar a Pirita da força e do poder? - Buscando a sabedoria de Deus"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como evitar a Pirita da riqueza? - Buscando o Reino primeiro, não tendo inveja e sendo grato"), 0, 'J');

$pdf->ln(10);

// 03
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 3 - O Espelho da Morte x Espelho da Vida"), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que significa olhar para o Espelho da Morte? - Focar no EU e em seus desejos e medos"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Que significa olhar para o Espelho da Vida?  - Focar no que a Palavra diz sobre mim"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Qual espelho conduz ao medo?  - O que foca no EU * Qual conduz à segurança? - A Palavra"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* O quê o Medo produz? - Fuga ou raiva * E a segurança? - Coragem e amor"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Qual a chave do Espelho da Vida?  - Ouvir e depender do Espírito Santo, que revela e aplica a Palavra em nós."), 0, 'J');

$pdf->ln(10);

// 04
$pdf->SetFont('arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode("Mistério 4 - A Chave da Evolução"), 0, 'J');

$pdf->Ln(10);

$pdf->MultiCell(0, 15, utf8_decode("* Que chave é essa? Submissão à verdade"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quem possui essa chave? Quem conhece a Deus"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Para onde essa evolução leva? Leva à santificação em Cristo"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Como evoluímos?  Sendo praticantes da Palavra de Deus"), 0, 'J');
$pdf->MultiCell(0, 15, utf8_decode("* Quando essa evolução irá terminar? Na vida eterna, quando formos perfeitos"), 0, 'J');

$pdf->ln(10);

// Select Arial italic 8
$pdf->SetFont('arial', 'I', 8);
// Print centered page number
$pdf->Cell(0, 10, "Este material impresso pelo(a) - " . $nome_usuario, 0, 1, 'J');

// F - Resposta do Mistério

$nome_relatorio = utf8_decode("Expedição Verde 2 - A Evolução");

$pdf->Output("$nome_relatorio.pdf", "I");
