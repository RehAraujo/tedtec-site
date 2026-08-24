# Decisões técnicas

## Rich Showcase como backend invisível

**Decisão:** usar o feed 954 e a base local do Rich Showcase, preservando a interface própria.

**Motivo:** elimina manutenção manual sem introduzir chamadas ao Google por visitante. O risco da API PHP interna é contido por validação e fallbacks.

## `tt-carousel` preservado

**Decisão:** normalizar dados no backend e renderizar o markup existente.

**Motivo:** mantém identidade, responsividade e controle de interação sem depender do widget visual do fornecedor.

## Plugins pequenos por responsabilidade

**Decisão:** separar reviews, Hero motion e footer.

**Motivo:** reduz acoplamento e permite rollback localizado. O custo é manter três ciclos de versão e compatibilidade.

## JavaScript e Canvas nativos

**Decisão:** não adicionar GSAP, ScrollTrigger ou biblioteca 3D.

**Motivo:** o efeito aprovado cabe em Canvas 2D e APIs do navegador, com menor dependência e fallback simples.

## Footer pelo hook do Astra

**Decisão:** substituir o callback do Footer Builder em `astra_footer`, somente quando elegível.

**Motivo:** integração mais previsível que duplicar markup dentro de páginas e rollback imediato ao desativar o plugin.

## Homologação separada

**Decisão:** manter a página 1091 como rascunho privado e a 509 como Home pública.

**Motivo:** permite revisão autenticada sem criar uma segunda Home pública. Um 404 fora da sessão é esperado para rascunhos privados.

## Exports brutos fora do Git

**Decisão:** ignorar backups e HTML exportado do editor.

**Motivo:** esses arquivos podem conter nonces, links administrativos e metadados transitórios; não são fonte canônica do conteúdo.
