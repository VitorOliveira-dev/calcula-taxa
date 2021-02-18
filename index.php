<?php include("cabecalho.php"); ?>

<h2 class="margin-cima_baixo centralize">Receba suas vendas no crédito à vista em 1 dia sem pagar taxa para antecipar</h2>

<div class="margin-lateral margin-cima_baixo">

    <!-- 1 -->
    <div class="card-group centralize shadow">
        <!-- À vista -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Crédito à vista</h5>
                <h3 id="exibe" class="CLCreditoV">R$ 0,00</h3>
                <div style="position: relative;">
                    <input class="RngCreditoV" type="range" id="rangeValue" name="vol" value="0" min="0" max="10000" step="10">

                </div>
            </div>
        </div>

        <!-- Parcelado -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Crédito Parcelado</h5>
                <h3 id="exibe" class="CLCreditoP">R$ 0,00</h3>
                <input class="RngCreditoP" type="range" id="rangeValue" name="vol" value="0" min="0" max="10000" step="10"><br>
                <label>Parcelas</label>
                <center>
                    <select style="width: 70px;" id="parcela" class="form-select" aria-label="Default select example">
                        <option value="1" selected>1x</option>
                        <option value="2">2x</option>
                        <option value="3">3x</option>
                        <option value="4">4x</option>
                        <option value="5">5x</option>
                        <option value="6">6x</option>
                        <option value="7">7x</option>
                        <option value="8">8x</option>
                        <option value="9">9x</option>
                        <option value="10">10x</option>
                        <option value="11">11x</option>
                        <option value="12">12x</option>
                    </select>
                </center>
            </div>
        </div>

        <!-- Débito -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Débito</h5>
                <h3 id="exibe" class="CLDebito">R$ 0,00</h3>
                <input class="RngDebito" type="range" id="rangeValue" name="vol" value="0" min="0" max="10000" step="10">
            </div>
        </div>

    </div>

    <!-- 2 -->
    <div class="card centralize shadow">
        <div class="card-body ">
            <h5 class="card-title">Prazo de recebimento</h5>

            <div class="button-group">
                <button value="1" class="btn btn-outline-dark">1 dia</button>
                <button value="30" class="btn btn-outline-dark buttonClicked">30 dias</button>
            </div>

        </div>
    </div>

    <!-- 3 -->
    <div class="card-group centralize shadow">

        <!-- Total de vendas -->
        <div class="card padding-10">
            <div class="card-body">
                <h5 class="card-title">Total de vendas</h5>
                <h1 class="card-text" id="valorBruto">R$ 0,00</h1>
            </div>
        </div>

        <!-- Total a receber -->
        <div class="card padding-10">
            <div class="card-body">
                <h5 class="card-title">Total a receber</h5>
                <h1 class="card-text" id="valorLiquido">R$ 0,00</h1>
            </div>
        </div>

    </div>

</div>

<?php include("tabela.php"); ?>
<?php include("rodape.php"); ?>

<!-- JavaScript -->
<script>
    var debito = document.querySelector(".RngDebito"); //recebe o valor do input range
    var campoDebito = document.querySelector(".CLDebito"); //recebe o valor da classe debito
    var VLDebito = document.querySelector("#valorLiquido") //recebe o valor do campo valor liquido
    var brutoDebito = document.querySelector("#valorBruto") //recebe o valor do campo valor bruto
    var vDebito = 0 //valor final liquido

    var creditoV = document.querySelector(".RngCreditoV");
    var CampoCreditoV = document.querySelector(".CLCreditoV");
    var VLCreditoV = document.querySelector("#valorLiquido")
    var brutoCreditoV = document.querySelector("#valorBruto")
    var vCreditoV = 0

    var creditoP = document.querySelector(".RngCreditoP");
    var campoCreditoP = document.querySelector(".CLCreditoP");
    var VLCreditoP = document.querySelector("#valorLiquido")
    var brutoCreditoP = document.querySelector("#valorBruto")
    var vCreditoP = 0

    var parcelas = document.getElementById("parcela")

    var antecipacao = false
    //Evento click botão
    $(document).ready(function() {
        $("button").click(function() {

            $("button").removeClass("buttonClicked");
            $(this).addClass("buttonClicked");

            if ($(this).val() == 1) {
                antecipacao = true
            } else {
                antecipacao = false
            }

            creditoParcelado()
            creditoAVista()
            debitoFFF()

        });
    });

    //Evento Débito
    debito.addEventListener("input", function() {
        debitoFFF()
    });

    //Evento Crédito Á Vista
    creditoV.addEventListener("input", function() {
        creditoAVista()

    });

    //Evento Nº Parcelas
    parcelas.addEventListener("input", function() {
        nParcelas()

    });

    //Evento Crédito Parcelado
    creditoP.addEventListener("input", function() {
        creditoParcelado()

    });

    function creditoParcelado() {
        var nParcela = parcelas.options[parcelas.selectedIndex].value
        campoCreditoP.textContent = "R$ " + creditoP.value + ",00";
        brutoCreditoP.textContent = "R$ " + (parseFloat(debito.value) + parseFloat(creditoP.value) + parseFloat(creditoV.value)) + ",00";
        if (antecipacao == false) {
            vCreditoP = credito(creditoP.value, nParcela)
        } else {
            vCreditoP = creditoAntecipado(creditoP.value, nParcela)
        }
        VLCreditoP.textContent = "R$ " + (parseFloat(vCreditoP) + parseFloat(vCreditoV) + parseFloat(vDebito)).toFixed(2).replace('.', ',')

        for (var i = 1; i <= nParcela; i++) {
            var tbParcelas = document.querySelector("#p" + i)
            tbParcelas.textContent = "R$ - ";
        }

        var valorParcela = vCreditoP / nParcela

        for (var i = 1; i <= nParcela; i++) {
            var tbParcelas = document.querySelector("#p" + i)
            tbParcelas.textContent = "R$ " + valorParcela.toFixed(2);
        }

    }

    function nParcelas() {
        var nParcela = parcelas.options[parcelas.selectedIndex].value
        campoCreditoP.textContent = "R$ " + creditoP.value + ",00";
        if (antecipacao == false) {
            vCreditoP = credito(creditoP.value, nParcela)
        } else {
            vCreditoP = creditoAntecipado(creditoP.value, nParcela)
        }
        VLCreditoP.textContent = "R$ " + (parseFloat(vCreditoP) + parseFloat(vCreditoV) + parseFloat(vDebito)).toFixed(2).replace('.', ',')

        for (var i = 1; i <= 12; i++) {
            var tbParcelas = document.querySelector("#p" + i)
            tbParcelas.textContent = "R$ - ";

        }

        var valorParcela = vCreditoP / nParcela

        for (var i = 1; i <= nParcela; i++) {
            var tbParcelas = document.querySelector("#p" + i)
            tbParcelas.textContent = "R$ " + valorParcela.toFixed(2);
        }
    }

    function creditoAVista() {
        CampoCreditoV.textContent = "R$ " + creditoV.value + ",00";
        brutoCreditoV.textContent = "R$ " + (parseFloat(debito.value) + parseFloat(creditoP.value) + parseFloat(creditoV.value)) + ",00"
        if (antecipacao == false) {
            vCreditoV = credito(creditoV.value, 1)
        } else {
            vCreditoV = creditoAntecipado(creditoV.value, 1)
        }
        VLCreditoV.textContent = "R$ " + (parseFloat(vCreditoV) + parseFloat(vCreditoP) + parseFloat(vDebito)).toFixed(2).replace('.', ',')

    }

    function debitoFFF() {
        campoDebito.textContent = "R$ " + debito.value + ",00";
        brutoDebito.textContent = "R$ " + (parseFloat(debito.value) + parseFloat(creditoP.value) + parseFloat(creditoV.value)) + ",00"
        vDebito = valorDebito(debito.value)
        VLDebito.textContent = "R$ " + (parseFloat(vDebito) + parseFloat(vCreditoP) + parseFloat(vCreditoV)).toFixed(2).replace('.', ',')
    }
</script>