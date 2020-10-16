import Vue from 'vue'
import Vuex from 'vuex'
import './assets/css/tailwind.css'
import App from './App.vue'
import theme from './theme'
import { router } from "./router"
import VueTailwind from 'vue-tailwind'
import VueAppend from './mixin/vue-append'
import Common from './mixin/common'
import VueMasonry from 'vue-masonry-css'
Vue.use(VueMasonry);
Vue.use(VueAppend)
Vue.use(Vuex);
Vue.use(Common, router);
Vue.use(VueTailwind, theme);
Vue.filter("mb_nick", val => {
  var value = val;
  value = value.replace(/<a href=/g, '<div data-href=');
  value = value.replace(/<\/a>/g, '</div>');
  value = value.replace(/onclick/g, 'data-type').trim(0);
  value = value.replace(/\(this.href\);/g, '').trim();
  value = value.replace(/return false;/g, '').trim();
  return String(value);
});
Vue.filter("number_format", val =>{
  return String(val).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
});
Vue.filter("point_format", val =>{
  if(parseInt(val) > 0)
    return "+ " + String(val).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  else
    return String(val).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
});
Vue.filter('round', (value, decimals) => {
  if (!value) value = 0;
  if (!decimals) decimals = 0;
  value = Math.round(value * Math.pow(10, decimals)) / Math.pow(10, decimals);
  return value;
});
const store = new Vuex.Store({
  state: {
    isLogin : false,
    member : {},
    connect : {
      mb_cnt : 0,
      total_cnt : 0,
    },
    visit : {
      today : 0,
      yesterday : 0,
      max : 0,
      all : 0,
    },
    loading : false,
    pip : false,
    youtube : null,
    config : null,
  },
  mutations: {
    async Login (state) {
      let formData = new FormData();
      const id = document.getElementById('login_id').value;
      const pw = document.getElementById('login_pw').value;
      formData.append("login", true);
      formData.append("mb_id", id);
      formData.append("mb_password", pw);
      fetch(window.url, {
        method: "post",
        body: formData,
      })
      .then(function(response) {
        return response.json();
      })
      .then(function(json) {
        if(json.msg) {
          alert(json.msg);
          return false;
        }
        state.isLogin = true;
        state.member = json;
      });
    },
    async Logout (state) {
      let formData = new FormData();
      formData.append('logout', true);
      fetch(window.url, {
        method: "post",
        body: formData,
      })
      .then(function(response) {
        return response.json();
      })
      .then(function() {
        state.isLogin = false;
        state.member = {};
      });
    },
    async PIP(state, yt) {
      state.pip = true;
      document.getElementById('pip').appendChild(yt);
    },
    async PIPClose(state) {
      document.getElementById('pip').removeChild(document.querySelector('#pip iframe'));
      document.getElementById('pip_wrapper').classList.add('hidden');
      state.pip = false;
    },
    async PIPHide() {
      if(document.getElementById('pip').classList.contains('hidden'))
        document.getElementById('pip').classList.remove('hidden');
      else
        document.getElementById('pip').classList.add('hidden');
      //document.getElementById('pip_wrapper').classList.add('hidden');
    },
    PIPDrag : function(e){
      console.log(e);
    },
    async GetYoutube(state) {
      var iframe = document.querySelectorAll('iframe');
      if(!iframe) {
        alert('PIP모드로 전환할 유튜브 동영상이 없습니다.');
      }else if(iframe.length > 1){
        document.getElementById('pip_modal').click();
        state.youtube = iframe;
        //document.getElementById('PIPModal_body').innerHTML = '';

      }else{
        state.pip = false;
        await this.commit('PIP', iframe[0].cloneNode(true));
        document.getElementById('pip_wrapper').classList.remove('hidden');
      }
    },
    async PIPChoice(state, i){
      state.pip = false;
      await this.commit('PIP', state.youtube[i].cloneNode(true));
      state.youtube = null,
      document.getElementById('pip_wrapper').classList.remove('hidden');
      document.getElementById('pip_modal_hide').click();
    },
    async PIPButton(state, html){
      if(html.indexOf('youtube') != -1){
        document.getElementById('pip_button').classList.remove('hidden');
      }
    }
  }
});
Vue.config.productionTip = false;

new Vue({
  store: store,
  router,
  render: h => h(App),
}).$mount('#app')
