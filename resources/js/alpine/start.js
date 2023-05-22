import Alpine from 'alpinejs';
import mask from '@alpinejs/mask'

import {
    productList, currentCarroussel, adminSelector, carrousselForm, categorySelector, productForm, productPage, variantForm, categoryForm, featureForm, productFeature
} from './admin'

import {
    header, registerForm, carrossel, mostSalesProducts, productRequest, cart, sideBar, searchFilters, productSearch
} from './global';

//GLOBAL COMPONENTS
window.mostSalesProducts = mostSalesProducts
window.productRequest = productRequest
window.searchFilters = searchFilters
window.productSearch = productSearch
window.registerForm = registerForm
window.carrossel = carrossel
window.sideBar = sideBar
window.header = header
window.cart = cart

//ADMIN COMPONENTS
window.currentCarroussel = currentCarroussel
window.categorySelector = categorySelector
window.carrousselForm = carrousselForm
window.productFeature = productFeature
window.adminSelector = adminSelector
window.categoryForm = categoryForm
window.productList = productList
window.productForm = productForm
window.productPage = productPage
window.featureForm = featureForm
window.variantForm = variantForm

Alpine.plugin(mask)
window.Alpine = Alpine;
Alpine.start();