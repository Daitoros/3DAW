/* * auth.js (Versão AJAX)
 * Gerencia a autenticação do lado do cliente (client-side).
 * Verifica o sessionStorage, que é preenchido pelo login.
 */

// Função para verificar se o usuário tem a permissão correta
function protegerPagina(funcaoExigida) {
    // Pega a 'funcao' que foi salva no login
    const funcaoLogada = sessionStorage.getItem('funcao');

    if (funcaoLogada !== funcaoExigida) {
        // Se não tiver a permissão (ou não estiver logado), manda de volta para o login
        window.location.href = 'index.html';
    }
}

// Função de Logoff
function logoff() {
    sessionStorage.removeItem('funcao');
    window.location.href = 'index.html';
}

