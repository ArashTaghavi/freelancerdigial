import axios from 'axios'

const instance = axios.create({
    baseURL: '/api/team/'
});

let token = document.head.querySelector('meta[name="csrf-token"]');
window.token = token.content;

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

window.axios = instance;

export default instance
