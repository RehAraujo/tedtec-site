# TED TEC Reviews Carousel

Plugin WordPress que usa as avaliações armazenadas pelo Rich Showcase for Google Reviews como fonte de dados para o `tt-carousel` da TED TEC. O Rich Showcase não participa da renderização visual.

## Finalidade

- eliminar avaliações gravadas manualmente na página inicial;
- preservar integralmente o HTML e as classes esperadas pelo `tt-carousel`;
- mostrar avaliações recentes, nota média e total atualizados;
- manter a seção disponível quando a dependência estiver temporariamente indisponível.

## Instalação

1. Copie `tedtec-reviews-carousel` para `wp-content/plugins/`.
2. Confirme que o Rich Showcase está ativo e que o feed da TED TEC sincroniza normalmente.
3. Ative **TED TEC Reviews Carousel** no WordPress.
4. Insira o shortcode na seção de avaliações da home:

   ```text
   [tedtec_reviews_carousel limit="12"]
   ```

O CSS visual do `tt-carousel` continua pertencendo ao site. O plugin entrega o markup compatível, os dados normalizados e o controlador JavaScript de navegação. O script é enfileirado somente quando o shortcode é renderizado.

## Dependência

- WordPress 6.2 ou posterior;
- PHP 7.4 ou posterior;
- Rich Showcase for Google Reviews (`widget-google-reviews`);
- feed local da TED TEC configurado e sincronizado;
- WP-Cron funcional para as atualizações automáticas do Rich Showcase.

O plugin não contém nem lê diretamente uma Google Places API key. Também não faz chamadas ao Google durante uma visita à página.

## Shortcode e opções

```text
[tedtec_reviews_carousel limit="12"]
```

`limit` controla somente a quantidade renderizada. São aceitos valores de 1 a 30; o padrão é 12. A leitura não reduz nem remove o histórico mantido pelo Rich Showcase.

## Comportamento

O provider localiza o feed da TED TEC, usa a camada PHP do Rich Showcase e converte cada avaliação para um contrato interno. O normalizador:

- ignora avaliações ocultas, incompletas ou sem texto;
- sanitiza nomes, textos e URLs;
- remove duplicidades pelo identificador da avaliação;
- ordena pelo timestamp, da mais recente para a mais antiga;
- aplica o limite somente após a normalização e ordenação.

O template apresenta nota média, total de avaliações, fotos locais quando disponíveis e o conjunto de cards esperado pelo `tt-carousel`.

## Navegação

O arquivo `assets/js/carousel.js` preserva o comportamento do carrossel original:

- 3 cards por vez acima de 1024 px;
- 2 cards por vez entre 641 e 1024 px;
- 1 card por vez até 640 px;
- setas e indicadores por grupo;
- swipe horizontal sem bloquear o scroll vertical;
- recálculo no redimensionamento da viewport;
- autoplay de 5 segundos, pausado durante interação e desativado em `prefers-reduced-motion`;
- inicialização isolada por container, inclusive quando houver mais de um carrossel na página.

## Fallback e resiliência

Quando a leitura do Rich Showcase produz uma resposta válida, o plugin salva o último payload normalizado na opção `tedtec_reviews_last_good`, sem autoload. Em falhas posteriores, a ordem é:

1. último payload válido armazenado pelo plugin;
2. fallback estático sem dados pessoais;
3. mensagem com link para o Google quando não houver avaliações válidas.

O repositório não inclui cópias de nomes ou textos de terceiros no fallback. As avaliações exibidas normalmente continuam vindo da base local; se ela e o último payload válido estiverem indisponíveis, o plugin não fabrica cards.

A ausência da classe, do método, do feed ou da tabela esperada resulta em fallback, sem fatal error.

## Manutenção

- Verifique periodicamente se a integração interna usada pelo provider continua compatível após atualizar o Rich Showcase.
- Monitore a sincronização do feed e o WP-Cron no painel do WordPress.
- Não grave chaves, tokens ou credenciais neste plugin ou neste repositório.
- Atualize a versão do cabeçalho do plugin quando houver uma nova entrega.
- Faça uma validação pública do total, da nota, dos cards e da navegação após cada mudança.

## Compatibilidade

A versão 1.1.0 foi preparada para WordPress 6.2+, PHP 7.4+ e para a API PHP presente na instalação validada do Rich Showcase. Como essa API pertence a outro plugin, mudanças incompatíveis são tratadas defensivamente e acionam o fallback, mas devem ser avaliadas antes de uma atualização relevante da dependência.

## Rollback

1. Restaure a revisão anterior da página inicial que continha os cards estáticos.
2. Desative **TED TEC Reviews Carousel**.
3. Não é necessário remover ou reconfigurar o Rich Showcase.

Desativar o plugin não apaga a opção `tedtec_reviews_last_good`; isso permite reativação segura. Se a remoção definitiva desse dado for necessária, ela deve ser executada separadamente e com backup.
