var query = location.search.slice(1);
var partes = query.split('&');
var data = {};
partes.forEach(function (parte) {
    var chaveValor = parte.split('=');
    var chave = chaveValor[0];
    var valor = chaveValor[1];
    data[chave] = valor;
});
console.log(data)

/*
As variáveis de parâmetros do get devem vir como txc(taxa crédito), txa(taxa antecipação), txd(taxa débito), txc2a6 e txc7a12 . 
Os parâmetros deverão vir nesse formato: https://services1.btx.digital/simula_taxa/?txc=2&txa=1.75&txd=1.50&txc2a6=3.5&txc7a12=5
*/

function credito(valor, parcelas) {
    var mdr
    if (parcelas >= 2 && parcelas <= 6) {
        mdr = parseFloat(data.txc2a6)
    } else if (parcelas >= 7 && parcelas <= 12) {
        mdr = parseFloat(data.txc7a12)
    }
    else {
        mdr = parseFloat(data.txc)
    }
    var valorComTaxa = valor - (mdr * valor / 100)
    var vParcela = valorComTaxa / parcelas
    var valorLiquido = (valorComTaxa).toFixed(2)
    console.log("Taxa Efetiva: "+mdr+"%")

    return valorLiquido;
}

function creditoAntecipado(valor, parcelas) {
    var mdr
    if (parcelas >= 2 && parcelas <= 6) {
        mdr = parseFloat(data.txc2a6)
    } else if (parcelas >= 7 && parcelas <= 12) {
        mdr = parseFloat(data.txc7a12)
    }
    else {
        mdr = parseFloat(data.txc)
    }

    var valorComTaxa = valor - (mdr * valor / 100)

    var vParcela = valorComTaxa / parcelas
    var vPrazoMedio = prazoMedio(parcelas)
    var taxaAntecipacao = parseFloat(data.txa) / 100 //valor em %
    var taxaMediaDia = Math.pow(1 + taxaAntecipacao, 1 / 30) - 1
    var antecipacao = valorComTaxa * vPrazoMedio * taxaMediaDia
    var taxaEfetiva = (valor - valorComTaxa + antecipacao) / valor
    console.log("Taxa Efetiva: "+taxaEfetiva+"%")

    var valorLiquido = (valorComTaxa - antecipacao).toFixed(2)
    return valorLiquido;
}

function valorDebito(valor) {
    var mdr = parseFloat(data.txd)
    var valorLiquido = valor - (mdr * valor / 100)

    return valorLiquido;
}
function prazoMedio(nParcela) {
    var dias = 30
    if (nParcela == 1) {
        dias = 30
    } else {
        for (var i = nParcela; i > 1; i--) {
            dias = dias + 15
        }
    }
    return dias
}