# Sistema de motion

## Implementação

O Hero usa JavaScript nativo e Canvas 2D. Não há GSAP, ScrollTrigger ou biblioteca 3D. O plugin `TED TEC Hero Preview` versão 0.3.2 carrega o controlador nas páginas 509 e 1091.

Elementos coordenados:

- notebook técnico e exploded view;
- HUD e labels;
- grid, órbitas, pontos e linhas de rede;
- parallax discreto em dispositivos com ponteiro fino;
- progresso de scroll e curtain reveal para “Como funciona”.

## Princípios

- conteúdo primeiro, decoração depois;
- movimento curto, sutil e reversível;
- `opacity` e `transform` preferidos para elementos DOM;
- um ciclo com `requestAnimationFrame` para atualização visual;
- o ciclo do Canvas pausa quando o Hero sai da viewport e retoma sem duplicar RAFs;
- nenhuma animação deve alterar a estrutura editorial abaixo do Hero.

## Progressão de saída

Durante o scroll, os elementos auxiliares perdem presença antes do notebook. A superfície clara assume a experiência por um reveal controlado; não existe faixa intermediária, blur ou halo como elemento separado.

## Fallbacks

- SVG/HTML mantém o notebook reconhecível caso o Canvas não inicie;
- texto, CTAs e benefícios não dependem do controlador;
- sem JavaScript, a página continua navegável;
- em `prefers-reduced-motion: reduce`, parallax e transições desnecessárias são desativados e o conteúdo permanece legível.

## Performance e QA

Validar:

- um único controlador por página;
- ausência de listeners duplicados e erros no console;
- scroll para baixo e para cima;
- 1440, 1024, 768 e 390 px;
- ausência de overflow horizontal;
- navegação por teclado e reduced motion;
- carregamento restrito às páginas 509 e 1091.
