# Erro DH Key too small


O openssl na versão 3 dá erros aos usar os certificados digitais, então devemos ativar o modo legado do OpenSSL 1.1.1, pesquise na internet.

No linux (especialmente Debian e derivados) para resolver, edite o arquivo:

sudo nano /etc/ssl/openssl.cnf

```
# List of providers to load
[provider_sect]
default = default_sect
legacy = legacy_sect

[default_sect]
activate = 1

[legacy_sect]
activate = 1
```

Se ainda assim não deu resultado, inclua:

```
[default_conf]
ssl_conf = ssl_sect
 
[ssl_sect]
system_default = system_default_sect
 
[system_default_sect]
MinProtocol = TLSv1
CipherString = DEFAULT@SECLEVEL=1
```
