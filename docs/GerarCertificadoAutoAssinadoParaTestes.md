# Gerar Certificado auto assinado

## Para um CNPJ
1 - Gerar chave privada:
```
openssl genpkey -algorithm RSA -out private.key -pkeyopt rsa_keygen_bits:2048
```

2 - Crie o arquivo de configuração openssl.cnf:

```
[ req ]
distinguished_name = req_distinguished_name
x509_extensions = v3_ca
req_extensions = v3_req

[ req_distinguished_name ]
C = BR
ST = São Paulo
L = São Paulo
O = Sua Empresa
OU = Unidade de TI
CN = 05.730.928/0001-45
emailAddress = email@suaempresa.com.br

[ v3_ca ]
subjectAltName = @alt_names
basicConstraints = CA:TRUE
keyUsage = keyCertSign, cRLSign

[ v3_req ]
basicConstraints = CA:FALSE
keyUsage = nonRepudiation, digitalSignature, keyEncipherment
subjectAltName = @alt_names
2.16.76.1.3.3 = ASN1:UTF8String:05730928000145

[ alt_names ]
email = email@suaempresa.com.br
```

3 - Gere o certificado autoassinado:

```bash
openssl req -new -x509 -days 3650 -key private.key -out certificate.crt -config openssl.cnf -extensions v3_req
```

4 - Converta para o formato PFX:

```bash
openssl pkcs12 -export -out certificate.pfx -inkey private.key -in certificate.crt -certfile certificate.crt -passout pass:minhasenha
```


## Para um CPF

Mesmos passos anteriores, exeto o arquivo openssl.cnf será esse abaixo.
Note que o oid 2.16.76.1.3.1 é composto por uma data de nascimento seguido do CPF.
2.16.76.1.3.1 = ASN1:UTF8String:ddddddddccccccccccc
Onde d é data de nascimento e c é o cpf somente números.

```
[ req ]
distinguished_name = req_distinguished_name
x509_extensions = v3_ca
req_extensions = v3_req

[ req_distinguished_name ]
C = BR
ST = São Paulo
L = São Paulo
O = SpedNfe
OU = Unidade de TI
CN = 904.839.260-86
emailAddress = email@suaempresa.com.br

[ v3_ca ]
subjectAltName = @alt_names
basicConstraints = CA:TRUE
keyUsage = keyCertSign, cRLSign

[ v3_req ]
basicConstraints = CA:FALSE
keyUsage = nonRepudiation, digitalSignature, keyEncipherment
subjectAltName = @alt_names
2.16.76.1.3.1 = ASN1:UTF8String:1210198506157250000116

[ alt_names ]
email = email@suaempresa.com.br

```
