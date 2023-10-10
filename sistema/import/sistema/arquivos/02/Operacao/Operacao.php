<?php

$usuario = $_GET['id_lider'];
$id_modulo = $_GET['id_modulo'];


$pdo = new PDO("mysql:host=localhost;dbname=u301957058_camp_brasil","u301957058_administrador","campBr202@");

require_once '../../../fpdf/fpdf.php';
 
$pdf= new FPDF("P","pt","A4");
			
		// Dados Líder
		$consultalider_sql = "SELECT * FROM lider WHERE id_lider LIKE :ID_USU";
		$consultalider = $pdo->prepare($consultalider_sql);
		$consultalider->bindValue(":ID_USU",$usuario);
		$consultalider->execute();
		$xL = $consultalider->rowCount();
		$dadoslider = $consultalider->fetch(PDO::FETCH_ASSOC);

		// Dados Coordenador
		$consultacoordenador_sql = "SELECT * FROM coordenador WHERE id_coordenador LIKE :ID_USU";
		$consultacoordenador = $pdo->prepare($consultacoordenador_sql);
		$consultacoordenador->bindValue(":ID_USU",$usuario);
		$consultacoordenador->execute();
		$xC = $consultacoordenador->rowCount();
		$dadoscoordenador = $consultacoordenador->fetch(PDO::FETCH_ASSOC);

		// Dados SR
		$consultasr_sql = "SELECT * FROM supervisorr WHERE id_supervisorR LIKE :ID_USU";
		$consultasr = $pdo->prepare($consultasr_sql);
		$consultasr->bindValue(":ID_USU",$usuario);
		$consultasr->execute();
		$xSR = $consultasr->rowCount();
		$dadossr = $consultasr->fetch(PDO::FETCH_ASSOC);

		// Dados SE
		$consultase_sql = "SELECT * FROM supervisore WHERE id_supervisorEs LIKE :ID_USU";
		$consultase = $pdo->prepare($consultase_sql);
		$consultase->bindValue(":ID_USU",$usuario);
		$consultase->execute();
		$xSE = $consultase->rowCount();
		$dadosse = $consultase->fetch(PDO::FETCH_ASSOC);

		// Dados Direção
		$consultadirecao_sql = "SELECT * FROM direcao WHERE id_direcao LIKE :ID_USU";
		$consultadirecao = $pdo->prepare($consultadirecao_sql);
		$consultadirecao->bindValue(":ID_USU",$usuario);
		$consultadirecao->execute();
		$xD = $consultadirecao->rowCount();
		$dadosdirecao = $consultadirecao->fetch(PDO::FETCH_ASSOC);

		// Dados Pais
		$consulta_pais_sql = "SELECT * FROM pais WHERE id_pais LIKE :ID_USU";
		$consulta_pais = $pdo->prepare($consulta_pais_sql);
		$consulta_pais->bindValue(":ID_USU",$usuario);
		$consulta_pais->execute();
		$xPais = $consulta_pais->rowCount();
		$dados_pais = $consulta_pais->fetch(PDO::FETCH_ASSOC);

		$nivel = "";
		$nome_usuario = "";

		if ($xPais == 0) {
			
		}else{
			$nivel .= "Usuário";
			$nome_usuario .= $dados_pais['nome_pais'];
		}

		if ($xL == 0) {
			
		}else{
			$nivel .= "Líder";
			$nome_usuario .= $dadoslider['nome_lider'];
		}

		if ($xC == 0) {
			
		}else{
			$nivel .= "Coordenador";
			$nome_usuario .= $dadoscoordenador['nome_coordenador'];
		}

		if ($xSR == 0) {
			
		}else{
			$nivel .= "Supervisor Regional";
			$nome_usuario .= $dadossr['nome_supervisorR'];
		}

		if ($xSE == 0) {
			
		}else{
			$nivel .= "Supervisor Estadual";
			$nome_usuario .= $dadosse['nome_supervisorE'];
		}
		
		if ($xD == 0) {
			
		}else{
			$nivel .= "Direção";
			$nome_usuario .= $dadosdirecao['nome_direcao'];
		}

			$consultarM_sql = "SELECT * FROM modulo WHERE id_modulo LIKE :ID";
			$consultarM = $pdo->prepare($consultarM_sql);
			$consultarM->bindValue(":ID",$id_modulo);
			$consultarM->execute();

			$modulo = $consultarM->fetch(PDO::FETCH_ASSOC);

				$pdf->AddPage();
				//$pdf->Image('logog8.jpg');
				$pdf->Ln(8); 
				$pdf->SetFont('arial','B',18);
				$pdf->Cell(0,5,utf8_decode("CAMP BRASIL"),0,1,'C');
				$pdf->Ln(8);
				$pdf->Cell(0,5,"","B",1,'C');
				$pdf->Ln(8);

				$pdf->Image('../../capa.jpg',50,300,500,300);

				$pdf->SetFont('arial','B',14);
				
				if ($xL != 0 OR $xD != 0) {
					$pdf->Cell(150,20,utf8_decode("$nivel:"),0,0,'J');
				}else{
					$pdf->Cell(150,20,utf8_decode("$nivel:"),0,0,'J');					
				}
				
				$pdf->Cell(0,20,utf8_decode($nome_usuario),0,1,'J');
				$pdf->Ln(8);

				$pdf->Cell(60,20,utf8_decode("Módulo:"),0,0,'J');
				$pdf->Cell(0,20,utf8_decode($modulo['nome_modulo']),0,1,'J');
				$pdf->Ln(8);

				$pdf->Ln(300); 
				$pdf->SetFont('arial','B',18);
				$pdf->Cell(0,5,utf8_decode("Máterial Operação Verde 1 - A Colheita"),0,1,'C');
				$pdf->Ln(8);
				$pdf->Cell(0,5,"","B",1,'C');

				// Página 2	
			
			$pdf->AddPage();
			
			// I - Lição 01	
				//Capa
				$pdf->SetFont('arial','B',18);
				$pdf->Cell(0,0,utf8_decode("Lição 01"),0,0,'C');
				$pdf->Ln(10);
				
				$pdf->Image('../../capa.jpg',50,300,500,300);

				//Título da Lição
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(50,20,utf8_decode("1. Árvore e Fruto - Jesus é a Videira"),0,1,'L');

				
				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Pegando os Cestos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Sobre o que conversamos na última aventura? Sobre tipos de solo e como fazer para ser um bom solo. Se uma árvore cresce em um bom solo, o que ela produz? Eu tenho aqui o nome de frutos e vocês dirão a que árvore ele pertence! (Manga, maçã, tomate, côco, uva, cajá) Agora eu tenho aqui outras palavras, vocês vão me dizer quem produz essas coisas:  imoralidade, impureza, indecência, idolatria, feitiçaria, ódio, discórdia, ciúmes, raiva, egoísmo, brigas, inveja, embriaguez. Esses são coisas que pessoas fazem. De onde elas vêm? Porque pessoas produzem coisas más?"),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("Gálatas 5:19 nos diz que essas são obras da carne! Mas porque não posso dizer que são frutos da carne? Porque fruto você cultiva como vocês fizeram com o terrário. É difícil, leva tempo, precisa cuidado. Essas coisas que falei são como mato em nossas vidas, crescem naturalmente. E quando não tínhamos Jesus éramos escravos dessas coisas. Quando recebemos a Cristo ele coloca Sua vida dentro de nós, como uma semente e precisamos cuidar dela para que cresça e preencha toda a nossa vida. Nós mesmos devemos ser como um simples galho na árvore que é Jesus, produzindo o que Ele quer. Escutem o que esse versículo diz: "),0,'J');
				
				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Portanto, assim como vocês receberam a Cristo Jesus, o Senhor, continuem a viver nele, enraizados e edificados nele, firmados na fé, como foram ensinados, transbordando de gratidão. Colossenses 2:6,7"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("(Leve um galho seco para o grupo) Gente, o que vocês acham desse galho? Ele pode dar fruto? Porque não? O que está faltando? A árvore! Um galho longe da árvore produz fruto? Por que não?Mas quando começou a história dessa árvore que está dentro de nós e que deve dar frutos?"),0,'J');

				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Limpando os Galhos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("No Velho testamento, quem era o povo escolhido de Deus e que seria uma benção para outras nações? Vamos ler: "),0,'J');
				
				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Porque a vinha do Senhor dos Exércitos é a casa de Israel, e os homens de Judá são a planta das suas delícias;"),0,'J');
				
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Então, quem era a árvore que deveria dar frutos para Deus, no passado? Israel, o povo de Deus. E Deus estava no meio do seu povo. E a que tipo de árvore Israel era comparado? (Fig.1.1) Uma Videira, um pé de uvas! Continuando... e esperou que exercesse juízo, e eis aqui opressão; justiça, e eis aqui clamor. Isaías 5:7 Que fruto Israel deveria ter dado? Justiça! O que é justiça? E que fruto Israel deu? Opressão! O que é opressão? O povo de Israel fazia o bem? Não! Eles não agiam certo, pecavam, tinham ídolos... Mas Deus prometeu uma outra videira. (Fig1.2) Um dia Jesus falou isso aos discípulos:"),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Eu sou a videira verdadeira, e meu Pai é o agricultor."),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Quem é a videira agora? Quem é uma benção para todas as famílias da terra? Jesus passou a ser essa árvore e esteve entre nós, como homem. E depois que Ele subiu aos céus, prometeu continuar conosco. Como? Vamos continuar a leitura..."),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Todo ramo que, estando em mim, não dá fruto, ele corta; e todo que dá fruto ele poda, para que dê mais fruto ainda. Vocês já estão limpos, pela palavra que lhes tenho falado. Permaneçam em mim, e eu permanecerei em vocês. Nenhum ramo pode dar fruto por si mesmo, se não permanecer na videira."),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Quem pode dar fruto? E quem é que não dá fruto? Mas, e se o galho estiver somente perto da videira? E se a pessoa estiver só perto de Jesus? O que acham? Como a pessoa tem que estar então? Precisa estar grudada em Jesus, ter Ele em seu coração de verdade! O que acontece com quem não está em Cristo? (Fig.1.3) Se alguém não estiver em mim, será lançado fora, como a vara, e secará; e os colhem e lançam no fogo, e ardem. "),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Se vós estiverdes em mim, e as minhas palavras estiverem em vós, pedireis tudo o que quiserdes, e vos será feito. Nisto é glorificado meu Pai, que deis muito fruto; e assim sereis meus discípulos. Como o Pai me amou, também eu vos amei a vós; permanecei no meu amor. João 15:6-9"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("(Fig1.4) Então devemos estar nEle, e as palavras dEle devem estar em nós para que possamos dar frutos? Mas que fruto é esse que devemos dar? Vamos abrir o livro de Gálatas novamente para ver a resposta:"),0,'J');
				
				$pdf->Image('../../capa.jpg',50,300,500,300);

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Mas o fruto do Espírito é amor, alegria, paz, paciência, amabilidade, bondade, fidelidade, mansidão e domínio próprio... Gálatas 5:22,23 "),0,'J');
				
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Que fruto é? O fruto do Espírito! O Espírito Santo que habita em nós usa a Palavra de Deus, que é o nosso alimento, para nos fortalecer e produzir fruto em nossa vida! Como nos alimentamos da Palavra de Deus? Você tem se alimentado da Palavra todos os dias? Tem se grudado na Palavra como a lagartixa se gruda na parede? Tem feito o semanário? A Bíblia nos diz em Salmos 1:1-2 que somos "),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("como árvores plantadas junto a corrente de águas que no devido tempo, dá o seu fruto"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Quanto mais nos alimentamos da Palavra, mais daremos o fruto do Espírito! Então o que vamos produzir nas nossas vidas? Manga, abacate, melão?  Vamos ler Gálatas 5:22 novamente? Que bom saber que não precisamos mais ter aquelas coisas que são obras da carne e que nos escravizam. O que vocês acham? Vocês querem ser galhos produtores de fruto? O que devem fazer? Vocês acham que precisam abandonar alguma coisa em suas vidas? Como vocês podem permanecer em Jesus? Você gostaria de dar o fruto do espírito? Então bem-vindos à Operação Verde I - A colheita! Vamos conhecer todo o fruto do Espírito, como desenvolver cada parte, como é bom para nossas vidas e como esse fruto pode influenciar e lançar suas sementes nas vidas de nossos amigos e família! Vamos aprender também sobre o fruto da terra, como é bom e como ajuda nossa saúde! Prontos?"),0,'J');

				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Preparando para a colheita:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Oração - Senhor muito obrigado por estar em nosso coração, muito obrigado pelo Espírito Santo que produz bom fruto em nossa vida! Nos ajuda a cada dia mais permanecermos no Senhor, nos alimentarmos da Sua palavra e darmos fruto para Tua glória!"),0,'J');
				$pdf->Ln(10);

				$pdf->MultiCell(0,15,utf8_decode("Versículo para memorizar 1"),0,'J');
				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Como é feliz aquele que não segue o conselho dos ímpios, não imita a conduta dos pecadores, nem se assenta na roda dos zombadores! Ao contrário, sua satisfação está na lei do Senhor, e nessa lei medita dia e noite. É como árvore plantada à beira de águas correntes: Dá fruto no tempo certo e suas folhas não murcham. Tudo o que ele faz prospera! Salmos 1:1-3"),0,'J');
				$pdf->Ln(10);
				
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Mistério 1 - O Milagre da Vida"),0,'J');
				$pdf->Ln(10);
				
				$pdf->MultiCell(0,15,utf8_decode("* Quem realiza o milagre?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Onde a árvore é plantada?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como ela cresce?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Qual a condição para dar fruto?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como o amor age em nós?"),0,'J');
				
				$pdf->ln(10);
			    // Select Arial italic 8
			    $pdf->SetFont('arial','I',8);
			    // Print centered page number
			    $pdf->Cell(0,10,"Este material impresso pelo ".$nome_usuario,0,1,'J');
			// F - Lição 01	
			
			$pdf->AddPage();			
			
			// I - Lição 02
				//Capa
				$pdf->SetFont('arial','B',18);
				$pdf->Cell(0,0,utf8_decode("Lição 02"),0,0,'C');
				$pdf->Ln(10);
				
				$pdf->Image('../../capa.jpg',50,300,500,300);

				//Título da Lição
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(50,20,utf8_decode("2. Amor - Bom Samaritano - Vermelhos"),0,1,'L');

				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Pegando os Cestos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Quem já descobriu o mistério? Quem fez o semanário? O que aprenderam? Agora respondam, Onde o fruto do Espírito é produzido? Em nossas vidas. O fruto do Espírito se apresenta de várias maneiras em nossa vida. Quem lembra? Amor, alegria, paz...  "),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("E o fruto da terra? É variado também? Quem faz as sementes germinarem e crescerem? A terra ou Deus? Abram em I Coríntios 3:7 "),0,'J');
				
				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("de modo que nem o que planta nem o que rega são alguma coisa, mas unicamente Deus, que efetua o crescimento. 1 Coríntios 3:7"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode(" Qual a resposta? Na terra, a semente é lançada, a terra faz sua parte, o lavrador faz a sua parte, mas o crescimento vem de Deus. Na nossa vida, Jesus é a semente, Deus dá o crescimento e o Espírito gera o fruto usando a palavra, mas qual a nossa parte? Devemos ser boa terra e facilitar que Jesus cresça em nossa vida e devemos fazer aquilo que o Espírito Santo nos dirige a fazer e ser através da palavra!"),0,'J');

				$pdf->MultiCell(0,15,utf8_decode("Que fruto o Espírito quer produzir em nossa vida? Vamos olhar em Gálatas 5:22 novamente? Qual a primeira maneira citada, na qual o Espírito Santo frutifica em nossas vidas? Amor! Você sabia que o fruto da terra de cor vermelha nos lembra o amor? Vamos descobrir o porquê em nossa Operação Verde I - A colheita?"),0,'J');

				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Limpando os Galhos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("(Leve melancia para as crianças) Que cor é a melancia? Existem outros frutos vermelhos? Quais? O que faz com que esses frutos sejam vermelhos? Corantes naturais criados por Deus. Ele pintou essa parte do fruto da terra de vermelho. Mas será que esses corantes são iguais a tinta guache? Não esses corantes são especiais! Ele são responsáveis pela seleção do que entra e do que sai das células no nosso corpo e servem para permitir a entrada dos bons nutrientes e remover o lixo celular, livrando as nossas células das toxinas, das coisas que as prejudicam. "),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("Quando comemos essa melancia, por exemplo, estamos ajudando nosso corpo a se livrar das coisas que o prejudicam. (Fig.2.1) Todo fruto da terra vermelho é bom principalmente para os nossos rins porque eles reduzem as toxinas do nosso sangue. Os rins são um filtro muito importante do nosso corpo. Se ficam com excesso de substâncias tóxicas eles podem adoecer e parar de trabalhar. Os alimentos vermelhos, limpam nosso corpo e a melancia lava mesmo, porque além de tudo tem muita água!"),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("Então será que eu posso comer um monte de frutas vermelhas todo dia para não ter problemas nos rins? Não, porque quando ele faz muita faxina, as células que temos responsáveis pela faxina natural do corpo ficam preguiçosas e não vão querer trabalhar sozinhas. Podemos ficar muito doentes. Devemos comer os vermelhos? Sim, mas não demais! "),0,'J');

				$pdf->MultiCell(0,15,utf8_decode("Mas eu falei que o fruto da terra da cor vermelha nos lembra o amor, quem sabe o porquê? Porque o amor protege o nossa vida contra coisas ruins como raiva, inveja e amargura, o que mais? O que vocês acham? Vamos ler sobre o amor? Mateus 5:43-48 diz "),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode(" Como o Pai me amou, assim eu os amei; permaneçam no meu amor. Se vocês obedecerem aos meus mandamentos, permanecerão no meu amor, assim como tenho obedecido aos mandamentos de meu Pai e em seu amor permaneço. Tenho lhes dito estas palavras para que a minha alegria esteja em vocês e a alegria de vocês seja completa"),0,'J');

					$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("O que esse versículo está dizendo? Então amor tem a ver com obediência? Amor não é estar apaixonado? O que é amor? Vamos ler I Coríntios 13:4-8"),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("O amor é paciente, o amor é bondoso. Não inveja, não se vangloria, não se orgulha. Não maltrata, não procura seus interesses, não se ira facilmente, não guarda rancor. O amor não se alegra com a injustiça, mas se alegra com a verdade. Tudo sofre, tudo crê, tudo espera, tudo suporta. O amor nunca perece"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Será que amar é fácil? Será que é amamos naturalmente? Existe um história na Bíblia que nos ajuda a entender."),0,'J');

				$pdf->Image('../../capa.jpg',50,300,500,300);


				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Certa ocasião, um perito na levantou-se para pôr Jesus à prova e lhe perguntou: Mestre, o que preciso fazer para herdar a vida eterna? O que está escrito na Lei? respondeu Jesus. Como você a lê? Ele respondeu: Ame o Senhor, o seu Deus de todo o seu coração, de toda a sua alma, de todas as suas forças e de todo o seu entendimento e Ame o seu próximo como a si mesmo. Disse Jesus: Você respondeu corretamente. Faça isso, e viverá. Mas ele, querendo justificar-se, perguntou a Jesus: E quem é o meu próximo? Em resposta, disse Jesus: (Fig.2.2) Um homem descia de Jerusalém para Jericó, quando caiu nas mãos de assaltantes. Estes lhe tiraram as roupas, espancaram-no e se foram deixando-o quase morto. Aconteceu estar descendo pela mesma estrada um sacerdote. O que é um sacerdote? É um líder religioso. (Fig.2.3) Quando viu o homem, passou pelo outro lado. E assim também um levita; O que é um levita? Alguém que era responsável do serviço na casa de Deus. quando chegou ao lugar e o viu, passou pelo outro lado. Mas um samaritano"),0,'J');
				
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Quem eram os samaritanos? Povo que judeu que havia se separado do restante de Israel e isso fazia com que os israelitas os desprezassem. ... "),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("estando de viagem, chegou onde se encontrava o homem e, quando o viu, teve piedade dele. (Fig.2.4) Aproximou-se, enfaixou lhe as feridas, derramando nelas vinho e óleo. Depois colocou-o sobre o seu próprio animal, levou-o para uma hospedaria e cuidou dele. No dia seguinte, deu dois denários ao hospedeiro e disse-lhe: Cuide dele. Quando voltar lhe pagarei todas as despesas que você tiver. Qual destes três você acha que foi o próximo do homem que caiu nas mãos dos assaltantes? Aquele que teve misericórdia dele, respondeu o perito na lei. Jesus lhe disse: Vá e faça o mesmo. Lucas 10:25-37"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Ok, várias perguntas para vocês: O Samaritano conhecia aquele homem? Ele precisava parar? Foi perigoso para ele parar ali? Custou dinheiro pra ele? Custou o que mais? Porque então ele ajudou o homem? Vamos ler novamente a resposta de Jesus ao mestre da lei quando ele perguntou o que fazer para ganhar a vida eterna? Ame o Senhor, o seu Deus de todo o seu coração, de toda a sua alma, de todas as suas forças e de todo o seu entendimento e Ame o seu próximo como a si mesmo. Isso estava escrito na lei que Deus deu ao seu povo, a nós também! E agora, porque o samaritano fez aquilo? Amor é uma decisão e uma resposta ao amor que Deus tem por nós! Existem pessoas que você acha difícil amar? Você tem inimigos? A raiva, o ressentimento fazem bem ao seu coração? Isso é como lixo em sua vida que faz você esquecer do amor que Deus tem por você mesmo você fazendo coisas erradas. Deus lhe ama e lhe diz que você deve amar. Amar não é fácil, mas quando eu quero obedecer, eu vou tirar o lixo da falta de perdão, da raiva do meu coração e vou colocar o amor de Deus no lugar mesmo quando é difícil para que a minha alegria seja completa e eu permaneça no amor que é Deus. (Dê um breve testemunho de sua vida, como decidiu amar alguém, mesmo sendo difícil) Você quer tomar a decisão de amar, de deixar o Espírito Santo produzir amor em você? Vamos orar!"),0,'J');

				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Preparando para a colheita:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Oração - Senhor muito obrigado por me amar ao ponto de dar a Sua vida por mim. Me ajude a tirar o lixo da minha vida e a te obedecer e a amar aquelas pessoas que são difíceis de amar. Me ajude a semear amor na vida delas como fez Jesus e o Samaritano! Em Teu nome! Amém!"),0,'J');
				$pdf->Ln(10);

				$pdf->MultiCell(0,15,utf8_decode("Versículo para memorizar 1"),0,'J');
				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Como é feliz aquele que não segue o conselho dos ímpios, não imita a conduta dos pecadores, nem se assenta na roda dos zombadores! Ao contrário, sua satisfação está na lei do Senhor, e nessa lei medita dia e noite. É como árvore plantada à beira de águas correntes: Dá fruto no tempo certo e suas folhas não murcham. Tudo o que ele faz prospera! Salmos 1:1-3"),0,'J');
				$pdf->Ln(10);

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Mistério 1- O Milagre da Vida"),0,'J');
				$pdf->Ln(10);
				
				$pdf->Image('../../capa.jpg',50,300,500,300);

				$pdf->MultiCell(0,15,utf8_decode("* Quem realiza o milagre?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Onde a árvore é plantada?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como ela cresce?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Qual a condição para dar fruto?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como o amor age em nós?"),0,'J');

				$pdf->ln(10);
			    // Select Arial italic 8
			    $pdf->SetFont('arial','I',8);
			    // Print centered page number
			    $pdf->Cell(0,10,"Este material impresso pelo ".$nome_usuario,0,1,'J');
			// I - Lição 02
			
			$pdf->AddPage();			

			// I - Lição 03
				//Capa
				$pdf->SetFont('arial','B',18);
				$pdf->Cell(0,0,utf8_decode("Lição 03"),0,0,'C');
				$pdf->Ln(10);
				
				$pdf->Image('../../capa.jpg',50,300,500,300);

				//Título da Lição
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(50,20,utf8_decode("3. Alegria - Laranja - Cartas de Paulo"),0,1,'L');

				
				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Pegando os Cestos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("(Fazer um jogo da forca com espaços para a palavra CONTENTAMENTO) Vocês querem uma receita de beleza meninas? Vocês querem uma receita de força e saúde meninos? Hoje nós vamos brincar de forca enquanto trabalhamos e aqui vai aparecer a receita da beleza e da força e que tem a ver com a segunda maneira como o fruto do espírito aparece em nossa vida! A primeira é o amor! Você tem trabalhado o amor em sua vida? Descobriram o Mistério do Milagre da Vida?"),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("Hoje vamos conversar sobre a Alegria! O que é alegria? (deixe que falem suas opiniões) Qual a diferença entre alegria e diversão? Vamos fazer um teste antes de nossa forca! Eu digo a situação e vocês dizem se o resultado é alegria ou diversão!"),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("Ir para a praia, jogar bola com os amigos, brincar com as amigas, ganhar um presente, fazer algo bom para alguém, soltar pipa, sentir-se amado, estar satisfeito com a família, ir a um parque de diversão, ir ao shopping, cantar sozinho!"),0,'J');

				$pdf->MultiCell(0,15,utf8_decode("Vocês perceberam a diferença? O que vocês disseram que era diversão, depende de alguém ou de algo? E a alegria? Então é diferente? Vamos fazer nossa forca? (faça a brincadeira da forca até que descubram a palavra. Essa palavra é sinónimo de alegria, e é aquela receita de força e beleza da qual eu falei. Quem quer entrar na Operação Verde e descobrir?"),0,'J');

				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Limpando os Galhos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("(Leve uma laranja) Que fruto da terra é esse? De que cor ele é? Que outros frutos da terra são laranja? Essa cor de fruto nos lembra a alegria sabe por que? Por que eles são ricos em cálcio, Vitaminas E e C. O cálcio é bom para que? Para ter ossos fortes! (Fig.3.1) Mas também é relaxante muscular e combate o estresse. A vitamina C é energético e hidratante meninos, faz com que você se sinta menos cansado! E, meninas, a Vitamina E retarda o envelhecimento, é bom para a pele! As frutas e verduras de cor laranja nos relaxam! Porque o fruto da terra laranja nos lembra a alegria? Porque nos dá uma sensação de bem-estar e nos dá força e energia para continuar! Como podemos entender esse fruto melhor? Como fazer para não atrapalhar o Espírito a produzir esse fruto em nossa vida? (Fig.3.2) As cartas de Paulo aos cristãos das cidades de Corinto e Filipos, vão nos ajudar a ver o que precisamos podar, tirar de nossas vidas para que o espírito produza esse fruto em nós! pode ler o versículo  de  II Coríntios 8:1 - 4"),0,'J');
				
				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Agora, irmãos, queremos que vocês tomem conhecimento da graça que Deus concedeu às igrejas da Macedônia. No meio da mais severa tribulação, a grande alegria e a extrema pobreza deles transbordaram em rica generosidade. Pois dou testemunho de que eles deram tudo quanto podiam, e até além do que podiam. Por iniciativa própria eles nos suplicaram insistentemente o privilégio de participar da assistência aos santos"),0,'J');
				
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("O que é tribulação? Problema ou tempo difícil. Alegria, Pobreza e generosidade existiram no meio de um tempo difícil. Vocês acham que essas 3 palavras combinam. Alegria combina com pobreza? Pobreza combina com generosidade, dar para o outro? Tempos difíceis, problemas, pobreza... como pode alguém pode ter grande alegria e generosidade assim? É fácil? Parece impossível! Não é humano! O que fazemos quando as coisas estão difíceis e não temos dinheiro para nada? O que as pessoas daquela igreja estava fazendo? Eles pediram insistentemente para cooperar financeiramente e com grande alegria! Qual o segredo? Paulo revela esse segredo sobre-humano na carta à igreja de Filipos. Escutem: "),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Alegro-me grandemente no Senhor, porque finalmente vocês renovaram o seu interesse por mim. De fato, vocês já se interessavam, mas não tinham oportunidade para demonstrá-lo. Não estou dizendo isso porque esteja necessitado, pois aprendi a adaptar-me a toda e qualquer circunstância. Sei o que é passar necessidade e sei o que é ter fartura (Fig.3.3) Aprendi o segredo de viver contente em toda e qualquer situação, seja bem alimentado, seja com fome, tendo muito, ou passando necessidade. Tudo posso naquele que me fortalece. Filipenses 4:10-13"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Aqui Paulo fala novamente de cooperação financeira, mas agora, dos Filipenses, e ele diz que se alegra, não porque estava necessitado e foi suprido, mas porque ele tinha aprendido uma coisa, o que foi? O contentamento. O que é isso? É agradecer e ficar satisfeito com o que você tem. Isso gera alegria! Que alegria é essa que o fez ficar contente, mesmo apanhando, mesmo quase se afogando, mesmo preso, quando cantava louvando a Deus? Que alegria é essa que ele diz que é a sua força? "),0,'J');

				$pdf->Image('../../capa.jpg',50,300,500,300);

				$pdf->MultiCell(0,15,utf8_decode("Ela lembra os alimentos laranja, essa alegria acalma, tira o estresse, rejuvenesce e fortalece. A alegria depende do contentamento. O que você tem? Jesus lhe salvou da condenação de seus pecados? Então você tem a salvação! (Testemunhe da sua alegria de saber que estava salvo) Você tem certeza de que Deus o ama? Você tem certeza que pertence a Deus? Você crê que Deus está no controle dos seus problemas? Você crê que vai estar um dia com Deus? Você se alegra nisso? O que mais o Senhor lhe deu? Uma cama não muito boa? Uma rede pra dormir? Uma família, ou parte dela? Você tem comida suficiente para se manter vivo? Tem uma roupa? Você se alegra nisso?  "),0,'J');

				$pdf->MultiCell(0,15,utf8_decode("Você sabe de onde Paulo escreveu a maior parte de suas cartas? Da prisão, ele foi preso várias vezes por pregar o evangelho! (Fig.3.4) Escutem agora o que Jesus diz..."),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Como o Pai me amou, assim eu os amei; permaneçam no meu amor. Se vocês obedecerem aos meus mandamentos, permanecerão no meu amor, assim como tenho obedecido aos mandamentos de meu Pai e em seu amor permaneço. Tenho lhes dito estas palavras para que a minha alegria esteja em vocês e a alegria de vocês seja completa. João 15:9-11"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Jesus tinha essa alegria e essa alegria é passada a nós. Jesus estava contente, mesmo sabendo que iria para a cruz. Porque? Porque Ele tinha a certeza que esta era a vontade de Deus para ele naquele momento. A cruz era o que tinha para aquele dia! “Alegrai-vos” é uma ordem! Jesus lhe salvou, lhe dá forças, Ele vai voltar! Alegrai-vos! Olhe o que Ele já lhe deu! O Espírito Santo vai lhe ajudar, lembrando do amor e da esperança em Deus e ajudando a obedecer! A alegria do senhor Jesus é a nossa força! Aleluia!"),0,'J');

				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Preparando para a colheita:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Oração - Senhor me perdoe por esquecer do Seu amor, esquecer de agradecer por tudo e esquecer que sou seu!  Me ajude a estar contente em tudo, mesmo quando for difícil! E a ter esperança só no Senhor! Obrigada por Sua alegria porque ela nunca acaba! Em nome de Jesus! Amém!"),0,'J');
				$pdf->Ln(10);

				$pdf->MultiCell(0,15,utf8_decode("Versículo para memorizar 2"),0,'J');
				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Deixo a paz a vocês; a minha paz dou a vocês. Não a dou como o mundo a dá. Não se perturbe o seu coração, nem tenham medo. João 14:27"),0,'J');
				$pdf->Ln(10);
				
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Mistério 2 - Manifestações Sobre-Humanas"),0,'J');
				$pdf->Ln(10);
				
				$pdf->MultiCell(0,15,utf8_decode("* Que manifestações são essas?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Por que são sobre-humanas?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como ter essas manifestações?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* O que o fruto laranja evita?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* O que o fruto marrom evita?"),0,'J');

				$pdf->ln(10);
			    // Select Arial italic 8
			    $pdf->SetFont('arial','I',8);
			    // Print centered page number
			    $pdf->Cell(0,10,"Este material impresso pelo ".$nome_usuario,0,1,'J');
			// F - Lição 03
			
			$pdf->AddPage();			

			// I - Lição 04
				//Capa
				$pdf->SetFont('arial','B',18);
				$pdf->Cell(0,0,utf8_decode("Lição 04"),0,0,'C');
				$pdf->Ln(10);
				
				$pdf->Image('../../capa.jpg',50,300,500,300);

				//Título da Lição
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(50,20,utf8_decode("4. Paz - Marrom - O Naufrágio."),0,1,'L');
				
				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Pegando os Cestos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("(Leve um dominó para o grupo) Você sabe o que é efeito dominó? Vamos ver o efeito dominó em ação e vocês vão entender! (Monte com as crianças uma fila de dominós) Olhem para essa fila de dominós, o que vocês acham que acontece se eu empurrar a primeira peça? Vamos testar? (peça a uma criança que empurre a primeira peça). E é um efeito dominó. Hoje vamos falar de mais uma manifestação do Espírito Santo em nossas vidas. A paz! O que é paz? Paz, não é ausência de brigas e guerras, mas é um estado de tranquilidade, segurança mesmo no meio dessas coisas. Mas será que isso é fácil? Como conseguimos Paz? Tanto a Paz como a Alegria sofrem o efeito dominó, elas dependem do amor. Se existir amor, podem existir paz e alegria, senão, não é possível. Mas como dependem? Vou fazer umas perguntas: Deus lhe ama? Você tem certeza? Você já tem a salvação? Tem certeza? Deus está no controle de tudo no mundo? Tem certeza? Como você se sente, sabendo que Deus lhe ama e que ele tem o controle de tudo o que acontece com você? Tranquilo e alegre ou desesperado e triste? Se você derruba a certeza do amor, você não amará, não obedecerá, sua alegria vai ser derrubada e sua paz também e todas as outras manifestações do Espírito, exatamente como esses dominós!"),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("Mas porque as vezes cremos no amor, mas ficamos inseguros? Porque somos humanos pecadores e esquecemos do amor de Deus e pecamos desconfiando se Deus realmente está no controle. O Espírito quer nos dar uma vida de paz! E o fruto da terra marrom nos lembra a paz! Vamos para a operação verde descobrir o porquê?"),0,'J');
				
				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Limpando os Galhos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Podem me dizer algumas frutas e verduras que são marrons? Você sabe para que servem esses alimentos? (Fig.4.1)  Eles ajudam na digestão e regulam o intestino. Algumas vezes nos sentimos inchados porque comemos coisas que não são boas para nosso intestino. Você já se sentiu assim? Alimentos marrons também ajudam nosso sangue a ficar com mais oxigênio e ajudam a tirar a gordura que entope as artérias e veias. Fazendo isso, esses alimentos auxiliam no combate à depressão e à ansiedade. Porém, sempre tome bastante água quando ingerir esses alimentos porque eles têm muitas fibras e você pode ficar com prisão de ventre. Enfim, o efeito dos alimentos marrons é parecido com o efeito da paz em nossas vidas. Nos livra de tudo que nos pressiona e nos dá sensação de alívio e tranquilidade. Agora vamos ver, na prática, como a paz funciona na vida de uma pessoa? "),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("Nosso personagem é novamente Paulo! Paulo era cheio do Espírito Santo e pregava o evangelho e fazia discípulos por onde passava, mas muitos não gostavam da pregação do evangelho. Paulo foi preso por pregar a fé em Jesus Cristo várias vezes. (Fig.4.2) Uma vez, ele apresentou sua defesa diante do rei Agripa e o rei o colocou em um navio, com outros presos para ser levado à Itália, e ser julgado pelo Imperador. No capítulo 27 de Atos vamos descobrir o que aconteceu na viagem! "),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("A viagem estava bem, eles pararam em Sidom, depois em Mirra e de lá, pegaram outro navio para a Itália, o vento estava bem forte, depois deram mais uma parada no mar pois os ventos continuavam fortes. Vamos ver o que Paulo fez!"),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Por isso Paulo os advertiu: Senhores, vejo que a nossa viagem será desastrosa e acarretará grande prejuízo para o navio, para a carga e também para as nossas vidas. Mas o centurião, em vez de ouvir o que Paulo falava, seguiu o conselho do piloto e do dono do navio. Atos 27:9-11 "),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Paulo era apenas um prisioneiro! Então resolveram continuar até Creta quando o vento acalmou um pouco. Paulo continua relatando o que aconteceu:"),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Pouco tempo depois, desencadeou-se da ilha um vento muito forte, chamado Nordeste. O navio foi arrastado pela tempestade, sem poder resistir ao vento; assim, cessamos as manobras e ficamos à deriva. Passando ao sul de uma pequena ilha chamada Clauda, foi com dificuldade que conseguimos recolher o barco salva-vidas. Levantando-o, lançaram mão de todos os meios para reforçar o navio com cordas; e temendo que ele encalhasse nos bancos de areia de Sirte, baixaram as velas e deixaram o navio à deriva. (Deixando que o mar os levasse) No dia seguinte, sendo violentamente castigados pela tempestade, começaram a lançar fora a carga. No terceiro dia, lançaram fora, com as próprias mãos, a armação do navio. Não aparecendo nem sol nem estrelas por muitos dias, e continuando a abater-se sobre nós grande tempestade, finalmente perdemos toda a esperança de salvamento. Visto que os homens tinham passado muito tempo sem comer, Paulo levantou-se diante deles e disse: Os senhores deviam ter aceitado o meu conselho de não partir de Creta, pois assim teriam evitado este dano e prejuízo. Mas agora recomendo-lhes que tenham coragem, pois nenhum de vocês perderá a vida; apenas o navio será destruído. (Fig.4.3) Pois ontem à noite apareceu-me um anjo do Deus a quem pertenço e a quem adoro, dizendo-me: ‘Paulo, não tenha medo. É preciso que você compareça perante César; Deus, por sua graça, deu-lhe as vidas de todos os que estão navegando com você. Assim, tenham ânimo, senhores! Creio em Deus que acontecerá do modo como me foi dito. Devemos ser arrastados para alguma ilha.  "),0,'J');

				$pdf->Image('../../capa.jpg',50,300,500,300);

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("De onde vinha essa certeza de Paulo. Como podia estar tão tranquilo? Sim ele sabia que Deus estava no controle! Na décima quarta noite, no meio de muita ventania, perceberam que estavam próximos à terra, porém havia muitos rochedos, então resolveram jogar as âncoras e, pela manhã, alguns queriam saltar do navio, com medo que o navio se quebrasse. Mais uma vez Paulo interveio com tranquilidade: "),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Então Paulo disse ao centurião e aos soldados: Se estes homens não ficarem no navio, vocês não poderão salvar-se.... Pouco antes do amanhecer, Paulo insistia que todos se alimentassem, dizendo: Hoje faz catorze dias que vocês têm estado em vigília constante, sem nada comer. Agora eu os aconselho a comerem algo, pois só assim poderão sobreviver. Nenhum de vocês perderá um fio de cabelo sequer. Tendo dito isso, tomou pão e deu graças a Deus diante de todos. Então o partiu e começou a comer. Todos se reanimaram e também comeram algo. Estavam a bordo duzentas e setenta e seis pessoas."),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Pela manhã jogaram o resto da comida no mar e cortaram as âncoras para que o navio fosse até a praia, porém ele encalhou e as ondas começaram a quebrar o navio. Então aconteceu algo horrível! Vamos ler! "),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Os soldados resolveram matar os presos para impedir que algum deles fugisse, jogando-se ao mar. Mas o centurião queria poupar a vida de Paulo e os impediu de executar o plano.(Fig.4.4) Então ordenou aos que sabiam nadar que se lançassem primeiro ao mar em direção à terra. Os outros teriam que salvar-se em tábuas ou em pedaços do navio. Atos 27:1-44 Dessa forma, todos chegaram a salvo em terra"),0,'J');
				
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Deus havia prometido cuidar deles e o que aconteceu? Deus promete estar com você, mesmo nos momentos mais difíceis, quando há brigas em casa ou alguém morre. Você vai crer que Deus o ama e está no controle de tudo? Então o Espírito Santo lhe dará Paz!  "),0,'J');

				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Preparando para a colheita:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Oração - Senhor Obrigada pela tua paz, nos ajude a sempre confiarmos no teu amor e no teu controle sobre todas as coisas. Quando estiver difícil nos ajude a lembrar porque dependemos do Senhor. Em nome de Jesus! Amém!"),0,'J');
				$pdf->Ln(10);

				$pdf->MultiCell(0,15,utf8_decode("Versículo para memorizar 2"),0,'J');
				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Deixo a paz a vocês; a minha paz dou a vocês. Não a dou como o mundo a dá. Não se perturbe o seu coração, nem tenham medo. João 14:27"),0,'J');
				$pdf->Ln(10);
				
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Mistério 2 - Manifestações Sobre-Humanas"),0,'J');
				$pdf->Ln(10);
				
				$pdf->MultiCell(0,15,utf8_decode("* Que manifestações são essas?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Por que são sobre-humanas?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como ter essas manifestações?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* O que o fruto laranja evita?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* O que o fruto marrom evita?"),0,'J');

				$pdf->Image('../../capa.jpg',50,300,500,300);

				$pdf->ln(10);
			    // Select Arial italic 8
			    $pdf->SetFont('arial','I',8);
			    // Print centered page number
			    $pdf->Cell(0,10,"Este material impresso pelo ".$nome_usuario,0,1,'J');
			// I - Lição 04
			
			$pdf->AddPage();			

			// I - Lição 05
				//Capa
				$pdf->SetFont('arial','B',18);
				$pdf->Cell(0,0,utf8_decode("Lição 05"),0,0,'C');
				$pdf->Ln(10);
				
				$pdf->Image('../../capa.jpg',50,300,500,300);

				//Título da Lição
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(50,20,utf8_decode("5. Longanimidade - Verde Claro - Jesus e Tomé"),0,1,'L');

				
				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Pegando os Cestos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("(Leve 3 pedaços de elástico de diferentes tamanhos e várias tiras de papel amassadas de diferentes tamanhos) Vamos fazer de conta que esses objetos que eu vou entregar para vocês são sua paciência. Cada um vai receber um objeto de tamanho ou material diferente. Eu vou falar situações que podem lhe deixar impaciente e vocês vão esticar o que tem na sua mão, conforme acham que sua paciência vai ser testada. "),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("Alguém está demorando no banho na hora de sair para passear/ Alguém pisa no seu pé de propósito/ Alguém diz que a culpa de algo que você não fez é sua / Alguém grita com você todo dia e faz coisas para lhe irritar/ Alguém mentiu para você pela 10ª vez/ Você quer fazer algo e alguém diz que você não tem idade/  Seu irmão ou irmã quebrou seu brinquedo/ Você vê alguém que cola na prova tirar 10/ Você pediu algo a Deus e ainda não aconteceu. Quem já rasgou o papel? Quem esticou o elástico até o fim? Quem ainda não esticou até o fim? A parte do fruto do espírito que vamos conhecer hoje é a longanimidade. Quem já sabe o que é longanimidade? Olhem para a palavra. Alguém longânimo é alguém com o ânimo loooooongo. Ela não desanima nem fica com raiva com facilidade. É mais do que paciência! Longanimidade é a capacidade sobrenatural de suportar o sofrimento ou a irritação. "),0,'J');

				$pdf->MultiCell(0,15,utf8_decode("É possível ser longânimo o tempo todo com nossas próprias forças? Uma hora o papel vai rasgar ou o elástico vai soltar. Uma hora você pode ficar com raiva, chorar, cansar de esperar e algumas pessoas até machucam outras! Então como podemos ter esse poder sobrenatural? Se temos o Espírito Santo habitando em nós, nós podemos ter esse poder! Vamos para nossa operação verde descobrir como ter essa super paciência?"),0,'J');

				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Limpando os Galhos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("(Esprema limões com as crianças para um suco, coloque água gelada até que não fique muito azedo. Deixe que provem, sem açúcar ou faça pipoca e tempere com limão e pouco sal para comerem no final) Que cor é essa fruta? Verde claro. Você conhece algum outro fruto da terra que seja verde claro por dentro ou por dentro e por fora? Essa variedade de cor do fruto da terra nos lembra a longanimidade. (Fig.5.1) Os alimentos Verde Claros como a alface acalmam e baixam a pressão e alguns como o limão e a uva verde melhoram o sistema imunológico, diminuindo o risco de câncer! Algumas gotas de limão na água diminuem a acidez de nosso corpo provocada pela impaciência, pela raiva e pelo desânimo. A acidez no nosso corpo aumenta o risco de câncer. Vocês sabiam disso? Algumas frutas e verduras nos acalmam! Mas, essa calma, não é suficiente porque ajuda pouco, mesmo os remédios fortes que algumas pessoas tomam, não conseguem ajudar muito, porque quando o efeito do remédio acaba elas ficam chateadas novamente. Então precisamos de algo sobrenatural para nos ajudar com os momentos difíceis de nossa vida. "),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("Se queremos ser pacientes e longânimos precisamos pedir calma ao Senhor e forças para não ficarmos doentes por causa das situações que nos deixam impacientes ou que nos fazem esperar. A primeira coisa que temos que fazer é reconhecer que nós mesmos não conseguimos suportar alguns problemas bem difíceis. Você tem problemas difíceis onde é difícil ter paciência?  "),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("Será que Jesus era paciente? Vocês lembram de alguma situação onde ele foi longânimo? Vamos ler na Palavra uma história que nos mostra a grande longanimidade de Jesus. Depois da ressurreição de Jesus, Ele apareceu a Maria Madalena e algumas mulheres e pediu que elas fossem reunir os discípulos."),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("(Fig. 5.2) Ao cair da tarde daquele primeiro dia da semana, estando os discípulos reunidos a portas trancadas, por medo dos judeus, Jesus entrou, pôs-se no meio deles e disse: Paz seja com vocês! Tendo dito isso, mostrou-lhes as mãos e o lado. Os discípulos alegraram-se quando viram o Senhor."),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Já imaginou? Os discípulos pensaram que ele estava morto e então Ele aparece e lhes mostra suas mãos. O que tinha nas mãos de Jesus? Os buracos dos pregos. Ele veio em forma de homem para provar sua ressurreição. Porque Ele precisava provar sua ressurreição? Vocês podem lembrar de coisas que Jesus fez que provaram que Ele era Deus? E os discípulos ainda não acreditavam? Será que Jesus tinha que ter paciência com eles? MUITA! Pedro até o tinha negado. Depois de 3 anos andando com Jesus, eles ainda duvidavam. Como você se sentiria se você fosse Jesus? O que você faria? Mas Ele foi longânimo! Para nos ensinar a sermos longânimos, pacientes. As vezes você vai até sofrer porque alguém que você gosta não muda ou continua fazendo coisas erradas, mas não podemos desistir! Será que temos forças para sermos como Jesus? E quem pode nos dar essa paciência sobrenatural? Vamos continuar a ler..."),0,'J');

				$pdf->Image('../../capa.jpg',50,300,500,300);


				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Novamente Jesus disse: Paz seja com vocês! Assim como o Pai me enviou, eu os envio. E com isso, soprou sobre eles e disse: Recebam o Espírito Santo. Se perdoarem os pecados de alguém, estarão perdoados; se não os perdoarem, não estarão perdoados. Tomé, chamado Dídimo, um dos Doze, não estava com os discípulos quando Jesus apareceu. Os outros discípulos lhe disseram: Vimos o Senhor! Mas ele lhes disse: Se eu não vir as marcas dos pregos nas suas mãos, não colocar o meu dedo onde estavam os pregos e não puser a minha mão no seu lado, não crerei. "),0,'J');

					$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("O que vocês acham de Tomé? Ele só creria se colocasse o dedo nas feridas de Jesus! Haja paciência! Depois de Jesus ter enfrentado a cruz por ele e agora ele ainda não acredita? Vamos ver o que Jesus vai fazer com Tomé?"),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("(Fig.5.3) Uma semana mais tarde, os seus discípulos estavam outra vez ali, e Tomé com eles. Apesar de estarem trancadas as portas, Jesus entrou, pôs-se no meio deles e disse: Paz seja com vocês! E Jesus disse a Tomé: Coloque o seu dedo aqui; veja as minhas mãos. Estenda a mão e coloque-a no meu lado. Pare de duvidar e creia. (Fig.5.4) Disse-lhe Tomé: Senhor meu e Deus meu! Então Jesus lhe disse: Porque me viu, você creu? Felizes os que não viram e creram. João 21:19-29"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("O que Jesus fez? Mandou um raio torrar Tomé? Fez ele ficar doente? O que Ele fez? Porque Ele fez isso? Porque Ele é um Deus de amor e é longânimo! Tomé colocou a mão em Jesus? O que ele fez em vez disso? Ele reconheceu a bobagem que tinha feito e ficou envergonhado diante do Deus criador! Jesus não estava presente quando Tomé disse o que queria aos discípulos, mas Jesus repetiu palavra por palavra o que ele havia dito. Jesus não somente tem paciência conosco, mas essa paciência vem de seu amor. Mesmo sabendo que as vezes pensamos e fazemos pecado, Ele nos ama! Essa paciência e amor mudaram a vida de Tomé. Se deixarmos o Espírito Santo produzir esse fruto em nossas vidas, vocês acham que as pessoas vão perceber a mudança em nós? Elas vão ver o amor a e a longanimidade de Deus em mim e em você! Você gostaria de pedir a ajuda de Deus para ter essa longanimidade sobrenatural que só Deus pode dar? Mesmo nas situações difíceis? Mesmo quando o que você quer demora? Vamos orar!"),0,'J');

				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Preparando para a colheita:"),0,1,'L');
				
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Oração - Senhor Deus, nos ajude a buscarmos o Senhor sempre, para que sempre sejamos pacientes, perdoando a quem nos faz mal e ajudando a suportar a espera de algo que queremos! Obrigada porque Jesus é paciente conosco! Nos ajude a amarmos com paciência como o Senhor nos ama! Em nome de Jesus, Amém"),0,'J');
				$pdf->Ln(10);

				$pdf->MultiCell(0,15,utf8_decode("Versículo para memorizar 3"),0,'J');
				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Descanse no Senhor e aguarde por Ele com paciência; não se aborreça com o sucesso dos outros, nem com aqueles que maquinam o mal.  Salmos 37:7"),0,'J');
				$pdf->Ln(10);
				
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Mistério 3 - A Verdadeira Resistência "),0,'J');
				$pdf->Ln(10);
				
				$pdf->MultiCell(0,15,utf8_decode("* Qual a verdadeira resistência?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* A quê ela resiste?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como desenvolvê-la?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como a longanimidade lhe ajuda?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* O que minha benignidade produz nos outros?"),0,'J');

				$pdf->Image('../../capa.jpg',50,300,500,300);

				$pdf->ln(10);
			    // Select Arial italic 8
			    $pdf->SetFont('arial','I',8);
			    // Print centered page number
			    $pdf->Cell(0,10,"Este material impresso pelo ".$nome_usuario,0,1,'J');
			// I - Lição 05
			
			$pdf->AddPage();			

			// I - Lição 06
				//Capa
				$pdf->SetFont('arial','B',18);
				$pdf->Cell(0,0,utf8_decode("Lição 06"),0,0,'C');
				$pdf->Ln(10);
				
				$pdf->Image('../../capa.jpg',50,300,500,300);

				//Título da Lição
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(50,20,utf8_decode("6. Benignidade - Preto - Dorcas."),0,1,'L');

				
				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Pegando os Cestos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Que manifestações do Espírito Santo nós já conhecemos? Amor, alegria, paz e longanimidade. Hoje vamos conhecer a Benignidade ou Amabilidade. Quem quer adivinhar o que é benignidade? (Escreva tiras de papel com as palavras - Idiota, burro, feio, horrível, não presta, mau, agressão, bullying, julgar, rir do outro, triste, perdão, consolo, bom, inteligente, bonito, ajuda, elogio, ouvir, capaz, positivo, alegre) Olhe para essas palavras e separe as que vocês acham que tem a ver com benignidade. (deixe que separem) Agora me digam o que é benignidade. (Ouça as crianças) É a disposição sobrenatural de ser, fazer e pensar coisas boas para com o outro. "),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("Quais dessas palavras fazem você se sentir bem? Essas palavras saem de uma pessoa benigna. Uma pessoa benigna e amável evita trazer dor aos outros. Vocês conhecem alguém assim? É possível ser assim o tempo todo? E com os nossos inimigos? É impossível! Por isso Deus trabalha em nossa vida pela Palavra e pelo Espírito Santo que está dentro de cada um de nós para nos dar essa força sobrenatural para sermos amáveis e benignos com outras pessoas. Temos algum exemplo a seguir? Jesus foi o exemplo! E o Espírito Santo nos ajuda a sermos como Jesus, mas temos que escolher ser assim todos os dias com todas as pessoas. Vamos para nossa operação verde descobrir como ter essa super amabilidade ou benignidade?"),0,'J');
				
				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Limpando os Galhos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("(Fig.6.1) O fruto da terra que nos lembra a benignidade é o de cor escura. Que alimentos, frutos da terra são pretos? Feijão preto, arroz preto, Jabuticaba, chá preto ... As frutas e vegetais pretos combatem a anemia, fortalecendo nosso sangue, tiram as coisas tóxicas do nosso organismo e retardam o envelhecimento. "),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("Você sabe quais alimentos são prejudiciais à saúde? Margarina, frituras, refrigerantes, excesso de açúcar, alimentos enlatados... Os alimentos pretos limpam nosso organismo! Lembra das palavras que fazem mal? São como estes alimentos prejudiciais, elas machucam e podem fazer pessoas chorarem e ficarem doentes de verdade. Fazem a pessoa que as falou, também se sentir mal porque ela está cheia de raiva, inveja e maldade e essas coisas destroem a vida e a alegria. Pelo contrário, as palavras e atitudes boas, a benignidade, limpa nossas vidas e ajuda as pessoas ao redor de nós a se sentirem bem e amadas. E quando fazemos elas felizes, ficamos bem também! Você acha que tem feito a escolha certa na maneira que você trata e fala com seus amigos e colegas? Sua família? E a maneira como trata e fala com as pessoas que não gostam de você? A Bíblia nos conta a história de uma mulher e o presente que ela recebeu por ser uma pessoa benigna. Sua história está no livro de Atos capítulo 9:36 a 42."),0,'J');
				
				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("(Fig.6.2) E havia em Jope uma discípula chamada Tabita, que traduzido se diz Dorcas. O que essa mulher era? Igual a vocês! Vocês são discípulos de quem? Todos somos discípulos de Cristo! Vamos continuar... Esta estava cheia de boas obras e esmolas que fazia. "),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Como essa mulher vivia? Ela era boa para as pessoas, ela ajudava as pessoas. "),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("(Fig.6.3) E aconteceu naqueles dias que, enfermando ela, morreu; e, tendo-a lavado, a depositaram num quarto alto. E, como Lida era perto de Jope, ouvindo os discípulos que Pedro estava ali, lhe mandaram dois homens, rogando-lhe que não se demorasse em vir ter com eles. E, levantando-se Pedro, foi com eles; e quando chegou o levaram ao quarto alto, e todas as viúvas o rodearam, chorando e mostrando as túnicas e roupas que Dorcas fizera quando estava com elas "),0,'J');

					$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("A quem ela ajudava? As viúvas! Viúvas, na época de Jesus passavam muita necessidade, fome e não tinham o que vestir. Dorcas era discípula, então o que havia dentro dela? O Espírito Santo, e ele lhe dava o poder sobrenatural para se importar com pessoas que não podiam lhe dar nada em troca, isso é misericórdia. Você acha fácil tratar bem e ajudar quem pode lhe ajudar também ou alguém que nunca vai poder retribuir? Mas Deus ajudou Dorcas a ajudarem aquelas mulheres, elas não podiam fazer nada por Dorcas agora, mas sabiam quem poderia fazer algo! Deus! Então elas chamaram quem? Pedro. E ele viu como Dorcas tinha demonstrado o amor de Deus, ajudando aquelas mulheres. Pedro deve ter sentido compaixão por aquelas viúvas também, ele se importou com elas, elas tinham perdido sua amiga. Mas Pedro, fazendo sair a todos, pôs-se de joelhos e orou: e, voltando-se para o corpo, disse:"),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Tabita, levanta-te. (Fig.6.4) E ela abriu os olhos, e, vendo a Pedro, assentou-se. E ele, dando-lhe a mão, a levantou e, chamando os santos e as viúvas, apresentou-lha viva. E foi isto notório por toda a Jope, e muitos creram no Senhor."),0,'J');

				$pdf->Image('../../capa.jpg',50,300,500,300);


				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Uau! Pedro ressuscitou Dorcas? Não Pedro orou e falou! Se eu orar e falar, as pessoas vão ressuscitar? Quem pode ressuscitar os mortos? Deus! Ele foi benigno para com Dorcas e para com aquelas viúvas e fez com que ela vivesse novamente! E qual foi o resultado? Muitos creram! "),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Quando somos amáveis com as pessoas e olhamos pra elas com misericórdia, mesmo quando nos fazem mal, fazemos com que conheçam a Deus! O fruto do Espírito em nossa vida semeia o amor na vida de outros! Quem semeou, nessa história? Dorcas, as viúvas e Pedro. E se Dorcas nunca tivesse se importado? E se Dorcas tivesse ignorado aquelas mulheres? E se tivesse pensado “Porque eu tenho que ajudar? Elas que vão trabalhar! Preguiçosas! Elas podem fazer roupas e vender! Como essa história teria terminado?"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Jesus quer crescer em sua vida e o Espírito Santo quer fazer você dar fruto, assim como Dorcas e Pedro deram. É uma ordem de Deus que você dê fruto. Mas é uma escolha sua, obedecer e amar, ser alegre, ter paz, ser amável com os outros. Você vai decidir rasgar essas coisas de sua vida? (coloque as tiras de coisas más diante deles) Essas coisas, atitudes e palavras más não devem ter mais lugar na sua vida. Você quer pegar uma delas e rasgar e pedir perdão a Deus. Pedir que Ele lhe ajude a ter a força sobrenatural de fazer o bem, dizer só coisas boas, ajudar as pessoas e nunca mais fazer ninguém se sentir mal? Vamos orar... "),0,'J');

				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Preparando para a colheita:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Oração - Deus me perdoe! Pelas palavras que fizeram mal aos meus amigos, pelas atitudes que não ajudaram as pessoas que me amam e cuidam de mim, me ajude a ser benigno, a amar, mostrar amor, ajudar a todos ao redor de mim, para que todos conheçam seu amor! Obrigado porque o Senhor tem sido tão bom para mim! Em nome de Jesus!"),0,'J');
				$pdf->Ln(10);

				$pdf->MultiCell(0,15,utf8_decode("Versículo para memorizar 3"),0,'J');
				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Descanse no Senhor e aguarde por Ele com paciência; não se aborreça com o sucesso dos outros, nem com aqueles que maquinam o mal.  Salmos 37:7"),0,'J');
				$pdf->Ln(10);
				
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Mistério 3 - A Verdadeira Resistência "),0,'J');
				$pdf->Ln(10);
				
				$pdf->MultiCell(0,15,utf8_decode("* Qual a verdadeira resistência?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* A quê ela resiste?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como desenvolvê-la?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como a longanimidade lhe ajuda?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* O que minha benignidade produz nos outros?"),0,'J');

				$pdf->ln(10);
			    // Select Arial italic 8
			    $pdf->SetFont('arial','I',8);
			    // Print centered page number
			    $pdf->Cell(0,10,"Este material impresso pelo ".$nome_usuario,0,1,'J');
			// F - Lição 06
			
			$pdf->AddPage();			

			// I - Lução 07
				//Capa
				$pdf->SetFont('arial','B',18);
				$pdf->Cell(0,0,utf8_decode("Lição 07"),0,0,'C');
				$pdf->Ln(10);
				
				$pdf->Image('../../capa.jpg',50,300,500,300);

				//Título da Lição
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(50,20,utf8_decode("7. Bondade - Roxo - Filemon."),0,1,'L');
				
				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Pegando os Cestos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Você sabe o que seu nome quer dizer? O meu quer dizer.... Você sabe o que quer dizer o nome Ágata - Boa. Mas o que é uma pessoa boa? A palavra que foi usada, na língua em que este livro foi escrito - o grego - quer dizer “bom de maneira completa”. Essa palavra foi usada para descrever o caráter e a natureza de Deus. A Bíblia diz em Salmo 119.68: Tu és bom, e o que fazes é bom,... E agora? A Bíblia diz que o fruto do Espírito é também bondade? Mas nós somos pecadores, como podemos ser bons? Isso mesmo, o Espírito Santo é que nos dá o poder sobrenatural de ser bom! Lembra que precisamos ficar pregados na videira que é Jesus! E qual o propósito desses poderes sobrenaturais? Semear Deus na vida dos outros! Quem lembra das manifestações do fruto do Espírito que já conhecemos? Amor, Alegria, Paz, Longanimidade, Benignidade e agora vamos aprender sobre .... Você gosta que as pessoas sejam boas com você? Gosta quando agem de maneira justa e ajudam você? E você tem sido bom para os outros?  Então vamos começar nossa operação verde I de hoje:"),0,'J');

				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Limpando os Galhos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Hoje temos um fruto da terra da cor que é a mistura do vermelho com o azul! Quem sabe? Roxo! Quem pode me dizer um fruto da terra que é roxo? Repolho roxo, beterraba, uva! Quem gosta de uva? E suco de uva? (Fig.7.1) Alimentos roxos são bons para nossa digestão, mas vocês sabem porque podemos relacionar os alimentos de cor roxa com a bondade? Porque eles fazem bem para o nosso coração! Eles possuem uma substância que evita que o sangue coagule. Coágulos acontecem quando o sangue endurece. Quando você se corta, sangra no começo, depois o corte para de sangrar. Isso é bom! Mas, algumas vezes, ficar muito tempo parado, fumar muito e ter muita gordura no corpo podem fazer com que o sangue coagule dentro das veias e artérias e pode causar um problema no coração e até no cérebro, os alimentos de cor roxa, ajudam o sangue a não coagular nesses casos, eles mantém o sangue bem líquido e correndo! Como os alimentos roxos, a bondade também é boa para o nosso coração, porque qual o contrário dela? A maldade! A maldade faz bem ao coração? Existem pessoas que morrem do coração porque tem raiva e sentimentos maus em seus corações!  Ser bom ajuda até a nossa saúde! Mas como vimos, Deus é que é bom! Como podemos ser bons também? Vamos ler na Palavra a história de um homem que desenvolveu o poder sobrenatural da bondade. Quando estava na prisão Paulo conheceu um rapaz chamado Onésimo! Onésimo havia sido escravo de Filemom. Naquela época a escravidão era comum. Pessoas compravam pessoas dos povos que eram dominados nas guerras. (Fig.7.2) Onésimo era um desses jovens que tinham sido comprados para trabalhar na casa de Filemom. Vocês lembram de outra pessoa que foi vendida como escrava para trabalhar na casa de alguém? José. E o que aconteceu com José? Ele se tornou o governador do Egito! Onésimo era diferente de José! Onésimo era rebelde! A Bíblia não diz detalhes, só que ele fugiu e parece ter levado algum dinheiro de Filemom na fuga. Onésimo foi preso e encontrou Paulo na prisão! O que vocês acham que Paulo fez com ele? Exatamente! Paulo pregou o evangelho para ele! (Fig.7.3) E Onésimo entregou sua a vida a Jesus! Paulo então, escreveu uma carta a Filemom, que era cristão, sobre Onésimo! Vamos abrir a carta a Filemom, diz assim:"),0,'J');
				
				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Seu amor me tem dado grande alegria e consolação, porque você, irmão, tem reanimado o coração dos santos. Por isso, mesmo tendo em Cristo plena liberdade para mandar que você cumpra o seu dever, prefiro fazer um apelo com base no amor."),0,'J');
				
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode(" A quem Paulo estava escrevendo? Como Paulo se sentia em relação a Filemom? Ele era um bom discípulo? Filemom era um bom homem? Ele reanimava o coração das pessoas, ele era um bom homem! Paulo faz um pedido a Filemom com base em que? No amor! Paulo sabia que Filemom amava a Deus e as pessoas e pediu em nome desse amor! Era o momento de Filemom mostrar ainda mais esse amor na prática! O que será que Paulo vai pedir?"),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Eu, Paulo, já velho, e agora também prisioneiro de Cristo Jesus, apelo em favor de meu filho Onésimo, que gerei enquanto estava preso. "),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Paulo não era casado, como ele tinha filho? Como Ónesimo era filho de Paulo? Como? Ele era filho na fé! Paulo havia pregado o evangelho para Onésimo e sua vida havia sido transformada! Paulo continua:"),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Ele antes lhe era inútil, mas agora é útil, tanto para você quanto para mim. Mando-o de volta a você, como se fosse o meu próprio coração. Gostaria de mantê-lo comigo para que me ajudasse em seu lugar enquanto estou preso por causa do evangelho. Mas não quis fazer nada sem a sua permissão, para que qualquer favor que você fizer seja espontâneo, e não forçado. Talvez ele tenha sido separado de você por algum tempo, para que você o tivesse de volta para sempre, não mais como escravo, mas, acima de escravo, como irmão amado. Para mim ele é um irmão muito amado, e ainda mais para você, tanto como pessoa quanto como cristão.  Assim, se você me considera companheiro na fé, receba-o como se estivesse recebendo a mim.  "),0,'J');

				$pdf->Image('../../capa.jpg',50,300,500,300);

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Será que qualquer pessoa faria isso por um ladrão, um criminoso? O que vocês acham? Paulo poderia simplesmente falar de Jesus e pronto! Mas Paulo fez mais, Paulo estava exercendo o poder sobrenatural da bondade, Paulo estava indo além! Ele estava pedindo que Filemom o recebesse como se fosse ele próprio! Uau! Como Onésimo deve ter ficado? Onésimo era escravo lembra? Ele tinha casa e família para onde voltar? Ele estava sendo solto e Paulo resolveu pedir um favor enorme a Filemom! Mas Paulo não parou por aí. Eu vou ler e vocês vão me dizer o que mais Paulo fez diz em sua carta:"),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Se ele o prejudicou em algo ou lhe deve alguma coisa, ponha na minha conta. Eu, Paulo, escrevo de próprio punho: Eu pagarei — para não dizer que você me deve a sua própria pessoa. Filemom 1:7-19"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("O que Paulo ia fazer? Pagar a conta! Do bolso dele! Que bondade! É essa a bondade do Senhor! É ir além, é ser generoso! Quem pagou a nossa conta na cruz? Foi alta a nossa conta? Mas bondade de Deus ela é justa! Havia uma lei “ Sem derramamento de sangue, não pode haver perdão de pecados”. Deus não foi contra a lei nem deu um jeitinho na lei, Ele poderia ter feito isso, afinal quem havia criado essa lei? Ele o próprio Deus! Mas a bondade sempre anda com a justiça. Alguém tinha que morrer, mas alguém só morreria em nosso lugar para pagar nossa dívida se nos amasse. O que diz em João 3:16? Porque Deus amou .... Deus pagou nossa dívida. Ele foi bom para mim e para você!"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Mas, continuando a história... (Fig.7.4) A Bíblia não diz, mas imaginamos que Filemom tenha recebido Onésimo e talvez o tenha até libertado! Mas isso só aconteceu por causa do pedido de Paulo! Um pedido difícil de fazer e difícil de aceitar. Custou para Paulo. Era justo Paulo pedir a Filemom que esquecesse a dívida? Não, então ele se ofereceu para pagar! Agora me digam: O que é bondade? Você quer ter isso em sua vida? Pode pensar em alguém que você possa começar a ser bom para essa pessoa? Com justiça, pedindo a Deus sabedoria? Seu irmão, sua mãe, sua avó...? O que você pode fazer? Vamos orar!"),0,'J');

				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Preparando para a colheita:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Oração - Deus me ajude a ser bom para as pessoas, a ser generoso e justo, me ajude a sempre lembrar da bondade e quando eu não estiver com vontade de ser bom, me ajude a deixar a Sua palavra ser minha dona. Que Jesus possa crescer sempre em meu coração e que minha família, amigos e professores possam ver isso na minha vida. Em nome de Jesus, Amém!"),0,'J');
				$pdf->Ln(10);

				$pdf->MultiCell(0,15,utf8_decode("Versículo para memorizar 4"),0,'J');
				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Não te desamparem a benignidade e a fidelidade; ata-as ao teu pescoço; escreve-as na tábua do teu coração. E acharás graça e bom entendimento aos olhos de Deus e do homem. Provérbios 3:3,4"),0,'J');
				$pdf->Ln(10);
				
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Mistério 4 - A Dupla Orgânica"),0,'J');
				$pdf->Ln(10);
				
				$pdf->MultiCell(0,15,utf8_decode("* O que é um alimento orgânico?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Por que ele é melhor?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* O que é felicidade?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como você pode ser bom para os outros?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* O que impede você de se tomar orgânico?"),0,'J');

				$pdf->Image('../../capa.jpg',50,300,500,300);


				$pdf->ln(10);
			    // Select Arial italic 8
			    $pdf->SetFont('arial','I',8);
			    // Print centered page number
			    $pdf->Cell(0,10,"Este material impresso pelo ".$nome_usuario,0,1,'J');
			// F - Lição 07

			$pdf->AddPage();	

			// I - Lição 08
				//Capa
				$pdf->SetFont('arial','B',18);
				$pdf->Cell(0,0,utf8_decode("Lição 08"),0,0,'C');
				$pdf->Ln(10);
				
				$pdf->Image('../../capa.jpg',50,300,500,300);

				//Título da Lição
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(50,20,utf8_decode("8. Fidelidade - Branco - Parábola dos Talentos"),0,1,'L');

				
				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Pegando os Cestos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Você sabe a diferença entre um alimento orgânico e um não orgânico? Um alimento orgânico é aquele que não sofre influências exteriores à terra e ao que é produzido pela própria terra, para se desenvolver! Vamos ver se vocês entenderam, vou dar alguns exemplos e vocês vão me dizer se é orgânico ou não: Você coloca esterco para fertilizar o milho, esterco vem de onde? Então é orgânico! Você coloca fertilizante industrializado no milho? Você aplica produtos químicos para melhorar a semente do milho? Você faz seleção das sementes do milho? Você cruza a semente do milho com a semente de outras plantas resistentes a pragas? Você planta outras plantas ao redor de seu milho para evitar pragas? Você coloca pesticidas na sua plantação de milho para evitar pragas. "),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("Qual o alimento mais confiável o orgânico ou os outros? O orgânico! Algumas estratégias que as pessoas utilizam para produzir, não fazem mal ao homem, como alguns pesticidas que matam somente as pragas, mas outras, podem fazer muito mal e até causar doenças! Então se você pode fazer uma horta na sua casa é bem melhor! Os orgânicos são mais confiáveis! E o interessante é que as coisas mais orgânicas demoram mais a crescer, mas são melhores, mais confiáveis!"),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("Você acha que é importante ser uma pessoa confiável? Essa é mais uma manifestação do Espírito Santo em nossas vidas - FIDELIDADE. Ser fiel, ser confiável!  Você conhece alguém que é confiável, que nunca falha? Porque você acha que as pessoas não cumprem o que prometem, ou não fazem o que falam? Você já fez isso? Nós temos a natureza pecaminosa, e é ela nos leva a pensar em nós mesmos, a ser sem compromisso, não cumprir a palavra, deixar pra depois... Você gostaria de ser confiável como os orgânicos? Vamos para nossa Operação Verde para descobrir como!"),0,'J');

				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Limpando os Galhos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("O fruto da terra de cor branca nos lembra a fidelidade, sabe porquê? Por que eles nos ajudam com o que sustenta o nosso corpo. Com o que faz nosso corpo ser confiável! O que faz o nosso corpo ficar de pé? O que torna minhas pernas confiáveis para andar e correr? (Fig.8.1) Minha estrutura, meus ossos, nervos e músculos! Os alimentos brancos tem potássio, que ajuda seus músculos a serem fortes, e cálcio que fortalece seus ossos! Eles ajudam nossa estrutura a ser confiável! Você se sente confiante para pular e correr? Você sabe que sua estrutura vai lhe suportar! "),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("Você pode lembrar de alimentos de cor branca? Banana, batata, couve-flor, alho e feijão branco. Eles nutrem seu corpo para que ele seja confiável! O que nutre nosso espírito, para que nos tornemos pessoas confiáveis? A Palavra de Deus! E o Espírito Santo nos ajuda a compreender e obedecer a Palavra, Ele nos ajuda quando temos dúvida ou medo, nos ajuda quando desanimamos! Ele nos ajuda a produzir fidelidade! A quem devemos ser fiéis em primeiro lugar? A quem mais devemos ser fiéis? Mas e se o governo ou a escola nos mandarem fazer algo que é contra Deus? A quem devemos ser fiéis? Mas, porque devemos ser fiéis a Deus? Porque Ele é fiel a Sí mesmo e a nós!  Escutem esse versículo: "),0,'J');
				
				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Deus não é homem para que minta, nem filho de homem para que se arrependa. Acaso ele fala e deixa de agir? Acaso promete e deixa de cumprir? Números 23:19"),0,'J');
				
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Mas e quando acontecem coisas ruins? Deus não está sendo fiel nestes momentos? O que vocês acham? Sabemos de tudo que vai nos pensamentos de Deus? Algumas coisas Deus permiti que aconteçam, mas Ele transforma essas coisas em bem e aprendemos com elas! Deus é fiel! "),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Sabemos que Deus age em todas as coisas para o bem daqueles que o amam, dos que foram chamados de acordo com o seu propósito. Romanos 8:28"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Vamos ler a Parábola dos Talentos para entender mais sobre fidelidade!"),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode(" (Fig.8.2) Portanto, vigiem, porque vocês não sabem o dia nem a hora! E também será como um homem que, ao sair de viagem, chamou seus servos e confiou-lhes os seus bens. A um deu cinco talentos, a outro dois, e a outro um; a cada um de acordo com a sua capacidade. Será que Deus sabe do que somos capazes? Sabe de nossos medos e falhas? Em seguida partiu de viagem. O que havia recebido cinco talentos saiu imediatamente, aplicou-os, e ganhou mais cinco. Também o que tinha dois talentos ganhou mais dois. (Fig.8.3) Mas o que tinha recebido um talento saiu, cavou um buraco no chão e escondeu o dinheiro do seu senhor. "),0,'J');
				
				$pdf->Image('../../capa.jpg',50,300,500,300);

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("O que os 2 primeiros fizeram? Um empresário lhe deixa com sua empresa, o que você faria? Fecharia as portas para não perder dinheiro ou tentaria fazer o negócio render dentro de suas capacidades? "),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Depois de muito tempo o senhor daqueles servos voltou e acertou contas com eles. O que tinha recebido cinco talentos trouxe os outros cinco e disse: O senhor me confiou cinco talentos; veja, eu ganhei mais cinco. O senhor respondeu: Muito bem, servo bom e fiel! Você foi fiel no pouco; eu o porei sobre o muito. Venha e participe da alegria do seu senhor! Veio também o que tinha recebido dois talentos e disse: O senhor me confiou dois talentos; veja, eu ganhei mais dois. O senhor respondeu: Muito bem, servo bom e fiel! Você foi fiel no pouco; eu o porei sobre o muito. Venha e participe da alegria do seu senhor! (Fig.8.4) Por fim veio o que tinha recebido um talento e disse: Eu sabia que o senhor é um homem severo, que colhe onde não plantou e junta onde não semeou. Por isso, tive medo, saí e escondi o seu talento no chão. Veja, aqui está o que lhe pertence. O senhor respondeu: Servo mau e negligente! Você sabia que eu colho onde não plantei e junto onde não semeei? Então você devia ter confiado o meu dinheiro aos banqueiros, para que, quando eu voltasse, o recebesse de volta com juros. Tirem o talento dele e entreguem-no ao que tem dez. Pois a quem tem, mais será dado, e terá em grande quantidade. Mas a quem não tem, até o que tem lhe será tirado. Mateus 25:13-29"),0,'J');
			
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("O último servo conhecia seu senhor? Ou julgou seu Senhor? Se ele quisesse mais do que os servos poderiam dar o que teria feito aos outros? Porque vocês acham que aquele homem escondeu o talento? Aquele homem se mostrou confiável para cuidar do que Deus lhe havia dado? O que Deus tem dado a você? Você tem cuidado? Tem multiplicado? Deus lhe deu inteligência? Como estão seus estudos? Lhe deu tempo? Como você tem usado seu tempo? Lhe deu roupas, sapato, quarto? Como tem cuidado? As vezes exige trabalho, cansaço, forças! Mas Você o que um soldado diz? Missão dada é missão cumprida!"),0,'J');

				$pdf->MultiCell(0,15,utf8_decode("Vamos lembrar de Jesus? Ele tinha uma tarefa no mundo? Completar essa tarefa custou alguma coisa a Ele? Você pode confiar em Jesus? Vamos orar e pedir ao Senhor que nos ajude a ter esse poder sobrenatural de sermos fiéis! Custe o que custar! "),0,'J');

				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Preparando para a colheita:"),0,1,'L');
				

				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Oração - Senhor, Te agradecemos pela Tua fidelidade, porque podemos confiar no Senhor, mesmo quando tudo está difícil! Nos ajude a sermos filhos fiéis, alunos fiéis e amigos fiéis, sempre obedecendo ao Senhor em tudo o que fazemos!"),0,'J');
				$pdf->Ln(10);

				$pdf->MultiCell(0,15,utf8_decode("Versículo para memorizar 4"),0,'J');
				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Não te desamparem a benignidade e a fidelidade; ata-as ao teu pescoço; escreve-as na tábua do teu coração. E acharás graça e bom entendimento aos olhos de Deus e do homem. Provérbios 3:3,4"),0,'J');
				$pdf->Ln(5);
				
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Mistério 4 - A Dupla Orgânica"),0,'J');
				$pdf->Ln(5);
				
				$pdf->MultiCell(0,15,utf8_decode("* O que é um alimento orgânico?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Por que ele é melhor?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* O que é felicidade?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como você pode ser bom para os outros?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* O que impede você de se tomar orgânico?"),0,'J');	

				$pdf->ln(1);
			    // Select Arial italic 8
			    $pdf->SetFont('arial','I',8);
			    // Print centered page number
			    $pdf->Cell(0,10,"Este material impresso pelo ".$nome_usuario,0,1,'J');
			// F - Lição 08
			
			$pdf->AddPage();	

			// I - Lição 09
				//Capa
				$pdf->SetFont('arial','B',18);
				$pdf->Cell(0,0,utf8_decode("Lição 09"),0,0,'C');
				$pdf->Ln(10);
				
				$pdf->Image('../../capa.jpg',50,300,500,300);

				//Título da Lição
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(50,20,utf8_decode("9. Mansidão - Amarelos - Tito"),0,1,'L');

				
				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Pegando os Cestos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("(Leve para o encontro pequenas borboletas desenhadas em papel e recortadas, e canudos para todos.) Tenho um desafio para vocês! Vocês vão levar essas borboletas até usando apenas um canudo! Vamos ver quem consegue, sem derrubar! (O objetivo é que as crianças suguem as borboletas e levem-nas gentilmente até o local indicado. Ao final da atividade compartilhem como foi a experiência). Quem conseguiu? Quais as dificuldades? O que ajudou? A pressa ajuda ou atrapalha? Ter força faz diferença? O que fez a diferença? Calma, gentileza, firmeza! Essas são as características da manifestação do fruto do Espírito que vamos aprender hoje! Vamos falar o que já conhecemos? Amor, alegria, paz, longanimidade, benignidade, bondade, fidelidade... e hoje vamos analisar a Mansidão! Quais as características da mansidão? Calma, gentileza, firmeza! Na Bíblia tem um significado muito legal, significa PODER SOB CONTROLE! Uau! Vamos entender melhor! Eu tenho força para levar as borboletas? Mas se eu colocar toda a minha força, o que acontece? E se eu fizer com toda a minha velocidade ajuda? Eu preciso controlar na medida certa minha respiração e a velocidade para fazer a borboleta chegar do outro lado."),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("É fácil nos controlarmos quando alguém nos provoca? É fácil aceitar algo que demora? É fácil ser paciente quando as pessoas não querem mudar? Não é! Eu quero usar minha força e meu poder para resolver as coisas e conseguir o que eu quero. Isso dá certo? Você afasta as pessoas ou trás elas para junto de você quando você é paciente e calmo? Você acha que consegue ser manso todo tempo? Mansidão é um poder sobrenatural! Para entender melhor vamos para a nossa operação verde? "),0,'J');
				
				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Limpando os Galhos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Que cores do fruto da terra nós já conhecemos?  Vermelho, laranja, marrom, verde claro, preto, roxo e branco. Hoje eu vou falar as características do fruto da terra que lembra a mansidão e vocês vão me falar a cor. Tem vitaminas B3 e C, ajudam a proteger o coração, retardam o envelhecimento e ajudam na visão, além de ajudar nas defesas do corpo e deixar nossa pele linda. UAU! Temos como exemplo o Mamão, abóbora, milho, abacaxi e manga. Que cor é? Exatamente! (Fig.9.1) Amarelo! "),0,'J');
				
				$pdf->SetFont('arial','I',12);
				
				$pdf->MultiCell(0,15,utf8_decode("Quem aqui gosta de maracujá? Que cor é o maracujá? Vocês sabiam que o maracujá tem substâncias que agem no sistema nervoso central e atuam como tranquilizantes, analgésicos e relaxantes musculares. Por isso ajudam a combater a ansiedade, a depressão e a insônia? O maracujá nos ajuda então a sermos mais mansos? Mas será que sempre vai funcionar? Não! Nós temos a natureza pecaminosa! Mas o Espírito Santo quer frutificar em nós esse poder sobrenatural da mansidão. Hoje vamos conhecer um personagem da Bíblia que é pouco conhecido das crianças. O nome dele é Tito! (Fig.9.2) Conhecemos Tito porque Paulo lhe mandou uma carta pessoal!"),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("Tito nasceu na Grécia e seu discipulador foi Paulo. Tito o acompanhou na viagem para Jerusalém quando Paulo foi defender diante dos judeus que Jesus era para todos os povos, não somente para o povo de Israel! Durante o tempo em que Paulo esteve em Éfeso, Tito o ajudou a compreender o povo grego e demonstrou a Paulo que era um bom administrador e sabia lidar com pessoas! "),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("Eles eram muito amigos! Tanto que Paulo o colocou como presbítero chefe das igrejas da ilha de Creta. Essa é a carta de Paulo a Tito. Vamos ler alguns trechos!"),0,'J');
				
				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("A Tito, meu verdadeiro filho em nossa fé comum: Graça e paz da parte de Deus Pai e de Cristo Jesus, nosso Salvador. Tito 1:4"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Porque Paulo chama Tito de “verdadeiro filho na fé”? Você é filho na fé de alguém? De quem? Você sabia que você já poder ter filhos na fé? Se você falar de Jesus para sua vó e ela receber Jesus como seu salvador, o que você será? Pai ou mãe na fé, de sua avó! Uau! E um pai ou uma mãe deve deixar seu filho depois que ele nasce? O quê um pai e uma mãe devem fazer? Cuidar, alimentar! Como cuidamos de nossos filhos espirituais? Como eu cuido de vcs? Orando uns pelos outros, aconselhando na Palavra, ajudando a conhecer a Deus... Paulo cuidou bem de Tito, seu discípulo e agora dá algumas instruções a ele. Vamos continuar..."),0,'J');

				$pdf->Image('../../capa.jpg',50,300,500,300);

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("(Fig.9.3) Mas você ensine o que está de acordo com a sã doutrina. Quanto aos homens idosos, que sejam moderados, respeitáveis, sensatos, sadios na fé, no amor e na perseverança. Tito 2:1,2 "),0,'J');

					$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Tito era idoso? Não! Mas ele deveria ensinar aos homens idosos porque ele era sábio! Como ele se tornou sábio? Conhecendo a Deus através das escrituras! E ele devia ensinar aos idosos a serem moderados, sensatos. O que significa ser moderado e sensato? Ser controlado! "),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Do mesmo modo, quanto aos mais jovens, exorte-os para que, em todas as coisas, sejam moderados. Tito 2:6"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("O que ele repete aqui? Novamente! Moderado!"),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Lembre a todos que se sujeitem aos governantes e às autoridades, que sejam obedientes e estejam prontos para toda boa obra. Que não difamem ninguém. Que sejam pacíficos, cordiais, dando provas de toda cortesia para com todos"),0,'J');
				
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode(". O que é ser pacífico? Buscar a paz com todos! E tratar com cortesia? Tratar com gentileza! Então tanto idosos quanto jovens deveriam ser o que? Gentis, pacificadores e moderados, controlados. E Paulo fala com o próprio Tito: "),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Em tudo seja você mesmo um exemplo para eles, fazendo boas obras. Em seu ensino, mostre integridade e seriedade; use linguagem sadia, contra a qual nada se possa dizer, para que aqueles que se lhe opõem fiquem envergonhados por não terem nada de mal para dizer a nosso respeito. Tito 2:7,8"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Vocês têm uma palavra que resume essas qualidades? Manso! E qual o oposto de ser manso? Vamos ler na carta. Pois nós também, no passado, éramos insensatos, desobedientes, desgarrados, escravos de todo tipo de paixões e prazeres, vivendo em maldade e inveja, sendo odiados e odiando-nos uns aos outros. Parece a descrição de alguém manso? De alguém que é controlado pelo Espírito de Deus? Não, é o oposto! É isso que a nossa velha natureza nos leva a fazer - odiar! Graças a deus que Jesus nos libertou de sermos escravos dessa natureza de pecado, agora podemos falar não para essas coisas e pedir ajuda a Deus para sermos mansos de coração! Escutem..."),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Mas quando se manifestou a bondade de Deus, nosso Salvador, e o seu amor por todos, ele nos salvou, não por obras de justiça praticadas por nós, mas segundo a sua misericórdia. Ele nos salvou mediante o lavar regenerador e renovador do Espírito Santo, Tito 3:1-5"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Paulo ainda continua dando conselhos a Tito!"),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("(Fig.9.4) Evite discussões tolas, genealogias, controvérsias e debates sobre a lei; porque são inúteis e sem valor."),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Como podemos ter forças para evitar discussões? Para ser pacificador e gentil com as pessoas? Esse é um poder sobrenatural que vem do Senhor, é o fruto do Espírito Santo nas suas vidas e na minha! (Conte um testemunho de mansidão em sua vida) Tito era da confiança de Paulo porque ele tinha o fruto do Espírito em sua vida: amor, alegria, paz, longanimidade, benignidade, bondade, fidelidade, mansidão... isso era visto! Tanto que Paulo o colocou como líder de várias igrejas. Tito tinha “poder sob controle”. Você quer ser manso e ter a sua força e as suas emoções sob controle? Vamos orar..."),0,'J');

				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Preparando para a colheita:"),0,1,'L');
				

				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Oração - Senhor, muito obrigado porque não somos mais escravos da natureza de pecado! Nos ajude a sermos mansos, a controlar nossa boca, nossa raiva, nossos pensamentos. Nós não conseguimos sozinhos, mas teu Espírito Santo pode nos dar esse poder sobrenatural. Nos ajude para que possamos, como Tito, ajudar outros! Em nome de Jesus, Amém!"),0,'J');
				$pdf->Ln(10);

				$pdf->MultiCell(0,15,utf8_decode("Versículo para memorizar 4"),0,'J');
				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Melhor é o homem paciente do que o guerreiro, mais vale controlar o seu espírito do que conquistar uma cidade. Provérbios 16:32"),0,'J');
				$pdf->Ln(10);
				
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Mistério 4 - O Poder da Clorofila"),0,'J');
				$pdf->Ln(10);

				$pdf->Image('../../capa.jpg',50,300,500,300);
				
				$pdf->MultiCell(0,15,utf8_decode("* O que é Clorofila?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Que poder é esse?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Que mais ela faz em nosso corpo?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como devemos usar nossa energia?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como dominar a mim mesmo?"),0,'J');	

				$pdf->ln(10);
			    // Select Arial italic 8
			    $pdf->SetFont('arial','I',8);
			    // Print centered page number
			    $pdf->Cell(0,10,"Este material impresso pelo ".$nome_usuario,0,1,'J');
			// F - Lição 09
			
			$pdf->AddPage();	

			// I - Lição 10
				//Capa
				$pdf->SetFont('arial','B',18);
				$pdf->Cell(0,0,utf8_decode("Lição 10"),0,0,'C');
				$pdf->Ln(10);
				
				$pdf->Image('../../capa.jpg',50,300,500,300);

				//Título da Lição
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(50,20,utf8_decode("10. Domínio Próprio - Verdes - Sansão"),0,1,'L');

				
				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Pegando os Cestos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Vamos fazer uma brincadeira? Vamos formar um círculo. Agora, vamos escolher uma criança para sair da sala e quando ela voltar ela vai tentar fazer os outros que estão círculo rirem, se ela conseguir fazer 3 rirem o último vai levantar e ela vai sentar em seu lugar. Pode sair! (Tente fazer exercícios de respiração para que todos se acalmem e chame a criança, brinquem algumas vezes) E aí crianças? Foi difícil segurar o riso? Porque foi difícil? Quem usou alguma estratégia para não rir? Que estratégia seria a melhor? O que vocês acabaram de fazer foi o exercício da última manifestação do fruto do Espírito Santo em nossas vidas. Domínio próprio! O que vocês acham que é domínio próprio? Dominar a si mesmo! Ele parece com mansidão, mas mansidão você tem em relação as pessoas que estão ao seu redor. Domínio próprio você exerce com você mesmo! Por exemplo: Quem aqui tem medo de algo? É difícil dominar a si mesmo quando você tem medo? E quando você quer algo e não pode ter ainda? É difícil dominar a si mesmo? Não fazer birra, não chorar, não ficar zangado! Mas o medo é sempre ruim? A vontade de ter algo é ruim? Ruim é quando eu deixo essas forças que estão em mim me controlarem em vez de eu controlá-las! O que o nosso versículo diz? ... mais vale controlar o seu espírito do que conquistar uma cidade. Uau! Como podemos ter esse controle? Vamos ver em nossa última operação verde!"),0,'J');
				
				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Limpando os Galhos:"),0,1,'L');
				 
				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Que cor é esse abacate? Que outros frutos da terra são verdes? Vamos fazer algo bem gostoso? (Bata abacate com leite em pó e um pouco de limão e distribua nos copinhos para que provem!) (Fig.10.1) Vocês sabiam que os alimentos verdes tem clorofila e a clorofila é um energético natural? Ela fornece energia para nossas células além de limpar o organismo e impedir que ele absorva substâncias químicas. O Abacate, brócolis, espinafre e abacate nos dão uma energia saldável! Esse fruto nos lembra o domínio próprio porque ele nos ajuda a conduzir nossa energia de maneira saldável! A Bíblia nos conta de um homem que tinha muita energia e muita força, foi o homem mais forte que já existiu, quem sabe quem é? Vamos escutar sua história e aprender a dominar toda a energia que temos!"),0,'J');
				
				$pdf->MultiCell(0,15,utf8_decode("(Fig.10.2) Um dia um anjo apareceu a uma mulher que não podia ter filhos e depois a seu marido dizendo que eles teriam um filho, só que ele seria Nazireu, um nazireu tinha que viver com algumas regras: Não podia beber bebida forte, álcool, não podia cortar os cabelos nem tocar em nada morto ou imundo. Manoá e sua esposa esperaram e tiveram um filho e lhe deram o nome de Sansão e lhe ensinaram como deveria viver! Sansão se tornou um homem super forte!"),0,'J');
				
				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("E o Espírito do Senhor começou a agir nele... Juízes 13:25 Voltou para casa e disse ao seu pai e à sua mãe: — Vi uma mulher em Timna, das filhas dos filisteus, e agora gostaria que a buscassem para ser a minha esposa. Porém o seu pai e a sua mãe lhe disseram: — Será que não há mulher entre as filhas de seus parentes ou entre todo o nosso povo, para que você tivesse de ir procurar uma esposa no meio dos filisteus, aqueles incircuncisos? Mas Sansão disse ao seu pai: — Busquem essa mulher para mim, porque é só dela que me agrado. Juízes 14:2,3"),0,'J');
				
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Um israelita não deveria se casar com pessoas de outros povos que adoravam outros deuses. O que vocês acham da atitude de Sansão? Ele estava dominando seus desejos? Como vocês acham que isso vai terminar? Vamos ver... Um dia Sansão estava indo buscar sua mulher e deu de cara com um leão, UAU! Um leão tem força? Mas a Bíblia diz que Sansão rasgou o Leão ao meio e seguiu seu caminho, mas desviou-se e passou por uma vinha e bebeu do seu fruto, ele não deveria ter bebido porque suco de uva fermenta e é como álcool só que mais fraco. E na volta para casa..."),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("E, afastando-se do caminho para ver o corpo do leão morto, eis que havia nele um enxame de abelhas com mel. Pegou o favo nas mãos e se foi andando e comendo dele. Quando chegou onde estavam o seu pai e a sua mãe, deu-lhes um pouco do mel, e eles comeram. Mas Sansão não lhes contou que havia tirado o mel do corpo do leão."),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Tem algo de errado ai? Ele tocou em um animal morto! Ter fome é errado? Não, mas comer o que não deve é! Sansão dominou sua fome? Não! Então, no casamento dele havia 30 homens do povo de sua noiva e ..."),0,'J');
			
				$pdf->Image('../../capa.jpg',50,300,500,300);

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Então Sansão lhes disse: — Vou propor um enigma para que vocês o decifrem. Se, nos sete dias das bodas, vocês puderem decifrá-lo e me explicar o seu significado, darei a vocês trinta túnicas e trinta mudas de roupa. Se não puderem me explicar o significado, vocês me darão as trinta túnicas e as trinta mudas de roupa. E eles disseram: — Apresente-nos o enigma. Queremos ouvi-lo. Sansão disse: “Do que come saiu comida, e do forte saiu doçura.” E, em três dias, não puderam decifrar o enigma. Juízes 14:8-14"),0,'J');

					$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Do que Sansão estava falando? Do leão! Sansão estava fazendo graça com seu pecado de quebrar os votos de Nazireu e sua falta de domínio próprio. Por causa disso, sua noiva terminou por trair a confiança de Sansão e contou aos 30 homens o enigma. Sansão ficou furioso! E mais uma vez não se dominou... "),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("matou trinta homens daquela cidade, pegou as roupas deles e as deu aos que decifraram o enigma. Porém Sansão ficou irado e voltou para a casa do seu pai. Quanto à mulher de Sansão, foi dada em casamento ao homem que tinha sido o seu amigo de honra. Juízes 14:19,20  Quando soube disso ... Então saiu, apanhou trezentas raposas e pegou um bom número de tochas. Amarrou as raposas duas a duas pela cauda e prendeu uma tocha em cada par. Pôs fogo nas tochas e largou as raposas nas plantações dos filisteus. Juízes 15:4,5 "),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Os filisteus então, armaram para matar Sansão mas ... (Fig.10.3) "),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Ele Achou uma queixada de jumento, ainda fresca, pegou-a na mão e com ela matou mil homens. Juízes 15:13-15"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Mais uma vez pegou num animal morto! Quanta desgraça em sua vida e cada vez mais Sansão quebrava seu voto de Nazireu. Novamente, Sansão escolheu outra mulher que não era de seu povo, seu nome era Dalila. Os filisteus então pagaram Dalila para enganar Sansão e conseguir saber dele o segredo de sua força, pois queriam pegá-lo! "),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Então Dalila disse a Sansão: — Peço que você me conte em que consiste a sua grande força e com que você poderia ser amarrado e subjugado. Juízes 16:5,6"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Depois de enganar Dalila 3 vezes Sansão contou o que achava ser o segredo de sua força. ..."),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Nunca foi passada uma navalha na minha cabeça, porque sou nazireu consagrado a Deus desde o ventre de minha mãe. Se o meu cabelo for cortado, a minha força irá embora, ficarei fraco e serei como qualquer outro homem. Juízes 16:17"),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Sansão quebrou seu último voto! Dalila o fez dormir, cortou seus cabelos e ele foi capturado por seus inimigos, furaram seus olhos e o colocaram como escravo, preso. Que triste é não ter domínio próprio, o que vocês acham? Enquanto estava na prisão, Sansão se arrependeu do que havia feito e seu cabelo crescia. Um dia, levaram Sansão a um grande templo e o trouxeram diante de uma multidão para rirem dele. Então aconteceu o seguinte... "),0,'J');

				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Sansão disse ao moço que o guiava pela mão: — Deixe-me apalpar as colunas que sustentam o templo, para que eu possa me encostar nelas. Ora, o templo estava cheio de homens e mulheres, e também ali estavam todos os governantes dos filisteus. E sobre o teto havia uns três mil homens e mulheres, que olhavam enquanto Sansão os divertia. (Fig.10.4) Sansão clamou ao Senhor e disse: — Senhor Deus, peço-te que te lembres de mim. Dá-me força só mais esta vez, ó Deus, para que eu me vingue dos filisteus, que furaram os meus olhos.Em seguida, Sansão abraçou-se às duas colunas do meio, que sustentavam o templo, e fez força sobre elas, com a mão direita em uma e com a esquerda na outra. E disse: — Que eu morra com os filisteus. E empurrou com toda a sua força, e o templo caiu sobre os governantes e sobre todo o povo que ali estava. Assim, foram mais os que Sansão matou quando morreu do que os que ele havia matado durante toda a sua vida. Juízes 16:26-30 "),0,'J');

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Sansão precisava ter passado por tudo isso para livrar seu povo dos Filisteus? Ele poderia ter tido domínio próprio, porque ele tinha o Espírito Santo, mas ele escolheu não controlar seus desejos e força. Você quer ter domínio de sí mesmo? Dominar seus desejos e sua força? Você precisa fazer 2 coisas! Começar a exercitar nas coisas pequenas: estudo, hora de dormir, tempo devocional... E pedir ajuda sempre a Deus para que ele lhe dê o poder sobrenatural de dominar a si mesmo! Vamos orar!"),0,'J');
				
				$pdf->Image('../../capa.jpg',50,300,500,300);

				//Tópico
				$pdf->Ln(10);
				$pdf->SetFont('arial','B',12);
				$pdf->Cell(90,20,utf8_decode("Preparando para a colheita:"),0,1,'L');
				
				$pdf->Image('../../capa.jpg',50,300,500,300);

				//Texto
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Oração - Senhor nos ajude a ter o fruto do espírito em nossa vida, para que vivamos bem e possamos mostrar em nossas vidas que Deus é poderoso para fazer o sobrenatural na vida de quem o ama! Em nome de Jesus! Amém!"),0,'J');
				$pdf->Ln(10);

				$pdf->MultiCell(0,15,utf8_decode("Versículo para memorizar 4"),0,'J');
				$pdf->SetFont('arial','I',12);
				$pdf->MultiCell(0,15,utf8_decode("Melhor é o homem paciente do que o guerreiro, mais vale controlar o seu espírito do que conquistar uma cidade. Provérbios 16:32"),0,'J');
				$pdf->Ln(10);
				
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Mistério 4 - O Poder da Clorofila"),0,'J');
				$pdf->Ln(10);
				
				$pdf->MultiCell(0,15,utf8_decode("* O que é Clorofila?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Que poder é esse?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Que mais ela faz em nosso corpo?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como devemos usar nossa energia?"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como dominar a mim mesmo?"),0,'J');	

				$pdf->ln(10);
			    // Select Arial italic 8
			    $pdf->SetFont('arial','I',8);
			    // Print centered page number
			    $pdf->Cell(0,10,"Este material impresso pelo ".$nome_usuario,0,1,'J');
			// F - Lição 10
		
			$pdf->AddPage();

			// I - Resposta do Mistério
				//$pdf->Image('logog8.jpg');
				$pdf->Ln(8); 
				$pdf->SetFont('arial','B',18);
				$pdf->Cell(0,5,utf8_decode("CAMP BRASIL"),0,1,'C');
				$pdf->Ln(8);
				$pdf->Cell(0,5,"","B",1,'C');
				$pdf->Ln(8);

				$pdf->Image('../../capa.jpg',50,300,500,300);

				$pdf->SetFont('arial','B',14);
				
				if ($xL != 0 OR $xD != 0) {
					$pdf->Cell(150,20,utf8_decode("$nivel:"),0,0,'J');
				}else{
					$pdf->Cell(150,20,utf8_decode("$nivel:"),0,0,'J');		
				}
				
				$pdf->Cell(0,20,utf8_decode($nome_usuario),0,1,'J');
				$pdf->Ln(8);

				$pdf->Cell(60,20,utf8_decode("Módulo:"),0,0,'J');
				$pdf->Cell(0,20,utf8_decode($modulo['nome_modulo']),0,1,'J');
				$pdf->Ln(8);

				$pdf->Ln(300); 
				$pdf->SetFont('arial','B',18);
				$pdf->MultiCell(0,15,utf8_decode("Respostas de Mistérios - Operação Verde 1 - A Colheita"),0,'C');
				$pdf->Ln(8);
				$pdf->Cell(0,5,"","B",1,'C');
				$pdf->Ln(400);

				// 01

				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Mistério 1 - O Milagre da Vida"),0,'J');
				$pdf->Ln(10);
				
				$pdf->MultiCell(0,15,utf8_decode("* Quem realiza o milagre? - Deus"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Onde a árvore é plantada? - Ele gera a vida e salvação"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como ela cresce? - A imagem de Jesus cresce em nós através da Palavra e do Espírito Santo"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Qual a condição para dar fruto? - Estar preso à videira Jesus"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como o amor age em nós? - Amor"),0,'J');

				// 02

				$pdf->Ln(10);
				
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Mistério 2 - Manifestações Sobre-Humanas"),0,'J');
				$pdf->Ln(10);
				
				$pdf->MultiCell(0,15,utf8_decode("* Que manifestações são essas? - Os frutos do Espírito"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Por que são sobre-humanas? - Porque são produzidas pelo Espírito Santo"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como ter essas manifestações? - Se andamos fazemos a vontade do Espírito"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* O que o fruto laranja evita? - Tristeza e desespero"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* O que o fruto marrom evita? - Preocupação"),0,'J');

				// 03
				$pdf->Ln(10);
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Mistério 3 - A Verdadeira Resistência "),0,'J');
				$pdf->Ln(10);
				
				$pdf->MultiCell(0,15,utf8_decode("* Qual a verdadeira resistência? - Esperar com paciência sempre sendo bom"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* A quê ela resiste? - As situações difíceis e ao mal"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como desenvolvê-la? - Buscando ajuda de Deus para amar"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como a longanimidade lhe ajuda? - Me ajuda a resistir nas dificuldades e a mostrar o amor de Deus"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* O que minha benignidade produz nos outros? - Adimiração pela bondade de Deus"),0,'J');

				// 04
				$pdf->Ln(10);
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Mistério 4 - A Dupla Orgânica"),0,'J');
				$pdf->Ln(10);
				
				$pdf->MultiCell(0,15,utf8_decode("* O que é um alimento orgânico? - É aquele que não tem influência de fertilizante ou agrotóxicos artificiais"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Por que ele é melhor? - Porque é mais confiável para a saúde"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* O que é felicidade? - É a característica de quem é confiável"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como você pode ser bom para os outros? - Fazendo coisas para abençoá-los ainda que me custe algo"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* O que impede você de se tomar orgânico? - Minha natureza pecaminosa	e a má influência de outros"),0,'J');

				// 05
				$pdf->Ln(10);
				$pdf->SetFont('arial','',12);
				$pdf->MultiCell(0,15,utf8_decode("Mistério 4 - O Poder da Clorofila"),0,'J');
				$pdf->Ln(10);
				
				$pdf->MultiCell(0,15,utf8_decode("* O que é Clorofila? - Corante verde das plantas"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Que poder é esse? - Ele tem o poder de nos dar energia"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Que mais ela faz em nosso corpo? - Protege nosso corpo, desintoxica, ajuda a reduzir a pressão"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como devemos usar nossa energia? - Da melhor maneira possível para glorificar a Deus"),0,'J');
				$pdf->MultiCell(0,15,utf8_decode("* Como dominar a mim mesmo? - Parando de fazer o que quero e dependendo da força de Deus"),0,'J');	

				$pdf->ln(10);
			    // Select Arial italic 8
			    $pdf->SetFont('arial','I',8);
			    // Print centered page number
			    $pdf->Cell(0,10,"Este material impresso pelo ".$nome_usuario,0,1,'J');
			// F - Resposta do Mistério
 
$nome_relatorio = utf8_decode("Operação Verde 1 - A Colheita");			
$pdf->Output("$nome_relatorio.pdf","I");
?>