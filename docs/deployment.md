# Deploy

## Pré-condições

1. working tree revisado e sem arquivos sensíveis;
2. backup recuperável do componente e, quando houver conteúdo, do banco;
3. homologação visual aprovada;
4. pacote do plugin gerado somente com seus arquivos;
5. plano de rollback conhecido.

## Plugins próprios

1. confirme nome, versão e escopo do pacote;
2. em **Plugins → Adicionar plugin → Enviar plugin**, envie o ZIP;
3. use a substituição da versão existente; não desinstale antes;
4. confirme que o plugin permanece ativo;
5. valide a versão e a página pública em sessão não autenticada.

## Conteúdo da Home

O conteúdo editorial vive na página 509. Mudanças visuais devem ser preparadas na 1091 e promovidas somente após comparação e backup. Não altere permalink, status ou configuração de página inicial quando a publicação exigir apenas substituição de conteúdo.

## Cache

Primeiro compare conteúdo salvo e HTML público. Faça purge somente quando houver evidência de resposta obsoleta. Um purge não sincroniza o Rich Showcase; sincronização e cache de página são camadas diferentes.

## Validação pós-deploy

- HTTP 200 na URL pública sem parâmetros;
- sessão não autenticada;
- 1440, 1024, 768 e 390 px;
- reduced motion;
- zero erro JavaScript e overflow horizontal;
- Hero, seções, avaliações e footer presentes;
- links, compartilhamento e navegação do carrossel funcionais.

Se existir diferença relevante entre homologação e produção, pare e preserve o rollback antes de qualquer correção adicional.
