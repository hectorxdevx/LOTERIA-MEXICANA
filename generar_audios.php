<?php
/**
 * generar_audios.php — Generador de audios para Lotería Mexicana vía API de Fish Audio
 * 
 * Uso:
 *   php generar_audios.php [TU_API_KEY]
 *   O bien define la constante FISH_AUDIO_API_KEY abajo.
 */

// 1. Configuración de API Key (puede pasarse por argumento CLI o definirse aquí)
$apiKey = $argv[1] ?? getenv('FISH_AUDIO_API_KEY') ?: 'TU_API_KEY_AQUI';

if ($apiKey === 'TU_API_KEY_AQUI' || empty($apiKey)) {
    echo "====================================================================\n";
    echo "AVISO: No se proporcionó una API Key válida de Fish Audio.\n";
    echo "Uso: php generar_audios.php <TU_API_KEY>\n";
    echo "O define FISH_AUDIO_API_KEY en tu entorno o en este script.\n";
    echo "Nota: El proyecto ya incluye 54 audios .wav generados en audios/\n";
    echo "====================================================================\n";
    exit(1);
}

// 2. Las 54 cartas oficiales de la Lotería Mexicana
$cartas = [
    'EL GALLO', 'EL DIABLITO', 'LA DAMA', 'EL CATRÍN', 'EL PARAGUAS', 'LA SIRENA',
    'LA ESCALERA', 'LA BOTELLA', 'EL BARRIL', 'EL ÁRBOL', 'EL MELÓN', 'EL VALIENTE',
    'EL GORRITO', 'LA MUERTE', 'LA PERA', 'LA BANDERA', 'EL BANDOLÓN', 'EL VIOLONCELLO',
    'LA GARZA', 'EL PÁJARO', 'LA MANO', 'LA BOTA', 'LA LUNA', 'EL COTORRO',
    'EL BORRACHO', 'EL NEGRITO', 'EL CORAZÓN', 'LA SANDÍA', 'EL TAMBOR', 'EL CAMARÓN',
    'LAS JARAS', 'EL MÚSICO', 'LA ARAÑA', 'EL SOLDADO', 'LA ESTRELLA', 'EL CAZO',
    'EL MUNDO', 'EL APACHE', 'EL NOPAL', 'EL ALACRÁN', 'LA ROSA', 'LA CALAVERA',
    'LA CAMPANA', 'EL CANTARITO', 'EL VENADO', 'EL SOL', 'LA CORONA', 'LA CHALUPA',
    'EL PINO', 'EL PESCADO', 'LA PALMA', 'LA MACETA', 'EL ARPA', 'LA RANA'
];

// 3. Modelo de voz: Goku (Mario Castañeda) en Fish Audio
$modeloGoku = '9f850ee9ada24b20a6866825eaefd3f8';

$outputDir = __DIR__ . '/audios';
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0777, true);
}

// 4. Generar audio intro especial con la voz de Goku
$archivoIntro = "$outputDir/intro.mp3";
$textoIntro = "¡Vamos a comenzar chicos, hagan silencio o los agarro a madrazos, comenzamos en 3, 2, 1...!";

echo "====================================================================\n";
echo "Voz configurada: Goku (Mario Castañeda) [ID: $modeloGoku]\n";
echo "====================================================================\n";

if (!file_exists($archivoIntro)) {
    echo "Generando audio INTRO con voz de Goku...\n";
    $payloadIntro = json_encode([
        'text' => $textoIntro,
        'reference_id' => $modeloGoku,
        'format' => 'mp3'
    ], JSON_UNESCAPED_UNICODE);

    $ctxIntro = stream_context_create([
        'http' => [
            'method'  => 'POST',
            'header'  => "Authorization: Bearer $apiKey\r\n" .
                         "Content-Type: application/json\r\n" .
                         "User-Agent: LoteriaMexicana-Bot/1.0\r\n",
            'content' => $payloadIntro,
            'timeout' => 30,
            'ignore_errors' => true
        ]
    ]);

    $audioIntro = @file_get_contents('https://api.fish.audio/v1/tts', false, $ctxIntro);
    $statusIntro = $http_response_header[0] ?? '';

    if ($audioIntro !== false && strpos($statusIntro, '200') !== false) {
        file_put_contents($archivoIntro, $audioIntro);
        echo " -> Audio intro generado exitosamente: audios/intro.mp3\n\n";
    } else {
        echo " -> Error al generar intro ($statusIntro)\n";
        if (strpos($statusIntro, '402') !== false) {
            echo "    [AVISO] Saldo insuficiente en la API de Fish Audio (HTTP 402).\n";
            echo "    Recarga créditos en https://fish.audio/app/developers\n\n";
        }
    }
} else {
    echo "Audio INTRO ya existe: $archivoIntro (omitiendo)\n\n";
}

echo "Iniciando descarga de las 54 cartas con voz de Goku...\n";

foreach ($cartas as $index => $nombre) {
    $num = $index + 1;
    $archivoSalida = "$outputDir/$num.mp3";

    if (file_exists($archivoSalida)) {
        echo "[$num/54] Ya existe: $archivoSalida (omitiendo)\n";
        continue;
    }

    echo "[$num/54] Solicitando: ¡$nombre!... ";

    $payload = json_encode([
        'text' => "¡$nombre!",
        'reference_id' => $modeloGoku,
        'format' => 'mp3'
    ], JSON_UNESCAPED_UNICODE);

    $context = stream_context_create([
        'http' => [
            'method'  => 'POST',
            'header'  => "Authorization: Bearer $apiKey\r\n" .
                         "Content-Type: application/json\r\n" .
                         "User-Agent: LoteriaMexicana-Bot/1.0\r\n",
            'content' => $payload,
            'timeout' => 30,
            'ignore_errors' => true
        ]
    ]);

    $audioData = @file_get_contents('https://api.fish.audio/v1/tts', false, $context);
    $statusLine = $http_response_header[0] ?? '';

    if ($audioData !== false && strpos($statusLine, '200') !== false) {
        file_put_contents($archivoSalida, $audioData);
        echo "OK ($num.mp3)\n";
    } else {
        echo "ERROR ($statusLine)\n";
        if (strpos($statusLine, '402') !== false) {
            echo "   [!] Saldo insuficiente en Fish Audio. La cuenta requiere recarga de créditos API.\n";
            break;
        }
    }

    usleep(500000); // 0.5s
}

echo "\nProceso finalizado.\n";
