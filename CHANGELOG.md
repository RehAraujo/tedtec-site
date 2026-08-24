# Changelog

As versões abaixo correspondem aos plugins próprios. O site completo ainda não possui versionamento semântico independente.

## Unreleased

- organiza a documentação técnica e operacional do projeto;
- inclui as fontes do Hero motion e do footer global já observadas em produção;
- remove nomes e textos de terceiros do fallback versionado de avaliações;
- preserva o foco dos indicadores do carrossel durante a navegação;
- pausa o Canvas do Hero quando ele está fora da viewport;
- normaliza o link telefônico do footer para o formato internacional;
- protege exports brutos e backups locais contra inclusão acidental no Git.

## TED TEC Reviews Carousel 1.1.0 — 2026-08-24

- adiciona controlador próprio de navegação;
- mantém 3, 2 ou 1 card visível conforme o breakpoint;
- adiciona setas, indicadores, swipe, recálculo no resize e autoplay;
- respeita `prefers-reduced-motion`.

## TED TEC Global Footer 1.0.0 — 2026-08-24

- registra o footer institucional pelo hook `astra_footer`;
- preserva o Astra como fallback;
- adiciona contatos, redes sociais e compartilhamento com fallback de clipboard.

## TED TEC Reviews Carousel 1.0.0 — 2026-08-20

- integra a base local do Rich Showcase ao `tt-carousel`;
- adiciona normalização, sanitização, ordenação e deduplicação;
- adiciona cache da última resposta válida e fallback estático.
