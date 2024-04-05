<?php
$uploadOk = 0;  // Definindo $uploadOk como 0 como valor padrão
$targetFile = "";  // Inicializando $targetFile como string vazia

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileInput'])) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES['fileInput']['name']);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Verificar se o arquivo é uma imagem real ou um arquivo PDF
    $allowedExtensions = array("jpg", "jpeg", "png", "gif", "pdf", "bmp");
    if (!in_array($fileType, $allowedExtensions)) {
        echo "<p class='upload-message'>Desculpe, apenas arquivos JPG, JPEG, PNG, GIF, PDF e BMP são permitidos.</p>";
        $uploadOk = 0;
    }

    // Verificar se o arquivo já existe
    if (file_exists($targetFile)) {
        echo "<p class='upload-message'>Desculpe, o arquivo já existe.</p>";
        $uploadOk = 0;
    }

    // Definir o tamanho máximo de upload para 10 MB
    ini_set('upload_max_filesize', '10M');

    // Verificar o tamanho do arquivo
    if ($_FILES['fileInput']['size'] > 10000000) { // 10 MB em bytes
        echo "<p class='upload-message'>Desculpe, o arquivo é muito grande.</p>";
        $uploadOk = 0;
    }

    // Verificar se $uploadOk é 0 por um erro
    if ($uploadOk == 0) {
        echo "<p class='upload-message'>Desculpe, o seu arquivo não foi enviado.</p>";
    } else {
        if (move_uploaded_file($_FILES['fileInput']['tmp_name'], $targetFile)) {
            echo "<p class='upload-success'>O arquivo " . htmlspecialchars(basename($_FILES['fileInput']['name'])) . " foi enviado.</p>";
            $uploadOk = 1;  // Definindo $uploadOk como 1 após upload bem-sucedido
        } else {
            echo "<p class='upload-message'>Desculpe, ocorreu um erro ao enviar o seu arquivo.</p>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Upload Concluído</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/img/upload.png" type="image/x-icon">
    <style>
        h1 {
            color: #fff;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            text-align: center;
        }

        .preview-image {
            max-width: 100%;
            /* Definir largura máxima para a imagem */
            max-height: 400px;
            /* Definir altura máxima para a imagem */
            border-radius: 15px;
            /* Adicionar borda arredondada */
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007BFF;
            /* cor de fundo do botão */
            color: #fff;
            /* cor do texto do botão */
            text-decoration: none;
            /* remover sublinhado do link */
            border-radius: 5px;
            /* bordas arredondadas */
            transition: background-color 0.3s ease;
            /* suave transição de cor de fundo */
            text-align: center;
        }

        .btn-back:hover {
            background-color: #0056b3;
            /* cor de fundo do botão ao passar o mouse */
        }

        .upload-message {
            color: #ff0000;
            /* cor vermelha para mensagens de erro */
            font-family: Arial, sans-serif;
            /* fonte Arial para mensagens de erro */
            text-align: center;
            /* centralizar texto */
            margin-top: 20px;
            /* espaço superior */
        }

        .upload-success {
            color: #00cc00;
            /* cor verde para mensagem de sucesso */
            font-family: Arial, sans-serif;
            /* fonte Arial para mensagem de sucesso */
            text-align: center;
            /* centralizar texto */
            margin-top: 20px;
            /* espaço superior */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Upload Concluído</h1>
        <?php if ($uploadOk == 1 && in_array($fileType, array("jpg", "jpeg", "png", "gif"))) : ?>
            <div id="previewContainer">
                <img class="preview-image" src="<?php echo $targetFile; ?>" alt="Pré-visualização">
            </div>
        <?php endif; ?>
        <a href="index.html" class="btn-back">Voltar ao Início</a>
    </div>
</body>

</html>