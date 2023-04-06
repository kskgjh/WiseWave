import Alpine from 'alpinejs';
import {
    productList, currentCarroussel, adminSelector, carrousselForm, adminSideBar, categorySelector
} from './admin'

import header from './global';

//GLOBAL COMPONENTS
window.header = header

//ADMIN COMPONENTS
window.currentCarroussel = currentCarroussel
window.carrousselForm = carrousselForm
window.adminSelector = adminSelector
window.adminSideBar = adminSideBar
window.productList = productList
window.categorySelector = categorySelector
window.Alpine = Alpine;
Alpine.start();