import './bootstrap';
import store from './store'
import VueAxios from 'vue-axios';
import axios from 'axios';

import {createApp} from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import Home from './pages/Home.vue'
import Shop from './pages/Shop.vue'
import CodeDetails from './pages/CodeDetails.vue'
import ModerateCodes from './pages/Dashboard/ModerateCodes.vue'
import Codes from './pages/Dashboard/Codes.vue'
import Shops from './pages/Dashboard/Shops.vue'
import Employees from './pages/Dashboard/Employees.vue'

import HeaderShops from './modals/HeaderShops.vue'
import Login from './modals/Login.vue'
import Register from './modals/Register.vue'

import Modal from './elements/Modal.vue'
import Loader from './elements/Loader.vue'
import ShopCard from './elements/ShopCard.vue'
import Notifications from './elements/Notifications.vue'
import Alert from './elements/Alert.vue'
import PromocodesList from './elements/PromocodesList.vue'

import CodesTab from './tabs/CodesTab.vue'
import ModerateTab from './tabs/ModerateTab.vue'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css';
import * as ElementPlusIconsVue from '@element-plus/icons-vue'


const app = createApp({});

for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
    app.component(key, component)
  }

app.use(ElementPlus)

app.use(store)
app.use(VueAxios, axios)
app.component('font-awesome-icon', FontAwesomeIcon)

app.component('home-page', Home);
app.component('shop-page', Shop);
app.component('code-details', CodeDetails);
app.component('dashboard-moderate-codes', ModerateCodes);
app.component('dashboard-codes', Codes);
app.component('dashboard-shops', Shops);
app.component('dashboard-employees', Employees);

app.component('header-shops', HeaderShops);
app.component('login-modal', Login);
app.component('register-modal', Register);

app.component('show-modal', Modal);
app.component('loader', Loader);
app.component('shop-card', ShopCard);
app.component('notifications', Notifications);
app.component('alert', Alert);
app.component('promocodes-list', PromocodesList);

app.component('codes-tab', CodesTab);
app.component('moderate-tab', ModerateTab);


app.mount("#app");
