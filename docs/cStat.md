# Codigos cStat nos retornos da SEFAZ

## 100 - SUCESSO
**100 - Autorizado o uso da NF-e**
## 101 - SUCESSO
**101 - Cancelamento de NF-e homologado**
## 102 - SUCESSO
**102 - Inutilização de número homologado**
## 103 - SUCESSO
**103 - Lote recebido com sucesso**
## 104 - SUCESSO
**104 - Lote processado**
## 105 - SUCESSO
**105 - Lote em processamento**
## 106 - REJEIÇÃO
**106 - Lote não localizado**
> Correção : *O numero de recibo não foi localizado, confira*


## 107 - SUCESSO
**107 - Serviço em Operação**
## 108 - REJEIÇÃO
**108 - Serviço Paralisado Momentaneamente (curto prazo)**
> Correção : *Fora do ar AGUARDE!*


## 109 - REJEIÇÃO
**109 - Serviço Paralisado sem Previsão**
> Correção : *Fora do ar tente usar CONTINGÊNCIA*


## 110 - REJEIÇÃO
**110 - Uso Denegado**
> Correção : *Cuidado algo errado com o registro da empresa na SEFAZ*


## 111 - SUCESSO
**111 - Consulta cadastro com uma ocorrência**
## 112 - SUCESSO
**112 - Consulta cadastro com mais de uma ocorrência**
## 113 - REJEIÇÃO
**113 - SVC em processo de desativação SVC será  desabilitada para a SEFAZ-XX em dd/mm/aa às hh:mm horas**
> Correção : *Contingência indisponível*


## 114 - REJEIÇÃO
**114 - SVC-RS desabilitada pela SEFAZ de Origem**
> Correção : *Contingência indisponível*


## 124 - SUCESSO
**124 - EPEC Autorizado**
## 128 - SUCESSO
**128 - Lote de Evento Processado**
## 135 - SUCESSO
**135 - Evento registrado e vinculado a NF-e**
## 136 - SUCESSO
**136 - Evento registrado, mas não vinculado a NF-e**
## 137 - SUCESSO
**137 - Nenhum documento localizado para o Destinatário**
## 138 - SUCESSO
**138 - Documento localizado para o Destinatário**
## 139 - SUCESSO
**139 - Pedido de Download processado**
## 140 - SUCESSO
**140 - Download disponibilizado**
## 142 - REJEIÇÃO
**142 - Ambiente de Contingência EPEC bloqueado para o Emitente**
> Correção : *EPEC bloqueado consultar a SEFAZ*


## 150 - SUCESSO
**150 - Autorizado o uso da NF-e, autorização fora de prazo**
## 151 - SUCESSO
**151 - Cancelamento de NF-e homologado fora de prazo**
## 155 - SUCESSO
**155 - Cancelamento homologado fora de prazo**
## 201 - REJEIÇÃO
**201 - Rejeição: Número máximo de numeração a inutilizar ultrapassou o limite**
> Correção : *Não podem ser inutilizados tantos numeros*


## 202 - REJEIÇÃO
**202 - Rejeição: Falha no reconhecimento da autoria ou integridade do arquivo digital**
> Correção : *Algo não esta correto no formato do arquivo*


## 203 - REJEIÇÃO
**203 - Rejeição: Emissor não habilitado para emissão de NF-e**
> Correção : *Você não está credenciado para usar esse serviço*


## 204 - REJEIÇÃO
**204 - Duplicidade de NF-e [nRec:999999999999999]**
> Correção : *Já existe outra NFe autorizada com esse mesmo numero*


## 205 - REJEIÇÃO
**205 - NF-e está denegada na base de dados da SEFAZ [nRec:999999999999999]**
> Correção : *Essa nota já existe e foi DENEGADA*


## 206 - REJEIÇÃO
**206 - Rejeição: NF-e já está inutilizada na Base de dados da SEFAZ**
> Correção : *Esse numero de NFe foi inutilizado anteriormente*


## 207 - REJEIÇÃO
**207 - Rejeição: CNPJ do emitente inválido**
> Correção : *Erro no CNPJ do emitente*


## 208 - REJEIÇÃO
**208 - Rejeição: CNPJ do destinatário inválido**
> Correção : *Erro no CNPJ do destinatário*


## 209 - REJEIÇÃO
**209 - Rejeição: IE do emitente inválida**
> Correção : *IE incorreta do emitente*


## 210 - REJEIÇÃO
**210 - Rejeição: IE do destinatário inválida**
> Correção : *IE incorreta do destinatário*


## 211 - REJEIÇÃO
**211 - Rejeição: IE do substituto inválida**
> Correção : *IE do substituto incorreta*


## 212 - REJEIÇÃO
**212 - Rejeição: Data de emissão NF-e posterior a data de recebimento**
> Correção : *Verifique o relogio do sistema ou a zona de tempo ou o horário de verão*


## 213 - REJEIÇÃO
**213 - Rejeição: CNPJ-Base do Emitente difere do CNPJ-Base do Certificado Digital**
> Correção : *Você está usando um certificado de outro CNPJ*


## 214 - REJEIÇÃO
**214 - Rejeição: Tamanho da mensagem excedeu o limite estabelecido**
> Correção : *O tamanho da mensagem é maior que o aceitável, reduza o numero de NFe ou de itens*


## 215 - REJEIÇÃO
**215 - Rejeição: Falha no schema XML**
> Correção : *Provavelmente foram encontrados caracteres estranhos e não suportados*


## 216 - REJEIÇÃO
**216 - Rejeição: Chave de Acesso difere da cadastrada**
> Correção : *A chave de acesso indicada está difernete a registra na SEFAZ*


## 217 - REJEIÇÃO
**217 - Rejeição: NF-e não consta na base de dados da SEFAZ**
> Correção : *Essa NFe não está registrada, ou não foi enviada ou foi rejetada*


## 218 - REJEIÇÃO
**218 - NF-e já está cancelada na base de dados da SEFAZ [nRec:999999999999999]**
> Correção : *Não é possivel realizar mais operações com a NFE já cancelada*


## 219 - REJEIÇÃO
**219 - Rejeição: Circulação da NF-e verificada**
> Correção : *O cancelamento não é mais possivel a circulação já foi identificada*


## 220 - REJEIÇÃO
**220 - Rejeição: Prazo de Cancelamento superior ao previsto na Legislação**
> Correção : *As notas somente podem ser canceladas dentro do prazo*


## 221 - REJEIÇÃO
**221 - Rejeição: Confirmado o recebimento da NF-e pelo destinatário**
> Correção : *O recebimento já foi feito pelo destinatário não pode mais ser cancelada*


## 222 - REJEIÇÃO
**222 - Rejeição: Protocolo de Autorização de Uso difere do cadastrado**
> Correção : *O numero do protocolo indicado é diferente do registrado*


## 223 - REJEIÇÃO
**223 - Rejeição: CNPJ do transmissor do lote difere do CNPJ do transmissor da consulta**
> Correção : *O certificado usado para autenticar a comunicação não é o mesmo usado para assinar a NF-e*


## 224 - REJEIÇÃO
**224 - Rejeição: A faixa inicial é maior que a faixa final**
> Correção : *Preste atenção aos numeros para inutilizar*


## 225 - REJEIÇÃO
**225 - Rejeição: Falha no Schema XML do lote de NFe**
> Correção : *Podem ser Espaços entre as TAGs do XML; Quebras de Linhas; Caracteres especiais; Nome de TAGs errados; Versão do XML diferente do esperado pelo WebService*


## 226 - REJEIÇÃO
**226 - Rejeição: Código da UF do Emitente diverge da UF autorizadora**
> Correção : *O cUF indicado não corresponde a UF, avise o administrador*


## 227 - REJEIÇÃO
**227 - Rejeição: Erro na Chave de Acesso - Campo Id – falta a literal NFe**
> Correção : *Falha no atributo Id, avise o administrador*


## 228 - REJEIÇÃO
**228 - Rejeição: Data de Emissão muito atrasada**
> Correção : *Existe um limite de tempo para enviar uma solicitação e foi ultrapassado. Refaça e reenvie*


## 229 - REJEIÇÃO
**229 - Rejeição: IE do emitente não informada**
> Correção : *A IE do emitente é obrigatória*


## 230 - REJEIÇÃO
**230 - Rejeição: IE do emitente não cadastrada**
> Correção : *Emitente não cadastrado, verifique com a SEFAZ*


## 231 - REJEIÇÃO
**231 - Rejeição: IE do emitente não vinculada ao CNPJ**
> Correção : *A IE não pertence ao CNPJ, corrija*


## 232 - REJEIÇÃO
**232 - Rejeição: IE do destinatário não informada**
> Correção : *IE do destinatário deve ser informada nesse caso*


## 233 - REJEIÇÃO
**233 - Rejeição: IE do destinatário não cadastrada**
> Correção : *A IE do destinatário deve estar incorreta, verifique*


## 234 - REJEIÇÃO
**234 - Rejeição: IE do destinatário não vinculada ao CNPJ**
> Correção : *A IE do destinatário não pertence ao CNPJ do mesmo, verifique*


## 235 - REJEIÇÃO
**235 - Rejeição: Inscrição SUFRAMA inválida**
> Correção : *Numero da SUFRAMA incorreto, correija*


## 236 - REJEIÇÃO
**236 - Rejeição: Chave de Acesso com dígito verificador inválido**
> Correção : *O digito verificar é calculado e está incorreto, informe o administrador*


## 237 - REJEIÇÃO
**237 - Rejeição: CPF do destinatário inválido**
> Correção : *O CFP do destinatário está errdo, corrija*


## 238 - REJEIÇÃO
**238 - Rejeição: Cabeçalho - Versão do arquivo XML superior a Versão vigente**
> Correção : *O numero da versão está incorreto, informe o administrador*


## 239 - REJEIÇÃO
**239 - Rejeição: Cabeçalho - Versão do arquivo XML não suportada**
> Correção : *Versão do documento errada, informe o adminstrador*


## 240 - REJEIÇÃO
**240 - Rejeição: Cancelamento/Inutilização - Irregularidade Fiscal do Emitente**
> Correção : *Consulte a SEFAZ*


## 241 - REJEIÇÃO
**241 - Rejeição: Um número da faixa já foi utilizado**
> Correção : *Essa inutilização já foi realizada.*


## 242 - REJEIÇÃO
**242 - Rejeição: Cabeçalho - Falha no Schema XML**
> Correção : *Normalmente causado por caracteres inválidos, informe o administrador*


## 243 - REJEIÇÃO
**243 - Rejeição: XML Mal Formado**
> Correção : *Erro na montagem do XML, informe o administrador*


## 244 - REJEIÇÃO
**244 - Rejeição: CNPJ do Certificado Digital difere do CNPJ da Matriz e do CNPJ do Emitente**
> Correção : *O certificado utilizado é incorreto*


## 245 - REJEIÇÃO
**245 - Rejeição: CNPJ Emitente não cadastrado**
> Correção : *Confira o CNPJ do emitente está errado*


## 246 - REJEIÇÃO
**246 - Rejeição: CNPJ Destinatário não cadastrado**
> Correção : *Confira o CNPJ do destinatário está errado*


## 247 - REJEIÇÃO
**247 - Rejeição: Sigla da UF do Emitente diverge da UF autorizadora**
> Correção : *O sistema está enviando para outro autorizador diverso da UF do emitente *


## 248 - REJEIÇÃO
**248 - Rejeição: UF do Recibo diverge da UF autorizadora**
> Correção : *O recibo usado é de outra autoriazadora, verifique qual é o recibo correto*


## 249 - REJEIÇÃO
**249 - Rejeição: UF da Chave de Acesso diverge da UF autorizadora**
> Correção : *A chave de acesso é de outra autorizadora*


## 250 - REJEIÇÃO
**250 - Rejeição: UF diverge da UF autorizadora**
> Correção : *A chave de acesso é de outra autorizadora*


## 251 - REJEIÇÃO
**251 - Rejeição: UF/Município destinatário não pertence a SUFRAMA**
> Correção : *A chave de acesso é de outra autorizadora*


## 252 - REJEIÇÃO
**252 - Rejeição: Ambiente informado diverge do Ambiente de recebimento**
> Correção : *A chave de acesso é de outra autorizadora*


## 253 - REJEIÇÃO
**253 - Rejeição: Digito Verificador da chave de acesso composta inválida**
> Correção : *A chave de acesso é de outra autorizadora*


## 254 - REJEIÇÃO
**254 - Rejeição: NF-e complementar não possui NF referenciada**
> Correção : *A chave de acesso é de outra autorizadora*


## 255 - REJEIÇÃO
**255 - Rejeição: NF-e complementar possui mais de uma NF referenciada**
> Correção : *A chave de acesso é de outra autorizadora*


## 256 - REJEIÇÃO
**256 - Rejeição: Uma NF-e da faixa já está inutilizada na Base de dados da SEFAZ**
> Correção : *A chave de acesso é de outra autorizadora*


## 257 - REJEIÇÃO
**257 - Rejeição: Solicitante não habilitado para emissão da NF-e**
> Correção : *A chave de acesso é de outra autorizadora*


## 258 - REJEIÇÃO
**258 - Rejeição: CNPJ da consulta inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 259 - REJEIÇÃO
**259 - Rejeição: CNPJ da consulta não cadastrado como contribuinte na UF**
> Correção : *A chave de acesso é de outra autorizadora*


## 260 - REJEIÇÃO
**260 - Rejeição: IE da consulta inválida**
> Correção : *A chave de acesso é de outra autorizadora*


## 261 - REJEIÇÃO
**261 - Rejeição: IE da consulta não cadastrada como contribuinte na UF**
> Correção : *A chave de acesso é de outra autorizadora*


## 262 - REJEIÇÃO
**262 - Rejeição: UF não fornece consulta por CPF**
> Correção : *A chave de acesso é de outra autorizadora*


## 263 - REJEIÇÃO
**263 - Rejeição: CPF da consulta inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 264 - REJEIÇÃO
**264 - Rejeição: CPF da consulta não cadastrado como contribuinte na UF**
> Correção : *A chave de acesso é de outra autorizadora*


## 265 - REJEIÇÃO
**265 - Rejeição: Sigla da UF da consulta difere da UF do Web Service**
> Correção : *A chave de acesso é de outra autorizadora*


## 266 - REJEIÇÃO
**266 - Rejeição: Série utilizada não permitida no Web Service**
> Correção : *A chave de acesso é de outra autorizadora*


## 267 - REJEIÇÃO
**267 - Rejeição: NF Complementar referencia uma NF-e inexistente**
> Correção : *A chave de acesso é de outra autorizadora*


## 268 - REJEIÇÃO
**268 - Rejeição: NF Complementar referencia outra NF-e Complementar**
> Correção : *A chave de acesso é de outra autorizadora*


## 269 - REJEIÇÃO
**269 - Rejeição: CNPJ Emitente da NF Complementar difere do CNPJ da NF Referenciada**
> Correção : *A chave de acesso é de outra autorizadora*


## 270 - REJEIÇÃO
**270 - Rejeição: Código Município do Fato Gerador: dígito inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 271 - REJEIÇÃO
**271 - Rejeição: Código Município do Fato Gerador: difere da UF do emitente**
> Correção : *A chave de acesso é de outra autorizadora*


## 272 - REJEIÇÃO
**272 - Rejeição: Código Município do Emitente: dígito inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 273 - REJEIÇÃO
**273 - Rejeição: Código Município do Emitente: difere da UF do emitente**
> Correção : *A chave de acesso é de outra autorizadora*


## 274 - REJEIÇÃO
**274 - Rejeição: Código Município do Destinatário: dígito inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 275 - REJEIÇÃO
**275 - Rejeição: Código Município do Destinatário: difere da UF do Destinatário**
> Correção : *A chave de acesso é de outra autorizadora*


## 276 - REJEIÇÃO
**276 - Rejeição: Código Município do Local de Retirada: dígito inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 277 - REJEIÇÃO
**277 - Rejeição: Código Município do Local de Retirada: difere da UF do Local de Retirada**
> Correção : *A chave de acesso é de outra autorizadora*


## 278 - REJEIÇÃO
**278 - Rejeição: Código Município do Local de Entrega: dígito inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 279 - REJEIÇÃO
**279 - Rejeição: Código Município do Local de Entrega: difere da UF do Local de Entrega**
> Correção : *A chave de acesso é de outra autorizadora*


## 280 - REJEIÇÃO
**280 - Rejeição: Certificado Transmissor inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 281 - REJEIÇÃO
**281 - Rejeição: Certificado Transmissor Data Validade**
> Correção : *A chave de acesso é de outra autorizadora*


## 282 - REJEIÇÃO
**282 - Rejeição: Certificado Transmissor sem CNPJ**
> Correção : *A chave de acesso é de outra autorizadora*


## 283 - REJEIÇÃO
**283 - Rejeição: Certificado Transmissor - erro Cadeia de Certificação**
> Correção : *A chave de acesso é de outra autorizadora*


## 284 - REJEIÇÃO
**284 - Rejeição: Certificado Transmissor revogado**
> Correção : *A chave de acesso é de outra autorizadora*


## 285 - REJEIÇÃO
**285 - Rejeição: Certificado Transmissor difere ICP-Brasil**
> Correção : *A chave de acesso é de outra autorizadora*


## 286 - REJEIÇÃO
**286 - Rejeição: Certificado Transmissor erro no acesso a LCR**
> Correção : *A chave de acesso é de outra autorizadora*


## 287 - REJEIÇÃO
**287 - Rejeição: Código Município do FG - ISSQN: dígito inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 288 - REJEIÇÃO
**288 - Rejeição: Código Município do FG - Transporte: dígito inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 289 - REJEIÇÃO
**289 - Rejeição: Código da UF informada diverge da UF solicitada**
> Correção : *A chave de acesso é de outra autorizadora*


## 290 - REJEIÇÃO
**290 - Rejeição: Certificado Assinatura inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 291 - REJEIÇÃO
**291 - Rejeição: Certificado Assinatura Data Validade**
> Correção : *A chave de acesso é de outra autorizadora*


## 292 - REJEIÇÃO
**292 - Rejeição: Certificado Assinatura sem CNPJ**
> Correção : *A chave de acesso é de outra autorizadora*


## 293 - REJEIÇÃO
**293 - Rejeição: Certificado Assinatura - erro Cadeia de Certificação**
> Correção : *A chave de acesso é de outra autorizadora*


## 294 - REJEIÇÃO
**294 - Rejeição: Certificado Assinatura revogado**
> Correção : *A chave de acesso é de outra autorizadora*


## 295 - REJEIÇÃO
**295 - Rejeição: Certificado Assinatura difere ICP-Brasil**
> Correção : *A chave de acesso é de outra autorizadora*


## 296 - REJEIÇÃO
**296 - Rejeição: Certificado Assinatura erro no acesso a LCR**
> Correção : *A chave de acesso é de outra autorizadora*


## 297 - REJEIÇÃO
**297 - Rejeição: Assinatura difere do calculado**
> Correção : *A chave de acesso é de outra autorizadora*


## 298 - REJEIÇÃO
**298 - Rejeição: Assinatura difere do padrão do Sistema**
> Correção : *A chave de acesso é de outra autorizadora*


## 299 - REJEIÇÃO
**299 - Rejeição: XML da área de cabeçalho com codificação diferente de UTF-8**
> Correção : *A chave de acesso é de outra autorizadora*


## 301 - REJEIÇÃO
**301 - Uso Denegado: Irregularidade fiscal do emitente**
> Correção : *A chave de acesso é de outra autorizadora*


## 302 - REJEIÇÃO
**302 - Uso Denegado: Irregularidade fiscal do destinatário**
> Correção : *A chave de acesso é de outra autorizadora*


## 303 - REJEIÇÃO
**303 - Uso Denegado: Destinatário não habilitado a operar na UF**
> Correção : *A chave de acesso é de outra autorizadora*


## 304 - REJEIÇÃO
**304 - Rejeição: Pedido de Cancelamento para NF-e com evento da Suframa**
> Correção : *A chave de acesso é de outra autorizadora*


## 315 - REJEIÇÃO
**315 - Data de Emissão anterior ao início da autorização de Nota Fiscal na UF**
> Correção : *A chave de acesso é de outra autorizadora*


## 316 - REJEIÇÃO
**316 - Nota Fiscal referenciada com a mesma Chave de Acesso da Nota Fiscal atual**
> Correção : *A chave de acesso é de outra autorizadora*


## 317 - REJEIÇÃO
**317 - NF modelo 1 referenciada com data de emissão inválida**
> Correção : *A chave de acesso é de outra autorizadora*


## 318 - REJEIÇÃO
**318 - Contranota de Produtor sem Nota Fiscal referenciada**
> Correção : *A chave de acesso é de outra autorizadora*


## 319 - REJEIÇÃO
**319 - Contranota de Produtor não pode referenciar somente Nota Fiscal de entrada**
> Correção : *A chave de acesso é de outra autorizadora*


## 320 - REJEIÇÃO
**320 - Contranota de Produtor referencia somente NF de outro emitente**
> Correção : *A chave de acesso é de outra autorizadora*


## 321 - REJEIÇÃO
**321 - Rejeição: NF-e de devolução de mercadoria não possui documento fiscal referenciado**
> Correção : *A chave de acesso é de outra autorizadora*


## 322 - REJEIÇÃO
**322 - NF-e de devolução com mais de um documento fiscal referenciado**
> Correção : *A chave de acesso é de outra autorizadora*


## 323 - REJEIÇÃO
**323 - Rejeição: CNPJ autorizado para download inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 324 - REJEIÇÃO
**324 - Rejeição: CNPJ do destinatário já autorizado para download**
> Correção : *A chave de acesso é de outra autorizadora*


## 325 - REJEIÇÃO
**325 - Rejeição: CPF autorizado para download inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 326 - REJEIÇÃO
**326 - Rejeição: CPF do destinatário já autorizado para download**
> Correção : *A chave de acesso é de outra autorizadora*


## 327 - REJEIÇÃO
**327 - Rejeição: CFOP inválido para NF-e com finalidade de devolução de mercadoria**
> Correção : *A chave de acesso é de outra autorizadora*


## 328 - REJEIÇÃO
**328 - Rejeição: CFOP de devolução de mercadoria para NF-e que não tem finalidade de devolução de mercadoria**
> Correção : *A chave de acesso é de outra autorizadora*


## 329 - REJEIÇÃO
**329 - Rejeição: Número da DI /DSI inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 330 - REJEIÇÃO
**330 - Rejeição: Informar o Valor da AFRMM na importação por via marítima**
> Correção : *A chave de acesso é de outra autorizadora*


## 331 - REJEIÇÃO
**331 - Rejeição: Informar o CNPJ do adquirente ou do encomendante nesta forma de importação**
> Correção : *A chave de acesso é de outra autorizadora*


## 332 - REJEIÇÃO
**332 - Rejeição: CNPJ do adquirente ou do encomendante da importação inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 333 - REJEIÇÃO
**333 - Rejeição: Informar a UF do adquirente ou do encomendante nesta forma de importação**
> Correção : *A chave de acesso é de outra autorizadora*


## 334 - REJEIÇÃO
**334 - Rejeição: Número do processo de drawback não informado na importação**
> Correção : *A chave de acesso é de outra autorizadora*


## 335 - REJEIÇÃO
**335 - Rejeição: Número do processo de drawback na importação inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 336 - REJEIÇÃO
**336 - Rejeição: Informado o grupo de exportação no item para CFOP que não é de exportação**
> Correção : *A chave de acesso é de outra autorizadora*


## 337 - REJEIÇÃO
**337 - Rejeição: Não informado o grupo de exportação no item**
> Correção : *A chave de acesso é de outra autorizadora*


## 338 - REJEIÇÃO
**338 - Rejeição: Número do processo de drawback não informado na exportação**
> Correção : *A chave de acesso é de outra autorizadora*


## 339 - REJEIÇÃO
**339 - Rejeição: Número do processo de drawback na exportação inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 340 - REJEIÇÃO
**340 - Rejeição: Não informado o grupo de exportação indireta no item**
> Correção : *A chave de acesso é de outra autorizadora*


## 341 - REJEIÇÃO
**341 - Rejeição: Número do registro de exportação inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 342 - REJEIÇÃO
**342 - Rejeição: Chave de Acesso informada na Exportação Indireta com DV inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 343 - REJEIÇÃO
**343 - Rejeição: Modelo da NF-e informada na Exportação Indireta diferente de 55**
> Correção : *A chave de acesso é de outra autorizadora*


## 344 - REJEIÇÃO
**344 - Rejeição: Duplicidade de NF-e informada na Exportação Indireta (Chave de Acesso informada mais de uma vez)**
> Correção : *A chave de acesso é de outra autorizadora*


## 345 - REJEIÇÃO
**345 - Rejeição: Chave de Acesso informada na Exportação Indireta não consta como NF-e referenciada**
> Correção : *A chave de acesso é de outra autorizadora*


## 346 - REJEIÇÃO
**346 - Rejeição: Somatório das quantidades informadas na Exportação Indireta não corresponde a quantidade total do item**
> Correção : *A chave de acesso é de outra autorizadora*


## 347 - REJEIÇÃO
**347 - Rejeição: Descrição do Combustível diverge da descrição adotada pela ANP**
> Correção : *A chave de acesso é de outra autorizadora*


## 348 - REJEIÇÃO
**348 - Rejeição: NFC-e com grupo RECOPI**
> Correção : *A chave de acesso é de outra autorizadora*


## 349 - REJEIÇÃO
**349 - Rejeição: Número RECOPI não informado**
> Correção : *A chave de acesso é de outra autorizadora*


## 350 - REJEIÇÃO
**350 - Rejeição: Número RECOPI inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 351 - REJEIÇÃO
**351 - Rejeição: Valor do ICMS da Operação no CST=51 difere do produto BC e Alíquota**
> Correção : *A chave de acesso é de outra autorizadora*


## 352 - REJEIÇÃO
**352 - Rejeição: Valor do ICMS Diferido no CST=51 difere do produto Valor ICMS Operação e percentual diferimento**
> Correção : *A chave de acesso é de outra autorizadora*


## 353 - REJEIÇÃO
**353 - Rejeição: Valor do ICMS no CST=51 não corresponde a diferença do ICMS operação e ICMS diferido**
> Correção : *A chave de acesso é de outra autorizadora*


## 354 - REJEIÇÃO
**354 - Rejeição: Informado grupo de devolução de tributos para NF-e que não tem finalidade de devolução de mercadoria**
> Correção : *A chave de acesso é de outra autorizadora*


## 355 - REJEIÇÃO
**355 - Rejeição: Informar o local de saída do Pais no caso da exportação**
> Correção : *A chave de acesso é de outra autorizadora*


## 356 - REJEIÇÃO
**356 - Rejeição: Informar o local de saída do Pais somente no caso da exportação**
> Correção : *A chave de acesso é de outra autorizadora*


## 357 - REJEIÇÃO
**357 - Rejeição: Chave de Acesso do grupo de Exportação Indireta inexistente [nRef: xxx]**
> Correção : *A chave de acesso é de outra autorizadora*


## 358 - REJEIÇÃO
**358 - Rejeição: Chave de Acesso do grupo de Exportação Indireta cancelada ou denegada [nRef: xxx]**
> Correção : *A chave de acesso é de outra autorizadora*


## 359 - REJEIÇÃO
**359 - Rejeição: NF-e de venda a Órgão Público sem informar a Nota de Empenho**
> Correção : *A chave de acesso é de outra autorizadora*


## 360 - REJEIÇÃO
**360 - Rejeição: NF-e com Nota de Empenho inválida para a UF.**
> Correção : *A chave de acesso é de outra autorizadora*


## 361 - REJEIÇÃO
**361 - Rejeição: NF-e com Nota de Empenho inexistente na UF.**
> Correção : *A chave de acesso é de outra autorizadora*


## 362 - REJEIÇÃO
**362 - Rejeição: Venda de combustível sem informação do Transportador**
> Correção : *A chave de acesso é de outra autorizadora*


## 363 - REJEIÇÃO
**363 - Total do ISS difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 364 - REJEIÇÃO
**364 - Rejeição: Total do valor da dedução do ISS difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 365 - REJEIÇÃO
**365 - Rejeição: Total de outras retenções difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 366 - REJEIÇÃO
**366 - Rejeição: Total do desconto incondicionado ISS difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 367 - REJEIÇÃO
**367 - Rejeição: Total do desconto condicionado ISS difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 368 - REJEIÇÃO
**368 - Rejeição: Total de ISS retido difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 369 - REJEIÇÃO
**369 - Rejeição: Não informado o grupo avulsa na emissão pelo Fisco**
> Correção : *A chave de acesso é de outra autorizadora*


## 370 - REJEIÇÃO
**370 - Rejeição: Nota Fiscal Avulsa com tipo de emissão inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 372 - REJEIÇÃO
**372 - Destinatário com identificação de estrangeiro com caracteres inválidos**
> Correção : *A chave de acesso é de outra autorizadora*


## 373 - REJEIÇÃO
**373 - Descricao do primeiro item diferente de NOTA FISCAL EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL**
> Correção : *A chave de acesso é de outra autorizadora*


## 374 - REJEIÇÃO
**374 - CFOP incompatível com o grupo de tributação [nItem:nnn]**
> Correção : *A chave de acesso é de outra autorizadora*


## 375 - REJEIÇÃO
**375 - Informe no passo 1 a chave da NF-e referenciada.NF-e com CFOP 5929 (Lançamento relativo a Cupom Fiscal) referencia uma NFC-e [nItem:nnn]**
> Correção : *A chave de acesso é de outra autorizadora*


## 376 - REJEIÇÃO
**376 - Data do Desembaraço Aduaneiro inválida [nItem:nnn]**
> Correção : *A chave de acesso é de outra autorizadora*


## 378 - REJEIÇÃO
**378 - Grupo de Combustível sem a informação de Encerrante [nItem:nnn]**
> Correção : *A chave de acesso é de outra autorizadora*


## 379 - REJEIÇÃO
**379 - Grupo de Encerrante na NF-e (modelo 55) para CFOP diferente de venda de combustível para consumidor final [nItem:nnn]**
> Correção : *A chave de acesso é de outra autorizadora*


## 380 - REJEIÇÃO
**380 - Valor do Encerrante final não é superior ao Encerrante inicial [nItem:nnn]**
> Correção : *A chave de acesso é de outra autorizadora*


## 381 - REJEIÇÃO
**381 - Grupo de tributação ICMS90, informando dados do ICMS-ST [nItem:nnn]**
> Correção : *A chave de acesso é de outra autorizadora*


## 382 - REJEIÇÃO
**382 - CFOP não permitido para o CST informado [nItem:nnn]**
> Correção : *A chave de acesso é de outra autorizadora*


## 383 - REJEIÇÃO
**383 - Item com CSOSN indevido [nItem:nnn]**
> Correção : *A chave de acesso é de outra autorizadora*


## 384 - REJEIÇÃO
**384 - CSOSN não permitido para a UF [nItem:nnn]**
> Correção : *A chave de acesso é de outra autorizadora*


## 385 - REJEIÇÃO
**385 - Grupo de tributação ICMS900, informando dados do ICMS-ST [nItem:nnn]**
> Correção : *A chave de acesso é de outra autorizadora*


## 386 - REJEIÇÃO
**386 - CFOP não permitido para o CSOSN informado [nItem:nnn]**
> Correção : *A chave de acesso é de outra autorizadora*


## 387 - REJEIÇÃO
**387 - Código de Enquadramento Legal do IPI inválido [nItem:nnn]**
> Correção : *A chave de acesso é de outra autorizadora*


## 388 - REJEIÇÃO
**388 - Código de Situação Tributária do IPI incompatível com o Código de Enquadramento Legal do IPI [nItem:nnn]**
> Correção : *A chave de acesso é de outra autorizadora*


## 389 - REJEIÇÃO
**389 - Código Município ISSQN inexistente [nItem:nnn]**
> Correção : *A chave de acesso é de outra autorizadora*


## 390 - REJEIÇÃO
**390 - Nota Fiscal com grupo de devolução de tributos [nItem:nnn]**
> Correção : *A chave de acesso é de outra autorizadora*


## 391 - REJEIÇÃO
**391 - Não informados os dados do cartão de crédito / débito nas Formas de Pagamento da Nota Fiscal**
> Correção : *A chave de acesso é de outra autorizadora*


## 392 - REJEIÇÃO
**392 - Não informados os dados da operação de pagamento por cartão de crédito / débito**
> Correção : *A chave de acesso é de outra autorizadora*


## 393 - REJEIÇÃO
**393 - NF-e com o grupo de Informações Suplementares**
> Correção : *A chave de acesso é de outra autorizadora*


## 394 - REJEIÇÃO
**394 - Nota Fiscal sem a informação do QR-Code**
> Correção : *A chave de acesso é de outra autorizadora*


## 395 - REJEIÇÃO
**395 - Endereço do site da UF da Consulta via QRCode diverge do previsto**
> Correção : *A chave de acesso é de outra autorizadora*


## 396 - REJEIÇÃO
**396 - Parâmetro do QR-Code inexistente (chAcesso)**
> Correção : *A chave de acesso é de outra autorizadora*


## 397 - REJEIÇÃO
**397 - Parâmetro do QR-Code divergente da Nota Fiscal (chAcesso)**
> Correção : *A chave de acesso é de outra autorizadora*


## 398 - REJEIÇÃO
**398 - Parâmetro nVersao do QR-Code difere do previsto**
> Correção : *A chave de acesso é de outra autorizadora*


## 399 - REJEIÇÃO
**399 - Parâmetro de Identificação do destinatário no QR-Code para Nota Fiscal sem identificação do destinatário**
> Correção : *A chave de acesso é de outra autorizadora*


## 401 - REJEIÇÃO
**401 - Rejeição: CPF do remetente inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 402 - REJEIÇÃO
**402 - Rejeição: XML da área de dados com codificação diferente de UTF-8**
> Correção : *A chave de acesso é de outra autorizadora*


## 403 - REJEIÇÃO
**403 - Rejeição: O grupo de informações da NF-e avulsa é de uso exclusivo do Fisco**
> Correção : *A chave de acesso é de outra autorizadora*


## 404 - REJEIÇÃO
**404 - Rejeição: Uso de prefixo de namespace não permitido**
> Correção : *A chave de acesso é de outra autorizadora*


## 405 - REJEIÇÃO
**405 - Rejeição: Código do país do emitente: dígito inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 406 - REJEIÇÃO
**406 - Rejeição: Código do país do destinatário: dígito inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 407 - REJEIÇÃO
**407 - Rejeição: O CPF só pode ser informado no campo emitente para a NF-e avulsa**
> Correção : *A chave de acesso é de outra autorizadora*


## 408 - REJEIÇÃO
**408 - Rejeição: Evento não disponível para Autor pessoa física**
> Correção : *A chave de acesso é de outra autorizadora*


## 409 - REJEIÇÃO
**409 - Rejeição: Campo cUF inexistente no elemento nfeCabecMsg do SOAP Header**
> Correção : *A chave de acesso é de outra autorizadora*


## 410 - REJEIÇÃO
**410 - Rejeição: UF informada no campo cUF não é atendida pelo Web Service**
> Correção : *A chave de acesso é de outra autorizadora*


## 411 - REJEIÇÃO
**411 - Rejeição: Campo versaoDados inexistente no elemento nfeCabecMsg do SOAP Header**
> Correção : *A chave de acesso é de outra autorizadora*


## 416 - REJEIÇÃO
**416 - Rejeição: Falha na descompactação da área de dados**
> Correção : *A chave de acesso é de outra autorizadora*


## 417 - REJEIÇÃO
**417 - Rejeição: Total do ICMS superior ao valor limite estabelecido**
> Correção : *A chave de acesso é de outra autorizadora*


## 418 - REJEIÇÃO
**418 - Rejeição: Total do ICMS ST superior ao valor limite estabelecido**
> Correção : *A chave de acesso é de outra autorizadora*


## 420 - REJEIÇÃO
**420 - Rejeição: Cancelamento para NF-e já cancelada**
> Correção : *A chave de acesso é de outra autorizadora*


## 450 - REJEIÇÃO
**450 - Rejeição: Modelo da NF-e diferente de 55**
> Correção : *A chave de acesso é de outra autorizadora*


## 451 - REJEIÇÃO
**451 - Rejeição: Processo de emissão informado inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 452 - REJEIÇÃO
**452 - Rejeição: Tipo Autorizador do Recibo diverge do Órgão Autorizador**
> Correção : *A chave de acesso é de outra autorizadora*


## 453 - REJEIÇÃO
**453 - Rejeição: Ano de inutilização não pode ser superior ao Ano atual**
> Correção : *A chave de acesso é de outra autorizadora*


## 454 - REJEIÇÃO
**454 - Rejeição: Ano de inutilização não pode ser inferior a 2006**
> Correção : *A chave de acesso é de outra autorizadora*


## 455 - REJEIÇÃO
**455 - Rejeição: Órgão Autor do evento diferente da UF da Chave de Acesso**
> Correção : *A chave de acesso é de outra autorizadora*


## 461 - REJEIÇÃO
**461 - Rejeição: Informado percentual de Gás Natural na mistura para produto diferente de GLP**
> Correção : *A chave de acesso é de outra autorizadora*


## 462 - REJEIÇÃO
**462 - Código Identificador do CSC no QR-Code não cadastrado na SEFAZ**
> Correção : *A chave de acesso é de outra autorizadora*


## 463 - REJEIÇÃO
**463 - Código Identificador do CSC no QR-Code foi revogado pela empresa**
> Correção : *A chave de acesso é de outra autorizadora*


## 464 - REJEIÇÃO
**464 - Código de Hash no QR-Code difere do calculado**
> Correção : *A chave de acesso é de outra autorizadora*


## 465 - REJEIÇÃO
**465 - Rejeição: Número de Controle da FCI inexistente**
> Correção : *A chave de acesso é de outra autorizadora*


## 466 - REJEIÇÃO
**466 - Rejeição: Evento com Tipo de Autor incompatível**
> Correção : *A chave de acesso é de outra autorizadora*


## 467 - REJEIÇÃO
**467 - Rejeição: Dados da NF-e divergentes do EPEC**
> Correção : *A chave de acesso é de outra autorizadora*


## 468 - REJEIÇÃO
**468 - Rejeição: NF-e com Tipo Emissão = 4, sem EPEC correspondente**
> Correção : *A chave de acesso é de outra autorizadora*


## 471 - REJEIÇÃO
**471 - Rejeição: Informado NCM=00 indevidamente**
> Correção : *A chave de acesso é de outra autorizadora*


## 476 - REJEIÇÃO
**476 - Rejeição: Código da UF diverge da UF da primeira NF-e do Lote**
> Correção : *A chave de acesso é de outra autorizadora*


## 477 - REJEIÇÃO
**477 - Rejeição: Código do órgão diverge do órgão do primeiro evento do Lote**
> Correção : *A chave de acesso é de outra autorizadora*


## 478 - REJEIÇÃO
**478 - Rejeição: Local da entrega não informado para faturamento direto de veículos novos**
> Correção : *A chave de acesso é de outra autorizadora*


## 479 - REJEIÇÃO
**479 - Emissor em situação irregular perante o fisco**
> Correção : *A chave de acesso é de outra autorizadora*


## 480 - REJEIÇÃO
**480 - CNPJ da Chave de acesso da NF-e informada diverge do CNPJ do emitente**
> Correção : *A chave de acesso é de outra autorizadora*


## 481 - REJEIÇÃO
**481 - UF da Chave de acesso diverge do código da UF informada**
> Correção : *A chave de acesso é de outra autorizadora*


## 482 - REJEIÇÃO
**482 - AA da Chave de acesso inválida**
> Correção : *A chave de acesso é de outra autorizadora*


## 483 - REJEIÇÃO
**483 - MM da chave de acesso inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 484 - REJEIÇÃO
**484 - Rejeição: Chave de Acesso com tipo de emissão diferente de 4 (posição 35 da Chave de Acesso)**
> Correção : *A chave de acesso é de outra autorizadora*


## 485 - REJEIÇÃO
**485 - Rejeição: Duplicidade de numeração do EPEC (Modelo, CNPJ, Série e Número)**
> Correção : *A chave de acesso é de outra autorizadora*


## 486 - REJEIÇÃO
**486 - DPEC não localizada para o número de registro de DPEC informado**
> Correção : *A chave de acesso é de outra autorizadora*


## 487 - REJEIÇÃO
**487 - Nenhuma DPEC localizada para a chave de acesso informada**
> Correção : *A chave de acesso é de outra autorizadora*


## 488 - REJEIÇÃO
**488 - Requisitante de Consulta não tem o mesmo CNPJ base do emissor da DPEC**
> Correção : *A chave de acesso é de outra autorizadora*


## 489 - REJEIÇÃO
**489 - Rejeição: CNPJ informado inválido (DV ou zeros)**
> Correção : *A chave de acesso é de outra autorizadora*


## 490 - REJEIÇÃO
**490 - Rejeição: CPF informado inválido (DV ou zeros)**
> Correção : *A chave de acesso é de outra autorizadora*


## 491 - REJEIÇÃO
**491 - Rejeição: O tpEvento informado inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 492 - REJEIÇÃO
**492 - Rejeição: O verEvento informado inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 493 - REJEIÇÃO
**493 - Rejeição: Evento não atende o Schema XML específico**
> Correção : *A chave de acesso é de outra autorizadora*


## 494 - REJEIÇÃO
**494 - Rejeição: Chave de Acesso inexistente**
> Correção : *A chave de acesso é de outra autorizadora*


## 496 - REJEIÇÃO
**496 - Não informado o tipo de integração no pagamento com cartão de crédito / débito**
> Correção : *A chave de acesso é de outra autorizadora*


## 501 - REJEIÇÃO
**501 - Rejeição: Pedido de Cancelamento intempestivo (NF-e autorizada a mais de 7 dias)**
> Correção : *A chave de acesso é de outra autorizadora*


## 502 - REJEIÇÃO
**502 - Rejeição: Erro na Chave de Acesso - Campo Id não corresponde à concatenação dos campos correspondentes**
> Correção : *A chave de acesso é de outra autorizadora*


## 503 - REJEIÇÃO
**503 - Rejeição: Série utilizada fora da faixa permitida no SCAN (900-999)**
> Correção : *A chave de acesso é de outra autorizadora*


## 504 - REJEIÇÃO
**504 - Rejeição: Data de Entrada/Saída posterior ao permitido**
> Correção : *A chave de acesso é de outra autorizadora*


## 505 - REJEIÇÃO
**505 - Rejeição: Data de Entrada/Saída anterior ao permitido**
> Correção : *A chave de acesso é de outra autorizadora*


## 506 - REJEIÇÃO
**506 - Rejeição: Data de Saída menor que a Data de Emissão**
> Correção : *A chave de acesso é de outra autorizadora*


## 507 - REJEIÇÃO
**507 - Rejeição: O CNPJ do destinatário/remetente não deve ser informado em operação com o exterior**
> Correção : *A chave de acesso é de outra autorizadora*


## 508 - REJEIÇÃO
**508 - Rejeição: CNPJ do destinatário com conteúdo nulo só é válido em operação com exterior**
> Correção : *A chave de acesso é de outra autorizadora*


## 509 - REJEIÇÃO
**509 - Rejeição: Informado código de município diferente de “9999999” para operação com o exterior**
> Correção : *A chave de acesso é de outra autorizadora*


## 510 - REJEIÇÃO
**510 - Rejeição: Operação com Exterior e Código País destinatário é 1058 (Brasil) ou não informado**
> Correção : *A chave de acesso é de outra autorizadora*


## 511 - REJEIÇÃO
**511 - Rejeição: Não é de Operação com Exterior e Código País destinatário difere de 1058 (Brasil)**
> Correção : *A chave de acesso é de outra autorizadora*


## 512 - REJEIÇÃO
**512 - Rejeição: CNPJ do Local de Retirada inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 513 - REJEIÇÃO
**513 - Rejeição: Código Município do Local de Retirada deve ser 9999999 para UF retirada = EX**
> Correção : *A chave de acesso é de outra autorizadora*


## 514 - REJEIÇÃO
**514 - Rejeição: CNPJ do Local de Entrega inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 515 - REJEIÇÃO
**515 - Rejeição: Código Município do Local de Entrega deve ser 9999999 para UF entrega = EX**
> Correção : *A chave de acesso é de outra autorizadora*


## 516 - REJEIÇÃO
**516 - Rejeição: Falha no schema XML – inexiste a tag raiz esperada para a mensagem**
> Correção : *A chave de acesso é de outra autorizadora*


## 517 - REJEIÇÃO
**517 - Rejeição: Falha no schema XML – inexiste atributo versao na tag raiz da mensagem**
> Correção : *A chave de acesso é de outra autorizadora*


## 518 - REJEIÇÃO
**518 - Rejeição: CFOP de entrada para NF-e de saída**
> Correção : *A chave de acesso é de outra autorizadora*


## 519 - REJEIÇÃO
**519 - Rejeição: CFOP de saída para NF-e de entrada**
> Correção : *A chave de acesso é de outra autorizadora*


## 520 - REJEIÇÃO
**520 - Rejeição: CFOP de Operação com Exterior e UF destinatário difere de EX**
> Correção : *A chave de acesso é de outra autorizadora*


## 521 - REJEIÇÃO
**521 - Rejeição: CFOP de Operação Estadual e UF do emitente difere da UF do destinatário para destinatário contribuinte do ICMS.**
> Correção : *A chave de acesso é de outra autorizadora*


## 522 - REJEIÇÃO
**522 - Rejeição: CFOP de Operação Estadual e UF emitente difere da UF remetente para remetente contribuinte do ICMS.**
> Correção : *A chave de acesso é de outra autorizadora*


## 523 - REJEIÇÃO
**523 - Rejeição: CFOP não é de Operação Estadual e UF emitente igual a UF destinatário.**
> Correção : *A chave de acesso é de outra autorizadora*


## 524 - REJEIÇÃO
**524 - Rejeição: CFOP de Operação com Exterior e não informado NCM**
> Correção : *A chave de acesso é de outra autorizadora*


## 525 - REJEIÇÃO
**525 - Rejeição: CFOP de Importação e não informado dados da DI**
> Correção : *A chave de acesso é de outra autorizadora*


## 526 - REJEIÇÃO
**526 - Ano-Mes da Chave de Acesso com atraso superior a 6 meses em relacao ao Ano-Mes atual**
> Correção : *A chave de acesso é de outra autorizadora*


## 527 - REJEIÇÃO
**527 - Rejeição: Operação de Exportação com informação de ICMS incompatível**
> Correção : *A chave de acesso é de outra autorizadora*


## 528 - REJEIÇÃO
**528 - Rejeição: Valor do ICMS difere do produto BC e Alíquota**
> Correção : *A chave de acesso é de outra autorizadora*


## 529 - REJEIÇÃO
**529 - Rejeição: NCM de informação obrigatória para produto tributado pelo IPI**
> Correção : *A chave de acesso é de outra autorizadora*


## 530 - REJEIÇÃO
**530 - Rejeição: Operação com tributação de ISSQN sem informar a Inscrição Municipal**
> Correção : *A chave de acesso é de outra autorizadora*


## 531 - REJEIÇÃO
**531 - Rejeição: Total da BC ICMS difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 532 - REJEIÇÃO
**532 - Rejeição: Total do ICMS difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 533 - REJEIÇÃO
**533 - Rejeição: Total da BC ICMS-ST difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 534 - REJEIÇÃO
**534 - Rejeição: Total do ICMS-ST difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 535 - REJEIÇÃO
**535 - Rejeição: Total do Frete difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 536 - REJEIÇÃO
**536 - Rejeição: Total do Seguro difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 537 - REJEIÇÃO
**537 - Rejeição: Total do Desconto difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 538 - REJEIÇÃO
**538 - Rejeição: Total do IPI difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 539 - REJEIÇÃO
**539 - Duplicidade de NF-e com diferença na Chave de Acesso [chNFe: 99999999999999999999999999999999999999999999][nRec:999999999999999]**
> Correção : *A chave de acesso é de outra autorizadora*


## 540 - REJEIÇÃO
**540 - Rejeição: CPF do Local de Retirada inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 541 - REJEIÇÃO
**541 - Rejeição: CPF do Local de Entrega inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 542 - REJEIÇÃO
**542 - Rejeição: CNPJ do Transportador inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 543 - REJEIÇÃO
**543 - Rejeição: CPF do Transportador inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 544 - REJEIÇÃO
**544 - Rejeição: IE do Transportador inválida**
> Correção : *A chave de acesso é de outra autorizadora*


## 545 - REJEIÇÃO
**545 - Rejeição: Falha no schema XML – versão informada na versaoDados do SOAPHeader diverge da versão da mensagem**
> Correção : *A chave de acesso é de outra autorizadora*


## 546 - REJEIÇÃO
**546 - Rejeição: Erro na Chave de Acesso – Campo Id – falta a literal NFe**
> Correção : *A chave de acesso é de outra autorizadora*


## 547 - REJEIÇÃO
**547 - Rejeição: Dígito Verificador da Chave de Acesso da NF-e Referenciada inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 548 - REJEIÇÃO
**548 - Rejeição: CNPJ da NF referenciada inválido.**
> Correção : *A chave de acesso é de outra autorizadora*


## 549 - REJEIÇÃO
**549 - Rejeição: CNPJ da NF referenciada de produtor inválido.**
> Correção : *A chave de acesso é de outra autorizadora*


## 550 - REJEIÇÃO
**550 - Rejeição: CPF da NF referenciada de produtor inválido.**
> Correção : *A chave de acesso é de outra autorizadora*


## 551 - REJEIÇÃO
**551 - Rejeição: IE da NF referenciada de produtor inválido.**
> Correção : *A chave de acesso é de outra autorizadora*


## 552 - REJEIÇÃO
**552 - Rejeição: Dígito Verificador da Chave de Acesso do CT-e Referenciado inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 553 - REJEIÇÃO
**553 - Rejeição: Tipo autorizador do recibo diverge do Órgão Autorizador.**
> Correção : *A chave de acesso é de outra autorizadora*


## 554 - REJEIÇÃO
**554 - Rejeição: Série difere da faixa 0-899**
> Correção : *A chave de acesso é de outra autorizadora*


## 555 - REJEIÇÃO
**555 - Rejeição: Tipo autorizador do protocolo diverge do Órgão Autorizador.**
> Correção : *A chave de acesso é de outra autorizadora*


## 556 - REJEIÇÃO
**556 - Rejeição: Justificativa de entrada em contingência não deve ser informada para tipo de emissão normal**
> Correção : *A chave de acesso é de outra autorizadora*


## 557 - REJEIÇÃO
**557 - Rejeição: A Justificativa de entrada em contingência deve ser informada.**
> Correção : *A chave de acesso é de outra autorizadora*


## 558 - REJEIÇÃO
**558 - Rejeição: Data de entrada em contingência posterior a data de recebimento.**
> Correção : *A chave de acesso é de outra autorizadora*


## 559 - REJEIÇÃO
**559 - Rejeição: UF do Transportador não informada**
> Correção : *A chave de acesso é de outra autorizadora*


## 560 - REJEIÇÃO
**560 - Rejeição: CNPJ base do emitente difere do CNPJ base da primeira NF-e do lote recebido**
> Correção : *A chave de acesso é de outra autorizadora*


## 561 - REJEIÇÃO
**561 - Rejeição: Mês de Emissão informado na Chave de Acesso difere do Mês de Emissão da NF-e**
> Correção : *A chave de acesso é de outra autorizadora*


## 562 - REJEIÇÃO
**562 - Rejeição: Código Numérico informado na Chave de Acesso difere do Código Numérico da NF-e [chNFe:99999999999999999999999999999999999999999999]**
> Correção : *A chave de acesso é de outra autorizadora*


## 563 - REJEIÇÃO
**563 - Rejeição: Já existe pedido de Inutilização com a mesma faixa de inutilização**
> Correção : *A chave de acesso é de outra autorizadora*


## 564 - REJEIÇÃO
**564 - Rejeição: Total do Produto / Serviço difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 565 - REJEIÇÃO
**565 - Rejeição: Falha no schema XML – inexiste a tag raiz esperada para o lote de NF-e**
> Correção : *A chave de acesso é de outra autorizadora*


## 567 - REJEIÇÃO
**567 - Rejeição: Falha no schema XML – versão informada na versaoDados do SOAPHeader diverge da versão do lote de NF-e**
> Correção : *A chave de acesso é de outra autorizadora*


## 568 - REJEIÇÃO
**568 - Rejeição: Falha no schema XML – inexiste atributo versao na tag raiz do lote de NF-e**
> Correção : *A chave de acesso é de outra autorizadora*


## 569 - REJEIÇÃO
**569 - Rejeição: Data de entrada em contingência muito atrasada**
> Correção : *A chave de acesso é de outra autorizadora*


## 570 - REJEIÇÃO
**570 - Rejeição: Tipo de Emissão 3, 6 ou 7 só é válido nas contingências SCAN/SVC**
> Correção : *A chave de acesso é de outra autorizadora*


## 571 - REJEIÇÃO
**571 - Rejeição: O tpEmis informado diferente de 3 para contingência SCAN**
> Correção : *A chave de acesso é de outra autorizadora*


## 572 - REJEIÇÃO
**572 - Rejeição: Erro Atributo ID do evento não corresponde a concatenação dos campos (“ID” + tpEvento + chNFe + nSeqEvento)**
> Correção : *A chave de acesso é de outra autorizadora*


## 573 - REJEIÇÃO
**573 - Rejeição: Duplicidade de Evento**
> Correção : *A chave de acesso é de outra autorizadora*


## 574 - REJEIÇÃO
**574 - Rejeição: O autor do evento diverge do emissor da NF-e**
> Correção : *A chave de acesso é de outra autorizadora*


## 575 - REJEIÇÃO
**575 - Rejeição: O autor do evento diverge do destinatário da NF-e**
> Correção : *A chave de acesso é de outra autorizadora*


## 576 - REJEIÇÃO
**576 - Rejeição: O autor do evento não é um órgão autorizado a gerar o evento**
> Correção : *A chave de acesso é de outra autorizadora*


## 577 - REJEIÇÃO
**577 - Rejeição: A data do evento não pode ser menor que a data de emissão da NF-e**
> Correção : *A chave de acesso é de outra autorizadora*


## 578 - REJEIÇÃO
**578 - Rejeição: A data do evento não pode ser maior que a data do processamento**
> Correção : *A chave de acesso é de outra autorizadora*


## 579 - REJEIÇÃO
**579 - Rejeição: A data do evento não pode ser menor que a data de autorização para NF-e não emitida em contingência**
> Correção : *A chave de acesso é de outra autorizadora*


## 580 - REJEIÇÃO
**580 - Rejeição: O evento exige uma NF-e autorizada**
> Correção : *A chave de acesso é de outra autorizadora*


## 587 - REJEIÇÃO
**587 - Rejeição: Usar somente o namespace padrão da NF-e**
> Correção : *A chave de acesso é de outra autorizadora*


## 588 - REJEIÇÃO
**588 - Rejeição: Não é permitida a presença de caracteres de edição no início/fim da mensagem ou entre as tags da mensagem**
> Correção : *A chave de acesso é de outra autorizadora*


## 589 - REJEIÇÃO
**589 - Rejeição: Número do NSU informado superior ao maior NSU da base de dados da SEFAZ**
> Correção : *A chave de acesso é de outra autorizadora*


## 590 - REJEIÇÃO
**590 - Rejeição: Informado CST para emissor do Simples Nacional (CRT=1)**
> Correção : *A chave de acesso é de outra autorizadora*


## 591 - REJEIÇÃO
**591 - Rejeição: Informado CSOSN para emissor que não é do Simples Nacional (CRT diferente de 1)**
> Correção : *A chave de acesso é de outra autorizadora*


## 592 - REJEIÇÃO
**592 - Rejeição: A NF-e deve ter pelo menos um item de produto sujeito ao ICMS**
> Correção : *A chave de acesso é de outra autorizadora*


## 593 - REJEIÇÃO
**593 - Rejeição: CNPJ-Base consultado difere do CNPJ-Base do Certificado Digital**
> Correção : *A chave de acesso é de outra autorizadora*


## 594 - REJEIÇÃO
**594 - Rejeição: O número de sequencia do evento informado é maior que o permitido**
> Correção : *A chave de acesso é de outra autorizadora*


## 595 - REJEIÇÃO
**595 - Rejeição: Obrigatória a informação da justificativa do evento.**
> Correção : *A chave de acesso é de outra autorizadora*


## 596 - REJEIÇÃO
**596 - Rejeição: Evento apresentado fora do prazo: [prazo vigente]**
> Correção : *A chave de acesso é de outra autorizadora*


## 597 - REJEIÇÃO
**597 - Rejeição: CFOP de Importação e não informado dados de IPI**
> Correção : *A chave de acesso é de outra autorizadora*


## 598 - REJEIÇÃO
**598 - Rejeição: NF-e emitida em ambiente de homologação com Razão Social do destinatário diferente de NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL**
> Correção : *A chave de acesso é de outra autorizadora*


## 599 - REJEIÇÃO
**599 - Rejeição: CFOP de Importação e não informado dados de II**
> Correção : *A chave de acesso é de outra autorizadora*


## 600 - REJEIÇÃO
**600 - CSOSN incompativel na operacao com Nao Contribuinte**
> Correção : *A chave de acesso é de outra autorizadora*


## 601 - REJEIÇÃO
**601 - Rejeição: Total do II difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 602 - REJEIÇÃO
**602 - Rejeição: Total do PIS difere do somatório dos itens sujeitos ao ICMS**
> Correção : *A chave de acesso é de outra autorizadora*


## 603 - REJEIÇÃO
**603 - Rejeição: Total do COFINS difere do somatório dos itens sujeitos ao ICMS**
> Correção : *A chave de acesso é de outra autorizadora*


## 604 - REJEIÇÃO
**604 - Rejeição: Total do vOutro difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 605 - REJEIÇÃO
**605 - Rejeição: Total do vISS difere do somatório do vProd dos itens sujeitos ao ISSQN**
> Correção : *A chave de acesso é de outra autorizadora*


## 606 - REJEIÇÃO
**606 - Rejeição: Total do vBC do ISS difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 607 - REJEIÇÃO
**607 - Rejeição: Total do ISS difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 608 - REJEIÇÃO
**608 - Rejeição: Total do PIS difere do somatório dos itens sujeitos ao ISSQN**
> Correção : *A chave de acesso é de outra autorizadora*


## 609 - REJEIÇÃO
**609 - Rejeição: Total do COFINS difere do somatório dos itens sujeitos ao ISSQN**
> Correção : *A chave de acesso é de outra autorizadora*


## 610 - REJEIÇÃO
**610 - Rejeição: Total da NF difere do somatório dos Valores compõe o valor Total da NF.**
> Correção : *A chave de acesso é de outra autorizadora*


## 611 - REJEIÇÃO
**611 - Rejeição: cEAN inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 612 - REJEIÇÃO
**612 - Rejeição: cEANTrib inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 613 - REJEIÇÃO
**613 - Rejeição: Chave de Acesso difere da existente em BD**
> Correção : *A chave de acesso é de outra autorizadora*


## 614 - REJEIÇÃO
**614 - Rejeição: Chave de Acesso inválida (Código UF inválido)**
> Correção : *A chave de acesso é de outra autorizadora*


## 615 - REJEIÇÃO
**615 - Rejeição: Chave de Acesso inválida (Ano menor que 06 ou Ano maior que Ano corrente)**
> Correção : *A chave de acesso é de outra autorizadora*


## 616 - REJEIÇÃO
**616 - Rejeição: Chave de Acesso inválida (Mês menor que 1 ou Mês maior que 12)**
> Correção : *A chave de acesso é de outra autorizadora*


## 617 - REJEIÇÃO
**617 - Rejeição: Chave de Acesso inválida (CNPJ zerado ou dígito inválido)**
> Correção : *A chave de acesso é de outra autorizadora*


## 618 - REJEIÇÃO
**618 - Rejeição: Chave de Acesso inválida (modelo diferente de 55 e 65)**
> Correção : *A chave de acesso é de outra autorizadora*


## 619 - REJEIÇÃO
**619 - Rejeição: Chave de Acesso inválida (número NF = 0)**
> Correção : *A chave de acesso é de outra autorizadora*


## 620 - REJEIÇÃO
**620 - Rejeição: Chave de Acesso difere da existente em BD**
> Correção : *A chave de acesso é de outra autorizadora*


## 621 - REJEIÇÃO
**621 - Rejeição: CPF Emitente não cadastrado**
> Correção : *A chave de acesso é de outra autorizadora*


## 622 - REJEIÇÃO
**622 - Rejeição: IE emitente não vinculada ao CPF**
> Correção : *A chave de acesso é de outra autorizadora*


## 623 - REJEIÇÃO
**623 - Rejeição: CPF Destinatário não cadastrado**
> Correção : *A chave de acesso é de outra autorizadora*


## 624 - REJEIÇÃO
**624 - Rejeição: IE Destinatário não vinculada ao CPF**
> Correção : *A chave de acesso é de outra autorizadora*


## 625 - REJEIÇÃO
**625 - Rejeição: Inscrição SUFRAMA deve ser informada na venda com isenção para ZFM**
> Correção : *A chave de acesso é de outra autorizadora*


## 626 - REJEIÇÃO
**626 - Rejeição: CFOP de operação isenta para ZFM diferente do previsto**
> Correção : *A chave de acesso é de outra autorizadora*


## 627 - REJEIÇÃO
**627 - Rejeição: O valor do ICMS desonerado deve ser informado**
> Correção : *A chave de acesso é de outra autorizadora*


## 628 - REJEIÇÃO
**628 - Rejeição: Total da NF superior ao valor limite estabelecido pela SEFAZ [Limite]**
> Correção : *A chave de acesso é de outra autorizadora*


## 629 - REJEIÇÃO
**629 - Rejeição: Valor do Produto difere do produto Valor Unitário de Comercialização e Quantidade Comercial**
> Correção : *A chave de acesso é de outra autorizadora*


## 630 - REJEIÇÃO
**630 - Rejeição: Valor do Produto difere do produto Valor Unitário de Tributação e Quantidade Tributável**
> Correção : *A chave de acesso é de outra autorizadora*


## 631 - REJEIÇÃO
**631 - Rejeição: CNPJ-Base do Destinatário difere do CNPJ-Base do Certificado Digital**
> Correção : *A chave de acesso é de outra autorizadora*


## 632 - REJEIÇÃO
**632 - Rejeição: Solicitação fora de prazo, a NF-e não está mais disponível para download**
> Correção : *A chave de acesso é de outra autorizadora*


## 633 - REJEIÇÃO
**633 - Rejeição: NF-e indisponível para download devido a ausência de Manifestação do Destinatário**
> Correção : *A chave de acesso é de outra autorizadora*


## 634 - REJEIÇÃO
**634 - Rejeição: Destinatário da NF-e não tem o mesmo CNPJ raiz do solicitante do download**
> Correção : *A chave de acesso é de outra autorizadora*


## 635 - REJEIÇÃO
**635 - Rejeição: NF-e com mesmo número e série já transmitida e aguardando processamento**
> Correção : *A chave de acesso é de outra autorizadora*


## 650 - REJEIÇÃO
**650 - Rejeição: Evento de "Ciência da Emissão" para NF-e Cancelada ou Denegada**
> Correção : *A chave de acesso é de outra autorizadora*


## 651 - REJEIÇÃO
**651 - Rejeição: Evento de "Desconhecimento da Operação" para NF-e Cancelada ou Denegada**
> Correção : *A chave de acesso é de outra autorizadora*


## 653 - REJEIÇÃO
**653 - Rejeição: NF-e Cancelada, arquivo indisponível para download**
> Correção : *A chave de acesso é de outra autorizadora*


## 654 - REJEIÇÃO
**654 - Rejeição: NF-e Denegada, arquivo indisponível para download**
> Correção : *A chave de acesso é de outra autorizadora*


## 655 - REJEIÇÃO
**655 - Rejeição: Evento de Ciência da Emissão informado após a manifestação final do destinatário**
> Correção : *A chave de acesso é de outra autorizadora*


## 656 - REJEIÇÃO
**656 - Rejeição: Consumo Indevido**
> Correção : *A chave de acesso é de outra autorizadora*


## 657 - REJEIÇÃO
**657 - Rejeição: Código do Órgão diverge do órgão autorizador**
> Correção : *A chave de acesso é de outra autorizadora*


## 658 - REJEIÇÃO
**658 - Rejeição: UF do destinatário da Chave de Acesso diverge da UF autorizadora**
> Correção : *A chave de acesso é de outra autorizadora*


## 660 - REJEIÇÃO
**660 - Rejeição: CFOP de Combustível e não informado grupo de combustível da NF-e**
> Correção : *A chave de acesso é de outra autorizadora*


## 661 - REJEIÇÃO
**661 - Rejeição: NF-e já existente para o número do EPEC informado**
> Correção : *A chave de acesso é de outra autorizadora*


## 662 - REJEIÇÃO
**662 - Rejeição: Numeração do EPEC está inutilizada na Base de Dados da SEFAZ**
> Correção : *A chave de acesso é de outra autorizadora*


## 663 - REJEIÇÃO
**663 - Rejeição: Alíquota do ICMS com valor superior a 4 por cento na operação de saída interestadual com produtos importados**
> Correção : *A chave de acesso é de outra autorizadora*


## 678 - REJEIÇÃO
**678 - Rejeição: NF referenciada com UF diferente da NF-e complementar**
> Correção : *A chave de acesso é de outra autorizadora*


## 679 - REJEIÇÃO
**679 - Rejeição: Modelo da NF-e referenciada diferente de 55/65**
> Correção : *A chave de acesso é de outra autorizadora*


## 680 - REJEIÇÃO
**680 - Rejeição: Duplicidade de NF-e referenciada (Chave de Acesso referenciada mais de uma vez)**
> Correção : *A chave de acesso é de outra autorizadora*


## 681 - REJEIÇÃO
**681 - Rejeição: Duplicidade de NF Modelo 1 referenciada (CNPJ, Modelo, Série e Número)**
> Correção : *A chave de acesso é de outra autorizadora*


## 682 - REJEIÇÃO
**682 - Rejeição: Duplicidade de NF de Produtor referenciada (IE, Modelo, Série e Número)**
> Correção : *A chave de acesso é de outra autorizadora*


## 683 - REJEIÇÃO
**683 - Rejeição: Modelo do CT-e referenciado diferente de 57**
> Correção : *A chave de acesso é de outra autorizadora*


## 684 - REJEIÇÃO
**684 - Rejeição: Duplicidade de Cupom Fiscal referenciado (Modelo, Número de Ordem e COO)**
> Correção : *A chave de acesso é de outra autorizadora*


## 685 - REJEIÇÃO
**685 - Rejeição: Total do Valor Aproximado dos Tributos difere do somatório dos itens**
> Correção : *A chave de acesso é de outra autorizadora*


## 686 - REJEIÇÃO
**686 - Rejeição: NF Complementar referencia uma NF-e cancelada**
> Correção : *A chave de acesso é de outra autorizadora*


## 687 - REJEIÇÃO
**687 - Rejeição: NF Complementar referencia uma NF-e denegada**
> Correção : *A chave de acesso é de outra autorizadora*


## 688 - REJEIÇÃO
**688 - Rejeição: NF referenciada de Produtor com IE inexistente [nRef: xxx]**
> Correção : *A chave de acesso é de outra autorizadora*


## 689 - REJEIÇÃO
**689 - Rejeição: NF referenciada de Produtor com IE não vinculada ao CNPJ/CPF informado [nRef: xxx]**
> Correção : *A chave de acesso é de outra autorizadora*


## 690 - REJEIÇÃO
**690 - Rejeição: Pedido de Cancelamento para NF-e com CT-e**
> Correção : *A chave de acesso é de outra autorizadora*


## 691 - REJEIÇÃO
**691 - Rejeição: Chave de Acesso da NF-e diverge da Chave de Acesso do EPEC**
> Correção : *A chave de acesso é de outra autorizadora*


## 692 - REJEIÇÃO
**692 - 692-Rejeição: Existe EPEC registrado para esta Série e Número [Chave EPEC: xxxxxxxxxxx]**
> Correção : *A chave de acesso é de outra autorizadora*


## 693 - REJEIÇÃO
**693 - Alíquota de ICMS superior a definida para a operação interestadual [nItem:999]**
> Correção : *A chave de acesso é de outra autorizadora*


## 694 - REJEIÇÃO
**694 - Peça orientação ao seu contador sobre a partilha de ICMS entre estados. No caso da operação ser com consumidor final (= 1 Sim), a UF do destinatário ser outra que a UF do emitente, e o tipo de contribuinte ser 9 - Não Contribuinte, que pode ou não possuir Inscrição Estadual no Cadastro de Contribuintes do ICMS, as informações de partilha de ICMS devem ser informadas no passo 3, como: pFCPUFDest, pICMSInter, pICMSInterPart, pICMSUFDest, vBCUFDest, vFCPUFDest, vICMSUFDest e vICMSUFRemet. Não informado o grupo de ICMS para a UF de destino [nItem:999]**
> Correção : *A chave de acesso é de outra autorizadora*


## 695 - REJEIÇÃO
**695 -  Informado indevidamente o grupo de ICMS para a UF de destino [nItem:999]**
> Correção : *A chave de acesso é de outra autorizadora*


## 696 - REJEIÇÃO
**696 - No passo 1, mude "Consumidor Final" para "1 - Sim"Operacao com nao contribuinte deve indicar operacao com consumidor final**
> Correção : *A chave de acesso é de outra autorizadora*


## 697 - REJEIÇÃO
**697 - Alíquota interestadual do ICMS com origem diferente do previsto [nItem:999]**
> Correção : *A chave de acesso é de outra autorizadora*


## 698 - REJEIÇÃO
**698 - Peça orientação ao seu contador sobre a partilha de ICMS entre estados. No caso da operação ser com consumidor final (= 1 Sim), a UF do destinatário ser outra que a UF do emitente, e o tipo de contribuinte ser 9 - Não Contribuinte, que pode ou não possuir Inscrição Estadual no Cadastro de Contribuintes do ICMS, as informações de partilha de ICMS devem ser informadas no passo 3, como: pFCPUFDest, pICMSInter, pICMSInterPart, pICMSUFDest, vBCUFDest, vFCPUFDest, vICMSUFDest e vICMSUFRemet. Alíquota interestadual do ICMS incompatível com as UF envolvidas na operação [nItem:999]**
> Correção : *A chave de acesso é de outra autorizadora*


## 699 - REJEIÇÃO
**699 - Percentual do ICMS Interestadual para a UF de destino difere do previsto para o ano da Data de Emissão [nItem:999]**
> Correção : *A chave de acesso é de outra autorizadora*


## 700 - REJEIÇÃO
**700 - Rejeição: Mensagem de Lote versão 3.xx. Enviar para o Web Service nfeAutorizacao**
> Correção : *A chave de acesso é de outra autorizadora*


## 701 - REJEIÇÃO
**701 - Rejeição: NF-e não pode utilizar a versão 3.00**
> Correção : *A chave de acesso é de outra autorizadora*


## 702 - REJEIÇÃO
**702 - Rejeição: NFC-e não é aceita pela UF do Emitente**
> Correção : *A chave de acesso é de outra autorizadora*


## 703 - REJEIÇÃO
**703 - Rejeição: Data-Hora de Emissão posterior ao horário de recebimento**
> Correção : *A chave de acesso é de outra autorizadora*


## 704 - REJEIÇÃO
**704 - Rejeição: NFC-e com Data-Hora de emissão atrasada**
> Correção : *A chave de acesso é de outra autorizadora*


## 705 - REJEIÇÃO
**705 - Rejeição: NFC-e com data de entrada/saída**
> Correção : *A chave de acesso é de outra autorizadora*


## 706 - REJEIÇÃO
**706 - Rejeição: NFC-e para operação de entrada**
> Correção : *A chave de acesso é de outra autorizadora*


## 707 - REJEIÇÃO
**707 - Rejeição: NFC-e para operação interestadual ou com o exterior**
> Correção : *A chave de acesso é de outra autorizadora*


## 708 - REJEIÇÃO
**708 - Rejeição: NFC-e não pode referenciar documento fiscal**
> Correção : *A chave de acesso é de outra autorizadora*


## 709 - REJEIÇÃO
**709 - Rejeição: NFC-e com formato de DANFE inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 710 - REJEIÇÃO
**710 - Rejeição: NF-e com formato de DANFE inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 711 - REJEIÇÃO
**711 - Rejeição: NF-e com contingência off-line**
> Correção : *A chave de acesso é de outra autorizadora*


## 712 - REJEIÇÃO
**712 - Rejeição: NFC-e com contingência off-line para a UF**
> Correção : *A chave de acesso é de outra autorizadora*


## 713 - REJEIÇÃO
**713 - Rejeição: Tipo de Emissão diferente de 6 ou 7 para contingência da SVC acessada**
> Correção : *A chave de acesso é de outra autorizadora*


## 714 - REJEIÇÃO
**714 - Rejeição: NFC-e com contingência DPEC inexistente**
> Correção : *A chave de acesso é de outra autorizadora*


## 715 - REJEIÇÃO
**715 - Rejeição: NFC-e com finalidade inválida**
> Correção : *A chave de acesso é de outra autorizadora*


## 716 - REJEIÇÃO
**716 - Rejeição: NFC-e em operação não destinada a consumidor final**
> Correção : *A chave de acesso é de outra autorizadora*


## 717 - REJEIÇÃO
**717 - Rejeição: NFC-e em operação não presencial**
> Correção : *A chave de acesso é de outra autorizadora*


## 718 - REJEIÇÃO
**718 - Rejeição: NFC-e não deve informar IE de Substituto Tributário**
> Correção : *A chave de acesso é de outra autorizadora*


## 719 - REJEIÇÃO
**719 - Rejeição: NF-e sem a identificação do destinatário**
> Correção : *A chave de acesso é de outra autorizadora*


## 720 - REJEIÇÃO
**720 - Rejeição: Na operação com Exterior deve ser informada tag idEstrangeiro**
> Correção : *A chave de acesso é de outra autorizadora*


## 721 - REJEIÇÃO
**721 - Rejeição: Operação interestadual deve informar CNPJ ou CPF.**
> Correção : *A chave de acesso é de outra autorizadora*


## 722 - REJEIÇÃO
**722 - Operação interna com idEstrangeiro informado deve ser presencial**
> Correção : *A chave de acesso é de outra autorizadora*


## 723 - REJEIÇÃO
**723 - Rejeição: Operação interna com idEstrangeiro informado deve ser para consumidor final**
> Correção : *A chave de acesso é de outra autorizadora*


## 724 - REJEIÇÃO
**724 - Rejeição: NF-e sem o nome do destinatário**
> Correção : *A chave de acesso é de outra autorizadora*


## 725 - REJEIÇÃO
**725 - Rejeição: NFC-e com CFOP inválido**
> Correção : *A chave de acesso é de outra autorizadora*


## 726 - REJEIÇÃO
**726 - Rejeição: NF-e sem a informação de endereço do destinatário**
> Correção : *A chave de acesso é de outra autorizadora*


## 727 - REJEIÇÃO
**727 - Rejeição: Operação com Exterior e UF diferente de EX**
> Correção : *A chave de acesso é de outra autorizadora*


## 728 - REJEIÇÃO
**728 - Rejeição: NF-e sem informação da IE do destinatário**
> Correção : *A chave de acesso é de outra autorizadora*


## 729 - REJEIÇÃO
**729 - Rejeição: NFC-e com informação da IE do destinatário**
> Correção : *A chave de acesso é de outra autorizadora*


## 730 - REJEIÇÃO
**730 - Rejeição: NFC-e com Inscrição Suframa**
> Correção : *A chave de acesso é de outra autorizadora*


## 731 - REJEIÇÃO
**731 - Rejeição: CFOP de operação com Exterior e idDest <> 3**
> Correção : *A chave de acesso é de outra autorizadora*


## 732 - REJEIÇÃO
**732 - Rejeição: CFOP de operação interestadual e idDest <> 2**
> Correção : *A chave de acesso é de outra autorizadora*


## 733 - REJEIÇÃO
**733 - Rejeição: CFOP de operação interna e idDest <> 1**
> Correção : *A chave de acesso é de outra autorizadora*


## 734 - REJEIÇÃO
**734 - Rejeição: NFC-e com Unidade de Comercialização inválida**
> Correção : *A chave de acesso é de outra autorizadora*


## 735 - REJEIÇÃO
**735 - Rejeição: NFC-e com Unidade de Tributação inválida**
> Correção : *A chave de acesso é de outra autorizadora*


## 736 - REJEIÇÃO
**736 - Rejeição: NFC-e com grupo de Veículos novos**
> Correção : *A chave de acesso é de outra autorizadora*


## 737 - REJEIÇÃO
**737 - Rejeição: NFC-e com grupo de Medicamentos**
> Correção : *A chave de acesso é de outra autorizadora*


## 738 - REJEIÇÃO
**738 - Rejeição: NFC-e com grupo de Armamentos**
> Correção : *A chave de acesso é de outra autorizadora*


## 739 - REJEIÇÃO
**739 - Rejeição: NFC-e com grupo de Combustível**
> Correção : *A chave de acesso é de outra autorizadora*


## 740 - REJEIÇÃO
**740 - Rejeição: NFC-e com CST 51-Diferimento**
> Correção : *A chave de acesso é de outra autorizadora*


## 741 - REJEIÇÃO
**741 - Rejeição: NFC-e com Partilha de ICMS entre UF**
> Correção : *A chave de acesso é de outra autorizadora*


## 742 - REJEIÇÃO
**742 - Rejeição: NFC-e com grupo do IPI**
> Correção : *A chave de acesso é de outra autorizadora*


## 743 - REJEIÇÃO
**743 - Rejeição: NFC-e com grupo do II**
> Correção : *A chave de acesso é de outra autorizadora*


## 745 - REJEIÇÃO
**745 - Rejeição: NF-e sem grupo do PIS**
> Correção : *A chave de acesso é de outra autorizadora*


## 746 - REJEIÇÃO
**746 - Rejeição: NFC-e com grupo do PIS-ST**
> Correção : *A chave de acesso é de outra autorizadora*


## 748 - REJEIÇÃO
**748 - Rejeição: NF-e sem grupo da COFINS**
> Correção : *A chave de acesso é de outra autorizadora*


## 749 - REJEIÇÃO
**749 - Rejeição: NFC-e com grupo da COFINS-ST**
> Correção : *A chave de acesso é de outra autorizadora*


## 750 - REJEIÇÃO
**750 - Rejeição: NFC-e com valor total superior ao permitido para destinatário não identificado (Código)**
> Correção : *A chave de acesso é de outra autorizadora*


## 751 - REJEIÇÃO
**751 - Rejeição: NFC-e com valor total superior ao permitido para destinatário não identificado (Nome)**
> Correção : *A chave de acesso é de outra autorizadora*


## 752 - REJEIÇÃO
**752 - Rejeição: NFC-e com valor total superior ao permitido para destinatário não identificado (Endereço)**
> Correção : *A chave de acesso é de outra autorizadora*


## 752 - REJEIÇÃO
**752 - Rejeição: NFC-e com Frete**
> Correção : *A chave de acesso é de outra autorizadora*


## 754 - REJEIÇÃO
**754 - Rejeição: NFC-e com dados do Transportador**
> Correção : *A chave de acesso é de outra autorizadora*


## 755 - REJEIÇÃO
**755 - Rejeição: NFC-e com dados de Retenção do ICMS no Transporte**
> Correção : *A chave de acesso é de outra autorizadora*


## 756 - REJEIÇÃO
**756 - Rejeição: NFC-e com dados do veículo de Transporte**
> Correção : *A chave de acesso é de outra autorizadora*


## 757 - REJEIÇÃO
**757 - Rejeição: NFC-e com dados de Reboque do veículo de Transporte**
> Correção : *A chave de acesso é de outra autorizadora*


## 758 - REJEIÇÃO
**758 - Rejeição: NFC-e com dados do Vagão de Transporte**
> Correção : *A chave de acesso é de outra autorizadora*


## 759 - REJEIÇÃO
**759 - Rejeição: NFC-e com dados da Balsa de Transporte**
> Correção : *A chave de acesso é de outra autorizadora*


## 760 - REJEIÇÃO
**760 - Rejeição: NFC-e com dados de cobrança (Fatura, Duplicata)**
> Correção : *A chave de acesso é de outra autorizadora*


## 762 - REJEIÇÃO
**762 - Rejeição: NFC-e com dados de compras (Empenho, Pedido, Contrato)**
> Correção : *A chave de acesso é de outra autorizadora*


## 763 - REJEIÇÃO
**763 - Rejeição: NFC-e com dados de aquisição de Cana**
> Correção : *A chave de acesso é de outra autorizadora*


## 764 - REJEIÇÃO
**764 - Rejeição: Solicitada resposta síncrona para Lote com mais de uma NF-e (indSinc=1)**
> Correção : *A chave de acesso é de outra autorizadora*


## 765 - REJEIÇÃO
**765 - Rejeição: Lote só poderá conter NF-e ou NFC-e**
> Correção : *A chave de acesso é de outra autorizadora*


## 766 - REJEIÇÃO
**766 - Rejeição: NFC-e com CST 50-Suspensão**
> Correção : *A chave de acesso é de outra autorizadora*


## 767 - REJEIÇÃO
**767 - Rejeição: NFC-e com somatório dos pagamentos diferente do total da Nota Fiscal**
> Correção : *A chave de acesso é de outra autorizadora*


## 768 - REJEIÇÃO
**768 - Rejeição: NF-e não deve possuir o grupo de Formas de Pagamento**
> Correção : *A chave de acesso é de outra autorizadora*


## 769 - REJEIÇÃO
**769 - Rejeição: A critério da UF NFC-e deve possuir o grupo de Formas de Pagamento**
> Correção : *A chave de acesso é de outra autorizadora*


## 770 - REJEIÇÃO
**770 - Rejeição: NFC-e autorizada há mais de 24 horas.**
> Correção : *A chave de acesso é de outra autorizadora*


## 771 - REJEIÇÃO
**771 - Rejeição: Operação Interestadual e UF de destino com EX**
> Correção : *A chave de acesso é de outra autorizadora*


## 772 - REJEIÇÃO
**772 - Rejeição: Operação Interestadual e UF de destino igual à UF do emitente**
> Correção : *Operação indicada como interestadual mas a UF do destinatário é a mesmo do emitente.*


## 773 - REJEIÇÃO
**773 - Rejeição: Operação Interna e UF de destino difere da UF do emitente**
> Correção : *A UF do destinatário é diferente do emitente*


## 774 - REJEIÇÃO
**774 - Rejeição: NFC-e com indicador de item não participante do total**
> Correção : *Em NFCe todos os itens da notas integram o total, algum item não está dessa forma.*


## 775 - REJEIÇÃO
**775 - Rejeição: Modelo da NFC-e diferente de 65**
> Correção : *NFCe deve ter modelo 65 apenas, , informe o administrador do sistema*


## 776 - REJEIÇÃO
**776 - Rejeição: Solicitada resposta síncrona para UF que não disponibiliza este atendimento (indSinc=1)**
> Correção : *Não existe opereção sincrona, informe o administrador do sistema*


## 777 - REJEIÇÃO
**777 - Rejeição: Obrigatória a informação do NCM completo**
> Correção : *NCM incompleto, esse numero deve ter 8 digitos*


## 778 - REJEIÇÃO
**778 - Rejeição: Informado NCM inexistente**
> Correção : *Verifique o código NCM está errado. Lembre-se que esses códigos mudam e ninguém te avisa disso*


## 779 - REJEIÇÃO
**779 - Rejeição: NFC-e com NCM incompatível**
> Correção : *NCM do produto incompatível com NFCe*


## 780 - REJEIÇÃO
**780 - Rejeição: Total da NFC-e superior ao valor limite estabelecido pela SEFAZ [Limite]**
> Correção : *A NFCe indica um valor muito alto, acima do permitido*


## 781 - REJEIÇÃO
**781 - Rejeição: Emissor não habilitado para emissão da NFC-e**
> Correção : *CNPJ não habilitado, entre em contado com SEFAZ*


## 782 - REJEIÇÃO
**782 - Rejeição: NFC-e não é autorizada pelo SCAN**
> Correção : *NFCe não pode usar essa contingêcia*


## 783 - REJEIÇÃO
**783 - Rejeição: NFC-e não é autorizada pela SVC**
> Correção : *NFCe não pode usar essa contingêcia*


## 784 - REJEIÇÃO
**784 - Rejeição: NFC-e não permite o evento de Carta de Correção**
> Correção : *NFCe não aceita carta de correção, se existe erro cancele e emita outra NFCe*


## 785 - REJEIÇÃO
**785 - Rejeição: NFC-e com entrega a domicílio não permitida pela UF**
> Correção : *Esta UF não permite essa operação com entrega em domicilio*


## 786 - REJEIÇÃO
**786 - Rejeição: NFC-e de entrega a domicílio sem dados do Transportador**
> Correção : *Entrega em domicilio sem dados do transportador*


## 787 - REJEIÇÃO
**787 - Rejeição: NFC-e de entrega a domicílio sem a identificação do destinatário**
> Correção : *Entrega em domicilio sem a identificação do destinatário*


## 788 - REJEIÇÃO
**788 - Rejeição: NFC-e de entrega a domicílio sem o endereço do destinatário**
> Correção : *Indicada entrega em domicilio sem o endereço do destinatário*


## 789 - REJEIÇÃO
**789 - Rejeição: NFC-e para destinatário contribuinte de ICMS**
> Correção : *NFCe é apenas para consumidores e não para contribuintes*


## 790 - REJEIÇÃO
**790 - Rejeição: Operação com Exterior para destinatário Contribuinte de ICMS**
> Correção : *Exportação não pode ter um contribuinte do ICMS no exterior*


## 791 - REJEIÇÃO
**791 - Rejeição: NF-e com indicação de destinatário isento de IE, com a informação da IE do destinatário**
> Correção : *Foi indicada operação com Contribuinte isento de Inscrição no cadastro de Contribuintes do ICMS e informada a IE do destinatário*


## 792 - REJEIÇÃO
**792 - Rejeição: Informada a IE do destinatário para operação com destinatário no Exterior**
> Correção : *Em operações de exportação não pode ser indicado um IE*


## 793 - REJEIÇÃO
**793 - Rejeição: Informado Capítulo do NCM inexistente**
> Correção : *Confira o NCM está incorreto*


## 794 - REJEIÇÃO
**794 - Rejeição: NF-e com indicativo de NFC-e com entrega a domicílio**
> Correção : *NFC-e em operação com entrega a domicílio e não foram informados os dados do destinatário*


## 795 - REJEIÇÃO
**795 - Rejeição: Total do ICMS desonerado difere do somatório dos itens**
> Correção : *Valor da soma do ICMS desonerado dos itens não está igual ao valor do ICMS desonerado no total da nota. Verifique se o CST da nota está correto, caso esteja como por exemplo '00 - Tributado Integralmente' o valor do ICMS desonerado por item não será destacado, gerado assim essa rejeição no envio.*


## 796 - REJEIÇÃO
**796 - Rejeição: Empresa sem Chave de Segurança para o QR-Code**
> Correção : *Confira o CSC e o CSCid*


## 798 - REJEIÇÃO
**798 - Valor total do ICMS relativo Fundo de Combate à Pobreza (FCP) da UF de destino difere do somatório do valor dos itens**
> Correção : *Confira o CSC e o CSCid*


## 799 - REJEIÇÃO
**799 - Valor total do ICMS Interestadual da UF de destino difere do somatório dos itens**
> Correção : *Confira o CSC e o CSCid*


## 800 - REJEIÇÃO
**800 - Valor total do ICMS Interestadual da UF do remetente difere do somatório dos itens**
> Correção : *Confira o CSC e o CSCid*


## 805 - REJEIÇÃO
**805 - A SEFAZ do destinatário não permite Contribuinte Isento de Inscrição Estadual**
> Correção : *Confira o CSC e o CSCid*


## 806 - REJEIÇÃO
**806 - A partir de 01.10.2016 é obrigatória a informação do CEST, Código Especificador de Substituição Tributária, um código composto por 6 algarimos. No painel editar o produto você tem um botão "Tabela CEST" que exibe uma lista completa dos CESTs.Operação com ICMS-ST sem informação do CEST**
> Correção : *Confira o CSC e o CSCid*


## 807 - REJEIÇÃO
**807 - NFC-e com grupo de ICMS para a UF do destinatário**
> Correção : *Confira o CSC e o CSCid*


## 817 - REJEIÇÃO
**817 - Unidade Tributavel incompativel com o NCM informado na operacao com Comercio Exterior**
> Correção : *Confira o CSC e o CSCid*


## 999 - REJEIÇÃO
**999 - Rejeição: Erro não catalogado (informar a mensagem de erro capturado no tratamento da exceção)**
> Correção : *Isso é um problema provavelmente da SEFAZ*


##  - REJEIÇÃO
** - **
> Correção : *Isso é um problema provavelmente da SEFAZ*


