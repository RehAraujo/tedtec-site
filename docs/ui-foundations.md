# Fundamentos de interface

Este documento descreve padrões observados, não uma biblioteca completa de design tokens.

## Direção visual

- identidade escura e técnica no Hero;
- teal/ciano como cor de ação e sinal de sistema;
- superfícies claras para conteúdo racional;
- tipografia de alto contraste e hierarquia direta;
- grid, linhas, órbitas e HUD como detalhes secundários;
- componentes de conversão com rótulos objetivos.

## Hierarquia do Hero

1. mensagem e CTAs;
2. notebook técnico;
3. órbitas e grid;
4. labels de diagnóstico.

O motion não deve comprometer headline, subheadline, botões ou navegação. No mobile, efeitos são simplificados para preservar leitura e desempenho.

## Componentes preservados

- header integrado ao Hero, sem moldura branca externa;
- conteúdo em container, mesmo quando o fundo é full bleed;
- `tt-carousel` como linguagem visual das avaliações;
- footer compacto com links, ícones, tooltips, foco e hover;
- transição escuro–claro curta e reta, sem névoa ou decoração geométrica.

## Acessibilidade

- foco visível em controles interativos;
- labels acessíveis em ícones;
- links externos com `noopener noreferrer` quando aplicável;
- controles do carrossel com nomes e estado atual;
- suporte a `prefers-reduced-motion`;
- conteúdo essencial independente do Canvas.

## Breakpoints funcionais do carrossel

| Largura | Cards visíveis |
| --- | ---: |
| até 640 px | 1 |
| 641–1024 px | 2 |
| acima de 1024 px | 3 |

Esses breakpoints pertencem ao controlador do carrossel. Outros componentes usam regras próprias e devem ser validados nas larguras de QA.
