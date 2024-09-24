<?php
// Função para executar um comando Git e retornar o resultado
function getGitInfo($command) {
    return trim(shell_exec($command));
}

// Verificar se o diretório é um repositório Git
if (!is_dir('.git')) {
    echo "Este diretório não é um repositório Git.";
    exit;
}

// Pegar a versão do Git instalada no servidor
$gitVersion = getGitInfo('git --version');

// Pegar o hash do último commit
$gitCommitHash = getGitInfo('git log -1 --format="%H"');

// Pegar o autor do último commit
$gitCommitAuthor = getGitInfo('git log -1 --format="%an"');

// Pegar a data do último commit
$gitCommitDate = getGitInfo('git log -1 --format="%ad" --date=short');

// Pegar a mensagem do último commit
$gitCommitMessage = getGitInfo('git log -1 --format="%s"');

// Pegar a branch atual
$gitBranch = getGitInfo('git rev-parse --abbrev-ref HEAD');

// Exibir os detalhes da versão do Git
echo "<h2>Informações da Versão do Git</h2>";
echo "<p><strong>Versão do Git:</strong> $gitVersion</p>";
echo "<p><strong>Branch Atual:</strong> $gitBranch</p>";
echo "<p><strong>Último Commit:</strong> $gitCommitHash</p>";
echo "<p><strong>Autor
