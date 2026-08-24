# Fonte factual para case de portfólio

Material de referência para redação futura. Não é o case final e não contém métricas de negócio não verificadas.

## Contexto

A Home da TED TEC combinava uma interface própria com conteúdo WordPress. A seção de avaliações exibia cards gravados manualmente, embora o Rich Showcase já sincronizasse dados do Google. O projeto também evoluiu o Hero, o motion e o footer sem reconstruir o restante do site.

## Problemas tratados

- avaliações públicas desatualizadas por conteúdo hardcoded;
- necessidade de preservar o `tt-carousel` em vez de adotar o widget visual do fornecedor;
- motion técnico com fallback, responsividade e reduced motion;
- risco de mudanças de Hero substituírem conteúdo abaixo dele;
- footer duplicado ou inconsistente entre templates;
- diferença entre conteúdo salvo, preview autenticado e cache público.

## Abordagem

1. auditar WordPress, plugins, feed local, cron e cache sem alterar produção;
2. validar o Rich Showcase como fonte local;
3. criar um adaptador defensivo para reviews;
4. homologar o novo Hero na página privada 1091;
5. promover apenas o conteúdo aprovado para a Home 509;
6. isolar motion e footer em plugins com rollback próprio;
7. validar produção sem sessão em quatro larguras e reduced motion.

## Arquitetura entregue

`Google Reviews → Rich Showcase → base local → TED TEC Reviews Carousel → tt-carousel`

O visitante não dispara consultas ao Google. O adaptador sanitiza, deduplica, ordena e limita a renderização, mantendo o último payload válido e um estado estático sem dados pessoais para indisponibilidade total.

## Contribuição profissional

Rê Araujo conduziu direção, implementação, integração e validação documentadas neste repositório. Formulações públicas devem permanecer compatíveis com essa evidência e não atribuir resultados comerciais sem fonte.

## Evidências utilizáveis

- três plugins próprios com responsabilidades separadas;
- shortcode de 12 avaliações dinâmicas;
- carrossel responsivo em 3/2/1 cards;
- Canvas 2D e JavaScript nativo, sem biblioteca de motion;
- integração pelo hook oficial do Astra;
- fallbacks e procedimento de rollback documentados;
- QA em 1440, 1024, 768 e 390 px e reduced motion.

## Afirmações que exigem confirmação humana

- datas exatas de início e término do projeto;
- papel contratual e composição da equipe;
- ferramentas de design utilizadas fora do código;
- métricas de conversão, tráfego, velocidade, SEO ou receita;
- depoimentos sobre impacto do redesign;
- autorização para publicar capturas, marca e dados de clientes.

## Não afirmar sem evidência

- aumento percentual de conversão ou vendas;
- melhoria de Core Web Vitals;
- cobertura total de testes automatizados;
- autoria exclusiva de todas as partes do site;
- uso de Spline, WebGL, GSAP ou Figma nesta entrega;
- acesso ilimitado a todas as avaliações oferecidas pela API do Google.
