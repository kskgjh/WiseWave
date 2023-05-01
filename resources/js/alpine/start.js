import Alpine from 'alpinejs';
import mask from '@alpinejs/mask'

import {
    productList, currentCarroussel, adminSelector, carrousselForm, adminSideBar, categorySelector, productForm, productPage, variantForm, categoryForm
} from './admin'

import {
    header, registerForm, carrossel, mostSalesProducts
} from './global';

//GLOBAL COMPONENTS
window.mostSalesProducts = mostSalesProducts
window.registerForm = registerForm
window.carrossel = carrossel
window.header = header

//ADMIN COMPONENTS
window.currentCarroussel = currentCarroussel
window.categorySelector = categorySelector
window.carrousselForm = carrousselForm
window.adminSelector = adminSelector
window.adminSideBar = adminSideBar
window.categoryForm = categoryForm
window.productList = productList
window.productForm = productForm
window.productPage = productPage
window.variantForm = variantForm

Alpine.plugin(mask)
window.Alpine = Alpine;
Alpine.start();