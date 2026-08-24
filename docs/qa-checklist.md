# Checklist de QA

## Segurança e escopo

- [ ] Diff contém somente a entrega aprovada.
- [ ] Nenhum segredo, cookie, nonce, backup ou export bruto.
- [ ] Home 509 e homologação 1091 têm papéis claros.
- [ ] Rollback foi preservado e testável.

## Página pública

- [ ] `https://tedtec.com.br/` retorna HTTP 200 sem parâmetros.
- [ ] Header, Hero, Como funciona, Serviços, Sobre, Avaliações e footer estão presentes.
- [ ] Não há faixa branca externa ou overflow horizontal.
- [ ] Console sem erros JavaScript.
- [ ] Links, contatos, redes e compartilhamento funcionam.

## Responsividade

- [ ] 1440 px.
- [ ] 1024 px.
- [ ] 768 px.
- [ ] 390 px.
- [ ] Scroll para baixo e para cima.
- [ ] `prefers-reduced-motion: reduce`.

## Hero

- [ ] Notebook/HUD/grid/órbitas aparecem sem cobrir texto.
- [ ] Curtain reveal é natural e sem gradiente leitoso, blur ou halo.
- [ ] Canvas pausa fora da viewport e retoma ao voltar ao Hero.
- [ ] Conteúdo essencial permanece legível sem Canvas/JavaScript.

## Avaliações

- [ ] Shortcode não aparece literalmente.
- [ ] 12 cards válidos carregados quando `limit="12"`.
- [ ] 3/2/1 cards por vez nos breakpoints definidos.
- [ ] Setas, indicadores, ciclo e resize funcionam.
- [ ] Indicadores preservam o foco após clique, Enter e Space.
- [ ] Swipe não bloqueia o scroll vertical.
- [ ] Nota, total, ordem e link para Google estão coerentes.
- [ ] Fallbacks não introduzem duplicações.

## Footer

- [ ] Uma única instância no DOM.
- [ ] Astra permanece em páginas excluídas/protegidas.
- [ ] Foco, hover, tooltips e ícones preservados.
