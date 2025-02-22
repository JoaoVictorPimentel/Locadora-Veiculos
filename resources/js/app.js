/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import { createApp } from 'vue';
import { createStore } from 'vuex';
import './bootstrap';

const store = createStore({
    state() {
        return {
            item: {},
            transacao: { status: '', mensagem: '', dados: '' }
        };
    }
});

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import AlertComponent from './components/Alert.vue';
import CardComponent from './components/Card.vue';
import ExampleComponent from './components/ExampleComponent.vue';
import HomeComponent from './components/home/Home.vue';
import InputComponent from './components/InputContainer.vue';
import LoginComponent from './components/login/Login.vue';
import MarcasComponent from './components/marcas/Marcas.vue';
import ModalComponent from './components/Modal.vue';
import PaginateComponent from './components/Paginate.vue';
import TableComponent from './components/Table.vue';
app.component('example-component', ExampleComponent);
app.component('paginate-component', PaginateComponent);
app.component('marcas-component', MarcasComponent);
app.component('modal-component', ModalComponent);
app.component('login-component', LoginComponent);
app.component('alert-component', AlertComponent);
app.component('home-component', HomeComponent);
app.component('table-component', TableComponent);
app.component('card-component', CardComponent);
app.component('input-container-component', InputComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.use(store)
app.mount('#app');
