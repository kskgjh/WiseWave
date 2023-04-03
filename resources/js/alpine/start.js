import Alpine from 'alpinejs';
import productList from './admin'
import header from './global';

window.header = header
window.productList = productList()
window.Alpine = Alpine;
Alpine.start();