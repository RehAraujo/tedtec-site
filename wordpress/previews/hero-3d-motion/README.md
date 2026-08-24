# TED TEC Hero 3D Motion Preview

Notas sanitizadas do preview privado da página WordPress `1091`. O HTML bruto do editor permanece fora do Git.

## Tecnologia

- HTML e CSS isolados pelo contêiner `#tt3-preview`;
- Canvas 2D com projeção tridimensional própria para o notebook e exploded view;
- SVG inline como fallback visual do notebook;
- JavaScript nativo para renderização, parallax e progresso de scroll;
- nenhuma dependência externa de animação ou 3D.

## Segurança de publicação

A página 1091 continua sendo o ambiente de homologação. O controlador atende também a Home 509, mas qualquer evolução deve ser aprovada no rascunho antes de ser promovida.

## Motion e acessibilidade

Os parâmetros principais ficam centralizados no objeto `motion`. O scroll permanece nativo e usa um único ciclo com `requestAnimationFrame`. Em `prefers-reduced-motion: reduce`, animações, parallax e transições são removidos, preservando toda a informação visual.

## Fallback

Se o Canvas ou seu JavaScript não iniciar, o SVG `.tt3-notebook-wireframe` mantém o notebook técnico visível. Headline, descrição, CTAs e benefícios não dependem do recurso 3D.

## Rollback

Restaure a revisão anterior da página afetada ou reverta somente o plugin de motion. A 1091 deve permanecer disponível como referência de homologação.
