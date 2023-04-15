import Alpine from 'alpinejs';
import mask from '@alpinejs/mask'

import {
    productList, currentCarroussel, adminSelector, carrousselForm, adminSideBar, categorySelector, productForm
} from './admin'

import {
    header, registerForm
} from './global';

//GLOBAL COMPONENTS
window.header = header
window.registerForm = registerForm

//ADMIN COMPONENTS
window.currentCarroussel = currentCarroussel
window.categorySelector = categorySelector
window.carrousselForm = carrousselForm
window.adminSelector = adminSelector
window.adminSideBar = adminSideBar
window.productList = productList
window.productForm = productForm

Alpine.plugin(mask)
window.Alpine = Alpine;
Alpine.start();