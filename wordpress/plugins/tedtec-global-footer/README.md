# TED TEC Global Footer

Fonte única do footer institucional aprovado da TED TEC.

## Funcionamento

- substitui o callback do Astra Footer Builder pelo hook oficial `astra_footer`;
- mantém uma única instância do markup, CSS e JavaScript;
- preserva o Astra como fallback caso o plugin seja desativado;
- exclui administração, previews, feeds, 404, páginas protegidas e a homologação 1091;
- usa links canônicos para as seções da Home;
- mantém Web Share API com fallback para clipboard.

## Rollback

Desative o plugin para restaurar imediatamente o footer configurado no Astra. Na Home 509, restaure a revisão anterior caso também seja necessário recuperar a cópia hardcoded.
