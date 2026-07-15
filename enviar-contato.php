<?php
declare(strict_types=1);

function clean_field(string $value): string
{
    return trim(str_replace(["\r", "\n"], ' ', $value));
}

$nome = clean_field($_POST['nome'] ?? '');
$email = filter_var(clean_field($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$telefone = clean_field($_POST['telefone'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

if ($nome === '' || !$email || $mensagem === '') {
    http_response_code(400);
    echo 'Por favor, preencha nome, e-mail e mensagem.';
    exit;
}

$to = 'contato@lsn.eng.br';
$subject = 'Contato pelo site LSN Engenharia Civil';
$body = "Nome: {$nome}\n";
$body .= "E-mail: {$email}\n";
$body .= "Telefone: {$telefone}\n\n";
$body .= "Mensagem:\n{$mensagem}\n";

$headers = [
    'MIME-Version: 1.0',
    'Content-Type: text/plain; charset=UTF-8',
    'From: LSN Engenharia <contato@lsn.eng.br>',
    "Reply-To: {$nome} <{$email}>",
];

$sent = mail($to, $subject, $body, implode("\r\n", $headers));
?>
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contato | LSN Engenharia Civil</title>
    <link rel="stylesheet" href="assets/css/styles.css">
  </head>
  <body class="message-page">
    <main class="message-card">
      <?php if ($sent): ?>
        <p class="eyebrow">Mensagem enviada</p>
        <h1>Obrigado pelo contato.</h1>
        <p>A LSN Engenharia Civil recebeu sua mensagem e retornara em breve.</p>
      <?php else: ?>
        <p class="eyebrow">Envio nao concluido</p>
        <h1>Nao foi possivel enviar agora.</h1>
        <p>Entre em contato pelo e-mail <a href="mailto:contato@lsn.eng.br">contato@lsn.eng.br</a>.</p>
      <?php endif; ?>
      <a class="btn primary" href="index.html#contato">Voltar ao site</a>
    </main>
  </body>
</html>
