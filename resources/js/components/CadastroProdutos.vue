<template>
    <div class="container" id="app">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">CADASTRO DE PRODUTOS</div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputDescricao">Descrição *</label>
                                <input type="text" name="descricao" class="form-control" id="inputDescricao" placeholder="Descrição" v-model="descricao" required>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="inputCategoria">Categoria</label>
                                <select id="inputCategoria" class="form-control" v-model="categoria">
                                    <option selected>Selecione...</option>
                                    <option value="Asteraceas (Chicoracea)">Asteraceas (Chicoracea)</option>
                                    <option value="Crucíferas">Crucíferas</option>
                                    <option value="Cucurbitáceas">Cucurbitáceas</option>
                                    <option value="Leguminosas">Leguminosas</option>
                                    <option value="Liliáceas">Liliáceas</option>
                                    <option value="Quenopodiáceas">Quenopodiáceas</option>
                                    <option value="Solanáceas">Solanáceas</option>
                                    <option value="Umbelíferas">Umbelíferas</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputEmail4">Peso</label>
                                <input type="email" class="form-control" id="inputEmail4" placeholder="Peso" v-model="peso">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Valor de venda</label>
                                <money class="form-control" placeholder="Valor" v-model="valor"></money>
                            </div>
                        </div>
                        <button class="btn btn-primary" v-if="id ==''" @click="incluirProduto">Cadastrar</button>
                        <button class="btn btn-secondary" v-if="id !==''" @click="alterarDadosProduto">Alterar</button>
                        <button class="btn btn-danger" @click="limpaCampos">Limpar</button>
                        <button class="btn btn-warning" v-if="arrayProdutos.length <= 0 || arrayProdutos == ''" @click="listarProdutos">Listar</button>
                    </div>
                </div>
            </div>
        </div>
        <notifications group="foo" />
        <hr>
        <div class="row justify-content-center invisible" id="listaCadastroProdutos">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">LISTA DE PRODUTOS</div>

                    <div class="card-body table-responsive">
                        <table class="table table-hover" id="listProd">
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
                                    <button type="button" class="btn btn-primary btn-sm" @click="alterarProduto(ps.id)">Alterar</button>
                                    <button type="button" class="btn btn-secondary btn-sm" @click="excluirProduto(ps.id)">Excluir</button>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {

    name: "CadastroProdutos",

    mounted() {

        var self = this;

        setTimeout(function (){
            self.$scrollTo('#app', 500);
        },100);

        $('#produtos').removeClass('link-ac');

        setTimeout(function (){
            $('#produtos').addClass('link-ac');
        },300);

    },

    methods: {
        listarProdutos: function (){

            var self = this;

            axios.get('/listar-produtos-usuario').then(function(response){

                self.arrayProdutos = response.data;

                setTimeout(function (){
                    $('#listProd').DataTable({
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json"
                        },
                        retrieve: true,
                    });

                    $('#listaCadastroProdutos').removeClass('invisible');

                },300);

                setTimeout(function (){
                    self.$scrollTo('#lista', 500);
                },1000);
            });
        },

        incluirProduto: function (){

            var self = this;

            var data = {
                descricao: self.descricao,
                categoria: self.categoria,
                peso: self.peso,
                valor: self.valor ,
            }

            axios.post('/incluir-produto', data)
                .then(function (response) {

                    if(response.data.error != undefined)
                    {
                        self.$notify({
                            group: 'foo',
                            title: 'Oops!',
                            text: 'Algo deu errado aqui!',
                            ignoreDuplicates: true,
                            type:'danger'
                        });
                    }else{
                        self.$notify({
                            group: 'foo',
                            title: 'Gravado com sucesso!',
                            text: 'Produto gravado com sucesso!',
                            ignoreDuplicates: true,
                            type:'success'
                        });

                        setTimeout(function (){
                            self.limpaCampos();
                            self.listarProdutos();

                            self.$scrollTo('#lista', 500);

                        },300);

                    }
                }).catch(function (error) {
                    self.$notify({
                        group: 'foo',
                        title: 'Oops!',
                        text: 'Campos obrigatórios para preencher',
                        ignoreDuplicates: true,
                        type:'error'
                    });
            })

        },

        alterarDadosProduto: function (){

            var self = this;

            var data = {
                id: self.id,
                descricao: self.descricao,
                categoria: self.categoria,
                peso: self.peso,
                valor: self.valor
            }

            axios.post('/alterar-dados-produto', data).then(function (response) {

                self.$notify({
                    group: 'foo',
                    title: 'Alterado com sucesso!',
                    text: 'Produto alterado com sucesso!',
                    ignoreDuplicates: true,
                    type:'success'
                });

                setTimeout(function (){
                    self.limpaCampos();
                    self.listarProdutos();

                    self.$scrollTo('#lista', 500);

                },300);
            });
        },

        limpaCampos: function (){

            var self = this;

            $('#listaCadastroProdutos').addClass('invisible');

            self.id = '';
            self.descricao = '';
            self.categoria = '';
            self.peso = '';
            self.valor = '';
            self.arrayProdutos = [];
        },

        alterarProduto: function ($id){

            var self = this;

            axios.get('/lista-produto-por-id', {params: {id: $id}}).then(function (response) {

                self.id = response.data.id;
                self.descricao = response.data.descricao,
                self.categoria = response.data.categoria,
                self.peso = response.data.peso,
                self.valor = response.data.valor,

                self.$scrollTo('#app', 500);

            });
        },

        excluirProduto: function ($id){
            var self = this;

            var param = {
                id: $id
            };

            axios.post('/excluir-produto', param).then(function (){

                self.$notify({
                    group: 'foo',
                    title: 'Excluido com sucesso!',
                    text: 'Produto excluido com sucesso!',
                    ignoreDuplicates: true,
                    type:'success'
                });

                self.listarProdutos();

                self.$scrollTo('#lista', 500);
            });
        }
    },

    data: function (){
        return {
            id: '',
            descricao: '',
            categoria: '',
            peso: '',
            valor: '',

            arrayProdutos: []
        }
    }
}
</script>
