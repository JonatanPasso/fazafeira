<template>
    <div class="d-flex justify-content-center">
        <div class="card col-md-11">
            <div class="card-body">
                <h3 class="card-title">MINHA LISTA DE DESEJOS</h3>
                <hr>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">LISTA DE PRODUTOS DO USUÁRIO</div>

                            <div class="card-body table-responsive">
                                <table class="table table-hover" id="listProdHome">
                                    <thead>
                                    <tr>
                                        <th scope="col" style="width: 10%">#</th>
                                        <th scope="col" style="width: 35%">Descrição</th>
                                        <th scope="col" style="width: 10%">Valor</th>
                                        <th scope="col" style="width: 30%">Produtor</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="ps in arrayProdutos">
                                        <td>{{ps.id}}</td>
                                        <td>{{ps.descricao}}</td>
                                        <td>{{ps.valor}}</td>
                                        <td><span class="badge badge-danger" style="padding: 7px">{{ps.criado_por.name}}</span></td>
                                        <td>
                                            <button type="button"
                                                    class="btn btn-primary btn-sm"
                                                    v-bind:disabled="ps.lista_desejos !== null"
                                                    @click="incluirListaDesejo(ps.id, ps.criado_por.id)">Incluir</button>

                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">LISTA DE DESEJOS DO USUÁRIO</div>

                            <div class="card-body table-responsive">
                                <table class="table table-hover" id="listDesejo">
                                    <thead>
                                    <tr>
                                        <th scope="col" style="width: 10%">#</th>
                                        <th scope="col" style="width: 35%">Descrição</th>
                                        <th scope="col" style="width: 10%">Valor</th>
                                        <th scope="col" style="width: 30%">Produtor</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="ps in arrayLista">
                                        <td>{{ps.lista_desejos.id}}</td>
                                        <td>{{ps.lista_desejos.descricao}}</td>
                                        <td>{{ps.lista_desejos.valor}}</td>
                                        <td><span class="badge badge-danger" style="padding: 7px">{{ps.criado_por.name}}</span></td>
                                        <td>
                                            <button type="button"
                                                    class="btn btn-danger btn-sm"
                                                    @click="excluirListaDesejo(ps.id)">Excluir</button>

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
        self.listarDesejos();

        $('#painel').removeClass('link-ac');

        setTimeout(function (){
            $('#painel').addClass('link-ac');
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
        },

        listarDesejos: function (){
            var self = this;

            axios.get('/listar-desejos').then(function (response) {
                self.arrayLista = response.data;

                setTimeout(function () {
                    $('#listDesejo').DataTable({
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json"
                        },
                        retrieve: true,
                    });
                }, 300);
            });
        },

        incluirListaDesejo: function ($id, $usuario){

            var self = this;

            var data = {
                produto_id: $id,
                criado_por: $usuario
            }

            axios.post('/incluir-lista-desejo', data).then(function (response) {

                self.$notify({
                    group: 'foo',
                    title: 'Gravado com sucesso!',
                    text: 'Produto gravado com sucesso!',
                    ignoreDuplicates: true,
                    type:'success'
                });

                self.listarProdutos();
                self.listarDesejos();
            });

        },

        excluirListaDesejo: function ($id){
            var self = this;

            var param = {
                id: $id
            };

            axios.post('/excluir-desejo', param).then(function (){

                self.$notify({
                    group: 'foo',
                    title: 'Excluido com sucesso!',
                    text: 'Produto excluido com sucesso!',
                    ignoreDuplicates: true,
                    type:'success'
                });

                self.listarDesejos();

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
            arrayProdutos: [],
            arrayLista: []
        }
    }

}
</script>

<style scoped>

</style>
