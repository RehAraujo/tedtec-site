# Rollback

## Princípios

- não excluir a versão anterior antes da validação completa;
- preferir reversão localizada ao restauro integral de uma página;
- não misturar rollback visual com mudanças de cache, cron ou dados;
- registrar o estado anterior e o motivo da reversão.

## Hero e Home

Use a revisão/backup preservado da página 509 para recuperar o conteúdo anterior. A página 1091 permanece como referência de homologação. Se apenas o motion falhar, desative ou reverta somente `tedtec-hero-preview`; não restaure toda a Home automaticamente.

## Avaliações

1. restaure a revisão anterior da seção somente se necessário;
2. desative `TED TEC Reviews Carousel`;
3. mantenha o Rich Showcase e sua base intactos.

O adaptador não altera tabelas do Rich Showcase. Seu único estado próprio é `tedtec_reviews_last_good`.

## Footer

Desative `TED TEC Global Footer` para devolver o hook ao Astra Footer Builder. Páginas excluídas já usam o fallback do tema.

## Verificação

Após reverter, valide URL pública, console, layout, links, shortcode e cache. Não apague backups até a causa estar entendida e a produção estabilizada.
