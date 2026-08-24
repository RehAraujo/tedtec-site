# Estrutura WordPress

## Estado observado

| Elemento | Identificador | Papel |
| --- | ---: | --- |
| Home pública | 509 | Página inicial aprovada |
| Homologação | 1091 | Rascunho privado para comparação e rollback visual |
| Serviços | 1012 | Página pública |
| Área Restrita | 1074 | Página protegida; footer customizado excluído |
| Programas Drive | 904 | Página protegida; footer customizado excluído |

Tema observado: Astra. A Home usa conteúdo editado no WordPress, incluindo HTML/CSS customizado e blocos legados do editor. O conteúdo editorial não é reconstruído a partir deste repositório.

## Home 509

Ordem final observada:

1. header integrado;
2. Hero V2;
3. Como funciona;
4. Serviços;
5. Sobre a TED TEC;
6. avaliações dinâmicas;
7. footer institucional.

O antigo bloco isolado de métricas e o CTA redundante anterior ao footer não fazem parte da composição final aprovada.

## Componentes customizados

- `tedtec-hero-preview`: assets de motion somente para IDs 509 e 1091;
- `tedtec-reviews-carousel`: shortcode e renderização dinâmica;
- `tedtec-global-footer`: substituição localizada do Astra Footer Builder.

## O que não versionar

- `wp-config.php`, banco, usuários e sessões;
- uploads e caches;
- arquivos de hospedagem;
- exports brutos de páginas e backups;
- nonces e URLs administrativas temporárias;
- código de plugins ou tema de terceiros.

Os diretórios locais `wordpress/backups/` e `wordpress/pages/`, assim como `page-*.html` em previews, são deliberadamente ignorados.
