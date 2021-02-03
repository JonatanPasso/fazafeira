<template>
    <div class="d-flex justify-content-center">
        <div class="card col-md-11">
            <div class="card-body">
                <h3 class="card-title">PRODUTOS CADASTRADOS</h3>
                <hr>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">LISTA DE PRODUTOS</div>

                            <div class="card-body table-responsive">
                                <table class="table table-hover" id="listProdHome">
                                    <thead>
                                    <tr>
                                        <th scope="col" style="width: 10%">#</th>
                                        <th scope="col" style="width: 35%">Descrição</th>
                                        <th scope="col" style="width: 35%">Valor</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="ps in arrayProdutos">
                                        <td>{{ps.id}}</td>
                                        <td>{{ps.descricao}}</td>
                                        <td>{{ps.valor}}</td>
                                        <td>
                                            <button type="button"
                                                    class="btn btn-primary btn-sm"
                                                    data-toggle="modal"
                                                    data-target=".bd-example-modal-lg"
                                                    @click="listarProdutoPorId(ps.id)">Detalhar</button>

                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="card">
                        <div class="card-header">DETALHE DO PRODUTO</div>
                        <div class="card-body">
                            <h5 class="card-title">{{descricao}}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ categoria }}</h6>
                            <p class="card-text">{{created_at | moment("ddd, MMMM Do YYYY") }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "home",

    mounted() {

        var self = this;

        self.listarProdutos();

        $('#home').removeClass('link-ac');

        setTimeout(function (){
            $('#home').addClass('link-ac');
        },300);

    },

    methods: {

        listarProdutos: function () {

            var self = this;

            axios.get('/listar-produtos-usuario').then(function (response) {

                self.arrayProdutos = response.data;

                setTimeout(function () {
                    $('#listProdHome').DataTable({
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json"
                        },
                        retrieve: true,
                    });
                }, 300);
            });
        },

        listarProdutoPorId: function ($id){

            var self = this;

            axios.get('/lista-produto-por-id', {params: {id: $id}}).then(function (response) {

                self.id = response.data.id;
                self.descricao = response.data.descricao;
                self.categoria = response.data.categoria;
                self.peso = response.data.peso;
                self.valor = response.data.valor;
                self.criado_por = response.data.criado_por.name;
                self.created_at = response.data.created_at;
            });
        }

    },

    data: function (){
        return {
            descricao: '',
            categoria: '',
            peso: '',
            valor: '',
            criado_por: '',
            created_at: '',
            arrayProdutos: []
        }
    }

}
</script>

<style scoped>

</style>
