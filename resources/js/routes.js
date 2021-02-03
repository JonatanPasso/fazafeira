import ExampleComponent from "./components/ExampleComponent";
import CadastroProdutos from "./components/CadastroProdutos";
import home from "./components/home";
import ListaDesejos from "./components/ListaDesejos";
import PainelUsuario from "./components/PainelUsuario";

export default [
    {
        path: '/',
        component: home,
        meta: {
            title: 'Home'
        },
    },
    {
        path: '/home',
        component: ExampleComponent,
        meta: {
            title: 'Home Faz a Feira'
        }
    },
    {
        path: '/produto',
        component: CadastroProdutos,
        meta: {
            title: 'Cadastro de Produto'
        }
    },
    {
        path: '/desejos',
        component: ListaDesejos,
        meta: {
            title: 'Lista de Desejos'
        }
    },
    {
        path: '/painel',
        component: PainelUsuario,
        meta: {
            title: 'Painel Usuário'
        }
    },
]

