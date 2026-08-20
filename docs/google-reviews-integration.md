# Integração das avaliações do Google

## Problema

A página inicial da TED TEC exibia 20 avaliações gravadas diretamente no HTML do `tt-carousel`. Enquanto isso, o Rich Showcase for Google Reviews já coletava e armazenava localmente as avaliações do Google. A interface ficava desatualizada mesmo quando a base local recebia avaliações novas.

## Solução

```text
Google Reviews
      ↓
Rich Showcase
      ↓
base local e cache
      ↓
TED TEC Reviews Carousel
      ↓
tt-carousel
```

O Rich Showcase permanece como backend de obtenção e armazenamento. O plugin customizado atua como adaptador e renderiza somente o markup exigido pelo design existente.

Em produção, a página 509 usa:

```text
[tedtec_reviews_carousel limit="12"]
```

## Responsabilidades

### Rich Showcase

- coleta das avaliações no Google;
- sincronização periódica;
- armazenamento local;
- manutenção das fotos locais dos autores;
- dados agregados do estabelecimento.

### TED TEC Reviews Carousel

- leitura defensiva da camada PHP do Rich Showcase;
- conversão para um contrato interno estável;
- normalização e sanitização;
- ordenação por data;
- deduplicação por identificador;
- seleção da quantidade renderizada;
- renderização compatível com o `tt-carousel`;
- último payload válido e fallback estático.

## Comportamento público

- renderiza as 12 avaliações válidas mais recentes por padrão;
- usa nota média e total de avaliações do estabelecimento;
- prioriza fotos locais mantidas pelo Rich Showcase;
- mantém o fallback visual de avatar quando não há foto;
- preserva o link “Ver todas no Google” existente na página;
- acompanha automaticamente as mudanças já presentes na base local;
- não faz chamadas externas ao Google por visitante;
- não expõe chave da Google Places API no HTML ou em JavaScript.

O parâmetro `limit` aceita de 1 a 30 e afeta apenas a renderização. Todas as avaliações disponíveis continuam sob responsabilidade da base local do Rich Showcase.

## Feed e atualização

A instalação validada usa o feed **954** para a unidade TED TEC. A atualização desse feed é responsabilidade do Rich Showcase e depende do WP-Cron. O adaptador não dispara sincronizações e não altera cron, cache ou credenciais da dependência.

O identificador do feed não é uma credencial. Nenhuma API key, token ou senha deve ser incluída no repositório ou nesta documentação.

## Resiliência

O plugin salva a última resposta normalizada válida na opção WordPress `tedtec_reviews_last_good`, com autoload desativado. Se a fonte local ficar indisponível, o fluxo é:

1. tentar obter e validar os dados atuais do Rich Showcase;
2. usar o último payload válido salvo pelo adaptador;
3. usar o fallback estático seguro incluído no plugin;
4. apresentar uma mensagem com acesso às avaliações no Google se não houver conteúdo renderizável.

As seguintes situações são tratadas sem interromper a home:

- Rich Showcase desativado;
- classe ou método interno indisponível;
- feed ausente ou inválido;
- tabela local ausente;
- resposta vazia ou malformada;
- avaliação individual incompleta;
- foto de autor indisponível.

## Segurança

- nomes são tratados como texto simples;
- textos têm HTML removido e são escapados na saída;
- URLs são normalizadas e escapadas;
- identificadores são sanitizados;
- consultas que usam IDs locais são preparadas pelo WordPress;
- nenhum conteúdo de avaliação pode injetar HTML arbitrário;
- nenhuma credencial do Google, WordPress, banco ou hospedagem faz parte do código.

O Place ID e o endereço público do perfil no Google Maps identificam um estabelecimento público; não concedem acesso à API.

## Dependências e risco de compatibilidade

- WordPress 6.2+;
- PHP 7.4+;
- Rich Showcase for Google Reviews;
- feed 954 configurado;
- WP-Cron funcionando;
- CSS e JavaScript existentes do `tt-carousel`.

O provider usa uma camada PHP pertencente ao Rich Showcase. Uma atualização futura pode alterar essa interface. O código verifica a existência da classe, do método e da estrutura retornada; uma incompatibilidade aciona o fallback, mas exige revisão do adaptador.

## Rollback

O rollback operacional é simples:

1. restaurar a revisão anterior da página 509, recuperando os cards estáticos;
2. desativar o plugin TED TEC Reviews Carousel;
3. manter o Rich Showcase ativo e sem mudanças.

Nenhuma tabela do Rich Showcase é modificada pelo adaptador. O único estado próprio é a opção `tedtec_reviews_last_good`.

## Validação após implantação

1. Confirmar que o shortcode não aparece literalmente.
2. Confirmar a quantidade de cards e a ordem das avaliações.
3. Comparar nota e total com os dados locais do Rich Showcase.
4. Testar setas, indicadores, animações e link para o Google.
5. Verificar a home em larguras móveis, tablet e desktop.
6. Confirmar que uma atualização do feed aparece sem purge global de cache.
7. Em ambiente controlado, testar os fallbacks antes de atualizar a dependência.
